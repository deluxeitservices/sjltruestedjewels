<?php
// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function downloadPdf(Order $order)
    {
        // (Optional) authorize that the logged-in user owns this order
        // $this->authorize('view', $order);


        $pdf = Pdf::loadView('pages.orders.pdf', ['order' => $order->load('items', 'user')])->setPaper('a4');


        $filename = 'order-' . $order->order_no . '.pdf';
        return $pdf->download($filename);   // or ->stream($filename) to preview in browser
    }

    public function showCompulsory(Order $order)
    {
        // Optional: ensure the order is paid before showing
        // abort_unless($order->status === 'paid', 403);

        return view('pages.orders.declaration', compact('order'));
    }

    public function submitCompulsory(Request $request, Order $order)
    {
        // Server-side validation (mirror your client rules)
        // $data = $request->validate([
        //     'fund_agreed'            => ['required', 'string', 'max:255'],
        //     'firstName'              => ['required', 'string', 'max:255'],
        //     'lastName'               => ['required', 'string', 'max:255'],
        //     'email'                  => ['required', 'email', 'max:255'],
        //     'compulsory_buying_form_image.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB
        //     'signature'              => ['required', 'string'], // data URL
        // ]);

        // 2) Save uploads -> array of public paths
        $filePaths = [];
        if ($request->hasFile('compulsory_buying_form_image')) {
            foreach ($request->file('compulsory_buying_form_image') as $file) {
                $filePaths[] = $file->store("declarations/{$order->id}", 'public');
            }
        }

        // 3) Save signature (data URL -> file)
        $signaturePath = null;
        // if (preg_match('/^data:image\/(\w+);base64,/', $data['signature'], $m)) {
        //     $ext = strtolower($m[1] ?? 'png');
        //     $raw = base64_decode(substr($data['signature'], strpos($data['signature'], ',') + 1));
        //     $signaturePath = "declarations/{$order->id}/signature." . $ext;
        //     Storage::disk('public')->put($signaturePath, $raw);
        // } else {
        //     return back()->withErrors(['signature' => 'Invalid signature data'])->withInput();
        // }

        // (Optional) persist a JSON blob on the order for audit
        DB::table('sjl_compulsory_buying_form_master')->insert([
            'order_id'             => $order->id,

            'date'            => $request->input('date'),          // Y-m-d from the form
            'fund_agreed'          => $request->input('fund_agreed'),

            'firstName'           => $request->input('firstName'),
            'lastName'            => $request->input('lastName'),
            'email'                => $request->input('email'),

            // 'bank_account_name'    => $request->input('bank_account_name'),
            // 'bank_account_number'  => $request->input('bank_account_number'),
            // 'bank_name'            => $request->input('bank_name'),

            'files_json'           => json_encode($filePaths),
            'signature'       => $signaturePath,

            // 'ip'                   => $request->ip(),
            // 'user_agent'           => (string)$request->userAgent(),

            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // You could also create a separate table if you prefer structured storage

        return view('pages.orders.compulsory_success', [
            'order'  => $order,
        ]);
    }
}

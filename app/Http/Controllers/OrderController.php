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
        $uid = auth()->id();
        $previousForms = $uid
            ? DB::table('sjl_compulsory_buying_form_master')
            ->where('order_id', '!=', $order->id)
            ->where('user_id', $uid)
            ->orderByDesc('created_at')
            ->get()
            : collect(); // no user -> empty collection
        return view('pages.orders.declaration', compact('order', 'previousForms'));
    }

    public function submitCompulsory(Request $request, Order $order)
    {


        $isOrderExist  = Order::where('id', $order->id)->first();

        $useExisting = (bool) $request->boolean('use_existing');
        if ($isOrderExist->sjl_compulsory_id == 0) {
            if ($useExisting) {
                $existingId = $request->input('existing_form_id');
                abort_if(!$existingId, 422, 'Select a previous submission.');
                $order->update(['sjl_compulsory_id' => $existingId]);

                return view('pages.orders.compulsory_success', [
                    'order'  => $order,
                ]);
            } else {

                $isExist  = DB::table('sjl_compulsory_buying_form_master')->where('order_id', $order->id)->count();
                if ($isExist <= 0) {
                    // Server-side validation (mirror your client rules)
                    $data = $request->validate([
                        // 'fund_agreed'            => ['required', 'string', 'max:255'],
                        'firstName'              => ['required', 'string', 'max:255'],
                        // 'lastName'               => ['required', 'string', 'max:255'],
                        'email'                  => ['required', 'email', 'max:255'],
                        'compulsory_buying_form_image.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB
                        'signature'              => ['required', 'string'], // data URL
                    ]);

                    // 3) Save signature (data URL -> file)
                    $signaturePath = null;
                    if (preg_match('/^data:image\/(\w+);base64,/', $data['signature'], $m)) {
                        $ext = strtolower($m[1] ?? 'png');
                        $raw = base64_decode(substr($data['signature'], strpos($data['signature'], ',') + 1));
                        $signaturePath = "declarations/{$order->id}/signature." . $ext;
                        Storage::disk('public')->put($signaturePath, $raw);
                    } else {
                        return back()->withErrors(['signature' => 'Invalid signature data'])->withInput();
                    }

                    // (Optional) persist a JSON blob on the order for audit
                    $compulsoryId  = DB::table('sjl_compulsory_buying_form_master')->insertGetId([
                        'order_id'             => $order->id,
                        'user_id'             => auth()->id(),

                        'date'            => $request->input('date'),          // Y-m-d from the form
                        // 'fund_agreed'          => $request->input('fund_agreed'),

                        'name'           => $request->input('firstName'),
                        // 'lastName'            => $request->input('lastName'),
                        'email'                => $request->input('email'),

                        // 'bank_account_name'    => $request->input('bank_account_name'),
                        // 'bank_account_number'  => $request->input('bank_account_number'),
                        // 'bank_name'            => $request->input('bank_name'),

                        'files_json'           => '',
                        'signature'       => $signaturePath,

                        // 'ip'                   => $request->ip(),
                        // 'user_agent'           => (string)$request->userAgent(),

                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ]);


                    // 2) Save uploads -> array of public paths
                    $filePaths = [];
                    if ($request->hasFile('compulsory_buying_form_image')) {
                        foreach ($request->file('compulsory_buying_form_image') as $file) {
                            $filePaths[] = $file->store("declarations/{$order->id}", 'public');
                            $storedPath = $file->store("declarations/{$order->id}", 'public');

                            DB::table('sjl_compulsory_buying_form_image')->insert([
                                'sjl_compulsory_buying_form_master_id' => $compulsoryId,
                                'file_name'      => $storedPath,
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ]);
                        }
                    }
                    $order->update(['sjl_compulsory_id' => $compulsoryId]);


                    // You could also create a separate table if you prefer structured storage

                    return view('pages.orders.compulsory_success', [
                        'order'  => $order,
                    ]);
                } else {
                    return view('pages.orders.is_exists_compulsory', [
                        'order'  => $order,
                    ]);
                }
            }
        } else {
            return view('pages.orders.is_exists_compulsory', [
                'order'  => $order,
            ]);
        }
    }
}

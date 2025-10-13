<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{

    /**
     * Display the user's profile Dashboard.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    /**
     * Show the application Account
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function account()
    {
        $userId = Auth::id();
        //get user address
        $userData = User::where('id', $userId)->first();
        return view('profile.account', compact('userData'));
    }


    /**
     * Show the application order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function order()
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        $orders = Order::where('customer_email', $userData->email)
            ->get();
        return view('profile.order', compact('orders', 'userData'));
    }


    /**
     * Show the application order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        return view('dashboard', compact('userData'));
    }




    /**
     * Show the application wishlist
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function wishlist()
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        $favorites = \App\Models\Favorite::where('user_id', $userId)->get();

        return view('profile.wishlist', compact('favorites', 'userData'));
    }




    /**
     * Show the application Order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function accountUpdate(Request $request)
    {
        $userId = Auth::id();

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'mobile' => 'required|string',
        ]);

        User::where('id', $userId) // Add your condition here, e.g., updating by user ID
            ->update([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
            ]);

        // Store files if uploaded
        if ($request->hasFile('profile_picture')) {
            $directoryPath = 'uploads/userprofile/' . $userId;

            // Create the directory if it doesn't exist
            if (!Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->makeDirectory($directoryPath);
            }

            // Store the single file
            $path = $request->file('profile_picture')->store($directoryPath, 'public');
            $fileName = basename($path);

            // Update user profile picture
            User::where('id', $userId)->update([
                'profile_picture' => $fileName
            ]);
        }
        if (!isset($fileName)) {
            $getData = User::where('id', $userId)->first();
            $fileName = $getData->profile_picture;
        }
        $imageUrl = asset('storage/uploads/userprofile/' . $userId . '/' . $fileName);


        // Return success response with the image path
        return response()->json([
            'success' => true,
            'message' => 'User data updated successfully',
            'image_path' => $imageUrl // Generate the full URL for the image
        ]);
    }

    /**
     * Show the application Order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addressUpdate(Request $request)
    {
        $userId = Auth::id();
        $addressId = $request->input('address_id');
        $is_default = $request->input('is_default');
        // Validate the request data
        $validatedData = $request->validate([
            'address' => 'nullable|string',
            'city' => 'required|string',
            'house_no' => 'required|string',
            'street_name' => 'required|string',
            'postal_code' => 'required|string',
            'country' => 'required|string',
        ]);


        if ($is_default) {
            UserAddress::where('user_id', $userId)
                ->where('id', '!=', $addressId)
                ->update(['default_address' => 0]);
        }

        UserAddress::where('id', $addressId) // Add your condition here, e.g., updating by user ID
            ->update([
                'city' => $request->input('city'),
                'house_no' => $request->input('house_no'),
                'street_name' => $request->input('street_name'),
                'postal_code' => $request->input('postal_code'),
                'country' => $request->input('country'),
                'default_address'  => $is_default ? 1 : 0,
                'address' => $request->input('address')
            ]);


        // Return success response with the image path
        return response()->json([
            'success' => true,
            'message' => 'User data updated successfully',
        ]);
    }


    /**
     * Show the application Order Details
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function orderDetail($id)
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        $orderId = $id;
        $order = Order::with('items', 'user', 'user_address')->where('id', $orderId)->first();
        return view('profile.order-details', compact('order', 'userData'));
    }



    /**
     * Show the application Contact Us page 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('profile.contact');
    }


    /**
     * Show the application About Us page 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function about()
    {
        return view('pages.about');
    }


    /**
     * Show the application order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function address()
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        $addresses = UserAddress::where('user_id', $userId)
            ->get();
        return view('profile.address', compact('userData', 'addresses'));
    }


    /**
     * Show the application order
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addressDetail($id)
    {
        $userId = Auth::id();
        //get user data
        $userData = User::where('id', $userId)->first();
        $addresses = UserAddress::where('user_id', $userId)->where('id', $id)
            ->first();
        return view('profile.address_details', compact('userData', 'addresses'));
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // keeps it simple & safe
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = $request->user();
        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        // Optional: log out other devices
        // $request->user()->setRememberToken(Str::random(60));

        // Return JSON for your AJAX
        return response()->json(['ok' => true]);
    }
}

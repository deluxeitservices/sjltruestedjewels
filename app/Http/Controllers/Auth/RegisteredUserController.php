<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeBackup(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            // 'name'        => ['required', 'string', 'max:255'],
            // 'email'       => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            // 'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            // 'dob'         => ['required', 'date'], // Date of Birth
            // 'mobile'      => ['required', 'string', 'max:15'],
            // 'address'     => ['required', 'string', 'max:255'],
            // 'house_no'    => ['required', 'string', 'max:50'],
            // 'street_name' => ['required', 'string', 'max:255'],
            // 'city'        => ['required', 'string', 'max:100'],
            // 'postal_code' => ['required', 'string', 'max:20'],
            // 'country'     => ['required', 'string', 'max:100'],
        ]);

        // dd($request);
        // dd('dsaf');
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'dob'         => $request->dob,
            'mobile'      => $request->mobile,
            // 'address'     => $request->address,
            'house_no'    => $request->house_no,
            'street_name' => $request->street_name,
            'city'        => $request->city,
            'postal_code' => $request->postal_code,
            'country'     => $request->country,
        ]);

        event(new Registered($user));

        Auth::login($user);


        Mail::to($user->email)->send(new UserRegisteredMail($user, false)); // to user
        Mail::to(config('mail.admin_address'))->send(new UserRegisteredMail($user, true)); // to admin
        return redirect(RouteServiceProvider::HOME);
    }

}

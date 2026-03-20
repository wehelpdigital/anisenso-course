<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClientAccessLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('client')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Please enter your email or phone number.',
            'password.required' => 'Please enter your password.',
        ]);

        // Find user by email or phone
        $user = ClientAccessLogin::findForLogin($request->login);

        if (! $user) {
            throw ValidationException::withMessages([
                'login' => ['We couldn\'t find an account with that email or phone number.'],
            ]);
        }

        // Check if password is set
        if (empty($user->clientPassword)) {
            throw ValidationException::withMessages([
                'login' => ['This account doesn\'t have a password set. Please contact support.'],
            ]);
        }

        // Verify password
        // Handle both bcrypt hashed passwords and legacy plain text passwords
        $storedPassword = $user->clientPassword;
        $inputPassword = $request->password;
        $passwordValid = false;

        // Check if password is bcrypt hashed (starts with $2y$, $2a$, or $2b$)
        if (preg_match('/^\$2[yab]\$/', $storedPassword)) {
            // Bcrypt hashed password - use Hash::check
            $passwordValid = Hash::check($inputPassword, $storedPassword);
        } else {
            // Legacy plain text password - direct comparison
            $passwordValid = ($inputPassword === $storedPassword);

            // If valid, upgrade to bcrypt hash for security
            if ($passwordValid) {
                $user->clientPassword = Hash::make($inputPassword);
                $user->save();
            }
        }

        if (! $passwordValid) {
            throw ValidationException::withMessages([
                'password' => ['The password you entered is incorrect.'],
            ]);
        }

        // Log the user in
        Auth::guard('client')->login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}

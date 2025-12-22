<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class PasswordResetController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotForm()
    {
        return view('pages.auth.forgot-password');
    }

    /**
     * Send password reset link to email
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // Generate a unique token
        $token = Str::random(64);

        // Delete any existing token for this email
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Create new reset token (store hashed token)
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => hash('sha256', $token),
            'created_at' => now(),
        ]);

        // Send email with reset link
        Mail::to($request->email)->send(new PasswordResetMail($token, $request->email));

        return back()->with('status', 'Password reset link sent to your email!');
    }

    /**
     * Show the reset password form
     */
    public function showResetForm($token)
    {
        // Check if token exists and is not expired (24 hours)
        $reset = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $token))
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$reset) {
            return redirect('/forgot-password')->withError('Invalid or expired token.');
        }

        return view('pages.auth.reset-password', ['token' => $token, 'email' => $reset->email]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Check if token is valid
        $reset = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $request->token))
            ->where('email', $request->email)
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$reset) {
            return back()->withError('Invalid or expired token.');
        }

        // Find user and update password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withError('User not found.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // Delete the reset token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('status', 'Password reset successfully! Please log in with your new password.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Show the user registration form.
     */
    public function showRegistrationForm(): View
    {
        // Render the registration view.
        return view('pages.auth.register');
    }

    /**
     * Handle a new user registration request.
     *
     * This method:
     * - Validates the registration input data.
     * - Creates a new user with a hashed password.
     * - Logs the user in automatically after registration.
     * - Regenerates the session to prevent fixation attacks.
     * - Redirects the user to the cards page with a success message.
     */
    public function register(Request $request)
    {
        // Validate registration input.
        $request->validate([ // Already added most of these in client side 
            'firstName' => 'required|string|max:30',
            'lastName' => 'required|string|max:30',
            'email' => 'required|email|max:60|unique:users',
            'username' => 'required|string|max:40|unique:users',
            'password' => 'required|min:5|max:50|confirmed',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:50',
        ]);

        $fullName = $this->makeName($request->firstName, $request->lastName);

        // Create the new user.
        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'username' => $request->username,
            'bio' => $request->bio,
            'location' => $request->location,
        ]);
        
        $user->points = 100;
        $user->save();

        // Attempt login for the newly registered user.
        $credentials = $request->only('username', 'password');
        Auth::attempt($credentials);

        // Regenerate session for security (protection against session fixation).
        $request->session()->regenerate();

        // Redirect to cards page with a success message.
        return redirect('/')->withSuccess('Registration completed successfully! Get ready to explore BountyBust.');
    }

    protected function makeName(string $firstName, string $lastName): string
    {
        // No whitespaces should be presented in each of the fields
        $str1 = trim($firstName);
        $str2 = trim($lastName);
        return  preg_replace('/\s+/', ' ', "$str1 $str2");
    }
}

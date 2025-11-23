<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function authenticate(Request $request): RedirectResponse
    {
        // Validate the request data.
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        // Attempt to authenticate and log in the user.
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate the session ID to prevent session fixation attacks.
            $request->session()->regenerate();
            return redirect('/')->withSuccess('Login successful! Welcome back to BountyBust.');
        }
 
        // Authentication failed: return back with an error message.
        return back()->withError( 'The provided credentials do not match our records.')->onlyInput('username');
    }
}

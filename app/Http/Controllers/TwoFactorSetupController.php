<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorEmailCodeMail;

class TwoFactorSetupController extends Controller
{
    public function index()
    {
        $User = auth()->user();
        return view('admin.two-factor-setup', compact('User'));
    }

    public function switchMethod(Request $Request)
    {
        $Request->validate([
            'method' => 'required|in:email,authenticator'
        ]);

        $User = auth()->user();
        
        $Method = $Request->input('method');
        $User->update(['two_factor_method' => $Method]);

        if ($Method === 'authenticator' && !$User->two_factor_secret) {
            return back()->with('info', 'Switched to Authenticator. Please enable it below.');
        }

        return back()->with('success', 'Two-Factor Authentication method updated successfully.');
    }

    public function showEmailChallenge()
    {
        return view('auth.two-factor-email-challenge');
    }

    public function verifyEmailChallenge(Request $Request)
    {
        $Request->validate(['code' => 'required|string']);

        $User = auth()->user();

        if (!$User->two_factor_email_code || now()->greaterThan($User->two_factor_email_code_expires_at)) {
            return back()->withErrors(['code' => 'The authentication code has expired. Please request a new one.']);
        }

        if ($Request->input('code') !== $User->two_factor_email_code) {
            return back()->withErrors(['code' => 'The provided authentication code is incorrect.']);
        }

        $User->update([
            'two_factor_email_code' => null,
            'two_factor_email_code_expires_at' => null,
        ]);

        session(['admin_2fa_passed' => true]);

        return redirect()->intended('/Admin/Dashboard');
    }

    public function resendEmailCode()
    {
        $User = auth()->user();
        $Code = sprintf("%06d", mt_rand(100000, 999999));
        
        $User->update([
            'two_factor_email_code' => $Code,
            'two_factor_email_code_expires_at' => now()->addMinutes(10)
        ]);

        Mail::to($User->email)->send(new TwoFactorEmailCodeMail($Code));

        return back()->with('status', 'A new authentication code has been sent to your email.');
    }
}

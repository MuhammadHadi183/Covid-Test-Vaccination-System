<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorEmailCodeMail;

class RequireAdminTwoFactor
{
    public function handle(Request $Request, Closure $Next): Response
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            $User = auth()->user();
            
            if (empty($User->two_factor_method)) {
                $User->update(['two_factor_method' => 'email']);
            }

            $PassedAuthenticator = $User->two_factor_method === 'authenticator' && !empty($User->two_factor_secret);
            $PassedEmail = session('admin_2fa_passed') === true;

            if (!$PassedAuthenticator && !$PassedEmail) {
                if (!$Request->routeIs('admin.2fa.email.*') && !$Request->routeIs('logout')) {
                    if (!$User->two_factor_email_code || now()->greaterThan($User->two_factor_email_code_expires_at)) {
                        $Code = sprintf("%06d", mt_rand(100000, 999999));
                        $User->update([
                            'two_factor_email_code' => $Code,
                            'two_factor_email_code_expires_at' => now()->addMinutes(10)
                        ]);
                        Mail::to($User->email)->send(new TwoFactorEmailCodeMail($Code));
                    }
                    return redirect()->route('admin.2fa.email.challenge');
                }
            } else {
                if ($User->two_factor_method === 'authenticator' && empty($User->two_factor_secret)) {
                    $IsSetupRoute = $Request->routeIs('admin.setup-2fa*') || $Request->is('user/two-factor-authentication') || $Request->routeIs('livewire.*');
                    if (!$IsSetupRoute) {
                        $User->update(['two_factor_method' => 'email']);
                    }
                }
            }
        }

        return $Next($Request);
    }
}

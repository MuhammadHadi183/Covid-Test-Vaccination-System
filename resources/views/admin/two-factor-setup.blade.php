@extends('layouts.app')
@section('content')
<div class="page-header">
  <div>
    <div class="page-title">Two-Factor Authentication Setup</div>
    <div class="page-sub">Manage your security preferences. 2FA is mandatory for Administrators.</div>
  </div>
</div>

<div class="card card-pad" style="max-width: 800px;">
    
    @if(session('success'))
        <div style="padding: 15px; background: #eafeea; color: #27ae60; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div style="padding: 15px; background: #eaf2fb; color: #2980b9; border-radius: 8px; margin-bottom: 20px;">
            {{ session('info') }}
        </div>
    @endif

    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Select 2FA Method</h3>
        <p style="color: var(--text-sub); font-size: .9rem; margin-bottom: 20px;">Choose how you want to receive your security codes when logging in.</p>
        
        <form method="POST" action="{{ route('admin.setup-2fa.switch') }}">
            @csrf
            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                

                <label style="flex: 1; min-width: 200px; border: 2px solid {{ $User->two_factor_method === 'email' ? 'var(--primary)' : 'var(--border)' }}; border-radius: 10px; padding: 20px; cursor: pointer; display: flex; align-items: flex-start; gap: 15px; transition: all .2s; background: {{ $User->two_factor_method === 'email' ? '#f4f6f8' : '#fff' }};">
                    <input type="radio" name="method" value="email" {{ $User->two_factor_method === 'email' ? 'checked' : '' }} onchange="this.form.submit()" style="margin-top: 5px;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary); margin-bottom: 5px;">Email Authentication</div>
                        <div style="font-size: .85rem; color: var(--text-sub);">Receive a 6-digit code via your registered email address.</div>
                    </div>
                </label>


                <label style="flex: 1; min-width: 200px; border: 2px solid {{ $User->two_factor_method === 'authenticator' ? 'var(--primary)' : 'var(--border)' }}; border-radius: 10px; padding: 20px; cursor: pointer; display: flex; align-items: flex-start; gap: 15px; transition: all .2s; background: {{ $User->two_factor_method === 'authenticator' ? '#f4f6f8' : '#fff' }};">
                    <input type="radio" name="method" value="authenticator" {{ $User->two_factor_method === 'authenticator' ? 'checked' : '' }} onchange="this.form.submit()" style="margin-top: 5px;">
                    <div>
                        <div style="font-weight: 700; color: var(--primary); margin-bottom: 5px;">Google Authenticator</div>
                        <div style="font-size: .85rem; color: var(--text-sub);">Use an authenticator app (like Google Authenticator) to generate codes.</div>
                    </div>
                </label>

            </div>
        </form>
    </div>

    @if($User->two_factor_method === 'authenticator')
        <hr style="border: none; border-top: 1px solid var(--border); margin: 30px 0;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--primary); margin-bottom: 10px;">Authenticator Configuration</h3>
        

        <div style="padding: 20px; background: #fff; border: 1px solid var(--border); border-radius: 10px;">
            @livewire('profile.two-factor-authentication-form')
        </div>
    @endif

</div>
@endsection

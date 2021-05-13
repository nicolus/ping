<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Account Settings</h5>
                    <form action="" method="post">
                        <div class="form-group">
                            <x-label for="email">E-mail :</x-label>
                            <x-input class="mb-2" type="email" id="email" value="{{$user->email}}" name="email" disabled/>
                            <x-label for="phonenumber">Phone number :</x-label>
                            <x-input class="mb-2" type="tel" id="phonenumber" value="{{$user->phone_number}}" name="phonenumber"/>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Two factor authentication :</h5>
                    @if($qrcode && $user->two_factor_confirmed)
                        <p>@lang('Two factor authentication is activated, you can add it to Google Authenticator or Duo by scanning the qrcode below')</p>
                        <div class="text-center mb-4">{!! $qrcode !!}</div>
                        <form action="/user/two-factor-authentication" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-primary">Disable Two Factor Authentication</button>
                        </form>
                    @elseif(session('status') == 'two-factor-authentication-enabled')
                        <p>@lang('In order to activate 2FA, please scan the qrcode below in Google Authenticator or Duo and below and enter the code that\'s displayed in the app')</p>
                        <form action="" method="post">
                            @csrf
                            <div class="text-center">{!! $qrcode !!}</div>
                                <div class="input-group mb-3">
                                    <x-input type="text" name="code" id="code"></x-input>
                                    <x-button type="submit">
                                        {{ __('Send') }}
                                    </x-button>
                                </div>
                            </form>
                    @else
                        <form action="/user/two-factor-authentication" method="post">
                            <p>@lang('Two factor authentication is not activated yet. We strongly suggest that you activate it by using Google Authenticator or Duo and clicking the button below')</p>
                            @csrf
                            <button class="btn btn-primary">Enable Two Factor Authentication</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<?php

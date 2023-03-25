<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label name="email" type="email" :value="old('email')" required autofocus>{{__('Email')}}</x-input-label>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label name="password" type="password" required autocomplete="current-password">{{__('Password')}}</x-input-label>
                </div>

                <!-- Remember Me -->
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="remember_me" name="remember" class="form-check-input">

                        <label class="form-check-label" for="remember_me">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        @if (Route::has('password.request'))
                            <a class="text-muted me-3" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
    <div class="text-center">
        <a class="text-muted" href="{{route('register')}}">{{__("No account yet ? Create one.")}}</a>
    </div>
</x-app-layout>

<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <x-input-label name="name" required autofocus />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label name="email" required />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label name="password" autocomplete="new-password" required />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-input-label name="password_confirmation" required />
                </div>
                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-app-layout>

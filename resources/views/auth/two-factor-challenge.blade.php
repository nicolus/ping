<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <div class="mb-4 small text-muted">
                {{ __('You have enabled Two factor authentication on your account, please enter a validation code to continue...') }}
            </div>

            <div class="mt-4 d-flex justify-content-around">
                <form method="POST" action="">
                    @csrf
                    <label for="code">{{__('TOTP code')}} :</label>
                    <div class="input-group mb-3">
                        <input type="text" name="code" id="code" class="form-control" />
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </x-auth-card>
</x-app-layout>

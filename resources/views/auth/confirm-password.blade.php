<x-guest-layout>
    <div class="mb-4 text-sm text-secondary">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            @if ($errors->get('password'))
                <div class="text-danger mt-2">
                    @foreach ($errors->get('password') as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>

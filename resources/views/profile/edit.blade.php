<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Profile Update Form -->
            <div class="card mb-4">
                <div class="card-header">{{ __('Update Profile Information') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Update Form -->
            <div class="card mb-4">
                <div class="card-header">{{ __('Update Password') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete User Form -->
            <div class="card">
                <div class="card-header">{{ __('Delete Account') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

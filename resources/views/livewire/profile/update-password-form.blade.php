<?php

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(__('Password updated successfully.'));
    }
}; ?>

<section class="space-y-6">
    <div>
        <flux:heading level="2">
            {{ __('Update Password') }}
        </flux:heading>
        <flux:subheading>
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </flux:subheading>
    </div>

    <form wire:submit="updatePassword" class="space-y-6">
        <flux:input wire:model="current_password" label="{{ __('Current Password') }}" type="password" required
                    autocomplete="current-password"/>

        <flux:input wire:model="password" label="{{ __('New Password') }}" type="password" required
                    autocomplete="new-password"/>
        <flux:input wire:model="password_confirmation" label="{{ __('Confirm Password') }}" type="password" required
                    autocomplete="new-password"/>

        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
    </form>
</section>

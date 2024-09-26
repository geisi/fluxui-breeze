<?php

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (!Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        Flux::toast(__('Password confirmed successfully.'));

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="space-y-6">
    <flux:text>
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </flux:text>

    <form wire:submit="confirmPassword" class="space-y-6">
        <flux:input wire:model="password" label="{{ __('Password') }}" type="password" required
                    :placeholder="__('Password')"/>

        <div class="flex justify-end">
            <flux:button variant="primary" type="submit">
                {{ __('Confirm') }}
            </flux:button>
        </div>
    </form>
</div>

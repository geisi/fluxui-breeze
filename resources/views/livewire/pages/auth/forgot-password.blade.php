<?php

use Flux\Flux;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        Flux::toast(__($status));
    }
}; ?>

<div class="space-y-6">
    <flux:subheading>
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </flux:subheading>

    <form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <x-flux::input :label="__('Email')" wire:model="email" id="email" class="block mt-1 w-full" type="email"
                       name="email" required autofocus/>

        <div class="flex items-center justify-end mt-4">
            <x-flux::button type="submit">
                {{ __('Email Password Reset Link') }}
            </x-flux::button>
        </div>
    </form>
</div>

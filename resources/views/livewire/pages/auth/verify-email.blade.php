<?php

use App\Livewire\Actions\Logout;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Flux::toast(__('A new verification link has been sent to the email address you provided during registration.'));
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="space-y-6">
    <flux:text>
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </flux:text>

    <div class="flex items-center justify-between">
        <flux:button variant="primary" wire:click="sendVerification">
            {{ __('Resend Verification Email') }}
        </flux:button>

        <flux:button variant="ghost" wire:click="logout">
            {{ __('Log Out') }}
        </flux:button>
    </div>
</div>

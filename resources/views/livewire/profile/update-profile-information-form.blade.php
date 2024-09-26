<?php

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);

        Flux::toast(__('Profile updated successfully.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(__('A new verification link has been sent to your email address.'));
    }
}; ?>

<section class="space-y-6">
    <div>
        <flux:heading level="2">
            {{ __('Profile Information') }}
        </flux:heading>
        <flux:subheading>
            {{ __("Update your account's profile information and email address.") }}
        </flux:subheading>
    </div>

    <form wire:submit="updateProfileInformation" class="space-y-6">
        <flux:input :label="__('Name')" wire:model="name" autofocus required autocomplete="name"/>
        <flux:input :label="__('Email')" wire:model="email" type="email" required autocomplete="username"/>
        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div class="flex items-center space-x-6">
                <flux:text>
                    {{ __('Your email address is unverified.') }}
                </flux:text>

                <flux:button wire:click.prevent="sendVerification">
                    {{ __('Click here to re-send the verification email.') }}
                </flux:button>
            </div>
        @endif

        <flux:button variant="primary" type="submit">{{ __('Save') }}</flux:button>
    </form>
</section>

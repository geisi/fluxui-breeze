<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register" class="space-y-6">
        <flux:input :label="__('Name')" wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name"/>

        <flux:input :label="__('Email')" wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username"/>

        <flux:input :label="__('Password')" wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password"/>
        <flux:input :label="__('Confirm Password')" wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password"/>

        <div class="flex items-center justify-end mt-4 space-x-6">
            <x-flux::button variant="ghost" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </x-flux::button>

            <x-flux::button type="submit">
                {{ __('Register') }}
            </x-flux::button>
        </div>
    </form>
</div>

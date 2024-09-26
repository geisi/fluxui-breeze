<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit="login" class="space-y-6">

        <x-flux::input wire:model="form.email" :label="__('Email')" type="email"
                       required autocomplete="username"/>

        <x-flux::input wire:model="form.password" :label="__('Password')" type="password"
                       required autocomplete="current-password"/>

        <x-flux::checkbox wire:model="form.remember" :label="__('Remember me')"/>

        <div class="flex items-center justify-end mt-4 space-x-6">
            @if (Route::has('password.request'))
                <x-flux::button variant="ghost" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </x-flux::button>
            @endif

            <x-flux::button type="submit">
                {{ __('Log in') }}
            </x-flux::button>
        </div>
    </form>
</div>

<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
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
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-mary-input
                label="{{ __('Email') }}"
                placeholder="{{ __('Email') }}"
                icon="o-user"
                wire:model="form.email"
                class="block mt-1 w-full dark:text-white/70"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-mary-password
                label="{{ __('Password') }}"
                placeholder="{{ __('Password') }}"
                class="block mt-1 w-full dark:text-white/70"
                wire:model="form.password"
            />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 dark:text-white/70">
            <x-mary-checkbox
                label="{{ __('Remember me') }}"
                wire:model="form.remember"
            />
        </div>

        <div class="flex items-center mt-4">
{{--            @if (Route::has('password.request'))--}}
{{--                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>--}}
{{--                    {{ __('Forgot your password?') }}--}}
{{--                </a>--}}
{{--            @endif--}}

            <x-mary-button
                spinner="login"
                type="submit"
                class="px-6"
                label="{{ __('Log in') }}"
            />
        </div>
    </form>
</div>

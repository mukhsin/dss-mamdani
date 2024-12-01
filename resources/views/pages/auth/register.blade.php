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
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-mary-input
                label="{{ __('Name') }}"
                placeholder="{{ __('Name') }}"
                icon="o-user"
                wire:model="name"
                class="block mt-1 w-full dark:text-white/70"
            />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-mary-input
                label="{{ __('Email') }}"
                placeholder="{{ __('Email') }}"
                icon="o-user"
                wire:model="email"
                class="block mt-1 w-full dark:text-white/70"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-mary-password
                label="{{ __('Password') }}"
                placeholder="{{ __('Password') }}"
                class="block mt-1 w-full dark:text-white/70"
                wire:model="password"
            />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-mary-password
                label="{{ __('Confirm Password') }}"
                placeholder="{{ __('Confirm Password') }}"
                class="block mt-1 w-full dark:text-white/70"
                wire:model="password_confirmation"
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-mary-button
                type="submit"
                class="ms-4 px-6"
                label="{{ __('Register') }}"
            />
        </div>
    </form>
</div>

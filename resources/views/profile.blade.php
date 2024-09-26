<x-app-layout>
    <flux:heading size="xl" class="mb-6">
        {{__('Profile')}}
    </flux:heading>

    <div class="space-y-6">
        <flux:card>
            <livewire:profile.update-profile-information-form/>
        </flux:card>
        <flux:card>
            <livewire:profile.update-password-form/>
        </flux:card>
        <flux:card>
            <livewire:profile.delete-user-form/>
        </flux:card>
    </div>
</x-app-layout>

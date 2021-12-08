<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form" class="w-full">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Profile Photo File Input -->
            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

            <x-jet-label for="photo" value="{{ __('Photo') }}" />

            <!-- Current Profile Photo -->
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->username }}"
                    class="h-20 w-20 object-cover">
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview">
                <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                    x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select A New Photo') }}
            </x-jet-secondary-button>

            @if ($this->user->profile_photo_path)
            <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2" />
        </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 block w-full">
            <x-jet-label for="username" value="Usuario" />
            <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username"
                autocomplete="username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 block w-full">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <div class="col-span-6 block w-full" style="display: flex;">
            <!-- Nombres -->
            <div class="col-span-6 sm:col-span-4 w-full" style="margin-right: 5vh">
                <x-jet-label for="nombres" value="Nombres" />
                <x-jet-input id="nombres" type="text" class="mt-1 block w-full" wire:model.defer="state.nombres"
                    autocomplete="nombres" />
                <x-jet-input-error for="nombres" class="mt-2" />
            </div>

            <!-- Apellidos -->
            <div class="col-span-6 sm:col-span-4 w-full">
                <x-jet-label for="apellidos" value="Apellidos" />
                <x-jet-input id="apellidos" type="text" class="mt-1 block w-full" wire:model.defer="state.apellidos"
                    autocomplete="apellidos" />
                <x-jet-input-error for="apellidos" class="mt-2" />
            </div>
        </div>
        <div class="col-span-6 block w-full" style="display: flex; justify-content: space-between;">
            <!-- DNI -->
            <div class="col-span-6 sm:col-span-4 w-full" style="margin-right: 5vh">
                <x-jet-label for="dni" value="DNI" />
                <x-jet-input id="dni" type="text" class="mt-1 block w-full" wire:model.defer="state.dni"
                    autocomplete="dni" />
                <x-jet-input-error for="dni" class="mt-2" />
            </div>

            <!-- Celular -->
            <div class="col-span-6 sm:col-span-4 w-full">
                <x-jet-label for="ncelular" value="N° Celular" />
                <x-jet-input id="ncelular" type="text" class="mt-1 block w-full" wire:model.defer="state.ncelular"
                    autocomplete="ncelular" />
                <x-jet-input-error for="ncelular" class="mt-2" />
            </div>

        </div>
        <div class="col-span-6 block w-full" style="display: flex; justify-content: space-between;">
            <!-- Fecha de Nacimiento -->
            <div class="col-span-6">
                <x-jet-label for="fnac" value="Fecha de Nacimiento" />
                <x-jet-input id="fnac" type="date" class="mt-1 block w-full" wire:model.defer="state.fnac"
                    autocomplete="fnac" />
                <x-jet-input-error for="fnac" class="mt-2" />
            </div>

            <!-- Edad -->
            <div class="col-span-6">
                <x-jet-label for="edad" value="Edad" />
                <x-jet-input id="edad" type="text" class="mt-1 block w-full" wire:model.defer="state.edad"
                    autocomplete="edad" />
                <x-jet-input-error for="edad" class="mt-2" />
            </div>

            <!-- Sexo -->
            <div class="col-span-6">
                <x-jet-label for="sexo" value="{{ __('Sexo') }}" />
                <select id="sexo" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="sexo" wire:model.defer="state.sexo">
                    <option value="m" {{ $this->user->sexo== 'm' ?
                        'selected'
                        : '' }} >
                        Hombre
                    </option>
                    <option value="f" {{ $this->user->sexo== 'f' ?
                        'selected'
                        : '' }}>
                        Mujer
                    </option>
                </select>
                <x-jet-input-error for="sexo" class="mt-2" />
            </div>
        </div>
        <!-- Dirección -->
        <div class="col-span-6 block w-full">
            <x-jet-label for="direccion" value="Dirección" />
            <x-jet-input id="direccion" type="text" class="mt-1 block w-full" wire:model.defer="state.direccion"
                autocomplete="direccion" />
            <x-jet-input-error for="direccion" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

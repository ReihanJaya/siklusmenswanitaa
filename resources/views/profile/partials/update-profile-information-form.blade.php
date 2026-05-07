<section>
    <header>
        <h2 class="text-lg font-bold text-gray-800">
            📸 Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Perbarui foto, nama, dan email kamu.
        </p>
    </header>

    <!-- FOTO PROFILE -->
    <div class="mt-6 flex flex-col items-center gap-4" x-data="{ previewUrl: null }">
        <div class="relative group">
            <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-pink-400 to-purple-500 p-1 shadow-lg shadow-pink-200">
                <img 
                    x-bind:src="previewUrl || '{{ $user->profile_photo_url }}'"
                    alt="Profile Photo"
                    class="w-full h-full rounded-full object-cover bg-white"
                >
            </div>
            <label for="photoInput" class="absolute bottom-1 right-1 bg-white rounded-full p-2 shadow-md cursor-pointer hover:bg-pink-50 transition border border-pink-100 group-hover:scale-110">
                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                </svg>
            </label>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <input 
                type="file" 
                name="photo" 
                id="photoInput"
                accept="image/jpeg,image/png,image/webp"
                class="hidden"
                @change="
                    const file = $event.target.files[0];
                    if (file) {
                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran foto maksimal 2MB');
                            $event.target.value = '';
                            return;
                        }
                        previewUrl = URL.createObjectURL(file);
                        $refs.uploadBtn.classList.remove('hidden');
                    }
                "
            >

            <input type="hidden" name="name" value="{{ $user->name }}">
            <input type="hidden" name="email" value="{{ $user->email }}">

            <button 
                type="submit" 
                x-ref="uploadBtn"
                class="hidden mt-2 px-5 py-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-sm font-bold rounded-full shadow-md hover:shadow-lg transition active:scale-95"
            >
                💾 Simpan Foto
            </button>
        </form>

        @error('photo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        <p class="text-[11px] text-gray-400">JPG, PNG, WEBP • Maks 2MB</p>
    </div>

    <!-- FORM DATA -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-5">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>💾 Simpan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 font-semibold"
                >✅ Tersimpan!</p>
            @endif
        </div>
    </form>
</section>
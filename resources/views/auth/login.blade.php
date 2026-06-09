<x-auth-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-5">
        <div
            class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl mb-4 shadow-lg shadow-blue-500/30">
            <span class="material-icons-round text-white text-3xl">assignment_ind</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-700 mb-2">
            FreelanceApp
        </h1>
        <p class="text-gray-600 text-sm">
            Silahkan Login
        </p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div>
                <x-input-label class="block text-sm font-medium text-gray-600 mb-1.5" for="email"
                    :value="__('Email')" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="your@email.com" />
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <x-input-label class="block text-sm font-semibold text-gray-600 mb-1.5" for="password"
                    :value="__('Password')" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="••••••••" />
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 ">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 outline-none cursor-pointer" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm font-medium text-blue-500 hover:text-blue-600">
                        Lupa Sandi?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <x-primary-button class="w-full">
                {{ __('Masuk') }}
            </x-primary-button>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Atau</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="flex items-center justify-center">
                <a href="#"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#EA4335"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#4285F4"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#34A853"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500">Lanjut dengan Google</span>
                </a>
                {{-- <button type="button"
                    class="flex items-center justify-center gap-2 px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-500">Facebook</span>
                </button> --}}
            </div>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-sm text-gray-500">
            Belum Punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Buat satu di sini
            </a>
        </p>
    </div>

    <!-- Footer -->
    <x-auth-footer />

</x-auth-layout>

{{-- <div class="bg-card-light rounded-2xl shadow-soft p-8 border border-gray-100">
    <h2 class="text-xl font-semibold text-text-main-light dark:text-text-main-dark mb-6">
            Selamat Datang!
        </h2>
<form action{{ route('login') }}" class="space-y-6" method="POST">
    @csrf
    <div class="group">
        <x-input-label class="block text-sm font-medium text-text-muted-light mb-1.5" for="email"
            :value="__('Email')" />

        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-icons-round text-gray-400 dark:text-gray-500 text-xl">email</span>
            </div>
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" placeholder="nama@perusahaan.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>
    </div>
    <div class="group">
        <div class="flex items-center justify-between mb-1.5">
            <x-input-label class="block text-sm font-medium text-text-muted-light dark:text-text-muted-dark mb-1.5"
                for="password" :value="__('Password')" />
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-icons-round text-gray-400 dark:text-gray-500 text-xl">lock</span>
            </div>
            <x-text-input id="password" class="block w-full" type="password" name="password" required
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />

        </div>
        <div class="flex justify-end mt-2">
            @if (Route::has('password.request'))
                <a class="text-xs font-medium text-primary hover:text-primary-hover transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Kata Sandi?') }}
                </a>
            @endif
        </div>
    </div>
    <x-primary-button class="w-full">
        {{ __('Masuk') }}
    </x-primary-button>

    <!-- Remember Me -->
    <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>


</form>


<p class="mt-8 text-center text-sm text-text-muted-light dark:text-text-muted-dark">
    Belum punya akun?
    <a class="font-semibold text-primary hover:text-primary-hover transition-colors"
        href="{{ route('register') }}">Daftar
        Sekarang</a>
</p>
<div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span
                    class="px-2 bg-card-light dark:bg-card-dark text-text-muted-light dark:text-text-muted-dark text-xs">Atau
                    lanjutkan dengan</span>
            </div>
        </div>
</div>

<div class="fixed bottom-2 left-0 right-0 flex justify-center pointer-events-none">
    <div class="w-1/3 h-1.5 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
</div> --}}

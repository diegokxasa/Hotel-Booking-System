<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>


<a href="{{ route('github.login') }}"
   class="w-full flex justify-center items-center px-4 py-2 mt-2 bg-gray-800 text-white rounded-lg">
   <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 .5C5.73.5.5 5.73.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56
               0-.28-.01-1.02-.02-2-3.2.69-3.87-1.54-3.87-1.54-.53-1.35-1.3-1.71-1.3-1.71
               -1.06-.73.08-.71.08-.71 1.17.08 1.78 1.2 1.78 1.2
               1.04 1.78 2.73 1.27 3.4.97.11-.75.41-1.27.75-1.56
               -2.55-.29-5.23-1.27-5.23-5.65 0-1.25.45-2.27
               1.19-3.07-.12-.29-.52-1.45.11-3.02 0 0 .97-.31
               3.18 1.18a11.1 11.1 0 0 1 5.79 0c2.2-1.49 3.17-1.18
               3.17-1.18.63 1.57.23 2.73.11 3.02.74.8 1.19 1.82
               1.19 3.07 0 4.39-2.68 5.36-5.24 5.65.42.36.8 1.07.8 2.16
               0 1.56-.01 2.82-.01 3.21 0 .31.21.67.8.56A10.52 10.52 0
               0 0 23.5 12C23.5 5.73 18.27.5 12 .5z"/>
   </svg>
   Login with GitHub
</a>

    </x-authentication-card>
</x-guest-layout>

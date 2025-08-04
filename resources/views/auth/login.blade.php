<div class="mt-[30px]">
@include("header")
</div>

<link rel="stylesheet" href="{{Vite::asset('resources/css/login.css')}}">
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<h1 class="text-center mt-10 mb-10 text-2xl text-[#9370db]">Вход</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
         
            <x-text-input id="email" class="block mt-1 w-full dark:bg-white dark:rounded" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Почта" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
           

            <x-text-input placeholder="Пароль" id="password" class="block mt-1 w-full dark:rounded dark:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-[white] dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>
        <div class="flex justify-center">
        <x-primary-button class="flex items-center justify-center w-96 border-none bg-transparent dark:bg-transparent  dark:rounded bg-[#e3fc3d] dark:hover:text-black dark:hover:bg-[#e3fc3d] dark:text-white" style="border: 1px solid  #9370db;">
                {{ __('Отправить') }}
            </x-primary-button>
        </div> 
      
        <div class="flex flex-col items-center justify-center align-center mt-4 ">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#9370db] flex flex-col items-center justify-center align-center dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            
            <div class='flex'><p class="text-white mt-5 mr-1">Нет аккаунта?</p><a href="{{ route('register') }}" class="underline text-md text-[#9370db] dark:text-[#9370db] mt-5 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ml-50"> {{ __('ЗАРЕГЕСТРИРОВАТЬСЯ') }}
            </a></div>
            </div> 
           
           
            
            
        </div>
        
    </form>
   
</x-guest-layout>

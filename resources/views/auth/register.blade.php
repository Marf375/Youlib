@include("header")
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h1 class="text-center mb-[30px] text-2xl">Регистрация</h1>
        <!-- Name -->
        <div>
            
            <x-text-input id="name" class="dark:bg-white block mt-1 w-full dark:text-black" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Имя" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-6 ">
       
            <x-text-input id="email" class="dark:bg-white block mt-1 w-full dark:text-black"  type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Почта" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6 ">
      

            <x-text-input id="password" class="pas block mt-1 w-full dark:bg-white dark:text-black" placeholder="Пароль"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p Class="simb text-[red]">Пароль должен быть не менее 8 символов</p>
            <p Class="zag text-[red]">Пароль должен содержать Заглавную букву</p>
            <p Class="cifr text-[red]">Пароль должен содержать минимум 1 цифру</p>
            <p Class="uniq text-[red]">Пароль Должен содержать Уникальный знак </p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
  

            <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-white dark:text-black" placeholder="Подтвердите пароль"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
       
   <div class="mt-6 ">
       
       <x-text-input id="age" class="dark:bg-white block mt-1 w-full dark:text-black" type="number" name="age" :value="old('age')"  autocomplete="age" placeholder="Возраст" />
       <x-input-error :messages="$errors->get('age')" class="mt-2" />
   </div>
        <div class="flex flex-col items-center justify-end mt-10">
        <x-primary-button class="w-[50%] mb-5 flex items-center justify-center bg-transparent " style="border: 1px solid #9370db;">
                {{ __('ЗАРЕГИСТРИРОВАТЬСЯ') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 dark:text-[#e3fc3d] hover:text-gray-900 dark:hover:text-gray-100  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('УЖЕ ЗАРЕГИСТРИРОВАНЫ?') }}
            </a>

            
        </div>
    </form>
</x-guest-layout>
<script>
    let simb=document.querySelector(".simb")
    let zag=document.querySelector(".zag")
   
    let cifr=document.querySelector(".cifr")
    let uniq=document.querySelector(".uniq")
    let pas=document.querySelector(".pas")
    let val
    let a=[]
    pas.addEventListener('input',()=>{
        val=pas.value
        console.log(val)
        if (val.length >= 8) {
               simb.style.color="green"
            } else {
               simb.style.color="red"
            }
            
            // Проверка на заглавную букву
            if (/[A-ZА-Я]/.test(val)) {
                zag.style.color="green"
                
            } else {
                zag.style.color="red"
              
            }
            
            // Проверка на цифру
            if (/\d/.test(val)) {
                cifr.style.color="green"
                
            } else {
                cifr.style.color="red"
                
            }
            // Проверка на уникальный символ (например, !@#$%^&* и т.д.)
            if (/[-!$%^&*()_+|~=`{}?]/.test(val)) {
              
                uniq.style.color="green"
            
            } else {
                uniq.style.color="red"
            }
        });
            

</script>

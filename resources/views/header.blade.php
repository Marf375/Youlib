

<link rel='stylesheet' href="{{Vite::asset('resources/css/style.css')}}">
<header class='mt-[10px]'>
    <nav class='text-[#9370DB] flex justify-around content-center ml-[10%]'>
        <div class="logo flex gap-[1dvw]" >
            <img class="w-[3dvw] h-[6dvh]" src="{{Vite::asset('resources/views/logo.png')}}"/>
            <a href="/" class="text-[2.5rem]"> YOULIB</a>
        </div>
         <div class="align-login">
                <a href="{{ url('/dashboard') }}"><button class = 'header-buttons'>ВОЙТИ</button></a>
               
                <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.5714 9H25.7143C26.3205 9 26.9019 9.24583 27.3305 9.68342C27.7592 10.121 28 10.7145 28 11.3333V27.6667C28 28.2855 27.7592 28.879 27.3305 29.3166C26.9019 29.7542 26.3205 30 25.7143 30H16.5714M23.4286 19.5L18.8571 14.8333M23.4286 19.5L18.8571 24.1667M23.4286 19.5H12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
        </div>
    </nav>
</header>


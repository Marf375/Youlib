@php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
@endphp
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <div class="flex ml-[15dvw] gap-[1dvw] h-[10dvh]">
        <div class="logo flex gap-[1dvw] mt-[2dvh]" >
<img class="w-[3dvw] h-[6dvh]" src="{{Vite::asset('resources/views/logo.png')}}"/>
            <a href="/dashboard" class="text-[2.5rem] text-[#9370DB]"> YOULIB</a>
        </div>
        
    
        <div class="flex w-[10dvw] ml-[55dvw]">
            <p class='text-[#9370db] balance mt-[40px] text-[1.5rem]'>{{ Auth::user()->balance
            }}</p><p class="ml-[4px] mt-[40px] text-[#9370db] text-[1.5rem]"> Руб.</p> 
             <div id='bala' class="absolute z-10 top-[4.2dvh] right-[15dvw]"></div>
        </div>
       
               
                    <li class="nav-item dropdown" style="list-style-type:none;">
                        <a class="nav-link dropdown-toggle inline-flex items-center px-3 mt-5  border-none text-2xl leading-4 font-medium rounded-md text-[#9370db]  bg-transparent hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu z-50 mt-2 w-[15dvh]  h-[10dvh] left-[-3dvh]  border-solid border-1 border-[#9370db] bg-transparent">
                          <li><x-dropdown-link :href="route('profile.edit') " class=' hover:text-[white] bg-transparent' >
                            {{ __('ПРОФИЛЬ') }}
                        </x-dropdown-link></li>
                          <li><form method="POST" action="{{ route('logout') }}" class='w-[100%] px-0'>
                            @csrf

                            <x-dropdown-link :href="route('logout')" class='hover:text-[white]  bg-transparent'
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('ВЫХОД') }}
                            </x-dropdown-link>
                        </form></li>
                        </ul>
                      </li>
              
    </div>


        
</header>


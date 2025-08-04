@include("header1")
<body class="dark:bg-black">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{Vite::asset('resources/css/style.css')}}">
<h2 class="font-semibold mx-[5dvw] text-2xl font-sans text-[white] dark:text-[#e3fc3d] leading-tight">
            {{ __('Профиль') }}
        </h2>
<x-app-layout class="flex ">


    <div class="py-12 w-[90dvw]">
        <div class="max-w-7xl mx-[50pc] sm:px-6 lg:px-8 space-y-6 ">
            <div class=" w-[40dvw] ml-[-500px] p-4 sm:p-8 bg-[#323232] dark:bg-[#121212] shadow sm:rounded-lg">
                <div class="">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="  w-[40dvw]  ml-[-500px] p-4 sm:p-8 bg-[#323232] dark:bg-[#121212] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class=" w-[40dvw]  ml-[-500px] p-4 sm:p-8 bg-[#323232] dark:bg-[#121212] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            <div class="w-[40dvw]  ml-[-500px] p-4 sm:p-8 bg-[#323232] dark:bg-[#121212] shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.fact')
                </div>
            </div>
        </div>
    </div>
    <br>

</x-app-layout>
<div class="mt-[190dvh]">
    <h1 class="text-[30px] font-bold text-white my-[100px]">Персональная библиотека</h1>
    <div class="grid grid-cols-4 ml-[20dvw]">
    @foreach($books as $book)
    <div>
        <img src="{{$book->image}}" alt="" class="w-[10dvw]">
        <h1 class="text-[20px] text-[white] w-[10dvw]">{{$book->book_name}}</h1>
        @if(!empty($book->file_path))
            <a href="{{ route('reader', ['filename' => basename($book->file_path)]) }}" class="btn btn-primary">
                Читать книгу
            </a>
        @else
            <button class="btn btn-secondary" disabled>Файл недоступен</button>
        @endif
    </div>
    @endforeach
</div>
   </div>
</body>

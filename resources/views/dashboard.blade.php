<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        window.STRIPE_KEY = "{{ config('services.stripe.key') }}";
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{Vite::asset('resources/css/adbs.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/css/style.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/css/stars.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/css/sss.css')}}">
@vite(['resources/js/components/adb.jsx'])
@vite(['resources/js/app.jsx'])

    <title>YOULIB</title>
</head>
<body class="bg-[black]">

@include("header1")
<x-app-layout class="h-[1px]">
</x-app-layout>

</br>
<script>
    window.books=@json($books)
      </script>
 <script>window.isAuthenticated=@json($isAuthenticated)
 </script>
 <script>window.userLibrary=@json($userLibrary)
 </script>
 <script>window.boo=@json($boo)
 </script>

<div id='anp'></div>
<div class="w-[100dvw] h-[20dvh]"></div>
</main>
<footer class="absolute flex gap-[20dvw] justify-around text-[#9370db] bg-[black] w-[100dvw]    items-center">
    <div>
      <h2>Контакты</h2>
      <p>Телефон:7 (999) 666-44-44</p>
      <p>Почта:Youlib@gmail.com</p>
    </div>
    <div>
      <h2>Соцсети</h2>
      <img>
      <img>
    </div>
  </footer>
</body>
</html>



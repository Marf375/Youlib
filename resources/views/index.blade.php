
<!DOCTYPE html>
<html lang="ru">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>Youlib</title>


@vite(['resources/css/style.css','resources/js/app.jsx'])
</head>

<body>

@include("header")

<main>

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
</main>

<footer class="flex gap-[20dvw] justify-around text-[#9370db] bg-[black] mt-[10dvw] h-[15dvh]     items-center">
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

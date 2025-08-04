
@include('header1')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{Vite::asset('resources/css/style.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/css/stars.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/css/reviewsstyle.css')}}">
<?php
$hash = isset($_GET['hash']) ? $_GET['hash'] : '';
echo($hash);

?>
 @foreach($books_arr as $booka)
 @if($booka->id==$hash)
 @if(session('success'))

       
 <div class='book flex mx-[15dvw]' style="margin-top: 15px; padding: 10px;">
    <img src="{{$booka->img}}" alt="">
    <div class='flex flex-col ml-[1dvw] '>
    <strong class="dark:text-white text-white my-[1dvh]">{{ $booka->name }}</strong>
    <p class='text-[white] w-[30dvw]'>{{$booka->description}}</p>
    <div class='flex ml-[25dvw] my-[5dvh] '>
        @for($i = 1; $i <= 5; $i++)
        <span class="star {{ $i <= $booka->rating ? 'filled' : '' }}">&#9733;</span>
        @endfor
    </div>
    <form action="">
        <button class='bt w-[25dvw] h-[15dvh]'> В избранное</button>
        </form>
        <script>
        let bth=[document.queryselector('.bt')]
        let status=[]
        bth.addEventListener('click',()=>{
            if(){
            bth.style.backgroundcolor='green';}
            else{

            }
        })

        </script>
</div>
        @else()
        
     
        <div class='book flex mx-[15dvw] flex-col flex-nowrap justify-center content-center ml-[25dvw] mt-[15dvh]' >
            <div class="flex">
                <img src="{{$booka->img}}" alt="" class="w-[10dvw] h-[35dvh] rounded-[10px]">
                <div class="flex flex-col">
                    <strong class="dark:text-white text-white my-[1dvh] text-[2rem] mx-[5dvw]">{{ $booka->name }}</strong>
                    <div class="flex mx-[5dvw] gap-[3dvw]">
                        <div class="bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                        <p class="text- text-[1.3rem] bold">Год выпуска:</p>{{$booka->Year}}
                        </div>
                        <div class="bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                            <p class="text- text-[1.3rem] bold">Время чтение</p>
                            @if($booka->timer=="NULL")
                            <p>Автор не указал время чтения</p>
                            @else
                            {{$booka->timer}}
                            @endif
                        </div>
                        
                        <div class="bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                        <p class=" text-[1.3rem] bold">Автор:</p><p class="text-[1.6rem] mt-[5px]">{{$booka->copyright_holder}}</p>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class='flex flex-col ml-[1dvw]  my-[30px]'>
                <div class="bg-[grey] w-[40dvw] flex flex-wrap content-center justify-center min-h-[20dvh] rounded-[1dvw]">
                <p class='text-[white] w-[30dvw] '>{{$booka->description}}</p>
                </div>
                    <div class='flex ml-[25dvw] my-[5dvh]'>
                        @for($i = 1; $i <= 5; $i++)
                        <span class="star  {{ $i <= $booka->rating ? 'filled' : '' }}">&#9733;</span>
                        @endfor
                    </div>
            </div>
        </div>
                @endif
                 @endif
        @endforeach

<script>
    let hash = window.location.hash.substring(1);
    console.log(hash)
    if (hash) {
      
        window.location.href = window.location.pathname + "?hash=" + hash;
    }
</script>
@vite(['resources/js/components/reviews.jsx'])

<div id="reviews"></div>
<div class="h-[20dvh] w-[100dvw]"></div>
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
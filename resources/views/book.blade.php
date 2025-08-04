@if(session()->has('success'))
@include('header1')
@else()
@include('header')
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{Vite::asset('resources/css/style.css')}}">
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
            <div class='flex ml-[25dvw] my-[5dvh]'>
                @for($i = 1; $i <= 5; $i++)
                <span class="star  {{ $i <= $booka->rating ? 'filled' : '' }}">&#9733;</span>
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
                        <img src="{{$booka->img}}" alt="" class="imgb rounded-[10px]">
                        <div class="flex flex-col">
                            <strong class="dark:text-white text-white my-[1dvh] text-[2rem] mx-[5dvw]">{{ $booka->name }}</strong>
                            <div class="flex mx-[5dvw] gap-[3dvw]">
                                <div class="gg bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                                <p class="gg text- text-[1.3rem] bold">Год выпуска:</p>{{$booka->Year}}
                                </div>
                                <div class="gg bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                                    <p class="text- text-[1.3rem] bold">Время чтение</p>
                                    @if($booka->timer=="NULL")
                                    <p>Автор не указал время чтения</p>
                                    @else
                                    {{$booka->timer}}
                                    @endif
                                </div>
                                
                                <div class="gg bg-[grey] w-[5dvw] h-[5dvw] rounded-[10px] flex-wrap justify-center content-center flex">
                                <p class="text- text-[1.3rem] bold">Автор:</p>{{$booka->copyright_holder}}
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
@vite(['resources/js/components/reviews_noa.jsx'])

<div id="revn"></div>

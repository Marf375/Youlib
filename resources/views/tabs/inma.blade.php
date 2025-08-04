
  
        <!-- Слайдер -->
        <div id="sliderExample" class="carousel slide h-[30dvh] w-[70dvw]" data-bs-ride="false">
            <div class="carousel-inner border-solid border-[1px] border-[#9370DB] w-[70%] h-[25dvh] ml-[280px]">
                <div class="carousel-item active w-[100%] ">
                    <img src="" class="d-block w-100" alt="Slider Image 1">
                </div>
                <div class="carousel-item">
                    <img src="" class="d-block w-100" alt="Slider Image 2">
                </div>
                <div class="carousel-item">
                    <img src="" class="d-block w-100" alt="Slider Image 3">
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#sliderExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden mb-[50dvw]"><</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sliderExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">></span>
            </button>
        </div>
<h1 class='text-[2rem] text-[#9370DB] mx-[5dvw]'>Рекомендуемые<a href="" class=' text-[white] hover:text-[#9370DB] ml-[20px] text-[16px]'>Показать все</a></h1>
<div class="my-[50px]">@include('recomend')<div>
    <div class="w-[100dvw] h-[50px]"></div>
  <h1 class="text-[2rem] text-[#9370DB] my-[10px] mx-[5dvw]">Интересный факт</h1>
  <div class="mt-[3dvh] w-[50dvw] h-[30dvh] border-solid border-[1px] border-[#9370DB] justify-self-center">
    
    <p></p>
    <img src="" alt="">
  </div>
  <h1 class='text-[2rem] text-[#9370DB] mx-[5dvw]'>Новинки <a href="" class=' text-[white] hover:text-[#9370DB] ml-[20px] text-[16px]'>Показать все</a></h1>
@include('news')
<h1 class='text-[2rem] text-[#9370DB] mx-[5dvw]'>Любовь? <a href="/catalog#love" class=' text-[white] hover:text-[#9370DB] ml-[20px] text-[16px]'>Показать все</a></h1>
@include('love')

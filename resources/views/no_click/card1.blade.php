<div class="mt-5 w-[10dvw] h-[35dvh] ">
            <div class="product-card">
                <a href="/book#{{$book->id}}">
                <img src="{{$book->img}}" alt="Товар" class="product-image">
                <div class="product-info">
                    <h5 class="mt-[20%]">{{$book->name}}</h5>
                    <p>{{$book->copyright_holder}}</p>
                </div>
                </a>
       
            </div>
            <div>
            <p class="text-[#9370DB]">{{$book->price}} руб.</p>
            </div>
</div> 
<div class="mt-5 w-[15dvw] h-[35dvh] card">
            <div class="product-card">
                <a href='/book_a#{{$book->id}}'>
                <img src="{{$book->img}}"  alt="Товар" class="product-image">
                <div class="product-info">
                    <h5>{{$book->file}}</h5>
                    <h5 class="bn">{{$book->name}}</h5>
                    <h5>{{$book->copyright_holder}} </h5>
                </div>
                </a>
       
            </div>
        <div>
        @if(auth()->user()->library->contains('book_name', $book->name))
    <div><p class='bp'>Книга у вас в библиотеке</p></div>
@else
    <div><p class='bp text-[18px] my-[10px] mx-[20px]'>{{$book->price}}  </p></div>
    <button class='ats border-solid border-[1px] border-[#9370db] text-[white] rounded-[10px] h-[50px] w-[200px] data-book-name="{{$book->name}}"'>добавить в корзину</button>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    let buttons = document.querySelectorAll(".ats");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            
            button.textContent = "В корзине";
            button.disabled = true; 

         
            button.classList.add("in-cart");

           
        });
    });
});
</script>
@endif
        </div>
</div> 
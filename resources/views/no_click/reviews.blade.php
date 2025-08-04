<link rel="stylesheet" href="{{Vite::asset('resources/views/stars.css')}}">
<link rel="stylesheet" href="{{Vite::asset('resources/views/reviewsstyle.css')}}">
<section class="h-[10dvh] dark:rounded-[10px]  ">
    <div>
        <h2>Отзывы</h2>
    
      
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
    
    
        @if(isset($showForm) && $showForm)
            <form action="/reviews" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Ваше имя" class='rounded-[10px] bg-black text-white' required>
                <textarea name="content" placeholder="Ваш отзыв" required class='rounded-[10px] bg-black text-white'></textarea>
                <label for="rating">
                    <div class="stars">
                        <input type="radio" name="rating" value="5" id="star5" required>
                        <label for="star5">&#9733;</label>
                    
                        <input type="radio" name="rating" value="4" id="star4" required>
                        <label for="star4">&#9733;</label>
                    
                        <input type="radio" name="rating" value="3" id="star3" required>
                        <label for="star3">&#9733;</label>
                    
                        <input type="radio" name="rating" value="2" id="star2" required>
                        <label for="star2">&#9733;</label>
                    
                        <input type="radio" name="rating" value="1" id="star1" required>
                        <label for="star1">&#9733;</label>
                    </div>
                </label>
                
                <button type="submit" class="dark:text-white">Отправить</button>
            </form>
        @endif
    
        
        <div class='review-align'>
        <h3>Последние отзывы:</h3>
        @foreach($reviews as $review)
            <div class='review' style="margin-top: 15px; padding: 10px;"> 
                <strong class="dark:text-white text-white">{{ $review->name }}</strong>
                 @for($i = 1; $i <= 5; $i++)
                <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
            @endfor
                <p class="dark:text-white">{{ $review->content }}</p>
                <p class="dark:text-white">добавлено:{{ $review->created_at->format('d-m-Y H:i')}}</p>
            </div>
        @endforeach
        
   
   
            {{ $reviews->links('vendor.pagination.custom') }}
  
        </div>
    </div>
</section>
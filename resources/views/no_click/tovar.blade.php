
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            @foreach($books_arr as $book)
                            @if($book->genres->contains('name', 'Любовные романы'))
                           <div class='w-[5dvw] h-[15dvh] '>@include('card')</div>
                           @endif
                            @endforeach
                        </div>
                    </div>
          

  
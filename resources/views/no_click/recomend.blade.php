  <!-- Карусель -->
  <div id="carouselExampleControls" class="carousel slide w-[70dvw]" data-bs-ride="false">
              <div class="carousel-inner">
                  @php
                      $chunks = $books->chunk(5); // Разбиваем книги на группы по 5
                  @endphp

                  @foreach($chunks as $index => $chunk)
                      <div class="carousel-item @if($index === 0) active @endif">
                          <div class="d-flex flex-wrap justify-content-center gap-3">
                              @foreach($chunk as $book)
                                  @if(Auth::check())
                                      @include('card', ['book' => $book])
                                  @else
                                      @include('card1', ['book' => $book])
                                  @endif
                              @endforeach
                          </div>
                      </div>
                  @endforeach
              </div>

              @if($chunks->count() > 1)
                  <button class="carousel-control-prev mr-[500px]" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                  </button>
              @endif
          </div>
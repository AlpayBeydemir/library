@extends('frontend.index')
@section('content')

    <div class="container mt-5">

        <div class="row">
            <div class="col-lg-8">
                <h4>Featured</h4>
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NXx8ZXZlbnR8ZW58MHx8MHx8&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1674574124345-02c525664b65?ixlib=rb-4.0.3&ixid=MnwxMjA3fDF8MHxzZWFyY2h8MTV8fGV2ZW50fGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fGV2ZW50fGVufDB8fDB8fA%3D%3D&auto=format&fit=crop&w=500&q=60" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <h4>Featured Events</h4>
                @foreach($events as $event)
                    @if($event->selected_time > date('Y-m-d'))
                        <div class="featured-events">
                            <div class="card text-center event-header-div">
                                <div class="card-header event-header">
                                    @php($date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->selected_time))
                                    <span class="event-header-span">{{ $date->format('F') }}</span>
                                </div>
                                <div class="card-body event-body">
                                    <h3>{{ $date->format('d') }}</h3>
                                </div>
                            </div>
                            <div class="event-info">
                                <a href="{{ route('DetailEvent', $event->id) }}"><h6>{{ $event->name }}</h6></a>
                                <div>
                                    <span class="event-date">{{ $date->format('F') . $date->format('d') ."th " . "|" . " " . $date->format('H:i') }}</span>
                                </div>
                                <div>
                                    <span class="event-location">{{ $event->address }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <div class="row mt-5">
            @foreach($products as $product)
                <div class="card ms-4" style="width: 18rem; height: 35rem;">
                    <img src="{{ Storage::url($product->image) }}" class="card-img-top" style="height: 75%;" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <span> Publisher : {{ $product->publisher }}</span>
                        <a href="{{ route('product-detail', $product->id) }}" class="btn btn-primary">Go To Detail</a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection()

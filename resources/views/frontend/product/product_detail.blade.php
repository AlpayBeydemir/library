@extends('frontend.index')

@section('content')

<div class="container mt-5">
    <div class="row">

        <div class="col-lg-3">
            <div>
                <img src="{{ Storage::url($product->image) }}" alt="" style="width: 85%;">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="product-detail">
                <h3>{{ $product->name }}</h3>

                @foreach($product->author as $auth)
                    <h6 class="product-author">{{ $auth->name }}</h6>
                @endforeach

                <span>Published By: {{ $product->publisher }} | Publication Year:{{ $product->publication_year }} | Language: {{ $product->language }}</span>

                <p>{{ $product->description }}</p>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    <h5>All Copies In Use</h5>
                    <span>Stock : {{ $product->stock }}</span>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" style="width: 100%" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Borrow from Library
                    </button>
                </div>
            </div>
        </div>


        <!-- Modal Start-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Borrow Menu</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>{{ $product->name }}</h6>
                        <div>
                            <span>For</span>
                            <form action="" method="post">

                                <select class="form-select mt-3" name="borrow_time" id="borrow_time">
                                    <option value="0">7 Days</option>
                                    <option value="1">14 Days</option>
                                    <option value="2">21 Days</option>
                                </select>

                                <select class="form-select mt-3" name="receive_type" id="receive_type">
                                    <option value="0">Get Book From Library</option>
                                    <option value="0">Deliver To Your Address</option>
                                </select>

                                <select class="form-select mt-3" name="address" id="address">
                                    <option value="0">Address 1</option>
                                    <option value="1">Address 2</option>
                                </select>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Borrow</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal End-->

    </div>
</div>

@endsection()

@section('js')
    <script>

    </script>
@endsection()

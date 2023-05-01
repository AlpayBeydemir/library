@extends('admin.index')
@section('admin')

    <div class="main-content">
        <div class="page-content mt-5">
            <div class="container-fluid">

                <form action="{{ route('filter.product') }}" method="post" id="product-filter">
                    @csrf
                    <div class="row" style="margin-bottom: 2rem;">
                        <div class="col-md-3">
                            <label for="authors"> Select Authors </label>
                            <select name="authors" id="authors" class="form-control">
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}"> {{ $author->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="categories"> Select Category </label>
                            <select name="categories" id="categories" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="name"> Product Name </label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="col-md-3 product-filter-btn" style="margin-top: 1.8rem;">
                            <button type="submit" id="product-filter-btn" class="btn btn-outline-success"> Search </button>
                        </div>


                    </div>
                </form>

                <div class="row">

                    <table class="table table-striped table-bordered text-start">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Image</th>
                                    <th>Book Name</th>
                                    <th>Authors</th>
                                    <th>User Name</th>
                                    <th>Status</th>
                                    <th>Delivered Date</th>
                                    <th>Extend Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        @php($i = 1)
                        @foreach($orders as $order)

                                <tbody>
                                    <tr>
                                        <input type="hidden" value="{{ $order->id }}" name="id">
                                        <td>{{ $i++ }}</td>
                                        <td><img src="{{ Storage::url($order->product->image) }}" style="width: 60px; height: 50px;"></td>
                                        <td>{{ $order->product->name }}</td>
                                        <td>
                                            @foreach($order->product->author as $auth)
                                                <li>{{ $auth->name }}</li>
                                            @endforeach
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->delivered == 1 ? 'Delivered' : 'Not Delivered' }}</td>
                                        <td>{{ $order->delivered_date }}</td>
                                        <td>
                                            @if($order->delivered == 0)
                                                <form action="{{ route("AdminExtendTime", $order->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ $order->id }}" name="id">
                                                    <input class="form-control" type="date" name="delivered_date" id="delivered_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime(' + 14 days')) }}" >
                                                    <button type="submit" class="btn btn-success mt-3" id="extend_delivered_date_btn" title="Extend Time" style="width: 100%"> <i class="fa fa-calendar-day"></i> Extend
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->delivered == 0)
                                                <form action="{{ route("AdminReceiveProduct", $order->id) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $order->id }}">
                                                    <button type="submit" class="btn btn-info" id="receive_product" title="Receive The Book"> <i class="fa fa-backward"></i> Receive The Product
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>

                        @endforeach
                    </table>


                </div>

            </div>
        </div>
    </div>


@endsection()

@section('js')

    <script>
        function receiveProduct(id) {
            if (confirm('Are you sure you want to receive this book?')) {
                $.ajax({
                    url: '/receive-product/' + id,
                    type: 'PUT',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        alert('The book has been received.');
                        location.reload();
                    },
                    error: function(response) {
                        alert('An error occurred while receiving the book.');
                    }
                });
            }
        }
    </script>


@endsection


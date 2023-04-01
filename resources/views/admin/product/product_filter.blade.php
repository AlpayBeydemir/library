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
                    <table class="table table-striped table-bordered text-center">
                        <tr>
                            <th>Number</th>
                            <th>Image</th>
                            <th>Book Name</th>
                            <th>Publisher</th>
                            <th>Category</th>
                            <th>Authors</th>
                            <th>Stock</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                        @php($i = 1)
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td><img src="{{ Storage::url($product->image) }}" style="width: 60px; height: 50px;"></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->publisher }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    @foreach($product->author as $auth)
                                        <li>{{ $auth->name }}</li>
                                    @endforeach
                                </td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>{{ $product->updated_at }}</td>
                                <td>
                                    <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info" title="Edit Product"> <i class="fas fa-edit"></i> </a>
                                    <button class="btn btn-danger" title="Delete Product" onclick="deleteProduct({{  $product->id }})"> <i class="fas fa-trash-alt"></i> </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection()

@section('js')

@endsection


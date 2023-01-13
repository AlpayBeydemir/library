@extends('admin.index')
@section('admin')

    <div class="page-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Number</th>
                        <th>Image</th>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    @php($i = 1)
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><img src="{{ asset($product->image) }}" style="width: 60px; height: 50px;"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->author->name }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <a href="{{ route('edit.product', $product->id) }}" class="btn btn-info" title="Edit Product"> <i class="fas fa-edit"></i> </a>
                                <a href="{{ route('delete.author', $product->id) }}" class="btn btn-danger" title="Delete author"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection()



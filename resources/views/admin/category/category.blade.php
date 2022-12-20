@extends('admin.index')
@section('admin')

    <div class="page-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Number</th>
                        <th>Category Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    @php($i = 1)
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->is_active }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <a href="{{ route('edit.category', $category->id) }}" class="btn btn-info" title="Edit Category"> <i class="fas fa-edit"></i> </a>
                                <a href="{{ route('delete.category', $category->id) }}" class="btn btn-danger" title="Delete Category"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection()

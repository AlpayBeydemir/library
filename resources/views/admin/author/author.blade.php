@extends('admin.index')
@section('admin')

    <div class="page-content mt-5">
        <div class="container-fluid">
            <div class="row">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>Number</th>
                        <th>Author Name</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                    @php($i = 1)
                    @foreach($authors as $author)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->is_active }}</td>
                            <td>{{ $author->created_at }}</td>
                            <td>{{ $author->updated_at }}</td>
                            <td>
                                <a href="{{ route('edit.author', $author->id) }}" class="btn btn-info" title="Edit author"> <i class="fas fa-edit"></i> </a>
                                <a href="{{ route('delete.author', $author->id) }}" class="btn btn-danger" title="Delete author"> <i class="fas fa-trash-alt"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection()


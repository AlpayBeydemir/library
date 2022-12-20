@extends('admin.index')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add New Category</h3>
                            </div>
                                <div class="card-body">

                                    <form method="post" action="{{ route('store.category') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" name="name" id="name">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>

                                    </form>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection()

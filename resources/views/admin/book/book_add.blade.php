@extends('admin.index')
@section('admin')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add New Product</h3>
                            </div>
                            <div class="card-body">

                                <form method="post" id="product_store" action="" enctype="multiple">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="author_id" class="form-label">Select Author</label>
                                        <select class="form-select" name="author_id" id="author_id">
                                            <option value=""> Select </option>
                                                @foreach($authors as $author)
                                                    <option value="{{ $author->id }}"> {{ $author->name }} </option>
                                                @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Select Category</label>
                                        <select class="form-select" name="category_id" id="category_id">
                                            <option value=""> Select </option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label"> Book Name </label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="stock" class="form-label"> Stock Number </label>
                                        <input type="number" class="form-control" name="stock" id="stock">
                                    </div>

                                    <div class="mb-3">
                                        <label for="isbn" class="form-label"> ISBN Number </label>
                                        <input type="text" class="form-control" name="isbn" id="isbn">
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label"> Image </label>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>

                                    <button type="button" id="form_submit" class="btn btn-primary">Submit</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#form_submit").click(function () {
                
                $.ajax({
                    url : {{ route('store.product')}},
                    method : 'post',
                    data : new FormData (this)
                });
            })
        });
    </script>

@endsection()


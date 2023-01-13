@extends('admin.index')
@section('admin')



    <div class="page-content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Edit {{ $products->name }} Product</h3>
                            </div>
                            <div class="card-body">

                                <form id="product_update" method="POST" action="{{ route('store.product') }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="author_id" class="form-label"> Select Author </label>
                                        <select class="form-select" name="author_id" id="author_id">
                                            <option value=""> Select </option>
                                            @foreach($authors as $author)
                                                <option value="{{ $author->id }}" {{ $author->id == $products->author_id ? 'selected' : '' }} > {{ $author->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label"> Select Category </label>
                                        <select class="form-select" name="category_id" id="category_id">
                                            <option value=""> Select </option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $products->author_id ? 'selected' : '' }} > {{ $category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label"> Book Name </label>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ $products->name }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label"> Stock Number </label>
                                        <input type="number" class="form-control" name="stock" id="stock" min="0" value="{{ $products->stock }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label"> Image </label>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>

                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-2 col-form-label">  </label>
                                        <div class="col-sm-10">
                                            <img id="showImage" class="rounded avatar-lg" src="{{ Storage::url($products->image) }}" alt="Card image cap">
                                        </div>
                                    </div>

                                    {{--                                    <div id="firstProduct">--}}
                                    {{--                                        <div class="product_isbn">--}}
                                    {{--                                            <div class="mb-3">--}}
                                    {{--                                                <label for="isbn" class="form-label"> ISBN Number </label>--}}
                                    {{--                                                <input type="text" class="form-control" name="isbn[]" id="isbn">--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    {{--                                    <div id="moreProduct">--}}

                                    {{--                                    </div>--}}

                                    {{--                                    <button type="button" class="btn btn-info" onclick="addProduct();"> Add More ISBN Number </button>--}}
                                    {{--                                    <button type="button" class="btn btn-danger" onclick="removeProduct();"> Remove ISBN Number </button>--}}
                                    <br>

                                    <button type="button" id="product_update_btn" class="btn btn-primary mt-3">Submit</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        function addProduct(){
            $("#firstProduct .product_isbn").clone().find("input").val("").end().appendTo("#moreProduct");
        }

        function removeProduct(){
            $("#moreProduct .product_isbn").last().remove();
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function (){

            // var author_id   = $('#author_id').val();
            // var category_id = $('#category_id').val();
            // var name        = $('#name').val();
            // var isbn        = $('#isbn').val();
            // var image       = $('#image').val();

            $('#product_update_btn').click(function (){
                var formData = new FormData();
                var product_update = $('#product_update').serializeArray();
                var file_data = $("#image").prop("files")[0];
                formData.append("image", file_data);

                $.each(product_update, function (key, el){
                    formData.append(el.name, el.value);
                })

                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                $.ajax({
                    url         : "{{ route('update.product') }}",
                    method      : "POST",
                    processData : false,
                    contentType : false,
                    cache       : false,
                    data        : formData,
                    // author_id    : author_id,
                    // category_id  : category_id,
                    // name         : name,
                    // isbn         : isbn,
                    // image        : image,

                    success     : function (data){
                        var result = JSON.parse(data);
                        if (result.error == 1)
                        {
                            toastr.error(result.message);
                        }
                        else
                        {
                            toastr.success(result.message);
                            location.href = result.url;
                        }
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function (){
           $('#image').change(function (e){
              var reader = new FileReader();
              reader.onload = function (e){
                  $('#showImage').attr('src', e.target.result);
              }
              reader.readAsDataURL(e.target.files[0]);
           });
        });
    </script>

@endsection()


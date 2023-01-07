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

                                <form id="product_store" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="author_id" class="form-label"> Select Author </label>
                                        <select class="form-select" name="author_id" id="author_id">
                                            <option value=""> Select </option>
                                                @foreach($authors as $author)
                                                    <option value="{{ $author->id }}"> {{ $author->name }} </option>
                                                @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label"> Select Category </label>
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
                                        <label for="image" class="form-label"> Image </label>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>

                                    <div id="firstProduct">
                                        <div class="product_isbn">
                                            <div class="mb-3">
                                                <label for="isbn" class="form-label"> ISBN Number </label>
                                                <input type="text" class="form-control" name="isbn[]" id="isbn">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="moreProduct">

                                    </div>

                                    <button type="button" class="btn btn-info" onclick="addProduct();"> Add More ISBN Number </button>
                                    <button type="button" class="btn btn-danger" onclick="removeProduct();"> Remove ISBN Number </button>
                                    <br>

                                    <button type="button" id="product_store_btn" class="btn btn-primary mt-3">Submit</button>

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

            $('#product_store_btn').click(function (){
                var formData = new FormData();
                var product_store = $('#product_store').serializeArray();

                $.each(product_store, function (key, el){
                    formData.append(el.name, el.value);
                })

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

               $.ajax({
                   url         : "{{ route('store.product') }}",
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

@endsection()


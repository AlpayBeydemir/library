@extends('admin.index')

@section('styles')

    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        /*Styling preloader*/
        .preloader{
            /*
            Making the preloader floating over other elements.
            The preloader is visible by default.
            */
            /*position: absolute;*/
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1000;
        }
    </style>

@endsection()

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
                                <div class="preloader"><span class="preloader-js"></span></div>
                                <form id="product_store" method="POST" action="{{ route('store.product') }}" enctype="multipart/form-data">
                                    @csrf


                                    <div class="mb-3">
                                        <label for="author_id" class="form-label">Select Author</label>

                                        <select name="author_id[]" id="author_id" class="select2 form-control select2-multiple"
                                                multiple="multiple" data-placeholder="Authors ...">
                                            @foreach($authors as $author)
                                                <option value="{{ $author->id }}"> {{ $author->name }} </option>
                                            @endforeach
                                        </select>

                                    </div>


{{--                                    <div class="mb-3">--}}
{{--                                        <label for="author_id" class="form-label select-label"> Select Author </label>--}}
{{--                                        <select class="form-select" name="author_id[]" id="author_id" multiple>--}}
{{--                                            <option value=""> Select </option>--}}
{{--                                                @foreach($authors as $author)--}}
{{--                                                    <option value="{{ $author->id }}"> {{ $author->name }} </option>--}}
{{--                                                @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}

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
                                        <label for="publisher" class="form-label"> Publisher </label>
                                        <input type="text" class="form-control" name="publisher" id="publisher">
                                    </div>

                                    <div class="mb-3">
                                        <label for="publication_year" class="form-label"> Publication Year </label>
                                        <input type="number" class="form-control" name="publication_year" id="publication_year" min="1900" max="3000">
                                    </div>

                                    <div class="mb-3">
                                        <label for="language" class="form-label"> Language </label>
                                        <input type="text" class="form-control" name="language" id="language">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label"> Stock Number </label>
                                        <input type="number" class="form-control" name="stock" id="stock" min="0">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label"> ISBN Number </label>
                                        <input type="number" class="form-control" name="isbn" id="isbn" min="0">
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label"> Image </label>
                                        <input type="file" class="form-control" name="image" id="image">
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

                                    <button type="button" id="product_store_btn" class="btn btn-primary mt-3">Submit</button>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

{{--    <script type="text/javascript">--}}
{{--        function addProduct(){--}}
{{--            $("#firstProduct .product_isbn").clone().find("input").val("").end().appendTo("#moreProduct");--}}
{{--        }--}}

{{--        function removeProduct(){--}}
{{--            $("#moreProduct .product_isbn").last().remove();--}}
{{--        }--}}
{{--    </script>--}}



@endsection()

@section('js')

    <script>
        //after window is loaded completely
        window.onload = function(){
            //hide the preloader
            document.querySelector(".preloader").style.display = "none";
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function (){

            $('#product_store_btn').click(function (){
                var formData = new FormData();
                var product_store = $('#product_store').serializeArray();
                var file_data = $("#image").prop("files")[0];
                formData.append("image", file_data);

                $.each(product_store, function (key, el){
                    formData.append(el.name, el.value);
                })

                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                $.ajax({
                    url         : "{{ route('store.product') }}",
                    method      : "POST",
                    processData : false,
                    contentType : false,
                    cache       : false,
                    data        : formData,

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

    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>

@endsection()


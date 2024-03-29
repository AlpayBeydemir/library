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

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-header-text">Edit {{ $products->name }} Product</h3>
                                </div>
                                <div class="card-body">
                                    <div class="preloader"><span class="preloader-js"></span></div>

                                    <form id="product_update" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="author_id" class="form-label">Select Author</label>

                                            <select name="author_id[]" id="author_id" class="select2 form-control select2-multiple"
                                                    multiple="multiple" data-placeholder="Authors ...">
                                                @foreach($authors as $author)
                                                    <option {{ $author->selected == 1 ? 'selected' : '' }} value="{{ $author->id }}" > {{ $author->name }} </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label"> Select Category </label>
                                            <select class="form-select" name="category_id" id="category_id">
                                                <option value=""> Select </option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $category->id == $products->category_id ? 'selected' : '' }} > {{ $category->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label"> Book Name </label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $products->name }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label"> Description </label>
                                            <textarea class="form-control" name="description" id="description" cols="10" rows="5">{{ $products->description }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="publisher" class="form-label"> Publisher </label>
                                            <input type="text" class="form-control" name="publisher" id="publisher" value="{{ $products->publisher }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="publication_year" class="form-label"> Publication Year </label>
                                            <input type="number" class="form-control" name="publication_year" id="publication_year" min="1900" max="3000" value="{{ $products->publication_year }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="language" class="form-label"> Language </label>
                                            <input type="text" class="form-control" name="language" id="language" value="{{ $products->language }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label"> Stock Number </label>
                                            <input type="number" class="form-control" name="stock" id="stock" min="0" value="{{ $products->stock }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="name" class="form-label"> ISBN Number </label>
                                            <input type="number" class="form-control" name="isbn" id="isbn" min="0" value="{{ $products->isbn }}">
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

                                        <br>

                                        <button type="button" id="product_update_btn" class="btn btn-success mt-3">Update Product</button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

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
                    url         : "{{ route('update.product', $products->id) }}",
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

    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>

@endsection

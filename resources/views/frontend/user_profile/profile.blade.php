@extends('frontend.index')

@section('content')


    <div class="container mt-5">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Add New Address
                </button>
                <h4>My Information</h4>

                <div class="mt-3">
                    <label class="form-label" for="name">User Name</label>
                    <input class="form-control" type="text" name="name" placeholder="{{ $profile->name }}">
                </div>

                <div class="mt-3">
                    <label class="form-label" for="name">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="{{ $profile->email }}">
                </div>

                <div class="mt-3">
                    <label class="form-label" for="name">My Addresses</label>
                    @foreach($profile->user_address as $address)
                        <input class="form-control mt-3" type="text" name="address" placeholder="{{ $address->address }}" style="width: 75%;">
                        <a href="{{ route('delete.address', $address->id) }}" class="btn btn-danger" style="float: right;" title="Delete Category"> <i class="fas fa-trash-alt"></i> </a>
                    @endforeach
                </div>


                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Address</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="add_address">
                                @csrf
                            <div class="modal-body">

                                    <label for="address_name">Address Name</label>
                                    <input type="text" class="form-control" name="address_name" id="address_name">

                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="save_address_btn" class="btn btn-primary">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

@endsection()

@section('js')

    <script type="text/javascript">
        $(document).ready(function (){

            $('#save_address_btn').click(function (){
                var formData = new FormData();
                var product_store = $('#add_address').serializeArray();

                $.each(product_store, function (key, el){
                    formData.append(el.name, el.value);
                })

                $.ajax({
                    url         : "{{ route('add_address') }}",
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

@endsection()

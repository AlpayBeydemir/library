@extends('frontend.index')

@section('content')

    <div class="container mt-5">

        <div class="row d-flex justify-content-center align-items-center" id="profile-info-div">
            <div class="col-lg-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" style="float: right;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Add New Address
                </button>
                <h4>My Information</h4>

                <form action="{{ route('UpdateProfile') }}" method="post" id="UpdateProfileForm">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                    <div class="mt-3">
                        <label class="form-label" for="name">User Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $profile->name }}">
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="name">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{ $profile->email }}">
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-outline-success" id="update_profile_btn" onclick="UpdateProfile()">Update</button>
                    </div>
                </form>


                <div class="mt-3">
                    <label class="form-label" for="name">My Addresses</label>
                    @foreach($profile->user_address as $address)
                        <div class="user-profile-address mt-3">
                            <input class="form-control" type="text" name="address" placeholder="{{ $address->address }}" style="width: 75%;">
                            <a href="{{ route('delete.address', $address->id) }}" class="btn btn-danger" style="float: right;" title="Delete Category"> <i class="fas fa-trash-alt"></i> </a>
                        </div>
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
                            <form action="{{ route('add_address') }}" method="post" id="add_address">
                                @csrf
                            <div class="modal-body">

                                    <label for="address_name">Address Name</label>
                                    <input type="text" class="form-control mb-3" name="address_name" id="address_name">

                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="save_address_btn" onclick="SaveAddress()" class="btn btn-primary">Save</button>
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

    <script>
        function SaveAddress(){
            AjaxPost('add_address');
        }
    </script>

    <script>
        function UpdateProfile(){
            AjaxPost('UpdateProfileForm', 'profile-info-div');
        }
    </script>

@endsection()

@extends('frontend.index')

@section('content')


    <div class="container mt-5">

        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6">
                <h4>My Information</h4>
                <div class="mt-3">
                    <label class="form-label" for="name">User Name</label>
                    <input class="form-control" type="text" name="name" placeholder="{{ $profile->name }}">
                </div>

                <div class="mt-3">
                    <label class="form-label" for="name">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="{{ $profile->email }}">
                </div>


            </div>
        </div>

    </div>

@endsection()

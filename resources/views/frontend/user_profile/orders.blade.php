@extends('frontend.index')

@section('content')

    <div class="container">

        <div class="order-head">
            <h4>My Orders</h4>
        </div>

        @foreach($userProducts as $userProduct)
            <div class="row order-row">
                <div class="col-lg-12 col-md-12 order-card">
                    <img src="{{ Storage::url($userProduct->product->image) }}" alt="" style="width: 15%; margin-left: -12px;">

                    <div class="product-name">
                        <h5>Product Name</h5>
                        <span>{{ $userProduct->product->name }}</span>
                    </div>

                    <div class="issued-date">
                        <h5>Issued Date</h5>
                        <span>{{ $userProduct->issued_date }}</span>
                    </div>

                    <div class="delivered-date">
                        <h5>Delivered Date</h5>
                        <span>{{ $userProduct->delivered_date }}</span>
                    </div>

                    <div class="application-number">
                        <h5>Application Number</h5>
                        <span>{{ $userProduct->application_number }}</span>
                    </div>

                    <div class="extend_time_form">
                        <form action="{{ route('extend.time', $userProduct->id) }}" method="post" id="extend_time">
                            @csrf
                            <div>
                                <input class="form-control" type="date" name="delivered_date" id="delivered_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime(' + 14 days')) }}" >
                            </div>

                            <div class="extend-btn">
                                <button type="button" value="{{ $userProduct->id }}" id="extend_delivered_date_btn" onclick="ExtendTime()" class="btn btn-primary">Extend Delivered Date</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach()

    </div>

@endsection()

@section('js')

    <script>
        function ExtendTime(){
            AjaxPost('extend_time');
        }
    </script>

@endsection()

@extends('frontend.index')

@section('content')

    <div class="container">

        <div class="order-head">
            <h4>My Orders</h4>
        </div>

        @foreach($userProducts as $userProduct)
            <div class="row order-row">
                <div class="col-lg-12 col-md-12 order-card">
                    <img src="{{ Storage::url($userProduct->image) }}" alt="" style="width: 15%; margin-left: -12px;">

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

                    <form id="extend_time">
                        @csrf
                        <div class="extend-btn">
                            <button type="button" value="{{ $userProduct->id }}" id="extend_delivered_date_btn" class="btn btn-primary">Extend Delivered Date</button>
                        </div>
                    </form>

                </div>
            </div>
        @endforeach()

    </div>

@endsection()

@section('js')

    <script type="text/javascript">
        $(document).ready(function (){

            $('#extend_delivered_date_btn').click(function (){

                var formData = new FormData();
                var extend_time = $('#extend_time').serializeArray();

                $.each(extend_time, function (key, el){
                    formData.append(el.name, el.value);
                })

                $.ajax({
                    url         : "{{ route('extend.time', $userProduct->id) }}",
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

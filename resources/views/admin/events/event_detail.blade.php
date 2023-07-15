@extends('admin.index')

@section('styles')

    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/custom.css') }}" rel="stylesheet" type="text/css">

@endsection()

@section('admin')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-10" style="display: flex; flex-direction: row; justify-content: center; align-items: center;">
                            <div class="col-lg-5 col-md-5">
                                @if($files)
                                    @foreach($files as $file)
                                        <div>
                                            <img src="{{ Storage::url($file->file) }}" alt="" style="width: 60%;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-header-text">{{ $event->name }}</h3>
                                        <div class="event-count" style="float: right;">
                                            @if($count && $count > 0)
                                                <span>Bu etkinliğe <strong>{{ $count }}</strong> kişi katılıyor.</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="card-body" style="display: flex; flex-direction: row; justify-content: space-between;">
                                        <div>
                                            <div>
                                                <label for="">Address : </label>
                                                <span>{{ $event->address }}</span>
                                            </div>
                                            <span>{{ $event->explanation }}</span>
                                        </div>
                                        <div style="float: right; color: purple;">
                                            <span>{{ $event->selected_time }}</span>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="participants">
                                            <h4>Participants</h4>
                                            @foreach($participants as $participant)
                                                <ul>
                                                    <li class="card participant-card">
                                                        <div>
                                                            <label for="" class="event-participant-label">Name Surname: </label>
                                                            <span>{{ $participant->user->name }}</span>
                                                        </div>
                                                        <div>
                                                            <label for="" class="event-participant-label">Email Address: </label>
                                                            <span>{{ $participant->user->email }}</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </div>
                                    </div>

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
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function (){

            $('#event_store_btn').click(function (){
                var formData = new FormData();
                var event_store = $('#event_store_form').serializeArray();
                var totalFiles = document.getElementById('files').files.length;
                for (var index = 0; index < totalFiles; index++)
                {
                    formData.append("files[]", document.getElementById('files').files[index]);
                }

                $.each(event_store, function (key, el){
                    formData.append(el.name, el.value);
                })

                $.ajax({
                    url         : "{{ route('store.event') }}",
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

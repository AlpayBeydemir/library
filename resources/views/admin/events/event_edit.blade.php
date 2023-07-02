@extends('admin.index')

@section('styles')

    <link href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        .avatar-lg {
             height: unset !important;
             width: unset !important;
        }
    </style>
@endsection()

@section('admin')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-10">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-header-text">Update New Event</h3>
                                </div>
                                <div class="card-body">
                                    <form id="event_edit_form" method="POST" action="{{ route('update.event', $event->id) }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="name" class="form-label"> Event Name </label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $event->name }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="explanation" class="form-label"> Explanation </label>
                                            <textarea class="form-control" name="explanation" id="explanation" cols="10" rows="5">{{ $event->explanation }}</textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label"> Address </label>
                                            <input type="text" class="form-control" name="address" id="address" value="{{ $event->address }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="selected_time" class="col-sm-2 col-form-label">Date and time</label>
                                            <input class="form-control" name="selected_time" id="selected_time" min="{{ date('Y-m-d H:i:s') }}" type="datetime-local" value="{{ $event->selected_time }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="files" class="form-label"> Image </label>
                                            <input type="file" class="form-control" name="files[]" id="files" multiple>
                                        </div>

                                        <div class="row mb-3" style="display: flex; flex-direction: row;">
                                            @foreach($file as $dosya)
                                                <img id="showImage" class="rounded avatar-lg" src="{{ Storage::url($dosya->file) }}">
                                            @endforeach
                                        </div>

                                        <button type="button" id="event_update_btn" class="btn btn-primary mt-3">Submit</button>

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
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function (){

            $('#event_update_btn').click(function (){
                var formData = new FormData();
                var event_update = $('#event_edit_form').serializeArray();
                var totalFiles = document.getElementById('files').files.length;
                for (var index = 0; index < totalFiles; index++)
                {
                    formData.append("files[]", document.getElementById('files').files[index]);
                }

                $.each(event_update, function (key, el){
                    formData.append(el.name, el.value);
                })

                $.ajax({
                    url         : "{{ route('update.event', $event->id) }}",
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
            $('#files').change(function (e){
                var reader = new FileReader();
                reader.onload = function (e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>

@endsection()

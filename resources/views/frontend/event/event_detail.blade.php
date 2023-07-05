@extends('frontend.index')

@section('content')

    <div class="container mt-5">
        <div class="row">

            <div class="col-lg-6 col-md-6">
                @if($files)
                    @foreach($files as $file)
                        <div>
                            <img src="{{ Storage::url($file->file) }}" alt="" style="width: 60%;">
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="col-lg-6 col-md-6">
                <h4>Event Details</h4>
                <div class="card">
                    <div class="card-header">
                        <span>{{ $event->name }}</span>
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

                            <form action="{{ route('JoinEvent') }}" method="post" id="JoinEventForm">
                                @csrf
                                <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                                <input type="hidden" name="user_id" id="user_id" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" type="button" id="join_event_btn">Join The Event!</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection()

@section('js')

    <script type="text/javascript">
        $(document).ready(function (){
            $('#join_event_btn').click(function (){
                var formData = new FormData();
                var join_event = $('#JoinEventForm').serializeArray();

                $.each(join_event, function (key, el){
                    formData.append(el.name, el.value);
                })

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you joining the event?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Yes, I'm Joining",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed){
                        $.ajax({
                            url         : "{{ route('JoinEvent') }}",
                            method      : "POST",
                            processData : false,
                            contentType : false,
                            cache       : false,
                            data        : formData,

                            success     : function (data){
                                var result = JSON.parse(data);
                                console.log(result);
                                if (result.error == 1)
                                {
                                    // toastr.error(result.message);
                                    swalWithBootstrapButtons.fire(
                                        'Nooo!',
                                        'Oopps A problem appeared.',
                                        result.message,
                                        'error'
                                    )
                                }
                                else
                                {
                                    swalWithBootstrapButtons.fire(
                                        'GREAT!',
                                        result.message,
                                        'success'
                                    )
                                    // toastr.success(result.message);
                                    // location.href = result.url;
                                }
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel){
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                        )
                    }
                })

            });
        });
    </script>

@endsection()

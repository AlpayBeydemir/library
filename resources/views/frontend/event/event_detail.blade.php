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
                            <br>
                            <span style="color: green"><bold>Registered Successfully!</bold></span>
                        </div>
                        <div style="float: right; color: purple;">
                            <span>{{ $event->selected_time }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('JoinEvent') }}" method="post" id="JoinEventForm">
                            @csrf
                            <input type="hidden" name="event_id" id="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                            <div class="d-grid gap-2">
                            @if(isset($event_participants) && !empty($event_participants) && $event_participants->status == 1)
                                <input type="hidden" name="cancel_participants" id="cancel_participants" value="cancel">
                                <button class="btn btn-danger" type="button" id="join_event_btn">Cancel it</button>
                            @else
                                <button class="btn btn-success" type="button" id="join_event_btn">Join The Event!</button>
                            @endif
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
                // var hasCancelParticipants = true;
                console.log(join_event);

                $.each(join_event, function (key, el){
                    formData.append(el.name, el.value);
                })
                var hasCancelParticipants = $('#cancel_participants').length > 0;
                console.log(hasCancelParticipants);

                if (hasCancelParticipants) {
                    // 'cancel_participants' gizli inputu bulundu
                    var cancelParticipantsValue = $('#cancel_participants').val();
                    if (cancelParticipantsValue === '') {
                        console.log('cancel_participants boş');
                    } else {
                        console.log('cancel_participants dolu: ' + cancelParticipantsValue);
                    }
                } else {
                    // 'cancel_participants' gizli inputu bulunamadı
                    console.log('cancel_participants bulunamadı');
                }

                console.log(hasCancelParticipants);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: hasCancelParticipants ? "Would You Like To Cancel It ?" : "Are you joining the event?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: hasCancelParticipants ? "Cancel It" : "Yes, I'm Joining",
                    cancelButtonText: hasCancelParticipants ? "Close" : "No, cancel!",
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
                            datatype    : 'html',

                            success     : function (data){
                                console.log(data);
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
                                    );
                                    // toastr.success(result.message);
                                    // location.href = result.url;
                                }
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel){
                        swalWithBootstrapButtons.fire(
                            hasCancelParticipants ? "Closed" : 'Cancelled',
                        )
                    }
                })
            });
        });
    </script>

@endsection()

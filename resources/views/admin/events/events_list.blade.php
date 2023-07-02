@extends('admin.index')

@section('styles')
    <link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
@endsection()

@section('admin')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Events</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h3 class="card-title">Events List</h3>

                                <table id="datatable" class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Explanation</th>
                                        <th>Address</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php($i = 1)
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $event->name }}</td>
                                            <td>{{ substr($event->explanation,0,20) }}</td>
                                            <td>{{ $event->address }}</td>
                                            <td>{{ $event->selected_time }}</td>
                                            <td>
                                                <a href="{{ route('edit.event', $event->id) }}" class="btn btn-info" title="Edit Event"> <i class="fas fa-edit"></i> </a>
                                                <a href="{{ route('delete.event', $event->id) }}" class="btn btn-danger" title="Delete Event"> <i class="fas fa-trash-alt"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        </div>
    </div>

@endsection()

@section('js')

    <!-- Buttons examples -->
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('backend/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <script>
        $('#datatable').DataTable();
    </script>

@endsection()

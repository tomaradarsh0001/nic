@extends('layouts.app')
@section('title', 'MIS User Action Logs Details')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        .pagination .active a {
            color: #ffffff !important;
        }
    </style>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">MIS</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">User Action Activity Logs</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-2">
					<div class="form-group">
						<label for="date" class="form-label">Enter from date</label>
						<input type="date" name="start_date" id="start_date" placeholder="Start Date" class="form-control" />
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="dateEnd" class="form-label">Enter to date</label>
						<input type="date" name="end_date" id="end_date" placeholder="End Date" class="form-control" />
					</div>
				</div>
				<div class="col-md-1 align-self-end">
					<div class="form-group">
				        <button id="filter" class="btn btn-primary">Filter</button>
					</div>
				</div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered data-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>User Name</th>
                            <th>Module Name</th>
                            <th>Action Name</th>
                            <th>Action Url</th>
                            <th>Action Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footerScript')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/moment.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('actionLogListings') }}",
                    data: function(d) {
                        //   d.email = $('.searchEmail').val(),
                        d.search = $('input[type="search"]').val(),
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'module_name',
                        name: 'module_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row, meta) {
                            return moment(data).format('DD/MM/YYYY HH:mm:ss');
                        }
                    },
                    //   {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            $('#filter').click(function() {
                table.draw();
            });
            // $(".searchEmail").keyup(function() {
            //     table.draw();
            // });
        });
    </script>
@endsection
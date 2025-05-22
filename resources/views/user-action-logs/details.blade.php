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
        <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">

                <form id="search-form">
                    <div class="d-flex pb-4 gap-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="serach" id="serach"
                                    placeholder="search by action Or description" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="date" name="date" id="date" placeholder="Date"
                                    class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="submit" value="Search" class="btn btn-primary" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>User Name</th>
                            <th>Module Name</th>
                            <th>Action Name</th>
                            <th>Action Url</th>
                            <th>Action Date & Time</th>
                            {{-- <th>Action Date</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @include('user-action-logs.pagination_child')
                    </tbody>
                </table>
                <input type="hidden" name="hidden_page" id="hidden_page" value="1" />

            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script>
        $(document).ready(function() {
            const fetch_data = (page, seach_term, date) => {
                if (seach_term === undefined) {
                    seach_term = "";
                }
                if (date === undefined) {
                    date = "";
                }
                $.ajax({
                    url: "/user-actions-logs?page=" + page + "&seach_term=" + seach_term + "&date=" +
                        date,
                    success: function(data) {
                        $('tbody').html('');
                        $('tbody').html(data);
                    }
                })
            }

            $('body').on('submit', '#search-form', function(e) {
                event.preventDefault();
                var seach_term = $('#serach').val();
                var date = $('#date').val();
                var page = $('#hidden_page').val();
                fetch_data(page, seach_term, date);
            });

            $('body').on('click', '.pager a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                $('#hidden_page').val(page);
                var seach_term = $('#serach').val();
                var date = $('#date').val();
                fetch_data(page, seach_term, date);
            });
        });
    </script>

    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection

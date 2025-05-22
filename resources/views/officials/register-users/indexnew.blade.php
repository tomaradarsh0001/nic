@extends('layouts.app')

@section('title', 'MIS Form Details')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<style>
	.pagination .active a {
		color: #ffffff !important;

	}
</style>
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
	<div class="breadcrumb-title pe-3">Registrations</div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Registration Applications List</li>
			</ol>
		</nav>
	</div>
	<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>

<div class="card">
	<div class="card-body">
		<div class="pb-4">
		<form id="search-form">
			<div class="d-flex gap-3">
				<div class="col-md-2">
					<div class="d-flex flex-column">
						<div class="form-group">
							<label for="date" class="form-label">Filter By Status</label>
							<select class="form-control" name="status" id="status">
								<option value="">Select status</option>
							   @foreach($items as $item)
							   <option class="text-capitalize" value="{{ $item->id }}">{{ $item->item_name }}</option>
							   @endforeach
							</select>
						</div>
						
					</div>
				</div>
				<div class="col-md-1 align-self-end">
					<div class="form-group">
						<input type="submit" id="filterSearch" name="submit" value="Search" class="btn btn-primary" />
					</div>
				</div>
				
				
			</div>
			<span class="text-danger" id="filterErrorMsg"></span>
		</form>
	</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
					
						<th>Serial No.</th>
						<th>Registration No.</th>
                        <th>Name</th>
                        <th>Property Details</th>
                        <th>Registration Type</th>
                        <th>Purpose Of Registration</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th>Remarks</th>
                        {{-- <th>Assigned By</th>
                        <th>Assigned To</th> --}}
                        <th>Action</th>
					</tr>
				</thead>
				<tbody>
					@include('officials.register-users.pagination_child')
				</tbody>
			</table>
			<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

		</div>
	</div>
</div>
<div id="tooltip"></div>
@endsection


@section('footerScript')
<script>
	$(document).ready(function () {
		const fetch_data = (page, status) => {
			if (status === undefined) {
				status = "";
			}
			$.ajax({
				url: "/register/users?page=" + page + "&status=" + status,
				success: function (data) {
					$('tbody').html('');
					$('tbody').html(data);
				}
			})
		}

		$('#filterSearch').on('click',function(event){
			event.preventDefault();
			var status = $('#status').val();
			var filterErrorMsg = $('#filterErrorMsg');
			if(status == '' ){
				filterErrorMsg.show();
				filterErrorMsg.html('Please select status')
			} else{
				filterErrorMsg.html('')
				filterErrorMsg.hide();
				var page = $('#hidden_page').val();
				fetch_data(page, status);
			}
			
		})

		// Tooltip for View Docs

		$(document).ready(function(){
    var tooltip = $('#tooltip');

    $('.view-more').hover(function(e) {
        var tooltipText = $(this).attr('data-tooltip');
        tooltip.text(tooltipText);
        tooltip.css({
            top: e.pageY + 10 + 'px',
            left: e.pageX + 10 + 'px',
            display: 'block'
        });
    }, function() {
        tooltip.hide();
    });

    $('.view-more').mousemove(function(e) {
        tooltip.css({
            top: e.pageY + 10 + 'px',
            left: e.pageX + 10 + 'px'
        });
    });
});

// End

		// $('body').on('submit', '#search-form', function(e) {
		// 	event.preventDefault();
		// 	var status = $('#status').val();
		// 	var page = $('#hidden_page').val();
		// 	fetch_data(page, status);
		// });

		$('body').on('click', '.pager a', function(event) {
			event.preventDefault();
			var page = $(this).attr('href').split('page=')[1];
			$('#hidden_page').val(page);
			var status = $('#status').val();
			fetch_data(page, status);
		});
	});
</script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
	$(document).ready(function() {
		var table = $('#example2').DataTable({
			lengthChange: false,
			buttons: ['copy', 'excel', 'pdf', 'print']
		});

		table.buttons().container()
			.appendTo('#example2_wrapper .col-md-6:eq(0)');
	});
</script>

@endsection
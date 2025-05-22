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
	<div class="breadcrumb-title pe-3">MIS</div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">MIS</li>
			</ol>
		</nav>
	</div>
	<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>

<hr>

<div class="card">
	<div class="card-body">
		<form id="search-form">
			<div class="d-flex pb-4 gap-3">

				<div class="col-md-2">
					<div class="form-group">
						<label for="serach" class="form-label">Enter property id</label>
						<input type="text" name="serach" id="serach" placeholder="search by property id"
							class="form-control" />
							<span id="propertyIdError" class="text-danger" style="position: absolute;"></span>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="date" class="form-label">Enter from date</label>
						<input type="date" name="date" id="date" placeholder="Start Date" class="form-control" />
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="dateEnd" class="form-label">Enter to date</label>
						<input type="date" name="dateEnd" id="dateEnd" placeholder="End Date" class="form-control" />
					</div>
				</div>
				<div class="col-md-1 align-self-end">
					<div class="form-group">
						<input type="submit" name="submit" value="Search" class="btn btn-primary" />
					</div>
				</div>
				<div class="d-flex gap-3 justify-content-end">
					@haspermission('export.data')


					<div class="col-md-6">
						<div class="form-group">

							<label for="dateEnd" class="form-label">Select colony</label>
							<select class="form-select" name="old_colony_name" id="ColonyNameOld"
								aria-label="Default select example">
								<option value="">Select Colony</option>
								@foreach($colonyList as $colony)
									<option value="{{ $colony->id}}">{{$colony->name}}</option>
								@endforeach

							</select>
						</div>
					</div>


					<!-- <form method="post" action="{{route('detailsExport')}}">
					@csrf
					<input type="hidden" name="format" value="csv">
					<button type="submit" id="exportBtn" class="btn btn-primary px-5 filter-btn" data-export-format="csv">Export CSV</button>
				</form> -->
					<div class="col-md-6 align-self-end">
						<div class="form-group">
							<button type="button" id="exportBtn" name="exportBtn"
								class="btn btn-primary px-3 filter-btn export-btn" data-export-format="csv">Export
								CSV</button>
						</div>
					</div>
					@endhaspermission
				</div>
			</div>
		</form>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Property Id</th>
						<th>Is Problematic?</th>
						<th>File Number</th>
						<th>Joint Properties</th>
						<th>Property Type</th>
						<th>Property SubType</th>
						<th>Property Status</th>
						<th>Section</th>
						<th>Address</th>
						<th>Premium (₹)</th>
						<th>Ground Rent (₹)</th>
						<th>Area</th>
						<th>Username</th>
						<th>Created At</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@include('mis.pagination_child')
				</tbody>
			</table>
			<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

		</div>
	</div>
</div>

@endsection


@section('footerScript')
<script>
	$(document).ready(function () {
		const fetch_data = (page, seach_term, date, dateEnd) => {
			if (seach_term === undefined) {
				seach_term = "";
			}
			if (date === undefined) {
				date = "";
			}
			if (dateEnd === undefined) {
				dateEnd = "";
			}
			$.ajax({
				url: "{{ route('propertDetails')}}" + "?page=" + page + "&seach_term=" + seach_term + "&date=" + date + "&dateEnd=" + dateEnd,
				success: function (data) {
					$('tbody').html('');
					$('tbody').html(data);
				}
			})
		}

		// $('body').on('submit', '#search-form', function (e) {
		// 	event.preventDefault();
		// 	var seach_term = $('#serach').val();
		// 	var date = $('#date').val();
		// 	var dateEnd = $('#dateEnd').val();
		// 	var page = $('#hidden_page').val();
		// 	fetch_data(page, seach_term, date, dateEnd);
		// });


		$('body').on('submit', '#search-form', function(e) {
			event.preventDefault();
			var search_term = $('#serach').val();
			var date = $('#date').val();
			var dateEnd = $('#dateEnd').val();
			var page = $('#hidden_page').val();
			if(search_term){
				$.ajax({
						url: "{{ route('isMisPropertyAvailable') }}",
						type: "POST",
						dataType: "JSON",
						data: {
							search_term: search_term,
							_token: '{{ csrf_token() }}'
						},
						success: function(response) {
							if(response.status){
								fetch_data(page, search_term, date,dateEnd);
								$('#propertyIdError').html('')
							} else {
								fetch_data(page, search_term, date,dateEnd);
								$('#propertyIdError').html(response.message)
							}
						},
						error: function(response) {
							console.log(response);
						}
					})
			}

		});



		$('body').on('click', '.pager a', function (event) {
			event.preventDefault();
			var page = $(this).attr('href').split('page=')[1];
			$('#hidden_page').val(page);
			var seach_term = $('#serach').val();
			var date = $('#date').val();
			var dateEnd = $('#dateEnd').val();
			fetch_data(page, seach_term, date, dateEnd);
		});
	});
</script>

<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script>
	$(document).ready(function () {
		var table = $('#example2').DataTable({
			lengthChange: false,
			buttons: ['copy', 'excel', 'pdf', 'print']
		});

		table.buttons().container()
			.appendTo('#example2_wrapper .col-md-6:eq(0)');
	});
</script>
<script>

	$('.export-btn').click(function () {
		var button = $('.export-btn');
		button.prop('disabled', true).html('LOADING...');

		const filters = {};
		let exportFormat = $(this).data('export-format');
		const val = $("#serach").val();
		const colonyNameOld = $("#ColonyNameOld").val();
		if (colonyNameOld != '') {

			if (val != filters.colonyNameOld)
				filters.colonyNameOld = colonyNameOld;
		} else {
			delete filters.colonyNameOld;
		}
		if (val != '') {
			if (val != filters.propId)
				filters.propId = val;
		} else {
			delete filters.propId;
		}

		const val2 = $("#date").val();
		if (val2 != '') {
			if (val2 != filters.date)
				filters.date = val2;
		} else {
			delete filters.date;
		}


		const val3 = $("#dateEnd").val();
		if (val3 != '') {
			if (val3 != filters.dateEnd)
				filters.dateEnd = val3;
		} else {
			delete filters.dateEnd;
		}


		$.ajax({
			type: "post",
			url: '{{route("detailsExport")}}',
			data: {
				_token: "{{csrf_token()}}",
				format: exportFormat,
				filters: filters
			},
			xhrFields: {
				responseType: 'blob' // Important
			},
			success: response => {
				// Create a blob object from the response
				button.prop('disabled', false).html('Export CSV');

				var blob = new Blob([response], {
					type: (exportFormat == 'xls' || exportFormat == 'csv') ? "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" : "application/pdf",
				});
				var url = window.URL.createObjectURL(blob);

				// Create a temporary anchor element
				var downloadLink = document.createElement('a');
				downloadLink.href = url;
				downloadLink.download = 'report.' + exportFormat; // Provide a filename here
				document.body.appendChild(downloadLink);
				downloadLink.click();

				// Cleanup
				window.URL.revokeObjectURL(url);
				document.body.removeChild(downloadLink);
			},
			error: function (xhr, status, error) {
				console.error(error)
			}
		})
	});
</script>
@endsection

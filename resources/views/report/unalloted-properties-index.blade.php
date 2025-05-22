@extends('layouts.app')

@section('title', 'Unalloted Property Listings')

@section('content')

    <style>
        div.dt-buttons {
            float: none !important;
            width: 19%;
        }

        div.dt-buttons.btn-group {
            margin-bottom: 20px;
        }

        div.dt-buttons.btn-group .btn {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* Ensure responsiveness on smaller screens */
        @media (max-width: 768px) {
            div.dt-buttons.btn-group {
                flex-direction: column;
                align-items: flex-start;
            }

            div.dt-buttons.btn-group .btn {
                width: 100%;
                text-align: left;
            }
        }
    </style>
    <!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Reports</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Report of Unallotted Properties</li>
            </ol>
        </nav>
    </div>
    <!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->
</div>
<!--breadcrumb-->
<!--end breadcrumb-->


    <div class="card mx-3 mb-5">
        <div class="card-body ">
            <div class="d-flex justify-content-between py-3">
                <h6 class="mb-0 text-uppercase tabular-record_font align-self-end"></h6>
            </div>
			<div class="table-responsive mt-2">
				<table id="example" class="display nowrap" style="width:100%">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Property Id</th>
							<th>Land Type</th>
							<th>Colony Name</th>
							<th>Do property documents<br>exist?</th>
							<th>Area (In Sqm.)</th>
							<th>Is Vaccant?</th>
							<th>Is it under the custodianship <br>of any other department?</th>
							<th>Is Encroachment?</th>
							<th>Is there any litigation?</th>
						</tr>
					</thead>
				</table>
			</div>
        </div>
    </div>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="colonyNameModal" tabindex="-1" aria-labelledby="colonyNameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="colonyNameModalLabel">Full Colony Name</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="fullColonyName"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footerScript')
    <script type="text/javascript">
       $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: false,
            ajax: {
                url: "{{ route('getUnallotedProperties') }}",
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'unique_propert_id', name: 'unique_propert_id' },
                { data: 'landType', name: 'landType' },
                {
                    data: 'colonyName',
                    name: 'colonyName',
                    render: function(data, type, row) {
                        if (type === 'display') {
                            const truncated = data.length > 20 ? data.substring(0, 20) + '...' : data;
                            return `<a href="#" class="view-colony" data-full="${data}" title="Click to see full colony Name">${truncated}</a>`;
                        }
                        return data;
                    }
                },
                { data: 'is_property_document_exist', name: 'is_property_document_exist' },
                { data: 'plot_area_in_sqm', name: 'plot_area_in_sqm' },
                { data: 'is_vaccant', name: 'is_vaccant' },
                { data: 'is_transferred', name: 'is_transferred' },
                { data: 'is_encrached', name: 'is_encrached' },
                { data: 'is_litigation', name: 'is_litigation' },
            ],
            dom: '<"top"Blf>rt<"bottom"ip><"clear">', // Custom DOM for button and pagination positioning
            buttons: [
                'csv', 'excel', 'pdf'
            ],
        });

        // Event delegation to handle clicks on dynamically generated links
        $('#example').on('click', '.view-colony', function(e) {
            e.preventDefault();
            const fullColonyName = $(this).data('full');
            $('#fullColonyName').text(fullColonyName);
            $('#colonyNameModal').modal('show');
        });
    });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'All Property Details')

@section('content') 
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary" onclick="printSection('sectionToPrint')">Print Property Data</button>
    </div>
    <div id="sectionToPrint">
            <div class="col pt-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-0 text-uppercase tabular-record_font pb-4">summary of properties</h6>
                        
                        <!-- <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties	<span class="badge bg-primary rounded-pill">{{$tabularRecord[2]}}</span>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties (nazul)	<span class="badge bg-primary rounded-pill">{{$tabularRecord[0]}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties (rehabilitation)	<span class="badge bg-primary rounded-pill">{{$tabularRecord[1]}}</span>
                            </li>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties (freehold)	<span class="badge bg-primary rounded-pill">{{$tabularRecord[4]}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties (Leasehold)	<span class="badge bg-primary rounded-pill">{{$tabularRecord[5]}}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-capitalize tabular-record_font">Total properties (freehold + Leasehold )	<span class="badge bg-primary rounded-pill">{{$tabularRecord[3]}}</span>
                            </li>
                        </ul> -->


                        <table class="table mb-0">
                                    <thead>
										<tr>
											<th scope="col">Title</th>
											<th scope="col">Old Values</th>
											<th scope="col">Revalidated</th>
										</tr>
									</thead>
									<tbody>
										<tr class="">
											<th scope="row">Total properties</th>
											<td>60063</td>
											<td>{{$tabularRecord[2]}}</td>
										</tr>
										<tr class="">
											<th scope="row">Total properties (nazul)</th>
											<td>5424</td>
											<td>{{$tabularRecord[0]}}</td>
										</tr>
										<tr class="">
											<th scope="row">Total properties (rehabilitation)</th>
											<td>54639</td>
											<td>{{$tabularRecord[1]}}</td>
										</tr>
										<tr class="">
											<th scope="row">Total properties (freehold)</th>
											<td>30167</td>
											<td>{{$tabularRecord[4]}}</td>
										</tr>
										<tr class="">
											<th scope="row">Total properties (Leasehold)</th>
											<td></td>
											<td>{{$tabularRecord[5]}}</td>
										</tr>
										<tr class="">
											<th scope="row">Total properties (freehold + Leasehold )</th>
											<td>62008</td>
											<td>{{$tabularRecord[3]}}</td>
										</tr>
									</tbody>
								</table>
                    </div>
                </div>
            </div>
        
            <div class="col pt-2 pb-5">
                <div class="card">
							<div class="card-body">
                            <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Section-wise breakup of all</h6>
								<table class="table mb-0">
									<thead>
										<tr>
											<th scope="col">S. No.</th>
											<th scope="col">Section</th>
											<th scope="col">Total Properties (X)</th>
											<th scope="col">History Entered (Y)</th>
											<th scope="col">Fully Completed</th>
											<th scope="col">History Pending (X-Y)</th>
											<th scope="col">Revalidated</th>
										</tr>
									</thead>
									<tbody>
                                        <?php
                                            $totalProperties = 0;
                                            $totalPropertiesCompleted = 0;
                                        ?>
                                        @foreach($tabularRecord[6] as $key => $tabularData)
										<tr>
											<th scope="row">{{$key+1}}</th>
											<td>{{$tabularData['section']}}</td>
											<td>{{$tabularData['total_properties']}}</td>
											<td>{{$tabularData['history_entered']}}</td>
											<td>{{$tabularData['fully_completed']}}</td>
											<td>{{$tabularData['history_pending']}}</td>
											<td>{{$tabularData['completed_properties']}}</td>
										</tr>
                                        <?php
                                        $totalProperties = $totalProperties + (int)$tabularData['total_properties'];
                                        $totalPropertiesCompleted = $totalPropertiesCompleted + (int)$tabularData['completed_properties'];
                                        ?>
										@endforeach
                                        <tr>
											<th colspan="2" scope="row">Total</th>
											<th>{{$totalProperties}}</th>
                                            <th>51794</th>
                                            <th>33889</th>
                                            <th>10214</th>
											<th>{{$totalPropertiesCompleted}}</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
            </div>
    </div>



    <script>
        function printSection(sectionId) {
            var printContent = document.getElementById(sectionId).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
			window.location.reload();
        }

        document.addEventListener("keydown", function(event) {
        // Check if Ctrl + P is pressed
        if (event.ctrlKey && event.key === "p") {
            // Call the print function with the section id you want to print
            printSection("sectionToPrint"); // Replace "sectionId" with the ID of the section you want to print
            event.preventDefault(); // Prevent the default print dialog from appearing
        }
    });
    </script>

@endsection
@forelse($dataWithPagination as $index => $propertyDetail)
	<tr>
		<td>{{$index + 1}}</td>
		<td>
			<div class="cursor-pointer text-primary" data-bs-toggle="modal"
				data-bs-target="#exampleScrollableModal{{$propertyDetail->id}}">{{$propertyDetail->unique_propert_id}}</div>
			<span class="text-secondary">({{$propertyDetail->old_propert_id}})</span>
			<div class="modal fade" id="exampleScrollableModal{{$propertyDetail->id}}" tabindex="-1" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-xl">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Modal title</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<table class="table mb-0">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Process Of Transfer</th>
										<th scope="col">Transfer Date</th>
										<th scope="col">Lessee Name</th>
										<th scope="col">Lessee Age</th>
										<th scope="col">Property Share</th>
										<th scope="col">Lessee pan No.</th>
										<th scope="col">Lessee aadhar No.</th>
									</tr>
								</thead>
								<tbody>
									@foreach($propertyDetail->propertyTransferredLesseeDetails as $key => $lesseeDetails)
										<tr>
											<th scope="row">{{$key + 1}}</th>
											<td>{{$lesseeDetails->process_of_transfer}}</td>
											<td>{{($lesseeDetails->transferDate) ? $lesseeDetails->transferDate : $propertyDetail->propertyLeaseDetail->date_of_conveyance_deed}}
											</td>
											<td>{{$lesseeDetails->lessee_name}}</td>
											<td>{{$lesseeDetails->lessee_age}}</td>
											<td>{{$lesseeDetails->property_share}}</td>
											<td>{{$lesseeDetails->lessee_pan_no}}</td>
											<td>{{$lesseeDetails->lessee_aadhar_no}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</td>
	        <td>
            {{-- @if ($propertyDetail->alert_flag == '1')
				<span class="badge bg-danger">Yes</span></br>
				{{!empty($propertyDetail->additional_remark) ? $propertyDetail->additional_remark : ""}}
			@else
				{{!empty($propertyDetail->additional_remark) ? $propertyDetail->additional_remark : ""}}
			@endif --}}
            @php
                $remark = $propertyDetail->additional_remark;
                $modalId = 'remarkModal_' . $propertyDetail->id; // Ensure unique modal ID
            @endphp

            @if ($propertyDetail->alert_flag == '1')
                <span class="badge bg-danger">Yes</span><br>
            @endif

            @if (!empty($remark))
                @if (Str::length($remark) > 20)
                    {{ Str::limit($remark, 20) }}
                    <!-- Trigger Modal -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"
                        class="text-primary">More</a>
                    <!-- Modal -->
                    <div class="modal fade" id="{{ $modalId }}" tabindex="-1"
                        aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="{{ $modalId }}Label">Additional Remark</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body"
                                    style="white-space: normal !important; word-wrap: break-word !important; overflow-wrap: break-word !important;">
                                    {{ $remark }}
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{ $remark }}
                @endif
            @endif

        </td>
		<td>
			<div>{{$propertyDetail->unique_file_no}}</div>
			<span class="text-secondary">({{$propertyDetail->file_no}})</span>
		</td>
		<td>
			@foreach($propertyDetail->splitedPropertyDetail as $key => $chldProperty)
				<p>
					<a href="{{ route('propertyChildDetails', ['id' => $chldProperty->id]) }}">{{$chldProperty->child_prop_id}}</a>
					@if(!empty($chldProperty->old_property_id))
						<span class="text-secondary">({{$chldProperty->old_property_id}})</span>
					@endif
				</p>
			@endforeach
		</td>

		<td>{{$item->itemNameById($propertyDetail->property_type)}}</td>
		<td>{{$item->itemNameById($propertyDetail->property_sub_type)}}</td>
		<td>{{$item->itemNameById($propertyDetail->status)}}</td>
		<td>{{$propertyDetail->section_code}}</td>
		<td>@if($propertyDetail->block_no)
				{{$propertyDetail->block_no}}/
			@endif
			{{$propertyDetail->plot_or_property_no}}/
			{{$propertyDetail->oldColony->name}}
		</td>

		<td>
			@if ($propertyDetail->propertyLeaseDetail)
				{{$propertyDetail->propertyLeaseDetail->premium}}.{{$propertyDetail->propertyLeaseDetail->premium_in_paisa}}{{$propertyDetail->propertyLeaseDetail->premium_in_aana}}
			@endif
		</td>

		<td>
			@if ($propertyDetail->propertyLeaseDetail)
				{{$propertyDetail->propertyLeaseDetail->gr_in_re_rs}}.{{$propertyDetail->propertyLeaseDetail->gr_in_paisa}}
			@endif
		</td>

		<td>
			@if ($propertyDetail->propertyLeaseDetail)
				{{$propertyDetail->propertyLeaseDetail->plot_area}}
				{{$item->itemNameById($propertyDetail->propertyLeaseDetail->unit)}}
			@endif
		</td>
		<td>{{$user->userNameById($propertyDetail->created_by)}}</td>
		<td>

			@php
				// Convert UTC time to IST using Carbon
				$utcTime = $propertyDetail->created_at; // Assuming $propertyDetail contains your UTC timestamp
				$istTime = $utcTime->setTimezone('Asia/Kolkata');
			@endphp

			{{ $istTime->format('Y-m-d H:i:s') }}
		</td>
		<td>
			<div class="d-flex gap-3">
				<a href="{{ route('viewDetails', ['property' => $propertyDetail->id]) }}">
					<button type="button" class="btn btn-success px-5">View</button>
				</a>
				
				@haspermission('edit.property.details')
				<a href="{{ route('editDetails', ['property' => $propertyDetail->id]) }}">
					<button type="button" class="btn btn-primary px-5">Edit</button>
				</a>
				@endhaspermission				
				@haspermission('delete.property.details')
				<button type=" button" data-bs-toggle="modal" data-bs-target="#deleteProperty_{{$propertyDetail->id}}"
					class="btn btn-danger px-5">Delete</button>
				<div class="modal fade" id="deleteProperty_{{$propertyDetail->id}}" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Are You Sure ?</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">Do you really want to delete this property? <br>This process cannot be
								undone. </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
								<form method="post" action="{{ route('property.destroy', ['id' => $propertyDetail->id]) }}">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger">Confim Delete</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				@endhaspermission
			</div>
		</td>
		<!-- <td>
																	<a href="#">
																		<div class="col">
																			<button type="button" class="btn btn-info px-5 radius-30">View Detail</button>
																		</div>
																	</a>
																</td> -->
	</tr>

@empty
	<p>No Properties available</p>
@endforelse
<tr>
	<td colspan="14">
		{!! $dataWithPagination->links('pagination.custom') !!}
	</td>
</tr>

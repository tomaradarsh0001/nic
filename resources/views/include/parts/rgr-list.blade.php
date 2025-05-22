<div class="row mt-3 detail-view {{isset($data) ? '': 'd-none'}}" id="colony-view">
    @if(!isset($data))
    <div class="row mb-4 d-none" id="selected-controls">
        <div class="col-lg-12">
            <button class="btn btn-danger" onclick="$(this).prop('disabled',true);generatePdfForSelectedRGR()" id="btn-selected-pdf">Generate Pdf</button>
            <button class="btn btn-primary" onclick="sendDraftForSelectedRGR()">Send Letter</button>
        </div>
    </div>
    @endif
    <!-- <div class="row"> -->
    <div class="col-lg-12">
        @include('modals.view-rgr-draft')
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    @if(!isset($data))
                    <th>
                        <input type="checkbox" id="check-header">
                    </th>
                    @endif
                    <th>Property ID</th>
                    <th>Address</th>
                    <th>Area (Sq. M.)</th>
                    <th>Land rate</th>
                    <th>Land value</th>
                    <th>RGR</th>
                    <!-- <th>circle land rate</th>
                        <th>circle land value</th>
                        <th>circle RGR</th> -->
                    <th>Calculated on</th>
                    <th>Created Date</th>
                    @if(!isset($data))
                    <th>Letter Sent?</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="colony-rows">
                @if(isset($data))
                @forelse($data as $row)
                <tr @if(isset($highlighted) && $highlighted==$row->id)
                    class="highlightedRow"
                    @endif>
                    <td>{{$row->propertyId}}</td>
                    <td>{{$row->address}}</td>
                    <td>{{round($row->property_area_in_sqm,2)}}</td>
                    @php
                    $calculationColumn = $row->calculated_on_rate == "L" ? 'lndo':'circle';
                    @endphp
                    <td>
                        &#8377;{{customNumFormat(round($row->{$calculationColumn.'_land_rate'},2))}}
                    </td>
                    <td>
                        &#8377;{{customNumFormat(round($row->{$calculationColumn.'_land_value'},2))}}
                    </td>
                    <td>&#8377;{{customNumFormat(round($row->{$calculationColumn.'_rgr'}))}}/-</td>
                    <td>{{$row->calculated_on_rate == "L"?'L&DO Rate':'Circle Rate'}}</td>
                    <td>{{date('d-m-Y',strtotime($row->created_at))}}</td>

                    <td><a class="btn btn-draft" onclick="viewDraft(<?= $row->id ?>)"><i class="bx bx-check"></i>View Draft</a></td>

                </tr>
                @empty
                <tr>
                    <td colspan="9">No Data Found</td>
                </tr>
                @endforelse
                @endif
            </tbody>
        </table>
        @if(isset($data))
        {{$data->links()}}
        @endif
    </div>
    <!-- </div> -->

</div>
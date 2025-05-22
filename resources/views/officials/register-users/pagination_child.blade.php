@forelse($dataWithPagination as $index => $registrationDetail)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>
            {{ $registrationDetail->applicant_number }}
        </td>
        <td>
            {{ $registrationDetail->name }}

        </td>
        <td>
            {{ ucfirst($registrationDetail->block) . '/' . ucfirst($registrationDetail->plot) . '/' . ucfirst($registrationDetail->flat) . '/' . ucfirst($registrationDetail->oldColony->name) }}
        </td>
        <td>
            {{ ucwords($registrationDetail->user_type) }}
        </td>
        <td>
            {{ ucwords($registrationDetail->purpose_of_registation) }}
        </td>
        <td>
            @switch($registrationDetail->item_code)
                @case('RS_REJ')
                    <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @case('RS_NEW')
                    <div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @case('RS_UREW')
                    <div class="badge rounded-pill text-warning bg-light-warning  p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @case('RS_REW')
                    <div class="badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @case('RS_PEN')
                    <div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @case('RS_APP')
                    <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
                @break

                @default
                    <div class="badge rounded-pill text-secondary bg-light p-2 text-uppercase px-3">
                        {{ ucwords($registrationDetail->item_name) }}
                    </div>
            @endswitch
        </td>
        <td class="view-hover-data show-toggle-data">
        <a href="javascript:void(0);" class="text-danger pdf-icons"><i class='bx bxs-file-pdf'></i></a>
        <div class="tooltip-data">
    @php
        $documents = [];
        $documentTypes = [
            'sale_deed_doc' => 'Sale Deed Document',
            'builder_buyer_agreement_doc' => 'Builder Buyer Agreement Document',
            'lease_deed_doc' => 'Lease Deed Document',
            'substitution_mutation_letter_doc' => 'Substitution Mutation Letter Document',
            'owner_lessee_doc' => 'Owner Lessee Document',
            'authorised_signatory_doc' => 'Authorised Signatory Document',
            'chain_of_ownership_doc' => 'Chain of Ownership Document',
        ];

        foreach ($documentTypes as $key => $label) {
            $documentPart = explode('/', $registrationDetail->{$key});
            $document = end($documentPart);

            if (!empty($document)) {
                // Construct the URL to the file in the public storage directory
                $fileUrl = asset('storage/' . $registrationDetail->{$key});

                $documents[] = "<span class='td-data-link'>
                    <i class='bx bx-chevron-right'></i>
                    <a href='" . htmlspecialchars($fileUrl) . "' 
                       target='_blank' class='link-primary'>" .
                       ucfirst(htmlspecialchars($document)) .
                    "</a></span>";
            }
        }

        $documents = implode('', $documents);
    @endphp
    {!! $documents !!}
</div>


        </td>
        <td>
            {!! $registrationDetail->remarks
                ? $registrationDetail->remarks .
                    ' <span style="
                font-size: 13px;
                color: #7e7e7ea1;
                font-weight: 700;
            ">(' .
                    $registrationDetail->assigned_by_name .
                    ')</span>'
                : 'NA' !!}


        </td>

        <td>
            <!-- View Button -->
            <a href="{{ route('register.user.details', ['id' => $registrationDetail->id]) }}">
                <button type="button" class="btn btn-success px-5">View</button>
            </a>
            

        </td>
    </tr>

    @empty
        <tr>
            <td colspan="14">
                <p class="text-danger text-center">No Application Available</p>
            </td>
        </tr>
    @endforelse
    <tr>
        <td colspan="14">
            {!! $dataWithPagination->links('pagination.custom') !!}
        </td>
    </tr>

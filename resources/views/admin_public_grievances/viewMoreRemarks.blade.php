@foreach ($grievances as $grievance)
    <!-- Modal Trigger -->
    <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#viewMoreModal{{ $grievance->id }}">View Details</button> -->
<style>
p.user-commented {
    display: inline-block;
    /* background: #fff; */
    padding: 3px 7px;
    color: #424242 !important;
    font-weight: 400;
    margin: 0px;
    border-radius: 5px;
    font-size: 11px;
}
p.message-commented {
    margin-bottom: 5px;
    font-size: 14px;
    color: #585858;
    font-weight: 500;
}
.remark-group {
    padding: 10px;
    margin: 2px 0px;
    border-radius: 5px;
    background: #0036360f;
}
.modal-body .remark-group:nth-child(odd) {
    background: #00666821;
}
.text-right {
    text-align: right;
}
</style>
    <!-- Modal Definition -->
    <div class="modal fade" id="viewMoreModal{{ $grievance->id }}" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="viewMoreModalLabel{{ $grievance->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="viewMoreModalLabel{{ $grievance->id }}">Grievance Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                @foreach ($grievance->remarks as $remark)        
                    <div class="remark-group">
                        <p class="message-commented">{{ $remark->remark }}</p>    
                        <div class="text-right">
                            <p class="user-commented">- {{ $remark->creator->name }} ({{ $remark->created_at->format('Y-m-d') }})</p>
                        </div>
                    </div>

                        <!-- @if (!$loop->last)
                            <hr>
                        @endif -->
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


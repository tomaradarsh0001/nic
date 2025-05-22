<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-striped">
            <tr>
                <td colspan="4">Property Details</td>
            </tr>
            <tr>
                <th>Known As</th>
                <td>{{$demand->property_known_as}}</td>
                <th>Lesse&apos;s Name</th>
                <td>{{$demand->current_lessee}}</td>
            </tr>
        </table>
        <br>
        <table class="table table-bordered table-striped">
            <tr>
                <td colspan="8">Demand details</td>
            </tr>
            <tr>
                <th>Demand Id</th>
                <td>{{$demand->property_known_as}}</td>
                <th>Amount</th>
                <td>₹ {{customNumFormat($demand->net_total)}}</td>
                <th>Balance</th>
                <td>₹ {{customNumFormat($demand->balance_amount)}}</td>
                <th>FY</th>
                <td>{{$demand->current_fy}}</td>
            </tr>
        </table>
        <br>
        {{-- <table class="table table-bordered">
            <tr>
                <th>Property</th>
                <th>Unique Demand Id</th>
                <th>Financial Year</th>
                <th>Net Total</th>
                <th>Balance</th>
            </tr>
            <tr>
                <th>{{$demand->property_known_as}}</th>
                <th>{{$demand->unique_id}}</th>
                <th>{{$demand->current_fy}}</th>
                <th>₹{{customNumFormat($demand->net_total)}}</th>
                <th>₹{{customNumFormat($demand->balance_amount)}}</th>
            </tr>
        </table> --}}
        <br>
    </div>
</div>
<form method="post" id="paymentDetailForm" action="{{route('applicant.demandPayment')}}">
    @csrf
    <div class="col-lg-12">
        <h5 class="mt-2 mb-2">Fill payment details</h5>
    </div>
    <input type="hidden" name="demand_id" value="{{$demand->id}}">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-striped mt-2">
                <tr>
                    <th>S.No</th>
                    <th>Particulars</th>
                    <th>Net Total</th>
                    <th>Paid Amount</th>
                    <th>Balance</th>
                    <th>Fill Payment Amount</th>
                </tr>
                @foreach($demand->demandDetails as $i=>$detail)
                <input type="hidden" name="subhead_id[{{$i}}]" value="{{$detail->id}}">
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$detail->subhead_name}}</td>
                    <td>₹{{customNumFormat($detail->net_total)}}</td>
                    <td>₹{{customNumFormat($detail->paid_amount ?? 0)}}</td>
                    @php
                    $balance = $detail->balance_amount;
                    @endphp
                    <td>₹{{customNumFormat($balance)}}</td>
                    <td>
                        <input type="number" name="paid_amount[{{$i}}]" class="form-control amountToPay" min="0" max="{{$balance}}" {{ $balance == 0 ? 'disabled':'' }}>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="5">Total amount to pay</th>
                    <th id="totalAmountToPay">₹ 0</th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary" id="btnSubmitDemandPayment">Procced</button>
        </div>
    </div>
    <div class="row d-none mt-2" id="form-part-2">
        @include('include.parts.payer-details')
    </div>
</form>
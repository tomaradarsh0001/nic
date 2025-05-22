@extends('layouts.public.app')

@section('title', 'Payment')

@section('content')
<style>
    .submitButtonDiv {
        margin-top: auto;
        margin-bottom: 1em;
    }

    #additionalInputDiv {
        display: flex;
        flex-direction: row;
    }

    #additionalInputDiv>* {
        flex: 1;
        /* Makes all children grow equally to fill the available space */
    }

    .or {
        margin-top: 2.5em !important;
    }

    .or h5 {
        text-align: center;
    }
</style>
<div class="login-8">
    <div class="container">
        <div class="row login-box mb-2">
            <div class="col-lg-12 mx-auto form-section">
                <div class="form-inner">
                    <div class="form-inner-head">
                        <h3>eDharti Payment</h3>
                    </div>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="payemntType" class="quesLabel">Payment Type</label>
                                    <select name="payment_type" id="payemntType" class="form-select">
                                        <option value="">Select</option>
                                        @foreach($paymentTypes as $paymentType)
                                        @php
                                        $additionalData =$paymentType->additional_data;
                                        @endphp
                                        @if(!($guestUser && isset($additionalData->displayForAuthUsers))) {{-- show options available for guest user only --}}
                                        <option value="{{$paymentType->item_code}}" additional-input="{{$additionalData}}">{{$paymentType->item_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col d-none" id="additionalInputDiv">
                                <div class="row"></div>
                            </div>
                            <div class="col d-none submitButtonDiv" id="submitButtonDiv"><button type="button" class="btn btn-primary" id="submitButton1">Proceed</button></div>
                        </div>
                    </form>
<!-- added by Swati Mishra to add payment help pdf in payment page itself on 02052025.-->
                    <div class="alert alert-warning mt-4">
                        <p class="text-muted text-sm">
                            <strong>Note:</strong>Please refer to the
                                <a href="{{ asset('assets/pdf/eServices_PaymentFlow.pdf') }}" target="_blank"
                                    class="text-primary underline">payment guidelines PDF </a>for the detailed payment instructions.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-2 d-none" id="paymentDetailsRow">
            <hr>
            <div class="col-lg-12" id="paymentDetails">
            </div>
        </div>
    </div>
</div>

@include('include.alerts.ajax-alert')
@endsection

@section('footerScript')
<script src="{{asset('assets/js/demandPayment.js')}}"></script>
<script src="{{asset('assets/js/addressDropdown.js')}}"></script>
<script>
    const inputHTMLTemplate = (name) => `
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="" class="quesLabel">${name.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}</label>
                <input type="text" name="${name}" id="additionalInput" class="form-control">
            </div>
        </div>
    </div>`;

    function toggleVisibility(element, shouldShow) {
        if (shouldShow) element.removeClass('d-none');
        else element.addClass('d-none');
    }

    function safeJSONParse(str) {
        try {
            return JSON.parse(str);
        } catch {
            console.error("Invalid JSON:", str);
            return null;
        }
    }

    $('#payemntType').change(function() {
        const selectedPaymentType = $(this).val();
        const additionalInputDiv = $('#additionalInputDiv');
        const submitButtonDiv = $('#submitButtonDiv');
        const selectedOption = $(this).find('option:selected');
        const additionalInputString = selectedOption.attr('additional-input');

        if (selectedPaymentType) {
            const additionalInputData = safeJSONParse(additionalInputString);
            if (additionalInputData && additionalInputData.additional_input) {
                const additionalInput = additionalInputData.additional_input;
                additionalInputDiv.empty();

                if (Array.isArray(additionalInput)) {
                    additionalInput.forEach((input, index) => {
                        additionalInputDiv.append(inputHTMLTemplate(input));
                        if (index < additionalInput.length - 1) {
                            additionalInputDiv.append('<div class="col or"><h5>OR</h5></div>');
                        }
                    });
                } else {
                    additionalInputDiv.append(inputHTMLTemplate(additionalInput));
                }

                toggleVisibility(additionalInputDiv, true);
                toggleVisibility(submitButtonDiv, false);
            } else {
                additionalInputDiv.empty();
                toggleVisibility(additionalInputDiv, false);
                toggleVisibility(submitButtonDiv, true);
            }
        } else {
            toggleVisibility(additionalInputDiv, false);
            toggleVisibility(submitButtonDiv, false);
        }
    });


    $(document).on('keyup', '#additionalInput', function() {
        if ($(this).val() != '') {
            if ($('#submitButtonDiv').hasClass('d-none')) {
                $('#submitButtonDiv').removeClass('d-none')
            }
        } else {
            if (!$('#submitButtonDiv').hasClass('d-none')) {
                $('#submitButtonDiv').addClass('d-none')
            }
        }
    })
    $('#submitButton1').click(function() {
        var paymentType = $('#payemntType').val();
        var additionalInput = $('#additionalInput');
        var inputName = additionalInput.attr('name');
        var inputValue = additionalInput.val();
        $.ajax({
            type: "GET",
            url: "{{route('getPaymentDetails')}}",
            data: {
                paymentType: paymentType,
                inputName: inputName,
                inputValue: inputValue
            },
            success: function(response) {
                console.log(!response.status);
                if (!response.status) {
                    showError(response.details);
                } else {
                    $('#paymentDetails').html(response.html);
                    $('#paymentDetailsRow').removeClass('d-none');
                }
            }
        });
    });
</script>

@endsection

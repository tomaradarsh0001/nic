@extends('layouts.app')

@section('title', 'Create Request')

@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Logistic Management</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Request</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form id="logisticForm" action="{{ route('request.update', ['requestId' => $requestItems->first()->request_id]) }}" method="POST">
            @csrf
            <input type="hidden" name="status" id="status">
            @foreach ($requestItems as $requestItem)
                <div class="row m-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Item Name</label>
                            <input type="text" class="form-control" value="{{ $requestItem->logisticItem->name }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" value="{{ $requestItem->category->name }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row m-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Requested Units</label>
                            <input type="number" class="form-control" value="{{ $requestItem->requested_units }}" disabled>
                            <input type="hidden" name="items[{{ $loop->index }}][requested_units]" value="{{ $requestItem->requested_units }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Available Units</label>
                            <input type="number" class="form-control available-units" value="{{ $requestItem->available_units }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Issued Units</label>
                            <input type="number" name="items[{{ $loop->index }}][issued_units]" value="{{ old('items.' . $loop->index . '.issued_units', $requestItem->issued_units) }}" class="form-control issued-units" min="0">
                            <input type="hidden" name="items[{{ $loop->index }}][logistic_items_id]" value="{{ $requestItem->logistic_items_id }}">
                            <input type="hidden" name="items[{{ $loop->index }}][category_id]" value="{{ $requestItem->category_id }}">
                            <span class="error-message" style="color:red; display:none;">Issued units cannot be more than requested units and must not be blank when approving.</span>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="d-flex justify-content-end py-3">
                <button type="button" id="approveBtn" class="btn btn-success mx-2">Approve</button>
                <button type="button" id="rejectBtn" class="btn btn-danger">Reject</button>
                @include('include.alerts.approve-confirmation')
                @include('include.alerts.reject-confirmation')
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {

        function showValidationMessage(element, message) {
            element.addClass('is-invalid');
            element.siblings('.error-message').text(message).show();
        }

        function hideValidationMessage(element) {
            element.removeClass('is-invalid');
            element.siblings('.error-message').hide();
        }

        function validateInput(element, isApproval) {
            const issuedUnits = element.val();
            const requestedUnits = element.closest('.row').find('input[name^="items"][name$="[requested_units]"]').val();

            if (issuedUnits === '') {
                if (isApproval) {
                    showValidationMessage(element, 'Issued units cannot be blank');
                    return false;
                } else {
                    hideValidationMessage(element);
                    return true;
                }
            } else if (parseInt(issuedUnits) < 0) {
                showValidationMessage(element, 'Issued units cannot be less than 0');
                return false;
            } else if (parseInt(issuedUnits) > parseInt(requestedUnits)) {
                showValidationMessage(element, 'Issued units cannot be more than requested units');
                return false;
            } else {
                hideValidationMessage(element);
                return true;
            }
        }

        $('.issued-units').on('input', function () {
            validateInput($(this), true);
        });

        function validateIssuedUnits(isApproval) {
            let isValid = true;
            $('.issued-units').each(function () {
                if (!validateInput($(this), isApproval)) {
                    isValid = false;
                }
            });
            return isValid;
        }

        $('#approveBtn').click(function (e) {
            e.preventDefault();
            if (validateIssuedUnits(true)) {
                $('#status').val('approved');
                $('#approveModal').modal('show');
            } else {
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
        });

        $('#rejectBtn').click(function (e) {
            e.preventDefault();
            let isValid = true;

            $('.issued-units').each(function () {
                const issuedUnits = $(this).val();
                if (issuedUnits !== '' && parseInt(issuedUnits) !== 0) {
                    showValidationMessage($(this), 'Issued units must be 0 or blank when rejecting.');
                    isValid = false;
                } else {
                    hideValidationMessage($(this));
                }
            });

            if (isValid) {
                $('#status').val('rejected');
                $('#rejectModal').modal('show');
            } else {
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
            }
        });

        $('#approveModal .confirm-approve').click(function () {
            if (validateIssuedUnits(true)) {
                $('#logisticForm').submit();
            } else {
                $('html, body').animate({
                    scrollTop: $('.is-invalid').first().offset().top - 100
                }, 500);
                $('#approveModal').modal('hide');
            }
        });

        $('#rejectModal .confirm-reject').click(function () {
            $('#logisticForm').submit();
        });

        // Close button fix for Bootstrap modals
        $('.btn-close, .btn-secondary').click(function () {
            $(this).closest('.modal').modal('hide');
        });
    });
</script>
@endsection

<!-- in this page add bootstrap label class and mobile maxlength -->
<div class="col-lg-12 patment-inputs">
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">First Name <span class="text-danger">*</span></label>
                <input type="text" name="payer_first_name" id="payer_first_name" class="form-control" placeholder="Enter Name" required pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" title="only alphamumeric characters and space are allowed">
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Last Name</label>
                <input type="text" name="payer_last_name" id="payer_last_name" class="form-control" placeholder="Enter Name" pattern="^[a-zA-Z]+( [a-zA-Z]+)*$" title="only alphamumeric characters and space are allowed">
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Mobile <span class="text-danger">*</span></label>
                <input type="text" name="payer_mobile" id="payer_mobile" class="form-control" maxlength="10" placeholder="Mobile No." required pattern="^[1-9][0-9]{9}$" ttile="please enter 10 digit value">
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" class="form-label" for="">Email <span class="text-danger">*</span></label>
                <input type="email" name="payer_email" id="payer_email" class="form-control" placeholder="Email" required>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Address Line 1 <span class="text-danger">*</span></label>
                <input type="text" name="address_1" id="address_1" class="form-control" placeholder="Address line 1" required pattern="^[a-zA-Z0-9 ,./-]+$" title="invalid adderess">
            </div>

        </div>
        <div class="col-lg-6 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Address Line 2</label>
                <input type="text" name="address_2" id="address_2" class="form-control" placeholder="Address line 2" pattern="^[a-zA-Z0-9 ,./-]+$" title="invalid adderess">
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Region</label>
                <input type="text" name="region" id="region" class="form-control" placeholder="Region" pattern="^[a-zA-Z0-9 ,]+$">
            </div>

        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Postal code</label>
                <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Postal code" pattern="[1-9][0-9]{5}" ttile="please enter 6 digit value">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">Country<span class="text-danger">*</span></label>
                <select name="country" id="country_select" required class="form-select">
                    <option value="">Select</option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" {{$country->name == 'India' ? 'selected': ''}}>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="">State<span class="text-danger">*</span></label>
                <select name="state" id="state_select" required class="form-select">
                    <option value="">Select</option>
                    @foreach($states as $state)
                    <option value="{{$state->id}}">{{$state->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 mb-3">
            <div class="form-group">
                <label class="form-label" for="city_select">City<span class="text-danger">*</span></label>
                <select name="city" id="city_select" required class="form-control"></select>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 my-2">
    <button type="button" class="btn btn-primary" id="continue-payment">Continue</button>
</div>
<div class="row d-none mt-5 mb-3 payment-mode" id="row-payment-mode">
    <div class="col-lg-12 mb-2">
        <h5>Select Your Payment Mode</h5>
    </div>
    <div class="col-lg-3">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_mode" value="PAY_ONLINE" id="mode_online" @required(true)>
            <label class="form-check-label" for="mode_online">Online (RTGS/IMPS/UPI)</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_mode" value="PAY_OFFLINE" id="mode_offline" @required(true)>
            <label class="form-check-label" for="mode_offline">Offline (Challan)</label>
        </div>
    </div>
    <div class="col-lg-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>


<script>
    $(document).on('click', '#continue-payment', function() {
        $('#row-payment-mode').removeClass('d-none');
    })

    $(document).ready(function() {
        // Function to validate inputs
        function validateInput(input) {
            let value = input.val();
            let rawPattern = input.attr("pattern") || ".*"; // Get pattern as a string
            let escapedPattern = rawPattern.replace(/\\/g, "\\\\"); // Escape backslashes
            let pattern = input.attr('type') == 'email' ? /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,5}$/ : new RegExp(escapedPattern); // Now create RegExp
            let requiredValid = !input.attr("required") || value.trim() !== "";
            let isValid = requiredValid && (value == "" || pattern.test(value));

            if (!isValid) {
                showError(input, requiredValid);
            } else {
                removeError(input);
            }
        }

        // Function to show the error message
        function showError(input, requiredValid) {
            let parentDiv = input.parent();
            let inputLabel = input.parent().find('label').text().replace('*', '').trim();
            let errorText = (!requiredValid) ? inputLabel + ' is required' : input.attr("title") || "Invalid " + inputLabel; // Use the title attribute as the error message
            if (parentDiv.find(".error").length === 0) {
                parentDiv.append(`<small class="error text-danger">${errorText}</small>`);
            }
        }

        // Function to remove the error message
        function removeError(input) {
            input.parent().find(".error").remove();
        }

        // Handle form submit
        $("form").on("submit", function(e) {
            let hasError = false;

            $(this).find("input, select").each(function() {
                validateInput($(this));
                if ($(this).parent().find(".error").length > 0) {
                    hasError = true;
                }
            });

            if (hasError) {
                e.preventDefault(); // Stop form submission if there are errors
            }
        });

        // Handle input keyup (remove error if input becomes valid)
        $("input[required], input[pattern]").on("keyup", function() {
            validateInput($(this));
        });

        // Handle focusout (show error if input is still invalid)
        $("input[required], input[pattern], select").on("focusout", function() {
            validateInput($(this));
        });
    })
</script>
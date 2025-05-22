<!-- <style>
    .alert {
        width: auto !important;
        min-width: 350px;
        text-align: center;
        position: fixed !important;
        /*bottom: 30px !important;*/
        top: 69px !important;
        right: 19px !important;
        z-index: 999 !important;
    }
</style>
<div class="d-none alert alert-danger"></div>
<div class="d-none alert alert-success"></div> -->

<script>
    const showError = (message) => {
        var errorText = message;
        var displaySettings = {
            text: errorText,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #c20d0a, #d63431)",
            },
            offset: {
                // x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 50 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
            onClick: function toasterDemo() {} // Callback after click
        }
        if (Array.isArray(message) && message.length > 0) { //when multiple errors
            let errorListHTML = ``;
            message.forEach((listMessage, i) => {
                errorListHTML += `&bull; ${listMessage}<br>`;
            });
            // errorListHTML += `</ul>`;
            // $('.alert-danger').html(errorListHTML);
            errorText = errorListHTML;
            displaySettings.text = errorText
            displaySettings.escapeMarkup = false;
        }
        /* else { //when only one error
                   $('.alert-danger').html(`<h6>${message}</h6>`);
               }
               $('.alert-danger').removeClass('d-none').show(); //need to add show. display none is added in div
               setTimeout(() => {
                   $('.alert-danger').addClass('d-none');
               }, 3000); */

        Toastify(displaySettings).showToast();
    }
    const showSuccess = (message, redirectTo = null) => {
        /* $('.alert-success').html(`<h6>${message}</h6>`);
        $('.alert-success').removeClass('d-none');
        setTimeout(() => {
            $('.alert-success').addClass('d-none');
            if(redirectTo){
                window.location.href = redirectTo
            }
        }, 5000); */
        var displaySettings = {
            text: message,
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #00b09b, #116d6e)",
            },
            offset: {
                // x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                y: 50 // vertical axis - can be a number or a string indicating unity. eg: '2em'
            },
            onClick: function toasterDemo() {} // Callback after click
        }
        /* if (redirectTo) {
            displaySettings.destination = redirectTo;
            displaySettings.newWindow = false;
        } */
        Toastify(displaySettings).showToast();

        //manually redirect on hide toast
        console.log(redirectTo);
        
        if (redirectTo) {
            setTimeout(() => {
                window.location.href = redirectTo; // Reload or redirect after toast duration
            }, displaySettings.duration);
        }
    }
</script>
<style>
    /* Loader css  */

    .loader {
        display: flex;
        justify-content: center;
        flex-direction: row;
        padding: 2rem;
    }

    .lds-roller {
        /* change color here */
        color: #116d6e
    }

    .lds-roller,
    .lds-roller div,
    .lds-roller div:after {
        box-sizing: border-box;
    }

    .lds-roller {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 40px 40px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 7.2px;
        height: 7.2px;
        border-radius: 50%;
        background: currentColor;
        margin: -3.6px 0 0 -3.6px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 62.62742px;
        left: 62.62742px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 67.71281px;
        left: 56px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 70.90963px;
        left: 48.28221px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 72px;
        left: 40px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 70.90963px;
        left: 31.71779px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 67.71281px;
        left: 24px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 62.62742px;
        left: 17.37258px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 56px;
        left: 12.28719px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Loader css  */


    /* for Edharti loader - SOURAV CHAUHAN (11 April 2025) */
    #spinnerOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1000;
            /* Ensure it covers other content */
        }

        .spinner {
            border: 8px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 8px solid #ffffff;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
</style>

@if(strpos( url()->current(), '/reports') || strpos( url()->current(), '/reports/detailed-report') || strpos( url()->current(), '/dashboard/main'))
<div id="spinnerOverlay">
        <img src="{{ asset('assets/images/chatbot_icongif.gif') }}">
        <br>
        <h1 style="color: white;font-size: 20px;">Loading all properties, Please wait...</h1>
</div>
@endif

<div class="row loader_container d-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="loader">
                    <div class="lds-roller">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
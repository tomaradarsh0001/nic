<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Jaldi:wght@400;700&family=Jost:ital,wght@0,100..900;1,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Site is under construction</title>
    <style>
        body {
            font-family: "Jaldi", serif;
            background-color: #f8fafc;
            color: #333;
            text-align: center;
            padding: 0;
        }

        .error-wrap{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 16px);
            background-image: url(../assets/images/error-bg.png);
            background-repeat: no-repeat;
            background-position-x: center;
            background-position-y: calc(50% - 167px);
        }

        .error-wrap h1{
            font-family: "Jaldi", serif;
            font-weight: 400;
            font-style: normal;
            font-size:400px;
            color:rgba(255, 19, 19, 0.56);
            margin:0;
            line-height:350px;
            opacity: 0.3;
        }


        h1 {
            font-size: 50px;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            /* background-color: #f8fafc; */
            padding: 10px 20px;
            /* border: 1px solid #007bff; */
            border-radius: 5px;
        }
        a:hover {
            /* background-color: #007bff; */
            color: white;
        }
        .error-msg{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin:60px 0 20px;
        }
        .error-msg > img{
            margin-right:10px;
        }
        .error-msg p{
            font-size: 50px;
            color: #0000008F;
            line-height: 60px;
            margin: 0;
        }
        .error-msg .think-cloud {
            position: absolute;
            opacity: 0.6;
            left: calc(50% + 375px);
            bottom: 0;
            transform: translateX(-50%);
        }
        .error-foot{
            display:flex;
            align-items: center;
            justify-content: center;
        }
        .foot-left{
            font-size:28px;
            color:#0000008F;
            margin-right:15px;
        }
        .foot-left span{
            color:#FF13138F;
            font-weight:bold;
            position:relative;
            margin-right: 8px;
        }
        .foot-left span::after{
            content: "";
            width: 1px;
            height: 34px;
            position: absolute;
            border-left: 3px solid #0000008F;
            right: -9px;
            top:7px;
        }
        .action-btn{
            font-size:25px;
            font-weight:300;
            background-color:#116D6E;
            color:#FFFFFF;
            border-color:#116d6e;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius:10px;
            padding: 3px 15px;
        }
        .action-btn:hover,
        .action-btn:focus{
            background-color: #1fa1a2;
            border-color: #1fa1a2;
        }
        .action-btn img{
            margin-right:5px;
        }
    </style>
</head>
<body>
    <div class="error-wrap">
        <h1>503</h1>
        <div class="error-msg">
            <img src="../assets/images/close-error.svg" alt="Error Page"/>
            <p>SITE IS UNDER CONSTRUCTION!</p>
            <div class="think-cloud">
                <!-- <img src="assets/images/think-cloud.svg" alt="Think Cloud"/> -->
                <img src="../assets/images/cloud-think.png" alt="Think Cloud"/>
            </div>
        </div>
        <div class="error-foot">
            <div class="foot-left">
                <span>503</span> SITE UNDER MAINTENANCE
            </div>
            <a class="action-btn" href="/"> <img src="../assets/images/arrow_back.svg" alt="Back arrow"/> Back </a>
        </div>
    </div>
</body>
</html>

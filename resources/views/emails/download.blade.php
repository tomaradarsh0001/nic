<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Static Template</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
</head>

<body
    style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    ">
    <div>
        <main>
            <div
                style="
            margin: 0;
            margin-top: 20px;
            padding: 12px 10px 15px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
          ">
                <div style="width: 100%; max-width: 489px; margin: 0 auto; background: rgb(255 240 182 / 70%);">

                    <p style="margin: 0; margin-top: 17px; font-weight: 500; letter-spacing: 0.56px;">
                        Your report is ready for download.
                    </p>
                    <h5><a href="{{$link}}" target="_blank" rel="noopener noreferrer">Download</a></h5>
                </div>
            </div>

            <p
                style="
            max-width: 400px;
            margin: 0 auto;
            margin-top: 90px;
            text-align: center;
            font-weight: 500;
            color: #8c8c8c;
          ">
                Need help? Ask at
                <a
                    href="mailto:edharti@gmail.com"
                    style="color: #499fb6; text-decoration: none;">edharti@gmail.com</a>
                or visit our
                <a
                    href=""
                    target="_blank"
                    style="color: #499fb6; text-decoration: none;">Help Center</a>
            </p>
        </main>
    </div>
</body>

</html>
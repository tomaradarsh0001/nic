<!DOCTYPE html>
<html>
<head>
    <title>New Public Grievance Recieved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            text-align: center;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <img src="{{ $message->embed(public_path('assets/images/logo-icon.png')) }}" style="width: 10%; height: auto;" alt="Land and Development Office">
            <h1>New Public Grievance Recieved</h1>
        </div>
        <div class="content">
            <p>Dear Admin,</p>
            <p>A new public grievance has been submitted to the Land & Development Office (L&DO). Below are the details of the grievance:</p>
                <div class="details">
                    <p><strong>Grievance Details:</strong></p>
                    <p><strong>Name:</strong> {{ $grievance['name'] }}</p>
                    <p><strong>Address:</strong> {{ $grievance['address'] }}</p>
                    <p><strong>Description:</strong> {{ $grievance['description'] }}</p>
                </div>
                </div>

            <p>Please review the grievance and take the necessary steps to address it. 
                If you need further information, you may contact the user directly using the details provided above.</p>
            <div class="footer1" style="margin-top: 20px;">
                Best regards,<br>
                Land & Development Office (L&DO)<br>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

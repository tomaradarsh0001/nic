<!DOCTYPE html>
<html>
<head>
    <title>Acknowledgment of Grievance Submission to L&DO</title>
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
            <h1>Acknowledgment of Grievance Submission to L&DO</h1>
        </div>
        <div class="content">
            <p>Dear {{ $grievance['name'] }},</p>
            <p>Thank you for submitting your public grievance to the Land & Development Office (L&DO). 
                We have successfully received your grievance, and it has been logged in our system for further review and action.</p>
            <div class="details">
                <p><strong>Grievance Details:</strong></p>
                <p><strong>Name:</strong> {{ $grievance['name'] }}</p>
                <p><strong>Address:</strong> {{ $grievance['address'] }}</p>
                <p><strong>Description:</strong> {{ $grievance['description'] }}</p>
            </div>
            <!-- <p><strong>Name:</strong> {{ $grievance['name'] }}</p>
            <p><strong>Description:</strong> {{ $grievance['description'] }}</p> -->
            <p>Your grievance will be reviewed by our team, and we will take the necessary steps to address the issue. 
                We appreciate your patience and understanding during this process.</p>
            <p>Thank you for bringing this matter to our attention. 
                We are committed to resolving your grievance as promptly as possible.</p>
        </div>
        <div class="footer1" style="margin-top: 20px;">
            Best regards,<br>
            Land & Development Office (L&DO)<br>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Land and Development Office, Ministry of Housing and Urban Development. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
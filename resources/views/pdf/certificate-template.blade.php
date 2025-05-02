<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            position: relative;
            width: 100%;
            min-height: 100vh;
        }
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: auto;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: auto;
        }
        .content {
            margin-top: 150px; /* Adjust based on your header height */
            margin-bottom: 150px; /* Adjust based on your footer height */
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Content will be dynamically added by PdfCertificateController -->
        <div class="content">
           <h1>Hello World</h1>
        </div>
    </div>
</body>
</html> 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggapan Direkam - BLP Property</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Product+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0ebf8;
            font-family: 'Roboto', sans-serif;
            color: #202124;
            padding: 12px 0 48px;
        }

        .form-container {
            max-width: 640px;
            margin: 0 auto;
        }

        /* Top Accent Card */
        .header-card {
            background-color: #ffffff;
            border-radius: 8px;
            border-top: 10px solid #673ab7;
            padding: 24px;
            margin-bottom: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        .header-title {
            font-family: 'Product Sans', 'Roboto', sans-serif;
            font-size: 32px;
            font-weight: 400;
            line-height: 40px;
            margin-bottom: 8px;
            color: #202124;
        }

        .success-message {
            font-size: 14px;
            color: #202124;
            margin-top: 20px;
            margin-bottom: 24px;
            line-height: 20px;
        }

        .another-response-link {
            font-size: 14px;
            color: #1a73e8;
            text-decoration: underline;
            cursor: pointer;
            display: inline-block;
        }

        .another-response-link:hover {
            color: #1557b0;
        }
    </style>
</head>
<body>

    <div class="container py-2 mt-4">
        <div class="form-container">
            
            <!-- Header Card with Success Message -->
            <div class="header-card">
                <h1 class="header-title">Formulir Database Calon Pembeli BLP Property {{ $salesName ? '- Sales ' . $salesName : '' }}</h1>
                
                <div class="success-message">
                    Tanggapan Anda telah direkam. Terima kasih telah mengisi formulir ini!
                </div>
                
                <a href="{{ route('public.form-leads', ['sales' => $salesName]) }}" class="another-response-link">
                    Kirim tanggapan lain
                </a>
            </div>

        </div>
    </div>

</body>
</html>

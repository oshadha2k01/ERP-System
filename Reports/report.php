<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <Style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-color: white;
        }
        .main-container{
            text-align: center;
            margin-top: 50px;
            padding: 20px;
        }
        .main-buttons{
            margin-top: 50px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            border-radius: 6px;
        }
        .btn-mod{
            padding: 10px 20px;
            margin: 0 10px;
        }
        h1{
            font-size: 50px;
        }
        /* Media quaries */
        @media (max-width: 768px) {
            h1 {
                font-size: 40px; 
            }
            .btn-mod {
                padding: 12px 20px;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 30px; 
            }
            .btn-mod {
                padding: 10px 15px; 
                width: 100%; 
                margin: 10px 0; 
            }
        }
    </Style>
</head>
<body>
    <div class="main-container">
        <h1 class="mb-4">Welcome to the Report Section</h1>

        <!--Main Buttons for Tasks -->
        <div class="main-buttons">
            <a class='btn btn-primary btn-lg btn-mod' href='/ERP-System/Reports/invoice_report.php'>Invoice Report</a>
            <a class='btn btn-primary btn-lg btn-mod' href='/ERP-System/Reports/invoice_item_report.php'>Invoice Item Report</a>
            <a class='btn btn-primary btn-lg btn-mod' href='/ERP-System/Reports/item_report.php'>Item Report</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
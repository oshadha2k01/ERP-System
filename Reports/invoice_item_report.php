<?php
include('../includes/dbh.inc.php');
require '../vendor/autoload.php';

// use dompdf for report generation
use Dompdf\Dompdf;

$dateFrom = isset($_POST['date_from']) ? $_POST['date_from'] : '';
$dateTo = isset($_POST['date_to']) ? $_POST['date_to'] : '';

// Fetch invoices item report based on the date range
$sql = "
SELECT 
    i.invoice_no,
    i.date AS invoiced_date,
    CONCAT(c.title, ' ', c.first_name, ' ', c.last_name) AS customer_name,
    CONCAT(itm.item_name, ' (', itm.item_code, ')') AS item_info,
    ic.category AS item_category,
    im.unit_price
FROM 
    invoice i
JOIN 
    customer c ON i.customer = c.id
JOIN 
    invoice_master im ON i.invoice_no = im.invoice_no
JOIN 
    item itm ON im.item_id = itm.id
JOIN 
    item_category ic ON itm.item_category = ic.id
WHERE 
    i.date BETWEEN ? AND ?
ORDER BY 
    i.invoice_no, i.date
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $dateFrom, $dateTo);
$stmt->execute();
$result = $stmt->get_result();

$invoicesitems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invoicesitems[] = $row;
    }
}
//Generate PDF using Dompdf
if (isset($_POST['generate_pdf'])) {
    $dompdf = new Dompdf();

    $currentDateTime = date('d-m-Y');

    //Ouput structure and save the pdf 
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Invoice Item Report PDF</title>
        <style>
            body {
                position: relative;
            }

            h1 {
                text-align: center;
                font-size: 24px;
                margin-bottom: 0;
                color: blue;
            }

            h2 {
                text-align: center;
                font-size: 18px;
                margin-top: 0;
                margin-bottom: 20px;
            }

            .date-time {
                position: absolute;
                top: 10px;
                right: 20px;
                font-size: 12px;
            }

            table {
                width: 90%;
                height: auto;
                border-collapse: collapse;
                margin-top: 20px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }

            th {
                background-color: #ffffff;
            }

            .signature-space {
                margin-top: 10px;
            }

            .signature {
                width: 200px;
                border-top: 1px solid #000;
                margin-top: 40px;
                margin-left: 700px;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="date-time">Generated on: <?= htmlspecialchars($currentDateTime) ?></div>
        <h1>Invoice Item Report</h1>
        <h2>Invoice Item Report from <?= htmlspecialchars($dateFrom) ?> to <?= htmlspecialchars($dateTo) ?></h2>

        <!-- Invoice Table -->
        <table>
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Invoiced Date</th>
                    <th>Customer Name</th>
                    <th>Item Name with Code</th>
                    <th>Item Category</th>
                    <th>Item Unit Price </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($invoicesitems)): ?>
                    <?php foreach ($invoicesitems as $invoice): ?>
                        <tr>
                            <td><?= htmlspecialchars($invoice['invoice_no']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y', strtotime($invoice['invoiced_date']))) ?></td>
                            <td><?= htmlspecialchars($invoice['customer_name']) ?></td>
                            <td><?= htmlspecialchars($invoice['item_info']) ?></td>
                            <td><?= htmlspecialchars($invoice['item_category']) ?></td>
                            <td><?= htmlspecialchars($invoice['unit_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No invoices found for the selected date range</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="signature-space">
            <p class="signature">Authorized Signature</p>
        </div>


    </body>

    </html>
    <?php
    $html = ob_get_clean();


    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');


    $dompdf->render();


    $dompdf->stream("invoice_item_report.pdf", ["Attachment" => true]);
    exit();








}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Item Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 40px;
        }

        .form-control {
            border: 1px solid #000000;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Invoice Item Report</h2>

        <!-- Date range and search function  -->
        <form method="POST" action="invoice_item_report.php" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="date_from">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from"
                        value="<?= htmlspecialchars($dateFrom) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="date_to">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to"
                        value="<?= htmlspecialchars($dateTo) ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    <button type="submit" name="generate_pdf" class="btn btn-secondary">Generate PDF</button>
                </div>
            </div>
        </form>

        <!-- Invoice item report data table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Invoiced Date</th>
                    <th>Customer Name</th>
                    <th>Item Name with Code</th>
                    <th>Item Category</th>
                    <th>Item Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($invoicesitems)): ?>
                    <?php foreach ($invoicesitems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['invoice_no']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y', strtotime($item['invoiced_date']))) ?></td>
                            <td><?= htmlspecialchars($item['customer_name']) ?></td>
                            <td><?= htmlspecialchars($item['item_info']) ?></td>
                            <td><?= htmlspecialchars($item['item_category']) ?></td>
                            <td><?= htmlspecialchars($item['unit_price']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No invoices found for the selected date range</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
include('../includes/dbh.inc.php');
require '../vendor/autoload.php';

// use dompdf for report generation
use Dompdf\Dompdf;

// Fetch item report 
$sql = "
SELECT 
    DISTINCT itm.item_name,
    ic.category AS item_category,
    isc.sub_category AS item_subcategory,
    itm.quantity
FROM 
    item itm
JOIN 
    item_category ic ON itm.item_category = ic.id
JOIN 
    item_subcategory isc ON itm.item_subcategory = isc.id
ORDER BY 
    itm.item_name
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$item = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $item[] = $row;
    }
}

// Generate PDF using Dompdf
if (isset($_POST['generate_pdf'])) {
    $dompdf = new Dompdf();

    $currentDateTime = date('d-m-Y');

    // Output structure and save the pdf 
    ob_start();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Item Report PDF</title>
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
                margin-top: 50px;
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
        <h1>Item Report</h1>

        <!-- Item Table -->
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Sub Category</th>
                    <th>Item Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($item)): ?>
                    <?php foreach ($item as $itm): ?>
                        <tr>
                            <td><?= htmlspecialchars($itm['item_name']) ?></td>
                            <td><?= htmlspecialchars($itm['item_category']) ?></td>
                            <td><?= htmlspecialchars($itm['item_subcategory']) ?></td>
                            <td><?= htmlspecialchars($itm['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No Items found!</td>
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

    $dompdf->stream("item_report.pdf", ["Attachment" => true]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Report</title>
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
        <h2>Item Report</h2>
        <!-- generate PDF section -->
        <form method="POST" action="">
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="generate_pdf" class="btn btn-secondary">Generate PDF</button>
            </div>
        </form>

        <!-- Item report data table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Category</th>
                    <th>Item Sub Category</th>
                    <th>Item Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch item report data
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['item_name']) . "</td>
                            <td>" . htmlspecialchars($row['item_category']) . "</td>
                            <td>" . htmlspecialchars($row['item_subcategory']) . "</td>
                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

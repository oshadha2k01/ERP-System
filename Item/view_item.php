<?php
include('../includes/dbh.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/view_item.css">
</head>

<body>
    <div class="item-container">
        <h1 class="item-view text-center mt-4 mb-4">Item View List</h1>
        <div class="d-flex justify-content-start mb-4">
            <a class="btn btn-primary btn-md mb-0" href="add_item.php" style="margin-left: 80px; margin-top: 5px;">Add
                Item</a>
        </div>

        <div class="table-container table-responsive mx-auto">
            <table class="item-table table table-striped table-bordered text-center" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Item Category</th>
                        <th>Item Sub Category</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch data from item table in database -->
                    <?php
                    // SQL query for left joining item_category and item_subcategory tables with item table
                    $sql = "SELECT i.*, c.category AS category, s.sub_category AS sub_category
                    FROM item i 
                    LEFT JOIN item_category c ON i.item_category = c.id 
                    LEFT JOIN item_subcategory s ON i.item_subcategory = s.id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        // Display items details
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['item_code']}</td>
                                <td>" . ($row['category'] ?? 'N/A') . "</td>
                                <td>" . ($row['sub_category'] ?? 'N/A') . "</td>
                                <td>{$row['item_name']}</td>
                                <td>{$row['quantity']}</td>
                                <td>{$row['unit_price']}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href='update_item.php?id={$row['id']}'>Update</a>
                                    <a class='btn btn-danger btn-sm' href='delete_item.php?id={$row['id']}'>Delete</a>
                                </td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No Items found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


















    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
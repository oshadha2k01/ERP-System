<?php
include '../includes/dbh.inc.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/view_customer.css">   
</head>

<body>
    <div class="customer-container">
        <h1 class="customer-view text-center mt-4 mb-4">Customer View List</h1>
        <div class="d-flex justify-content-start mb-4">
            <a class="btn btn-primary btn-md mb-0" href="add_customer.php" style="margin-left: 80px; margin-top: 5px;">Add Customer</a>
        </div>

        <div class="table-container table-responsive mx-auto">
            <table class="customer-table table table-striped table-bordered text-center" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Contact Number</th>
                        <th>District</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch data from customer table in database -->
                    <?php
                    // SQL query for joining customer and district table
                    $sql = "
                           SELECT c.id, c.title, c.first_name, c.middle_name, c.last_name, c.contact_no, d.district 
                           FROM customer c 
                           LEFT JOIN district d ON c.district = d.id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        // Display customer details
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <tr>
                                <td>{$row['id']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['middle_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['contact_no']}</td>
                                <td>{$row['district']}</td>
                                <td>
                                    <a class='btn btn-primary btn-sm' href='update_customer.php?id={$row['id']}'>Update</a>
                                    <a class='btn btn-danger btn-sm' href='delete_customer.php?id={$row['id']}'>Delete</a>
                                </td>
                            </tr>
                            ";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No customers found.</td></tr>";
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

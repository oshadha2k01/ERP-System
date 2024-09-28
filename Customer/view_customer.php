<!--Include database connection-->
<?php
include'../includes/dbh.inc.php'; 
?>
<!--End of the include database connection-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="customer-container">
        <h1 class="customer-view">Customer View List</h1>
        <a class="btn btn-primary btn-sm" href="add_customer.php">Add Customer</a>

        <div class="table_container">
            <table class="customer-table table table-striped">
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
                    <!--Fetch data from customer table in database-->
                    <?php
                    $sql = "
                           SELECT c.id, c.title, c.first_name, c.middle_name, c.last_name, c.contact_no, d.district 
                           FROM customer c 
                           JOIN district d 
                           ON c.district = d.id";
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
                                    <a href='update_customer.php?id={$row['id']}' class='btn btn-primary btn-sm'>Update</a>
                                    <a href='delete_customer.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No customer details found!</td></tr>";
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

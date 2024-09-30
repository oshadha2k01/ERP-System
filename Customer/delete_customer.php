<?php
include('../includes/dbh.inc.php');

$id = $_GET['id'];

$sql = "DELETE FROM customer WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Customer deleted successfully!');
            window.location.href = 'view_customer.php';
          </script>";
} else {
    echo "<script>
            alert('Error deleting customer: " . $conn->error . "');
          </script>";
}
?>

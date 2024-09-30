<?php
include('../includes/dbh.inc.php');

$id = $_GET['id'];

$sql = "DELETE FROM item WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Item Details deleted successfully!');
            window.location.href = 'view_item.php';
          </script>";
} else {
    echo "<script>
            alert('Error deleting item details: " . $conn->error . "');
          </script>";
}
?>

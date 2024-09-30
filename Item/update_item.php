<?php
include('../includes/dbh.inc.php');

// Initialize variables for the item
$item = null;

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the item details from the database
    $sql = "SELECT * FROM item WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "<script>alert('Item not found.'); window.location.href='view_item.php';</script>";
        exit;
    }
}

// Get all item categories
$categories = [];
$sqlCategories = "SELECT id, category FROM item_category";
$resultCategories = $conn->query($sqlCategories);

if ($resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Get all item subcategories
$subcategories = [];
$sqlSubcategories = "SELECT id, sub_category FROM item_subcategory";
$resultSubcategories = $conn->query($sqlSubcategories);

if ($resultSubcategories->num_rows > 0) {
    while ($row = $resultSubcategories->fetch_assoc()) {
        $subcategories[] = $row;
    }
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get updated item details from the form
    $item_code = $_POST['item_code'];
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // PHP validation
    if (empty($item_code) || empty($item_category) || empty($item_subcategory) || empty($item_name) || empty($quantity) || empty($unit_price)) {
        $errorMessage = "All fields are required.";
    } elseif (!is_numeric($quantity) || $quantity < 0) {
        $errorMessage = "Please enter a valid quantity.";
    } elseif (!is_numeric($unit_price) || $unit_price < 0) {
        $errorMessage = "Please enter a valid unit price.";
    } else {
        // Update item in the database
        $sql = "UPDATE item 
                SET item_code = '$item_code', 
                    item_category = '$item_category', 
                    item_subcategory = '$item_subcategory', 
                    item_name = '$item_name', 
                    quantity = '$quantity', 
                    unit_price = '$unit_price' 
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Item updated successfully!');
                window.location.href = 'view_item.php';
              </script>";
        } else {
            echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/update_item.css">
</head>

<body>
    <div class="container update-container mt-5">
        <h2 class="text-center mb-3">Update Item</h2>
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        <!-- Update item form -->
        <form name="update_item" action="" method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="item_code">Item Code</label>
                    <input type="text" name="item_code" class="form-control" value="<?php echo $item['item_code']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="item_name">Item Name</label>
                    <input type="text" name="item_name" class="form-control" value="<?php echo $item['item_name']; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="item_category">Item Category</label>
                    <select class="form-control" name="item_category" required>
                        <option value="">-- Select Item Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $item['item_category']) ? 'selected' : ''; ?>>
                                <?php echo $category['category']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="item_subcategory">Item Subcategory</label>
                    <select class="form-control" name="item_subcategory" required>
                        <option value="">-- Select Item Subcategory --</option>
                        <?php foreach ($subcategories as $sub_category): ?>
                            <option value="<?php echo $sub_category['id']; ?>" <?php echo ($sub_category['id'] == $item['item_subcategory']) ? 'selected' : ''; ?>>
                                <?php echo $sub_category['sub_category']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="<?php echo $item['quantity']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="unit_price">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" class="form-control" value="<?php echo $item['unit_price']; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary w-100">Update Item</button>
                </div>
                <div class="col-md-6">
                    <a href="view_item.php" class="btn btn-secondary w-100">View Items</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

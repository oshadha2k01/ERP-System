<?php
include '../includes/dbh.inc.php';



// Get all item categories from the item_category table
$categories = [];
$sqlCategories = "SELECT id, category FROM item_category";
$resultCategories = $conn->query($sqlCategories);

if ($resultCategories->num_rows > 0) {
    while ($row = $resultCategories->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Get all item subcategories from the item_subcategory table
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
        // Insert data into the database
        $sql = "INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price)
            VALUES ('$item_code', '$item_category', '$item_subcategory', '$item_name', '$quantity', '$unit_price')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Item added successfully!');
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
    <title>Add Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/add_item.css">
    <script src="../js/add_item.js"></script>
</head>

<body>
    <div class="item-container">
        <h2 class="text-center mb-3">Add Item</h2>
        <form name="add_customer" action="" method="post" onsubmit="return validateForm()">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="item_code" class="form-label">Item Code</label>
                        <input type="text" name="item_code" class="form-control" placeholder="Item Code" required>
                        <span class="error-msg" id="itemcode-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" name="item_name" class="form-control" placeholder="Item Name"required>
                        <span class="error-msg" id="item-name-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="item_category" class="form-label">Item Category</label>
                        <select class="form-control" name="item_category" required>
                            <option value="">Select Item Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error-msg" id="item-category-error"></span>
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="item_subcategory" class="form-label">Item Sub Category</label>
                        <select class="form-control" name="item_subcategory" required>
                            <option value="">Select Item Subcategory </option>
                            <?php foreach ($subcategories as $sub_category): ?>
                                <option value="<?php echo $sub_category['id']; ?>"><?php echo $sub_category['sub_category']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error-msg" id="item-subcategory-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity"required>
                        <span class="error-msg" id="quantity-error"></span>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input type="number" step="0.01" name="unit_price" class="form-control" placeholder="Unit Parice"required>
                        <span class="error-msg" id="unit_price-error"></span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Add Item</button>
                <a href="view_item.php" class="btn btn-secondary">View Items</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

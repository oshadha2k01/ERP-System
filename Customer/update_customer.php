<?php
include '../includes/dbh.inc.php';

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];

    // Fetch the customer details from the database
    $sql = "SELECT * FROM customer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Customer not found.'); window.location.href = 'view_customer.php';</script>";
        exit();
    }

    $customer = $result->fetch_assoc();
}

// Get all districts from the district table
$districts = [];
$sqlDistricts = "SELECT id, district FROM district WHERE active = 'yes'";
$resultDistricts = $conn->query($sqlDistricts);

if ($resultDistricts->num_rows > 0) {
    while ($row = $resultDistricts->fetch_assoc()) {
        $districts[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact_no = $_POST['contact_no'];
    $district = $_POST['district']; 

    // PHP validation
    if (empty($title) || empty($first_name) || empty($last_name) || empty($contact_no) || empty($district)) {
        $errorMessage = "All fields are required.";
    } elseif (!is_numeric($contact_no) || strlen($contact_no) != 10) {
        $errorMessage = "Please enter a valid 10-digit contact number.";
    } else {
        // Update data in the database
        $sqlUpdate = "UPDATE customer SET title=?, first_name=?, middle_name=?, last_name=?, contact_no=?, district=? WHERE id=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ssssssi", $title, $first_name, $middle_name, $last_name, $contact_no, $district, $customerId);

        if ($stmtUpdate->execute() === TRUE) {
            echo "<script>
                    alert('Customer updated successfully!');
                    window.location.href = 'view_customer.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating customer: " . $conn->error . "');
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
    <title>Update Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Update Customer</h2>
        <form action="" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <select class="form-control" name="title" required>
                    <option value="">-- Select Title --</option>
                    <option value="Mr" <?php echo ($customer['title'] == 'Mr') ? 'selected' : ''; ?>>Mr</option>
                    <option value="Mrs" <?php echo ($customer['title'] == 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
                    <option value="Miss" <?php echo ($customer['title'] == 'Miss') ? 'selected' : ''; ?>>Miss</option>
                    <option value="Dr" <?php echo ($customer['title'] == 'Dr') ? 'selected' : ''; ?>>Dr</option>
                </select>  
            </div>
            <div class="mb-3">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $customer['first_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="middle_name">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" value="<?php echo $customer['middle_name']; ?>">
            </div>
            <div class="mb-3">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $customer['last_name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" value="<?php echo $customer['contact_no']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="district">District</label>
                <select class="form-control" name="district" required>
                    <option value="">-- Select District --</option>
                    <?php foreach ($districts as $districtOption): ?>
                        <option value="<?php echo $districtOption['id']; ?>" <?php echo ($districtOption['id'] == $customer['district']) ? 'selected' : ''; ?>><?php echo $districtOption['district']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Customer</button>
            <a href="view_customer.php" class="btn btn-secondary">Cancel</a>
        </form>    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>

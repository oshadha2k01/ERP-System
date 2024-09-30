<?php
include '../includes/dbh.inc.php';



// Get all districts from the district table
$districts = [];
$sqlDistricts = "SELECT id, district FROM district WHERE active = 'yes'";
$resultDistricts = $conn->query($sqlDistricts);

if ($resultDistricts->num_rows > 0) {
    while ($row = $resultDistricts->fetch_assoc()) {
        $districts[] = $row;
    }
}

$errorMessage = '';

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
        // Insert data into the database
        $sql = "INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district)
                VALUES ('$title', '$first_name', '$middle_name', '$last_name', '$contact_no', '$district')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Customer added successfully!');
                    window.location.href = 'view_customer.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error adding customer: " . $conn->error . "');
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
    <title>Add Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/add_customer.css">
    <script src="../js/add_customer.js"></script>
    <style>
        .add-container{
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;

    .form-control{
        border: 1px solid #000000;
    }
}
    </style>
</head>

<body>
    <div class="add-container">
        <h2 class="text-center mb-3">Add Customer</h2>
        <!-- Add customer form -->
        <form name="add_customer" action="" method="post" onsubmit="return validateForm()">
            <div class="mb-3 d-flex flex-column">
                <label for="title" class="form-label">Title</label>
                <select class="form-control" name="title" required>
                    <option value="">-- Select Title --</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                </select>
                <span class="error-msg" id="title-error"></span>
            </div>
            <div class="mb-3 d-flex flex-column">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
                <span class="error-msg" id="first-name-error"></span>
            </div>
            <div class="mb-3 d-flex flex-column">
                <label for="middle_name">Middle Name</label>
                <input type="text" class="form-control" name="middle_name">
                <span class="error-msg" id="middle-name-error"></span>
            </div>
            <div class="mb-3 d-flex flex-column">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
                <span class="error-msg" id="last-name-error"></span>
            </div>
            <div class="mb-3 d-flex flex-column">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" required>
                <span class="error-msg" id="contact-no-error"></span>
            </div>
            <div class="mb-3 d-flex flex-column">
                <label for="district">District</label>
                <select class="form-control" name="district" required>
                    <option value="">-- Select District --</option>
                    <?php foreach ($districts as $district): ?>
                        <option value="<?php echo $district['id']; ?>"><?php echo $district['district']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="error-msg" id="district-error"></span>
            </div>
            <button type="submit" class="btn btn-primary">Add Customer</button>
            <a href="view_customer.php" class="btn btn-secondary">View Customers</a>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'crud';
$table = 'invoice';

// Check if the ID is passed via GET
if (isset($_GET['ID'])) {
    $id = $_GET['ID'];
    $dsn = "mysql:host=$host; dbname=$dbname";
    $conn = new PDO($dsn, $username, $password);
    
    // Fetch current record from the database
    $sql = "SELECT * FROM $table WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $rez = $stmt->fetch();
}

// Handle form submission to update the record
if (isset($_POST['update'])) {
    $invoicenumber = $_POST['invoicenumber'];
    $companyname = $_POST['companyname'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $unitcost = $_POST['unitcost'];
    $totalprice = $_POST['totalprice'];

    // Check if all fields are filled
    if (empty($invoicenumber) || empty($companyname) || empty($address) || empty($description) || empty($unitcost) || empty($totalprice)) {
        die("Please fill all the inputs.");
    }

    // Update the record in the database
    try {
        $sql = "UPDATE $table SET InvoiceNumber = :invoicenr, CompanyName = :companyname, Address = :address, Description = :description, UnitCost = :unitcost, Total = :totalprice WHERE ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':invoicenr' => $invoicenumber,
            ':companyname' => $companyname,
            ':address' => $address,
            ':description' => $description,
            ':unitcost' => $unitcost,
            ':totalprice' => $totalprice,
            ':id' => $id
        ]);

        echo "Record updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
    <style>
        /* Your existing styles */
        form {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        form input[type="number"], form input[type="text"], form input[type="email"], form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        form textarea {
            resize: vertical;
            min-height: 120px;
            padding: 12px;
        }

        form input[type="submit"] {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        form input[type="submit"]:active {
            background-color: #003f7f;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <form action="update2.php?ID=<?php echo $id; ?>" method="POST">
        <input type="number" placeholder="Enter invoice number" name="invoicenumber" value="<?php echo htmlspecialchars($rez['InvoiceNumber']); ?>">
        <input type="text" placeholder="Enter company name" name="companyname" value="<?php echo htmlspecialchars($rez['CompanyName']); ?>">
        <input type="text" placeholder="Enter the address of the company" name="address" value="<?php echo htmlspecialchars($rez['Address']); ?>">
        <textarea placeholder="Describe" name="description"><?php echo htmlspecialchars($rez['Description']); ?></textarea>
        <input type="number" placeholder="Enter quantity" name="quantity" value="<?php echo htmlspecialchars($rez['UnitCost']); ?>">
        <input type="number" placeholder="Enter total price" name="totalprice" value="<?php echo htmlspecialchars($rez['Total']); ?>">
        <input type="submit" value="Update Invoice" name="update">
    </form>

</body>
</html>

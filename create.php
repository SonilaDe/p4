<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
/* General Form Styling */
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

/* Input Fields Styling */
form input[type="number"],
form input[type="text"],
form input[type="email"],
form textarea {
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

/* Placeholder Styling */
form input::placeholder,
form textarea::placeholder {
  color: #aaa;
  font-style: italic;
}

/* Textarea Specific Styling */
form textarea {
  resize: vertical;
  min-height: 120px;
  padding: 12px;
}

/* Focus Effect */
form input[type="number"]:focus,
form input[type="text"]:focus,
form input[type="email"]:focus,
form textarea:focus {
  border-color: #007BFF;
  box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
  outline: none;
}

/* Submit Button Styling */
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

/* Responsive Design */
@media (max-width: 768px) {
  form {
    padding: 20px;
  }
}


        </style>
</head>
<body>
    <form action="create.php" method="POST">
        <input type="number" placeholder="enter invoice number" name="invoicenumber">
        <input type="text" placeholder="enter company name" name="companyname">
        <input type="text" placeholder="enter the address of the company" name="address">
      <textarea placeholder="Describe"name="description"></textarea>
        <input type="number" placeholder="Unitcost" name="unitcost">
        <input type="number" placeholder="enter total price" name="totalprice">
        <input type="submit"value="Create invoice" name="create">
</form>

<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'crud';
$table = 'invoice';

if (isset($_POST['create'])) {
    $invoicenumber = $_POST['invoicenumber'];
    $companyname = $_POST['companyname'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $unitcost = $_POST['unitcost'];  // Make sure it's all lowercase
    $totalprice = $_POST['totalprice'];

    // Check if all required fields are filled
    if (empty($invoicenumber) || empty($companyname) || empty($address) || empty($description) || empty($unitcost) || empty($totalprice)) {
        die("Please fill all the inputs");
    }

    try {
        // Create PDO connection
        $dsn = "mysql:host=$host; dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL query
        $sql = "INSERT INTO $table (InvoiceNumber, CompanyName, Address, Description, UnitCost, Total) 
                VALUES (:invoicenr, :companyname, :address, :description, :unitcost, :totalprice)";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':invoicenr' => $invoicenumber,
            ':companyname' => $companyname,
            ':address' => $address,
            ':description' => $description,
            ':unitcost' => $unitcost,
            ':totalprice' => $totalprice
        ]);

        echo "Data inserted successfully";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




</body>
</html>
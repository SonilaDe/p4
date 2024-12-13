<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            border: 2px solid black;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 80%;
            padding: 8px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
        .total span {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Invoice Form</h2>
    <form action="form.php" method="POST">
        <!-- Client Information -->
        <div class="form-group">
            <label for="client_name">Client Name:</label>
            <input type="text" id="client_name" name="client_name" required>
        </div>

        <div class="form-group">
            <label for="client_address">Client Address:</label>
            <textarea id="client_address" name="client_address" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="invoice_date">Invoice Date:</label>
            <input type="date" id="invoice_date" name="invoice_date" required>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" required>
        </div>

        <!-- Item Details -->
        <h3>Item Details</h3>
        <table id="invoice_items">
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th><button type="button" onclick="addRow()">Add Item</button></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="item_description[]" required></td>
                    <td><input type="number" name="item_quantity[]" oninput="calculateTotal(this)" required></td>
                    <td><input type="number" name="item_price[]" oninput="calculateTotal(this)" required></td>
                    <td><span class="item_total">0.00</span></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

      
        <div class="total">
            <p><span>Subtotal: </span><span id="subtotal">0.00</span></p>
            <p><span>Tax (10%): </span><span id="tax">0.00</span></p>
            <p><span>Total Amount: </span><span id="total_amount">0.00</span></p>
        </div>

        <!-- Submit Button -->
   <button type="submit">Submit Invoice</button>
    </form>
</div>

<script>
    function addRow() {
        let table = document.getElementById('invoice_items').getElementsByTagName('tbody')[0];
        let row = table.insertRow();
        row.innerHTML = `
            <td><input type="text" name="item_description[]" required></td>
            <td><input type="number" name="item_quantity[]" oninput="calculateTotal(this)" required></td>
            <td><input type="number" name="item_price[]" oninput="calculateTotal(this)" required></td>
            <td><span class="item_total">0.00</span></td>
            <td></td>
        `;
    }

    function calculateTotal(element) {
        let row = element.closest('tr');
        let quantity = row.querySelector('[name="item_quantity[]"]').value;
        let price = row.querySelector('[name="item_price[]"]').value;
        let total = (quantity * price).toFixed(2);
        row.querySelector('.item_total').textContent = total;

        updateInvoiceSummary();
    }

    function updateInvoiceSummary() {
        let rows = document.querySelectorAll('#invoice_items tbody tr');
        let subtotal = 0;

        rows.forEach(row => {
            let itemTotal = parseFloat(row.querySelector('.item_total').textContent);
            if (!isNaN(itemTotal)) {
                subtotal += itemTotal;
            }
        });

        let tax = (subtotal * 0.10).toFixed(2);
        let totalAmount = (subtotal + parseFloat(tax)).toFixed(2);

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('tax').textContent = tax;
        document.getElementById('total_amount').textContent = totalAmount;
    }
</script>

<?php
$host='localhost';
$username='root';
$password='';
$dbname='invoice_system';
$table='invoive_items';


$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['submit'])) {
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['clients_id'];
    $email = $_POST['description'];
    $password = $_POST['quantity']; // You should hash passwords before saving to the database for security
    $price=$_POST['price'];
    $total=$_POST['total'];

    // SQL query to insert data into users table
    $sql = "INSERT INTO users (clients_id , description ,quantity, price , total) VALUES ('$name', '$email', '$password','$price' , '$total')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}}

$conn->close();
?>




</body>
</html>

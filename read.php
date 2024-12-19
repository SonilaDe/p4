<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: 'Arial', sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header Row Styling */
        th {
            background-color:lightsteelblue;
            color:Black;
            padding: 12px;
            text-align: left;
            font-size: 16px;
        }

        /* Table Rows Styling */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        /* Table Cell Styling */
        td {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            border: 2px solid #ddd;
        }

        /* Links Styling (Update/Delete) */
        a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            margin-right: 10px;
        }

        a:hover {
            color: #0056b3;
        }

        /* Hover Effect for Rows */
        tr:hover {
            background-color: #f1f1f1;
        }
        </style>
</head>
<body>
    <?php
$host='localhost';
$username='root';
$password='';
$dbname='crud';
$table='invoice';

try{
    $dsn="mysql:host=$host; dbname=$dbname";
    $conn=new PDO($dsn,$username,$password);
    $sql="SELECT * FROM $table";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $rezultati=$stmt->fetchAll();

echo "<table>

<tr>
<th>Invoice Number</th> <th>Company name</th>  <th>Address</th>  <th>Description</th>  <th>UnitCost</th>  <th>Total price</th> <th>Update/Delete</th> </tr>";
foreach($rezultati as $x){

    echo"<tr>
    <td>{$x['InvoiceNumber']}</td>
        <td>{$x['CompanyName']}</td>
            <td>{$x['Address']}</td>
             
                
                      <td>{$x['Description']}</td>
                            <td>{$x['UnitCost']}</td>
                                <td>{$x['Total']}</td>
                                  <td>
                                  
                                  
                                  <a href='update.php?ID={$x['Id']}'>Update</a>
                                  <a href='delete.php?ID={$x['Id']}'>Delete</a>


                                  </td>
                                </tr>
";


}
echo "</table>";
}
catch(PDOException $a){
    echo "error:" ,$a->getMessage();
}
    ?>

    <?php 
    if(isset($_GET['Delete'])){
        echo"<h2 id='h2'>Rekordi u fshi me sukses";
    }
    echo" 
    <script>
    setTimeout(function(){
    document.getElementById('h2').style.display='none';
},5000)
</script>"
;

    ?>
</body>
</html>
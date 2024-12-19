<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
$host='localhost';
$username='root';
$password='';
$dbname='crud';
$table='invoice';


if(isset($_GET['ID'])){
    $id=$_GET['ID'];



    try{
        $dsn="mysql:host=$host; dbname=$dbname";
$conn= new PDO($dsn, $username,$password);
$sql="DELETE FROM $table WHERE ID=:id";
$stmt=$conn->prepare($sql);
$stmt->execute([':id'=>$id]);
header("Location:read.php?Delete");
exit;


    }
    catch(PDOException $a){
        echo"error:" .$a->getMessage();
    }
}










?>
</body>
</html>
<?php 
$host = "localhost";
$dbname = "";
$username = "";
$password = "";
  
try {
    $connection = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
}

catch(PDOException $exception){
    echo "Error: " . $exception->getMessage();
}

?>



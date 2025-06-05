<?php 
$host = 'localhost'; // Change to your MySQL host 
$dbname = 'recipe_platform'; // Your database name 
$username = 'root'; // Your MySQL username 
$password = '1234'; // Your MySQL password 
 
try { 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); 
    // Set PDO error mode to exception 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) { 
    die("Could not connect to the database $dbname :" . $e->getMessage()); 
} 
?>
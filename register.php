<?php 
session_start(); 
include('db.php'); // Include the database connection 
 
// Handle registration 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
 
    // Check if the username already exists 
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username'); 
    $stmt->execute(['username' => $username]); 
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC); 
 
    if ($existingUser) { 
        $error = "Username already exists. Please choose another one."; 
    } else { 
        // Hash the password before saving it 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
 
        // Insert the new user into the database 
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, 
:password)'); 
        $stmt->execute([ 
            'username' => $username, 
            'password' => $hashedPassword 
        ]); 
 
        // Log the user in after successful registration 
        $_SESSION['username'] = $username; 
        header('Location: index.php'); 
        exit; 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Register</title> 
    <link rel="stylesheet" href="styles.css"> 
</head> 
<body> 
    <main> 
        <h2>Create an Account</h2> 
        <form method="POST"> 
            <label for="username">Username:</label> 
            <input type="text" name="username" id="username" required> 
             
            <label for="password">Password:</label> 
            <input type="password" name="password" id="password" required> 
             
            <button type="submit">Register</button> 
        </form> 
 
        <?php if (!empty($error)): ?> 
            <p class="error"><?= htmlspecialchars($error) ?></p> 
        <?php endif; ?> 
    </main> 
</body> 
</html>
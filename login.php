<?php 
session_start(); 
include('db.php');  
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
 
    // Prepare and execute SQL query to get the user data 
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username'); 
    $stmt->execute(['username' => $username]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
 
    // Check if the user exists and the password matches 
    if ($user && password_verify($password, $user['password'])) { 
        // Store user data in session 
        $_SESSION['username'] = $user['username']; 
        header('Location: index.php');  // Redirect to homepage 
        exit; 
    } else { 
        $error = "Invalid username or password."; 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login</title> 
    <link rel="stylesheet" href="styles.css"> 
</head> 
<body> 
    <main> 
        <h2>Login</h2> 
        <form method="POST"> 
            <label for="username">Username:</label> 
            <input type="text" name="username" id="username" required> 
             
            <label for="password">Password:</label> 
            <input type="password" name="password" id="password" required> 
             
            <button type="submit">Login</button> 
        </form> 
       
        <?php if (!empty($error)): ?> 
            <p class="error"><?= htmlspecialchars($error) ?></p> 
        <?php endif; ?> 
 
        <p>Don't have an account? <a href="register.php">Register here</a></p> 
    </main> 
</body> 
</html>
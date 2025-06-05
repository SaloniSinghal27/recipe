<?php 
session_start(); 
if (!isset($_SESSION['username'])) { 
    header('Location: login.php'); 
    exit; 
} 
 
// Load recipes 
$recipes = json_decode(file_get_contents("recipes.json"), true); 
$recipeId = $_GET['id'] ?? ''; 
$recipe = null; 
 
// Find the recipe by ID 
foreach ($recipes as $r) { 
    if ($r['id'] == $recipeId) { 
        $recipe = $r; 
        break; 
    } 
} 
 
if (!$recipe) { 
    echo "Recipe not found!"; 
    exit; 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title><?= htmlspecialchars($recipe['name']) ?></title> 
    <link rel="stylesheet" href="styles.css"> 
</head> 
<body> 
    <header> 
        <h1><?= htmlspecialchars($recipe['name']) ?></h1> 
        <a href="index.php">Back to Home</a> 
Saloni Singhal MCA I – SEC’C’ Roll No.:34 
    </header> 
 
    <main> 
        <p><?= htmlspecialchars($recipe['description']) ?></p> 
        <h3>Ingredients</h3> 
        <ul> 
            <?php foreach ($recipe['ingredients'] as $ingredient): ?> 
                <li><?= htmlspecialchars($ingredient) ?></li> 
            <?php endforeach; ?> 
        </ul> 
        <h3>Instructions</h3> 
        <p><?= nl2br(htmlspecialchars($recipe['instructions'])) ?></p> 
    </main> 
</body> 
</html> 
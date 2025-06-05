<?php 
session_start(); 
 
// Check if the user is logged in 
if (!isset($_SESSION['username'])) { 
    header('Location: login.php'); 
    exit; 
} 
 
// Load recipes 
$recipes = json_decode(file_get_contents("recipes.json"), true); 
$searchQuery = $_GET['search'] ?? ''; 
$filteredRecipes = []; 
 
// Filter recipes based on search query 
if (!empty($searchQuery)) { 
    foreach ($recipes as $recipe) { 
        if (stripos($recipe['name'], $searchQuery) !== false) { 
            $filteredRecipes[] = $recipe; 
        } 
    } 
} else { 
    $filteredRecipes = $recipes; 
} 
?> 
 
<!DOCTYPE html> 
<html lang="en"> 
 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Recipe Platform</title> 
    <link rel="stylesheet" href="styles.css"> 
</head> 
 
<body> 
    <header> 
        <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h1> 
        <nav> 
            <form method="GET"> 
                <input type="text" name="search" placeholder="Search recipes..." 
                    value="<?= htmlspecialchars($searchQuery) ?>" class="search-bar"> 
                <button type="submit">Search</button> 
            </form> 
            <a href="add_recipe.php" class="add-recipe-btn">Add Recipe</a> 
            <a href="logout.php">Logout</a> 
        </nav> 
 
    </header> 
 
    <main> 
        <h2>Recipes</h2> 
        <?php if (empty($filteredRecipes)): ?> 
        <p>No recipes found. Try searching for something else!</p> 
        <?php else: ?> 
        <ul> 
            <?php foreach ($filteredRecipes as $recipe): ?> 
            <li><a href="recipe.php?id=<?= $recipe['id'] ?>"><?= htmlspecialchars($recipe['name']) 
?></a></li> 
            <?php endforeach; ?> 
        </ul> 
        <?php endif; ?> 
    </main> 
</body> 
</html>
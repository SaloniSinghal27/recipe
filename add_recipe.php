<?php 
session_start(); 
if (!isset($_SESSION['username'])) { 
    header('Location: login.php'); 
    exit; 
} 
 
// Handle recipe submission 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $name = trim($_POST['name']); 
    $description = trim($_POST['description']); 
    $ingredients = explode("\n", trim($_POST['ingredients'])); 
    $instructions = trim($_POST['instructions']); 
 
    if ($name && $description && $ingredients && $instructions) { 
        $recipes = json_decode(file_get_contents('recipes.json'), true); 
 
        // Generate a unique ID for the new recipe 
        $newId = count($recipes) ? end($recipes)['id'] + 1 : 1; 
 
        $newRecipe = [ 
            'id' => $newId, 
            'name' => $name, 
            'description' => $description, 
            'ingredients' => $ingredients, 
            'instructions' => $instructions, 
        ]; 
 
        // Add new recipe to the list and save back to JSON 
        $recipes[] = $newRecipe; 
        file_put_contents('recipes.json', json_encode($recipes, JSON_PRETTY_PRINT)); 
 
        header('Location: index.php'); 
        exit; 
    } else { 
        $error = "All fields are required."; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Add a New Recipe</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="POST">
            <label for="name">Recipe Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter recipe name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="3" placeholder="Enter a brief description 
of the recipe" required></textarea>

            <label for="ingredients">Ingredients (one per line):</label>
            <textarea id="ingredients" name="ingredients" rows="5" placeholder="List the ingredients, one 
per line" required></textarea>

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" rows="8" placeholder="Enter the step-by-step 
instructions" required></textarea>

            <button type="submit">Add Recipe</button>
        </form>

        <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </main>
</body>

</html>
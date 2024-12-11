<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingredients = $_POST['ingredients'];

    // Получение списка рецептов, содержащих выбранные ингредиенты
    $placeholders = implode(',', array_fill(0, count($ingredients), '?'));
    $stmt = $pdo->prepare("SELECT r.* FROM recipes r 
                           JOIN recipe_ingredients ri ON r.id = ri.recipe_id 
                           WHERE ri.ingredient_id IN ($placeholders)");
    $stmt->execute($ingredients);
    $recipes = $stmt->fetchAll();

    echo json_encode($recipes);
    exit();
}
?>
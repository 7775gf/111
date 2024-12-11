<?php
function getUserById($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

function getRecipesByUserId($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE user_id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getFavoritesByUserId($pdo, $userId) {
    $stmt = $pdo->prepare('SELECT * FROM favorites WHERE user_id = ?');
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function getIngredientsByRecipeId($pdo, $recipeId) {
    $stmt = $pdo->prepare('SELECT * FROM ingredients WHERE recipe_id = ?');
    $stmt->execute([$recipeId]);
    return $stmt->fetchAll();
}
?>
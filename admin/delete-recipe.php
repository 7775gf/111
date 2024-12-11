<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM recipes WHERE id = ?');
    $stmt->execute([$recipeId]);

    header('Location: index.php');
    exit();
}
?>
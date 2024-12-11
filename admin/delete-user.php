<?php
include '../includes/db.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$userId]);

    header('Location: users.php');
    exit();
}
?>
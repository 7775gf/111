<?php
$route = $_GET['route'] ?? 'index';

switch ($route) {
    case 'index':
        include 'index.php';
        break;
    case 'recipe':
        include 'recipe.php';
        break;
    // Другие маршруты
    default:
        include '404.php';
}
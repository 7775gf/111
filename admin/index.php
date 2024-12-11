<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение списка рецептов
$stmt = $pdo->query('SELECT * FROM recipes ORDER BY created_at DESC');
$recipes = $stmt->fetchAll();
?>

<h1>Административная панель</h1>

<h2>Рецепты</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($recipes as $recipe): ?>
            <tr>
                <td><?= $recipe['id'] ?></td>
                <td><?= $recipe['title'] ?></td>
                <td><?= $recipe['description'] ?></td>
                <td>
                    <a href="edit-recipe.php?id=<?= $recipe['id'] ?>" class="btn btn-primary">Редактировать</a>
                    <a href="delete-recipe.php?id=<?= $recipe['id'] ?>" class="btn btn-danger">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'templates/footer.php'; ?>
<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение списка ингредиентов
$stmt = $pdo->query('SELECT * FROM shopping_list ORDER BY created_at DESC');
$shopping_list = $stmt->fetchAll();

// Обработка добавления ингредиента
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_ingredient'])) {
    $ingredient = $_POST['ingredient'];
    $calories = $_POST['calories'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare('INSERT INTO shopping_list (user_id, ingredient, calories, price) VALUES (1, ?, ?, ?)');
    $stmt->execute([$ingredient, $calories, $price]);

    header('Location: shopping-list.php');
    exit();
}

// Обработка удаления ингредиента
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_ingredient'])) {
    $ingredient_id = $_POST['ingredient_id'];

    $stmt = $pdo->prepare('DELETE FROM shopping_list WHERE id = ?');
    $stmt->execute([$ingredient_id]);

    header('Location: shopping-list.php');
    exit();
}
?>

<h1>Список покупок</h1>

<!-- Форма добавления ингредиента -->
<h2>Добавить ингредиент</h2>
<form action="shopping-list.php" method="post">
    <div class="form-group">
        <label for="ingredient">Ингредиент</label>
        <input type="text" name="ingredient" id="ingredient" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="calories">Калорийность</label>
        <input type="number" name="calories" id="calories" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="price">Цена</label>
        <input type="number" name="price" id="price" class="form-control" required>
    </div>
    <button type="submit" name="add_ingredient" class="btn btn-primary">Добавить</button>
</form>

<!-- Список ингредиентов -->
<h2>Ингредиенты</h2>
<ul class="list-group">
    <?php foreach ($shopping_list as $item): ?>
        <li class="list-group-item">
            <form action="shopping-list.php" method="post" style="display: inline;">
                <input type="hidden" name="ingredient_id" value="<?= $item['id'] ?>">
                <button type="submit" name="remove_ingredient" class="btn btn-danger btn-sm float-right">Удалить</button>
            </form>
            <strong><?= $item['ingredient'] ?></strong>
            <br>
            Калорийность: <?= $item['calories'] ?> ккал
            <br>
            Цена: <?= $item['price'] ?> руб.
        </li>
    <?php endforeach; ?>
</ul>

<!-- Кнопка заказа продуктов -->
<a href="https://dostavka.yandex.ru" class="btn btn-success mt-4" target="_blank">Заказать продукты</a>

<?php include 'templates/footer.php'; ?>
<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение информации о рецепте
if (isset($_GET['id'])) {
    $recipe_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch();

    // Получение похожих рецептов
    $keywords = explode(' ', $recipe['title']);
    $like_conditions = [];
    foreach ($keywords as $keyword) {
        $like_conditions[] = 'title LIKE ?';
    }
    $like_query = implode(' OR ', $like_conditions);

    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE ($like_query) AND id != ? LIMIT 3");
    $params = [];
    foreach ($keywords as $keyword) {
        $params[] = '%' . $keyword . '%';
    }
    $params[] = $recipe_id;
    $stmt->execute($params);
    $similar_recipes = $stmt->fetchAll();

    // Получение списка ингредиентов с количеством гр/мл
    $stmt = $pdo->prepare('SELECT ri.quantity, i.name, i.calories, i.price 
                           FROM recipe_ingredients ri 
                           JOIN ingredients i ON ri.ingredient_id = i.id 
                           WHERE ri.recipe_id = ?');
    $stmt->execute([$recipe_id]);
    $ingredients = $stmt->fetchAll();

    // Инициализация переменных для подсчета общей калорийности и цены
    $total_calories = 0;
    $total_price = 0;
}
?>

<h1><?= $recipe['title'] ?></h1>

<!-- Основная информация о рецепте -->
<div class="recipe-detail">
    <img src="<?= $recipe['image_url'] ?>" alt="<?= $recipe['title'] ?>" class="img-fluid mb-4">
    <p><strong>Описание:</strong> <?= $recipe['description'] ?></p>
    <p><strong>Инструкции:</strong> <?= $recipe['instructions'] ?></p>
    <p><strong>Длительность:</strong> <?= $recipe['duration'] ?> минут</p>
</div>

<!-- Список ингредиентов -->
<h2>Ингредиенты</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Ингредиент</th>
            <th>Количество (гр/мл)</th>
            <th>Калорийность</th>
            <th>Цена</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ingredients as $ingredient): ?>
            <?php
            // Расчет калорийности и цены на основе количества гр/мл
            $calories = $ingredient['calories'] * ($ingredient['quantity'] / 1000);
            $price = $ingredient['price'] * ($ingredient['quantity'] / 1000);

            // Суммирование общей калорийности и цены
            $total_calories += $calories;
            $total_price += $price;
            ?>
            <tr>
                <td><?= $ingredient['name'] ?></td>
                <td><?= $ingredient['quantity'] ?> гр/мл</td>
                <td><?= number_format($calories, 2) ?> ккал</td>
                <td><?= number_format($price, 2) ?> руб.</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Итого</th>
            <th></th>
            <th><?= number_format($total_calories, 2) ?> ккал</th>
            <th><?= number_format($total_price, 2) ?> руб.</th>
        </tr>
    </tfoot>
</table>

<!-- Блок "Смотрите также" -->
<h2>Смотрите также</h2>
<div class="row">
    <?php foreach ($similar_recipes as $similar_recipe): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= $similar_recipe['image_url'] ?>" class="card-img-top" alt="<?= $similar_recipe['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $similar_recipe['title'] ?></h5>
                    <p class="card-text"><?= $similar_recipe['description'] ?></p>
                    <a href="recipe_detail.php?id=<?= $similar_recipe['id'] ?>" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Кнопка "Добавить в календарь" -->
<div class="text-center mt-4">
    <button class="btn btn-secondary add-to-plan" data-recipe-id="<?= $recipe['id'] ?>">Добавить в календарь</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addToPlanButtons = document.querySelectorAll('.add-to-plan');

    addToPlanButtons.forEach(button => {
        button.addEventListener('click', function () {
            const recipeId = this.getAttribute('data-recipe-id');
            const date = prompt('Введите дату (в формате ГГГГ-ММ-ДД):');
            if (date) {
                // Отправка данных на сервер
                fetch('planning.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        recipe_id: recipeId,
                        date: date,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    // Обновление календаря
                    location.reload();
                });
            }
        });
    });
});
</script>

<?php include 'templates/footer.php'; ?>
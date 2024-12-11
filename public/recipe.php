<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение списка рецептов
$stmt = $pdo->query('SELECT * FROM recipes ORDER BY created_at DESC');
$recipes = $stmt->fetchAll();

// Обработка поискового запроса
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE title LIKE ? ORDER BY created_at DESC');
    $stmt->execute([$search]);
    $recipes = $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_recipe'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : []; // Проверяем, существует ли массив
    $instructions = $_POST['instructions'];
    $image_url = $_POST['image_url'];
    $duration = $_POST['duration'];

    // Проверяем, что массивы $ingredients и $quantities имеют одинаковую длину
    if (count($ingredients) !== count($quantities)) {
        echo '<div class="alert alert-danger">Ошибка: количество ингредиентов и количеств не совпадает.</div>';
        exit();
    }

    // Проверяем, что массив $quantities не пуст
    if (empty($quantities)) {
        echo '<div class="alert alert-danger">Ошибка: не указано количество для ингредиентов.</div>';
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO recipes (title, description, instructions, image_url, duration) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$title, $description, $instructions, $image_url, $duration]);
    $recipe_id = $pdo->lastInsertId();

    foreach ($ingredients as $index => $ingredient_id) {
        $quantity = $quantities[$index]; // Получаем количество гр/мл для каждого ингредиента
        $stmt = $pdo->prepare('INSERT INTO recipe_ingredients (recipe_id, ingredient_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$recipe_id, $ingredient_id, $quantity]);
    }

    header('Location: recipe.php');
    exit();
}
?>

<h1>Рецепты</h1>

<!-- Верхняя часть страницы -->
<div class="top-bar d-flex justify-content-between align-items-center mb-4">
    <!-- Поиск -->
    <form action="recipe.php" method="get" class="search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Поиск по названию">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Поиск</button>
            </div>
        </div>
    </form>

    <!-- Кнопки "Добавить рецепт" и "Рецепт из холодильника" -->
    <div class="buttons">
        <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#addRecipeModal">
            Добавить рецепт
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#findRecipeModal">
            Рецепт из холодильника
        </button>
    </div>
</div>

<!-- Список рецептов -->
<div class="row">
    <?php foreach ($recipes as $recipe): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= $recipe['image_url'] ?>" class="card-img-top" alt="<?= $recipe['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $recipe['title'] ?></h5>
                    <p class="card-text"><?= $recipe['description'] ?></p>
                    <a href="recipe_detail.php?id=<?= $recipe['id'] ?>" class="btn btn-primary">Подробнее</a>
                    <button class="btn btn-secondary add-to-plan" data-recipe-id="<?= $recipe['id'] ?>">Добавить в календарь</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Модальное окно для добавления нового рецепта -->
<div class="modal fade" id="addRecipeModal" tabindex="-1" role="dialog" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRecipeModalLabel">Добавить новый рецепт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="recipe.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Название рецепта</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ingredients">Ингредиенты</label>
                        <select id="ingredient-select" class="form-control">
                            <option value="">Выберите ингредиент</option>
                            <?php
                            $stmt = $pdo->query('SELECT * FROM ingredients');
                            while ($row = $stmt->fetch()): ?>
                                <option value="<?= $row['id'] ?>" data-calories="<?= $row['calories'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button type="button" id="add-ingredient" class="btn btn-primary mt-2">Добавить ингредиент</button>
                        <div id="ingredients-list" class="mt-2 row"></div>
                    </div>
                    <div class="form-group">
                        <label for="instructions">Инструкции</label>
                        <textarea name="instructions" id="instructions" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_url">URL изображения</label>
                        <input type="text" name="image_url" id="image_url" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Длительность (в минутах)</label>
                        <input type="number" name="duration" id="duration" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" name="add_recipe" class="btn btn-primary">Добавить рецепт</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для поиска рецептов по ингредиентам -->
<div class="modal fade" id="findRecipeModal" tabindex="-1" role="dialog" aria-labelledby="findRecipeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="findRecipeModalLabel">Рецепт из холодильника</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="find-recipe-form">
                    <div class="form-group">
                        <label for="ingredients">Ингредиенты</label>
                        <select id="ingredient-select-find" class="form-control">
                            <option value="">Выберите ингредиент</option>
                            <?php
                            $stmt = $pdo->query('SELECT * FROM ingredients');
                            while ($row = $stmt->fetch()): ?>
                                <option value="<?= $row['id'] ?>" data-calories="<?= $row['calories'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button type="button" id="add-ingredient-find" class="btn btn-primary mt-2">Добавить ингредиент</button>
                        <div id="ingredients-list-find" class="mt-2 row"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="button" id="find-recipe-button" class="btn btn-primary">Найти рецепт</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
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
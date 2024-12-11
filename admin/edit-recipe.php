<?php
include '../includes/db.php';
include 'templates/header.php';

if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
    $stmt->execute([$recipeId]);
    $recipe = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_recipe'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $ingredients = implode(',', $_POST['ingredients']);
        $instructions = $_POST['instructions'];
        $image_url = $_POST['image_url'];
        $duration = $_POST['duration'];

        $stmt = $pdo->prepare('UPDATE recipes SET title = ?, description = ?, ingredients = ?, instructions = ?, image_url = ?, duration = ? WHERE id = ?');
        $stmt->execute([$title, $description, $ingredients, $instructions, $image_url, $duration, $recipeId]);

        header('Location: index.php');
        exit();
    }
}
?>

<h1>Редактировать рецепт</h1>

<form action="edit-recipe.php?id=<?= $recipe['id'] ?>" method="post">
    <div class="form-group">
        <label for="title">Название рецепта</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $recipe['title'] ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <textarea name="description" id="description" class="form-control" required><?= $recipe['description'] ?></textarea>
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
        <div id="ingredients-list" class="mt-2">
            <?php
            $ingredients = explode(',', $recipe['ingredients']);
            foreach ($ingredients as $ingredient): ?>
                <div class="input-group mb-2">
                    <input type="hidden" name="ingredients[]" value="<?= $ingredient ?>">
                    <input type="text" class="form-control" value="<?= $ingredient ?>" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary remove-ingredient" type="button">Удалить</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="instructions">Инструкции</label>
        <textarea name="instructions" id="instructions" class="form-control" required><?= $recipe['instructions'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="image_url">URL изображения</label>
        <input type="text" name="image_url" id="image_url" class="form-control" value="<?= $recipe['image_url'] ?>" required>
    </div>
    <div class="form-group">
        <label for="duration">Длительность (в минутах)</label>
        <input type="number" name="duration" id="duration" class="form-control" value="<?= $recipe['duration'] ?>" required>
    </div>
    <button type="submit" name="edit_recipe" class="btn btn-primary">Сохранить изменения</button>
</form>

<?php include 'templates/footer.php'; ?>
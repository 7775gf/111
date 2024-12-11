<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение информации о пользователе
$user_id = 1; // Заглушка для текущего пользователя
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Получение списка рецептов, созданных пользователем
$stmt = $pdo->prepare('SELECT * FROM recipes WHERE user_id = ?');
$stmt->execute([$user_id]);
$user_recipes = $stmt->fetchAll();

// Получение списка избранных рецептов
$stmt = $pdo->prepare('SELECT * FROM favorites WHERE user_id = ?');
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();

// Обработка редактирования профиля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $preferences = $_POST['preferences'];

    $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, preferences = ? WHERE id = ?');
    $stmt->execute([$name, $email, $preferences, $user_id]);

    echo '<div class="alert alert-success" role="alert">Профиль успешно обновлен!</div>';
}
?>

<h1>Профиль</h1>

<!-- Информация о пользователе -->
<h2>Личная информация</h2>
<p><strong>Имя:</strong> <?= $user['name'] ?></p>
<p><strong>Email:</strong> <?= $user['email'] ?></p>
<p><strong>Предпочтения:</strong> <?= $user['preferences'] ?></p>

<!-- Рецепты, созданные пользователем -->
<h2>Мои рецепты</h2>
<div class="row">
    <?php foreach ($user_recipes as $recipe): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= $recipe['image_url'] ?>" class="card-img-top" alt="<?= $recipe['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $recipe['title'] ?></h5>
                    <p class="card-text"><?= $recipe['description'] ?></p>
                    <a href="recipe.php?id=<?= $recipe['id'] ?>" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Избранные рецепты -->
<h2>Избранное</h2>
<div class="row">
    <?php foreach ($favorites as $favorite): ?>
        <?php
        $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
        $stmt->execute([$favorite['recipe_id']]);
        $recipe = $stmt->fetch();
        ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?= $recipe['image_url'] ?>" class="card-img-top" alt="<?= $recipe['title'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $recipe['title'] ?></h5>
                    <p class="card-text"><?= $recipe['description'] ?></p>
                    <a href="recipe.php?id=<?= $recipe['id'] ?>" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- История действий -->
<h2>История действий</h2>
<ul class="list-group">
    <?php
    // Заглушка для истории действий
    $history = [
        ['action' => 'Просмотр рецепта', 'recipe_id' => 1, 'date' => '2023-10-01'],
        ['action' => 'Добавление рецепта в избранное', 'recipe_id' => 2, 'date' => '2023-10-02'],
        ['action' => 'Добавление рецепта в план питания', 'recipe_id' => 3, 'date' => '2023-10-03'],
    ];
    foreach ($history as $item): ?>
        <li class="list-group-item">
            <strong><?= $item['date'] ?>:</strong>
            <?= $item['action'] ?>
            <?php if (isset($item['recipe_id'])): ?>
                <?php
                $stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = ?');
                $stmt->execute([$item['recipe_id']]);
                $recipe = $stmt->fetch();
                ?>
                <a href="recipe.php?id=<?= $recipe['id'] ?>"><?= $recipe['title'] ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Форма редактирования профиля -->
<h2>Редактировать профиль</h2>
<form action="profile.php" method="post">
      <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" id="name" class="form-control" value="<?= $user['name'] ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
    </div>
    <div class="form-group">
        <label for="preferences">Предпочтения</label>
        <textarea name="preferences" id="preferences" class="form-control"><?= $user['preferences'] ?></textarea>
    </div>
    <button type="submit" name="edit_profile" class="btn btn-primary">Сохранить изменения</button>
</form>

<?php include 'templates/footer.php'; ?>
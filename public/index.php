<?php
include '../includes/db.php';
include 'templates/header.php';
?>
function renderRecipes($recipes) {
    foreach ($recipes as $recipe) {
        echo '<div class="col-md-4">';
        echo '<div class="card mb-4">';
        echo '<img src="' . $recipe['image_url'] . '" class="card-img-top" alt="' . $recipe['title'] . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $recipe['title'] . '</h5>';
        echo '<p class="card-text">' . $recipe['description'] . '</p>';
        echo '<a href="recipe.php?id=' . $recipe['id'] . '" class="btn btn-primary">Подробнее</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

<h1>Добро пожаловать на Food Planner!</h1>

<!-- Слайдер с популярными рецептами -->
<div class="slider">
    <?php
    $stmt = $pdo->query('SELECT * FROM recipes ORDER BY created_at DESC LIMIT 5');
    while ($row = $stmt->fetch()) {
        echo '<div>';
        echo '<img src="' . $row['image_url'] . '" alt="' . $row['title'] . '">';
        echo '<h3>' . $row['title'] . '</h3>';
        echo '</div>';
    }
    ?>
</div>

<!-- Блок с последними добавленными рецептами -->
<h2>Последние добавленные рецепты</h2>
<div class="row">
    <?php
    $stmt = $pdo->query('SELECT * FROM recipes ORDER BY created_at DESC LIMIT 6');
    while ($row = $stmt->fetch()) {
    renderRecipes($recipes);
    }
    ?>
</div>

<!-- Блок с рекомендациями -->
<h2>Рекомендации</h2>
<div class="row">
    <?php
    // Логика для рекомендаций (например, по предпочтениям пользователя)
    $stmt = $pdo->query('SELECT * FROM recipes ORDER BY created_at DESC LIMIT 6');
    while ($row = $stmt->fetch()) {
    renderRecipes($recipes);
    }
    ?>
</div>

<?php include 'templates/footer.php'; ?>
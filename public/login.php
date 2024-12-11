<?php
include '../includes/db.php';
include 'templates/header.php';

// Обработка входа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        echo '<div class="alert alert-success" role="alert">Вход выполнен успешно!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Неверный email или пароль!</div>';
    }
}
?>

<h1>Вход</h1>

<form action="login.php" method="post">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary">Войти</button>
</form>

<hr>

<p>Или войдите через Google:</p>
<a href="#" class="btn btn-danger">Вход через Google</a>

<?php include 'templates/footer.php'; ?>
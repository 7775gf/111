<?php
include '../includes/db.php';
include 'templates/header.php';

// Обработка регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        echo '<div class="alert alert-danger" role="alert">Заполните все поля!</div>';
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $password]);
        echo '<div class="alert alert-success" role="alert">Регистрация прошла успешно!</div>';
    }
}

<h1>Регистрация</h1>

<form action="register.php" method="post">
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Пароль</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" name="register" class="btn btn-primary">Зарегистрироваться</button>
</form>

<hr>

<p>Или зарегистрируйтесь через Google:</p>
<a href="#" class="btn btn-danger">Регистрация через Google</a>

<?php include 'templates/footer.php'; ?>
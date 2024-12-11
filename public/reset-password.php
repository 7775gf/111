<?php
include '../includes/db.php';
include 'templates/header.php';

// Обработка сброса пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE reset_token = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $pdo->prepare('UPDATE users SET password = ?, reset_token = NULL WHERE id = ?');
        $stmt->execute([$password, $user['id']]);

        echo '<div class="alert alert-success" role="alert">Пароль успешно изменен!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Неверный токен!</div>';
    }
}
?>

<h1>Сброс пароля</h1>

<form action="reset-password.php" method="post">
    <div class="form-group">
        <label for="password">Новый пароль</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
    <button type="submit" name="reset_password" class="btn btn-primary">Сбросить пароль</button>
</form>

<?php include 'templates/footer.php'; ?>
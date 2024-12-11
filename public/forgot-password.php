<?php
include '../includes/db.php';
include 'templates/header.php';

// Обработка восстановления пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Генерация токена для восстановления пароля
        $token = bin2hex(random_bytes(32));
        $stmt = $pdo->prepare('UPDATE users SET reset_token = ? WHERE id = ?');
        $stmt->execute([$token, $user['id']]);

        // Отправка письма с ссылкой для восстановления пароля
        $resetLink = 'http://yourdomain.com/reset-password.php?token=' . $token;
        $message = "Для восстановления пароля перейдите по ссылке: $resetLink";
        mail($email, 'Восстановление пароля', $message);

        echo '<div class="alert alert-success" role="alert">Ссылка для восстановления пароля отправлена на ваш email!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Пользователь с таким email не найден!</div>';
    }
}
?>

<h1>Восстановление пароля</h1>

<form action="forgot-password.php" method="post">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <button type="submit" name="forgot_password" class="btn btn-primary">Восстановить пароль</button>
</form>

<?php include 'templates/footer.php'; ?>
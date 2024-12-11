<?php
include '../includes/db.php';
include 'templates/header.php';

// Обработка отправки формы обратной связи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $message]);

    echo '<div class="alert alert-success" role="alert">Сообщение отправлено!</div>';
}
?>

<h1>Контакты</h1>

<h2>Контактная информация</h2>
<p><strong>Email:</strong> info@foodplanner.com</p>
<p><strong>Телефон:</strong> +7 (123) 456-78-90</p>
<p><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 1</p>

<h2>Форма обратной связи</h2>
<form action="contacts.php" method="post">
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="message">Сообщение</label>
        <textarea name="message" id="message" class="form-control" required></textarea>
    </div>
    <button type="submit" name="send_message" class="btn btn-primary">Отправить</button>
</form>

<?php include 'templates/footer.php'; ?>
<?php
include '../includes/db.php';
include 'templates/header.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $preferences = $_POST['preferences'];

        $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, preferences = ? WHERE id = ?');
        $stmt->execute([$name, $email, $preferences, $userId]);

        header('Location: users.php');
        exit();
    }
}
?>

<h1>Редактировать пользователя</h1>

<form action="edit-user.php?id=<?= $user['id'] ?>" method="post">
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
    <button type="submit" name="edit_user" class="btn btn-primary">Сохранить изменения</button>
</form>

<?php include 'templates/footer.php'; ?>
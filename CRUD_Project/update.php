<?php
require_once 'config.php';
$errors = [];
$id = $name = $email = $age = ''; // Initialize these variables

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id =?');
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die('User not found');
    }
    $name = $user['name'];
    $email = $user['email'];
    $age = $user['age'];
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    if (empty($email)) {
        $errors[] = 'Email is required';
    }
    if (empty($age)) {
        $errors[] = 'Age is required';
    }
    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE users SET name =?, email =?, age =? WHERE id =?');
        $stmt->execute([$name, $id, $ph_num, $id]);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Update User</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                <?php foreach ($errors as $key => $error):?>
                <li><?= "$key: $error"?></li>
                <?php endforeach;?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>"><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" ><br><br>
            <label for="age">Age:</label><br>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($age) ?>" ><br><br>
            <input type="submit" value="Update User">
        </form>
    </div>
</body>
</html>
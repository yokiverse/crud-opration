<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $stmt = $pdo->prepare('INSERT INTO users (name, email, age) VALUES (?, ?, ?)');
    $stmt->execute([$name, $email, $age]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <form action="create.php" method="POST">
        <input type="text" name="name" placeholder="Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="number" name="age" placeholder="Age"><br><br>
        <input type="submit" value="Add User">
    </form>
</body>
</html>

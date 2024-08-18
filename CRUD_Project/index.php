<?php
require_once 'config.php';

function getUsers($pdo) {
    $stmt = $pdo->query('SELECT * FROM users');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['delete'];

    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$id]);

    header("Location: index.php");
    exit();
}

$users = getUsers($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD Example</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= htmlspecialchars($user['age']) ?></td>
        <td>
            <form action="delete.php" method="POST" style="display: inline;">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit">Delete</button>
            </form>
            <form action="update.php" method="POST" style="display: inline;">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit">Update</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>


            </tbody>
        </table>
        <br>
        <a href="create.php">Add User</a>
    </div>
</body>
</html>

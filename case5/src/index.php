<?php
$host = 'mysql1'; // linked container name
$db   = 'mydb';
$user = 'root';
$pass = 'mydb6789tyui';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $stmt = $pdo->prepare("INSERT INTO message (content) VALUES (:content)");
    $stmt->execute(['content' => $_POST['message']]);
}

// Fetch all messages
$stmt = $pdo->query("SELECT * FROM message");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        input[type=text] { padding: 5px; width: 300px; }
        input[type=submit] { padding: 5px 10px; }
        ul { list-style: none; padding-left: 0; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h1>Message App</h1>
    <form method="POST">
        <input type="text" name="message" placeholder="Enter message" required>
        <input type="submit" value="Submit">
    </form>

    <h2>All Messages:</h2>
    <ul>
        <?php foreach ($messages as $msg): ?>
            <li><?php echo htmlspecialchars($msg['content']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>




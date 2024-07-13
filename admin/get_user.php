<?php
require '../config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} else {
    echo json_encode(['error' => 'User ID is required']);
}

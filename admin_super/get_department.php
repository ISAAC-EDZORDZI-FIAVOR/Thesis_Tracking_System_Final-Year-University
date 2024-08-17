<?php
require '../config.php';

if (isset($_GET['id'])) {
    $departmentId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
    $stmt->execute([$departmentId]);
    $department = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($department) {
        echo json_encode($department);
    } else {
        echo json_encode(['error' => 'Department not found']);
    }
} else {
    echo json_encode(['error' => 'Department ID is required']);
}

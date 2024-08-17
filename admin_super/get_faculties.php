<?php
require '../config.php';

if (isset($_GET['id'])) {
    $facultyId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ?");
    $stmt->execute([$facultyId]);
    $faculty = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($faculty) {
        echo json_encode($faculty);
    } else {
        echo json_encode(['error' => 'Faculty not found']);
    }
} else {
    echo json_encode(['error' => 'Faculty ID is required']);
}

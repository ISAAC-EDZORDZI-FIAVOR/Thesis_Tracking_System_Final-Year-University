<?php
require '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM chapter_type WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $chapter = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($chapter);
}

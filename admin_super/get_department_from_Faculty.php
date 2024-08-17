<?php
require '../config.php';

$faculty_id = $_GET['faculty_id'];
$query = "SELECT id, name FROM departments WHERE faculty_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$faculty_id]);
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($departments);
?>
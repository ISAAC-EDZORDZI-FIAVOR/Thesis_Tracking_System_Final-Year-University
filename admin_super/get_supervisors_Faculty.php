<?php
require '../config.php';

$faculty_id = $_GET['faculty_id'];
$department_id = $_GET['department_id'];
$query = "SELECT id, fullname FROM users WHERE role = 'lecturer' AND faculty_id = ? AND department_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$faculty_id, $department_id]);
$supervisors = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($supervisors);

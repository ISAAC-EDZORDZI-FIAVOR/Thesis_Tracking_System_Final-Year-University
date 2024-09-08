<?php
session_start();
require_once '../config.php';



$department_id = $_POST['department_id'] ?? null;

if (!$department_id) {
    echo json_encode([]);
    exit;
}

$query = "SELECT DISTINCT u.id, u.fullname 
          FROM users u
          JOIN assignments a ON u.id = a.primary_supervisor_id OR u.id = a.secondary_supervisor_id1 OR u.id = a.secondary_supervisor_id2
          WHERE u.role = 'lecturer' AND u.department_id = ?
          ORDER BY u.fullname";

$stmt = $pdo->prepare($query);
$stmt->execute([$department_id]);
$lecturers = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

header('Content-Type: application/json');
echo json_encode($lecturers);

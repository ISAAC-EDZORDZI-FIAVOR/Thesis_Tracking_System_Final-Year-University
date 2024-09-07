<?php
require '../config.php';

$departmentId = $_POST['department_id'];

$stmt = $pdo->prepare("SELECT id, fullname FROM users WHERE role = 'lecturer' AND department_id = ?");
$stmt->execute([$departmentId]);
$lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<option value=''>All Lecturers</option>";
foreach ($lecturers as $lecturer) {
    echo "<option value='{$lecturer['id']}'>{$lecturer['fullname']}</option>";
}

?>





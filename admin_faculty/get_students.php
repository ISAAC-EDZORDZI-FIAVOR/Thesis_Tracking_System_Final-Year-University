<?php
// Database connection
require '../config.php';

$departmentId = $_POST['department_id'];

// Get the list of students for the selected department
$query = "SELECT id, fullname FROM users WHERE role = 'student' AND department_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$departmentId]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build the HTML options for the student dropdown
$options = '<option value="">Select Student</option>';
foreach ($students as $student) {
    $options .= '<option value="' . $student['id'] . '">' . $student['fullname'] . '</option>';
}

echo $options;
?>

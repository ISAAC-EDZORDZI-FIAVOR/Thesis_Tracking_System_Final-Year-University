<?php
// Database connection
require '../config.php';

$departmentId = $_POST['department_id'];

// Get the list of lecturers for the selected department
$query = "SELECT id, fullname FROM users WHERE role = 'lecturer' AND department_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$departmentId]);
$lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Build the HTML options for the lecturer dropdown
$options = '<option value="">Select Lecturer</option>';
foreach ($lecturers as $lecturer) {
    $options .= '<option value="' . $lecturer['id'] . '">' . $lecturer['fullname'] . '</option>';
}

echo $options;
?>

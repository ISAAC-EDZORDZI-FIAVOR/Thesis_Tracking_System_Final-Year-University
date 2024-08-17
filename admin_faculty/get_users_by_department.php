<?php
require '../config.php';

if (isset($_POST['department_id']) && isset($_POST['type'])) {
    $department_id = $_POST['department_id'];
    $type = $_POST['type'];

    if ($type == 'students') {
        $query = "SELECT id, fullname FROM users WHERE department_id = ? AND role = 'student'";
    } else {
        $query = "SELECT id, fullname FROM users WHERE department_id = ? AND role = 'lecturer'";
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute([$department_id]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = '<option value="">Select ' . ucfirst($type) . '</option>';
    foreach ($users as $user) {
        $output .= '<option value="' . $user['id'] . '">' . $user['fullname'] . '</option>';
    }

    echo $output;
}

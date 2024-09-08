<?php
session_start();
require_once '../config.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dean') {
//     header('HTTP/1.1 403 Forbidden');
//     exit('Access denied');
// }

$department_id = $_POST['department'] ?? null;
$lecturer_id = $_POST['lecturer'] ?? null;

$query = "SELECT u.department_id, d.name as department_name, tp.status as proposal_status, 
    c1.status as chapter_one_status, 
    c2.status as chapter_two_status, 
    c3.status as chapter_three_status, 
    c4.status as chapter_four_status, 
    c5.status as chapter_five_status,
    a.primary_supervisor_id,
    a.secondary_supervisor_id1,
    a.secondary_supervisor_id2
    FROM users u 
    JOIN departments d ON u.department_id = d.id
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id 
    LEFT JOIN chapter_one c1 ON u.id = c1.student_id 
    LEFT JOIN chapter_two c2 ON u.id = c2.student_id 
    LEFT JOIN chapter_three c3 ON u.id = c3.student_id 
    LEFT JOIN chapter_four c4 ON u.id = c4.student_id 
    LEFT JOIN chapter_five c5 ON u.id = c5.student_id 
    LEFT JOIN assignments a ON u.id = a.student_id
    WHERE u.role = 'student'";

$params = [];

if ($department_id) {
    $query .= " AND u.department_id = ?";
    $params[] = $department_id;
}

if ($lecturer_id) {
    $query .= " AND (a.primary_supervisor_id = ? OR a.secondary_supervisor_id1 = ? OR a.secondary_supervisor_id2 = ?)";
    $params = array_merge($params, [$lecturer_id, $lecturer_id, $lecturer_id]);
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$departmentData = [];
foreach ($students as $student) {
    $dept_id = $student['department_id'];
    if (!isset($departmentData[$dept_id])) {
        $departmentData[$dept_id] = [
            'name' => $student['department_name'],
            'proposal' => 0,
            'chapter_one' => 0,
            'chapter_two' => 0,
            'chapter_three' => 0,
            'chapter_four' => 0,
            'chapter_five' => 0,
            'total' => 0
        ];
    }
    $departmentData[$dept_id]['total']++;
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        if ($student[$stage . '_status'] == 'approved') {
            $departmentData[$dept_id][$stage]++;
        }
    }
}

$filteredData = [];
foreach ($departmentData as $dept_id => $data) {
    $filteredData[$dept_id] = [
        'name' => $data['name'],
        'percentages' => []
    ];
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        $filteredData[$dept_id]['percentages'][$stage] = $data['total'] > 0 ? round(($data[$stage] / $data['total']) * 100, 2) : 0;
    }
}

header('Content-Type: application/json');
echo json_encode($filteredData);

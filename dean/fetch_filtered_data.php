<?php
session_start();
require_once '../config.php';

$department_id = $_POST['department'] ?? null;
$lecturer_id = $_POST['lecturer'] ?? null;

$query = "SELECT 
    u.department_id, 
    d.name as department_name,
    COUNT(DISTINCT u.id) as total_students,
    SUM(CASE WHEN tp.status = 'approved' THEN 1 ELSE 0 END) as proposal_completed,
    SUM(CASE WHEN c1.status = 'approved' THEN 1 ELSE 0 END) as chapter_one_completed,
    SUM(CASE WHEN c2.status = 'approved' THEN 1 ELSE 0 END) as chapter_two_completed,
    SUM(CASE WHEN c3.status = 'approved' THEN 1 ELSE 0 END) as chapter_three_completed,
    SUM(CASE WHEN c4.status = 'approved' THEN 1 ELSE 0 END) as chapter_four_completed,
    SUM(CASE WHEN c5.status = 'approved' THEN 1 ELSE 0 END) as chapter_five_completed
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

$query .= " GROUP BY u.department_id, d.name";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$departmentData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filteredData = [];
foreach ($departmentData as $dept) {
    $dept_id = $dept['department_id'];
    $filteredData[$dept_id] = [
        'name' => $dept['department_name'],
        'total_students' => $dept['total_students'],
        'completed' => [
            'proposal' => $dept['proposal_completed'],
            'chapter_one' => $dept['chapter_one_completed'],
            'chapter_two' => $dept['chapter_two_completed'],
            'chapter_three' => $dept['chapter_three_completed'],
            'chapter_four' => $dept['chapter_four_completed'],
            'chapter_five' => $dept['chapter_five_completed']
        ],
        'percentages' => []
    ];
    
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        $filteredData[$dept_id]['percentages'][$stage] = 
            $dept['total_students'] > 0 ? 
            round(($dept[$stage . '_completed'] / $dept['total_students']) * 100, 2) : 0;
    }
}

header('Content-Type: application/json');
echo json_encode($filteredData);

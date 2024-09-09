<?php
require_once '../config.php';

$student_id = $_POST['student_id'] ?? null;

if (!$student_id) {
    echo "No student selected";
    exit;
}

$stmt = $pdo->prepare("
    SELECT
        u.fullname AS student_name,
        tp.status as proposal_status,
        tp.submission_date as proposal_submission_date,
        tp.lecturer_comment_time as proposal_comment_time,
        c1.status as chapter_one_status,
        c1.submission_date as chapter_one_submission_date,
        c1.lecturer_comment_time as chapter_one_comment_time,
        c2.status as chapter_two_status,
        c2.submission_date as chapter_two_submission_date,
        c2.lecturer_comment_time as chapter_two_comment_time,
        c3.status as chapter_three_status,
        c3.submission_date as chapter_three_submission_date,
        c3.lecturer_comment_time as chapter_three_comment_time,
        c4.status as chapter_four_status,
        c4.submission_date as chapter_four_submission_date,
        c4.lecturer_comment_time as chapter_four_comment_time,
        c5.status as chapter_five_status,
        c5.submission_date as chapter_five_submission_date,
        c5.lecturer_comment_time as chapter_five_comment_time,
        GREATEST(
            COALESCE(tp.submission_date, '1970-01-01'),
            COALESCE(tp.lecturer_comment_time, '1970-01-01'),
            COALESCE(c1.submission_date, '1970-01-01'),
            COALESCE(c1.lecturer_comment_time, '1970-01-01'),
            COALESCE(c2.submission_date, '1970-01-01'),
            COALESCE(c2.lecturer_comment_time, '1970-01-01'),
            COALESCE(c3.submission_date, '1970-01-01'),
            COALESCE(c3.lecturer_comment_time, '1970-01-01'),
            COALESCE(c4.submission_date, '1970-01-01'),
            COALESCE(c4.lecturer_comment_time, '1970-01-01'),
            COALESCE(c5.submission_date, '1970-01-01'),
            COALESCE(c5.lecturer_comment_time, '1970-01-01')
        ) AS last_interaction_date
    FROM
        users u
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id
    LEFT JOIN chapter_one c1 ON u.id = c1.student_id
    LEFT JOIN chapter_two c2 ON u.id = c2.student_id
    LEFT JOIN chapter_three c3 ON u.id = c3.student_id
    LEFT JOIN chapter_four c4 ON u.id = c4.student_id
    LEFT JOIN chapter_five c5 ON u.id = c5.student_id
    WHERE u.id = ?
");

$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    echo "Student not found";
    exit;
}

echo "<h4 class='card-header bg-primary text-white'>{$student['student_name']}</h4>";
echo "<table class='table table-bordered'>";
echo "<thead><tr><th>Stage</th><th>Status</th><th>Submission Date</th><th>Last Interaction</th></tr></thead>";
echo "<tbody>";

$stages = [
    'Proposal' => ['proposal_status', 'proposal_submission_date', 'proposal_comment_time'],
    'Chapter 1' => ['chapter_one_status', 'chapter_one_submission_date', 'chapter_one_comment_time'],
    'Chapter 2' => ['chapter_two_status', 'chapter_two_submission_date', 'chapter_two_comment_time'],
    'Chapter 3' => ['chapter_three_status', 'chapter_three_submission_date', 'chapter_three_comment_time'],
    'Chapter 4' => ['chapter_four_status', 'chapter_four_submission_date', 'chapter_four_comment_time'],
    'Chapter 5' => ['chapter_five_status', 'chapter_five_submission_date', 'chapter_five_comment_time']
];

foreach ($stages as $stage => $fields) {
    echo "<tr>";
    echo "<td>{$stage}</td>";
    echo "<td>" . getStatusBadge($student[$fields[0]]) . "</td>";
    
    if ($student[$fields[1]]) {
        echo "<td>" . $student[$fields[1]] . "</td>";
        
        $last_interaction = max($student[$fields[1]], $student[$fields[2]] ?? '1970-01-01');
        $formatted_date = date('j l Y', strtotime($last_interaction));
        $days_since = (new DateTime())->diff(new DateTime($last_interaction))->days;
        
        echo "<td>{$formatted_date} ({$days_since} days ago)</td>";
    } else {
        echo "<td>Not submitted</td>";
        echo "<td>Not submitted</td>";
    }
    
    echo "</tr>";
}


echo "</tbody></table>";

// Last overall interaction
// Last overall interaction
if ($student['last_interaction_date'] != '1970-01-01') {
    $formatted_last_interaction = date('j l Y', strtotime($student['last_interaction_date']));
    $days_since_last_interaction = (new DateTime())->diff(new DateTime($student['last_interaction_date']))->days;
    echo "<p class='text-center'>Last Overall Interaction: {$formatted_last_interaction} ({$days_since_last_interaction} days ago)</p>";
} else {
    echo "<p class='text-center'>Last Overall Interaction: Not submitted yet</p>";
}


function getStatusBadge($status) {
    switch ($status) {
        case 'approved':
            return '<span class="badge bg-success">Approved</span>';
        case 'pending':
            return '<span class="badge bg-warning">Pending</span>';
        case 'revise':
            return '<span class="badge bg-warning">Revise</span>';
        case 'rejected':
            return '<span class="badge bg-danger">Rejected</span>';
        default:
            return '<span class="badge bg-secondary">Not Started</span>';
    }
}
?>

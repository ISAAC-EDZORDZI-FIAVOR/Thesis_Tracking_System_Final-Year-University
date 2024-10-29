<?php
require_once '../config.php';

$departmentId = $_POST['department'] ?? null;
$lecturerId = $_POST['lecturer'] ?? null;

$query = "
    SELECT
        u.id AS student_id,
        u.username as student_username,
        u.fullname AS student_name,
        d.name AS department_name,
        l.fullname AS lecturer_name,
        tp.status as proposal_status,
        tp.submission_date as proposal_submission_date,
        c1.status as chapter_one_status,
        c2.status as chapter_two_status,
        c3.status as chapter_three_status,
        c4.status as chapter_four_status,
        c5.status as chapter_five_status,
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
        ) AS last_interaction_date,
        DATEDIFF(CURDATE(),
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
            )
        ) AS days_since_last_interaction
    FROM
        users u
    JOIN departments d ON u.department_id = d.id
    JOIN assignments a ON u.id = a.student_id
    JOIN users l ON a.primary_supervisor_id = l.id
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id
    LEFT JOIN chapter_one c1 ON u.id = c1.student_id
    LEFT JOIN chapter_two c2 ON u.id = c2.student_id
    LEFT JOIN chapter_three c3 ON u.id = c3.student_id
    LEFT JOIN chapter_four c4 ON u.id = c4.student_id
    LEFT JOIN chapter_five c5 ON u.id = c5.student_id
    WHERE 1=1
";

$params = [];

if ($departmentId) {
    $query .= " AND d.id = ?";
    $params[] = $departmentId;
}

if ($lecturerId) {
    $query .= " AND (a.primary_supervisor_id = ? OR a.secondary_supervisor_id1 = ? OR a.secondary_supervisor_id2 = ?)";
    $params[] = $lecturerId;
    $params[] = $lecturerId;
    $params[] = $lecturerId;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "<div class='card full-width-card'>
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Department</th>
                                <th>Proposal</th>
                                <th>Chapter 1</th>
                                <th>Chapter 2</th>
                                <th>Chapter 3</th>
                                <th>Chapter 4</th>
                                <th>Chapter 5</th>
                                <th>Last Interaction</th>
                            </tr>
                        </thead>
                        <tbody>";

foreach ($results as $row) {
    $html .= "<tr>
                <td>{$row['student_username']}</td>
                <td>{$row['student_name']}</td>
                <td>{$row['department_name']}</td>
                <td>" . getStatusBadge($row['proposal_status']) . "</td>
                <td>" . getStatusBadge($row['chapter_one_status']) . "</td>
                <td>" . getStatusBadge($row['chapter_two_status']) . "</td>
                <td>" . getStatusBadge($row['chapter_three_status']) . "</td>
                <td>" . getStatusBadge($row['chapter_four_status']) . "</td>
                <td>" . getStatusBadge($row['chapter_five_status']) . "</td>";
    
    if ($row['proposal_submission_date']) {
        $interactionClass = $row['days_since_last_interaction'] > 30 ? 'text-danger' : '';
        $html .= "<td class='{$interactionClass}'>{$row['days_since_last_interaction']} days ago</td>";
    } else {
        $html .= "<td class='text-danger'>Proposal not submitted</td>";
    }
    
    $html .= "</tr>";
}

$html .= "      </tbody>
            </table>
        </div>
    </div>
</div>";

echo $html;

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

<?php
session_start();
require_once '../config.php';

// Check if user is logged in and has appropriate permissions
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "hod") {
    header("Location: ../admin/auth-signin.php");
    exit();
}



// Fetch the department information for the HOD
$stmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
$stmt->execute([$_SESSION['department_id']]);
$department = $stmt->fetch(PDO::FETCH_ASSOC);



$stmt = $pdo->prepare("SELECT id as student_id, fullname as student_name FROM users WHERE role = 'student' AND department_id = ?");
$stmt->execute([$_SESSION['department_id']]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</head>
<body>
    

    


    <div id="dashboardContent">

    <div class="row mb-4 mt-4">
        <div class="col-md-6">
            <select id="studentSelect" class="form-select">
                <option value="">Select a student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?php echo $student['student_id']; ?>"><?php echo $student['student_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


    <div id="studentDetails" class="card mb-4" style="display: none;">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Student Details</h5>
        </div>
        <div class="card-body">
            <!-- Student details will be populated here -->
        </div>
    </div>

    <div class='card mb-4'>
        <div class='card-header bg-primary text-white'>
            <h4 class='text-white'><?php echo $department['name']; ?> Department</h4>
        </div>
        <div class='card-body'>
            <?php
            // Fetch lecturers in this department
            $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'lecturer' AND department_id = ?");
            $stmt->execute([$department['id']]);
            $lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($lecturers as $lecturer) {
                echo "<div class='card mb-3'>";
                echo "<div class='card-header bg-secondary text-white'><p class='text-white'>{$lecturer['fullname']}</p></div>";
                echo "<div class='card-body'>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr><th>ID</th><th>Student Name</th><th>Proposal</th><th>Chapter 1</th><th>Chapter 2</th><th>Chapter 3</th><th>Chapter 4</th><th>Chapter 5</th><th>Last Interaction</th></tr></thead>";
                echo "<tbody>";
           
                // Fetch assigned students and their progress
                $stmt = $pdo->prepare("
                    SELECT
                        u.id AS student_id,
                        u.username as student_username,
                        u.fullname AS student_name,
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
                    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id
                    LEFT JOIN chapter_one c1 ON u.id = c1.student_id
                    LEFT JOIN chapter_two c2 ON u.id = c2.student_id
                    LEFT JOIN chapter_three c3 ON u.id = c3.student_id
                    LEFT JOIN chapter_four c4 ON u.id = c4.student_id
                    LEFT JOIN chapter_five c5 ON u.id = c5.student_id
                    JOIN assignments a ON u.id = a.student_id
                    WHERE
                        a.primary_supervisor_id = ? OR a.secondary_supervisor_id1 = ? OR a.secondary_supervisor_id2 = ?
                ");
                $stmt->execute([$lecturer['id'], $lecturer['id'], $lecturer['id']]);
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
                foreach ($students as $student) {
                    echo "<tr>";
                    echo "<td>{$student['student_username']}</td>";
                    echo "<td>{$student['student_name']}</td>";
                    echo "<td>" . getStatusBadge($student['proposal_status']) . "</td>";
                    echo "<td>" . getStatusBadge($student['chapter_one_status']) . "</td>";
                    echo "<td>" . getStatusBadge($student['chapter_two_status']) . "</td>";
                    echo "<td>" . getStatusBadge($student['chapter_three_status']) . "</td>";
                    echo "<td>" . getStatusBadge($student['chapter_four_status']) . "</td>";
                    echo "<td>" . getStatusBadge($student['chapter_five_status']) . "</td>";
                   
                    if ($student['proposal_submission_date']) {
                        $interactionClass = $student['days_since_last_interaction'] > 30 ? 'text-danger' : '';
                        echo "<td class='{$interactionClass}'>{$student['days_since_last_interaction']} days ago</td>";
                    } else {
                        echo "<td class='text-danger'>Proposal not submitted</td>";
                    }
                   
                    echo "</tr>";
                }
               
                echo "</tbody></table>";
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
</div>

<?php
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
<script>
$(document).ready(function() {
    $('#studentSelect').change(function() {
        var studentId = $(this).val();
        if (studentId) {
            $.ajax({
    url: 'get_student_details.php',
    method: 'POST',
    data: { student_id: studentId },
    success: function(response) {
        $('#studentDetails').html(response).show();
    },
    error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        $('#studentDetails').html("Error fetching student details").show();
    }
});

        } else {
            $('#studentDetails').hide();
        }
    });
});
</script>

</body>

</html>

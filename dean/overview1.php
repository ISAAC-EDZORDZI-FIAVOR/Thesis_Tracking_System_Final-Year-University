<?php
session_start();
require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TTS - Dean Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    $stmt = $pdo->prepare("SELECT * FROM departments WHERE faculty_id = ?");
    $stmt->execute([$_SESSION['faculty_id']]);
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <div class="container-fluid mt-4">
        <h1 class="mb-4">Faculty Dashboard</h1>

        <form id="filterForm" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select id="departmentFilter" name="department" class="form-control">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?php echo $dept['id']; ?>"><?php echo $dept['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="lecturerFilter" name="lecturer" class="form-control">
                        <option value="">All Lecturers</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </div>
        </form>

        <div id="dashboardContent">
            <!-- Initial dashboard content will be loaded here -->
           
            <?php
                // Fetch all departments in the faculty
                $stmt = $pdo->prepare("SELECT * FROM departments WHERE faculty_id = ?");
                $stmt->execute([$_SESSION['faculty_id']]);
                $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($departments as $department) {
                    echo "<div class='card mb-4'>";
                    echo "<div class='card-header bg-primary text-center text-white'><h2>{$department['name']}</h2></div>";
                    echo "<div class='card-body'>";

                    // Fetch lecturers in this department
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'lecturer' AND department_id = ?");
                    $stmt->execute([$department['id']]);
                    $lecturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($lecturers as $lecturer) {
                        echo "<div class='card mb-3'>";
                        echo "<div class='card-header bg-secondary text-white'><h3>{$lecturer['fullname']}</h3></div>";
                        echo "<div class='card-body'>";
                        echo "<table class='table table-striped'>";
                        echo "<thead><tr><th>ID</th><th>Student Name</th><th>Proposal</th><th>Chapter 1</th><th>Chapter 2</th><th>Chapter 3</th><th>Chapter 4</th><th>Chapter 5</th><th>Last Interaction</th></tr></thead>";
                        echo "<tbody>";
                    
                        // Updated query to fetch assigned students and last interaction
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

                    echo "</div></div>";
                }

                function getStatusBadge($status) {
                    switch ($status) {
                        case 'approved':
                            return '<span class="badge bg-success">Approved</span>';
                        case 'pending':
                            return '<span class="badge bg-warning">Pending</span>';
                        case 'rejected':
                            return '<span class="badge bg-danger">Rejected</span>';
                        default:
                            return '<span class="badge bg-secondary">Not Started</span>';
                    }
                }
            ?>

                
        </div>
    </div>
    </div>
    
    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script>
        $(document).ready(function() 
        {
            // Load initial dashboard content
            // loadDashboardContent();

            $('#departmentFilter').change(function() {
                var departmentId = $(this).val();
                $.ajax({
                    url: 'get_lecturers.php',
                    method: 'POST',
                    data: { department_id: departmentId },
                    success: function(response) {
                        $('#lecturerFilter').html(response);
                    }
                });
            });

            $('#filterForm').submit(function(e) {
                e.preventDefault();
                loadDashboardContent();
            });

            function loadDashboardContent() {
                $.ajax({
                    url: 'filter_dashboard.php',
                    method: 'POST',
                    data: $('#filterForm').serialize(),
                    success: function(response) {
                        $('#dashboardContent').html(response);
                    }
                });
            }
        });

    </script>
</body>
</html>

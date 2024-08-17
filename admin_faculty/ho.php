<?php
// Start session
session_start();

// Check if the user is logged in and has the 'admin' role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth-signin.php");
    exit();
}

// Database connection
require '../config.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $lecturerId = $_POST['lecturer_id'];
    $departmentId = $_POST['department_id'];

    // Check if the student is already assigned a supervisor
    $query = "SELECT * FROM assignments WHERE student_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$studentId]);
    $result = $stmt->fetchAll();

    if (count($result) > 0) {
        // Student is already assigned a supervisor
        $error = "This student is already assigned a supervisor.";
    } else {
        // Assign the student to the selected lecturer
        $query = "INSERT INTO assignments (student_id, lecturer_id, department_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentId, $lecturerId, $departmentId]);

        if ($stmt->rowCount() > 0) {
            $success = "Student assigned successfully.";
        } else {
            $error = "Failed to assign the student.";
        }
    }





    // Get the list of assigned supervisors

}

// Get the list of departments
$query = "SELECT * FROM departments";
$stmt = $pdo->query($query);
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);



$query = "SELECT * FROM assignments_list";
$stmt = $pdo->query($query);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Supervisor</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>Assign Supervisor</h1>
    
    <?php
    if (isset($success)) {
        echo "<p style='color: green;'>" . $success . "</p>";
    }
    if (isset($error)) {
        echo "<p style='color: red;'>" . $error . "</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="department">Select Department:</label>
        <select name="department_id" id="department" required>
            <option value="">Select Department</option>
            <?php foreach ($departments as $department): ?>
                <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="student">Select Student:</label>
        <select name="student_id" id="student" required>
            <option value="">Select Student</option>
        </select>

        <label for="lecturer">Select Lecturer:</label>
        <select name="lecturer_id" id="lecturer" required>
            <option value="">Select Lecturer</option>
        </select>

        <input type="submit" value="Assign Supervisor">
    </form>




    <h2>Assigned Supervisors</h2>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Lecturer Name</th>
                <th>Department</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $assignment): ?>
                <tr>
                    <td><?php echo $assignment['student_name']; ?></td>
                    <td><?php echo $assignment['lecturer_name']; ?></td>
                    <td><?php echo $assignment['department_name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    $(document).ready(function() {
        $('#department').on('change', function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: 'get_students.php',
                    type: 'POST',
                    data: {department_id: departmentId},
                    success: function(response) {
                        $('#student').html(response);
                    }
                });
                $.ajax({
                    url: 'get_lecturers.php',
                    type: 'POST',
                    data: {department_id: departmentId},
                    success: function(response) {
                        $('#lecturer').html(response);
                    }
                });
            } else {
                $('#student').html('<option value="">Select Student</option>');
                $('#lecturer').html('<option value="">Select Lecturer</option>');
            }
        });
    });
    </script>
</body>
</html>

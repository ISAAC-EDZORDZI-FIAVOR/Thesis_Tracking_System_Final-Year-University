<?php
session_start();
include_once('../config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../admin/auth-signin.php");
    exit();
}

$student_id = $_SESSION['user_id'];

$query = "SELECT chapter_number, MAX(status) as status FROM chapter_progress WHERE student_id = ? GROUP BY chapter_number";
$stmt = $pdo->prepare($query);
$stmt->execute([$student_id]);
$chapter_statuses = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Progress Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Thesis Progress Dashboard</h1>
        <div class="progress mb-4" style="height: 30px;">
            <?php
            $total_chapters = 5;
            $completed_chapters = count(array_filter($chapter_statuses, function($status) { return $status === 'accepted'; }));
            $progress_percentage = ($completed_chapters / $total_chapters) * 100;
            ?>
            <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_percentage; ?>%;" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo round($progress_percentage); ?>%</div>
        </div>
        <div class="row">
            <?php for ($i = 1; $i <= $total_chapters; $i++): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Chapter <?php echo $i; ?></h5>
                            <?php
                            $status = $chapter_statuses[$i] ?? 'Not started';
                            $status_class = $status === 'accepted' ? 'text-success' : ($status === 'rejected' ? 'text-danger' : 'text-warning');
                            ?>
                            <p class="card-text <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></p>
                            <a href="chapter_submission.php?chapter=<?php echo $i; ?>" class="btn btn-primary">View/Update</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

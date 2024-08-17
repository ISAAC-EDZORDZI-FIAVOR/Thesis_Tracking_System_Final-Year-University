<?php
session_start();
include_once('../config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../admin/auth-signin.php");
    exit();
}

$lecturer_id = $_SESSION['user_id'];

$query = "SELECT u.id as student_id, u.fullname, cp.chapter_number, MAX(cp.status) as status 
          FROM users u 
          LEFT JOIN chapter_progress cp ON u.id = cp.student_id 
          WHERE cp.lecturer_id = ? 
          GROUP BY u.id, cp.chapter_number";
$stmt = $pdo->prepare($query);
$stmt->execute([$lecturer_id]);
$student_progress = $stmt->fetchAll(PDO::FETCH_GROUP);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Student Progress Dashboard</h1>
        <?php foreach ($student_progress as $student_id => $chapters): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h2><?php echo $chapters[0]['fullname']; ?></h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php
                            $chapter = array_filter($chapters, function($ch) use ($i) { return $ch['chapter_number'] == $i; });
                            $status = !empty($chapter) ? reset($chapter)['status'] : 'Not started';
                            $status_class = $status === 'accepted' ? 'text-success' : ($status === 'rejected' ? 'text-danger' : 'text-warning');
                            ?>
                            <div class="col">
                                <h5>Chapter <?php echo $i; ?></h5>
                                <p class="<?php echo $status_class; ?>"><?php echo ucfirst($status); ?></p>
                                <a href="review_chapter.php?student_id=<?php echo $student_id; ?>&chapter=<?php echo $i; ?>" class="btn btn-sm btn-primary">Review</a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

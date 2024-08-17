<?php
require '../config.php';


if (isset($_POST['assignment_id'])) {
    $assignment_id = $_POST['assignment_id'];
    
    $stmt = $pdo->prepare("SELECT * FROM assignments WHERE id = ?");
    $stmt->execute([$assignment_id]);
    $assignment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode($assignment);
} else {
    echo json_encode(['error' => 'No assignment ID provided']);
}

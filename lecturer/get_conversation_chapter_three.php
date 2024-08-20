<?php
  require '../config.php';

if (isset($_GET['chapter_id'])) {
    $chapter_id = $_GET['chapter_id'];
    
    $stmt = $pdo->prepare("
        SELECT ti.*, u.fullname, u.role
        FROM chapter_three_interactions ti
        JOIN users u ON ti.user_id = u.id
        WHERE ti.chapter_three_id = :chapter_id
        ORDER BY ti.created_at ASC
    ");
    $stmt->execute(['chapter_id' => $chapter_id]);
    $interactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($interactions as $interaction) {
        $messageClass = $interaction['role'] == 'student' ? 'alert alert-light' : 'alert alert-primary';
$alignClass = $interaction['role'] == 'student' ? 'offset-md-0' : 'offset-md-4';

echo '<div class="row mb-3">';
echo '<div class="col-md-8 ' . $alignClass . '">';
echo '<div class="' . $messageClass . '">';
echo '<div class="d-flex justify-content-between align-items-center mb-2">';
echo '<strong>' . htmlspecialchars($interaction['fullname']) . '</strong>';
echo '<small class="text-muted">' . date('M d, Y H:i', strtotime($interaction['created_at'])) . '</small>';
echo '</div>';
echo '<h5 class="mb-2">' . htmlspecialchars($interaction['title']) . '</h5>';
echo '<p class="mb-2">' . htmlspecialchars($interaction['description']) . '</p>';
echo '<p class="mb-0">' . htmlspecialchars($interaction['message']) . '</p>';
echo '</div>';
echo '</div>';
echo '</div>';


    }
}

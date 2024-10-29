<?php
require_once '../config.php';

if (isset($_GET['query'])) {
    $search_query = '%' . $_GET['query'] . '%';

    $stmt = $pdo->prepare("
        SELECT ct.*, u.fullname as student_name,
               YEAR(ct.submission_date) as research_year,
               s.fullname as supervisor_name
        FROM compiled_thesis ct
        JOIN users u ON ct.student_id = u.id
        JOIN users s ON ct.primary_supervisor_id = s.id
        WHERE ct.thesis_title LIKE ? OR ct.keywords LIKE ?
    ");
    $stmt->execute([$search_query, $search_query]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        echo "<div class='list-group'>";
        foreach ($results as $result) {
            echo "<div class='list-group-item list-group-item-action flex-column align-items-start mb-3'>";
            echo "<div class='d-flex w-100 justify-content-between'>";
            echo "<h5 class='mb-1'>" . htmlspecialchars($result['thesis_title']) . "</h5>";
            echo "<small>" . htmlspecialchars($result['research_year']) . "</small>";
            echo "</div>";
            echo "<p class='mb-1'><strong>Author:</strong> " . htmlspecialchars($result['student_name']) . "</p>";
            echo "<p class='mb-1'><strong>Supervisor:</strong> " . htmlspecialchars($result['supervisor_name']) . "</p>";
            // echo "<p class='mb-1'><strong>Keywords:</strong> " . htmlspecialchars($result['keywords']) . "</p>";
            echo "<a href='" . htmlspecialchars($result['file_path']) . "' target='_blank' class='btn btn-outline-primary btn-sm mt-2'>";
            echo "<i class='fa fa-file-pdf-o mr-4'></i>View PDF</a>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class='alert alert-info'>No results found.</p>";
    }
}

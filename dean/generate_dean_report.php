<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "dean") {
    header("Location: ../admin/auth-signin.php");
    exit();
}
require '../vendor/autoload.php'; // Ensure this path is correct
require '../vendor/setasign/fpdf/fpdf.php'; // Correct file path for FPDF

class PDF extends FPDF
{
    function Header()
    {
        // Center the image
        $imagePath = './Thesis.png';
        $imageWidth = 30;
        $imageHeight = 30; // Set the height for the image
        $pageWidth = $this->GetPageWidth();
        $x = ($pageWidth - $imageWidth) / 2;
        $this->Image($imagePath, $x, 10, $imageWidth, $imageHeight);

        // School name centered
        $this->SetFont('Arial', 'B', 16);
        $this->SetY(50);
        $this->Cell(0, 10, 'Thesis Tracking System UEW', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128); // Gray color for footer text
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title)
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(0, 0, 255); // Blue background for titles
        $this->SetTextColor(255, 255, 255); // White text for titles
        $this->Cell(0, 10, $title, 0, 1, 'C', true);
        $this->Ln(5);
    }

    function ChapterBody($body)
    {
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0); // Black color for body text
        $this->MultiCell(0, 10, $body);
        $this->Ln();
    }

    function CreateTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(0, 0, 255); // Blue background for table header
        $this->SetTextColor(255, 255, 255); // White text for table header
        $w = array(90, 90); // Column widths
        $this->SetX((210 - array_sum($w)) / 2); // Center table
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0); // Black color for table data
        foreach ($data as $row) {
            $this->SetX((210 - array_sum($w)) / 2); // Center each row
            foreach ($row as $i => $col) {
                $this->Cell($w[$i], 10, $col, 1);
            }
            $this->Ln();
        }
    }

    function CenterText($text, $fontSize = 12, $fontStyle = '', $color = [0, 0, 0])
    {
        $this->SetFont('Arial', $fontStyle, $fontSize);
        $this->SetTextColor($color[0], $color[1], $color[2]); // Set text color
        $this->Cell(0, 10, $text, 0, 1, 'C');
    }
}

// Initialize PDF
$pdf = new PDF();
$pdf->AddPage();

// Data fetching
require '../config.php'; // Ensure this path is correct

$faculty_id = $_SESSION['faculty_id']; // Assuming the faculty_id is stored in the session

// Fetch faculty name
$faculty_query = "SELECT name FROM faculties WHERE id = ?";
$stmt = $pdo->prepare($faculty_query);
$stmt->execute([$faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);
$facultyName = $faculty['name'] ?? 'Unknown Faculty';

// Fetch other data
$stmt = $pdo->prepare("SELECT COUNT(*) FROM departments WHERE faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalDepartments = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'lecturer' AND faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalLecturers = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'student' AND faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalStudents = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(DISTINCT a.student_id) FROM assignments a JOIN users u ON a.student_id = u.id WHERE u.faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalAssignedStudents = $stmt->fetchColumn();

$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM users
    WHERE role = 'student'
    AND faculty_id = ?
    AND id NOT IN (SELECT DISTINCT student_id FROM assignments)
");
$stmt->execute([$faculty_id]);
$totalUnassignedStudents = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalThesisSubmitted = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE status = 'pending' AND faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalThesisSubmittedPending = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE status = 'approved' AND faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalThesisSubmittedApproved = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE status = 'rejected' AND faculty_id = ?");
$stmt->execute([$faculty_id]);
$totalThesisSubmittedRejected = $stmt->fetchColumn();

// Fetch chapter data
$chapters = ['one', 'two', 'three', 'four', 'five'];
foreach ($chapters as $chapter) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_$chapter c JOIN users u ON c.student_id = u.id WHERE u.faculty_id = ?");
    $stmt->execute([$faculty_id]);
    ${"totalchapter_{$chapter}Submitted"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_$chapter c JOIN users u ON c.student_id = u.id WHERE u.faculty_id = ? AND c.status = 'pending'");
    $stmt->execute([$faculty_id]);
    ${"totalchapter_{$chapter}SubmittedPending"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_$chapter c JOIN users u ON c.student_id = u.id WHERE u.faculty_id = ? AND c.status = 'approved'");
    $stmt->execute([$faculty_id]);
    ${"totalchapter_{$chapter}SubmittedApproved"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_$chapter c JOIN users u ON c.student_id = u.id WHERE u.faculty_id = ? AND c.status = 'rejected'");
    $stmt->execute([$faculty_id]);
    ${"totalchapter_{$chapter}SubmittedRejected"} = $stmt->fetchColumn();
}

// Report generation
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 255); // Blue color for the main title
$pdf->CenterText('Comprehensive Dean Report');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 0); // Black color for date text
$pdf->CenterText("Report Date: " . date('F j, Y'));
$pdf->CenterText('Generated on: ' . date('F j, Y, g:i a'));
$pdf->Ln(10);

// Add Faculty Name
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 0, 255); // Blue color for faculty name
$pdf->CenterText("Faculty: $facultyName");
$pdf->Ln(10);

// System Overview
$pdf->ChapterTitle('System Overview');
$pdf->CreateTable(
    ['Metric', 'Value'],
    [
        ['Total Users', $totalStudents + $totalLecturers],
        ['Student to Lecturer Ratio', ($totalLecturers ? round($totalStudents / $totalLecturers, 2) : 'N/A')],
    ]
);

// Thesis Progress Overview
$pdf->ChapterTitle('Thesis Progress Overview');
$pdf->CreateTable(
    ['Metric', 'Value'],
    [
        ['Completed Theses', $totalThesisSubmitted],
        ['Pending Theses', $totalThesisSubmittedPending],
        ['Approved Theses', $totalThesisSubmittedApproved],
        ['Rejected Theses', $totalThesisSubmittedRejected],
    ]
);

// Chapter Statistics
foreach ($chapters as $chapter) {
    $pdf->ChapterTitle("Chapter " . ucfirst($chapter) . " Statistics");
    $pdf->CreateTable(
        ['Metric', 'Value'],
        [
            ["Total Submitted", ${"totalchapter_{$chapter}Submitted"}],
            ["Pending", ${"totalchapter_{$chapter}SubmittedPending"}],
            ["Approved", ${"totalchapter_{$chapter}SubmittedApproved"}],
            ["Rejected", ${"totalchapter_{$chapter}SubmittedRejected"}],
        ]
    );
}

// Output the PDF
$pdf->Output('D', 'Dean_Report.pdf');
?>

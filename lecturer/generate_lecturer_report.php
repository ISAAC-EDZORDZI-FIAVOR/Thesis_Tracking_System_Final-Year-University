<?php

session_start();
require '../config.php';

// Check if user is logged in and is a lecturer
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../admin/auth-signin.php");
    exit();
}
require '../vendor/autoload.php'; // Ensure this path is correct
require '../vendor/setasign/fpdf/fpdf.php'; // Correct file path for FPDF

class PDF extends FPDF
{
    function Header()
    {
        $imagePath = './Thesis.png';
        $imageWidth = 30;
        $imageHeight = 30; // Set the height for the image
        $pageWidth = $this->GetPageWidth();
        $x = ($pageWidth - $imageWidth) / 2;
        $this->Image($imagePath, $x, 10, $imageWidth, $imageHeight);

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

$lecturer_id = $_SESSION['user_id']; // Assuming the lecturer's user_id is stored in the session

// Fetch lecturer name
$lecturer_query = "SELECT fullname FROM users WHERE id = ?";
$stmt = $pdo->prepare($lecturer_query);
$stmt->execute([$lecturer_id]);
$lecturer = $stmt->fetch(PDO::FETCH_ASSOC);
$lecturerName = $lecturer['fullname'] ?? 'Unknown Lecturer';

// Fetch department name
$department_query = "SELECT d.name FROM departments d 
                     JOIN users u ON d.id = u.department_id 
                     WHERE u.id = ?";
$stmt = $pdo->prepare($department_query);
$stmt->execute([$lecturer_id]);
$department = $stmt->fetch(PDO::FETCH_ASSOC);
$departmentName = $department['name'] ?? 'Unknown Department';

// Fetch data
$stmt = $pdo->prepare("SELECT COUNT(DISTINCT student_id) FROM assignments WHERE primary_supervisor_id = ? OR secondary_supervisor_id1 = ? OR secondary_supervisor_id2 = ?");
$stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
$totalAssignedStudents = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE primary_supervisor_id = ? OR secondary_supervisor_id1 = ? OR secondary_supervisor_id2 = ?");
$stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
$totalThesisSubmitted = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE (primary_supervisor_id = ? OR secondary_supervisor_id1 = ? OR secondary_supervisor_id2 = ?) AND status = 'pending'");
$stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
$totalThesisSubmittedPending = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE (primary_supervisor_id = ? OR secondary_supervisor_id1 = ? OR secondary_supervisor_id2 = ?) AND status = 'approved'");
$stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
$totalThesisSubmittedApproved = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM thesis_proposals WHERE (primary_supervisor_id = ? OR secondary_supervisor_id1 = ? OR secondary_supervisor_id2 = ?) AND status = 'rejected'");
$stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
$totalThesisSubmittedRejected = $stmt->fetchColumn();

// Fetch chapter data
$chapters = ['one', 'two', 'three', 'four', 'five'];
foreach ($chapters as $chapter) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_{$chapter} c 
        JOIN thesis_proposals tp ON c.student_id = tp.student_id 
        WHERE tp.primary_supervisor_id = ? OR tp.secondary_supervisor_id1 = ? OR tp.secondary_supervisor_id2 = ?");
    $stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
    ${"totalchapter_{$chapter}Submitted"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_{$chapter} c 
        JOIN thesis_proposals tp ON c.student_id = tp.student_id 
        WHERE (tp.primary_supervisor_id = ? OR tp.secondary_supervisor_id1 = ? OR tp.secondary_supervisor_id2 = ?) 
        AND c.status = 'pending'");
    $stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
    ${"totalchapter_{$chapter}SubmittedPending"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_{$chapter} c 
        JOIN thesis_proposals tp ON c.student_id = tp.student_id 
        WHERE (tp.primary_supervisor_id = ? OR tp.secondary_supervisor_id1 = ? OR tp.secondary_supervisor_id2 = ?) 
        AND c.status = 'approved'");
    $stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
    ${"totalchapter_{$chapter}SubmittedApproved"} = $stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM chapter_{$chapter} c 
        JOIN thesis_proposals tp ON c.student_id = tp.student_id 
        WHERE (tp.primary_supervisor_id = ? OR tp.secondary_supervisor_id1 = ? OR tp.secondary_supervisor_id2 = ?) 
        AND c.status = 'rejected'");
    $stmt->execute([$lecturer_id, $lecturer_id, $lecturer_id]);
    ${"totalchapter_{$chapter}SubmittedRejected"} = $stmt->fetchColumn();
}

// Report generation
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 255); // Blue color for the main title
$pdf->CenterText('Lecturer Report');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 0); // Black color for date text
$pdf->CenterText("Report Date: " . date('F j, Y'));
$pdf->CenterText('Generated on: ' . date('F j, Y, g:i a'));
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 0, 0); // Black color for the lecturer name
$pdf->CenterText('Lecturer: ' . $lecturerName);
$pdf->CenterText('Department: ' . $departmentName);
$pdf->Ln(10);

// Assigned Students
$pdf->ChapterTitle('Assigned Students');
$pdf->CreateTable(
    ['Metric', 'Value'],
    [
        ["Total Assigned Students", $totalAssignedStudents]
    ]
);
$pdf->Ln(10);

// Thesis Proposals
$pdf->ChapterTitle('Thesis Proposals');
$pdf->CreateTable(
    ['Metric', 'Value'],
    [
        ["Total Thesis Submitted", $totalThesisSubmitted],
        ["Pending", $totalThesisSubmittedPending],
        ["Approved", $totalThesisSubmittedApproved],
        ["Rejected", $totalThesisSubmittedRejected],
    ]
);
$pdf->Ln(10);

// Chapter Submissions
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
    $pdf->Ln(10);
}

// Output the PDF
$pdf->Output('D', 'Lecturer_Report.pdf');
?>

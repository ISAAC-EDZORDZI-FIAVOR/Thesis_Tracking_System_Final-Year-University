<?php
require '../config.php';
require '../vendor/autoload.php'; // Ensure this path is correct
require '../vendor/setasign/fpdf/fpdf.php'; // Correct file path for FPDF

// Error handling function
function handleError($message) {
    die("Error: $message");
}

// Fetch data with error handling
function fetchData($pdo, $query) {
    $stmt = $pdo->query($query);
    if ($stmt === false) {
        handleError("Failed to execute query: $query");
    }
    return $stmt->fetchColumn();
}

// Fetch data with error handling
try {
    $totalDepartments = fetchData($pdo, "SELECT COUNT(*) FROM departments");
    $totalFaculties = fetchData($pdo, "SELECT COUNT(*) FROM faculties");
    $totalLecturers = fetchData($pdo, "SELECT COUNT(*) FROM users WHERE role = 'lecturer'");
    $totalStudents = fetchData($pdo, "SELECT COUNT(*) FROM users WHERE role = 'student'");
    $totalAssignedStudents = fetchData($pdo, "SELECT COUNT(DISTINCT student_id) FROM assignments");
    $totalUnassignedStudents = fetchData($pdo, "
        SELECT COUNT(*)
        FROM users
        WHERE role = 'student'
        AND id NOT IN (SELECT DISTINCT student_id FROM assignments)
    ");
    $totalThesisSubmitted = fetchData($pdo, "SELECT COUNT(*) FROM thesis_proposals");
    $totalThesisSubmittedPending = fetchData($pdo, "SELECT COUNT(*) FROM thesis_proposals WHERE status = 'pending'");
    $totalThesisSubmittedApproved = fetchData($pdo, "SELECT COUNT(*) FROM thesis_proposals WHERE status = 'approved'");
    $totalThesisSubmittedRejected = fetchData($pdo, "SELECT COUNT(*) FROM thesis_proposals WHERE status = 'rejected'");

    // Chapter queries
    $chapters = ['one', 'two', 'three', 'four', 'five'];
    foreach ($chapters as $chapter) {
        ${"totalchapter_{$chapter}Submitted"} = fetchData($pdo, "SELECT COUNT(*) FROM chapter_$chapter");
        ${"totalchapter_{$chapter}SubmittedPending"} = fetchData($pdo, "SELECT COUNT(*) FROM chapter_$chapter WHERE status = 'pending'");
        ${"totalchapter_{$chapter}SubmittedApproved"} = fetchData($pdo, "SELECT COUNT(*) FROM chapter_$chapter WHERE status = 'approved'");
        ${"totalchapter_{$chapter}SubmittedRejected"} = fetchData($pdo, "SELECT COUNT(*) FROM chapter_$chapter WHERE status = 'rejected'");
    }
} catch (Exception $e) {
    handleError($e->getMessage());
}

// PDF generation code
class PDF extends FPDF
{
    function Header()
    
    {


        // Image path
        $imagePath = './Thesis.png';
        // Image dimensions
        $imageWidth = 30;
        $imageHeight = 30; // You can specify the height or let it auto-scale

        // Page width
        $pageWidth = $this->GetPageWidth();

        // Calculate X position for centering the image
        $x = ($pageWidth - $imageWidth) / 2;

        // Add the image centered
        $this->Image($imagePath, $x, 10, $imageWidth); // Centered image
        
        // Set font and color for the header
        // School name centered
       
        // $this->Image('./Thesis.png', 10, 10, 30); // Ensure logo path is correct
        $this->Ln(40);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Thesis Tracking System UEW', 0, 1, 'C');
        // Space after header
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0, 0, 0); // Black color for text
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title)
    {
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(255, 0, 0); // Red color for titles
        $this->Cell(0, 10, $title, 0, 1, 'C');
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
        $this->SetFillColor(0, 0, 255); // Blue color for header background
        $this->SetTextColor(255, 255, 255); // White color for header text
        $w = array(80, 80); // Column widths
        $this->SetX((210 - array_sum($w)) / 2); // Center table
        foreach ($header as $i => $col) {
            $this->Cell($w[$i], 10, $col, 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(0, 0, 0); // Black color for data text
        foreach ($data as $row) {
            $this->SetX((210 - array_sum($w)) / 2); // Center each row
            foreach ($row as $i => $col) {
                $this->Cell($w[$i], 10, $col, 1);
            }
            $this->Ln();
        }
    }

    function CenterText($text, $fontSize = 12, $fontStyle = '')
    {
        $this->SetFont('Arial', $fontStyle, $fontSize);
        $this->SetTextColor(0, 0, 0); // Black color for text
        $this->Cell(0, 10, $text, 0, 1, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Title
$pdf->SetFont('Arial', 'B', 30);
$pdf->SetTextColor(0, 0, 255); // Blue color for the main title
$pdf->CenterText('Comprehensive Super Admin Report');
$pdf->Ln(10);

// Date Info
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(0, 0, 0); // Black color for date text
$pdf->CenterText("Report Date: " . date('F j, Y'));
$pdf->CenterText('Generated on: ' . date('F j, Y, g:i a'));
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
        ['Completed Theses', ${'totalchapter_fiveSubmittedApproved'}],
        ['Thesis Completion Rate', ($totalStudents ? round((${'totalchapter_fiveSubmittedApproved'} / $totalStudents) * 100, 2) : 0) . '%'],
    ]
);

// Summary and Recommendations
$pdf->ChapterTitle('Summary and Recommendations');
$summary = "Based on the current statistics, the thesis completion rate is " .
    ($totalStudents ? round((${'totalchapter_fiveSubmittedApproved'} / $totalStudents) * 100, 2) : 0) . "%. " .
    "Consider implementing strategies to improve this rate if it's below the expected threshold.";
$pdf->ChapterBody($summary);
$pdf->Ln(20);

// Detailed Statistics
$pdf->ChapterTitle('Detailed Statistics');
$pdf->CreateTable(
    ['Metric', 'Value'],
    [
        ['Total Faculties', $totalFaculties],
        ['Total Departments', $totalDepartments],
        ['Total Lecturers', $totalLecturers],
        ['Total Students', $totalStudents],
        ['Assigned Students', $totalAssignedStudents],
        ['Unassigned Students', $totalUnassignedStudents],
        ['Thesis Submitted', $totalThesisSubmitted],
        ['Pending Thesis', $totalThesisSubmittedPending],
        ['Approved Thesis', $totalThesisSubmittedApproved],
        ['Rejected Thesis', $totalThesisSubmittedRejected],
    ]
);

// Chapter Statistics
$chapters = ['One', 'Two', 'Three', 'Four', 'Five'];
foreach ($chapters as $chapter) {
    $chapterKey = strtolower($chapter);
    $pdf->ChapterTitle("Chapter $chapter Statistics");
    $pdf->CreateTable(
        ['Metric', 'Value'],
        [
            ["Total Submitted", ${"totalchapter_{$chapterKey}Submitted"}],
            ["Pending", ${"totalchapter_{$chapterKey}SubmittedPending"}],
            ["Approved", ${"totalchapter_{$chapterKey}SubmittedApproved"}],
            ["Rejected", ${"totalchapter_{$chapterKey}SubmittedRejected"}],
        ]
    );
}

$pdf->Output('D', 'Super_Admin_Report.pdf');
?>

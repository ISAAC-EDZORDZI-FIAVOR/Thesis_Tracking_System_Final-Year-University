<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "dean") {
    header("Location: ../admin/auth-signin.php");
    exit();
}

require '../vendor/autoload.php';
require '../vendor/setasign/fpdf/fpdf.php';
require '../jpgraph/src/jpgraph.php';
require '../jpgraph/src/jpgraph_bar.php';
require '../jpgraph/src/jpgraph_pie.php';
require '../jpgraph/src/jpgraph_line.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('./Thesis.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(30);
        $this->Cell(0, 10, 'Dean\'s Comprehensive Thesis Report', 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ChapterTitle($num, $label)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 6, "Chapter $num : $label", 0, 1, 'L', true);
        $this->Ln(4);
    }

    function ChapterBody($txt)
    {
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(0, 5, $txt);
        $this->Ln();
    }

    function AddChart($title, $filename)
    {
        $this->AddPage();
        $this->ChapterTitle('', $title);
        $this->Image($filename, 10, 30, 190);
        unlink($filename);
    }
}

// Initialize PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Data fetching
require '../config.php';

// Fetch overall statistics
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student'");
$totalStudents = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'lecturer'");
$totalLecturers = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM faculties");
$totalFaculties = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM departments");
$totalDepartments = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM thesis_proposals WHERE status = 'approved'");
$totalApprovedTheses = $stmt->fetchColumn();

// Fetch faculty-wise statistics
$stmt = $pdo->query("
    SELECT f.name, 
           COUNT(DISTINCT u.id) as student_count,
           COUNT(DISTINCT tp.id) as approved_theses
    FROM faculties f
    LEFT JOIN users u ON f.id = u.faculty_id AND u.role = 'student'
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id AND tp.status = 'approved'
    GROUP BY f.id
");
$facultyStats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch monthly thesis submissions for the last 12 months
$stmt = $pdo->query("
    SELECT DATE_FORMAT(submission_date, '%Y-%m') as month, COUNT(*) as count
    FROM thesis_proposals
    WHERE submission_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY month
    ORDER BY month
");
$monthlySubmissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate report content
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Executive Summary', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, "This comprehensive report provides an overview of the thesis progress across all faculties. It includes statistics on student and lecturer counts, thesis submissions, and faculty-wise performance.");
$pdf->Ln(5);

$pdf->ChapterTitle(1, 'Overall Statistics');
$pdf->ChapterBody("Total Students: $totalStudents");
$pdf->ChapterBody("Total Lecturers: $totalLecturers");
$pdf->ChapterBody("Total Faculties: $totalFaculties");
$pdf->ChapterBody("Total Departments: $totalDepartments");
$pdf->ChapterBody("Total Approved Theses: $totalApprovedTheses");

$pdf->ChapterTitle(2, 'Faculty-wise Performance');
foreach ($facultyStats as $stat) {
    $pdf->ChapterBody("{$stat['name']}:");
    $pdf->ChapterBody("  Students: {$stat['student_count']}");
    $pdf->ChapterBody("  Approved Theses: {$stat['approved_theses']}");
    $pdf->Ln(5);
}

// Generate charts
// Bar chart for faculty-wise student count
$data = array_column($facultyStats, 'student_count');
$labels = array_column($facultyStats, 'name');
$graph = new Graph(600, 400);
$graph->SetScale("textlin");
$graph->SetBox(false);
$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true, '#FFFFFF@0.5', '#FFFFFF@0.5');
$graph->xaxis->SetTickLabels($labels);
$graph->xaxis->SetLabelAngle(45);
$barplot = new BarPlot($data);
$graph->Add($barplot);
$graph->title->Set("Students per Faculty");
$graph->Stroke("faculty_students.png");
$pdf->AddChart("Students per Faculty", "faculty_students.png");

// Pie chart for approved theses distribution
$data = array_column($facultyStats, 'approved_theses');
$graph = new PieGraph(400, 300);
$pieplot = new PiePlot($data);
$pieplot->SetLegends($labels);
$graph->Add($pieplot);
$graph->title->Set("Approved Theses Distribution");
$graph->Stroke("approved_theses_distribution.png");
$pdf->AddChart("Approved Theses Distribution", "approved_theses_distribution.png");

// Line chart for monthly thesis submissions
$data = array_column($monthlySubmissions, 'count');
$labels = array_column($monthlySubmissions, 'month');
$graph = new Graph(600, 400);
$graph->SetScale("textlin");
$graph->SetBox(false);
$graph->yaxis->HideZeroLabel();
$graph->ygrid->SetFill(true, '#FFFFFF@0.5', '#FFFFFF@0.5');
$graph->xaxis->SetTickLabels($labels);
$graph->xaxis->SetLabelAngle(45);
$lineplot = new LinePlot($data);
$graph->Add($lineplot);
$graph->title->Set("Monthly Thesis Submissions (Last 12 Months)");
$graph->Stroke("monthly_submissions.png");
$pdf->AddChart("Monthly Thesis Submissions", "monthly_submissions.png");

$pdf->ChapterTitle(3, 'Key Findings and Recommendations');
$pdf->ChapterBody("1. The faculty with the highest number of students is " . $facultyStats[array_search(max(array_column($facultyStats, 'student_count')), array_column($facultyStats, 'student_count'))]['name'] . ".");
$pdf->ChapterBody("2. The faculty with the most approved theses is " . $facultyStats[array_search(max(array_column($facultyStats, 'approved_theses')), array_column($facultyStats, 'approved_theses'))]['name'] . ".");
$pdf->ChapterBody("3. The overall thesis approval rate is " . round(($totalApprovedTheses / $totalStudents) * 100, 2) . "%.");
$pdf->ChapterBody("4. Recommendation: Focus on improving thesis completion rates in faculties with lower performance.");
$pdf->ChapterBody("5. Recommendation: Investigate and replicate best practices from high-performing faculties.");
$pdf->ChapterBody("6. Recommendation: Implement a mentorship program pairing experienced thesis supervisors with new faculty members.");

$pdf->Output('D', 'Dean_Comprehensive_Report.pdf');
?>

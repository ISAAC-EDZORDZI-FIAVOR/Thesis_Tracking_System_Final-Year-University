<?php
session_start();
require_once '../config.php';

// Check if user is logged in and has appropriate permissions
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dean') {
    header('Location: login.php');
    exit();
}

// Fetch all department data initially
$stmt = $pdo->prepare("SELECT u.department_id, d.name as department_name, tp.status as proposal_status, 
    c1.status as chapter_one_status, 
    c2.status as chapter_two_status, 
    c3.status as chapter_three_status, 
    c4.status as chapter_four_status, 
    c5.status as chapter_five_status 
    FROM users u 
    JOIN departments d ON u.department_id = d.id
    LEFT JOIN thesis_proposals tp ON u.id = tp.student_id 
    LEFT JOIN chapter_one c1 ON u.id = c1.student_id 
    LEFT JOIN chapter_two c2 ON u.id = c2.student_id 
    LEFT JOIN chapter_three c3 ON u.id = c3.student_id 
    LEFT JOIN chapter_four c4 ON u.id = c4.student_id 
    LEFT JOIN chapter_five c5 ON u.id = c5.student_id 
    WHERE u.role = 'student'");
$stmt->execute();
$allStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$departmentData = [];
foreach ($allStudents as $student) {
    $dept_id = $student['department_id'];
    if (!isset($departmentData[$dept_id])) {
        $departmentData[$dept_id] = [
            'name' => $student['department_name'],
            'proposal' => 0,
            'chapter_one' => 0,
            'chapter_two' => 0,
            'chapter_three' => 0,
            'chapter_four' => 0,
            'chapter_five' => 0,
            'total' => 0
        ];
    }
    $departmentData[$dept_id]['total']++;
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        if ($student[$stage . '_status'] == 'approved') {
            $departmentData[$dept_id][$stage]++;
        }
    }
}

$initialData = [];
foreach ($departmentData as $dept_id => $data) {
    $initialData[$dept_id] = [
        'name' => $data['name'],
        'percentages' => []
    ];
    foreach (['proposal', 'chapter_one', 'chapter_two', 'chapter_three', 'chapter_four', 'chapter_five'] as $stage) {
        $initialData[$dept_id]['percentages'][$stage] = $data['total'] > 0 ? round(($data[$stage] / $data['total']) * 100, 2) : 0;
    }
}

$lecturers = $pdo->query("SELECT id, fullname FROM users WHERE role = 'lecturer'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thesis Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .dashboard-header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .department-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 30px;
        }
        .department-card:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <div class="container">
            <h1><i class="fas fa-chart-line"></i> Thesis Tracking System</h1>
        </div>
    </div>

    <div class="container mb-4">
        <div class="card">
            <div class="card-body">
                <form id="filterForm">
                    <div class="row">
                        <div class="col-md-5">
                            <select id="departmentFilter" name="department" class="form-select">
                                <option value="">All Departments</option>
                                <?php foreach ($departmentData as $dept_id => $dept): ?>
                                    <option value="<?php echo $dept_id; ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                        <select id="lecturerFilter" name="lecturer" class="form-select" disabled>
                            <option value="">All Lecturers</option>
                        </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container" id="chartsContainer">
        <?php foreach ($initialData as $dept_id => $dept): ?>
            <div class="card department-card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-building"></i> <?php echo htmlspecialchars($dept['name']); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="bar-chart-<?php echo $dept_id; ?>"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="chart-container">
                                <canvas id="pie-chart-<?php echo $dept_id; ?>"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script>
    var initialChartData = <?php echo json_encode($initialData); ?>;

    $(document).ready(function() {


        $('#departmentFilter').on('change', function() {
        var departmentId = $(this).val();
        if (departmentId) {
            $.ajax({
                url: 'get_lecturer1.php',
                type: 'POST',
                data: { department_id: departmentId },
                dataType: 'json',
                success: function(lecturers) {
                    var options = '<option value="">All Lecturers</option>';
                    $.each(lecturers, function(id, name) {
                        options += '<option value="' + id + '">' + name + '</option>';
                    });
                    $('#lecturerFilter').html(options).prop('disabled', false);
                },
                error: function() {
                    console.error("Error fetching lecturers");
                }
            });
        } else {
            $('#lecturerFilter').html('<option value="">All Lecturers</option>').prop('disabled', true);
        }
    });



        function initializeCharts(data) {
            Object.keys(data).forEach(function(departmentId) {
                var departmentName = data[departmentId].name;
                var percentages = data[departmentId].percentages;
                var labels = ['Proposal', 'Chapter 1', 'Chapter 2', 'Chapter 3', 'Chapter 4', 'Chapter 5'];
                var values = Object.values(percentages);
                
                var barCtx = document.getElementById('bar-chart-' + departmentId).getContext('2d');
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Completion Percentage',
                            data: values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Student Progress (Bar Chart) - ' + departmentName
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                var pieCtx = document.getElementById('pie-chart-' + departmentId).getContext('2d');
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Student Progress (Pie Chart) - ' + departmentName
                            }
                        }
                    }
                });
            });
        }

        function updateCharts(data) {
    // Hide all department cards initially
    $('.department-card').hide();

    Object.keys(data).forEach(function(departmentId) {
        var barChart = Chart.getChart('bar-chart-' + departmentId);
        var pieChart = Chart.getChart('pie-chart-' + departmentId);
        
        if (barChart && pieChart) {
            var newData = Object.values(data[departmentId].percentages);
            
            barChart.data.datasets[0].data = newData;
            pieChart.data.datasets[0].data = newData;

            barChart.options.animation = false;
            pieChart.options.animation = false;
            barChart.update('none');
            pieChart.update('none');

            // Show the relevant department card
            $('#bar-chart-' + departmentId).closest('.department-card').show();

            console.log("Charts updated for department:", departmentId);
        }
    });
}


        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log("tsfsfssfs");
            
            
            $.ajax({
                url: 'fetch_filtered_data.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("Received data:", response);
                    updateCharts(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });

        // Initialize charts with the initial data
        initializeCharts(initialChartData);
    });
    </script>
</body>
</html>

<?php
// Database connection (PDO example)
$pdo = new PDO('mysql:host=localhost;dbname=cdcms_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the date range from GET parameters
$start_date = $_GET['start_date'] ?? '2024-01-01';
$end_date = $_GET['end_date'] ?? date('Y-m-d');

// Fetching enrollment statistics
$sql = "SELECT 
            COUNT(*) AS total_enrollments,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS pending_enrollments,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS confirmed_enrollments
        FROM enrollment_list WHERE date_created BETWEEN ? AND ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$start_date, $end_date]);
$enrollment_stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Attendance Tracking
$sql = "SELECT 
            SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) AS present,
            SUM(CASE WHEN status = 'Absent' THEN 1 ELSE 0 END) AS absent
        FROM attendance WHERE date BETWEEN ? AND ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$start_date, $end_date]);
$attendance_data = $stmt->fetch(PDO::FETCH_ASSOC);





// Fetch service usage data
$sql = "SELECT 
            sl.name AS service_name, 
            COUNT(b.service_id) AS children_enrolled,
            SUM(b.amount) AS total_revenue
        FROM billing b
        JOIN service_list sl ON b.service_id = sl.id
        WHERE b.date_created BETWEEN ? AND ? 
        AND b.status = 1  -- Only consider 'Paid' status
        GROUP BY b.service_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([$start_date, $end_date]);
$service_usage = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 1. Age Group Breakdown with Gender
$sql_age_group_gender = "
    SELECT
        CASE
            WHEN TIMESTAMPDIFF(YEAR, ed.meta_value, CURDATE()) BETWEEN 0 AND 5 THEN '0-5'
            WHEN TIMESTAMPDIFF(YEAR, ed.meta_value, CURDATE()) BETWEEN 6 AND 10 THEN '6-10'
            WHEN TIMESTAMPDIFF(YEAR, ed.meta_value, CURDATE()) BETWEEN 11 AND 15 THEN '11-15'
            ELSE '16+' 
        END AS age_group,
        eg.meta_value AS child_gender,
        COUNT(*) AS enrollments
    FROM enrollment_list el
    JOIN enrollment_details ed ON el.id = ed.enrollment_id
    JOIN enrollment_details eg ON el.id = eg.enrollment_id
    WHERE ed.meta_field = 'child_dob' 
    AND eg.meta_field = 'gender'
    GROUP BY age_group, child_gender";
$stmt = $pdo->query($sql_age_group_gender);
$age_groups_gender = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Seasonal Trends (Enrollments per Month)
$sql_seasonal = "SELECT 
                    MONTH(date_created) AS month,
                    COUNT(*) AS enrollments
                FROM enrollment_list
                WHERE YEAR(date_created) = YEAR(CURDATE())
                GROUP BY month
                ORDER BY month";
$stmt = $pdo->query($sql_seasonal);
$seasonal_trends = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Enrollment vs. Attendance (Including Absent Gap)
$sql_enrollment_vs_attendance = "SELECT 
                                    (SELECT COUNT(*) FROM enrollment_list WHERE date_created BETWEEN ? AND ?) AS total_enrollments,
                                    (SELECT COUNT(*) FROM attendance WHERE status = 'Present' AND date BETWEEN ? AND ?) AS total_attendance,
                                    (SELECT COUNT(*) FROM attendance WHERE status = 'Absent' AND date BETWEEN ? AND ?) AS total_absent";
$stmt = $pdo->prepare($sql_enrollment_vs_attendance);
$stmt->execute([$start_date, $end_date, $start_date, $end_date, $start_date, $end_date]);
$enrollment_vs_attendance = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports and Analytics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
        }
        header {
            background-color: #003366;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .report-section {
            background: #fff;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .report-section h2 {
            font-size: 26px;
            margin-bottom: 15px;
            color: #003366;
        }
        .report-stat {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        .report-stat i {
            font-size: 20px;
            margin-right: 10px;
            color: #4CAF50;
        }
        .report-stat span {
            font-weight: bold;
        }
        .report-stat .pending {
            color: #FF9800;
        }
        .report-stat .confirmed {
            color: #4CAF50;
        }
        .report-stat .absent {
            color: #F44336;
        }
        .report-stat .present {
            color: #4CAF50;
        }
        .report-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .report-section table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }
        .report-section table th, .report-section table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .report-section table th {
            background-color: #003366;
            color: #fff;
        }
        .report-section table tr:nth-child(even) {
            background-color: #f4f6f9;
        }
        .report-section table td {
            color: #333;
        }
        .report-section table td a {
            color: #003366;
            text-decoration: none;
        }
        .report-section table td a:hover {
            color: #4CAF50;
        }
        .report-section h3 {
            margin-top: 30px;
            font-size: 22px;
            color: #003366;
        }
        .report-section .btn {
            display: inline-block;
            background-color: #FF9800;
            color: #fff;
            padding: 10px 20px;
            margin-top: 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .report-section .btn:hover {
            background-color: #e68900;
        }
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
        .report-section h3 {
            font-size: 1.5em;
            margin-bottom: 1em;
        }

        .revenue-container {
            margin-top: 1em;
        }

        .revenue-service {
            background-color: #f9f9f9;
            padding: 1em;
            margin-bottom: 1em;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .service-name {
            font-size: 1.2em;
            margin-bottom: 0.5em;
        }

        .revenue-details p {
            margin: 0.5em 0;
        }

    </style>
</head>
<body>
    <header>
        <h1>Reports and Analytics</h1>
    </header>

    <div class="container">
        <!-- Enrollment Statistics -->
        <div class="report-section">
            <h2><i class="fas fa-users"></i> Enrollment Statistics</h2>
            <div class="report-stat"><i class="fas fa-clipboard-list"></i> Total Enrollments: <span><?php echo $enrollment_stats['total_enrollments']; ?></span></div>
            <div class="report-stat pending"><i class="fas fa-hourglass-half"></i> Pending Enrollments: <span><?php echo $enrollment_stats['pending_enrollments']; ?></span></div>
            <div class="report-stat confirmed"><i class="fas fa-check-circle"></i> Confirmed Enrollments: <span><?php echo $enrollment_stats['confirmed_enrollments']; ?></span></div>
        </div>

        <!-- Attendance Tracking -->
        <div class="report-section">
            <h2><i class="fas fa-calendar-check"></i> Attendance Tracking</h2>
            <div class="report-stat present"><i class="fas fa-check-circle"></i> Present Children: <span><?php echo $attendance_data['present']; ?></span></div>
            <div class="report-stat absent"><i class="fas fa-times-circle"></i> Absent Children: <span><?php echo $attendance_data['absent']; ?></span></div>
        </div>

        <!-- Revenue Tracking -->
        <div class="report-section">
            <h3>Revenue Tracking</h3>

            <?php
            // Revenue Tracking SQL query
            $sql = "SELECT 
                        sl.name AS service_name,
                        SUM(CASE WHEN b.status = 1 THEN b.amount ELSE 0 END) AS total_revenue,
                        SUM(CASE WHEN b.status = 0 THEN b.amount ELSE 0 END) AS pending_revenue
                    FROM billing b
                    JOIN service_list sl ON b.service_id = sl.id
                    WHERE b.date_created BETWEEN ? AND ?
                    GROUP BY sl.name";  // Group by service name

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$start_date, $end_date]);
            $revenue_data = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Fetch all service-wise revenue data
            ?>

            <div class="revenue-container">
                <?php if ($revenue_data && count($revenue_data) > 0): ?>
                    <?php foreach ($revenue_data as $service): ?>
                        <div class="revenue-service">
                            <h4 class="service-name"><?= htmlspecialchars($service['service_name']) ?></h4>
                            <div class="revenue-details">
                                <p><strong>Total Revenue:</strong> <?= number_format($service['total_revenue'], 2) ?></p>
                                <p><strong>Pending Revenue:</strong> <?= number_format($service['pending_revenue'], 2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No revenue data found for the selected date range.</p>
                <?php endif; ?>
            </div>
        </div>


         <!-- Service Usage -->
         <div class="report-section">
            <h2>Service Usage</h2>
            <?php if (count($service_usage) > 0): ?>
                <?php foreach ($service_usage as $service): ?>
                    <div class="report-stat">
                        <?php echo $service['service_name']; ?>: <?php echo $service['children_enrolled']; ?> children enrolled
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="report-stat">No service usage data available</div>
            <?php endif; ?>
        </div>

        <!-- Seasonal Trends -->
        <div class="report-section">
            <h2><i class="fas fa-calendar-alt"></i> Seasonal Trends</h2>
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Enrollments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($seasonal_trends as $trend): ?>
                        <tr>
                            <td><?php echo date("F", mktime(0, 0, 0, $trend['month'], 10)); ?></td>
                            <td><?php echo $trend['enrollments']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Enrollment vs Attendance -->
        <div class="report-section">
            <h2><i class="fas fa-user-check"></i> Enrollment vs Attendance</h2>
            <div class="report-stat"><i class="fas fa-users"></i> Total Enrollments: <span><?php echo $enrollment_vs_attendance['total_enrollments']; ?></span></div>
            <div class="report-stat present"><i class="fas fa-check-circle"></i> Total Present: <span><?php echo $enrollment_vs_attendance['total_attendance']; ?></span></div>
            <div class="report-stat absent"><i class="fas fa-times-circle"></i> Total Absent: <span><?php echo $enrollment_vs_attendance['total_absent']; ?></span></div>
        </div>

        <a href="#" class="btn">Export Report</a>
    </div>
</body>
</html>

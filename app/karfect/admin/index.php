<?php
session_start();
require_once 'includes/db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch dashboard stats
$stats = [
    'total_services' => $conn->query("SELECT COUNT(*) FROM services")->fetch_row()[0],
    'total_workers' => $conn->query("SELECT COUNT(*) FROM workers")->fetch_row()[0],
    'active_workers' => $conn->query("SELECT COUNT(*) FROM workers WHERE status='Active'")->fetch_row()[0],
    'total_reviews' => $conn->query("SELECT SUM(reviews) FROM services")->fetch_row()[0],
];

// Fetch recent services for table
$recent_services = $conn->query("SELECT id, title, category, discounted_price, rating FROM services ORDER BY id DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

// Fetch data for charts
$category_counts = $conn->query("SELECT category, COUNT(*) as count FROM services GROUP BY category")->fetch_all(MYSQLI_ASSOC);
$worker_status = $conn->query("SELECT status, COUNT(*) as count FROM workers GROUP BY status")->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Karfect Admin Dashboard for managing services and workers">
    <title>Karfect || Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
/* Main Content */
.main-content {
    margin-left: 250px;
    padding: 24px;
    min-height: 100vh;
    transition: margin-left 0.3s ease;
}

.main-content.full {
    margin-left: 0;
}

.container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Headings */
h4 {
    font-size: 14px;
    font-weight: 400;
    color: #5f6368;
    margin-bottom: 24px;
}

/* Stats Cards */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.card {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    position: relative;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, #1a73e8, #8ab4f8);
    opacity: 0.3;
    transition: opacity 0.2s ease;
}

.card:hover::before {
    opacity: 1;
}

.card .flex {
    display: flex;
    align-items: center;
    gap: 12px;
}

.card-icon {
    width: 24px;
    height: 24px;
    stroke: #1a73e8;
    stroke-width: 1.5;
    transition: transform 0.2s ease;
}

.card:hover .card-icon {
    transform: scale(1.05);
}

.card-label {
    font-size: 12px;
    font-weight: 500;
    color: #5f6368;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-stat {
    font-size: 24px;
    font-weight: 500;
    color: #202124;
}

/* Charts */
.chart-container {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
}

.chart-container h5 {
    font-size: 18px;
    font-weight: 500;
    color: #202124;
    margin-bottom: 16px;
}

canvas {
    max-height: 250px;
}

/* Table */
.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

.table-container h5 {
    font-size: 18px;
    font-weight: 500;
    color: #202124;
    padding: 16px;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

th, td {
    padding: 12px 16px;
    text-align: left;
    font-size: 14px;
}

th {
    background: #f1f3f4;
    color: #202124;
    font-weight: 500;
    position: sticky;
    top: 0;
    z-index: 10;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

td {
    border-top: 1px solid #dadce0;
    color: #5f6368;
}

tr {
    transition: background-color 0.2s ease;
}

tr:hover {
    background: #e8f0fe;
}

/* Animations */
@keyframes slideIn {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.animate-slide-in {
    animation: slideIn 0.6s ease-out forwards;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    animation: fadeIn 0.4s ease-in forwards;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .main-content {
        margin-left: 0;
        padding: 16px;
    }

    .grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}

@media (max-width: 768px) {
    .card {
        padding: 12px;
    }

    .card-stat {
        font-size: 20px;
    }

    .card-label {
        font-size: 10px;
    }

    .chart-container {
        padding: 12px;
    }

    canvas {
        max-height: 200px;
    }

    th, td {
        padding: 10px 12px;
        font-size: 12px;
    }
}

@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
    }

    .card {
        padding: 10px;
    }

    .card-icon {
        width: 20px;
        height: 20px;
    }

    .card-stat {
        font-size: 18px;
    }

    .card-label {
        font-size: 9px;
    }

    .table-container {
        font-size: 12px;
    }

    canvas {
        max-height: 180px;
    }
}
    </style>
</head>
<body>
    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="main-content" id="main-content" aria-label="Main dashboard content">
        <div class="container">
            <div class="flex justify-between items-center mb-8 animate-slide-in">
                <h4 class="leading-tight">Admin > Dashboard</h4>
                <!-- <button id="toggle-sidebar" class="btn md:hidden" aria-label="Toggle sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button> -->
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8"> <!-- Reduced gap from 6 -->
                <div class="card fade-in" role="region" aria-label="Total Services">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="card-icon mr-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <div>
                            <p class="card-label">Total Services</p>
                            <h5 class="card-stat"><?php echo htmlspecialchars($stats['total_services'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card fade-in" role="region" aria-label="Total Workers">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="card-icon mr-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <div>
                            <p class="card-label">Total Workers</p>
                            <h5 class="card-stat"><?php echo htmlspecialchars($stats['total_workers'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card fade-in" role="region" aria-label="Active Workers">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="card-icon mr-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <div>
                            <p class="card-label">Active Workers</p>
                            <h5 class="card-stat"><?php echo htmlspecialchars($stats['active_workers'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card fade-in" role="region" aria-label="Total Reviews">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="card-icon mr-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <div>
                            <p class="card-label">Total Reviews</p>
                            <h5 class="card-stat"><?php echo htmlspecialchars($stats['total_reviews'], ENT_QUOTES, 'UTF-8'); ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8"> <!-- Reduced gap from 6 -->
                <div class="card chart-container fade-in" role="region" aria-label="Services by Category Chart">
                    <h5 class="mb-4">Services by Category</h5>
                    <canvas id="categoryChart" aria-label="Pie chart showing services by category"></canvas>
                </div>
                <div class="card chart-container fade-in" role="region" aria-label="Worker Status Chart">
                    <h5 class="mb-4">Worker Status</h5>
                    <canvas id="statusChart" aria-label="Doughnut chart showing worker status"></canvas>
                </div>
            </div>

            <!-- Recent Services -->
            <div class="card fade-in" role="region" aria-label="Recent Services Table">
                <h5 class="mb-4">Recent Services</h5>
                <div class="table-container">
                    <table role="grid">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Price</th>
                                <th scope="col">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_services as $service): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($service['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($service['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>₹<?php echo number_format($service['discounted_price'], 2); ?></td>
                                    <td><?php echo number_format($service['rating'], 1); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js configuration
        const categoryData = {
            labels: <?php echo json_encode(array_column($category_counts, 'category')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($category_counts, 'count')); ?>,
                backgroundColor: ['#6e42e5', '#5a32d1', '#7e57c2', '#9575cd', '#b39ddb'],
                borderColor: '#fff',
                borderWidth: 2,
            }]
        };
        const statusData = {
            labels: <?php echo json_encode(array_column($worker_status, 'status')); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($worker_status, 'count')); ?>,
                backgroundColor: ['#6e42e5', '#ef4444', '#10b981'],
                borderColor: '#fff',
                borderWidth: 2,
            }]
        };

        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: categoryData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 14, family: 'Inter' } } },
                    tooltip: { backgroundColor: '#1f2a44', titleFont: { size: 14 }, bodyFont: { size: 12 } }
                },
                animation: { animateScale: true, animateRotate: true }
            }
        });
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: statusData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 14, family: 'Inter' } } },
                    tooltip: { backgroundColor: '#1f2a44', titleFont: { size: 14 }, bodyFont: { size: 12 } }
                },
                animation: { animateScale: true, animateRotate: true }
            }
        });

        // Sidebar toggle
        //document.getElementById('toggle-sidebar')?.addEventListener('click', () => {
        //    const sidebar = document.querySelector('.sidebar');
        //    sidebar.classList.toggle('active');
        //    document.getElementById('main-content').classList.toggle('full');
        //});
    </script>
</body>
</html>
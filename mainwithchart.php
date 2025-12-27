<?php
// opfmsl_fire_chart.php
// Full rewritten dashboard + chart (2023 - current year)
// HTML comments use <!-- comment -->
// PHP comments use // or /* */

include 'functions.php'; // include your DB helper file
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

$fullname = $_SESSION['fullname'] ?? '';
$userStation = $_SESSION['citymunicipality'] ?? '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Connect and fetch data
$conn = connectToDatabase();
$result = fetchData($conn, $search); // fetchData should return a mysqli_result or similar

// Initialize counters and yearly data (2023 .. current year)
$startYear = 2025;
$currentYear = (int) date('Y');
$yearlyData = [];
for ($y = $startYear; $y <= $currentYear; $y++) {
    $yearlyData[$y] = [
        'OPFMSL' => 0,
        'MDFI' => 0,
        'RESIDENTIAL' => 0,
        'NON-RESIDENTIAL' => 0,
        'STRUCTURAL' => 0,
        'NON-STRUCTURAL' => 0,
        'TRANSPORT' => 0,
    ];
}

// Current year summary counters (amounts and counts)
$opfmslregcounter = $opfmslregamount = 0;
$opfmslmdficounter = $opfmslmdfiamount = 0;
$rescounter = $resamount = 0;
$nonrescounter = $nonresamount = 0;
$nonstrcounter = $nonstramount = 0;
$transportcounter = $transportamount = 0;

if ($result && $result->num_rows > 0) {
    // iterate through rows once and build both yearly and current-year summaries
    while ($row = $result->fetch_assoc()) {
        // protect missing fields
        $alarm = isset($row['alarm_datetime']) ? $row['alarm_datetime'] : null;
        $typereport = isset($row['typereport']) ? $row['typereport'] : '';
        $category = isset($row['general_category']) ? $row['general_category'] : '';
        $estimated = isset($row['estimated_damage']) ? (float) $row['estimated_damage'] : 0.0;

        if ($alarm) {
            $year = (int) date('Y', strtotime($alarm));
            if ($year >= $startYear && $year <= $currentYear) {
                // OPFMSL vs MDFI counting (by report type)
                if (strcasecmp($typereport, 'Regular') === 0) {
                    $yearlyData[$year]['OPFMSL']++;
                } else {
                    $yearlyData[$year]['MDFI']++;
                }

                // category counters (increment only the category occurrence)
                switch (strtoupper($category)) {
                    case 'RESIDENTIAL':
                        $yearlyData[$year]['RESIDENTIAL']++;
                        break;
                    case 'NON-RESIDENTIAL':
                        $yearlyData[$year]['NON-RESIDENTIAL']++;
                        break;
                    case 'STRUCTURAL':
                        $yearlyData[$year]['STRUCTURAL']++;
                        break;
                    case 'NON-STRUCTURAL':
                        $yearlyData[$year]['NON-STRUCTURAL']++;
                        break;
                    case 'TRANSPORT':
                        $yearlyData[$year]['TRANSPORT']++;
                        break;
                }
            }

            // If the row is in the current year, also aggregate amounts for dashboard
            if ($year === $currentYear) {
                if (strcasecmp($typereport, 'Regular') === 0) {
                    $opfmslregcounter++;
                    $opfmslregamount += $estimated;
                } else {
                    $opfmslmdficounter++;
                    $opfmslmdfiamount += $estimated;
                }

                switch (strtoupper($category)) {
                    case 'RESIDENTIAL':
                        if (strcasecmp($typereport, 'Regular') === 0) {
                            $rescounter++;
                            $resamount += $estimated;
                        }
                        break;
                    case 'NON-RESIDENTIAL':
                        if (strcasecmp($typereport, 'Regular') === 0) {
                            $nonrescounter++;
                            $nonresamount += $estimated;
                        }
                        break;
                    case 'NON-STRUCTURAL':
                        if (strcasecmp($typereport, 'Regular') === 0) {
                            $nonstrcounter++;
                            $nonstramount += $estimated;
                        }
                        break;
                    case 'TRANSPORT':
                        if (strcasecmp($typereport, 'Regular') === 0) {
                            $transportcounter++;
                            $transportamount += $estimated;
                        }
                        break;
                }
            }
        }
    }
}

// close connection
$conn->close();

// Prepare JSON for chart (safe encoding)
$yearlyLabels = array_keys($yearlyData);
$yearlyJson = json_encode($yearlyData);
$labelsJson = json_encode($yearlyLabels);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IIS - Dashboard & Charts</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar { background-color: #0661bc; }
    .bg-bfp { background-color:#0661bc !important; }
    .dashboard-box { border-radius: 12px; padding: 20px; color: #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.12s ease-in-out; }
    .dashboard-box:hover { transform: translateY(-4px); }
  </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="bfpsl.png" alt="Logo" style="width:45px;height:45px;border-radius:50%;margin-right:10px;">
      <span>BFP-OPFMSL Intelligence and Investigation Section (IIS)</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="main.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="perstation.php">Per Station</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Fire Incident/s</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="dataentry.php">Data Entry</a></li>
            <li><a class="dropdown-item" href="fireincidents.php">View Entries</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="Contact.php">Contact Us</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-3">
  <h6>Welcome, <?php echo htmlspecialchars($fullname); ?>! <a href="logout.php">Logout</a></h6>
  <h4 class="mt-2">📊 Dashboard Overview - Province of Southern Leyte for CY <?php echo date('Y'); ?></h4>

  <div class="row gy-4 mt-3">
    <div class="col-md-3">
      <div class="dashboard-box bg-danger text-center">
        <h4><?php echo $opfmslregcounter; ?></h4>
        <p><?php echo '₱ '.number_format($opfmslregamount,2); ?></p>
        <small>Total (OPFMSL)</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box bg-secondary text-center">
        <h4><?php echo $opfmslmdficounter; ?></h4>
        <p><?php echo '₱ '.number_format($opfmslmdfiamount,2); ?></p>
        <small>Total MDFI (OPFMSL)</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box bg-primary text-center">
        <h4><?php echo $rescounter; ?></h4>
        <p><?php echo '₱ '.number_format($resamount,2); ?></p>
        <small>RESIDENTIAL</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="dashboard-box bg-dark text-center">
        <h4><?php echo $nonrescounter; ?></h4>
        <p><?php echo '₱ '.number_format($nonresamount,2); ?></p>
        <small>NON-RESIDENTIAL</small>
      </div>
    </div>

    <div class="col-md-3 mt-3">
      <div class="dashboard-box bg-success text-center">
        <h4><?php echo $nonstrcounter; ?></h4>
        <p><?php echo '₱ '.number_format($nonstramount,2); ?></p>
        <small>NON-STRUCTURAL</small>
      </div>
    </div>
    <div class="col-md-3 mt-3">
      <div class="dashboard-box bg-warning text-center text-dark">
        <h4><?php echo $transportcounter; ?></h4>
        <p><?php echo '₱ '.number_format($transportamount,2); ?></p>
        <small>TRANSPORT</small>
      </div>
    </div>
  </div>

  <!-- Chart -->
  <div class="card mt-4">
    <div class="card-body">
      <h5 class="card-title">Fire Incidents (<?php echo $startYear; ?> - <?php echo $currentYear; ?>)</h5>
      <canvas id="fireChart" height="120"></canvas>
    </div>
  </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
// Pass PHP data to JS
const yearlyData = <?php echo $yearlyJson; ?>;
const labels = <?php echo $labelsJson; ?>;

// Helper to safely read keys with hyphens
function valAt(year, key) {
    if (!yearlyData.hasOwnProperty(year)) return 0;
    return yearlyData[year][key] || 0;
}

const years = labels; // array of years as strings
const dsOPFMSL = years.map(y => valAt(y, 'OPFMSL'));
const dsMDFI = years.map(y => valAt(y, 'MDFI'));
const dsRES = years.map(y => valAt(y, 'RESIDENTIAL'));
const dsNONRES = years.map(y => valAt(y, 'NON-RESIDENTIAL'));
const dsSTR = years.map(y => valAt(y, 'STRUCTURAL'));
const dsNONSTR = years.map(y => valAt(y, 'NON-STRUCTURAL'));
const dsTRANS = years.map(y => valAt(y, 'TRANSPORT'));

new Chart(document.getElementById('fireChart'), {
    type: 'line',
    data: {
        labels: years,
        datasets: [
            { label: 'OPFMSL', data: dsOPFMSL, borderWidth: 2, fill: false },
            { label: 'MDFI', data: dsMDFI, borderWidth: 2, fill: false },
            { label: 'RESIDENTIAL', data: dsRES, borderWidth: 2, fill: false },
            { label: 'NON-RESIDENTIAL', data: dsNONRES, borderWidth: 2, fill: false },
            { label: 'STRUCTURAL', data: dsSTR, borderWidth: 2, fill: false },
            { label: 'NON-STRUCTURAL', data: dsNONSTR, borderWidth: 2, fill: false },
            { label: 'TRANSPORT', data: dsTRANS, borderWidth: 2, fill: false }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: (value) => value,
                font: {
                    weight: 'bold',
                    size: 12
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
</body>
</html>

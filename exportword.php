<?php
include 'functions.php'; // Include the functions file

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}
$conn = connectToDatabase(); // Call the function to connect to the database
// Get search term from query parameter
// Check if id exists in URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // secure the input
    
    $sql = "SELECT * FROM fire_incidents WHERE id = $id ORDER By id desc"; // use your actual table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
           } else {
        die("No record found with ID = $id");
    }
} else {
    die("No ID provided in URL.");
}

$result = fetchRow($conn, $id); // Call the function to fetch data

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IIS - BFP OPFMSL</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  />

  <!-- DataTables CSS -->
  <link 
    href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" 
    rel="stylesheet"
  />
 <title>IIS - FIM</title>
 <!-- Bootstrap CSS -->
<link
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
  rel="stylesheet"
/>

<!-- DataTables CSS (Bootstrap 5 integration) -->
<link
  href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"
  rel="stylesheet"
/>
  <style>
     .bg-bfp {
    background-color:#0661bc !important; /* deep navy blue */
  }
    .navbar {
      background-color: #0661bc; /* dark blue background */
    }
     .bg-bfp {
    background-color:#0661bc !important; /* deep navy blue */
  }
    .navbar .logo {
      font-weight: bold;
      font-size: 18px;
      color: white;
      text-decoration: none;
    }
    .navbar-nav .nav-link {
      color: white !important;
    }
    .navbar-nav .nav-link:hover {
      color: #ffcc00 !important;
    }
    .navbar-brand img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      margin-right: 10px;
    }
     /* Navigation bar container */
   .dashboard-box {
      border-radius: 12px;
      padding: 20px;
      color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
    }
    .dashboard-box:hover {
      transform: scale(1.03);
    }
     
        #reportContent {
    font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
    font-size: 16pt;
}

#reportContent h3,
#reportContent h4 {
    font-weight: bold;
}

  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <!-- Logo and Title -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="bfpsl.png" alt="Logo">
        <span>BFP-OPFMSL Intelligence and Investigation Section (IIS)</span>
      </a>

      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="main.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="perstation.php">Per Station</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
             Fire Incidents
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="dataentry.php">Data Entry</a></li>
              <li><a class="dropdown-item" href="fireincidents.php">View Entries</a></li>
             </ul>
          </li>
         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
              Reports
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
               <li><a class="dropdown-item" href="overdue.php">Investigation Reports Deadline</a></li>
              <li><a class="dropdown-item" href="summaryfi.php">Summary of Fire Incidents</a></li>
              
             </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
              User Accounts
            </a>
            <ul class="dropdown-menu dropdown-menu-end">

             <li><a class="dropdown-item" href="userview.php">View Users</a></li>
             </ul>
          </li>
          
         

          <li class="nav-item"><a class="nav-link" href="Contact.html">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
   <div class="container mt-3">
   
</div>
   <div class="container mt-2" >

<h6>Welcome, <?php echo " " . $_SESSION['fullname'] . " ( " . $_SESSION['username'] . "/" .  $_SESSION['Level'] . "/" .  $_SESSION['citymunicipality'] .   ") "; ?>! You have successfully logged in.  <a href="logout.php">Logout</a></h6>
  
 
</div>
</div>
    <!-- CARD: DATATABLE -->
    <div class="card shadow-lg">
      <div class="card-header bg-bfp text-white text-center">
        <h4>Fire Incident Complete Details </h4>
      </div>
 
        <div class="container mt-4">
    <div class="text-center mb-3">
        <button class="btn btn-success" onclick="exportToPdf()">Export to PDF</button>
        <button onclick='window.history.back();' class='btn btn-secondary'>
    ← Back
</button>
    </div>

    <div id="reportContent" style="margin-left:40px; margin-right:40px;">
        <h3 class="text-center mb-4">Fire Incident</h3>

        <div class="row mb-3">
            <div class="col-md-2"><b>Region:</b> <span><?php echo $row['region']; ?></span></div>
            <div class="col-md-2"><b>Province:</b> <span><?php echo $row['province']; ?></span></div>
            <div class="col-md-3"><b>City/Municipality:</b> <span><?php echo $row['citymunicipality']; ?></span></div>
            <div class="col-md-5"><b>Exact Location:</b> <span><?php echo $row['location']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Date Reported:</b> <span><?php echo $row['alarm_datetime']; ?></span></div>
            <div class="col-md-4"><b>Fire Started:</b> <span><?php echo $row['datetime_started']; ?></span></div>
            <div class="col-md-4"><b>Fire Out:</b> <span><?php echo $row['datetime_out']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Category:</b> <span><?php echo $row['general_category']; ?></span></div>
            <div class="col-md-4"><b>Sub-Category:</b> <span><?php echo $row['sub_category']; ?></span></div>
            <div class="col-md-4"><b>Establishment/s:</b> <span><?php echo $row['establishment_name']; ?></span></div>
        </div>

        <!-- Continue the same pattern for all remaining fields -->

        <div class="row mb-3">
            <div class="col-md-4"><b>Owner/s:</b> <span><?php echo $row['owner']; ?></span></div>
            <div class="col-md-4"><b>Occupant/s:</b> <span><?php echo $row['occupant']; ?></span></div>
            <div class="col-md-4"><b>No. of Storeys:</b> <span><?php echo $row['no_of_storeys']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Distance (Station to Scene):</b> <span><?php echo $row['dist']; ?></span></div>
            <div class="col-md-4"><b>Dispatch Time:</b> <span><?php echo $row['dispatch']; ?></span></div>
            <div class="col-md-4"><b>Arrival Time:</b> <span><?php echo $row['arrival']; ?></span></div>
        </div>

        <!-- Injuries / Fatalities -->
        <div class="row mb-3">
            <div class="col-md-4"><b>BFP Injuries (M/F/Total):</b> <span><?php echo $row['injuredbfpmale'].'/'.$row['injuredbfpfemale'].'/'.$row['injuredbfptotal']; ?></span></div>
            <div class="col-md-4"><b>Civilian Injuries (M/F/Total):</b> <span><?php echo $row['injuredcivmale'].'/'.$row['injuredcivfemale'].'/'.$row['injuredcivtotal']; ?></span></div>
            <div class="col-md-4"><b>BFP Fatalities (M/F/Total):</b> <span><?php echo $row['fatalbfpmale'].'/'.$row['fatalbfpfemale'].'/'.$row['fatalbfptotal']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Civilian Fatalities (M/F/Total):</b> <span><?php echo $row['fatalcivmale'].'/'.$row['fatalcivfemale'].'/'.$row['fatalcivtotal']; ?></span></div>
            <div class="col-md-4"><b>No. Affected Structures:</b> <span><?php echo $row['affectedstructure']; ?></span></div>
            <div class="col-md-4"><b>Estimated Damage:</b> <span><?php echo $row['estimated_damage']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Alarm Level:</b> <span><?php echo $row['alarm_level']; ?></span></div>
            <div class="col-md-4"><b>Cause of Fire:</b> <span><?php echo $row['cause']; ?></span></div>
            <div class="col-md-4"><b>Classification:</b> <span><?php echo $row['classification']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Fire Arson Investigator (FAI):</b> <span><?php echo $row['fai']; ?></span></div>
            <div class="col-md-4"><b>FSIC:</b> <span><?php echo $row['fsic']; ?></span></div>
            <div class="col-md-4"><b>Report Type:</b> <span><?php echo $row['typereport']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Status:</b> <span><?php echo $row['status']; ?></span></div>
            <div class="col-md-8"><b>Remarks:</b> <span><?php echo $row['remarks']; ?></span></div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4"><b>Date Submitted (SIR):</b> <span><?php echo $row['spot_report']; ?></span></div>
            <div class="col-md-4"><b>Date Submitted (PIR):</b> <span><?php echo $row['progress_report']; ?></span></div>
            <div class="col-md-4"><b>Date Submitted (FIR):</b> <span><?php echo $row['final_report']; ?></span></div>
        </div>
    </div>
</div>
<script>
async function exportToPdf() {
    const { jsPDF } = window.jspdf;

    const report = document.getElementById("reportContent");

    const canvas = await html2canvas(report, {
        scale: 2,
        useCORS: true
    });

    const imgData = canvas.toDataURL("image/png");

    const pdf = new jsPDF("p", "mm", "a4");

    const margin = 25.4; // 1 inch in mm
    const pageWidth = 210;
    const pageHeight = 297;

    const contentWidth = pageWidth - margin * 2;
    const contentHeight = (canvas.height * contentWidth) / canvas.width;

    let heightLeft = contentHeight;
    let position = margin;

    // First page
    pdf.addImage(imgData, "PNG", margin, position, contentWidth, contentHeight);
    heightLeft -= (pageHeight - margin * 2);

    // Additional pages
    while (heightLeft > 0) {
        pdf.addPage();
        position = margin - (contentHeight - heightLeft);
        pdf.addImage(imgData, "PNG", margin, position, contentWidth, contentHeight);
        heightLeft -= (pageHeight - margin * 2);
    }

    // Filename
    const region = "<?php echo $row['region']; ?>";
    const city = "<?php echo $row['citymunicipality']; ?>";
    const category = "<?php echo $row['general_category']; ?>";
    const location = "<?php echo $row['location']; ?>";
    const alarm = "<?php echo date('m-d-Y', strtotime($row['alarm_datetime'])); ?>";
    const fai = "<?php echo $row['fai']; ?>";

    const safe = str => str.replace(/[^\w\-]/g, "_");

    const filename =
        "FireIncident_" +
        safe(alarm) + "_" +
        safe(category) + "_" +
        safe(city) + "_" +
        safe(location) + "_" +
        safe(fai) + ".pdf";

    pdf.save(filename);
}
</script>


    </div>
  </div>
  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      var table = $('#dataTable').DataTable();

      // Handle form submission
      $('#dataForm').on('submit', function(e) {
        e.preventDefault();

        // Get form values
        var citymunicipality = $('#citymunicipality').val();
        var location = $('#location').val();
        var alarm_datetime = $('#alarm_datetime').val();
        var datetime_out = $('#datetime_out').val();
        var general_category = $('#general_category').val();
        var owner = $('#owner').val();
        var estimated_damage = $('#estimated_damage').val();
        var id = $('#id').val();
        

        // Add row to DataTable
        table.row.add([
          fullname, email, contact, position, region, city, date, remarks
        ]).draw(false);

        // Clear form
        this.reset();
      });
    });
  </script>
 
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</body>
</html>

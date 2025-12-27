<?php
include 'functions.php'; // Include the functions file

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

// Get search term from query parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

$conn = connectToDatabase(); // Call the function to connect to the database
$result = fetchData($conn, $search); // Call the function to fetch data

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
              Fire Incident/s
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="dataentry.php">Data Entry</a></li>
              <li><a class="dropdown-item" href="Fireincidents.php">View Entries</a></li>
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
         

          <li class="nav-item"><a class="nav-link" href="Contact.php">Contact Us</a></li>
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
        <h4>IR(SIR/PIR/FIR) Submission Deadline</h4>
      </div>
      <div class="card-body">
            <div class="d-flex justify-content-center mb-1 gap-2">
    <a href="main.php" class="btn btn-primary px-5">
        ← Home
    </a></div>
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Station</th>
              <th>Date and Time of Fire Alarm</th>
              <th>Exact Location</th>
              <th>FA Investigator</th>
              <th>Category</th>
              <th>SIR (24hrs)</th>
              <th>PIR (15days)</th>
              <th>FIR (45days)</th>
              <th>Action Taken</th>
            </tr>
          </thead>
          <tbody>
            <!-- Records will be added dynamically -->
               <!-- Records will be added dynamically -->
              <?php
                if ($result->num_rows > 0) {
              

                    while ($row = $result->fetch_assoc()) {
                       if (date("Y", strtotime($row["alarm_datetime"])) == date("Y")){
                      if  ($row["status"] != "Closed") {
                         $sirdeadline = $row["alarm_datetime"];
                        $pirdeadline = $row["alarm_datetime"];
                        $firdeadline = $row["alarm_datetime"];
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["citymunicipality"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["alarm_datetime"]) . "</td>";
                         echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fai"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["general_category"]) . "</td>";
                        
                       
                           if (isset($row["spot_report"]) && $row["spot_report"] !== null AND $row["spot_report"] !== '0000-00-00') {
                              $submitted = date("M d, Y ", strtotime($row["spot_report"]));
                      echo "<td>submitted ($submitted)</td>";
                          } else {
                            $sirdeadline = date("Y-m-d H:i:s", strtotime($sirdeadline . " +24 hours"));
                        $sirdeadline = date("M d, Y h:i A", strtotime($sirdeadline));
                        echo "<td>$sirdeadline</td>";
                      
                          }

                         if (isset($row["progress_report"]) && $row["progress_report"] !== null AND $row["progress_report"] !== '0000-00-00')  {
                           $submitted = date("M d, Y ", strtotime($row["progress_report"]));
                      echo "<td>submitted ($submitted)</td>";
                          } else {$pirdeadline = date("Y-m-d H:i:s", strtotime($pirdeadline . " +15 days"));
                        $pirdeadline = date("M d, Y ", strtotime($pirdeadline));
                        echo "<td>$pirdeadline</td>";

                          }
                         if (isset($row["final_report"]) && $row["final_report"] !== null AND $row["final_report"] !== '0000-00-00')  {
                           $submitted = date("M d, Y ", strtotime($row["final_report"]));
                           echo "<td>submitted ($submitted)</td>";
                          } else {
                        $firdeadline = date("M d, Y ", strtotime($firdeadline. " +45 days"));
                        echo "<td>$firdeadline</td>";
                          }
                                       // echo "<td>" . htmlspecialchars(string: $row["estimated_damage"]) . "</td>";
                                   
                  echo '<td style="text-decoration: underline; color:blue">
        <a href="update.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">Update</a> |
        <a href="exportword.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">Export</a> |
        <a href="viewIR.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">View Report</a>
      </td>';
                         // Add to total (make sure to cast to number)
                                             
                        }
                       }
                    }
                /* - Total Fire Indidents
                   echo '
                    <tfoot>
                           <tr>
                            <td colspan="1" style="text-align:right; color:blue; font-weight:bold;">REGULAR:</td>
                             <td style="font-weight:bold; color:blue; text-align:right">
                               <span>(' . number_format($regularcounter) . ')</span>
                            ₱' . number_format($regular_damage, 2) . '
                                   </td>

                           <td colspan="1" style="text-align:right; font-weight:bold; color:blue;">MDFI:</td>
                             <td style="font-weight:bold; text-align:right; color:blue;">
                           <span>(' . number_format($mdficounter) . ')</span>
                            ₱' . number_format($mdfi_damage, 2) . '
                                 </td>

                          <td colspan="2" style="text-align:right; font-weight:bold; color:blue;">TOTAL:</td>
                          <td style="font-weight:bold; text-align:right; color:blue;">
                            <span>(' . number_format($totalcounter) . ')</span>
                            ₱' . number_format($total_damage, 2) . '
                          </td>
                        </tr>
                      </tfoot>
                      '; */  
                  
                                      } 
                                      else {
                                          echo "<tr><td colspan='3'>No results found</td></tr>";
                                    
                                      } 
                                      
                                      ?>
            
 
          </tbody>
        </table>
      </div>
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
        var fullname = $('#fullname').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var position = $('#position').val();
        var region = $('#region').val();
        var city = $('#city').val();
        var date = $('#date').val();
        var remarks = $('#remarks').val();

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
</body>
</html>

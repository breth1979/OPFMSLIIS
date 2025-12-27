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
              <li><a class="dropdown-item" href="fireincidents.php">View Entries</a></li>
             </ul>
          </li>
       
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown">
              Reports
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
               <li><a class="dropdown-item" href="overdue.php">Investigation Reports Deadline</a></li>
              <li><a class="dropdown-item" href="summaryfi.php">Summary Fire Incidents</a></li>
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
        <h4>View - Fire Incident/s</h4>
      </div>
      <div class="card-body" class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
            <div class="d-flex justify-content-center mb-1 gap-2">
    <a href="main.php" class="btn btn-primary px-5">
        ← Home
    </a></div>
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Station</th>
              <th>Exact Location</th>
              <th>DT Reported</th>
              <th>Fire Started</th>
              <th>Category</th>
              <th>Owner/s</th>
              <th>Damage/s</th>
              <th>TypeReport</th>
              <th>Action/s</th>
            
            </tr>
          </thead>
          <tbody>
            <!-- Records will be added dynamically -->
              <?php
                if ($result->num_rows > 0) {
                  $regular_damage=0;
                  $regularcounter=0;
                  $mdficounter=0;
                  $totalcounter=0;
                  $mdfi_damage=0;
                  $total_damage = 0;
                    while ($row = $result->fetch_assoc()) {
                       if (date("Y", strtotime($row["alarm_datetime"])) == date("Y")){
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["citymunicipality"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                         echo "<td>" . htmlspecialchars($row["alarm_datetime"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["datetime_out"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["general_category"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["owner"]) . "</td>";
                       // echo "<td>" . htmlspecialchars(string: $row["estimated_damage"]) . "</td>";
                       echo "<td style='text-align:right;'> ₱ " . number_format((float)$row["estimated_damage"], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row["typereport"]) . "</td>";

                  echo '<td style="text-decoration: underline; color:blue">
        <a href="update.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">Update</a> |
        <a href="exportword.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">Export</a> |
        <a href="viewIR.php?id=' . urlencode($row["id"]) . '&citymunicipality=' . urlencode($row["citymunicipality"]) . '">View Report</a>
      </td>';

      


                        echo "</tr>";
                         // Add to total (make sure to cast to number)
                        $total_damage += (float)$row["estimated_damage"];
                        $totalcounter+=1;
                     
                        if ($row["typereport"]=="Regular") { $regular_damage+=(float)$row["estimated_damage"]; $regularcounter+=1;}
                         else {$mdfi_damage+=(float)$row["estimated_damage"]; $mdficounter+=1;}
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
<script>
function updateTotals() {
  let regularSum = 0, mdfiSum = 0, totalSum = 0;
  let regularCount = 0, mdfiCount = 0, totalCount = 0;

  document.querySelectorAll("#fireTable tbody tr").forEach(row => {
    const damageCell = row.querySelector(".damage");
    const typeCell = row.querySelector(".typereport");

    if (!damageCell || !typeCell) return;

    const damage = parseFloat(damageCell.textContent.replace(/,/g, '')) || 0;
    const type = typeCell.textContent.trim().toUpperCase();

    totalSum += damage;
    totalCount++;

    if (type === "REGULAR") {
      regularSum += damage;
      regularCount++;
    } else if (type === "MDFI") {
      mdfiSum += damage;
      mdfiCount++;
    }
  });

  document.getElementById("regular_total").innerHTML =
    `(${regularCount}) ₱${regularSum.toLocaleString(undefined, {minimumFractionDigits:2})}`;
  document.getElementById("mdfi_total").innerHTML =
    `(${mdfiCount}) ₱${mdfiSum.toLocaleString(undefined, {minimumFractionDigits:2})}`;
  document.getElementById("total_total").innerHTML =
    `(${totalCount}) ₱${totalSum.toLocaleString(undefined, {minimumFractionDigits:2})}`;
}

// Recalculate whenever a cell changes
document.querySelector("#fireTable").addEventListener("input", updateTotals);

// Optional: if rows can be added/removed dynamically
const observer = new MutationObserver(updateTotals);
observer.observe(document.querySelector("#fireTable tbody"), { childList: true, subtree: true });
</script>
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
      scrollX: true;
      scrollY: true;


      // Handle form submission
      $('#dataForm').on('submit', function(e) {
        e.preventDefault();

        // Get form values
        var citymunicipality = $('#citymunicipality').val();
        var location = $('#location').val();
        var alarm_datetime = $('#alarm_datetime').val();
        var datetime_out = $('#datetime_out').val();
        var general_category = $('#datetime_out').val();
        var owner = $('#owner').val();
        var estimated_damage = $('#estimated_damage').val();
        var typereport=$('#typereport').val();
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
</body>
</html>
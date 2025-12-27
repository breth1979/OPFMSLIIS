<?php
include 'functions.php'; // Include the functions file

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

if ($_SESSION['Level'] !== 'Administrator') {
    echo "<script>
    alert('⛔ Access denied. Administrator only! ');
    window.location.href = 'main.php'; // or login.php
</script>";
exit();

}
// Get search term from query parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';

$conn = connectToDatabase(); // Call the function to connect to the database
// Call the function to fetch data




 
    $result = fetchusers($conn );

//$result = fetchsummary($conn, $filters, $search);

$conn->close(); // Close the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IIS - Navigation Bar</title>
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
               <li><a class="dropdown-item" href="overdue.php"> Investigation Reports Deadline</a></li>
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
        <h4>USER PROFILES</h4>
      </div>
         <!-- Filter Form -->
   
          <div class="card-body">
        <div class="d-flex justify-content-center mb-1 gap-2">
    <a href="main.php" class="btn btn-primary px-4">
        ← Home
    </a>

  <a href="adduser.php" class="btn btn-primary px-5">
    + Add New User
</a>

</div>


<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
   
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
            <th>id</th>  
            <th>Full Name</th>
             <th>Email</th>
              <th>User Name</th>
              <th>Password</th>
              <th>User Level</th>
              <th>Station</th>
              <th>Grantor</th>
              <th>Action</th>
            
            </tr>
          </thead>
          <tbody>
            <!-- Records will be added dynamically -->
               <!-- Records will be added dynamically -->
              <?php
              if ($result !== null){
                if ($result->num_rows > 0) {
              

                    while ($row = $result->fetch_assoc()) {
                                                              
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fullname"]) . "</td>";
                         echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                       echo "<td>" . htmlspecialchars($row["userpassword"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Level"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["citymunicipality"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["grantor"]) . "</td>";
                    echo '<td>
    
    <a href="deleteuser.php?id=' . urlencode($row['id']) . '" 
       onclick="return confirmDelete(' . $row['id'] . ', \'' . addslashes($row['fullname']) . '\');" 
       style="color:red;">
       Delete
    </a>
</td>';

                        
                                       //
                        
                    
                     
                        
                     
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
                                    }
                                      ?>
            
 
          </tbody>
        </table>
        </div>
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
        scrollX: true;
         scrollY: true;

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
document.getElementById('exportExcel').addEventListener('click', function() {
    var table = document.getElementById('dataTable');
    var wb = XLSX.utils.table_to_book(table, {sheet:"Fire Incidents"});
    XLSX.writeFile(wb, 'fire_incidents.xlsx');
});
</script>
<!-- Your page content (tables, forms, etc.) here -->

<!-- Your modal HTML should be ABOVE this part -->
 <!--
<script>
alert(`Filter Parameters:\n<?php
foreach ($filters as $key => $value) {
    echo ucfirst(str_replace('_', ' ', $key)) . ": " . addslashes($value) . "\\n";
}
?>Search: <?php echo addslashes($search); ?>`);
</script>-->
<!-- ADD USER MODAL -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="save_user.php" method="POST" class="modal-content">
      
      <div class="modal-header bg-bfp text-white">
        <h5 class="modal-title">OPFMSLIIS - Add new user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" minlength="6" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Level</label>
          <select name="Level" class="form-select" required>
            <option value="">Select Level</option>
            <option value="Administrator">Administrator</option>
            <option value="Encoder">Encoder</option>
            <option value="Viewer">Viewer</option>
          </select>
        </div>

     
        <div class="mb-3">
    <label class="form-label">City / Municipality</label>
    <select name="citymunicipality" class="form-select" required>
        <option value="">Select Station</option>
        <option value="Maasin City Central">Maasin City Central</option>
        <option value="Macrohon">Macrohon</option>
        <option value="Padre Burgos">Padre Burgos</option>
        <option value="Malitbog">Malitbog</option>
        <option value="Bontoc">Bontoc</option>
        <option value="Tomas Oppus">Tomas Oppus</option>
        <option value="Sogod">Sogod</option>
        <option value="Libagon">Libagon</option>
        <option value="St. Bernard">St. Bernard</option>
        <option value="San Juan">San Juan</option>
        <option value="Anahawan">Anahawan</option>
        <option value="Hinundayan">Hinundayan</option>
        <option value="Hinunangan">Hinunangan</option>
        <option value="Silago">Silago</option>
        <option value="Liloan">Liloan</option>
         <option value="Pintuyan">Pintuyan</option>
        <option value="San Ricardo">San Ricardo</option>
        <option value="San Francisco">San Francisco</option>
        <option value="Pintuyan">Pintuyan</option>
        <option value="Limasawa">Limasawa</option>
    </select>
</div>

    

        <div class="mb-3">
          <label class="form-label">Grantor</label>
      <input type="text" name="grantor" class="form-control" value="<?php echo $row['username']; ?>">

        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save User</button>
      </div>

    </form>
  </div>
</div>
<!-- END MODAL -->
<script>
function confirmDelete(userId, fullname) {
    fullname = fullname.replace(/'/g, "\\'"); // Escape single quotes
    return confirm(`Do you really want to delete user ID ${userId} of ${fullname}?`);
}
</script>

</body>
</html>

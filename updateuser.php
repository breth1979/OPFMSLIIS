<?php
include 'functions.php'; // Include the functions file

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

$conn = connectToDatabase(); // Call the function to connect to the database
// Call the function to fetch data
// Get search term from query parameter
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // secure the input
    
    $sql = "SELECT * FROM users WHERE id = $id ORDER By id desc"; // use your actual table name
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
           } else {
        die("No record found with ID = $id");
    }
} else {
    die("No ID provided in URL.");
}






 
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
        <h4>UPDATE USER</h4>
      </div>
         <!-- Filter Form -->
   
          <div class="card-body">
        <div class="d-flex justify-content-center mb-1 gap-2">
    <a href="main.php" class="btn btn-primary px-4">
        ← Home
    </a>

 
</div>
 <form id="dataForm" action="saveupdate.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

    <div class="row mb-3">
        <div class="col-md-2">
            <label for="fullname" class="form-label">FULLNAME</label>
            <input type="text" class="form-control" name="fullname" value="<?php echo $row['fullname']; ?>" required>
        </div>

        <div class="col-md-2">
            <label for="email" class="form-label">EMAIL ADDRESS</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
        </div>

        <div class="col-md-2">
            <label for="town" class="form-label">STATION</label>
            <select class="form-select" name="citymunicipality" required>
                <option value="">-- Select STATION --</option>
                <?php
                $stations = ["Maasin City", "Macrohon", "P Burgos", "Limasawa", "Malitbog", "T Oppus",
                             "Bontoc", "Sogod", "Libagon", "Liloan", "San Francisco", "San Ricardo",
                             "St Bernard", "San Juan", "Anahawan", "Hinundayan", "Hinunangan", "Silago"];
                foreach ($stations as $station) {
                    $selected = ($row['citymunicipality'] == $station) ? "selected" : "";
                    echo "<option value='$station' $selected>$station</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-1">
            <label for="level" class="form-label">USER LEVEL</label>
            <select class="form-select" name="Level" required>
                <option value="">-- Select Access --</option>
                <?php
                $levels = ["ADMINISTRATOR", "ENCODER", "VIEWER"];
                foreach ($levels as $level) {
                    $selected = ($row['Level'] == $level) ? "selected" : "";
                    echo "<option value='$level' $selected>$level</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-1">
            <label for="username" class="form-label">USERNAME</label>
            <input type="text" class="form-control" name="username" value="<?php echo $row['username']; ?>" required>
        </div>

        <div class="col-md-1">
            <label for="password" class="form-label">PASSWORD</label>
            <input type="text" class="form-control" name="userpassword" value="<?php echo $row['userpassword']; ?>" required>
        </div>

        <div class="col-md-1">
            <label for="grantor" class="form-label">GRANTOR</label>
            <input type="text" class="form-control" name="grantor" value="<?php echo $_SESSION['username']; ?>" readonly>
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-success px-5 bg-bfp">UPDATE</button>
        <a href="userview.php" class="btn btn-secondary px-5 bg-bfp">CLOSE</a>
    </div>
</form>
  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    
    
  </script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>

</body>
</html>

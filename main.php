<?php
include 'functions.php'; // Include the functions file
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$userStation= $_SESSION['citymunicipality'];
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

  <style>
   
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
      transform: scale(1.3);
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
              <li><a class="dropdown-item" href="summaryfi.php">Summary of Fire Incident/s </a></li>
             
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
  

<!-- Modal Popup -->

   <div class="container mt-2" >
<h6>Welcome, <?php echo " " . $_SESSION['fullname'] . " ( " . $_SESSION['username'] . "/" .  $_SESSION['Level'] . "/" .  $_SESSION['citymunicipality'] .   ") "; ?>! You have successfully logged in.  <a href="logout.php">Logout</a></h6>
</div>

 <!-- CARD: DATATABLE -->
    <div class="card shadow-lg mb-6">
     
      <div class="card-body">
      <div class="container mt-5">
    <h3 class="mb-4">📊 Dashboard Overview - Province of Southern Leyte for CY   <?php echo date("Y");?></h3>
    <?php
                if ($result->num_rows > 0) {
                  $opfmslregcounter=0;
                  $opfmslregamount=0;
                  $opfmslmdficounter=0;
                  $opfmslmdfiamount=0;
                  $rescounter=0;
                  $resamount=0;
                
                  $nonrescounter=0;
                  $nonresamount =0;
                 
                  $nonstrcounter=0;
                  $nonstramount=0;
                 
                  $transportcounter=0;
                  $transportamount =0;

                  
               
                        while ($row = $result->fetch_assoc()) {
  
                         if (date("Y", strtotime($row["alarm_datetime"])) == date("Y")){
                            if ($row["typereport"]=="Regular"){ 
                               $opfmslregcounter+=1;
                           $opfmslregamount+=(float)$row["estimated_damage"];
                          }else {
                             $opfmslmdficounter+=1;
                           $opfmslmdfiamount+=(float)$row["estimated_damage"];
                        }
                          
                          
                        switch ($row["general_category"]) {
                       case "RESIDENTIAL":
                        if ($row["typereport"]=="Regular"){ 
                          $rescounter += 1;
                         $resamount +=(float)$row["estimated_damage"];

                        }
                                             
                        break;
                        case "NON-RESIDENTIAL":
                            if ($row["typereport"]=="Regular") {
                                $nonrescounter++;
                                $nonresamount += $row["estimated_damage"];
                            } 
                        break;
                         case "NON-STRUCTURAL":
                            if ($row["typereport"]=="Regular") {
                                $nonstrcounter++;
                                 $nonstramount+= $row["estimated_damage"];
                               
                            } 
                        break;

                        case "TRANSPORT":
                            if ($row["typereport"]=="Regular") {
                                $transportcounter++;
                                $transportamount += $row["estimated_damage"];
                            } 
                        break;
                     
                     default:
                        
                      }
                    }                      
                    }
                  }
                 ?>



    <div class="row g-4">
      <div class="col-md-3">
        <div class="dashboard-box bg-danger text-center">
          <i class="bi bi-people fs-1"></i>
         <h4 class="mt-2"><?php echo $opfmslregcounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($opfmslregamount, 2); ?></h4>
           <p>Total (OPFMSL))</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-secondary text-center">
          <i class="bi bi-people fs-1"></i>
           <h4 class="mt-2"><?php echo $opfmslmdficounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($opfmslmdfiamount, 2); ?></h4>
               <p>Total MDFI (OPFMSL)</p>
        </div>
      </div>
   <div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-people fs-1"></i>
         <h4 class="mt-2"><?php echo $rescounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($resamount, 2); ?></h4>
          <p>RESIDENTIAL</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-dark text-center">
          <i class="bi bi-people fs-1"></i>
         <h4 class="mt-2"><?php echo $nonrescounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($nonresamount, 2); ?></h4>
          <p>NON-RESIDENTIAL</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-success text-center">
          <i class="bi bi-check-circle fs-1"></i>
         <h4 class="mt-2"><?php echo $nonstrcounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($nonstramount, 2); ?></h4>
          <p>NON-STRUCTURAL</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="dashboard-box bg-warning text-center text-dark">
          <i class="bi bi-exclamation-triangle fs-1"></i>
     <h4 class="mt-2"><?php echo $transportcounter; ?></h4>
           <h4 class="mt-2"><?php echo "₱ ". number_format($transportamount, 2); ?></h4>
          <p>TRANSPORT</p>
        </div>
      </div>

      
   </div>
    </div>
   </div>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>

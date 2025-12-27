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
    h4{
      
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
  
   <div class="container mt-2" >

<h6>Welcome, <?php echo " " . $_SESSION['fullname'] . " ( " . $_SESSION['username'] . "/" .  $_SESSION['Level'] . "/" .  $_SESSION['citymunicipality'] .   ") "; ?>! You have successfully logged in.  <a href="logout.php">Logout</a></h6>
  
</div>
</div> </h6>
     

 <!-- CARD: DATATABLE -->
    <div class="card shadow-lg mb-6">
       <div class="card-body">
      <div class="container mt-5">
    <h3 class="mb-4">📊 Fire Incident/s- Per Fire Station(Regular/MDFI) for CY   <?php echo date("Y");?></h3>

              <?php
                if ($result->num_rows > 0) {
                  $opfmslregcounter=0;
                  $opfmslregamount=0;
                  $opfmslmdficounter=0;
                  $opfmslmdfiamount=0;

                  $mcfsregcounter=0;
                  $mcfsregamount=0;
                  $mcfsmdficounter=0;
                  $mcfsmdfiamount=0;
                  $macroregcounter = $macroregamount = 0;
                  $macromdficounter = $macromdfiamount = 0;

                  $pburgregcounter = $pburgregamount = 0;
                  $pburgmdficounter = $pburgmdfiamount = 0;

                  $limaregcounter = $limaregamount = 0;
                  $limamdficounter = $limamdfiamount = 0;

                  $malitregcounter = $malitregamount = 0;
                  $malitmdficounter = $malitmdfiamount = 0;

                  $toppusregcounter = $toppusregamount = 0;
                  $toppusmdficounter = $toppusmdfiamount = 0;

                  $bontregcounter = $bontregamount = 0;
                  $bontmdficounter = $bontmdfiamount = 0;

                  $sogregcounter = $sogregamount = 0;
                  $sogmdficounter = $sogmdfiamount = 0;

                  $libregcounter = $libregamount = 0;
                  $libmdficounter = $libmdfiamount = 0;

                  $srregcounter = $srregamount = 0;
                  $srmdficounter = $srmdfiamount = 0;

                  $stbregcounter = $stbregamount = 0;
                  $stbmdficounter = $stbmdfiamount = 0;

                  $hinunregcounter = $hinunregamount = 0;
                  $hinunmdficounter = $hinunmdfiamount = 0;

                  $hinundayregcounter = $hinundayregamount = 0;
                  $hinundaymdficounter = $hinundaymdfiamount = 0;

                  $anahregcounter = $anahregamount = 0;
                  $anahmdficounter = $anahmdfiamount = 0;

                  $sjuanregcounter = $sjuanregamount = 0;
                  $sjuanmdficounter = $sjuanmdfiamount = 0;

                  $silregcounter = $silregamount = 0;
                  $silmdficounter = $silmdfiamount = 0;
                  
                  $pintregcounter=0; $pintmdficounter=0;
                  $pintregamount =0; $pintmdfiamount=0;

                  $bontregcounter = 0;
                  $bontregamount = 0;
                  $bontmdficounter = 0;
                  $bontmdfiamount = 0;

                    $liloregcounter = 0;
$liloregamount = 0;
$lilomdficounter = 0;
$lilomdfiamount = 0;
$sanfregcounter = 0;
$sanfregamount = 0;
$sanfdficounter = 0;
$sanfdflamount = 0; // or $sanfdficounter amount variable


               
                        while ($row = $result->fetch_assoc()) {
                            if (date("Y", strtotime($row["alarm_datetime"])) == date("Y")){
                            if ($row["typereport"]=="Regular"){ 
                               $opfmslregcounter+=1;
                           $opfmslregamount+=(float)$row["estimated_damage"];
                          }else {
                             $opfmslmdficounter+=1;
                           $opfmslmdfiamount+=(float)$row["estimated_damage"];
                        }
                          
                          
                        switch ($row["citymunicipality"]) {
                       case "Maasin City":
                        if ($row["typereport"]=="Regular"){ 
                          $mcfsregcounter += 1;
                         $mcfsregamount +=(float)$row["estimated_damage"];

                        }else {
                             $mcfsmdficounter+=1;
                         $mcfsmdfiamount+=(float)$row["estimated_damage"];

                        }
                                             
                        break;
                        case "Liloan":
                            if ($row["typereport"]=="Regular") {
                                $liloregcounter++;
                                $liloregamount += $row["estimated_damage"];
                            } else {
                                $lilomdficounter++;
                                $lilomdfiamount += $row["estimated_damage"];
                            }
                        break;
                         case "Macrohon":
                            if ($row["typereport"]=="Regular") {
                                $macroregcounter++;
                                $macroregamount += $row["estimated_damage"];
                            } else {
                                $macromdficounter++;
                                $macromdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "P Burgos":
                            if ($row["typereport"]=="Regular") {
                                $pburgregcounter++;
                                $pburgregamount += $row["estimated_damage"];
                            } else {
                                $pburgmdficounter++;
                                $pburgmdfiamount += $row["estimated_damage"];
                            }
                        break;
                        case "San Francisco":
            if ($row["typereport"] == "Regular") {
                $sanfregcounter += 1;
                $sanfregamount += (float)$row["estimated_damage"];
            } else {
                $sanfdficounter += 1;
                $sanfdflamount += (float)$row["estimated_damage"];
            }
            break;

                        case "Limasawa":
                            if ($row["typereport"]=="Regular") {
                                $limaregcounter++;
                                $limaregamount += $row["estimated_damage"];
                            } else {
                                $limamdficounter++;
                                $limamdfiamount += $row["estimated_damage"];
                            }
                        break;
                        case "Pintuyan":
                            if ($row["typereport"] == "Regular") { 
                                $pintregcounter += 1;
                                $pintregamount += (float)$row["estimated_damage"];
                            } else {
                                $pintmdficounter += 1;
                                $pintmdfiamount += (float)$row["estimated_damage"];
                            }
                            break;

                        case "Malitbog":
                            if ($row["typereport"]=="Regular") {
                                $malitregcounter++;
                                $malitregamount += $row["estimated_damage"];
                            } else {
                                $malitmdficounter++;
                                $malitmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "T Oppus":
                            if ($row["typereport"]=="Regular") {
                                $toppusregcounter++;
                                $toppusregamount += $row["estimated_damage"];
                            } else {
                                $toppusmdficounter++;
                                $toppusmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Bontoc":
                            if ($row["typereport"]=="Regular") {
                                $bontregcounter++;
                                $bontregamount += $row["estimated_damage"];
                            } else {
                                $bontmdficounter++;
                                $bontmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Sogod":
                            if ($row["typereport"]=="Regular") {
                                $sogregcounter++;
                                $sogregamount += $row["estimated_damage"];
                            } else {
                                $sogmdficounter++;
                                $sogmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Libagon":
                            if ($row["typereport"]=="Regular") {
                                $libregcounter++;
                                $libregamount += $row["estimated_damage"];
                            } else {
                                $libmdficounter++;
                                $libmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "San Ricardo":
                            if ($row["typereport"]=="Regular") {
                                $srregcounter++;
                                $srregamount += $row["estimated_damage"];
                            } else {
                                $srmdficounter++;
                                $srmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "St Bernard":
                            if ($row["typereport"]=="Regular") {
                                $stbregcounter++;
                                $stbregamount += $row["estimated_damage"];
                            } else {
                                $stbmdficounter++;
                                $stbmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Hinunangan":
                            if ($row["typereport"]=="Regular") {
                                $hinunregcounter++;
                                $hinunregamount += $row["estimated_damage"];
                            } else {
                                $hinunmdficounter++;
                                $hinunmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Hinundayan":
                            if ($row["typereport"]=="Regular") {
                                $hinundayregcounter++;
                                $hinundayregamount += $row["estimated_damage"];
                            } else {
                                $hinundaymdficounter++;
                                $hinundaymdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Anahawan":
                            if ($row["typereport"]=="Regular") {
                                $anahregcounter++;
                                $anahregamount += $row["estimated_damage"];
                            } else {
                                $anahmdficounter++;
                                $anahmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "San Juan":
                            if ($row["typereport"]=="Regular") {
                                $sjuanregcounter++;
                                $sjuanregamount += $row["estimated_damage"];
                            } else {
                                $sjuanmdficounter++;
                                $sjuanmdfiamount += $row["estimated_damage"];
                            }
                        break;

                        case "Silago":
                            if ($row["typereport"]=="Regular") {
                                $silregcounter++;
                                $silregamount += $row["estimated_damage"];
                            } else {
                                $silmdficounter++;
                                $silmdfiamount += $row["estimated_damage"];
                            }
                        break;
                     default:
                        
                      }
                    }                  
                    }
                  }
                 ?>
                <!-- After the loop, show the total -->
    <div class="row g-4">
      <div class="col-md-3">
        <div class="dashboard-box bg-danger text-center">
          <i class="bi bi-people fs-1"></i>
         <h4 class="mt-2"><?php echo $opfmslregcounter . "/ ₱ " . number_format($opfmslregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $opfmslmdficounter . " / ₱ " . number_format($opfmslmdfiamount, 2); ?></h4>

          <p>Total (OPFMSL)</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-people fs-1"></i>
          <h4 class="mt-2"><?php echo  $mcfsregcounter . "/₱ " . number_format($mcfsregamount, 2); ?></h4>
           <h4 class="mt-2"><?php echo  $mcfsmdficounter . "/₱ " . number_format($mcfsmdfiamount, 2); ?></h4>
          <p>Maasin CFS</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-secondary text-center">
          <i class="bi bi-people fs-1"></i>
          <h4 class="mt-2"><?php echo $macroregcounter . "/ ₱ " . number_format($macroregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $macromdficounter . "/ ₱ " . number_format($macromdfiamount, 2); ?></h4>

          <p>Macrohon FS</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-success text-center">
          <i class="bi bi-check-circle fs-1"></i>
      <h4 class="mt-2"><?php echo $pburgregcounter . "/ ₱ " . number_format($pburgregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $pburgmdficounter . "/ ₱ " . number_format($pburgmdfiamount, 2); ?></h4>

          <p>Padre Burgos FS</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="dashboard-box bg-warning text-center text-center">
          <i class="bi bi-exclamation-triangle fs-1"></i>
     <h4 class="mt-2"><?php echo $limaregcounter . "/ ₱ " . number_format($limaregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $limamdficounter . "/ ₱ " . number_format($limamdfiamount, 2); ?></h4>
          <p>Limasawa FS</p>
        </div>
      </div>

      <div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-x-circle fs-1"></i>
        <h4 class="mt-2"><?php echo $malitregcounter . "/ ₱ " . number_format($malitregamount, 2); ?></h4>
        <h4 class="mt-2"><?php echo $malitmdficounter . "/ ₱ " . number_format($malitmdfiamount, 2); ?></h4>

          <p>Malitbog FS</p>
        </div>
      </div>
       
      <div class="col-md-3">
        <div class="dashboard-box bg-secondary text-center">
          <i class="bi bi-people fs-1"></i>
       <h4 class="mt-2"><?php echo $toppusregcounter . "/ ₱" . number_format($toppusregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $toppusmdficounter . "/ ₱ " . number_format($toppusmdfiamount, 2); ?></h4>

          <p>Tomas Oppus FS</p>
        </div>
      </div>
       <div class="col-md-3">
        <div class="dashboard-box bg-success text-center">
          <i class="bi bi-people fs-1"></i>
          <h4 class="mt-2"><?php echo $bontregcounter . "/ ₱ " . number_format($bontregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $bontmdficounter . "/ ₱ " . number_format($bontmdfiamount, 2); ?></h4>

          <p>Bontoc FS</p>
        </div>
      </div>

    </div>
    <div class="container mt-3"></div>
     <div class="row g-4">
      
      
      <div class="col-md-3">
        <div class="dashboard-box bg-warning text-center">
          <i class="bi bi-people fs-1"></i>
       <h4 class="mt-2"><?php echo $sogregcounter . "/ ₱ " . number_format($sogregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $sogmdficounter . "/ ₱ " . number_format($sogmdfiamount, 2); ?></h4>

          <p>Sogod FS</p>
        </div>
      </div>
<div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-people fs-1"></i>
        <h4 class="mt-2"><?php echo $libregcounter . "/ ₱ " . number_format($libregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $libmdficounter . "/ ₱ " . number_format($libmdfiamount, 2); ?></h4>

          <p>Libagon FS</p>
        </div>
      </div>
      

      <div class="col-md-3">
        <div class="dashboard-box bg-secondary text-center text-center">
          <i class="bi bi-exclamation-triangle fs-1"></i>
         <h4 class="mt-2"><?php echo $stbregcounter . "/ ₱ " . number_format($stbregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $stbmdficounter . "/ ₱ " . number_format($stbmdfiamount, 2); ?></h4>

          <p>St Bernard FS</p>
        </div>
      </div>
<div class="col-md-3">
        <div class="dashboard-box bg-success text-center">
          <i class="bi bi-people fs-1"></i>
         <h4 class="mt-2"><?php echo $anahregcounter . "/ ₱ " . number_format($anahregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $anahmdficounter . "/ ₱ " . number_format($anahmdfiamount, 2); ?></h4>
          <p>Anahawan FS</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-warning text-center">
          <i class="bi bi-check-circle fs-1"></i>
        <h4 class="mt-2"><?php echo $sjuanregcounter . "/ ₱ " . number_format($sjuanregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $sjuanmdficounter . "/ ₱ " . number_format($sjuanmdfiamount, 2); ?></h4>
          <p>San Juan FS</p>
        </div>
      </div>
       <div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-people fs-1"></i>
        <h4 class="mt-2"><?php echo $hinundayregcounter . "/ ₱ " . number_format($hinundayregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $hinundaymdficounter . "/ ₱ " . number_format($hinundaymdfiamount, 2); ?></h4>
          <p>Hinundayan FS</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="dashboard-box bg-secondary text-center">
          <i class="bi bi-x-circle fs-1"></i>
      <h4 class="mt-2"><?php echo $hinunregcounter . "/ ₱ " . number_format($hinunregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $hinunmdficounter . " / ₱ " . number_format($hinunmdfiamount, 2); ?></h4>
          <p>Hinunangan FS</p>
        </div>
      </div>
     
           <div class="col-md-3">
        <div class="dashboard-box bg-success text-center text-center">
          <i class="bi bi-exclamation-triangle fs-1"></i>
        <h4 class="mt-2"><?php echo $silregcounter . "/ ₱ " . number_format($silregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $silmdficounter . "/ ₱ " . number_format($silmdfiamount, 2); ?></h4>

          <p>Silago FS</p>
        </div>
      </div>
 <div class="col-md-3">
        <div class="dashboard-box bg-warning text-center">
          <i class="bi bi-people fs-1"></i>
      <h4 class="mt-2"><?php echo $liloregcounter . "/ ₱ " . number_format($liloregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $lilomdficounter . "/ ₱ " . number_format($lilomdfiamount, 2); ?></h4>


          <p>Liloan FS</p>
        </div>
      </div>
        <div class="col-md-3">
        <div class="dashboard-box bg-primary text-center">
          <i class="bi bi-x-circle fs-1"></i>
      <h4 class="mt-2"><?php echo $sanfregcounter . " / ₱ " . number_format($sanfregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $sanfdficounter . "/ ₱ " . number_format($sanfdflamount, 2); ?></h4>

          <p>San Francisco FS</p>
        </div>
      </div>
       <div class="col-md-3">
        <div class="dashboard-box  bg-secondary text-center">
          <i class="bi bi-x-circle fs-1"></i>
      <h4 class="mt-2"><?php echo $pintregcounter . "/ ₱ " . number_format($pintregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $pintmdficounter . "/ ₱ " . number_format($pintmdfiamount, 2); ?></h4>

          <p>Pintuyan FS</p>
        </div>
      </div>
     <div class="col-md-3">
        <div class="dashboard-box bg-success text-center">
          <i class="bi bi-check-circle fs-1"></i>
       <h4 class="mt-2"><?php echo $srregcounter . "/ ₱ " . number_format($srregamount, 2); ?></h4>
<h4 class="mt-2"><?php echo $srmdficounter . "/ ₱ " . number_format($srmdfiamount, 2); ?></h4>

          <p>San Ricardo FS</p>
        </div>
      </div>
    </div>
   
 <div class="container mt-3"></div>
     <div class="row g-4">
        

      
       
      
      </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

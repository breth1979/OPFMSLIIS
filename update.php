<?php
include 'functions.php'; // Include the functions file

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['citymunicipality'])) {

    $id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    $cityMunicipality = htmlspecialchars($_GET['citymunicipality'], ENT_QUOTES, 'UTF-8');

    echo "ID: " . $id . "<br>";
    echo "City/Municipality: " . $cityMunicipality . "<br>";
// filter if station is OPFM can access all, otherwise can access only if the user assigned to the station
  $userCity = $_SESSION['citymunicipality'] ?? '';
    $userUnit = $_SESSION['citymunicipality'] ?? '';

    // FILTER:
    // If OPFMSL → allow all
    // Otherwise → citymunicipality must match user's assigned station
    if ($userUnit === 'OPFMSL' || $cityMunicipality === $userCity) {
        echo "✅ Access Granted.";
    } else {
        echo "<script>
                alert('⛔ Access Denied: You are not assigned to this station.');
              window.history.go(-1);
              </script>";
        exit();
    }

}
else {
    die("Required parameters not provided.");
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
    die("No ID provided in URL.");}

$result = fetchRow($conn, $id); // Call the function to fetch data
if ($_SESSION['Level'] !== 'Administrator' && $_SESSION['Level'] !== 'Encoder') {
    echo "<script>
        alert('⛔ Access Level: " . $_SESSION['Level'] . "\\n⛔ Access denied. For Viewing Only!');
        window.location.href = 'readonlyview.php?id=" . $row['id'] . "';
    </script>";
    exit();
}

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
        <h4>View/Edit/Update Records</h4>
      </div>
     
        <div class="card-body">
        <form id="update" action="savechanges.php" method="POST">
          <div class="row mb-3">
            <div class="col-md-1">
                            <label for="region" class="form-label">Region</label>
              <input type="text" class="form-control" name="region" value="<?php echo $row['region']; ?>" readonly>
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            </div>
            <div class="col-md-2">
              <label for="province" class="form-label">Province</label>
              <input type="province" class="form-control" name="province" value="<?php echo $row['province']; ?>" readonly>
            </div>
            <div class="col-md-2">
              <label for="citymunicipality" class="form-label">citymunicipality</label>
              <label for="town" class="form-label">City/Municipality</label>
<select class="form-select" name="citymunicipality" required>
  

  <option value="Maasin City" <?php if($row['citymunicipality'] == 'Maasin City') echo 'selected'; ?>>Maasin City</option>
  <option value="Macrohon" <?php if($row['citymunicipality'] == 'Macrohon') echo 'selected'; ?>>Macrohon</option>
  <option value="P Burgos" <?php if($row['citymunicipality'] == 'P Burgos') echo 'selected'; ?>>P Burgos</option>
  <option value="Limasawa" <?php if($row['citymunicipality'] == 'Limasawa') echo 'selected'; ?>>Limasawa</option>
  <option value="Malitbog" <?php if($row['citymunicipality'] == 'Malitbog') echo 'selected'; ?>>Malitbog</option>
  <option value="T Oppus" <?php if($row['citymunicipality'] == 'T Oppus') echo 'selected'; ?>>T Oppus</option>
  <option value="Bontoc" <?php if($row['citymunicipality'] == 'Bontoc') echo 'selected'; ?>>Bontoc</option>
  <option value="Sogod" <?php if($row['citymunicipality'] == 'Sogod') echo 'selected'; ?>>Sogod</option>
  <option value="Libagon" <?php if($row['citymunicipality'] == 'Libagon') echo 'selected'; ?>>Libagon</option>
  <option value="Liloan" <?php if($row['citymunicipality'] == 'Liloan') echo 'selected'; ?>>Liloan</option>
  <option value="San Francisco" <?php if($row['citymunicipality'] == 'San Francisco') echo 'selected'; ?>>San Francisco</option>
  <option value="Pintuyan" <?php if($row['citymunicipality'] == 'Pintuyan') echo 'selected'; ?>>Pintuyan</option>
  <option value="San Ricardo" <?php if($row['citymunicipality'] == 'San Ricardo') echo 'selected'; ?>>San Ricardo</option>
  <option value="St Bernard" <?php if($row['citymunicipality'] == 'St Bernard') echo 'selected'; ?>>St Bernard</option>
  <option value="San Juan" <?php if($row['citymunicipality'] == 'San Juan') echo 'selected'; ?>>San Juan</option>
 
  <option value="Anahawan" <?php if($row['citymunicipality'] == 'Anahawan') echo 'selected'; ?>>Anahawan</option>
  <option value="Hinundayan" <?php if($row['citymunicipality'] == 'Hinundayan') echo 'selected'; ?>>Hinundayan</option>
  <option value="Hinunangan" <?php if($row['citymunicipality'] == 'Hinunangan') echo 'selected'; ?>>Hinunangan</option>
  <option value="Silago" <?php if($row['citymunicipality'] == 'Silago') echo 'selected'; ?>>Silago</option>
</select>

            </div>
             
            <div class="col-md-4">
              <label for="location" class="form-label">Exact Location</label>
              <input type="location" class="form-control" name="location" value="<?php echo $row['location']; ?>"required>
            </div>
            <div class="col-md-3">
              <label for="DTReport" class="form-label">Date and Time of Reported</label>
              <input type="datetime-local" class="form-control" name="alarm_datetime" value="<?php echo $row['alarm_datetime']; ?>" required>
            </div>
            
          </div>

          <div class="row mb-3">
            <div class="col-md-3">
              <label for="DTStarted" class="form-label">Date and Time of Fire Started</label>
              <input type="datetime-local" class="form-control" name="datetime_started" value="<?php echo $row['datetime_started']; ?>" required>
            </div>
            <div class="col-md-3">
              <label for="DTFout" class="form-label">Date and Time of Fire Out</label>
              <input type="datetime-local" class="form-control" name="datetime_out" value="<?php echo $row['datetime_out']; ?>" required>
            </div>
            <div class="col-md-2">
            <label for="category" class="form-label">Category</label>
<select class="form-select" name="general_category" required>
 
  <option value="RESIDENTIAL" <?php if($row['general_category'] == 'RESIDENTIAL') echo 'selected'; ?>>RESIDENTIAL</option>
  <option value="NON-RESIDENTIAL" <?php if($row['general_category'] == 'NON-RESIDENTIAL') echo 'selected'; ?>>NON-RESIDENTIAL</option>
  <option value="NON-STRUCTURAL" <?php if($row['general_category'] == 'NON-STRUCTURAL') echo 'selected'; ?>>NON-STRUCTURAL</option>
  <option value="TRANSPORT" <?php if($row['general_category'] == 'TRANSPORT') echo 'selected'; ?>>TRANSPORT</option>
</select>

            </div>
            <div class="col-md-4">
            <label for="category" class="form-label">Sub-Category</label>
<select class="form-select" name="sub_category" required>
 <option value="SINGLE AND TWO FAMILY DWELLING" 
    <?php if($row['sub_category'] == 'SINGLE AND TWO FAMILY DWELLING') echo 'selected'; ?>>
    SINGLE AND TWO FAMILY DWELLING
  </option>

  <option value="HOTEL" 
    <?php if($row['sub_category'] == 'HOTEL') echo 'selected'; ?>>
    HOTEL
  </option>

  <option value="DORMITORY" 
    <?php if($row['sub_category'] == 'DORMITORY') echo 'selected'; ?>>
    DORMITORY
  </option>

  <option value="CONDOMINIUMS" 
    <?php if($row['sub_category'] == 'CONDOMINIUMS') echo 'selected'; ?>>
    CONDOMINIUMS
  </option>

  <option value="LODGING AND ROOMING HOUSES" 
    <?php if($row['sub_category'] == 'LODGING AND ROOMING HOUSES') echo 'selected'; ?>>
    LODGING AND ROOMING HOUSES
  </option>
   <option value="APARTMENT BUILDING" 
    <?php if($row['sub_category'] == 'APARTMENT BUILDING') echo 'selected'; ?>>
    APARTMENT BUILDING
  </option>
   <option value="ASSEMBLY" 
    <?php if($row['sub_category'] == ' ASSEMBLY') echo 'selected'; ?>>
    ASSEMBLY
  </option>
   <option value="BUSINESS" 
    <?php if($row['sub_category'] == 'BUSINESS') echo 'selected'; ?>>
    BUSINESS
  </option>
    <option value="DETENTION AND CORRECTIONAL" 
    <?php if($row['sub_category'] == 'DETENTION AND CORRECTIONAL') echo 'selected'; ?>>
    DETENTION AND CORRECTIONAL
  </option>
    <option value="EDUCATIONAL" 
    <?php if($row['sub_category'] == 'EDUCATIONAL') echo 'selected'; ?>>
    EDUCATIONAL
  </option>
    <option value="HEALTH CARE" 
    <?php if($row['sub_category'] == 'HEALTH CARE') echo 'selected'; ?>>
    HEALTH CARE
  </option>
    <option value="INDUSTRIAL" 
    <?php if($row['sub_category'] == 'INDUSTRIAL') echo 'selected'; ?>>
    INDUSTRIAL
  </option>
    <option value="MERCANTILE" 
    <?php if($row['sub_category'] == 'MERCANTILE') echo 'selected'; ?>>
    MERCANTILE
  </option>
    <option value="MISCELLANEOUS" 
    <?php if($row['sub_category'] == 'MISCELLANEOUS') echo 'selected'; ?>>
    MISCELLANEOUS
  </option>
    <option value="MIXED OCCUPANCIES" 
    <?php if($row['sub_category'] == 'MIXED OCCUPANCIES') echo 'selected'; ?>>
    MIXED OCCUPANCIES
  </option>
    <option value="STORAGE" 
    <?php if($row['sub_category'] == 'STORAGE') echo 'selected'; ?>>
    STORAGE
  </option>
     <option value="AGRICULTURAL LAND" 
    <?php if($row['sub_category'] == 'AGRICULTURAL LAND') echo 'selected'; ?>>
    AGRICULTURAL LAND
  </option>
     <option value="AMBULANT VENDOR" 
    <?php if($row['sub_category'] == 'AMBULANT VENDOR') echo 'selected'; ?>>
    AMBULANT VENDOR
  </option>
     <option value="ELECTRICAL POLE" 
    <?php if($row['sub_category'] == 'ELECTRICAL POLE') echo 'selected'; ?>>
    ELECTRICAL POLE
  </option>
     <option value="FOREST" 
    <?php if($row['sub_category'] == 'FOREST') echo 'selected'; ?>>
    FOREST
  </option>
     <option value="GRASS" 
    <?php if($row['sub_category'] == 'GRASS') echo 'selected'; ?>>
    GRASS
  </option>
     <option value="RUBBISH" 
    <?php if($row['sub_category'] == 'RUBBISH') echo 'selected'; ?>>
    RUBBISH
  </option>
    <option value="AIRCRAFT" 
    <?php if($row['sub_category'] == 'AIRCRAFT') echo 'selected'; ?>>
    AIRCRAFT
  </option>
    <option value="AUTOMOBILE" 
    <?php if($row['sub_category'] == 'AUTOMOBILE') echo 'selected'; ?>>
    AUTOMOBILE
  </option>
    <option value="BUS" 
    <?php if($row['sub_category'] == 'BUS') echo 'selected'; ?>>
    BUS
  </option>
    <option value="HEAVY EQUIPMENT" 
    <?php if($row['sub_category'] == 'HEAVY EQUIPMENT') echo 'selected'; ?>>
    HEAVY EQUIPMENT
  </option>
    <option value="JEEPNEY" 
    <?php if($row['sub_category'] == 'JEEPNEY') echo 'selected'; ?>>
    JEEPNEY
  </option>
   <option value="LOCOMOTIVE" 
    <?php if($row['sub_category'] == 'LOCOMOTIVE') echo 'selected'; ?>>
    LOCOMOTIVE
  </option>
   <option value="MOTORCYCLE" 
    <?php if($row['sub_category'] == 'MOTORCYCLE') echo 'selected'; ?>>
    MOTORCYCLE
  </option>
   <option value="SHIP / WATER VESSEL" 
    <?php if($row['sub_category'] == 'SHIP / WATER VESSEL') echo 'selected'; ?>>
    SHIP / WATER VESSEL
  </option>
   <option value="TRICYCLE" 
    <?php if($row['sub_category'] == 'TRICYCLE') echo 'selected'; ?>>
    TRICYCLE
  </option>

 <option value="TRUCK" 
    <?php if($row['sub_category'] == 'TRUCK') echo 'selected'; ?>>
    TRUCK
  </option>
    
</select>

            </div>
           </div>

          <div class="row mb-3">
             <div class="col-md-3">
              <label for="establishment" class="form-label">Establishment/s</label>
               <input class="form-control" name="establishment_name" rows="3"  value="<?php echo $row['establishment_name'] ?>" required></input>
            </div>
             <div class="col-md-3">
              <label for="owner" class="form-label">Owner/s</label>
               <input class="form-control" name="owner" rows="3" value="<?php echo $row['owner'] ?>" requried></input>
            </div>
             <div class="col-md-3">
              <label for="occupants" class="form-label">Occupant/s</label>
               <input class="form-control" name="occupant" rows="3" value="<?php echo $row['occupant'] ?>" required></input>
              </div>   
              <div class="col-md-2">
              <label for="storey" class="form-label">No. of Storey/s</label>
              <input type="text" class="form-control" name="no_of_storeys" value="<?php echo $row['no_of_storeys'] ?>" required>
              </div>
       
          </div>

          <div class="row mb-3">
            <div class="col-md-2">
              <label for="distance" class="form-label">Dist (Station to Scene)</label>
              <input type="text" class="form-control" name="dist" value="<?php echo $row['dist']; ?>"required>
            </div>
            <div class="col-md-2">
              <label for="DispatchTime" class="form-label">Dispatch Time</label>
              <input type="time" class="form-control" name="dispatch" value="<?php echo $row['dispatch']; ?>"required>
            </div>
            <div class="col-md-2">
              <label for="Arrivaltime" class="form-label">Arrival Time</label>
              <input type="time" class="form-control" name="arrival" value="<?php echo $row['arrival']; ?>" required>
            </div>
             <div class="col-md-2">
              <label for="injurybfpmale" class="form-label">BFP Injury (Male) </label>
              <input type="text" class="form-control" name="injuredbfpmale" value="<?php echo $row['injuredbfpmale']; ?>" required>
            </div>
             <div class="col-md-2">
              <label for="injurybfpfemale" class="form-label">BFP Injury (Female) </label>
              <input type="text" class="form-control" name="injuredbfpfemale" value="<?php echo $row['injuredbfpfemale']; ?>" required>
            </div>
            <div class="col-md-2">
              <label for="injurybfptotal" class="form-label">BFP Injury (Total) </label>
              <input type="text" class="form-control" name="injuredbfptotal" value="<?php echo $row['injuredbfptotal']; ?>" required>
            </div>
          </div>
          <div class="row mb-3">
             <div class="col-md-2">
              <label for="injurycivmale" class="form-label">Civilian Injury (Male) </label>
              <input type="text" class="form-control" name="injuredcivmale" value="<?php echo $row['injuredcivmale']; ?>" required>
            </div>
             <div class="col-md-2">
              <label for="injurycivfemale" class="form-label">Civilian Injury (Female) </label>
              <input type="text" class="form-control" name="injuredcivfemale" value="<?php echo $row['injuredcivfemale']; ?>"  required>
            </div>
            <div class="col-md-2">
              <label for="injurycivtotal" class="form-label">Civilian Injury (Total) </label>
              <input type="text" class="form-control" name="injuredcivtotal"  value="<?php echo $row['injuredcivtotal']; ?>" required>
            </div>
             <div class="col-md-2">
              <label for="injured" class="form-label">BFP Fatalities (Male) </label>
              <input type="text" class="form-control" name="fatalbfpmale" value="<?php echo $row['fatalbfpmale']; ?>"  required>
            </div>
             <div class="col-md-2">
              <label for="fatal" class="form-label">BFP Fatalities (Female) </label>
              <input type="text" class="form-control" name="fatalbfpfemale" value="<?php echo $row['fatalbfpfemale']; ?>" required>
            </div>
            <div class="col-md-2">
              <label for="fatalitiesbfptotal" class="form-label">BFP Fatalities (Total) </label>
              <input type="text" class="form-control" name="fatalbfptotal" value="<?php echo $row['fatalbfptotal']; ?>"  required>
            </div>
          </div>
           <div class="row mb-3">
           
             <div class="col-md-2">
              <label for="Fatalitiescivmale" class="form-label">Civilian Fatalities (Male) </label>
              <input type="text" class="form-control" name="fatalcivmale" value="<?php echo $row['fatalcivmale']; ?>"  required>
            </div>
             <div class="col-md-2">
              <label for="Fatalitiescivfemale" class="form-label">Civilian Fatalities (Female) </label>
              <input type="text" class="form-control" name="fatalcivfemale" value="<?php echo $row['fatalcivfemale']; ?>"  required>
            </div>
            <div class="col-md-2">
              <label for="Fatalitiescivtotal" class="form-label">Civilian Fatalities (Total) </label>
              <input type="text" class="form-control" name="fatalcivtotal" value="<?php echo $row['fatalcivtotal']; ?>" required>
            </div>
              <div class="col-md-2">
              <label for="affectstructure" class="form-label">No. Affected Structures</label>
              <input type="text" class="form-control" name="affectedstructure" value="<?php echo $row['affectedstructure']; ?>" required>
            </div>
              <div class="col-md-2">
              <label for="damage" class="form-label">Amount Damages</label>
              <input type="text" class="form-control" name="estimated_damage"  value="<?php echo $row['estimated_damage']; ?>"required>
            </div>
            <div class="col-md-2">
  <label for="alarm" class="form-label">Alarm Level</label>
  <select class="form-select" name="alarm_level" required>
   <option value="1ST ALARM" <?php if($row['alarm_level'] == '1ST ALARM') echo 'selected'; ?>>1ST ALARM</option>
    <option value="2ND ALARM" <?php if($row['alarm_level'] == '2ND ALARM') echo 'selected'; ?>>2ND ALARM</option>
    <option value="3RD ALARM" <?php if($row['alarm_level'] == '3RD ALARM') echo 'selected'; ?>>3RD ALARM</option>
    <option value="4TH ALARM" <?php if($row['alarm_level'] == '4TH ALARM') echo 'selected'; ?>>4TH ALARM</option>
    <option value="5TH ALARM" <?php if($row['alarm_level'] == '5TH ALARM') echo 'selected'; ?>>5TH ALARM</option>
    <option value="TF ALPHA" <?php if($row['alarm_level'] == 'TF ALPHA') echo 'selected'; ?>>TF ALPHA</option>
    <option value="TF BRAVO" <?php if($row['alarm_level'] == 'TF BRAVO') echo 'selected'; ?>>TF BRAVO</option>
    <option value="TF CHARLIE" <?php if($row['alarm_level'] == 'TF CHARLIE') echo 'selected'; ?>>TF CHARLIE</option>
    <option value="TF DELTA" <?php if($row['alarm_level'] == 'TF DELTA') echo 'selected'; ?>>TF DELTA</option>
    <option value="TF ECHO" <?php if($row['alarm_level'] == 'TF ECHO') echo 'selected'; ?>>TF ECHO</option>
    <option value="GENERAL ALARM" <?php if($row['alarm_level'] == 'GENERAL ALARM') echo 'selected'; ?>>GENERAL ALARM</option>
    <option value="FIRE OUT UPON ARRIVAL" <?php if($row['alarm_level'] == 'FIRE OUT UPON ARRIVAL') echo 'selected'; ?>>FIRE OUT UPON ARRIVAL</option>
  </select>
</div>
            <div class="row mb-3">
           
             <div class="col-md-3">
              <label for="causeFire" class="form-label">Cause of Fire</label>
<select class="form-select" name="cause" required>
  <option value="">---Select Cause of Fire---</option>

  <?php
    $causes = [
      "UNDER INVESTIGATION",
      "OTHER CAUSES OF FIRE INCIDENT (Please indicate the cause in the Remarks)",
      "BATTERY SHORT CIRCUIT OR BATTERY EXPLOSION",
      "CHILDREN PLAYING MATCHSTICK OR LIGHTER",
      "DUST EXPLOSION",
      "ELECTRICAL IGNITION CAUSED BY ARCING",
      "ELECTRICAL IGNITION CAUSED BY LOOSED CONNECTION",
      "ELECTRICAL IGNITION CAUSED BY OVERLOADING",
      "ELECTRICAL IGNITION DUE TO PINCHED WIRE",
      "ELECTRICAL POST FIRE TO STRUCTURAL FIRE",
      "FIRE CAUSED BY LIGHTNING",
      "IGNITION CAUSED BY BOMB EXPLOSION",
      "IGNITION CAUSED BY FIRECRACKER EXPLOSION",
      "IGNITION CAUSED BY FIREWORKS / PYROTECHNICS EXPLOSION",
      "IGNITION OF MATERIALS CAUSED BY ACETYLENE / OTHER HOT WORKS",
      "IGNITION OF MATERIAL CAUSED BY WELDING SLAGS",
      "IGNITION OF MATERIALS FROM EMBER / FLYING EMBER OR ALIPATO",
      "INTENTIONAL FIRE BY USE OF INCENDIARY DEVICE OR MECHANISM",
      "INTENTIONAL FIRE BY USE OF OPEN FLAME (MATCHSTICK OR LIGHTER OR LIGHT TORCH)",
      "INTENTIONAL FIRE BY USE OF FLAMMABLE LIQUID",
      "LPG EXPLOSION CAUSED BY DEFECTIVE HOSE LINE",
      "LPG EXPLOSION CAUSED BY DEFECTIVE REGULATOR",
      "LPG EXPLOSION CAUSED BY DEFECTIVE STOVE",
      "LPG EXPLOSION CAUSED BY DEFECTIVE TANK",
      "LPG EXPLOSION CAUSED BY STATIC ELECTRICITY OR SPARK",
      "MAGNIFIED / AMPLIFIED SUN RAYS",
      "OPEN FLAME FROM COOKING (LPG / GAS STOVE, FIREWOOD)",
      "OPEN FLAME FROM FARMLAND / AGRICULTURAL LAND CLEARING OPERATION",
      "OPEN FLAME FROM KAINGIN (SLASH AND BURN)",
      "OPEN FLAME FROM KEROSENE LAMP (GASERA) / LIGHTING TORCH (SULO)",
      "OPEN FLAME FROM RUBBISH FIRE / BONFIRE TO STRUCTURAL FIRE",
      "OPEN FLAME FROM UNATTENDED LIGHTED CANDLE",
      "OVERHEATED ENGINE (MOTOR VEHICLES)",
      "OVERHEATED HOME APPLIANCES",
      "OVERHEATED INDUSTRIAL MACHINERY",
      "SMOKING(LIGHTED CIGARETTE, CIGAR OR PIPE)",
      "SPARKS FROM MACHINERY",
      "SPONTANEOUS COMBUSTION OF CHEMICALS",
      "SPONTANEOUS COMBUSTION OF SOLID MATERIALS",
      "TRANSFORMER POLE FIRE TO STRUCTURAL FIRE",
      "FIRE INCIDENT UNDER INVESTIGATION (ON PROCESS)",
      "UNDETERMINED FIRE CAUSE (ON PENDING INVESTIGATION)"
    ];

    foreach($causes as $cause){
      $selected = ($row['cause'] == $cause) ? 'selected' : '';
      echo "<option value=\"$cause\" $selected>$cause</option>";
    }
  ?>
</select>

            </div>
              <div class="col-md-3">
              <label for="classification" class="form-label">Classification</label>
<select class="form-select" name="classification" required>
  

  <option value="UNDER INVESTIGATION" 
    <?php if($row['classification'] == 'UNDER INVESTIGATION') echo 'selected'; ?>>
    UNDER INVESTIGATION
  </option>

  <option value="NATURAL" 
    <?php if($row['classification'] == 'NATURAL') echo 'selected'; ?>>
    NATURAL
  </option>

  <option value="ACCIDENTAL" 
    <?php if($row['classification'] == 'ACCIDENTAL') echo 'selected'; ?>>
    ACCIDENTAL
  </option>

  <option value="INCENDIARY" 
    <?php if($row['classification'] == 'INCENDIARY') echo 'selected'; ?>>
    INCENDIARY
  </option>

  <option value="UNDETERMINED" 
    <?php if($row['classification'] == 'UNDETERMINED') echo 'selected'; ?>>
    UNDETERMINED
  </option>
</select>

            </div>
             <div class="col-md-3">
              <label for="FAI" class="form-label">Fire Arson Investigator (FAI)</label>
              <input type="text" class="form-control" name="fai" value="<?php echo $row['fai']; ?>" required>
            </div>
             <div class="col-md-2">
              <label for="FSIC" class="form-label">FSIC</label>
              <input type="TEXT" class="form-control" name="fsic" value="<?php echo $row['fsic']; ?>" required>
            </div>


<div class="col-md-1">
<label for="FSIC" class="form-label">Report Type</label>
<select class="form-select" name="typereport" required>
   <option value="Regular" <?php if($row['typereport'] == 'Regular') echo 'selected'; ?>> Regular </option>

  <option value="MDFI" 
    <?php if($row['typereport'] == 'MDFI') echo 'selected'; ?>>MDFI</option>
</select>

           
            </div>
           
         
        <div class="row mb-3">
          <div class="col-md-2">
              <label for="spot_report" class="form-label">Date Submitted (SIR)</label>
              <input type="date" class="form-control" name="spot_report" value="<?php echo $row['spot_report']; ?>">
            </div>    
          
             <div class="col-md-2">
              <label for="progress_report" class="form-label">Date Submitted (PIR)</label>
              <input type="date" class="form-control" name="progress_report"
           value="<?php echo isset($row['progress_report']) && $row['progress_report'] !== null && $row['progress_report'] != '0000-00-00'
                     ? date('Y-m-d', strtotime($row['progress_report']))
                     : ''; ?>">
            </div>    
           
             <div class="col-md-2">
              <label for="final_report" class="form-label">Date Submitted (FIR)</label>
           <input type="date" class="form-control" name="final_report"
           value="<?php echo isset($row['final_report']) && $row['final_report'] !== null && $row['final_report'] != '0000-00-00'
                     ? date('Y-m-d', strtotime($row['final_report']))
                     : ''; ?>">
            </div>    
           
       
            <div class="col-md-2">
             <label for="Status" class="form-label">Status</label>
<select class="form-select" name="status" required>
 
  <option value="UNDER INVESTIGATION" 
    <?php if($row['status'] == 'UNDER INVESTIGATION') echo 'selected'; ?>>
    UNDER INVESTIGATION
  </option>

  <option value="Closed" 
    <?php if($row['status'] == 'Closed') echo 'selected'; ?>>
    Closed
  </option>

  <option value="Undetermined" 
    <?php if($row['status'] == 'Undetermined') echo 'selected'; ?>>
    Undetermined
  </option>
</select>


              </div>
              <div class="col-md-3">
              <label for="remarks" class="form-label">Remarks</label>
              <input type="text" class="form-control" name="remarks" value="<?php echo $row['remarks']; ?>" >
              
            </div>      
            </div>       
       <div class="text-center">
            <button type="submit" class="btn btn-success px-5 bg-bfp">Save Changes</button>
           <button type="button" class="btn btn-secondary px-5 bg-bfp" onclick="history.back()">Back</button>

          </div>
            
          
        </form>
        </div>
      </div>
    </div>

  </div>

<script>function exportToWord() {
    var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
                 "xmlns:w='urn:schemas-microsoft-com:office:word' " +
                 "xmlns='http://www.w3.org/TR/REC-html40'>" +
                 "<head><meta charset='utf-8'><title>Fire Report</title></head><body>";
    var footer = "</body></html>";
    var content = document.getElementById("reportContent").innerHTML;
    var blob = new Blob(['\ufeff', header + content + footer], {
        type: 'application/msword'
    });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');

    // Build filename dynamically
    var region = "<?php echo $row['region']; ?>";
    var city = "<?php echo $row['citymunicipality']; ?>";
    var category = "<?php echo $row['general_category']; ?>";
    var location = "<?php echo $row['location']; ?>";
    var alarm = "<?php echo date('m-d-Y', strtotime($row['alarm_datetime'])); ?>";

    var fai = "<?php echo $row['fai']; ?>";

    // Replace spaces and colons for safe filename
    var safeAlarm = alarm.replace(/[: ]/g, "_");
    var safeLocation = location.replace(/ /g, "_");
    var safeCity = city.replace(/ /g, "_");

    a.href = url;
    a.download = "FireIncident_" + safeAlarm + "_" + category + "_" + safeCity + "_" + safeLocation + "_" + fai +  ".doc";
    a.click();
}

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
</body>
</html>

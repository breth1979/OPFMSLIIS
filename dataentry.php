<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: main.php");
    exit();
}

if ($_SESSION['Level'] !== 'Administrator' && $_SESSION['Level'] !== 'Encoder') {
    echo "<script>
    alert('⛔ Access denied. Admin and Encoder only! ');
    window.location.href = 'main.php'; // or login.php
</script>";
exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IIS - BFP OPFMSL</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
               <li><a class="dropdown-item" href="overdue.php">Investigation Report/s Deadline </a></li>
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
          <!-- Dropdown Menu -->
          
         

          <li class="nav-item"><a class="nav-link" href="Contact.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mt-3"></div>
  
  <div >
     <div class="container mt-2" >
  
<h6>Welcome, <?php echo " " . $_SESSION['fullname'] . " ( " . $_SESSION['username'] . "/" .  $_SESSION['Level'] . "/" .  $_SESSION['citymunicipality'] .   ") "; ?>! You have successfully logged in.  <a href="logout.php">Logout</a></h6>
  
  
</div>
</div>
    <!-- CARD: DATA ENTRY FORM -->
    <div class="card shadow-lg " >
      <div class="card-header  bg-bfp text-white text-center" >
        <h4>Data Entry - Regular Fire Incident</h4>
      </div>
      <div class="card-body">
          <div class="d-flex justify-content-start mb-1 gap-2">
    <a href="main.php" class="btn btn-primary px-4">
        ← Home
    </a></div>
        <form id="dataForm" action="insertfi.php" method="POST">
          <div class="row mb-3">
            <div class="col-md-1">
              <label for="region" class="form-label">Region</label>
              <input type="text" class="form-control" name="region" value="8" required>
            </div>
            <div class="col-md-2">
              <label for="province" class="form-label">Province</label>
              <input type="province" class="form-control" name="province" value="Southern Leyte"required>
            </div>
             <div class="col-md-2">
              <label for="town" class="form-label">City/Municipality</label>
                           <select class="form-select" name="citymunicipality" required>
                <option value="">-- Select Town --</option>
                <option>Maasin City</option>
                <option>Macrohon</option>
                <option>P Burgos</option>
                <option>Limasawa</option>
                <option>Malitbog</option>
                <option>T Oppus</option>
                <option>Bontoc</option>
                <option>Sogod</option>
                <option>Libagon</option>
                <option>Liloan</option>
                <option>San Francisco</option>
                <option>Pintuyan</option>
                <option>San Ricardo</option>
                <option>St Bernard</option>
                <option>San Juan</option>
                <option>Anahawan</option>
                <option>Hinundayan</option>
                <option>Hinunangan</option>
                <option>Silago</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="location" class="form-label">Exact Location</label>
              <input type="location" class="form-control" name="location" required>
            </div>
            <div class="col-md-3">
              <label for="DTReport" class="form-label">Date and Time of Reported</label>
              <input type="datetime-local" class="form-control" name="alarm_datetime" required>
            </div>
            
          </div>

          <div class="row mb-3">
            <div class="col-md-3">
              <label for="DTStarted" class="form-label">Date and Time of Fire Started</label>
              <input type="datetime-local" class="form-control" name="datetime_started" required>
            </div>
            <div class="col-md-3">
              <label for="DTFout" class="form-label">Date and Time of Fire Out</label>
              <input type="datetime-local" class="form-control" name="datetime_out" required>
            </div>
           <div class="col-md-2">
  <label for="category" class="form-label">Category</label>
  <select class="form-select" name="general_category" id="category" required>
    <option value="">-- Select Category --</option>
    <option value="RESIDENTIAL">RESIDENTIAL</option>
    <option value="NON-RESIDENTIAL">NON-RESIDENTIAL</option>
    <option value="NON-STRUCTURAL">NON-STRUCTURAL</option>
    <option value="TRANSPORT">TRANSPORT</option>
  </select>
</div>

<div class="col-md-4">
  <label for="sub_category" class="form-label">Sub-Category</label>
  <select class="form-select" name="sub_category" id="sub_category" required>
    <option value="">-- Select Sub Category --</option>
  </select>
</div>

<script>
  const subCategory = document.getElementById("sub_category");
  const category = document.getElementById("category");

  const options = {
    RESIDENTIAL: [
      "SINGLE AND TWO FAMILY DWELLING",
      "CONDOMINIUMS",
      "LODGING AND ROOMING HOUSES",
      "APARTMENT BUILDING",
      "DORMITORY",
      "HOTEL"
    ],
    "NON-RESIDENTIAL": [
      "ASSEMBLY",
      "BUSINESS",
      "DETENTION AND CORRECTIONAL",
      "EDUCATIONAL",
      "HEALTH CARE",
      "INDUSTRIAL",
      "MERCANTILE",
      "MISCELLANEOUS",
      "MIXED OCCUPANCIES",
      "STORAGE"
    ],
    "NON-STRUCTURAL": [
      "AGRICULTURAL LAND",
      "AMBULANT VENDOR",
      "ELECTRICAL POLE",
      "FOREST",
      "GRASS",
      "RUBBISH"
    ],
    TRANSPORT: [
      "AIRCRAFT",
      "AUTOMOBILE",
      "BUS",
      "HEAVY EQUIPMENT",
      "JEEPNEY",
      "LOCOMOTIVE",
      "MOTORCYCLE",
      "SHIP / WATER VESSEL",
      "TRICYCLE",
      "TRUCK"
    ]
  };

  category.addEventListener("change", function () {
    const selected = category.value;
    subCategory.innerHTML = `<option value="">-- Select Sub Category --</option>`; // Reset

    if (options[selected]) {
      options[selected].forEach(item => {
        subCategory.innerHTML += `<option value="${item}">${item}</option>`;
      });
    }
  });
</script>

           </div>

          <div class="row mb-3">
             <div class="col-md-3">
              <label for="establishment" class="form-label">Establishment/s</label>
               <textarea class="form-control" name="establishment_name" rows="3" placeholder="Enter Establishment burned..." value= "n/a" required></textarea>
            </div>
             <div class="col-md-3">
              <label for="owner" class="form-label">Owner/s</label>
               <textarea class="form-control" name="owner" rows="3" placeholder="Name of Owner/s of burned establishment" value= "n/a" requried></textarea>
            </div>
             <div class="col-md-3">
              <label for="occupants" class="form-label">Occupant/s</label>
               <textarea class="form-control" name="occupant" rows="3" placeholder="Name of Occupants of establishment burned..." value= "n/a" required></textarea>
              </div>   
              <div class="col-md-2">
              <label for="storey" class="form-label">No. of Storey/s</label>
              <input type="text" class="form-control" name="no_of_storeys" value ="0" required>
              </div>
       
          </div>

          <div class="row mb-3">
            <div class="col-md-2">
              <label for="distance" class="form-label">Dist (Station to Scene)</label>
              <input type="text" class="form-control" name="dist" required>
            </div>
            <div class="col-md-2">
              <label for="DispatchTime" class="form-label">Dispatch Time</label>
              <input type="time" class="form-control" name="dispatch" required>
            </div>
            <div class="col-md-2">
              <label for="Arrivaltime" class="form-label">Arrival Time</label>
              <input type="time" class="form-control" name="arrival" required>
            </div>
             <div class="col-md-2">
              <label for="injurybfpmale" class="form-label">BFP Injury (Male) </label>
              <input type="text" class="form-control" name="injuredbfpmale" value="0" required>
            </div>
             <div class="col-md-2">
              <label for="injurybfpfemale" class="form-label">BFP Injury (Female) </label>
              <input type="text" class="form-control" name="injuredbfpfemale" value="0" required>
            </div>
            <div class="col-md-2">
              <label for="injurybfptotal" class="form-label">BFP Injury (Total) </label>
              <input type="text" class="form-control" name="injuredbfptotal" value="0" required>
            </div>
          </div>
          <div class="row mb-3">
             <div class="col-md-2">
              <label for="injurycivmale" class="form-label">Civilian Injury (Male) </label>
              <input type="text" class="form-control" name="injuredcivmale" value="0" required>
            </div>
             <div class="col-md-2">
              <label for="injurycivfemale" class="form-label">Civilian Injury (Female) </label>
              <input type="text" class="form-control" name="injuredcivfemale" value="0" required>
            </div>
            <div class="col-md-2">
              <label for="injurycivtotal" class="form-label">Civilian Injury (Total) </label>
              <input type="text" class="form-control" name="injuredcivtotal" value="0" required>
            </div>
             <div class="col-md-2">
              <label for="injured" class="form-label">BFP Fatalities (Male) </label>
              <input type="text" class="form-control" name="fatalbfpmale" value="0"  required>
            </div>
             <div class="col-md-2">
              <label for="fatal" class="form-label">BFP Fatalities (Female) </label>
              <input type="text" class="form-control" name="fatalbfpfemale" value="0" required>
            </div>
            <div class="col-md-2">
              <label for="fatalitiesbfptotal" class="form-label">BFP Fatalities (Total) </label>
              <input type="text" class="form-control" name="fatalbfptotal" value="0" required>
            </div>
          </div>
           <div class="row mb-3">
           
             <div class="col-md-2">
              <label for="Fatalitiescivmale" class="form-label">Civilian Fatalities (Male) </label>
              <input type="text" class="form-control" name="fatalcivmale" value="0" required>
            </div>
             <div class="col-md-2">
              <label for="Fatalitiescivfemale" class="form-label">Civilian Fatalities (Female) </label>
              <input type="text" class="form-control" name="fatalcivfemale" value="0" required>
            </div>
            <div class="col-md-2">
              <label for="Fatalitiescivtotal" class="form-label">Civilian Fatalities (Total) </label>
              <input type="text" class="form-control" name="fatalcivtotal"  value="0" required>
            </div>
              <div class="col-md-2">
              <label for="affectstructure" class="form-label">No. Affected Structures</label>
              <input type="text" class="form-control" name="affectedstructure" value="1" required>
            </div>
              <div class="col-md-2">
              <label for="damage" class="form-label">Amount Damages</label>
              <input type="text" class="form-control" name="estimated_damage" required>
            </div>
            <div class="col-md-2">
                <label for="alarm" class="form-label">Alarm Level</label>
              <select class="form-select" name="alarm_level"  value="1ST ALARM" required>
                <option value="">-- Select ALARM LEVEL --</option>
                <option>1ST ALARM</option>
                <option>2ND ALARM</option>
                <option>3RD ALARM</option>
                <option>4TH ALARM</option>
                <option>5TH ALARM</option>
                <option>TF ALPHA</option>
                <option>TF BRAVO</option>
                <option>TF CHARLIE</option>
                <option>TF DELTA</option>
                <option>TF ECHO</option>
                <option>GENERAL ALARM</option>
                <option>FIRE OUT UPON ARRIVAL</option>
              </select>
            </div>
            <div class="row mb-3">
           
             <div class="col-md-3">
              <label for="causeFire" class="form-label">Cause of Fire</label>
              <select class="form-select" name="cause" required>
                <option value="">---Select Cause of Fire---</option>
                <option>UNDER INVESTIGATION</option>
                <option>OTHERS (Please indicate the cause in the remarks)</option>
                <option>BATTERY SHORT CIRCUIT OR BATTERY EXPLOSION</option>
                <option>CHILDREN PLAYING MATCHSTICK OR LIGHTER</option>
                <option>DUST EXPLOSION</option>
                <option>ELECTRICAL IGNITION CAUSED BY ARCING</option>
                <option>ELECTRICAL IGNITION CAUSED BY LOOSED CONNECTION</option>
                <option>ELECTRICAL IGNITION CAUSED BY OVERLOADING</option>
                <option>ELECTRICAL IGNITION DUE TO PINCHED WIRE</option>
                <option>ELECTRICAL POST FIRE TO STRUCTURAL FIRE</option>
                <option>FIRE CAUSED BY LIGHTNING</option>
                <option>IGNITION CAUSED BY BOMB EXPLOSION</option>
                <option>IGNITION CAUSED BY FIRECRACKER EXPLOSION</option>
                <option>IGNITION CAUSED BY FIREWORKS / PYROTECHNICS EXPLOSION</option>
                <option>IGNITION OF MATERIALS CAUSED BY ACETYLENE / OTHER HOT WORKS</option>
                <option>IGNITION OF MATERIAL CAUSED BY WELDING SLAGS</option>
                <option>IGNITION OF MATERIALS FROM EMBER / FLYING EMBER OR ALIPATO</option>
                <option>INTENTIONAL FIRE BY USE OF INCENDIARY DEVICE OR MECHANISM</option>
                <option>INTENTIONAL FIRE BY USE OF OPEN FLAME (MATCHSTICK OR LIGHTER OR LIGHT TORCH</option>
                <option>INTENTIONAL FIRE BY USE OF FLAMMABLE LIQUID</option>
                <option>LPG EXPLOSION CAUSED BY DEFECTIVE HOSE LINE</option>
                <option>LPG EXPLOSION CAUSED BY DEFECTIVE REGULATOR</option>
                <option>LPG EXPLOSION CAUSED BY DEFECTIVE STOVE</option>
                <option>LPG EXPLOSION CAUSED BY DEFECTIVE TANK</option>
                  <option>LPG EXPLOSION CAUSED BY STATIC ELECTRICITY OR SPARK</option>                          
                   <option>MAGNIFIED / AMPLIFIED SUN RAYS</option>   
                    <option>OPEN FLAME FROM COOKING (LPG / GAS STOVE, FIREWOOD)</option>   
                     <option>OPEN FLAME FROM FARMLAND / AGRICULTURAL LAND CLEARING OPERATION</option>   
                      <option>OPEN FLAME FROM KAINGIN (SLASH AND BURN)</option>   
                       <option>OPEN FLAME FROM KEROSENE LAMP (GASERA) / LIGHTING TORCH (SULO)</option>   
                        <option>OPEN FLAME FROM RUBBISH FIRE / BONFIRE TO STRUCTURAL FIRE</option>   
                         <option>OPEN FLAME FROM UNATTENDED LIGHTED CANDLE</option>   
                          <option>OVERHEATED ENGINE (MOTOR VEHICLES)</option>   
                           <option>OVERHEATED HOME APPLIANCES</option>   
                            <option>OVERHEATED INDUSTRIAL MACHINERY</option>   
                             <option>SMOKING(LIGHTED CIGARETTE, CIGAR OR PIPE)</option>   
                              <option>SPARKS FROM MACHINERY</option>   
                               <option>SPONTANEOUS COMBUSTION OF CHEMICALS</option>   
                                <option>SPONTANEOUS COMBUSTION OF SOLID MATERIALS</option>   
                                <option>TRANSFORMER POLE FIRE TO STRUCTURAL FIRE</option>   
                                <option>FIRE INCIDENT UNDER INVESTIGATION (ON PROCESS)</option>   
                                <option>UNDETERMINED FIRE CAUSE (ON PENDING INVESTIGATION)</option>   
                               
              </select>
            </div>
              <div class="col-md-3">
              <label for="classification" class="form-label">Classification</label>
              <select class="form-select" name="classification" required>
                <option value="">---Select Classification ---</option>
                <option>UNDER INVESTIGATION</option>
                <option>NATURAL</option>
                <option>ACCIDENTAL</option>
                <option>INCENDIARY</option>
                <option>UNDETERMINED</option>
               
              </select>
            </div>
             <div class="col-md-3">
              <label for="FAI" class="form-label">Fire Arson Investigator (FAI)</label>
              <input type="text" class="form-control" name="fai" required>
            </div>
             <div class="col-md-2">
              <label for="FSIC" class="form-label">FSIC</label>
              <input type="TEXT" class="form-control" name="fsic" required>
            </div>
         
           
         
        <div class="row mb-3">
          <div class="col-md-2">
              <label for="sir" class="form-label">Date Submitted (SIR)</label>
              <input type="date" class="form-control" name="spot_report" >
            </div>    
             
            <div class="col-md-2">
              <label for="Status" class="form-label">Status</label>
               <select class="form-select" name="status" required>
                <option value="">---Select Status</option>
                <option>UNDER INVESTIGATION</option>
                <option>CLOSED</option>
                <option>UNDETERMINED</option>
                </select>
              </div>
               <div class="col-md-2">
              <label for="FSIC" class="form-label">Report Type</label>
               <select class="form-select" name="typereport" required>
                <option value="Regular">---Select Report Type ---</option>
                <option>Regular</option>
                <option>MDFI</option>
               </select>
               </div>
              <div class="col-md-5">
              <label for="remarks" class="form-label">Remarks</label>
              <input type="text" class="form-control" name="remarks" value="none" required>
              
            </div>      
            </div>       
       <div class="text-center">
            <button type="submit" class="btn btn-success px-5 bg-bfp">Submit</button>
            <button type="reset" class="btn btn-secondary px-5 bg-bfp">Clear</button>
          </div>
            
          
        </form>
      </div>
    </div>
</div>
    <!-- CARD: DATATABLE -->
    <div class="card shadow-lg">
      
    
    </div>

  </div>
   <!-- Choices Occupancy Libraries -->

  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
 

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

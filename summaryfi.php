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
// Call the function to fetch data



    $filters = [
    'citymunicipality' => $_GET['citymunicipality'] ?? '*',
    'date_from'        => $_GET['date_from'] ?? '',
    'date_to'          => $_GET['date_to'] ?? '',
    'general_category' => $_GET['general_category'] ?? '*',
    'sub_category'     => $_GET['sub_category'] ?? '*',
    'cause'            => $_GET['cause'] ?? '*',
    'classification'   => $_GET['classification'] ?? '*',
    'typereport'       => $_GET['typereport'] ?? '*',
    'status'           => $_GET['status'] ?? '*'
];
// Display filter parameters in a message box
  $filtersApplied = false;


// Check if any filter or search value is set
foreach ($filters as $key => $value) {
    if ($value != '*' && $value != '') {
        $filtersApplied = true;
        break;
    }
}

if (!$filtersApplied && empty($search)) {
    $result = null; // No filters/search, don't fetch
} else {
    $result = fetchsummary($conn, $filters, $search);
}

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
        <h4>Summary of Fire Incidents</h4>
      </div>
         <!-- Filter Form -->
    <form method="GET" class="row g-3 mb-3">
      
      <!-- Date of Occurrence From -->
      <div class="col-md-2">
        <label for="date_from" class="form-label">Date of Occurrence (From)</label>
        <input type="date" class="form-control" name="date_from" 
               value="<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>">
      </div>

      <!-- Date of Occurrence To -->
      <div class="col-md-2">
        <label for="date_to" class="form-label">Date of Occurrence (To)</label>
        <input type="date" class="form-control" name="date_to" 
               value="<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>">
      </div>

      <!-- City / Municipality -->
      <div class="col-md-2">
        <label for="citymunicipality" class="form-label">City/Municipality</label>
                 <select class="form-select" name="citymunicipality" required>
              <option value="*" >*</option>
    <option value="Maasin City" >Maasin City</option>
  <option value="Macrohon" >Macrohon</option>
  <option value="P Burgos" >P Burgos</option>
  <option value="Limasawa" >Limasawa</option>
  <option value="Malitbog" >Malitbog</option>
  <option value="T Oppus" >T Oppus</option>
  <option value="Bontoc" >Bontoc</option>
  <option value="Sogod">Sogod</option>
<option value="Libagon">Libagon</option>
<option value="Liloan">Liloan</option>
<option value="San Francisco">San Francisco</option>
  <option value="Pintuyan">Pintuyan</option>
<option value="San Ricardo">San Ricardo</option>
<option value="St Bernard">St Bernard</option>
<option value="San Juan">San Juan</option>
<option value="Anahawan">Anahawan</option>
<option value="Hinundayan">Hinundayan</option>
<option value="Hinunangan">Hinunangan</option>
<option value="Silago">Silago</option>

</select>
        </select>
      </div>

      <!-- Type of Report -->
      <div class="col-md-2">
        <label for="typereport" class="form-label">Type of Report</label>
        <select class="form-select" name="typereport">
          <option value="*">*</option>
          <option value="Regular" <?php echo (isset($_GET['typereport']) && $_GET['typereport']=='Regular') ? 'selected' : ''; ?>>Regular</option>
          <option value="MDFI" <?php echo (isset($_GET['typereport']) && $_GET['typereport']=='MDFI') ? 'selected' : ''; ?>>MDFI</option>
        </select>
      </div>

      <!-- General Category -->
     

      <!-- Sub Category -->
      <!-- General Category -->
<div class="col-md-2">
    <label for="general_category" class="form-label">General Category</label>
    <select class="form-select" name="general_category" id="general_category" required>
        <option value="*">*</option>
        <option value="RESIDENTIAL">RESIDENTIAL</option>
        <option value="NON-RESIDENTIAL">NON-RESIDENTIAL</option>
        <option value="NON-STRUCTURAL">NON-STRUCTURAL</option>
        <option value="TRANSPORT">TRANSPORT</option>
    </select>
</div>

<!-- Sub Category -->
<div class="col-md-2">
    <label for="sub_category" class="form-label">Sub Category</label>
    <select class="form-select" name="sub_category" id="sub_category">
        <option value="">*</option>
    </select>
</div>

<script>
// Define subcategories for each general category
const subCategories = {
    "*":["*"],
    "RESIDENTIAL": ["SINGLE AND TWO FAMILY DWELLING", "HOTEL", "DORMITORY", "CONDOMINIUMS", "LODGING AND ROOMING HOUSES", "APARTMENT BUILDING" ],
    "NON-RESIDENTIAL": ["ASSEMBLY" , "BUSINESS" , "DETENTION AND CORRECTIONAL" , "EDUCATIONAL" , "HEALTH CARE", "INDUSTRIAL", "MISCELLANEOUS", "MIXED OCCUPANCIES", "STORAGE"     ],
    "NON-STRUCTURAL": ["AGRICULTURAL LAND" , "AMBULANT VENDOR" , "ELECTRICAL POLE" , "FOREST", "GRASS", "RUBBISH" ],
    "TRANSPORT": ["AIRCRAFT" , "AUTOMOBILE" , "BUS" , "HEAVY EQUIPMENT" , "JEEPNEY", "LOCOMOTIVE" , "MOTORCYCLE" ,   "SHIP / WATER VESSEL" ,  "TRICYCLE", "TRUCK"     ]
};

// Function to populate sub category based on selected general category
document.getElementById('general_category').addEventListener('change', function() {
    const subSelect = document.getElementById('sub_category');
    const selectedCategory = this.value;
    
    // Clear existing options
    subSelect.innerHTML = '<option value="">*</option>';
    
    if (subCategories[selectedCategory]) {
        subCategories[selectedCategory].forEach(sub => {
            const option = document.createElement('option');
            option.value = sub;
            option.textContent = sub;
            subSelect.appendChild(option);
        });
    }
});
</script>


      <!-- Fire Cause -->
     <div class="col-md-3">
    <label for="cause" class="form-label">Cause</label>
    <select class="form-select" name="cause">
        <option value="*">*</option>
        <option value="UNDER INVESTIGATION">UNDER INVESTIGATION</option>
        <option value="OTHERS">OTHER CAUSES</option>
        <option value="BATTERY SHORT CIRCUIT OR BATTERY EXPLOSION">BATTERY SHORT CIRCUIT OR BATTERY EXPLOSION</option>
        <option value="CHILDREN PLAYING MATCHSTICK OR LIGHTER">CHILDREN PLAYING MATCHSTICK OR LIGHTER</option>
        <option value="DUST EXPLOSION">DUST EXPLOSION</option>
        <option value="ELECTRICAL IGNITION CAUSED BY ARCING">ELECTRICAL IGNITION CAUSED BY ARCING</option>
        <option value="ELECTRICAL IGNITION CAUSED BY LOOSED CONNECTION">ELECTRICAL IGNITION CAUSED BY LOOSED CONNECTION</option>
        <option value="ELECTRICAL IGNITION CAUSED BY OVERLOADING">ELECTRICAL IGNITION CAUSED BY OVERLOADING</option>
        <option value="ELECTRICAL IGNITION DUE TO PINCHED WIRE">ELECTRICAL IGNITION DUE TO PINCHED WIRE</option>
        <option value="ELECTRICAL POST FIRE TO STRUCTURAL FIRE">ELECTRICAL POST FIRE TO STRUCTURAL FIRE</option>
        <option value="FIRE CAUSED BY LIGHTNING">FIRE CAUSED BY LIGHTNING</option>
        <option value="IGNITION CAUSED BY BOMB EXPLOSION">IGNITION CAUSED BY BOMB EXPLOSION</option>
        <option value="IGNITION CAUSED BY FIRECRACKER EXPLOSION">IGNITION CAUSED BY FIRECRACKER EXPLOSION</option>
        <option value="IGNITION CAUSED BY FIREWORKS / PYROTECHNICS EXPLOSION">IGNITION CAUSED BY FIREWORKS / PYROTECHNICS EXPLOSION</option>
        <option value="IGNITION OF MATERIALS CAUSED BY ACETYLENE / OTHER HOT WORKS">IGNITION OF MATERIALS CAUSED BY ACETYLENE / OTHER HOT WORKS</option>
        <option value="IGNITION OF MATERIAL CAUSED BY WELDING SLAGS">IGNITION OF MATERIAL CAUSED BY WELDING SLAGS</option>
        <option value="IGNITION OF MATERIALS FROM EMBER / FLYING EMBER OR ALIPATO">IGNITION OF MATERIALS FROM EMBER / FLYING EMBER OR ALIPATO</option>
        <option value="INTENTIONAL FIRE BY USE OF INCENDIARY DEVICE OR MECHANISM">INTENTIONAL FIRE BY USE OF INCENDIARY DEVICE OR MECHANISM</option>
        <option value="INTENTIONAL FIRE BY USE OF OPEN FLAME (MATCHSTICK OR LIGHTER OR LIGHT TORCH)">INTENTIONAL FIRE BY USE OF OPEN FLAME (MATCHSTICK OR LIGHTER OR LIGHT TORCH)</option>
        <option value="INTENTIONAL FIRE BY USE OF FLAMMABLE LIQUID">INTENTIONAL FIRE BY USE OF FLAMMABLE LIQUID</option>
        <option value="LPG EXPLOSION CAUSED BY DEFECTIVE HOSE LINE">LPG EXPLOSION CAUSED BY DEFECTIVE HOSE LINE</option>
        <option value="LPG EXPLOSION CAUSED BY DEFECTIVE REGULATOR">LPG EXPLOSION CAUSED BY DEFECTIVE REGULATOR</option>
        <option value="LPG EXPLOSION CAUSED BY DEFECTIVE STOVE">LPG EXPLOSION CAUSED BY DEFECTIVE STOVE</option>
        <option value="LPG EXPLOSION CAUSED BY DEFECTIVE TANK">LPG EXPLOSION CAUSED BY DEFECTIVE TANK</option>
        <option value="LPG EXPLOSION CAUSED BY STATIC ELECTRICITY OR SPARK">LPG EXPLOSION CAUSED BY STATIC ELECTRICITY OR SPARK</option>
        <option value="MAGNIFIED / AMPLIFIED SUN RAYS">MAGNIFIED / AMPLIFIED SUN RAYS</option>
        <option value="OPEN FLAME FROM COOKING (LPG / GAS STOVE, FIREWOOD)">OPEN FLAME FROM COOKING (LPG / GAS STOVE, FIREWOOD)</option>
        <option value="OPEN FLAME FROM FARMLAND / AGRICULTURAL LAND CLEARING OPERATION">OPEN FLAME FROM FARMLAND / AGRICULTURAL LAND CLEARING OPERATION</option>
        <option value="OPEN FLAME FROM KAINGIN (SLASH AND BURN)">OPEN FLAME FROM KAINGIN (SLASH AND BURN)</option>
        <option value="OPEN FLAME FROM KEROSENE LAMP (GASERA) / LIGHTING TORCH (SULO)">OPEN FLAME FROM KEROSENE LAMP (GASERA) / LIGHTING TORCH (SULO)</option>
        <option value="OPEN FLAME FROM RUBBISH FIRE / BONFIRE TO STRUCTURAL FIRE">OPEN FLAME FROM RUBBISH FIRE / BONFIRE TO STRUCTURAL FIRE</option>
        <option value="OPEN FLAME FROM UNATTENDED LIGHTED CANDLE">OPEN FLAME FROM UNATTENDED LIGHTED CANDLE</option>
        <option value="OVERHEATED ENGINE (MOTOR VEHICLES)">OVERHEATED ENGINE (MOTOR VEHICLES)</option>
        <option value="OVERHEATED HOME APPLIANCES">OVERHEATED HOME APPLIANCES</option>
        <option value="OVERHEATED INDUSTRIAL MACHINERY">OVERHEATED INDUSTRIAL MACHINERY</option>
        <option value="SMOKING(LIGHTED CIGARETTE, CIGAR OR PIPE)">SMOKING(LIGHTED CIGARETTE, CIGAR OR PIPE)</option>
        <option value="SPARKS FROM MACHINERY">SPARKS FROM MACHINERY</option>
        <option value="SPONTANEOUS COMBUSTION OF CHEMICALS">SPONTANEOUS COMBUSTION OF CHEMICALS</option>
        <option value="SPONTANEOUS COMBUSTION OF SOLID MATERIALS">SPONTANEOUS COMBUSTION OF SOLID MATERIALS</option>
        <option value="TRANSFORMER POLE FIRE TO STRUCTURAL FIRE">TRANSFORMER POLE FIRE TO STRUCTURAL FIRE</option>
        <option value="FIRE INCIDENT UNDER INVESTIGATION (ON PROCESS)">FIRE INCIDENT UNDER INVESTIGATION (ON PROCESS)</option>
        <option value="UNDETERMINED FIRE CAUSE (ON PENDING INVESTIGATION)">UNDETERMINED FIRE CAUSE (ON PENDING INVESTIGATION)</option>
    </select>
</div>

<!-- Classification -->
<div class="col-md-2">
    <label for="classification" class="form-label">Classification</label>
    <select class="form-select" name="classification" required>
        <option value="*">*</option>
  <option value="UNDER INVESTIGATION">UNDER INVESTIGATION</option>
  <option value="NATURAL">NATURAL</option>
  <option value="ACCIDENTAL">ACCIDENTAL</option>
  <option value="INCENDIARY">INCENDIARY</option>
  <option value="UNDETERMINED">UNDETERMINED</option>
</select>
</div>
<!-- Classification -->
<div class="col-md-2">
    <label for="status" class="form-label">Status</label>
    <select class="form-select" name="status" required>
        <option value="*">*</option>
  <option value="UNDER INVESTIGATION">UNDER INVESTIGATION</option>
  <option value="CLOSED">CLOSED</option>
  <option value="UNDETERMINED">UNDETERMINED</option>
 </select>
</div>

      <!-- Submit Button -->
      <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button> 
      </div>
       <div class="col-md-2 align-self-end">
     <a href="summaryfi.php" class="btn btn-primary w-100 text-center">Clear</a>

      </div>

    </form>
    <?php
   

?>
       
<div class="card-body">
       <div class="d-flex justify-content-end mb-2">
      <button id="exportExcel" class="btn btn-success">Export to Excel</button>
</div>
<div class="table-responsive" style="overflow-x: auto; white-space: nowrap;">
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            
            <tr>
            <th>Date and Time of Fire Alarm</th>  
            <th>Station</th>
             <th>Exact Location</th>
              <th>Fire Started</th>
              <th>Fire Out</th>
              <th>Category</th>
              <th>Sub Category</th>
              <th>Establishment</th>
              <th>Owner/s</th>
               <th>Occupants</th>
              <th>Storeys</th>
              <th>Distance</th>
              <th>Dispatch</th>
              <th>Arrival</th>
              <th>BFP Imjury (Male)</th>
              <th>BFP Imjury (Female)</th>
              <th>BFP Injury (Total)</th>
              <th>Civilian Injury(Male))</th>
               <th>Civilian Injury(Female)</th>
              <th>Civilian Injury(Total)</th>
               <th>BFP Fatalities (Male)</th>
              <th>BFP Fatalities (Female)</th>
              <th>BFP Fatalities (Total)</th>
              <th>Civilian Fatalities(Male))</th>
               <th>Civilian Fatalities(Female)</th>
              <th>Civilian Fatalities(Total)</th>
              <th>Affected Structures</th>
              <th>Amount Damages</th>
              <th>Alarm</th>
              <th>Cause</th>
              <th>Classification</th>
              <th>FAI</th>
              <th>FSIC</th>
               <th>SIR Date</th>
              <th>PIR Date</th>
              <th>FIR Date</th>
              <th>Status</th>
              <th>Type Report</th>
              <th>Remarks</th>
            
            </tr>
          </thead>
          <tbody>
            <!-- Records will be added dynamically -->
               <!-- Records will be added dynamically -->
              <?php
                $regularcounter=0;
                  $regular_damage=0;
                  $mdfi_damage=0;
                  $mdficounter=0;
                  $totalcounter=0;
                  $total_damage=0;
              if ($result !== null){
                if ($result->num_rows > 0) {
                

                    while ($row = $result->fetch_assoc()) {
                       if (date("Y", strtotime($row["alarm_datetime"])) == date("Y")){
                                            
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["alarm_datetime"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["citymunicipality"]) . "</td>";
                         echo "<td>" . htmlspecialchars($row["location"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["datetime_started"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["datetime_out"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["general_category"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["sub_category"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["establishment_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["owner"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["occupant"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["no_of_storeys"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["dist"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["dispatch"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["arrival"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredbfpmale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredbfpfemale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredbfptotal"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredcivmale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredcivfemale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["injuredcivtotal"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalbfpmale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalbfpfemale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalbfptotal"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalcivmale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalcivfemale"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["fatalcivtotal"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["affectedstructure"]) . "</td>";
                      
                     echo "<td>  ₱ " . number_format($row["estimated_damage"], 2) . "</td>";

                        echo "<td>" . htmlspecialchars($row["alarm_level"]) . "</td>";
                          echo "<td>" . htmlspecialchars($row["cause"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["alarm_level"]) . "</td>";
                              echo "<td>" . htmlspecialchars($row["fai"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["fsic"]) . "</td>";
                                  echo "<td>" . htmlspecialchars($row["spot_report"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["progress_report"]) . "</td>";
                                      echo "<td>" . htmlspecialchars($row["final_report"]) . "</td>";
                                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                                          echo "<td>" . htmlspecialchars($row["typereport"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";

                       
                        
                   $type = strtolower(trim($row["typereport"]));

if ($type === "regular") {  
    $regularcounter++; 
    $regular_damage += floatval($row["estimated_damage"]);

} elseif ($type === "mdfi") {
    $mdficounter++; 
    $mdfi_damage += floatval($row["estimated_damage"]);
}

               
                 

                 
                      
                     
                        
                       }
                    }
                      $totalcounter=$mdficounter + $regularcounter;
                        $total_damage=$mdfi_damage + $regular_damage;
                
                   echo '
                    <tfoot>
                           <tr>
                            <td colspan="2" style="text-align:right; color:black; font-weight:bold;">REGULAR:</td>
                             <td colspan="3" style="font-weight:bold; color:red; text-align:right">
                               <span>(' . number_format($regularcounter) . ')</span>
                            ₱' . number_format($regular_damage, 2) . '
                                   </td>

                           <td colspan="2" style="text-align:right; font-weight:bold; color:black;">MDFI:</td>
                             <td colspan="3" style="font-weight:bold; text-align:right; color:red;">
                           <span>(' . number_format($mdficounter) . ')</span>
                            ₱' . number_format($mdfi_damage, 2) . '
                                 </td>

                          <td colspan="2" style="text-align:right; font-weight:bold; color:black;">TOTAL:</td>
                          <td colspan="3"  style="font-weight:bold; text-align:right; color:red;">
                            <span>(' . number_format($totalcounter) . ')</span>
                            ₱' . number_format($total_damage, 2) . '
                          </td>
                        </tr>
                      </tfoot>
                      '; 
                  
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
document.getElementById('exportExcel').addEventListener('click', function () {

    // Get filter values from URL (PHP → JS)
    const typeReport = "<?php echo isset($_GET['typereport']) ? strtoupper($_GET['typereport']) : '*'; ?>";
    const city       = "<?php echo isset($_GET['citymunicipality']) ? $_GET['citymunicipality'] : '*'; ?>";
    const dateFrom   = "<?php echo isset($_GET['date_from']) ? $_GET['date_from'] : ''; ?>";
    const dateTo     = "<?php echo isset($_GET['date_to']) ? $_GET['date_to'] : ''; ?>";

    // Normalize values
    const safeType = (typeReport === '*' || typeReport === '') ? 'ALL' 
                    : typeReport.replace(/[^A-Z0-9]/g, "_");

    const safeCity = (city === '*' || city === '') ? 'ALL' 
                    : city.replace(/[^a-zA-Z0-9]/g, "_");

    const safeFrom = dateFrom ? dateFrom.replace(/-/g, "") : 'ALL';
    const safeTo   = dateTo ? dateTo.replace(/-/g, "") : 'ALL';

    const table = document.getElementById('dataTable');
    const wb = XLSX.utils.table_to_book(table, { sheet: "Fire Incidents" });

    const filename = `FIRES_${safeType}_${safeCity}_FROM_${safeFrom}_TO_${safeTo}.xlsx`;

    XLSX.writeFile(wb, filename);
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
</body>
</html>

<?php
include 'functions.php'; // Include the functions file
include 'db_connect.php';
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
    $id2=$id;
    $sql = "SELECT * FROM files WHERE id = $id"; // use your actual table name
    $sql2 = "SELECT * FROM fire_incidents WHERE id = $id2"; // use your actual table name
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
           } else {
       echo "<script>
        alert('⚠️ No uploaded file(s) found with Fire Incident ID: $id');
        window.close(); // closes the tab or popup window
    </script>";
    }
    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
           } else {
      echo "<script>
        alert('⚠️ No uploaded file(s) found with Fire Incident ID: $id');
        window.close(); // closes the tab or popup window
    </script>";
    }

} else {
    echo "<script>
        alert('⚠️ No uploaded file(s) found with ID: $id ');
        window.close(); // closes the tab or popup window
    </script>";
}




$stmt = $conn->prepare("SELECT * FROM files WHERE id = ? ORDER BY uploaded_at DESC");
$stmt->bind_param("s", $id); // "i" = integer (change to "s" if id is string)
$stmt->execute();
$result = $stmt->get_result();

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
    
.card-body {
  max-width: 400px;
  margin: 40px auto;
  padding: 25px;
  background: #f8fbff;
  border: 1px solid #c8e1ff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 80, 200, 0.1);
  text-align: center;
  font-family: "Segoe UI", Arial, sans-serif;
}

.card-body h6 {
  color: #004aad;
  margin-bottom: 20px;
}

.upload-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 15px;
}

.upload-form input[type="file"] {
  padding: 10px;
  border: 2px solid #007bff;
  border-radius: 8px;
  background-color: #e8f1ff;
  cursor: pointer;
  transition: all 0.2s;
}

.upload-form input[type="file"]:hover {
  background-color: #d6e8ff;
}

.upload-form button {
  background-color: #007bff;
  color: white;
  padding: 5px 30px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 15px;
  transition: background-color 0.3s ease;
}

.upload-form button:hover {
  background-color: #0056cc;
}

.view-link {
  display: inline-block;
  margin-top: 5px;
  text-decoration: none;
  color: #0056cc;
  font-weight: 600;
  transition: color 0.2s;
}

.view-link:hover {
  color: #002b80;
  text-decoration: underline;
}
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
        <h4> Upload - Investigation Reports </h4>
      </div>
  <div >
 
  <form action="upload.php" method="post" enctype="multipart/form-data" class="upload-form">
     <Label>📁 Upload Investigation Reports </label>
     <input type="text" name="file" value="<?php echo $id; ?>" readonly hidden >
   <input type="file" name="file" required> <button type="submit">Upload</button><button type="button" onclick="history.back()">Back</button>
  </form>
    <hr>
  <a href="fireincidents.php">BACK</a>
 </div>
           <div class="row mb-3">
  <div class="col-md-2">
    <label for="region" class="form-label">Exact Location</label>
    <input type="text" class="form-control" name="location" 
           value="<?php echo $row['location']; ?>" readonly>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
  </div>

  <div class="col-md-2">
    <label for="province" class="form-label">Fire Station</label>
    <input type="text" class="form-control" name="citymunicipality" 
           value="<?php echo $row['citymunicipality']; ?>" readonly>
  </div>

  <div class="col-md-2">
    <label for="DTReport" class="form-label">Date and Time Reported</label>
    <input type="text" class="form-control" name="alarm_datetime" 
           value="<?php echo $row['alarm_datetime']; ?>" readonly>
  </div>
  <div class="col-md-2">
     <label for="DTStarted" class="form-label">Date and Time of Fire Started</label>
  <input type="text" class="form-control" name="datetime_started" value="<?php echo $row['datetime_started']; ?>" readonly>
  </div>
 
</div>


        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Filename                  </th>
              <th>Date and Time Uploaded</th>  
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Records will be added dynamically -->
              <!-- Display the table with td, ID, Filename, Type Date Uploaded, Action (View/Download) -->
              <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['ID']) ?></td>
      <td><?= htmlspecialchars($row['filename']) ?></td>
      <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
      <td>
        <a href="<?= htmlspecialchars($row['filepath']) ?>" target="_blank">View</a> |
        <a href="<?= htmlspecialchars($row['filepath']) ?>" download>Download</a> 
      </td>
    </tr>
    <?php endwhile; ?>

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

<?php
// Function to connect to the database
function connectToDatabase() {
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "test"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to fetch data from the database
function fetchData($conn, $search = ""): mixed {
    $sql = "SELECT citymunicipality, location, alarm_datetime, datetime_out, general_category, owner, estimated_damage, typereport, id, fai, status, spot_report, progress_report, final_report  FROM fire_incidents ";

    // Add search condition if search term is provided
    if (!empty($search)) {
        $sql .= " WHERE citymunicipality LIKE ? OR general_category LIKE ? OR owner LIKE ? OR typereport LIKE ? OR location LIKE ? ORDER BY alarm_datetime ASC";
        
    }else if (empty($search)){ $sql .= " ORDER BY alarm_datetime ASC";

    }

    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        
    }

    $stmt->execute();
    $result = $stmt->get_result();


    return $result;
}
//only edit function
function fetchusers($conn, $search = ""): mixed {
    $sql = "SELECT id, fullname, email, username, userpassword,  Level, citymunicipality, grantor FROM users";

    // Add search condition if search term is provided
    if (!empty($search)) {
        $sql .= " WHERE citymunicipality LIKE ? OR fullname LIKE ? ORDER BY id ASC";
        
    }

    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $searchTerm = "%$search%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        
    }

    $stmt->execute();
    $result = $stmt->get_result();


    return $result;
}
function fetchsummary($conn, $filters, $search) {

    $sql = "SELECT * FROM fire_incidents WHERE 1 ";

    // Date From
    if (!empty($filters['date_from'])) {
        $date_from = $conn->real_escape_string($filters['date_from']);
        $sql .= " AND alarm_datetime >= '$date_from 00:00:00' ";
    }

    // Date To
    if (!empty($filters['date_to'])) {
        $date_to = $conn->real_escape_string($filters['date_to']);
        $sql .= " AND alarm_datetime <= '$date_to 23:59:59' ";
    }

    // City/Municipality
    if (!empty($filters['citymunicipality']) && $filters['citymunicipality'] !== '*') {
        $city = $conn->real_escape_string($filters['citymunicipality']);
        $sql .= " AND citymunicipality = '$city' ";
    }

    // General Category
    if (!empty($filters['general_category']) && $filters['general_category'] !== '*') {
        $gc = $conn->real_escape_string($filters['general_category']);
        $sql .= " AND general_category = '$gc' ";
    }

    // Sub Category
    if (!empty($filters['sub_category']) && $filters['sub_category'] !== '*') {
        $sc = $conn->real_escape_string($filters['sub_category']);
        $sql .= " AND sub_category = '$sc' ";
    }

    // Cause
    if (!empty($filters['cause']) && $filters['cause'] !== '*') {
        $cause = $conn->real_escape_string($filters['cause']);
        $sql .= " AND cause = '$cause' ";
    }

    // Classification
    if (!empty($filters['classification']) && $filters['classification'] !== '*') {
        $class = $conn->real_escape_string($filters['classification']);
        $sql .= " AND classification = '$class' ";
    }

    // Type of Report
    if (!empty($filters['typereport']) && $filters['typereport'] !== '*') {
        $type = $conn->real_escape_string($filters['typereport']);
        $sql .= " AND typereport = '$type' ";
    }

    // Status
    if (!empty($filters['status']) && $filters['status'] !== '*') {
        $status = $conn->real_escape_string($filters['status']);
        $sql .= " AND status = '$status' ";
    }

    // Search Field
    if (!empty($search)) {
        $s = $conn->real_escape_string($search);
        $sql .= " AND (
            citymunicipality LIKE '%$s%' OR
            location LIKE '%$s%' OR
            owner LIKE '%$s%' OR
            cause LIKE '%$s%' OR
            classification LIKE '%$s%'
        ) ";
    }

    // Sort by datetime
    $sql .= " ORDER BY alarm_datetime ASC ";
$result = $conn->query($sql);
echo "Rows found: " . $result->num_rows;
return $result;

    //return $conn->query($sql);
}



// Function to fetch a single row based on account number
function fetchRow($conn, $id) {
    $sql = "SELECT citymunicipality, location, alarm_datetime, datetime_out, general_category, owner, estimated_damage, id, fai, status, spot_report, progress_report, final_report FROM fire_incidents WHERE id=? ";
    $stmt = $conn->prepare($sql);
    echo $id;
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to update data in the database
function updateData($conn, $acctno, $firstname, $lastname, $mi, $gender, $contactno, $myaddress, $dateapplication, $remarks) {
    $sql = "UPDATE fire_incidents SET firstname = ?, lastname = ?, mi=?, gender=?, contactno=?, myaddress=?, dateapplication=?, remarks=? WHERE id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $firstname, $lastname, $mi, $gender, $contactno, $myaddress, $dateapplication, $acctno, $remarks);
    return $stmt->execute();
}
?>


<?php

<?php 
$alarm_datetime =$_POST["alarm_datetime"];
$region =$_POST["region"];
$province =$_POST["province"];
$citymunicipality =$_POST["citymunicipality"];
$location =$_POST["location"];
$general_category =$_POST["general_category"];
$sub_category =$_POST["sub_category"];
$establishment_name=$_POST["establishment_name"];
$no_of_storeys =$_POST["no_of_storeys"];
$owner =$_POST["owner"];
$occupant =$_POST["occupant"];
$datetime_started =$_POST["datetime_started"];
$datetime_out =$_POST["datetime_out"];
$injuredcivfemale =$_POST["injuredcivfemale"];
$injuredcivmale =$_POST["injuredcivmale"];
$fatalcivfemale =$_POST["fatalcivfemale"];
$fatalcivmale =$_POST["fatalcivmale"];
$estimated_damage =$_POST["estimated_damage"];
$alarm_level =$_POST["alarm_level"];
$cause =$_POST["cause"];
$classification =$_POST["classification"];
$spot_report =$_POST["spot_report"];
$fsic =$_POST["fsic"];
$remarks =$_POST["remarks"];

$typereport =$_POST["typereport"];
$dispatch =$_POST["dispatch"];
$arrival =$_POST["arrival"];
$dist =$_POST["dist"];
$fai =$_POST["fai"];
$injuredbfpmale =$_POST["injuredbfpmale"];
$injuredbfpfemale =$_POST["injuredbfpfemale"];
$injuredcivtotal =$_POST["injuredcivtotal"];
$injuredbfptotal =$_POST["injuredbfptotal"];
$fatalcivtotal =$_POST["fatalcivtotal"];
$fatalbfpmale =$_POST["fatalbfpmale"];
$fatalbfpfemale =$_POST["fatalbfpfemale"];
$fatalbfptotal =$_POST["fatalbfptotal"];
$status =$_POST["status"];
$affectedstructure =$_POST["affectedstructure"];


// Database Connection
$conn =new mysqli('localhost','root','','test');
// SERVER CONNECTION ERROR
if ($conn->connect_error) {
    echo "<script>alert('Database connection failed!');</script>";
    error_log('DB Connection Error: ' . $conn->connect_error);
    exit();
}
if(!$conn) {
    die('connection failed  :'. $conn->connect_error);
   }else
{
   
    $stmt = $conn->prepare("INSERT INTO fire_incidents (
    alarm_datetime, region, province, citymunicipality, location,
    general_category, sub_category, establishment_name, no_of_storeys,
    owner, occupant, datetime_started, datetime_out,
    injuredcivfemale, injuredcivmale, fatalcivfemale, fatalcivmale,
    estimated_damage, alarm_level, cause, classification, spot_report,
    fsic, remarks, typereport, dispatch, arrival, dist,
    fai, injuredbfpmale, injuredbfpfemale, injuredcivtotal, injuredbfptotal,
    fatalcivtotal, fatalbfpmale, fatalbfpfemale, fatalbfptotal, status,
    affectedstructure
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
// ERROR TRAP IF PREPARE FAILS
if (!$stmt) {
    echo "<script>alert('Error preparing SQL statement! Check console.');</script>";
    error_log("Prepare failed: " . $conn->error);
    exit();
}
 //
    //  $stmt=$conn->prepare("insert into fire_incidents values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        //$remarks="UI"; //for verification, without pending case/
       date_default_timezone_set('Asia/Manila'); // set timezone
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
$remarks =$_POST["remarks"];
    $stmt->bind_param("sssssssssssssssssssssssssssssssssssssss", $alarm_datetime, $region, $province, $citymunicipality, $location, $general_category, $sub_category, $establishment_name, $no_of_storeys, $owner, $occupant, $datetime_started, $datetime_out, $injuredcivfemale, $injuredcivmale, $fatalcivfemale, $fatalcivmale, $estimated_damage, $alarm_level, $cause,  $classification,  $spot_report, $fsic, $remarks,  $typereport,  $dispatch, $arrival, $dist, $fai, $injuredbfpmale, $injuredbfpfemale, $injuredcivtotal, $injuredbfptotal, $fatalcivtotal, $fatalbfpmale, $fatalbfpfemale, $fatalbfptotal, $status,  $affectedstructure );
    $stmt->execute();
   //echo "<script>alert('Record updated successfully!'); window.location='fire_incidents.php';</script>";
     echo "<script>alert('Record updated successfully!'); window.location='fireincidents.php';</script>";
       // echo "<H2>". $citymunicipality. "/ ". $location. "/ ". $general_category. "/ ". $sub_category. "/ ". $owner. "/ ". $alarm_datetime. "/ ". $spot_report. "/". $alarm_level. "/ ". $establishment_name. "</h2>";
    
    //echo "<h2><a href=main.php>HOME</a><h2>";     echo "<h2><a href=dataentry.html>Back</a><h2>";

  
$stmt->close();
$conn->close();
}
?>

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
$progress_report=$_POST["progress_report"];
$final_report =$_POST["final_report"];
$fsic =$_POST["fsic"];
$remarks =$_POST["remarks"];
$sirfilepdf =$_POST["sirfilepdf"];
$pirfilepdf =$_POST["pirfilepdf"];
$firfilepdf =$_POST["firfilepdf"];
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
$id = $_POST["id"];



// Database Connection
$conn =new mysqli('localhost','root','','test');
if(!$conn) {
    die('connection failed  :'. $conn->connect_error);
   }else


//if (isset($_POST['update.php'])) {
    
    // Prepare the SQL update
    $sql = "UPDATE fire_incidents 
            SET     
alarm_datetime=?,
region=?,
province=?,
citymunicipality=?,
location=?,
general_category=?,
sub_category=?,
establishment_name=?,
no_of_storeys=?,
owner=?,
occupant=?,
datetime_started=?,
datetime_out=?,
injuredcivfemale=?,
injuredcivmale=?,
fatalcivfemale=?,
fatalcivmale=?,
estimated_damage=?,
alarm_level=?,
cause=?,
classification=?,
spot_report=?,
progress_report=?,
final_report=?,
fsic=?,
remarks=?,
sirfilepdf=?,
pirfilepdf=?,
firfilepdf=?,
typereport=?,
dispatch=?,
arrival=?,
dist=?,
fai=?,
injuredbfpmale=?,
injuredbfpfemale=?,
injuredcivtotal=?,
injuredbfptotal=?,
fatalcivtotal=?,
fatalbfpmale=?,
fatalbfpfemale=?,
fatalbfptotal=?,
status=?,
affectedstructure=?                 
 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssss", 
$alarm_datetime, 
$region,
     $province, 
    $citymunicipality,
     $location, 
     $general_category, 
     $sub_category,
     $establishment_name,
     $no_of_storeys,
      $owner, 
      $occupant,
       $datetime_started, 
       $datetime_out, 
       $injuredcivfemale,
        $injuredcivmale, 
        $fatalcivfemale, 
        $fatalcivmale,
         $estimated_damage,
          $alarm_level, 
          $cause, 
          $classification,
           $spot_report,
            $progress_report,
             $final_report,   
               $fsic, 
               $remarks,
                $sirfilepdf,
                 $pirfilepdf,
                  $firfilepdf,
                   $typereport, 
                   $dispatch,
                    $arrival, 
                      $dist,
                       $fai, 
                       $injuredbfpmale, 
                       $injuredbfpfemale,
                        $injuredcivtotal,
                         $injuredbfptotal,  
                         $fatalcivtotal,
                          $fatalbfpmale,
                           $fatalbfpfemale,
                            $fatalbfptotal,
                             $status,
                              $affectedstructure,
                               $id );
    if ($stmt->execute()) {
         
        //echo "<script>alert('Record updated successfully!' ); window.location='fireincidents.php';</script>";
       echo "<script>
    alert('Record updated successfully! Record Id No.\\nID: {$id}\\nAffected rows: {$stmt->affected_rows}');
    window.history.go(-2);
</script>";

    } else {
       echo "<script>
    alert('Update Error ! Record Id No.\\nID: {$id}\\nAffected rows: {$stmt->affected_rows}');
   window.history.go(-2);
</script>";

    }
//}

?>

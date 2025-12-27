 echo '
<tfoot>
  <tr>
    <td colspan="1" style="text-align:right; color:blue; font-weight:bold;">REGULAR:</td>
    <td style="font-weight:bold; color:blue; text-align:right">
      <span>(' . number_format($regularcounter) . ')</span>
      ₱' . number_format($regular_damage, 2) . '
    </td>

    <td colspan="1" style="text-align:right; font-weight:bold; color:blue;">MDFI:</td>
    <td style="font-weight:bold; text-align:right; color:blue;">
      <span>(' . number_format($mdficounter) . ')</span>
      ₱' . number_format($mdfi_damage, 2) . '
    </td>

    <td colspan="2" style="text-align:right; font-weight:bold; color:blue;">TOTAL:</td>
    <td style="font-weight:bold; text-align:right; color:blue;">
      <span>(' . number_format($totalcounter) . ')</span>
      ₱' . number_format($total_damage, 2) . '
    </td>
  </tr>
</tfoot>
'; 
 $regular_damage=0;
                  $regularcounter=0;
                  $mdficounter=0;
                  $totalcounter=0;
                  $mdfi_damage=0;
                  $total_damage = 0;
                   $total_damage += (float)$row["estimated_damage"];
                        $totalcounter+=1;
                     
                        if ($row["typereport"]=="Regular") { $regular_damage+=(float)$row["estimated_damage"]; $regularcounter+=1;} else {$mdfi_damage+=(float)$row["estimated_damage"]; $mdficounter+=1;}
                       
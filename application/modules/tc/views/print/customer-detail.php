<!--<style>
  body{
    font-size: smaller;
  }
  table{
    font-size: smaller;
  }
</style>-->

<body>
  <table width="100%">
    <tr>
      <td rowspan="2"><img src="<?php print base_url()."themes/antavaya/images/logo.png"?>" /></td>
      <td><h1 style="text-align: center">Passenger Detail</h1></td>
    </tr>
    <tr>
<!--      <td><h4 style="text-align: center">Antavaya Sunda (Tour Department) Telp. 022 426 1739 Fax. 022 426 1759</h4></td>-->
    </tr>
  </table>
  <hr />
 
  <b>Buyer (<?php print $book_code?>)</b><br />
  <table width="100%">
    <tr>
      <td>Product</td>
      <td>: <?php print $tour->title;?><br>:&nbsp;[<?php print $tour->category->name." ".$tour->sub_category->name; ?>]</td>
      <td>Contact</td>
      <td>: <?php print $book->first_name." ".$book->last_name?></td>
    </tr>
    <tr>
      <td>Date of Depart</td>
      <td>: <?php print date("d M y", strtotime($tour->information->start_date))?></td>
      <td>From</td>
      <td>: <?php print $tour->information->keberangkatan?></td>
    </tr>
    <tr>
      <td>Phone</td>
      <td>: <?php print $book->telphone?></td>
      <td>Email</td>
      <td>: <?php print $book->email?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td>: <?php print $book->address?></td>
     
    </tr>
  </table>
  <hr />
   <?php    if($book->room){
            for($k = 1 ; $k <= $book->room ; $k++){
              $type_bed = "type_bed".$k;
              $qty = "qty".$k;
              
              if($k == 1){
                $class_active = "active";
              }else{
                $class_active = "";
              }
              
     ?><br />
  <b>Room <?php print $k; ?></b><br />
  <br />
  
   <table width="100%" style="border-style:double double double double;">
    <tr>
      <td style="border-style:none none double none;">Name</td>
      <td style="border-style:none none double none;">Contact</td>
     <td style="border-style:none none double none;">Place Of Birth</td>
      <td style="border-style:none none double none;">Birthdate</td>
      <td style="border-style:none none double none;">Type</td>
     <td style="border-style:none none double none;">No.Passport</td>
      <td style="border-style:none none double none;">Place Of Issued</td>
      <td style="border-style:none none double none;">Date Of Issued</td>
     <td style="border-style:none none double none;">Date Of Expired</td>
     <td style="border-style:none none double none;">Address</td>
    </tr>
    <?php
    foreach($book->passenger AS $dbp){ 
         if($dbp->room == $k){
              if($dbp->tanggal_lahir == "0000-00-00"){
                        $tanggal_lahir ="";
                    }else{
                       $tanggal_lahir = date("d F Y", strtotime($dbp->tanggal_lahir));
                        
                    }
                    if($dbp->date_of_issued  == "0000-00-00"){
                        $date_of_issued ="";
                    }else{
                         $date_of_issued = date("d F Y", strtotime($dbp->date_of_issued));
                    }
                    if($dbp->date_of_expired == "0000-00-00"){
                         $date_of_expired ="";
                    }else{
                         $date_of_expired = date("d F Y", strtotime($dbp->date_of_expired));
                    }
     
      print "<tr>"
        . "<td style='border-style:none none dotted none;'>{$dbp->first_name} {$dbp->last_name}</td>"
        . "<td style='border-style:none none dotted none;'>{$dbp->telphone}</td>"
        . "<td style='border-style:none none dotted none;'>{$dbp->tempat_tanggal_lahir}</td>"
       . "<td style='border-style:none none dotted none;'>{$tanggal_lahir}</td>"
              . "<td style='border-style:none none dotted none;'>{$dbp->type->desc}</td>"
               . "<td style='border-style:none none dotted none;'>{$dbp->no_passport}</td>"
        . "<td style='border-style:none none dotted none;'>{$dbp->place_of_issued}</td>"
       . "<td style='border-style:none none dotted none;'>{$date_of_issued}</td>"
              . "<td style='border-style:none none dotted none;'>{$date_of_expired}</td>"
               . "<td style='border-style:none none dotted none;'>{$dbp->address}</td>"
        . "</tr>";
     
         }
    } 
    ?>
   
  
  </table>
  <?php } }?>
  
 
</body>
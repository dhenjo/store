<?php
require_once 'system/core/Model.php';
class Form_eksternal extends CI_Model{
  function __construct() {
    $this->load->library('session');
    $this->load->library('nbscache');
  }
  function form_input($data = '', $value = '', $extra = '', $kunci = TRUE){
    if($kunci == TRUE)
      return form_input($data, $value, $extra);
    else
      return form_input($data, $value, $extra." readonly");
  }
  function form_input_price($id, $data = '', $value = '', $extra = '', $kunci = TRUE){
    if($kunci == TRUE)
      $hasil = form_input($data, $value, $extra." id='$id'");
    else
      $hasil = form_input($data, $value, $extra." id='$id' readonly");
    
//    if($kunci == TRUE){
      $hasil .= "
    <script>
      $(function() {
        $( '#{$id}' ).priceFormat({
          prefix: 'Rp ',
          centsLimit: 0,
          thousandsSeparator: '.'
        });
      });
    </script>";
//    }
    return $hasil;
  }
  function form_date($data, $value, $id, $extra = '', $tambahan = "", $kunci = TRUE){
    $hasil = $this->form_input($data, $value, "id='{$id}' ".$extra, $kunci);
    if($kunci == TRUE){
      $hasil .= <<<EOD
    <script>
      $(function() {
        $( "#{$id}" ).datepicker({
          {$tambahan}
          showOtherMonths: true,
          dateFormat: "yy-mm-dd",
          selectOtherMonths: true,
          selectOtherYears: true
        });
      });
    </script>
EOD;
    }
    return $hasil;
  }
  function form_password($data = '', $value = '', $extra = ''){
    return form_password($data, $value, $extra);
  }
  function form_upload($data = '', $value = '', $extra = '', $kunci = TRUE){
    if($kunci == true)
      return form_upload($data, $value, $extra);
    else
      return $this->form_input($data, $value, $extra, $kunci);
  }
  function form_submit($data = '', $value = '', $extra = ''){
    return form_submit($data, $value, $extra);
  }
  function form_open($action = '', $attributes = '', $hidden = array()){
    return form_open($action, $attributes, $hidden);
  }
  function form_close(){
    return form_close();
  }
  function form_open_multipart($action = '', $attributes = array(), $hidden = array()){
    return form_open_multipart($action, $attributes, $hidden);
  }
  function form_checkbox($data = '', $value = '', $checked = FALSE, $extra = ''){
    return form_checkbox($data, $value, $checked, $extra);
  }
  function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '', $kunci = TRUE){
    if($kunci == TRUE)
      return form_dropdown($name, $options, $selected, $extra);
    else{
      $hasil = form_hidden($name, $selected[0]).form_dropdown("", $options, $selected, $extra." disabled");
      return $hasil;
    }
  }
  function form_textarea($data = '', $value = '', $extra = '', $kunci = TRUE){
    if($kunci == TRUE)
      return form_textarea($data, $value, $extra);
    else
      return form_textarea($data, $value, $extra." readonly");
  }
  function form_edit_textarea($id_style, $link, $default = 0, $callback = "", $fungsi_tambahan = ""){
    $hasil = <<<EOD
    <div class="edit" id="{$id_style}">{$default}</div>
    <script>
      $(document).ready(function() {
         $('#{$id_style}').editable('{$link}',{
           {$callback}
         });
         {$fungsi_tambahan}
      });
    </script>
EOD;
    return $hasil;
  }
  function form_text_editable($id_style, $link, $default = 0, $callback = "", $fungsi_tambahan = "", $privilege = "nbs", $edit_nilai = 0){
    $akses = "tolak";
    if($this->session->userdata("id") == 1 OR $privilege == "nbs"){
      $akses = "masuk";
    }
    else{
      $edit = $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), $privilege, "edit");
      $add = $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), $privilege, "add");
      if($edit !== FALSE){
        $akses = "masuk";
      }
      else if($add !== FALSE AND $edit_nilai <= 0){
        $akses = "masuk";
      }
    }
    
    if($akses == "masuk"){
      $hasil = <<<EOD
    <div class="edit" id="{$id_style}">{$default}</div>
    <script>
      $(document).ready(function() {
         $('#{$id_style}').editable('{$link}',{
           {$callback}
         });
         {$fungsi_tambahan}
      });
    </script>
EOD;
    }
    else{
      $hasil = <<<EOD
      <div id="{$id_style}">{$default}</div>
EOD;
    }
    
    return $hasil;
  }
  function form_addrow_dropdown($name = '', $options = array(), $selected = array(), $extra = '', $delete = true){
    $name .= "[]";
    if(count($selected) > 0){
      foreach ($selected as $key => $value) {
        $hasil[] = $this->form_dropdown($name, $options, array($value), $extra);
      }
    }
    else{
      $hasil[] = $this->form_dropdown($name, $options, array(), $extra);
    }
    return $this->form_addrow($hasil, $delete);
  }
  function form_hidden($name, $value = '', $recursing = FALSE){
    return form_hidden($name, $value, $recursing);
  }
  function form_autocomplate($name, $name_hidden, $id, $id_hidden, $source, $value = 0, $value_hidden = 0, $extra = "", $fungsi = "", $name_update = "", $id_update = "", $kunci = true){
    if($kunci == TRUE){
      $hasil = $this->form_input($name, $value, 'id="'.$id.'" '.$extra);
      $hasil .= $this->form_input($name_hidden, $value_hidden, 'id="'.$id_hidden.'" style="display: none" ');
      $hasil .= $this->form_hidden($name_update, $id_update);
      $hasil .= <<<EOD
      <script>
      $(function() {
        $( "#{$id}" ).autocomplete({
          source: "{$source}",
          minLength: 1,
          select: function( event, ui ) {
            $("#{$id_hidden}").val(ui.item.id);
            {$fungsi}
          }
        });
      });
      </script>
EOD;
    }
    else{
      $hasil = $this->form_input($name, $value, 'id="'.$id.'" '.$extra, $kunci);
      $hasil .= $this->form_input($name_hidden, $value_hidden, 'id="'.$id_hidden.'" style="display: none" ', $kunci);
      $hasil .= $this->form_hidden($name_update, $id_update);
    }
    return $hasil;
  }
  function form_addrow_autocomplate($name, $name_hidden, $id_hidden, $link, $table, $body, $nomor, $tr, $id, $source, $value = array(), $value_hidden = array(), $extra = "", $delete = true){
    $hasil = array();
    if(count($value) > 0){
      $no = 1;
      foreach ($value as $key => $value2) {
        $hasil[] = $this->form_autocomplate($name, $name_hidden, $id."_".$no, $id_hidden."_".$no, $source, $value2, $value_hidden[$key], $extra);
        $no++;
      }
    }
    else{
      $hasil[] = $this->form_autocomplate($name, $name_hidden, $id, $id_hidden, $source, "", "", $extra);
    }
    $data = $this->form_addrow_tambahan($hasil, $link, $table, $body, $nomor, $tr, $delete);
    
    return $data;
  }
  function form_addrow_select($name, $options, $link, $table, $body, $nomor, $tr, $selected = array(), $extra = "", $delete = true){
    $hasil = array();
    if(count($selected) > 0){
      foreach ($selected as $key => $value2) {
        $hasil[] = $this->form_dropdown($name, $options, array($value2), $extra);
      }
    }
    else{
      $hasil[] = $this->form_dropdown($name, $options, $selected, $extra);
    }
    $data = $this->form_addrow_tambahan($hasil, $link, $table, $body, $nomor, $tr, $delete);
    
    return $data;
  }
  function form_addrow($isi, $delete = true){
    if(is_array($isi)){
      $tampil = "";
      $ld = "";
      $sld = "";
      if($delete === true){
        $ld = "<td><a href='javascript:void();' class='remove-element delRow' title='Remove' >Remove</a></td>";
        $sld = '$(".delRow").btnDelRow();';
      }
      foreach($isi as $si){
        $tampil .= "
          <tr>
            <td>{$si}</td>
            {$ld}
          </tr>
          ";
      }
    }
    $hasil = <<<EOD
    <table>
      {$tampil}
      <tr>
        <td><a href="javascript:void();" class="add-element addRow" title="Add">Add</a></td>
      </tr>
    </table>
      <script type="text/javascript">
      (function($){
        $(document).ready(function(){
          $(".addRow").btnAddRow();
          {$sld}
      });
      })(jQuery);
      </script>
EOD;
    return $hasil;
  }
  
  function form_addrow_tambahan($isi, $link, $table, $body, $nomor, $tr, $delete = true){
    $tampil = "";
    foreach($isi as $key => $is){
      $ld = "";
      $sld = "";
      if($delete === true){
        $ld = <<<EOD
        <td><a href='javascript:void();' class='remove-element' onclick='del_row_tambahan("{$tr[$key]}")' title='Remove' >Remove</a></td>
EOD;
        $sld = '$(".delRow").btnDelRow();';
      }
        $tampil .= "
          <tr id='{$tr[$key]}'>
            <td>{$is}</td>
            {$ld}
          </tr>
          ";
    }
     
    $hasil = <<<EOD
    <table id='{$table}'>
      {$tampil}
      <tbody id="{$body}"></tbody>
      <tr>
        <td><a href="javascript:void();" onclick="add_row_tambahan('{$table}','{$link}','{$body}', '{$nomor}')" class="add-element" title="Add">Add</a></td>
      </tr>
    </table>
EOD;
    return $hasil;
  }
  function form_addrow_autocomplate_input($name, $name2, $name_hidden, $id_hidden, $link, $table, $body, $nomor, $tr, $id, $source, $value = array(), $valueinput = array(), $value_hidden = array(), $extra = "", $delete = true, $name_update = "", $id_update = array()){
    $hasil = array();
    if(count($value) > 0){
      $no = 1;
      foreach ($value as $key => $value2) {
        $hasil[] = $this->form_autocomplate($name, $name_hidden, $id."_".$no, $id_hidden."_".$no, $source, $value2, $value_hidden[$key], "", "",$name_update, $id_update[$key]);
        $hasil2[] = $this->form_input_price($id_hidden."_".$no."set", $name2, $valueinput[$key], $extra);
        $no++;
      }
    }
    else{
      $hasil[] = $this->form_autocomplate($name, $name_hidden, $id, $id_hidden, $source, "", "", "");
      $hasil2[] = $this->form_input_price($id_hidden."set", $name2, "", $extra);
    }
    $data = $this->form_addrow_2col($hasil, $hasil2, $link, $table, $body, $nomor, $tr, $delete);
    
    return $data;
  }
  function form_addrow_input($name, $name2, $table, $body, $nomor, $tr, $link, $value = array(), $valueinput = array(), $extra = "", $delete = true, $name_update = "", $id_update = array()){
    $hasil = array();
    if(count($value) > 0){
      $no = 1;
      foreach ($value as $key => $value2) {
        $hasil[] = $this->form_input($name, $value2, $extra);
        $hasil2[] = $this->form_input($name2, $valueinput[$key], $extra).$this->form_hidden($name_update, $id_update[$key]);
        $no++;
      }
    }
    else{
      $hasil[] = $this->form_input($name, "", $extra);
      $hasil2[] = $this->form_input($name2, "", $extra);
    }
    $data = $this->form_addrow_2col($hasil, $hasil2, $link, $table, $body, $nomor, $tr, $delete);
    
    return $data;
  }
  function form_addrow_2col($isi, $isi2, $link, $table, $body, $nomor, $tr, $delete = true){
    $tampil = "";
    foreach($isi as $key => $is){
      $ld = "";
      $sld = "";
      if($delete === true){
        $ld = <<<EOD
        <td><a href='javascript:void();' class='remove-element' onclick='del_row_tambahan("{$tr[$key]}")' title='Remove' >Remove</a></td>
EOD;
        $sld = '$(".delRow").btnDelRow();';
      }
        $tampil .= "
          <tr id='{$tr[$key]}'>
            <td>{$is}</td>
            <td>{$isi2[$key]}</td>
            {$ld}
          </tr>
          ";
    }
     
    $hasil = <<<EOD
    <table id='{$table}'>
      <thead>
        <tr>
          <th>Akun</th>
          <th>Saldo</th>
          <th></th>
        </tr>
      </thead>
      {$tampil}
      <tbody id="{$body}"></tbody>
      <tr>
        <td><a href="javascript:void();" onclick="add_row_tambahan('{$table}','{$link}','{$body}', '{$nomor}')" class="add-element" title="Add">Add</a></td>
      </tr>
    </table>
EOD;
    return $hasil;
  }
  function form_addrow_tr($head, $isi, $link, $table, $id_body, $nomor, $tr, $atr_table = "ass", $delete = true, $add = true, $total = true, $tambah = array()){
    $tampil = "";
    foreach($isi as $key => $is){
      $ld = "";
      $sld = "";
      if($delete === true){
        $ld = <<<EOD
        <td><a href='javascript:void(0)' class='remove-element' onclick='del_row_lokal("{$tr[$key]}")' title='Remove' >Remove</a></td>
EOD;
        $sld = '$(".delRow").btnDelRow();';
      }
      $tampil .= "
      <tr id='{$tr[$key]}'>";
      foreach($is as $isi_tampil){
        $tampil .= "<td valign='top'>{$isi_tampil}</td>";
      }
      $tampil .="
        {$ld}
      </tr>
      ";
    }
    foreach($head as $hd){
      $tampil_head .= "<td><b>{$hd}</b></td>";
    }
     
    $hasil = <<<EOD
    <table id='{$table}' {$atr_table}>
        <tr>
          {$tampil_head}
          <td></td>
        </tr>
      {$tampil}
      <tbody id="{$id_body}"></tbody>
EOD;
    if($add === true){
      $hasil .= <<<EOD
      <tr>
        <td><a href="javascript:void(0)" onclick="add_row_tambahan('{$table}','{$link}','{$id_body}', '{$nomor}')" class="add-element" title="Add">Add</a></td>
      </tr>
EOD;
    }
    if($total === true){
      $hasil .= "
        <tr>
          <td colspan='".(count($head)-1)."' style='text-align: right;'><b>TOTAL</b></td>
          <td><div id='total_utama' style='text-align: right;'></div></td>
        </tr>
        ";
    }
    if($tambah){
      foreach($tambah as $k_tambah => $v_tambah){
        $hasil .= "
          <tr>
            <td colspan='".(count($head)-1)."' style='text-align: right;'><b>{$k_tambah}</b></td>
            <td style='text-align: right;'>{$v_tambah}</td>
          </tr>
          ";
      }
    }
    $hasil .= "</table>";
    return $hasil;
  }
  function form_radio($data = '', $value = '', $checked = FALSE, $extra = ''){
    return form_radio($data, $value, $checked, $extra);
  }
  
  function form_datetime($data, $data_time, $value, $id, $id_time, $extra = '', $tambahan = "", $tambahan2 = ""){
    $time_pisah = explode(" ", $value);
    $hasil = $this->form_input($data, $time_pisah[0], "id='{$id}' readonly ".$extra);
    $hasil .= $this->form_input($data_time, $time_pisah[1], "id='{$id_time}' style='width:40px' readonly ".$extra);
    $hasil .= <<<EOD
    <script>
      $(function() {
        $( "#{$id}" ).datepicker({
          {$tambahan}
          showOtherMonths: true,
          dateFormat: "yy-mm-dd",
          selectOtherMonths: true
        });
        $('#{$id_time}').timepicker({
          {$tambahan2}
          showPeriodLabels: false
        });
      });
    </script>
EOD;
    return $hasil;
  }
  
  function form_time($data_time, $value, $id_time, $extra = '', $tambahan2 = ""){
    $hasil .= $this->form_input($data_time, $value, "id='{$id_time}' style='width:40px' readonly ".$extra);
    $hasil .= <<<EOD
    <script>
      $(function() {
        $('#{$id_time}').timepicker({
          {$tambahan2}
          showPeriodLabels: false
        });
      });
    </script>
EOD;
    return $hasil;
  }
  
}
?>

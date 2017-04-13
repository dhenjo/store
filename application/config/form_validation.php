<?php
$config = array(
  
//  FRM
  
  'frm_simple_transaksi_masuk' => array(
    array(
        'field'   => 'tanggal', 
        'label'   => 'Tanggal dan Waktu', 
        'rules'   => 'required'
     ),
    array(
          'field'   => 'notransaksi', 
          'label'   => 'Nomor Transaksi', 
          'rules'   => 'required'
       ),
    array(
          'field'   => 'debit', 
          'label'   => 'Account Penerimaan', 
          'rules'   => ''
       ),
    array(
          'field'   => 'id_debit', 
          'label'   => 'Account Penerimaan', 
          'rules'   => 'required|integer'
       ),
    array(
          'field'   => 'kredit', 
          'label'   => 'Account Penerimaan Dari', 
          'rules'   => ''
       ),
    array(
          'field'   => 'id_kredit', 
          'label'   => 'Account Penerimaan Dari', 
          'rules'   => 'required|integer'
       ),
    array(
          'field'   => 'saldo', 
          'label'   => 'Nominal', 
          'rules'   => 'required'
       ),
    ),
  
//  END FRM
  
);
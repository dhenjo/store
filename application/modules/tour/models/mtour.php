<?php
class Mtour extends CI_Model {

    function __construct(){
        $this->load->library('PHPExcel');
    }

    function export_finance_report($filename, $pst){
     
      $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("AntaVaya")
							 ->setLastModifiedBy("AntaVaya")
							 ->setTitle("Data Flight Report Transaksi ")
							 ->setSubject("Data Flight Report Transaksi ")
							 ->setDescription("Report Data Transaksi Flight.")
							 ->setKeywords("Report Data Transaksi Flight")
							 ->setCategory("Data Transaksi Flight");

      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A1:AB2');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Report Data Transaksi ');
      $objPHPExcel->getActiveSheet()->getStyle('A1:AB2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A1:AB2')->getFill()->getStartColor()->setARGB('FF808080');
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
      $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
      $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Date');
      $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
      $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No TTU');
      $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
      $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Code');
      $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
      $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Branch');
      $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
      $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Pax Name');
      $objPHPExcel->getActiveSheet()->mergeCells('F4:F5');
      $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Deposit');
      $objPHPExcel->getActiveSheet()->mergeCells('G4:G5');
      $objPHPExcel->getActiveSheet()->setCellValue('H4', '');
      
      $kode_type = array(
        1   => array("id" => "Tunai", "col" => "H"),
        
        3   => array("id" => "Mega", "col" => "I"),
        2   => array("id" => "BCA", "col" => "J"),
        4   => array("id" => "Mandiri", "col" => "K"),
        
        7   => array("id" => "BCA", "col" => "L"),
        14  => array("id" => "Mandiri", "col" => "M"),
        15  => array("id" => "BNI", "col" => "N"),
        
        9   => array("id" => "BCA", "col" => "O"),
        5   => array("id" => "MEGA", "col" => "P"),
        11  => array("id" => "BNI", "col" => "Q"),
        12  => array("id" => "Mandiri", "col" => "R"),
        13  => array("id" => "City Bank", "col" => "S"),
        10  => array("id" => "Lainnya", "col" => "T"),
        
        16  => array("id" => "Travel Certificate", "col" => "U"),
        17  => array("id" => "Travel Voucher", "col" => "V"),
        18  => array("id" => "Voucher CT Corp", "col" => "W"),
        19  => array("id" => "Point Reward", "col" => "X"),
        20  => array("id" => "Kupon", "col" => "Y"),
      );
      foreach($kode_type AS $kt){
        $objPHPExcel->getActiveSheet()->setCellValue($kt['col'].'5', $kt['id']);
      }
      
      $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Transfer');
      $objPHPExcel->getActiveSheet()->mergeCells('I4:K4');
      
      $objPHPExcel->getActiveSheet()->setCellValue('L4', 'Debit');
      $objPHPExcel->getActiveSheet()->mergeCells('L4:N4');
      
      $objPHPExcel->getActiveSheet()->setCellValue('O4', 'Kartu Kredit');
      $objPHPExcel->getActiveSheet()->mergeCells('O4:T4');
      
      $objPHPExcel->getActiveSheet()->setCellValue('U4', 'Others');
      $objPHPExcel->getActiveSheet()->mergeCells('U4:Y4');
      
      $objPHPExcel->getActiveSheet()->setCellValue('Z4', 'Hendle By');
      $objPHPExcel->getActiveSheet()->mergeCells('Z4:Z5');
      $objPHPExcel->getActiveSheet()->setCellValue('AA4', 'Remarks');
      $objPHPExcel->getActiveSheet()->mergeCells('AA4:AA5');
      $objPHPExcel->getActiveSheet()->setCellValue('AB4', 'No Invoice');
      $objPHPExcel->getActiveSheet()->mergeCells('AB4:AB5');
      $objPHPExcel->getActiveSheet()->getStyle('A4:AB5')->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
            ),
            'fill' => array(
              'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
              'startcolor' => array(
                'argb' => 'FFA0A0A0'
              ),
              'endcolor'   => array(
                'argb' => 'FFFFFFFF'
              )
            )
          )
      );
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "awal"                => $pst['awal'],
        "akhir"               => $pst['akhir'],
        "id_tour_pameran"     => $pst['id_tour_pameran'],
        "id_store"            => $pst['id_store'],
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-ttu-get");
      $data_array = json_decode($data);
      
//      print "<pre>";
//      print_r($pst);
//      print_r($data_array);
//      die;
      $no = 1;
      foreach($data_array->data AS $key => $data){
        if($data->nominal > 0){
          $book = explode("|", $data->book);
          $data->type = ($data->type ? $data->type : 1);
          if($kunci[$data->no_ttu]){
            $kunci_nilai[$data->no_ttu][$data->type] += $data->nominal;
            $objPHPExcel->getActiveSheet()->setCellValue($kode_type[$data->type]["col"].$kunci[$data->no_ttu], $kunci_nilai[$data->no_ttu][$data->type]);
          }
          else{
            $kunci[$data->no_ttu] = 5+$no;
            $kunci_nilai[$data->no_ttu][$data->type] += $data->nominal;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.(5+$no), $no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.(5+$no), date("Y-m-d", strtotime($data->tanggal)));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.(5+$no), $data->no_ttu);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.(5+$no), $book[0]);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.(5+$no), $data->store);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.(5+$no), $book[2]." ".$book[3]);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.(5+$no), $data->no_deposit);
            $objPHPExcel->getActiveSheet()->setCellValue($kode_type[$data->type]["col"].(5+$no), $data->nominal);

            $objPHPExcel->getActiveSheet()->setCellValue('Z'.(5+$no), $this->global_models->get_field("m_users", "name", array("id_users" => $data->id_users_confirm)));
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.(5+$no), $data->remark);
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.(5+$no), "");
            $no++;
          }
        }
      }
//      print_r($kunci_nilai);
//      die;
      
//      for($t = 'A' ; $t <= 'AD' ; $t++){
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
//      }
      
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename."-".date("Y-m-d").'.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');

      $objWriter->save('php://output');die;
    }
    
    function export_cashier_report($filename, $pst){
     
      $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("AntaVaya")
							 ->setLastModifiedBy("AntaVaya")
							 ->setTitle("Data Flight Report Transaksi ")
							 ->setSubject("Data Flight Report Transaksi ")
							 ->setDescription("Report Data Transaksi Flight.")
							 ->setKeywords("Report Data Transaksi Flight")
							 ->setCategory("Data Transaksi Flight");

      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A1:K2');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Report Data Transaksi ');
      $objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A1:K2')->getFill()->getStartColor()->setARGB('FF808080');
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
      $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Date');
      $objPHPExcel->getActiveSheet()->setCellValue('C4', 'No TTU');
      $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Code');
      $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Branch');
      $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Type');
      $objPHPExcel->getActiveSheet()->setCellValue('G4', 'Penerima');
      $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Nominal');
      $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Handle By');
      $objPHPExcel->getActiveSheet()->setCellValue('J4', 'Remarks');
      $objPHPExcel->getActiveSheet()->setCellValue('K4', 'Pemesan');
      
      $kode_type = array(
        1   => array("id" => "Tunai", "col" => "H"),
        
        3   => array("id" => "Mega", "col" => "I"),
        2   => array("id" => "BCA", "col" => "J"),
        4   => array("id" => "Mandiri", "col" => "K"),
        
        7   => array("id" => "BCA", "col" => "L"),
        14  => array("id" => "Mandiri", "col" => "M"),
        15  => array("id" => "BNI", "col" => "N"),
        
        9   => array("id" => "BCA", "col" => "O"),
        5   => array("id" => "MEGA", "col" => "P"),
        11  => array("id" => "BNI", "col" => "Q"),
        12  => array("id" => "Mandiri", "col" => "R"),
        13  => array("id" => "City Bank", "col" => "S"),
        10  => array("id" => "Lainnya", "col" => "T"),
        
        16  => array("id" => "Travel Certificate", "col" => "U"),
        17  => array("id" => "Travel Voucher", "col" => "V"),
        18  => array("id" => "Voucher CT Corp", "col" => "W"),
        19  => array("id" => "Point Reward", "col" => "X"),
        20  => array("id" => "Kupon", "col" => "Y"),
        
        21  => array("id" => "Mega First Infinite", "col" => "Y"),
      );
//      foreach($kode_type AS $kt){
//        $objPHPExcel->getActiveSheet()->setCellValue($kt['col'].'5', $kt['id']);
//      }
      
//      $objPHPExcel->getActiveSheet()->setCellValue('I4', 'Transfer');
//      $objPHPExcel->getActiveSheet()->mergeCells('I4:K4');
//      
//      $objPHPExcel->getActiveSheet()->setCellValue('L4', 'Debit');
//      $objPHPExcel->getActiveSheet()->mergeCells('L4:N4');
//      
//      $objPHPExcel->getActiveSheet()->setCellValue('O4', 'Kartu Kredit');
//      $objPHPExcel->getActiveSheet()->mergeCells('O4:T4');
//      
//      $objPHPExcel->getActiveSheet()->setCellValue('U4', 'Others');
//      $objPHPExcel->getActiveSheet()->mergeCells('U4:Y4');
//      
//      $objPHPExcel->getActiveSheet()->setCellValue('Z4', 'Hendle By');
//      $objPHPExcel->getActiveSheet()->mergeCells('Z4:Z5');
//      $objPHPExcel->getActiveSheet()->setCellValue('AA4', 'Remarks');
//      $objPHPExcel->getActiveSheet()->mergeCells('AA4:AA5');
//      $objPHPExcel->getActiveSheet()->setCellValue('AB4', 'No Invoice');
//      $objPHPExcel->getActiveSheet()->mergeCells('AB4:AB5');
      $objPHPExcel->getActiveSheet()->getStyle('A4:K4')->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
              'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
              'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
              ),
            ),
            'fill' => array(
              'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation'   => 90,
              'startcolor' => array(
                'argb' => 'FFA0A0A0'
              ),
              'endcolor'   => array(
                'argb' => 'FFFFFFFF'
              )
            )
          )
      );
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "awal"                => $pst['awal'],
        "akhir"               => $pst['akhir'],
        "id_tour_pameran"     => $pst['id_tour_pameran'],
        "id_store"            => $pst['id_store'],
        "type"                => $pst['type'],
        "jenis"               => $pst['jenis'],
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cashier-get");
      $data_array = json_decode($data);
      
//      print "<pre>";
//      print_r($pst);
//      print_r($data_array);
//      die;
      
      $kode_type = $this->global_variable->payment_type();
      $jenis = array(
        1 => "Tiket",
        2 => "Hotel",
        3 => "Tour",
        4 => "Umroh",
        5 => "Transport" 
      );
      
      $no = 1;
      foreach($data_array->data AS $key => $data){
        if($data->nominal > 0){
            
            if($data->pemesan){
                $pemesan = $data->pemesan;
            }else{
                $pemesan = $data->book_pemesan;
            }
          $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$no), $no);
          $objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$no), date("Y-m-d", strtotime($data->tanggal)));
          $objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$no), $data->no_ttu);
          $objPHPExcel->getActiveSheet()->setCellValue('D'.(4+$no), $data->inventory.$data->tour);
          $objPHPExcel->getActiveSheet()->setCellValue('E'.(4+$no), $data->store);
          $objPHPExcel->getActiveSheet()->setCellValue('F'.(4+$no), $jenis[$data->jenis]);
          $objPHPExcel->getActiveSheet()->setCellValue('G'.(4+$no), $kode_type[$data->type]);
          $objPHPExcel->getActiveSheet()->setCellValue('H'.(4+$no), $data->nominal);
          $objPHPExcel->getActiveSheet()->setCellValue('I'.(4+$no), $this->global_models->get_field("m_users", "name", array("id_users" => $data->id_users_confirm)));
          $objPHPExcel->getActiveSheet()->setCellValue('J'.(4+$no), "'".$data->number);
          $objPHPExcel->getActiveSheet()->setCellValue('K'.(4+$no), $pemesan);
          $jumlah[$data->type] += $data->nominal;
          
          $no++;
        }
      }
      $objPHPExcel->getActiveSheet()->getStyle('H'.(5).':H'.(4+$no))->getNumberFormat()->setFormatCode('#,###');
//      print_r($kunci_nilai);
//      die;
      
      $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$no+3), 'Penerima');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.(4+$no+3).':B'.(4+$no+3));
      $objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$no+3), 'Total');
      $r = 1;
      foreach ($jumlah AS $kjml => $jml){
        $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$no+3+$r), $kode_type[$kjml]);
        $objPHPExcel->getActiveSheet()->mergeCells('A'.(4+$no+3+$r).':B'.(4+$no+3+$r));
        $objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$no+3+$r), $jml);
        $total += $jml;
        $r++;
      }
      
      $objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$no+3+$r), 'TOTAL');
      $objPHPExcel->getActiveSheet()->mergeCells('A'.(4+$no+3+$r).':B'.(4+$no+3+$r));
      $objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$no+3+$r), $total);
      $objPHPExcel->getActiveSheet()->getStyle('C'.(4+$no+4).':C'.(4+$no+3+$r))->getNumberFormat()->setFormatCode('#,###');
      
      $objPHPExcel->getActiveSheet()->getStyle('A'.(4+$no+3).':C'.(4+$no+3))->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
          )
      );
      $objPHPExcel->getActiveSheet()->getStyle('A'.(4+$no+3+$r).':C'.(4+$no+3+$r))->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
          )
      );
      
//      for($t = 'A' ; $t <= 'AD' ; $t++){
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
//      }
      
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename."-".date("Y-m-d").'.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');

      $objWriter->save('php://output');die;
    }
    
}
?>

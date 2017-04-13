<?php
class Mproduct_tour extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('PHPExcel');
    }

    function export_xls($filename,$data){
      
      $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("AntaVaya")
							 ->setLastModifiedBy("AntaVaya")
							 ->setTitle("Report Payment AntaVaya ")
							 ->setSubject("Report Payment AntaVaya ")
							 ->setDescription("Report Payment AntaVaya")
							 ->setKeywords("Report Payment AntaVaya")
							 ->setCategory("Report Payment AntaVaya");

      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A1:H3');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Report Payment Agent AntaVaya ');
      $objPHPExcel->getActiveSheet()->getStyle('A1:H3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
  
//      $objPHPExcel->getActiveSheet()->getStyle('A1:V2')->getFill()->getStartColor()->setARGB('FF808080');
      $objPHPExcel->getActiveSheet()->getStyle('A1:H3')->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true,
               'size'  => 21,
              'name'  => 'Verdana'
              
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
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $objPHPExcel->getActiveSheet()->setCellValue('A5', 'No');
      $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Date');
      $objPHPExcel->getActiveSheet()->setCellValue('C5', 'Book Code');
      $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Name');
      $objPHPExcel->getActiveSheet()->setCellValue('E5', 'Status');
      $objPHPExcel->getActiveSheet()->setCellValue('F5', 'Payment Type');
      $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Currency');
      $objPHPExcel->getActiveSheet()->setCellValue('H5', 'Nominal IDR');
      $objPHPExcel->getActiveSheet()->freezePane('A6');
      $objPHPExcel->getActiveSheet()->getStyle('A5:H5')->applyFromArray(
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
      
//      $data1 = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/report-payment");  
//      $data_array = json_decode($data1);
//      print $where;
//      print "<pre>";
//      print_r($data); 
//      print "</pre>";
//      die;
//      if(is_array($data)){
        $no = 1;
        foreach ($data->book as $key => $value) {

           
           if($value->currency == "IDR"){
            $nom_idr = $value->nominal;
            $nom_idr_tot += $value->nominal;
           
          }elseif($value->currency == "USD"){
            $nom_usd = $value->nominal;
            $nom_usd_tot += $value->nominal;
            
          }
          if($nom_idr_tot){
            $nom_idr_tot = $nom_idr_tot;
          }else{
            $nom_idr_tot = 0;
          }
           if($nom_idr){
              $nom_idr = $nom_idr;
            }else{
              $nom_idr =0;
            }
            
            if($nom_usd_tot){
              $nom_usd_tot = $nom_usd_tot;
            }else{
              $nom_usd_tot = 0;
            }
            if($nom_usd){
              $nom_usd = $nom_usd;
            }else{
              $nom_usd=0;
            }
             
            $objPHPExcel->getActiveSheet()->setCellValue('A'.(6+$key),$no++);
              $objPHPExcel->getActiveSheet()->setCellValue('B'.(6+$key),date("Y-m-d H:i:s", strtotime($value->tanggal)));
              $objPHPExcel->getActiveSheet()->setCellValue('C'.(6+$key),$value->book_code);
              $objPHPExcel->getActiveSheet()->setCellValue('D'.(6+$key),$value->name);
              $objPHPExcel->getActiveSheet()->setCellValue('E'.(6+$key),$value->status);
              $objPHPExcel->getActiveSheet()->setCellValue('F'.(6+$key),$value->payment_type);
              $objPHPExcel->getActiveSheet()->setCellValue('G'.(6+$key),$value->currency);
             // $objPHPExcel->getActiveSheet()->setCellValue('H'.(6+$key),$nom_usd);
             // $objPHPExcel->getActiveSheet()->getStyle('H'.(6+$key))->getNumberFormat()->setFormatCode('#,##0');
              $objPHPExcel->getActiveSheet()->setCellValue('H'.(6+$key),$nom_idr);
              $objPHPExcel->getActiveSheet()->getStyle('H'.(6+$key))->getNumberFormat()->setFormatCode('#,##0');
             
           }
        $jml =5+$no;
        $ak = "A".$jml.":G".$jml;
        $akj = "H".$jml.":I".$jml;
      
      $objPHPExcel->getActiveSheet()->mergeCells($ak);
      $objPHPExcel->getActiveSheet()->setCellValue('A'.($jml),'TOTAL ');
    //  $objPHPExcel->getActiveSheet()->setCellValue('H'.($jml),$nom_usd_tot);
     // $objPHPExcel->getActiveSheet()->getStyle('H'.($jml))->getNumberFormat()->setFormatCode('#,##0');
      $objPHPExcel->getActiveSheet()->setCellValue('H'.($jml),$nom_idr_tot);
      $objPHPExcel->getActiveSheet()->getStyle('H'.($jml))->getNumberFormat()->setFormatCode('#,##0');
      
      $objPHPExcel->getActiveSheet()->getStyle($ak)->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
          )
      ); 
      $objPHPExcel->getActiveSheet()->getStyle($akj)->applyFromArray(
          array(
            'font'    => array(
              'bold'      => true
            ),
            
          )
      );
      
//      }
      
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    //  $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      //$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(50);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
      
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename."-".date("Y-m-d").'.xls"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
      $objWriter->save('php://output');die;
    }
    
}
?>

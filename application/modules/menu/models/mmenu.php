<?php
class Mmenu extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function insert_user($kirim){
      $this->db->insert('m_users', $kirim);
      return $this->db->insert_id();
    }
    function update_user($id, $kirim){
      $this->db->where("id_users", $id);
      return $this->db->update("m_users", $kirim);
    }
    function get_detail($id){
      $this->db->where("id_users", $id);
      return $this->db->get("m_users")->row();
    }
    function change_status($id, $status){
      $this->db->where("id_users", $id);
      if($status == 1)
        $kirim['id_status_user'] = 2;
      else if($status == 2)
        $kirim['id_status_user'] = 1;
      else
        $kirim['id_status_user'] = $status;
      return $this->db->update("m_users", $kirim);
    }
    function get(){
      $this->db->select("m_menu.*, m_menu_kategori.name as kategori");
      $this->db->join("m_menu_kategori", "m_menu.id_menu_kategori = m_menu_kategori.id_menu_kategori","left");
      $data = $this->db->get("m_menu")->result();
      return $data;
    }
    function export_xls($filename){
      $objPHPExcel = $this->phpexcel;
      $objPHPExcel->getProperties()->setCreator("Mr Montir")
							 ->setLastModifiedBy("Mr Montir")
							 ->setTitle("Users Data")
							 ->setSubject("Users Data")
							 ->setDescription("Report users data.")
							 ->setKeywords("report users data")
							 ->setCategory("Users");

      $objPHPExcel->setActiveSheetIndex(0);
      
      $objPHPExcel->getActiveSheet()->mergeCells('A1:C2');
      $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Data Users');
      $objPHPExcel->getActiveSheet()->getStyle('A1:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
      $objPHPExcel->getActiveSheet()->getStyle('A1:C2')->getFill()->getStartColor()->setARGB('FF808080');
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Name');
      $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Email');
      $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Status');
      $objPHPExcel->getActiveSheet()->getStyle('A4:C4')->applyFromArray(
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
      
      $data = $this->get();
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $objPHPExcel->getActiveSheet()->setCellValue('A'.(5+$key), $value->name);
          $objPHPExcel->getActiveSheet()->setCellValue('B'.(5+$key), $value->email);
          $objPHPExcel->getActiveSheet()->setCellValue('C'.(5+$key), $value->status);
        }
      }
      $objPHPExcel->getActiveSheet()->getStyle('A5:C'.(5+$key))->applyFromArray(
          array(
            'font'    => array(
              'bold'      => false
            ),
            'alignment' => array(
              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
            'borders' => array(
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
      $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(30);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(50);
//      $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
      
      $objPHPExcel->setActiveSheetIndex(0);
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename."-".date("Y m d").'"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
      $objWriter->save('php://output');die;
    }
}
?>

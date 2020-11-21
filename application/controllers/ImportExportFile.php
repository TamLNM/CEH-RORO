<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
    // construct
    public function __construct() {
        parent::__construct();
        // load model
        $this->load->model('common_model', 'common');
    }    
     // export xlsx|xls file
    public function index() {
        $data['page'] = 'export-excel';
        $data['title'] = 'Export Excel data | TechArise';
        $data['employeeInfo'] = $this->common->getCusList();
        
        // Load view file for output
        $this->load->view('customer', $data);
    }

    // create xlsx
    public function createXLS() {
        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        $cusInfo = $this->common->getCusList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Loại khách');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mã khách hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Tên khách hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã số thuế');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Điện thoại');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Fax');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Địa chỉ');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Kích hoạt');       
        
        // Set Row
        $rowCount = 2;
        foreach ($cusInfo as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['CusTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['CusName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['TaxCode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['Tel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['Fax']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Địa chỉ']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Kích hoạt']);
            $rowCount++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(ROOT_UPLOAD_IMPORT_PATH.$fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(HTTP_UPLOAD_IMPORT_PATH.$fileName);        
    }
    
}
?>
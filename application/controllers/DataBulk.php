<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataBulk extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("data_model", "mdlData");
        $this->load->model("data_bulk_model", "mdlDataBulk");
        $this->load->model("user_model", "user");
        $this->load->library('excel');
        $this->ceh = $this->load->database('mssql', TRUE);        
        $this->data['menus'] = $this->menu->getMenu();
        $this->data['parentMenuList'] = $this->menu->getParentMenu();
    }

    public function _remap($method) {
        $methods = get_class_methods($this);

        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = array();

        if(($method == 'index')) {
            $method = md5('index');
        }

        foreach($methods as $smethod) {
            if (!in_array($smethod, $skip)) {
                $a_methods[] = md5($smethod);
                if($method == md5($smethod)) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if(!in_array($method, $a_methods)) {
            show_404();
        }
    }

    public function dtBulkManifest()
    {
        $access = $this->user->access('dtBulkManifest');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $VoyageKey          = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $IsLocalForeign     = $this->input->post('IsLocalForeign') ? $this->input->post('IsLocalForeign') : '';
            $ClassID            = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';
            $this->data['list'] = $this->mdlDataBulk->loadAllColForBulkManifestScreen($VoyageKey, $IsLocalForeign, $ClassID);
            echo json_encode($this->data);
            exit;
        }

        if ($action == 'add'){
            
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'addStockBulk'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockBulk($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addQuayBulkInJob'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveJobQuayForBulkIn($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
            
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlDataBulk->saveBulkManifest($saveData, $VoyageKey);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
            
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlDataBulk->updateBulkManifest($saveData, $VoyageKey);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
            
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlDataBulk->deleteBulkManifest($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = 'Nhập liệu - Hàng rời';
        $this->load->view('header', $this->data);
        $this->data['methodList'] = $this->mdlData->loadMethodListForStockScreen();
        $this->data['jobModeList'] = $this->mdlData->loadJobModeListForStockScreen();
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->data['unitList'] = $this->mdlCommon->loadUnitCodes();
        $this->data['cargoTypeList'] = $this->mdlCommon->loadCargoTypeList();
        $this->load->view('data_bulk/bulk_manifest', $this->data);
        $this->load->view('footer');
    }

    public function dtBulkGetIn()
    {
        $access = $this->user->access('dtBulkGetIn');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'loadStockBulkList'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $IsLocalForeign = $this->input->post('IsLocalForeign') ? $this->input->post('IsLocalForeign') : '';
                $ClassID = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';

                $this->data['list'] = $this->mdlDataBulk->loadStockBulkList($VoyageKey, $IsLocalForeign, $ClassID);
                echo json_encode($this->data);
                exit;
            }
            
            if ($child_action == 'loadStockInBulkList'){
                $StockRef = $this->input->post('StockRef') ? $this->input->post('StockRef') : '';
                
                $this->data['list'] = $this->mdlDataBulk->loadStockBulkInList($StockRef);
                echo json_encode($this->data);
                exit;
            }   
        }

        $this->data['title'] = 'Hàng rời Get-In';
        $this->load->view('header', $this->data);
        $this->load->view('data_bulk/bulk_get_in', $this->data);
        $this->load->view('footer');
    }

    public function dtBulkGetOut()
    {
        $access = $this->user->access('dtBulkGetOut');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'loadStockBulkList'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $IsLocalForeign = $this->input->post('IsLocalForeign') ? $this->input->post('IsLocalForeign') : '';
                $ClassID = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';

                $this->data['list'] = $this->mdlDataBulk->loadStockBulkList($VoyageKey, $IsLocalForeign, $ClassID);
                echo json_encode($this->data);
                exit;
            }
            
            if ($child_action == 'loadStockOutBulkList'){
                $StockRef = $this->input->post('StockRef') ? $this->input->post('StockRef') : '';
                
                $this->data['list'] = $this->mdlDataBulk->loadStockBulkOutList($StockRef);
                echo json_encode($this->data);
                exit;
            }   
        }

        $this->data['title'] = 'Hàng rời Get-Out';
        $this->load->view('header', $this->data);
        $this->load->view('data_bulk/bulk_get_out', $this->data);
        $this->load->view('footer');
    }

    // Create xlsx form for export
    public function createXLSFormForManifestImportForClassIn() {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $jobModeList = $this->mdlData->loadJobModeListForStockScreen();
        $methodList  = $this->mdlData->loadMethodListForStockScreen();
        $unitList    = $this->mdlCommon->loadUnitCodes();

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã phương án (xem ở cột L - N)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương thức (xem ở cột Q - S)');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Trọng lượng hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Đơn vị tính (xem ở cột U - W)');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mô tả'); 

        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Mã đơn vị');   
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Tên đơn vị');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($unitList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['UnitID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['UnitName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':X'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'X'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:X100')->getAlignment()->setWrapText(true); 

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);
        }

        // Set list box for Method
        $methodArr = '';
        foreach ($methodList as $item) {
            $methodArr .= ($item['MethodID'].",");
        }
        rtrim($methodArr, 'end');
        $methodArr = '"'.$methodArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);
        }

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);
        }

        /* Auto fill index */
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '1' . ', "")');
        }

        /* Create excel file */
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSFormForManifestImportForClassOut() {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $jobModeList = $this->mdlData->loadJobModeListForStockScreen();
        $methodList  = $this->mdlData->loadMethodListForStockScreen();
        $unitList    = $this->mdlCommon->loadUnitCodes();

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã phương án (xem ở cột L - N)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương thức (xem ở cột Q - S)');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Trọng lượng hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Đơn vị tính (xem ở cột U - W)');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mô tả'); 

        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Mã đơn vị');   
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Tên đơn vị');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($unitList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['UnitID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['UnitName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':X'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'X'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:X100')->getAlignment()->setWrapText(true); 

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);
        }

        // Set list box for Method
        $methodArr = '';
        foreach ($methodList as $item) {
            $methodArr .= ($item['MethodID'].",");
        }
        rtrim($methodArr, 'end');
        $methodArr = '"'.$methodArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);
        }

        // Set list box for Unit
        $unitArr = '';
        foreach ($unitList as $item) {
            $unitArr .= ($item['UnitID'].",");
        }
        rtrim($unitArr, 'end');
        $unitArr = '"'.$unitArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($unitArr);
        }

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
            $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"Item A,Item B,Item C"');
        }

        /* Auto fill index */
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '2' . ', "")');
        }

        /* Create excel file */
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    /* Bulk manifest export */
    public function createXLSForManifestExportWithClassIn() {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $jobModeList = $this->mdlData->loadJobModeListForStockScreen();
        $methodList  = $this->mdlData->loadMethodListForStockScreen();
        $unitList    = $this->mdlCommon->loadUnitCodes();
        $manifestInfo = $this->mdlDataBulk->loadAllColForBulkManifestScreen('', '', '');

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã phương án');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương thức');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Trọng lượng hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Đơn vị tính');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Nhập/ xuất tàu');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Hàng nội/ ngoại'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mô tả'); 

        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Mã đơn vị');   
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Tên đơn vị');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($unitList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['UnitID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['UnitName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':X'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'X'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:X100')->getAlignment()->setWrapText(true); 

        $rowCount = 2;
        $VoyageKey   = trim($this->uri->segment(3));
        foreach ($manifestInfo as $element) {
            if (($element['ClassID'] == 1) && ($element['VoyageKey'] == $VoyageKey)){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BookingNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['JobModeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['MethodID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['CargoWeight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['UnitName']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Sequence']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['CommodityDescription']);
                $rowCount++; 
            }            
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSForManifestExportWithClassOut() {
        $this->load->library('excel');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $jobModeList = $this->mdlData->loadJobModeListForStockScreen();
        $methodList  = $this->mdlData->loadMethodListForStockScreen();
        $unitList    = $this->mdlCommon->loadUnitCodes();
        $manifestInfo = $this->mdlDataBulk->loadAllColForBulkManifestScreen('', '', '');

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã phương án');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương thức');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Trọng lượng hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Đơn vị tính');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Nhập/ xuất tàu');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Hàng nội/ ngoại'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Mô tả'); 

        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Mã đơn vị');   
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Tên đơn vị');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($unitList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['UnitID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['UnitName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:X1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );

        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':X'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'X'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:X100')->getAlignment()->setWrapText(true); 

        $VoyageKey   = trim($this->uri->segment(3));
        $rowCount = 2;
        foreach ($manifestInfo as $element) {
            if (($element['ClassID'] == 2) && ($element['VoyageKey'] == $VoyageKey)){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BookingNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['JobModeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['MethodID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['CargoWeight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['UnitName']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Sequence']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['CommodityDescription']);
                $rowCount++; 
            }            
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}

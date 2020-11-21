<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("data_model", "mdlData");
        $this->load->model("common_model", "mdlCommon");
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

    public function dtStock()
    {
        $access = $this->user->access('dtStock');
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
            $childAction =  $this->input->post('childAction') ? $this->input->post('childAction') : '';

            if ($childAction == 'loadVesselFilterList'){
                $VBType     = $this->input->post('VBType') ? $this->input->post('VBType') : '';
                $VesselName = $this->input->post('VesselName') ? $this->input->post('VesselName') : '';
                $Year       = $this->input->post('Year') ? $this->input->post('Year') : '';
                $this->data['list'] = $this->mdlData->loadVesselListForManifestScreen($VBType, $VesselName, $Year);
                echo json_encode($this->data);
                exit;
            }
            
            if ($childAction == 'loadPortByLane'){
                $InLane     = $this->input->post('InLane') ? $this->input->post('InLane') : '';
                $OutLane    = $this->input->post('OutLane') ? $this->input->post('OutLane') : '';
                $this->data['list']     = $this->mdlData->loadPortByLane($InLane, $OutLane);
                echo json_encode($this->data);
                exit;
            }

            if ($childAction = 'loadStockList'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $this->data['list'] = $this->mdlData->loadAllColForStockScreen($VoyageKey, '', '', '', 1);
                echo json_encode($this->data);
                exit;
            }
            
            $VoyageKey                  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            //$VINNo                      = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
            //$BillOfLadingORBookingNo    = $this->input->post('BillOfLadingORBookingNo') ? $this->input->post('BillOfLadingORBookingNo') : '';
            $IsLocalForeign             = $this->input->post('IsLocalForeign');
            $ClassID                    = $this->input->post('ClassID');
            $this->data['list']         = $this->mdlData->loadAllColForStockScreen($VoyageKey, /*$VINNo*/'', /*$BillOfLadingORBookingNo*/ '', $IsLocalForeign, $ClassID);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $childAction =  $this->input->post('childAction') ? $this->input->post('childAction') : '';

            if ($childAction == 'addJobQuay'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlData->saveJobQuay($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($childAction = 'updateStockData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlData->updateStockData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlData->saveStock($saveData, $VoyageKey /*, $dateIn, $dateOut */    );
                echo json_encode($this->data);
                exit;
            }
        }
        
        if($action == 'delete')
        {
            $delData = $this->input->post('data') ? $this->input->post('data') : array();            
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlData->deleteStock($delData);
                echo json_encode($this->data['result']);
                exit();
            }
        }

        $this->data['title'] = 'Giám sát hàng biến động';
        $this->load->view('header', $this->data);
        $this->data['vesselList'] = $this->mdlData->loadVesselListForStockScreen();
        $this->data['unitList'] = $this->mdlData->loadUnitListForStockScreen();
        $this->data['customerList'] = $this->mdlData->loadCustomerListForStockScreen();
        $this->data['methodList'] = $this->mdlData->loadMethodListForStockScreen();
        $this->data['jobModeList'] = $this->mdlData->loadJobModeListForStockScreen();
        $this->data['vmStatusList'] = $this->mdlCommon->loadVMStatusList();
        $this->data['portList'] = $this->mdlData->loadPortListForStockScreen();
        $this->data['stockList'] = $this->mdlData->loadAllColForStockScreen('', '', '', '', '');
        $this->data['transitList'] = $this->mdlCommon->loadTransitList();
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->load->view('data/stock', $this->data);
        $this->load->view('footer');
    }

    public function dtManifest()
    {
        $access = $this->user->access('dtManifest');
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
            $childAction =  $this->input->post('childAction') ? $this->input->post('childAction') : '';

            if ($childAction == 'loadVesselFilterList'){
                $VBType     = $this->input->post('VBType') ? $this->input->post('VBType') : '';
                $VesselName = $this->input->post('VesselName') ? $this->input->post('VesselName') : '';
                $Year       = $this->input->post('Year') ? $this->input->post('Year') : '';
                $VIType       = $this->input->post('VIType') ? $this->input->post('VIType') : '';

                $this->data['list'] = $this->mdlData->loadVesselListForManifestScreen($VBType, $VesselName, $Year,$VIType);
                echo json_encode($this->data);
                exit;
            }


            if ($childAction == 'loadManifestList'){
                $VoyageKey              = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $this->data['list']     = $this->mdlData->loadAllColForManifestScreen($VoyageKey, '', '');
                echo json_encode($this->data);
                exit;
            }

            if ($childAction == 'loadPortByLane'){
                $InLane     = $this->input->post('InLane') ? $this->input->post('InLane') : '';
                $OutLane    = $this->input->post('OutLane') ? $this->input->post('OutLane') : '';
                $this->data['list']     = $this->mdlData->loadPortByLane($InLane, $OutLane);
                echo json_encode($this->data);
                exit;
            }

            $VoyageKey                  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $IsLocalForeign             = $this->input->post('IsLocalForeign') ? $this->input->post('IsLocalForeign') : '';
            $ClassID                    = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';
            $this->data['list']         = $this->mdlData->loadAllColForManifestScreen($VoyageKey, $IsLocalForeign, $ClassID);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $childAction =  $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($childAction == 'add_stock'){
                $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlData->saveStock($saveData, $VoyageKey);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($childAction == 'add_job_quay'){
                $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlData->saveJobQuay($saveData, $VoyageKey);
                    echo json_encode($this->data);
                    exit;
                }
            }


            $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlData->saveManifest($saveData, $VoyageKey);
                echo json_encode($this->data);
                exit;
            }
        }


        if($action == 'delete')
        {
            $delData = $this->input->post('data') ? $this->input->post('data') : array();

            /*
            $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : array();
            $BillOfLading = $this->input->post('BillOfLading') ? $this->input->post('BillOfLading') : array();
            $BookingNo = $this->input->post('BookingNo') ? $this->input->post('BookingNo') : array();
            $VINNo = $this->input->post('VINNo') ? $this->input->post('VINNo') : array();
            */
            
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlData->deleteManifest($delData);
                echo json_encode($this->data['result']);
                exit();
            }
        }

        $this->data['title'] = 'Hàng nhập - Manifest';
        $this->load->view('header', $this->data);
        $this->data['vesselList'] = $this->mdlData->loadVesselListForStockScreen();
        $this->data['methodList'] = $this->mdlData->loadMethodListForStockScreen();
        $this->data['jobModeList'] = $this->mdlData->loadJobModeListForStockScreen();
        $this->data['jobModeListHasIsVessel'] = $this->mdlData->loadJobModeListHasIsVessel();
        $this->data['brandList'] = $this->mdlData->loadBrandListForManifestScreen();
        $this->data['carTypeList'] = $this->mdlData->loadCarTypeListForManifestScreen();
        $this->data['portList'] = $this->mdlData->loadPortListForStockScreen();
        //$this->data['manifestImportList'] = $this->mdlData->loadAllColForManifestScreen()
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->load->view('data/manifest', $this->data);
        $this->load->view('footer');
    }

    // create xlsx for export
    public function createXLSForManifestExportWithClassIn() {
        // create file name
        //$fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $manifestInfo   = $this->mdlData->loadAllColForManifestScreen('', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $brandList      = $this->mdlData->loadBrandListForManifestScreen();
        $carTypeList    = $this->mdlData->loadCarTypeListForManifestScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương án'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã phương thức');           
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cảng xếp');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Cảng dỡ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Cảng đích');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Nhập/ xuất tàu');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hàng nội/ ngoại');          
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Trọng lượng (kg)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã hãng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã loại xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Loại động cơ');       
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Sequence');        
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case No');      
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Model Name');    
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Chassic number');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Engine Serial'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Màu xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Interier');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Option');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số Von');   
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Mã chìa khóa');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Ghi chú');     
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Mã hãng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Tên hãng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Mã loại xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Tên loại');
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Loại động cơ');

        $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Tên cảng');    
        
        // set Row
        $rowCount = 2;
        foreach ($manifestInfo as $element) {
            if ($element['ClassID'] == 1){
               $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BillOfLading']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['VINNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['JobModeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['MethodID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['POL']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['POD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['FPOD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['CarWeight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['BrandID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['CarTypeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['EngineType']);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['Sequence']);           
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['CaseNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['ModelName']);
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['ChassisNumber']);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['EngineSerial']);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['BodyColor']);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['Interier']);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['Option']);
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['VonNo']);            
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['KeyNo']);            
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['Remark']); 
                $rowCount++; 
            }            
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($brandList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $element['BrandID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $element['BrandName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($carTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $rowCount, $element['CarTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $element['CarTypeName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['EngineType']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AU1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AU'.$i)->applyFromArray($style);
        }     

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AU100')->getAlignment()->setWrapText(true);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSForManifestExportWithClassOut() {
        // create file name
        //$fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $manifestInfo   = $this->mdlData->loadAllColForManifestScreen('', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $brandList      = $this->mdlData->loadBrandListForManifestScreen();
        $carTypeList    = $this->mdlData->loadCarTypeListForManifestScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương án'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã phương thức');           
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cảng xếp');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Cảng dỡ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Cảng đích');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Nhập/ xuất tàu');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hàng nội/ ngoại');          
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Trọng lượng (kg)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã hãng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã loại xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Loại động cơ');       
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Sequence');        
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case No');      
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Model Name');    
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Chassic number');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Engine Serial'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Màu xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Interier');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Option');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số Von');   
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Mã chìa khóa');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Ghi chú');     
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Mã hãng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Tên hãng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Mã loại xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Tên loại');
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Loại động cơ');

        $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Tên cảng');    
        
        // set Row
        $rowCount = 2;
        foreach ($manifestInfo as $element) {
            if ($element['ClassID'] == 2){
               $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BookingNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['VINNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['JobModeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['MethodID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['POL']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['POD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['FPOD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['CarWeight']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['BrandID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['CarTypeID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['EngineType']);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['Sequence']);           
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['CaseNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['ModelName']);
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['ChassisNumber']);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['EngineSerial']);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['BodyColor']);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['Interier']);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['Option']);
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['VonNo']);            
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['KeyNo']);            
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['Remark']); 
                $rowCount++; 
            }            
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($brandList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $element['BrandID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $element['BrandName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($carTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $rowCount, $element['CarTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $element['CarTypeName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['EngineType']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AU1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AU'.$i)->applyFromArray($style);
        }     

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AU100')->getAlignment()->setWrapText(true);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    // create xlsx for export
    public function createXLSFormForManifestImportForClassIn() {
        // create file name
        //$fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        $manifestInfo = $this->mdlData->loadAllColForManifestScreen('', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $brandList      = $this->mdlData->loadBrandListForManifestScreen();
        $carTypeList    = $this->mdlData->loadCarTypeListForManifestScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');     
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương án (xem ở cột AB - AD)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã phương thức (xem ở cột AF - AH)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cảng xếp');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Cảng dở');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Cảng đích');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Trọng lượng (kg)');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã hãng xe (xem ở cột AJ - AL)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã loại xe (xem ở cột AN - AQ)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Loại động cơ (xem ở cột AN - AQ)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case No');      
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Model Name');    
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Chassic number');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Engine Serial'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Màu xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Interier');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Option');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số Von');           
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Mã chìa khóa');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Ghi chú'); 
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Mã hãng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Tên hãng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Mã loại xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Tên loại');
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Loại động cơ');

        $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Tên cảng');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($brandList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $element['BrandID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $element['BrandName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($carTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $rowCount, $element['CarTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $element['CarTypeName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['EngineType']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AU1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AU'.$i)->applyFromArray($style);
        }     

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AU100')->getAlignment()->setWrapText(true); 

        // Set list box for Port Modes
        $portArr = '';
        foreach ($portList as $item) {
            $portArr .= ($item['PortID'].",");
        }
        rtrim($portArr, 'end');
        $portArr = '"'.$portArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);
        }

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
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
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);
        }

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);
        }

        // Set list box for Brand
        $brandArr = '';
        foreach ($brandList as $item) {
            $brandArr .= ($item['BrandID'].",");
        }
        rtrim($brandArr, 'end');
        $brandArr = '"'.$brandArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($brandArr);
        }

        // Set list box for Car Type
        $carTypeArr = '';
        foreach ($carTypeList as $item) {
            $carTypeArr .= ($item['CarTypeID'].",");
        }
        rtrim($carTypeArr, 'end');
        $carTypeArr = '"'.$carTypeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($carTypeArr);
        }

        // Auto fill data
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $i, '=IF(M'.$i.'<>"",VLOOKUP(M'.$i.',$AO$1:$AQ$100,3,1), "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
             $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '"NTAU"' . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '"TAU-BAI"' . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '1' . ', "")');
        }

        /* Create excel file */
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSFormForManifestImportForClassOut() {
        // create file name
        //$fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        $manifestInfo = $this->mdlData->loadAllColForManifestScreen('', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $brandList      = $this->mdlData->loadBrandListForManifestScreen();
        $carTypeList    = $this->mdlData->loadCarTypeListForManifestScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');     
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');     
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Mã phương án (xem ở cột AB - AD)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã phương thức (xem ở cột AF - AH)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cảng xếp');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Cảng dở');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Cảng đích');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Trọng lượng (kg)');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã hãng xe (xem ở cột AJ - AL)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã loại xe (xem ở cột AN - AQ)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Loại động cơ (xem ở cột AN - AQ)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Sequence'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Case No');      
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Model Name');    
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Chassic number');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Engine Serial'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Màu xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Interier');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Option');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số Von');           
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Mã chìa khóa');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Ghi chú'); 
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Mã hãng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'Tên hãng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Mã loại xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Tên loại');
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Loại động cơ');

        $objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Tên cảng');

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($brandList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $element['BrandID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $element['BrandName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($carTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . $rowCount, $element['CarTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $element['CarTypeName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['EngineType']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AS' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AU1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AU'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AU100')->getAlignment()->setWrapText(true); 

        // Set list box for Port Modes
        $portArr = '';
        foreach ($portList as $item) {
            $portArr .= ($item['PortID'].",");
        }
        rtrim($portArr, 'end');
        $portArr = '"'.$portArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);
        }

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
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
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);
        }

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);
        }

        // Set list box for Brand
        $brandArr = '';
        foreach ($brandList as $item) {
            $brandArr .= ($item['BrandID'].",");
        }
        rtrim($brandArr, 'end');
        $brandArr = '"'.$brandArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($brandArr);
        }

        // Set list box for Car Type
        $carTypeArr = '';
        foreach ($carTypeList as $item) {
            $carTypeArr .= ($item['CarTypeID'].",");
        }
        rtrim($carTypeArr, 'end');
        $carTypeArr = '"'.$carTypeArr.'"';
        for ($i = 2; $i <= 100; $i++)
        {
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($carTypeArr);
        }

        // Auto fill data for EngineType
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $i, '=IF(M'.$i.'<>"",VLOOKUP(M'.$i.',$AO$1:$AQ$100,3,1), "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '"NTAU"' . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '"TAU-BAI"' . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '1' . ', "")');
        }

        /* Create excel file */
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Manifest-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    /* Stock */
    public function createXLSForStockExportWithClassIn(){
        // load excel library
        $this->load->library('excel');
        $stockInfo      = $this->mdlData->loadAllColForStockScreen('', '', '', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $cusList        = $this->mdlData->loadCustomerListForStockScreen();
        $vmStatusList   = $this->mdlCommon->loadVMStatusList();

        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã khách hàng (xem ở cột AO - AQ)');   
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mã cảng xếp (xem ở cột AS - AU)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Mã cảng dở (xem ở cột AS - AU)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mã cảng đích (xem ở cột AS - AU)');    
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tình trạng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Ngày vào (theo định dạng dd/mm/yyyy)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã phương án vào (xem ở cột AG - AI)');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương thức vào (xem ở cột AK - AM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Ngày ra (theo định dạng dd/mm/yyyy)');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mã phương án ra (xem ở cột AG - AI)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Mã phương thức ra (xem ở cột AK - AM)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Block');      
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Bay');    
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Row');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tier'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Area');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Số hóa đơn');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số lệnh giao nhận');     
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Số lệnh dịch vụ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Mã pin');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Sequence');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Transit ID');       
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Mã tình trạng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Mô tả');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Mã khách hàng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Tên khách hàng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'Tên cảng');

        // Set Row
        $rowCount = 2;
        foreach ($stockInfo as $element) {
            if ($element['ClassID'] == 1){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BillOfLading']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['VINNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['CusID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['POL']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['POD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['FPOD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['VMStatus']);        
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['DateIn']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['JobModeInID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['MethodInID']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['DateOut']);                
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['JobModeOutID']);                     
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['MethodOutID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['Block']);
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['Bay']);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['Row']);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['Tier']);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['Area']);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['InvNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['EirNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['OrderNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['PinCode']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $element['Sequence']);
                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $element['TransitID']);
                $rowCount++;
            }
        }

        $rowCount = 2;
        foreach($vmStatusList as $element){
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $element['VMStatus']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $element['VMStatusDesc']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($cusList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $rowCount, $element['CusName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AV1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AV'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AV100')->getAlignment()->setWrapText(true);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Stock-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSForStockExportWithClassOut(){
        // load excel library
        $this->load->library('excel');
        $stockInfo      = $this->mdlData->loadAllColForStockScreen('', '', '', '', '');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $cusList        = $this->mdlData->loadCustomerListForStockScreen();
        $vmStatusList   = $this->mdlCommon->loadVMStatusList();

        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã khách hàng (xem ở cột AO - AQ)');   
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mã cảng xếp (xem ở cột AS - AU)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Mã cảng dở (xem ở cột AS - AU)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mã cảng đích (xem ở cột AS - AU)');    
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tình trạng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Ngày vào (theo định dạng dd/mm/yyyy)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã phương án vào (xem ở cột AG - AI)');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương thức vào (xem ở cột AK - AM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Ngày ra (theo định dạng dd/mm/yyyy)');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mã phương án ra (xem ở cột AG - AI)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Mã phương thức ra (xem ở cột AK - AM)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Block');      
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Bay');    
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Row');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tier'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Area');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Số hóa đơn');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số lệnh giao nhận');     
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Số lệnh dịch vụ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Mã pin');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Sequence');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Transit ID');       
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Mã tình trạng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Mô tả');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Mã khách hàng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Tên khách hàng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'Tên cảng');

        // Set Row
        $rowCount = 2;
        foreach ($stockInfo as $element) {
            if ($element['ClassID'] == 2){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['BillOfLading']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['VINNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, ($element['ClassID'] == 1 ? 'Nhập' : 'Xuất'));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, ($element['IsLocalForeign'] == 1 ? 'Nội' : 'Ngoại'));
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['CusID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['POL']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['POD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['FPOD']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['VMStatus']);        
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['DateIn']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['JobModeInID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['MethodInID']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['DateOut']);                
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['JobModeOutID']);                     
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['MethodOutID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['Block']);
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['Bay']);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['Row']);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['Tier']);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['Area']);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['InvNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['EirNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element['OrderNo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element['PinCode']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $element['Sequence']);
                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $element['TransitID']);
                $rowCount++;
            }
        }

        $rowCount = 2;
        foreach($vmStatusList as $element){
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $element['VMStatus']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $element['VMStatusDesc']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($cusList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $rowCount, $element['CusName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AV1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AV'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AV100')->getAlignment()->setWrapText(true);

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Stock-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSFormForStockImportForClassIn() {
        // load excel library
        $this->load->library('excel');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $cusList        = $this->mdlData->loadCustomerListForStockScreen();
        $vmStatusList   = $this->mdlCommon->loadVMStatusList();
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã khách hàng (xem ở cột AO - AQ)');   
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mã cảng xếp (xem ở cột AS - AU)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Mã cảng dở (xem ở cột AS - AU)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mã cảng đích (xem ở cột AS - AU)');    
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tình trạng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Ngày vào (theo định dạng dd/mm/yyyy)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã phương án vào (xem ở cột AG - AI)');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương thức vào (xem ở cột AK - AM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Ngày ra (theo định dạng dd/mm/yyyy)');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mã phương án ra (xem ở cột AG - AI)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Mã phương thức ra (xem ở cột AK - AM)');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Block');      
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Bay');    
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Row');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tier'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Area');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Số hóa đơn');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số lệnh giao nhận');     
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Số lệnh dịch vụ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Mã pin');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Sequence');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Transit ID');    
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Mã tình trạng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Mô tả');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Mã khách hàng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Tên khách hàng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'Tên cảng');

        $rowCount = 2;
        foreach($vmStatusList as $element){
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $element['VMStatus']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $element['VMStatusDesc']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($cusList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $rowCount, $element['CusName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AV1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AV'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AV100')->getAlignment()->setWrapText(true); 

        // Auto fill data
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '1' . ', "")');
        }

        // Set list box for Port Modes
        $portArr = '';
        foreach ($portList as $item) {
            $portArr .= ($item['PortID'].",");
        }
        rtrim($portArr, 'end');
        $portArr = '"'.$portArr.'"';

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';

        // Set list box for Method
        $methodArr = '';
        foreach ($methodList as $item) {
            $methodArr .= ($item['MethodID'].",");
        }
        rtrim($methodArr, 'end');
        $methodArr = '"'.$methodArr.'"';

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        
        // Set list box for Port Modes
        $cusArr = '';
        foreach ($cusList as $item) {
            $cusArr .= ($item['CusID'].",");
        }
        rtrim($cusArr, 'end');
        $cusArr = '"'.$cusArr.'"';

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        
        // Set list box for Port Modes
        $cusArr = '';
        foreach ($cusList as $item) {
            $cusArr .= ($item['CusID'].",");
        }
        rtrim($cusArr, 'end');
        $cusArr = '"'.$cusArr.'"';

        // Set list box for Method
        $vmStatusArr = '';
        foreach ($vmStatusList as $item) {
            $vmStatusArr .= ($item['VMStatus'].",");
        }
        rtrim($vmStatusArr, 'end');
        $vmStatusArr = '"'.$vmStatusArr.'"';

        for ($i = 2; $i <= 100; $i++)
        {           
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr); 

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);     

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);      

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($cusArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($vmStatusArr);
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Stock-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function createXLSFormForStockImportForClassOut() {
        // load excel library
        $this->load->library('excel');
        $jobModeList    = $this->mdlData->loadJobModeListForStockScreen();
        $methodList     = $this->mdlData->loadMethodListForStockScreen();
        $portList       = $this->mdlData->loadPortListForStockScreen();
        $cusList        = $this->mdlData->loadCustomerListForStockScreen();
        $vmStatusList   = $this->mdlCommon->loadVMStatusList();
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        /* Set Header */
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Số vận đơn/ Số booking');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Số VIN');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Nhập/ xuất tàu (Nhập = 1, Xuất = 2)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Hàng nội/ ngoại (Nội = 1, Ngoại = 2)');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã khách hàng (xem ở cột AO - AQ)');   
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mã cảng xếp (xem ở cột AS - AU)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Mã cảng dở (xem ở cột AS - AU)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mã cảng đích (xem ở cột AS - AU)');    
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tình trạng xe');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Ngày vào (theo định dạng dd/mm/yyyy)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Mã phương án vào (xem ở cột AG - AI)');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Mã phương thức vào (xem ở cột AK - AM)');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Ngày ra (theo định dạng dd/mm/yyyy)');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Mã phương án ra (xem ở cột AG - AI)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Mã phương thức ra (xem ở cột AK - AM)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Block');      
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Bay');    
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Row');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tier'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Area');     
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Số hóa đơn');     
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Số lệnh giao nhận');     
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Số lệnh dịch vụ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Mã pin');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Sequence');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Transit ID');    
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Mã tình trạng xe');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Mô tả');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Mã phương án');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Tên phương án');   

        $objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'Mã phương thức');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Tên phương thức');

        $objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Mã khách hàng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Tên khách hàng');

        $objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'STT');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Mã cảng');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AV1', 'Tên cảng');

        $rowCount = 2;
        foreach($vmStatusList as $element){
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $element['VMStatus']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $element['VMStatusDesc']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($jobModeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $element['JobModeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $element['JobModeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($methodList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $element['MethodID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . $rowCount, $element['MethodName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($cusList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . $rowCount, $element['CusName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($portList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . $rowCount, $element['PortID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AV' . $rowCount, $element['PortName']);
            $rowCount++;
        }

        /* Set format for excel file */
        $style = array(
            'font' => array('size' => 11,'bold' => true),
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A1:AV1')->applyFromArray($style);

        $style = array(
            'alignment' => array('horizontal'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                 'vertical'     => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        );
        for($i = 2; $i <= 100; $i++){
            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AV'.$i)->applyFromArray($style);
        }

        for($col = 'A'; $col !== 'AV'; $col++) { // Set auto size
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1:AV100')->getAlignment()->setWrapText(true); 

        // Auto fill data
        for ($i = 2; $i <= 100; $i++)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . ($i-1) . ', "")');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, '=IF(OR(B'. ($i-1) .'<>"" , C'. ($i-1) .'<>""),' . '2' . ', "")');
        }

        // Set list box for Port Modes
        $portArr = '';
        foreach ($portList as $item) {
            $portArr .= ($item['PortID'].",");
        }
        rtrim($portArr, 'end');
        $portArr = '"'.$portArr.'"';

        // Set list box for Job Modes
        $jobModeArr = '';
        foreach ($jobModeList as $item) {
            $jobModeArr .= ($item['JobModeID'].",");
        }
        rtrim($jobModeArr, 'end');
        $jobModeArr = '"'.$jobModeArr.'"';

        // Set list box for Method
        $methodArr = '';
        foreach ($methodList as $item) {
            $methodArr .= ($item['MethodID'].",");
        }
        rtrim($methodArr, 'end');
        $methodArr = '"'.$methodArr.'"';

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        
        // Set list box for Port Modes
        $cusArr = '';
        foreach ($cusList as $item) {
            $cusArr .= ($item['CusID'].",");
        }
        rtrim($cusArr, 'end');
        $cusArr = '"'.$cusArr.'"';

        // Set list box for ClassID and IsLocalForeign
        $arr = '"1,2"';
        
        // Set list box for Port Modes
        $cusArr = '';
        foreach ($cusList as $item) {
            $cusArr .= ($item['CusID'].",");
        }
        rtrim($cusArr, 'end');
        $cusArr = '"'.$cusArr.'"';

        // Set list box for Method
        $vmStatusArr = '';
        foreach ($vmStatusList as $item) {
            $vmStatusArr .= ($item['VMStatus'].",");
        }
        rtrim($vmStatusArr, 'end');
        $vmStatusArr = '"'.$vmStatusArr.'"';

        for ($i = 2; $i <= 100; $i++)
        {           
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr); 

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($portArr);     

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('O' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($jobModeArr);      

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('M' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('P' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($methodArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($arr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($cusArr);

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setShowDropDown(true);
            $objValidation->setFormula1($vmStatusArr);
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Stock-Format-Data-Import.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}
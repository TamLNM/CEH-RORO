<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
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

    public function temp(){
        $this->data['title'] = 'Lệnh dịch vụ';

        $this->load->view('header', $this->data);
        $this->load->view('common/templayout');
        $this->load->view('footer');
    }

    public function cmPaymentMethod()
    {
        $access = $this->user->access('cmPaymentMethod');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePaymentMethod($saveData);
                echo json_encode($this->data);
                exit;
            }
        }
        
        if($action == 'delete')
        {
            $delACC_CDs = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delACC_CDs) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePaymentMethod($delACC_CDs);
                echo json_encode($this->data['result']);
                exit();
            }
        }
        
        $this->data['title'] = "Hình thức thanh toán";
        $this->load->view('header', $this->data);
        $this->data['payment_method'] = $this->mdlCommon->loadPaymentMethod();
        $this->load->view('common/payment_method', $this->data);
        $this->load->view('footer');
    }

    public function cmShifts(){
        $access = $this->user->access('cmPaymentMethod');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Ca sản xuất";
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveShifts($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteShifts($delData);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = 'Ca sản xuất';                
        $this->load->view('header', $this->data);
        $this->data['shiftList'] = $this->mdlCommon->loadAllColShiftList();        
        $this->load->view('common/shifts', $this->data);
        $this->load->view('footer');    
    }

    public function createXLSForCustomerExport(){
        $listCus     = $this->mdlCommon->loadAllColCustomer();
        $listCusType = $this->mdlCommon->loadCusType();
        $paymentTypeList = $this->mdlCommon->loadPaymentTypeList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);        

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mã loại khách (Xem ở cột L đến N)');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã khách hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Tên khách hàng');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã số thuế');     
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã loại hình thanh toán (xem ở cột R đến T)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Điện thoại');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Fax');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Địa chỉ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Email');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Kích hoạt (Không: 0, Có: 1)');     

        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'STT');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Mã loại khách');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Tên loại');     

        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'STT');     
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Mã loại hình');     
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tên loại hình'); 

        $rowCount = 2;
        foreach ($listCus as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['CusTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['CusID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['CusName']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['TaxCode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['PaymentTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['Tel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['Fax']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['Address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['Email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['IsActive']);
            $rowCount++;
        }
        
        $rowCount = 2;
        foreach ($listCusType as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['CusTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['CusTypeName']);
            $rowCount++;
        }
      
        $rowCount = 2;
        foreach ($paymentTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['PaymentTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['PaymentTypeName']);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Customer-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output'); 
    }
    
    public function createXLSFormForCustomerImport(){
        $listCusType = $this->mdlCommon->loadCusType();
        $paymentTypeList = $this->mdlCommon->loadPaymentTypeList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0); 

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'STT');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Mã loại khách (Xem ở cột L đến N)');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mã khách hàng');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Tên khách hàng');     
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mã số thuế');     
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mã loại hình thanh toán (xem ở cột R đến T)');     
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Điện thoại');     
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Fax');     
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Địa chỉ');     
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Email');     
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Kích hoạt (Không: 0, Có: 1)');        

        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'STT');     
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Mã loại khách');     
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Tên loại');   

        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'STT');     
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Mã loại hình');     
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Tên loại hình'); 

        $rowCount = 2;
        foreach ($listCusType as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['CusTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['CusTypeName']);
            $rowCount++;
        }

        $rowCount = 2;
        foreach ($paymentTypeList as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $rowCount - 1);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['PaymentTypeID']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['PaymentTypeName']);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=Customer-Format-Data-Export.xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');     
    }

    public function cmPorts(){
        $access = $this->user->access('cmPorts');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $this->data['title'] = "Cảng";

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePorts($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delPortID = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delPortID) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePort($delPortID);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = "Cảng";
        $this->load->view('header', $this->data);
        $this->data['nationList'] = $this->mdlCommon->loadNationList();
        $this->data['portList'] = $this->mdlCommon->loadPortListForPortScreen();
        $this->load->view('common/ports', $this->data);
        $this->load->view('footer');
    }

    public function cmJobModes(){
         $access = $this->user->access('cmJobModes');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Phương án";
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveJobModes($saveData);
                echo json_encode($this->data);
                exit;
            }
        }    

        if ($action == 'delete'){
            $delJobModes = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delJobModes) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteJobModes($delJobModes);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = "Phương án";
        $this->load->view('header', $this->data);
        $this->data['jobmodeList'] = $this->mdlCommon->loadAllColJobModes();
        $this->data['transitList'] = $this->mdlCommon->loadTransitList();
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->load->view('common/job_modes', $this->data);
        $this->load->view('footer');
    }

    public function cmServices(){
         $access = $this->user->access('cmServices');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveServices($saveData);
                echo json_encode($this->data);
                exit;
            }
        }    

        if ($action == 'delete'){
            $deleteData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($deleteData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteServices($deleteData);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = 'Dịch vụ';
        $this->load->view('header', $this->data);
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['servicesList'] = $this->mdlCommon->loadAllColServices();
        $this->load->view('common/services', $this->data);
        $this->load->view('footer');
    }

    public function cmJobTypes(){
        $access = $this->user->access('cmJobTypes');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Loại công việc";
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveJobTypes($saveData);
                echo json_encode($this->data);
                exit;
            }
        }    

        if ($action == 'delete'){
            $deleteData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($deleteData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteJobTypes($deleteData);
            }
            echo json_encode($this->data);
            exit;       
        }
        

        $this->data['title'] = 'Loại công việc';
        $this->load->view('header', $this->data);
        $this->data['jobTypeList'] = $this->mdlCommon->loadAllColJobTypes();
        $this->load->view('common/job_types', $this->data);
        $this->load->view('footer');
    }

    public function cmMethod()
    {
        $access = $this->user->access('cmMethod');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = "Loại công việc";
        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveMethod($saveData);
                echo json_encode($this->data);
                exit;
            }
        }   

        if ($action == 'delete'){
            $deleteData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($deleteData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteMethod($deleteData);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = 'Phương thức';
        $this->load->view('header', $this->data);
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['methodList'] = $this->mdlCommon->loadAllColMethodList();
        $this->load->view('common/method', $this->data);
        $this->load->view('footer');    
    }

    public function cmCustomerType()
    {
        $access = $this->user->access('cmCustomerType');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCustomerType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateCustomerType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delUnits = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delUnits) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteCustomerType($delUnits);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Loại khách hàng";
        $this->load->view('header', $this->data);
        $this->data['customertype'] = $this->mdlCommon->loadCusType();
        $this->load->view('common/customer_type', $this->data);
        $this->load->view('footer');     
    }

    public function cmCustomers()
    {
        $access = $this->user->access('cmCustomers');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Khách hàng";
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == 'view')
        {
            $customer_type      = $this->input->post('cusType') ? $this->input->post('cusType') : '';
            $customer_id        = $this->input->post('cusID') ? $this->input->post('cusID') : '';
            $customer_name      = $this->input->post('cusName') ? $this->input->post('cusName') : '';
            $customer_taxcode   = $this->input->post('TaxCode') ? $this->input->post('TaxCode') : '';
            $this->data['list'] = $this->mdlCommon->loadCustomers($customer_type, $customer_id, $customer_name, $customer_taxcode);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCustomers($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateCustomers($saveData);
                echo json_encode($this->data);
                exit;
            }
        }


        if($action == 'delete')
        {
            $delCusID = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delCusID) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteCustomers($delCusID);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->load->view('header', $this->data);
        $this->data['cusType'] = $this->mdlCommon->loadCusType(); // Load data for cus type screen
        $this->data['cus'] = $this->mdlCommon->loadCus();
        $this->data['paymentTypeList'] = $this->mdlCommon->loadPaymentTypeList();
        $this->load->view('common/customers', $this->data);
        $this->load->view('footer');        
    }

    public function cmDamagedType()
    {
        $access = $this->user->access('cmDamagedType');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveDamagedType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateDamagedType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete')
        {
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteDamagedType($delData);
            }
            echo json_encode($this->data);
            exit;
        }
    

        $this->data['title'] = "Loại hư hỏng";
        $this->load->view('header', $this->data);
        $this->data['damagedTypeList'] = $this->mdlCommon->loadDamagedTypeList();
        $this->load->view('common/damaged_type', $this->data);
        $this->load->view('footer');     
    }

    public function cmDamaged()
    {
        $access = $this->user->access('cmDamaged');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveDamaged($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateDamaged($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteDamaged($delData);
            }
            echo json_encode($this->data);
            exit;
        }
    

        $this->data['title'] = "Loại hư hỏng";
        $this->load->view('header', $this->data);
        $this->data['damagedList'] = $this->mdlCommon->loadDamagedList();
        $this->data['damagedTypeList'] = $this->mdlCommon->loadDamagedTypeList();
        $this->load->view('common/damaged', $this->data);
        $this->load->view('footer');     
    }

    public function cmBerth(){
         $access = $this->user->access('cmBerth');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveBerth($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateBerth($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteBerth($delData);
                echo json_encode($this->data);
                exit;      
            }
        }

        $this->data['title'] = "Bến";
        $this->load->view('header', $this->data);
        $this->data['berthList'] = $this->mdlCommon->loadBerthList();
        $this->load->view('common/berth', $this->data);
        $this->load->view('footer');
    }

    public function cmBitt(){
         $access = $this->user->access('cmBitt');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveBitt($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateBitt($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteBitt($delData);
                echo json_encode($this->data);
                exit;      
            }
        }

        $this->data['title'] = "Bitt";
        $this->load->view('header', $this->data);
        $this->data['bittList'] = $this->mdlCommon->loadBittList();
        $this->data['berthList'] = $this->mdlCommon->loadBerthID();
        $this->load->view('common/bitt', $this->data);
        $this->load->view('footer');
    }

    public function cmWorkerGroup(){
         $access = $this->user->access('cmWorkerGroup');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

       
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveWorkerGroup($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteWorkerGroup($delData);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = "Tổ đội công nhân";
        $this->load->view('header', $this->data);
        $this->data['workerGroupList'] = $this->mdlCommon->loadWorkerGroupList();
        $this->data['workerGroupTypeList'] = $this->mdlCommon->loadWorkerGroupTypeList();
        $this->load->view('common/worker_group', $this->data);
        $this->load->view('footer');
    }

    public function cmWorkerGroupType(){
        $access = $this->user->access('cmWorkerGroupType');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }    

                $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveWorkerGroupType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteWorkerGroupType($delData);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = "Loại tổ đội công nhân";
        $this->load->view('header', $this->data);
        $this->data['workerGroupTypeList'] = $this->mdlCommon->loadWorkerGroupTypeList();
        $this->load->view('common/worker_group_type', $this->data);
        $this->load->view('footer');
    }
    
    public function cmUnitCode() 
    {
        $access = $this->user->access('cmUnitCode');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveUnitCode($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delUnits = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delUnits) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteUnitCode($delUnits);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Đơn vị tính";
        $this->load->view('header', $this->data);
        $this->data['unitcodes'] = $this->mdlCommon->loadUnitCodes();
        $this->load->view('common/unit_codes', $this->data);
        $this->load->view('footer');
    }

    public function cmExchangeRate()
    {
        $access = $this->user->access('cmExchangeRate');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveExchangeRate($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delExchange = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delExchange) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteExchangeRate($delExchange);
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tỉ giá loại tiền";

        $this->load->view('header', $this->data);
        $this->data['exchange_rates'] = $this->mdlCommon->loadExchangeRate();
        $this->load->view('common/exchange_rate', $this->data);
        $this->load->view('footer');
    }

    public function cmServiceAddonConfig()
    {
        $access = $this->user->access('cmServiceAddonConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveServiceAddon($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = "Cấu hình DV đính kèm";

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdlCommon->loadDMethodInServices();
        $this->data['attach_services'] = $this->mdlCommon->loadServiceMore();
        $this->load->view('common/service_addon_config', $this->data);
        $this->load->view('footer');
    }

    public function cmTRFTemplateConfig()
    {
        $access = $this->user->access('cmTRFTemplateConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveTRFTempConfig($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = "Cấu hình tính cước";

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdlCommon->loadDMethodInServices();
        $this->data['template_services'] = $this->mdlCommon->loadServiceTemplate();
        $this->load->view('common/trf_template_config', $this->data);
        $this->load->view('footer');
    }

    public function cmPlugConfig()
    {
        $access = $this->user->access('cmPlugConfig');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Cấu hình cắm rút điện lạnh";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->data['payers'] = $this->mdlCommon->getPayers();
        $this->load->view('common/plug_config', $this->data);
        $this->load->view('footer');
    }

    public function cmTRFService()
    {
        $access = $this->user->access('cmTRFService');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Cấu hình cước bậc thang";

        $this->load->view('header', $this->data);
        $this->load->view('common/trf_service', $this->data);
        $this->load->view('footer');
    }

    public function cmLoLoService()
    {
        $access = $this->user->access('cmLoLoService');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Dịch vụ";

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdlCommon->loadDeliveryMode();
        $this->load->view('common/lolo_services', $this->data);
        $this->load->view('footer');
    }

    public function cmEir(){
        $access = $this->user->access('cmEir');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'searh_ship'){
            $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
            $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
            $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

            $this->data['vsls'] = $this->mdlCommon->searchShip($arrstt, $year, $name);
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $opr = $this->input->post('opr') ? $this->input->post('opr') : '';
            $httt = $this->input->post('httt') ? $this->input->post('httt') : '';
            $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
            $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
            $xnvc = $this->input->post('xnvc') ? $this->input->post('xnvc') : '';
            $method = $this->input->post('method') ? $this->input->post('method') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'OprID' => $opr,
                'PAYMENT_TYPE' => $httt,
                'CntrNo' => $cntrNo,
                'ShipKey' => $shipkey,
                'bXNVC' => $xnvc,
                'CJMode_CD' => $method
            );
            $this->data['list'] = $this->mdlCommon->loadEir($arr_where);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Lệnh nâng hạ";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->load->view('common/eir', $this->data);
        $this->load->view('footer');
    }

    public function cmInvDraff(){
        $access = $this->user->access('cmInvDraff');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'searh_payer'){
            $this->data['payers'] = $this->mdlCommon->getPayers_InvDFT();
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $opr = $this->input->post('opr') ? $this->input->post('opr') : '';
            $cusID = $this->input->post('cusid') ? $this->input->post('cusid') : '';
            $createdBy = $this->input->post('createdby') ? $this->input->post('createdby') : '';

            $payment_status = $this->input->post('payment_status') ? $this->input->post('payment_status') : array();
            $inv_type = $this->input->post('inv_type') ? $this->input->post('inv_type') : array();
            $currencyid = $this->input->post('currencyid') ? $this->input->post('currencyid') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'OprID' => $opr,
                'PAYMENT_STATUS' => $payment_status,
                'CreatedBy' => $createdBy,
                'CusID' => $cusID,
                'INV_TYPE' => $inv_type,
                'CURRENCYID' => $currencyid
            );

            $this->data['list'] = $this->mdlCommon->loadInvDraff($arr_where);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Phiếu tính cước";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->load->view('common/invoice_draff', $this->data);
        $this->load->view('footer');
    }

    public function cmInv()
    {
        $access = $this->user->access('cmInv');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        $actions = $this->input->post('actions') ? $this->input->post('actions') : '';
        if($actions == 'search-payer'){
            $this->data['results'] = $this->mdlCommon->getPayers_Inv();
            echo json_encode($this->data);
            exit;
        }
        if($actions == 'search-tariff'){
            $this->data['results'] = $this->mdlCommon->getTariff();
            echo json_encode($this->data);
            exit;
        }
        if($action == 'view')
        {
            $frd = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $td = $this->input->post('todate') ? $this->input->post('todate') : '';
            $payer = $this->input->post('payer') ? $this->input->post('payer') : '';
            $tariff = $this->input->post('tariff') ? $this->input->post('tariff') : '';
            $createdBy = $this->input->post('createdby') ? $this->input->post('createdby') : '';
            $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
            $currencyid = $this->input->post('CURRENCYID') ? $this->input->post('CURRENCYID') : array();

            $fromdate = $this->funcs->dbDateTime($frd);
            $todate = $this->funcs->dbDateTime($td.' 23:59:59');
            $arr_where = array(
                'FROM_DATE' => $fromdate,
                'TO_DATE' => $todate,
                'PAYER' => $payer,
                'TRF_CODE' => $tariff,
                'CreatedBy' => $createdBy,
                'ShipKey' => $shipkey,
                'CURRENCYID' => $currencyid
            );

            $this->data['list'] = $this->mdlCommon->loadInv($arr_where);
            echo json_encode($this->data);
            exit;
        }
        $this->data['title'] = "Hóa đơn";

        $this->load->view('header', $this->data);
        $this->load->view('common/invoice', $this->data);
        $this->load->view('footer');
    }

    public function cmCarBrand(){
        $access = $this->user->access('cmCarBrand');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCarBrand($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateCarBrand($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteCarBrand($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Hãng xe";
        $this->load->view('header', $this->data);
        $this->data['carBrandList'] = $this->mdlCommon->loadAllColCarBrand();
        $this->load->view('common/car_brand', $this->data);
        $this->load->view('footer');
    }

    public function cmCarType(){
        $access = $this->user->access('cmCarType');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }      
        
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        
        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCarType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateCarType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteCarType($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Loại xe";
        $this->load->view('header', $this->data);
        $this->data['carTypeList'] = $this->mdlCommon->loadAllColCarType();
        $this->data['carBrandList'] = $this->mdlCommon->loadAllColCarBrand();
        $this->load->view('common/car_type', $this->data);
        $this->load->view('footer');
    }

    public function cmPayForm(){
        $access = $this->user->access('cmPayForm');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePayForm($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePayForm($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Hình thức thanh toán";
        $this->load->view('header', $this->data);
        $this->data['paymentTypeList'] = $this->mdlCommon->loadAllColPaymentType();
        $this->data['paymentFormList'] = $this->mdlCommon->loadAllColPaymentForm();
        $this->load->view('common/inv_payment_form', $this->data);
        $this->load->view('footer');
    }

    public function cmRate(){
        $access = $this->user->access('cmRate');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveRate($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteRate($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Tỷ giá";
        $this->load->view('header', $this->data);
        $this->data['rateList'] = $this->mdlCommon->loadAllColRateList();
        $this->data['carBrandList'] = $this->mdlCommon->loadAllColCarBrand();
        $this->load->view('common/inv_rate', $this->data);
        $this->load->view('footer');
    }

    public function cmPaymentType(){
        $access = $this->user->access('cmPaymentType');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        
    
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePaymentType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePaymentType($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Loại hình thanh toán";
        $this->load->view('header', $this->data);
        $this->data['paymentTypeList'] = $this->mdlCommon->loadAllColPaymentType();
        $this->load->view('common/inv_payment_type', $this->data);
        $this->load->view('footer');
    }

    public function cmTransit(){
        $access = $this->user->access('cmTransit');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveTransit($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteTransit($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Loại hình vận chuyển";
        $this->load->view('header', $this->data);
        $this->data['carBrandList'] = $this->mdlCommon->loadAllColCarBrand();
        $this->data['transitList'] = $this->mdlCommon->loadAllColTransit();
        $this->load->view('common/transit', $this->data);
        $this->load->view('footer');
    }

    public function cmArea(){
        $access = $this->user->access('cmArea');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveArea($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateArea($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteArea($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "Vùng phụ";
        $this->load->view('header', $this->data);
        $this->data['areaList'] = $this->mdlCommon->loadAllColArea();
        $this->load->view('common/area', $this->data);
        $this->load->view('footer');
    }

    public function cmColor(){
        $access = $this->user->access('cmColor');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveColor($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteColor($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "MÀU";
        $this->load->view('header', $this->data);
        $this->data['manifestList'] = $this->mdlCommon->LoadVesselListFromManifestForColorScreen();
        $this->data['colorList'] = $this->mdlCommon->loadAllColColor();
        $this->load->view('common/color', $this->data);
        $this->load->view('footer');
    }

    public function cmClass(){
        $access = $this->user->access('cmClass');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveClass($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateClass($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteClass($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "HƯỚNG NHẬP XUẤT";
        $this->load->view('header', $this->data);
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->load->view('common/class', $this->data);
        $this->load->view('footer');
    }

    public function cmYard(){
        $access = $this->user->access('cmYard');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveYard($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteYard($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "THÔNG TIN DOANH NGHIỆP";
        $this->load->view('header', $this->data);
        $this->data['yardList'] = $this->mdlCommon->loadAllColYard();
        $this->load->view('common/yard', $this->data);
        $this->load->view('footer');
    }

    public function cmBlock(){
        $access = $this->user->access('cmBlock');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'view'){
            $YardID   = $this->input->post('YardID') ? $this->input->post('YardID') : '';
            $this->data['list'] = $this->mdlCommon->loadBlockByYardID($YardID);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveBlock($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteBlock($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "BÃI";
        $this->load->view('header', $this->data);
        $this->data['yardList'] = $this->mdlCommon->loadAllColYard();
        $this->load->view('common/block', $this->data);
        $this->load->view('footer');
    }

    public function cmPrefix(){
        $access = $this->user->access('cmPrefix');

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
            $this->data['list'] = $this->mdlCommon->loadAllColPrefix();
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->savePrefix($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deletePrefix($delData);
            }
            echo json_encode($this->data);
            exit;    
        }       

        $this->data['title'] = "QUYỂN HÓA ĐƠN";
        $this->load->view('header', $this->data);
        $this->data['prefixList'] = $this->mdlCommon->loadAllColPrefix();
        $this->load->view('common/inv_prefix', $this->data);
        $this->load->view('footer');
    }

    public function cmNational(){
        $access = $this->user->access('cmNational');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveNation($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteNation($delData);
            }
            echo json_encode($this->data);
            exit;    
        }    

        $this->data['title'] = "QUỐC GIA";
        $this->load->view('header', $this->data);
        $this->data['nationList'] = $this->mdlCommon->loadNationList();
        $this->load->view('common/national', $this->data);
        $this->load->view('footer');
    }

    public function cmOpr(){
        $access = $this->user->access('cmOpr');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveOpr($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteOpr($delData);
            }
            echo json_encode($this->data);
            exit;    
        }      

        $this->data['title'] = "HÃNG KHAI THÁC";
        $this->load->view('header', $this->data);
        $this->data['oprList'] = $this->mdlCommon->loadOprList();
        $this->load->view('common/opr', $this->data);
        $this->load->view('footer');
    }

    public function cmVMStatus(){
        $access = $this->user->access('cmVMStatus');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveVMStatus($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateVMStatus($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteVMStatus($delData);
            }
            echo json_encode($this->data);
            exit;    
        }      

        $this->data['title'] = "TÌNH TRẠNG XE";
        $this->load->view('header', $this->data);
        $this->data['vmStatusList'] = $this->mdlCommon->loadVMStatusList();
        $this->load->view('common/vmstatus', $this->data);
        $this->load->view('footer');
    }

    public function cmGate(){
        $access = $this->user->access('cmGate');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }        

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveGate($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateGate($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteGate($delData);
            }
            echo json_encode($this->data);
            exit;    
        }      

        $this->data['title'] = "CỔNG";
        $this->load->view('header', $this->data);
        $this->data['gateList'] = $this->mdlCommon->loadAllColGateList();
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->load->view('common/gate', $this->data);
        $this->load->view('footer');
    }

    public function cmLane(){
        $access = $this->user->access('cmLane');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }     

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'loadLane'){
                $laneID = $this->input->post('LaneID') ? $this->input->post('LaneID') : '';
                $this->data['list'] = $this->mdlCommon->loadLaneByID($laneID);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadLaneDetails'){
                $laneID = $this->input->post('LaneID') ? $this->input->post('LaneID') : '';
                $this->data['list'] = $this->mdlCommon->loadLaneDetailByID($laneID);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadExistPortListByLaneID'){
                $laneID = $this->input->post('LaneID') ? $this->input->post('LaneID') : '';
                $this->data['list'] = $this->mdlCommon->loadExistPortListByLaneID($laneID);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'add' || $action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'add_lane'){       
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->saveLane($saveData);
                    echo json_encode($this->data);
                    exit;
                }
                exit;
            }


            if ($child_action == 'add_lane_detail'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->saveLaneDetail($saveData);
                    echo json_encode($this->data);
                    exit;
                }
                exit;
            }
        }   

        if($action == 'delete'){

            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            //if ($child_action == 'deleteByLaneCode'){   
                $laneID = $this->input->post('LaneID') ? $this->input->post('LaneID') : '';
                $delData1 = $this->input->post('data1') ? $this->input->post('data1') : array();
                $delData2 = $this->input->post('data2') ? $this->input->post('data2') : array();
                $this->data['list'] = $this->mdlCommon->deleteLaneDetails($delData1, $delData2, $laneID);
                echo json_encode($this->data);
                exit;
                /*
            }

            if ($child_action == 'deleteByOpr'){   
                $laneID = $this->input->post('LaneID') ? $this->input->post('LaneID') : '';
                $delData = $this->input->post('data') ? $this->input->post('data') : array();
                 $this->data['list'] = $this->mdlCommon->deleteLaneDetailsByOpr($delData, $laneID);
                echo json_encode($this->data);
                exit;
            }            */
        }

        $this->data['title'] = "HÀNH TRÌNH TÀU";
        $this->load->view('header', $this->data);
        $this->data['oprList'] = $this->mdlCommon->loadOprList();
        $this->data['portList'] = $this->mdlCommon->loadPortList();
        $this->data['laneList'] = $this->mdlCommon->loadLaneList();
        $this->load->view('common/lane', $this->data);
        $this->load->view('footer');
    }

    public function cmCargoType(){
        $access = $this->user->access('cmCargoType');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }     


        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveCargoType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->updateCargoType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommon->deleteCargoType($delData);
            }
            echo json_encode($this->data);
            exit;    
        }   

        $this->data['title'] = "LOẠI HÀNG HÓA";
        $this->load->view('header', $this->data);
        $this->data['cargoTypeList'] = $this->mdlCommon->loadCargoTypeList();
        $this->load->view('common/cargo_type', $this->data);
        $this->load->view('footer');
    }
}

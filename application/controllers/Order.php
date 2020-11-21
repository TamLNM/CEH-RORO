<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

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
        $this->load->model("order_model", "mdlOrder");
        $this->load->model("vessel_model", "mdlVessel");
        $this->load->model("tariff_model", "mdlTariff");
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

    public function ordDelivery(){
        $access = $this->user->access('ordDelivery');
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
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'load_pay_form'){
                $payment_type_id = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                $this->data['list'] = $this->mdlCommon->loadPayFormByPaymentTypeID($payment_type_id);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'getAutoCode'){
                $digits = $this->input->post('digits') ? $this->input->post('digits') : '';
                $pinCodeNumeric = $this->input->post('pinCodeNumeric') ? $this->input->post('pinCodeNumeric') : '';

                $this->data['eirNoList'] = $this->mdlOrder->getEirNoList();
                $this->data['eirBulkNoList'] = $this->mdlOrder->getEirNoBulkList();
                $this->data['pinCodeList'] = $this->mdlOrder->generatePinCode($digits, $pinCodeNumeric);
                echo json_encode($this->data);
                exit;

            }

            if ($child_action == 'loadStockBulkList'){
                $BillOfLading = $this->input->post('BillOfLading') ? $this->input->post('BillOfLading') : '';
                
                $this->data['list'] = $this->mdlDataBulk->loadAllColStockBulkForOrderIn($BillOfLading);
                $this->data['CargoWeight'] = $this->mdlDataBulk->getCargoInWeightByBL($BillOfLading);
                echo json_encode($this->data);
                exit;
            }

            $BillOfLading = $this->input->post('BillOfLading') ? $this->input->post('BillOfLading') : '';
            $VINNo = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
            $this->data['list'] = $this->mdlData->loadAllColForStockScreen_Order('', $VINNo, $BillOfLading, '', '');
            $this->data['ordEirList'] = $this->mdlOrder->loadEirListForGate('', $VINNo);
            echo json_encode($this->data);
            exit;
        }

        if ($action == 'add'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'addORDBulkData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

                if(count($saveData) > 0){
                    $PaymentTypeID  = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                    $PayFormID      = $this->input->post('PayFormID') ? $this->input->post('PayFormID') : '';
                    $JobModeID      = $this->input->post('JobModeID') ? $this->input->post('JobModeID') : '';
                    $MethodID       = $this->input->post('MethodID') ? $this->input->post('MethodID') : '';

                    $this->data['result'] = $this->mdlOrder->saveOrdBulk($saveData, $PaymentTypeID, $PayFormID, $JobModeID, $MethodID);
                    echo json_encode($this->data);
                    exit;
                }
            }

            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

            if(count($saveData) > 0){
                $PaymentTypeID  = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                $PayFormID      = $this->input->post('PayFormID') ? $this->input->post('PayFormID') : '';
                $JobModeID      = $this->input->post('JobModeID') ? $this->input->post('JobModeID') : '';
                $MethodID       = $this->input->post('MethodID') ? $this->input->post('MethodID') : '';

                $this->data['result'] = $this->mdlOrder->saveOrdDelivery($saveData, $PaymentTypeID, $PayFormID, $JobModeID, $MethodID);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'edit'){
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlOrder->updateStockData($saveData);
                echo json_encode($this->data);
                exit;
            }
        }
         
        $this->data['title'] = 'Lệnh giao hàng';
        $this->load->view('header', $this->data);
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['methodList'] = $this->mdlCommon->loadAllColMethodList();
        $this->data['customerList'] = $this->mdlCommon->loadCus();
        $this->data['VINExistList'] = $this->mdlOrder->loadVinInEirTable();
        $this->data['stockList'] = $this->mdlData->loadAllColForStockScreen_Order('', '', '', '', '');
        $this->load->view('order/ord_delivery', $this->data);
        $this->load->view('footer');
    }

    public function ordService(){
        $access = $this->user->access('ordService');
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
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'load_pay_form'){
                $payment_type_id = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                $this->data['list'] = $this->mdlCommon->loadPayFormByPaymentTypeID($payment_type_id);
                echo json_encode($this->data);
                exit;
            }

            $BillOfLading = $this->input->post('BillOfLading') ? $this->input->post('BillOfLading') : '';
            $VINNo = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
            $this->data['list'] = $this->mdlData->loadAllColForStockScreen_Order('', $VINNo, $BillOfLading, '', '');
            echo json_encode($this->data);
            exit;
        }

        if ($action == 'add'){
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

            if(count($saveData) > 0){
                $PaymentTypeID  = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                $PayFormID      = $this->input->post('PayFormID') ? $this->input->post('PayFormID') : '';
                $JobModeID      = $this->input->post('JobModeID') ? $this->input->post('JobModeID') : '';
                $MethodID       = $this->input->post('MethodID') ? $this->input->post('MethodID') : '';
                $ServiceID       = $this->input->post('ServiceID') ? $this->input->post('ServiceID') : '';

                $this->data['result'] = $this->mdlOrder->saveOrdService($saveData, $PaymentTypeID, $PayFormID, $JobModeID, $MethodID, $ServiceID);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = 'Lệnh dịch vụ';
        $this->load->view('header', $this->data);
        $this->data['serviceList'] = $this->mdlCommon->loadServiceList();
        $this->data['customerList'] = $this->mdlCommon->loadCus();
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['methodList'] = $this->mdlCommon->loadAllColMethodList();
        $this->data['VINExistList'] = $this->mdlOrder->loadVinInEirTable();
        $this->data['stockList'] = $this->mdlData->loadAllColForStockScreen_Order('', '', '', '', '');
        $this->load->view('order/ord_service', $this->data);
        $this->load->view('footer');
    }

    public function ordBulk(){
        $access = $this->user->access('ordBulk');
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
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'getAutoCode'){
                $digits = $this->input->post('digits') ? $this->input->post('digits') : '';
                $pinCodeNumeric = $this->input->post('pinCodeNumeric') ? $this->input->post('pinCodeNumeric') : '';

                $this->data['eirNoList'] = $this->mdlOrder->getEirNoBulkList();
                $this->data['pinCodeList'] = $this->mdlOrder->generatePinCodeBulk($digits, $pinCodeNumeric);
                echo json_encode($this->data);
                exit;

            }
        }

        if ($action == 'add'){
            $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

            if(count($saveData) > 0){
                $PaymentTypeID  = $this->input->post('PaymentTypeID') ? $this->input->post('PaymentTypeID') : '';
                $PayFormID      = $this->input->post('PayFormID') ? $this->input->post('PayFormID') : '';
                $JobModeID      = $this->input->post('JobModeID') ? $this->input->post('JobModeID') : '';
                $MethodID       = $this->input->post('MethodID') ? $this->input->post('MethodID') : '';

                $this->data['result'] = $this->mdlOrder->saveOrdBulk($saveData, $PaymentTypeID, $PayFormID, $JobModeID, $MethodID);
                echo json_encode($this->data);
                exit;
            }
        }
        
        if ($action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'updateMNFBulk'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->updateMNFBulkStatus($saveData);
                    echo json_encode($this->data);
                    exit;
                }            
            }
        }

        $this->data['title'] = 'Lệnh hạ hàng';
        $this->load->view('header', $this->data);
        $this->data['portList'] = $this->mdlData->loadPortListForStockScreen();
        $this->data['customerList'] = $this->mdlCommon->loadCus();
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['methodList'] = $this->mdlCommon->loadAllColMethodList();
        $this->data['classList'] = $this->mdlVessel->loadClassList();
        $this->data['unitList'] = $this->mdlCommon->loadUnitCodes();
        $this->data['YardID'] = $this->session->userdata("YardID");
        $this->data['cargoTypeList'] = $this->mdlCommon->loadCargoTypeList();
        $this->data['manifestBulkList'] = $this->mdlDataBulk->loadAllColForBulkManifestScreen('', '', '');
        $this->data['trfStandardList'] = $this->mdlTariff->loadTRFStandardList('', '', '');
        $this->load->view('order/ord_bulk', $this->data);
        $this->load->view('footer');   
    }
}
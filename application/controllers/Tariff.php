<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tariff extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("tariff_model", "mdlTariff");
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

    public function trfCodes(){
        $access = $this->user->access('trfCodes');
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
                $this->data['result'] = $this->mdlTariff->saveTRFCodes($saveData);
                echo json_encode($this->data);
                exit;
            }
        }
        
        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlTariff->deleteTRFCodes($delData);
            }
            echo json_encode($this->data);
            exit;       
        }

        $this->data['title'] = "Mã biểu cước";
        $this->load->view('header', $this->data);
        $this->data['trfCodesList'] = $this->mdlTariff->loadTRFCodesList();
        $this->data['unitList'] = $this->mdlCommon->loadUnitCodes();
        $this->load->view('tariff/trfCodes', $this->data);
        $this->load->view('footer');
    }

    public function trfStandard(){
        $access = $this->user->access('trfStandard');
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
            $fromDay = $this->input->post('FromDay') ? $this->input->post('FromDay') : '';
            $toDay   = $this->input->post('ToDay') ? $this->input->post('ToDay') : '';
            $remark  = $this->input->post('Remark') ? $this->input->post('Remark') : '';
            $this->data['list'] = $this->mdlTariff->loadTRFStandardList($fromDay, $toDay, $remark);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $applyDate      = $this->input->post('ApplyDate') ? $this->input->post('ApplyDate') : '';
                $expireDate     = $this->input->post('ExpireDate') ? $this->input->post('ExpireDate') : '';
                $remark         = $this->input->post('Remark') ? $this->input->post('Remark') : '';
                $this->data['result'] = $this->mdlTariff->insertTRFStandard($saveData, $applyDate, $expireDate, $remark);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $applyDate      = $this->input->post('ApplyDate') ? $this->input->post('ApplyDate') : '';
                $expireDate     = $this->input->post('ExpireDate') ? $this->input->post('ExpireDate') : '';
                $remark         = $this->input->post('Remark') ? $this->input->post('Remark') : '';
                $this->data['result'] = $this->mdlTariff->updateTRFStandard($saveData, $applyDate, $expireDate, $remark);
                echo json_encode($this->data);
                exit;
            }
        }
        
        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlTariff->deleteTRFStandard($delData);
            }
            echo json_encode($this->data);
            exit;       
        }


        $this->data['title'] = "Biểu cước chuẩn";
        $this->load->view('header', $this->data);
        $this->data['trfStandardList'] = $this->mdlTariff->loadTRFStandardList('', '', '');
        $this->data['trfStandardList_distinct'] = $this->mdlTariff->loadDistinctTRFStandardList();
        $this->data['trfCodesList'] = $this->mdlTariff->loadTRFCodesList();
        $this->data['methodList'] = $this->mdlTariff->loadMethodList();
        $this->data['transitList'] = $this->mdlTariff->loadTransitList();
        $this->data['jobTypeList'] = $this->mdlTariff->loadJobTypeList();
        $this->data['jobModeList'] = $this->mdlTariff->loadJobModeList();       
        $this->data['classList'] = $this->mdlTariff->loadClassList();       
        $this->data['serviceList'] = $this->mdlTariff->loadServiceList();       
        $this->data['carTypeList'] = $this->mdlTariff->loadCarTypeList();       
        $this->data['invRataList'] = $this->mdlTariff->loadInvRataList();       
        $this->data['cargoTypeList'] = $this->mdlCommon->loadCargoTypeList();       
        $this->load->view('tariff/trfStandard', $this->data);
        $this->load->view('footer');
    }

    public function trfDiscount(){
        $access = $this->user->access('trfDiscount');
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
            $discountID     = $this->input->post('DiscountID') ? $this->input->post('DiscountID') : '';
            $cusID          = ($this->input->post('CusID') != '') ? $this->input->post('CusID') : '';
            $cusTypeID      = $this->input->post('CusTypeID') ? $this->input->post('CusTypeID') : '';
            $applyDate      = $this->input->post('ApplyDate') ? $this->input->post('ApplyDate') : '';
            $expireDate     = $this->input->post('ExpireDate') ? $this->input->post('ExpireDate') : '';  
            $this->data['list'] = $this->mdlTariff->loadTRFDiscountList($discountID, $cusID, $cusTypeID, $applyDate, $expireDate);

            echo json_encode($this->data);
            exit;
        }

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $applyDate      = $this->input->post('ApplyDate') ? $this->input->post('ApplyDate') : '';
                $expireDate     = $this->input->post('ExpireDate') ? $this->input->post('ExpireDate') : '';
                $discountID     = $this->input->post('DiscountID') ? $this->input->post('DiscountID') : '';
                $discountName   = $this->input->post('DiscountName') ? $this->input->post('DiscountName') : '';
                $cusID          = ($this->input->post('CusID') != '') ? $this->input->post('CusID') : '';
                $cusTypeID      = $this->input->post('CusTypeID') ? $this->input->post('CusTypeID') : '';
                $this->data['result'] = $this->mdlTariff->insertTRFDiscount($saveData, $applyDate, $expireDate, $discountID, $discountName, $cusID, $cusTypeID);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $applyDate      = $this->input->post('ApplyDate') ? $this->input->post('ApplyDate') : '';
                $expireDate     = $this->input->post('ExpireDate') ? $this->input->post('ExpireDate') : '';
                $discountID     = $this->input->post('DiscountID') ? $this->input->post('DiscountID') : '';
                $discountName   = $this->input->post('DiscountName') ? $this->input->post('DiscountName') : '';
                $cusID          = ($this->input->post('CusID') != '') ? $this->input->post('CusID') : '';
                $cusTypeID      = $this->input->post('CusTypeID') ? $this->input->post('CusTypeID') : '';
                $this->data['result'] = $this->mdlTariff->updateTRFDiscount($saveData, $applyDate, $expireDate, $discountID, $discountName, $cusID, $cusTypeID);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlTariff->deleteTRFDiscount($delData);
            }
            echo json_encode($this->data);
            exit;    
        }     

        $this->data['title'] = "Hợp đồng (theo khách hàng)";
        $this->load->view('header', $this->data);
        $this->data['trfCodesList'] = $this->mdlTariff->loadTRFCodesList();
        $this->data['customerList'] = $this->mdlCommon->loadCus();
        $this->data['cusTypeList'] = $this->mdlCommon->loadCusType();
        $this->data['trfStandardList'] = $this->mdlTariff->loadTRFStandardListForDiscountScreen();
        $this->data['trfDiscountList_distinct'] = $this->mdlTariff->loadDistinctTRFDiscountList();
        $this->data['trfDiscountList'] = $this->mdlTariff->loadTRFDiscountList();
        $this->data['paymentTypeList'] = $this->mdlTariff->loadPaymentType();
        $this->data['brandList'] = $this->mdlTariff->loadBrandList();
        $this->load->view('tariff/trfDiscount', $this->data);
        $this->load->view('footer');
    }
}

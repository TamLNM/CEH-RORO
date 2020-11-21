<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract_Tariff extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("Contracttrf_model", "mdlctf");
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("user_model", "user");

        $this->ceh = $this->load->database('mssql', TRUE);
        $this->data['menus'] = $this->menu->getMenu();
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

    public function ctTRFCode()
    {
        $access = $this->user->access('ctTRFCode');
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
                $this->data['result'] = $this->mdlctf->saveTRFCode($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_CODES');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Mã biểu cước";

        $this->load->view('header', $this->data);

        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["trfCodes"] = $this->mdlctf->loadTariffCodes();
        
        $this->load->view('contract_tariff/tariff_code', $this->data);
        $this->load->view('footer');
    }

    public function ctTariff_Standard()
    {
        $access = $this->user->access('ctTariff_Standard');
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
            $temp = $this->input->post('temp') ? $this->input->post('temp') : '';

            $this->data['list'] = $this->mdlctf->loadTariffStandard($temp);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            $applyDate = $this->input->post('applyDate') ? $this->input->post('applyDate') : '';
            $expireDate = $this->input->post('expireDate') ? $this->input->post('expireDate') : '';
            $ref_mark = $this->input->post('ref_mrk') ? $this->input->post('ref_mrk') : '';
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlctf->saveTariffSTD($saveData, $applyDate, $expireDate, $ref_mark);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete')
        {
            $delRowguids = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delRowguids) > 0)
            {
                $this->ceh->where_in('rowguid', $delRowguids)->delete('TRF_STD');
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Biểu cước chuẩn";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlctf->tarrifTemplate();
        $this->data["unitCodes"] = $this->mdlCommon->loadUnitCodes();
        $this->data["cargoTypes"] = $this->mdlCommon->loadCargoType();
        $this->data["trfCodes"] = $this->mdlctf->loadTRFSource();

        $this->data["cjModes"] = $this->mdlCommon->loadDeliveryMode();
        $this->data["method_modes"] = $this->mdlCommon->loadMethodMode();
        $this->data["cntrClass"] = $this->mdlCommon->loadCntrClass();

        $this->load->view('contract_tariff/tariff_standard', $this->data);
        $this->load->view('footer');
    }

    public function ctContract()
    {
        $access = $this->user->access('ctContract');
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
            $temp = $this->input->post('temp') ? $this->input->post('temp') : '';
            $this->data['lists'] = $this->mdlctf->loadContract($temp);
            echo json_encode($this->data);
            exit;
        }
        $this->data['title'] = "Hợp đồng (CKTP)";

        $this->load->view('header', $this->data);
        $this->data['temp'] = $this->mdlctf->contractTemplate();
        $this->load->view('contract_tariff/contract', $this->data);
        $this->load->view('footer');
    }

    public function ctTRFFreeDay()
    {
        $access = $this->user->access('ctTRFFreeDay');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Biểu cước lưu bãi";

        $this->load->view('header', $this->data);
        $this->data['oprs'] = $this->mdlCommon->getOprs();
        $this->data['payers'] = $this->mdlCommon->getPayers();
        
        $this->load->view('contract_tariff/tariff_free_day', $this->data);
        $this->load->view('footer');
    }
}

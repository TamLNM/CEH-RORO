<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scales extends CI_Controller {

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
        $this->load->model("common_bulk_model", "mdlCommonBulk");
        $this->load->model("order_model", "mdlOrder");
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

    public function scScales(){
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

        if ($action == 'view'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'getDataByPinCodeOrEirNo'){
                $PINCodeOREirNo   = $this->input->post('PINCodeOREirNo') ? $this->input->post('PINCodeOREirNo') : '';
                $this->data['bulkList'] = $this->mdlOrder->loadEirBulkListForGate($PINCodeOREirNo);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadTruckWeightList'){
                $this->data['list'] = $this->mdlCommon->loadTruckWeightList();
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'getDataByTruckNumberForIn'){
                $TruckNumber = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';

                $this->data['equipmentList'] = $this->mdlCommonBulk->loadEquipmentDataByTruckNumber($TruckNumber);
                $this->data['truckWeightDataWithEirNo'] = $this->mdlCommonBulk->loadTruckWeightDataWithEirNo($TruckNumber);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'getDataByTruckNumberForOut'){
                $TruckNumber = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';

                $this->data['list'] = $this->mdlOrder->loadJobGateList($TruckNumber);
                $this->data['remainCargoWeight'] = $this->mdlOrder->getRemainCargoWeight($TruckNumber);
                $this->data['secondWeightScale'] = $this->mdlOrder->getTwoScalesBefByTruckNo($TruckNumber);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'add' || $action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'addTruckWeightForIn'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                $StockRef = $this->input->post('StockRef') ? $this->input->post('StockRef') : '';

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->insertScalesDataForIn($saveData, $StockRef);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addTruckWeightWithBLForIn'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->insertScalesDataWithBLForIn($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'updateTruckWeightWithBLForIn'){
                 $saveData = $this->input->post('data') ? $this->input->post('data') : array();

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->updateScalesDataWithBLForIn($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            /*
            if ($child_action == 'updateTruckWeightForIn'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->updateScalesDataForIn($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }
            */

            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommon->saveScalesDataForOut($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = 'Cân';
        $this->load->view('header', $this->data);
        $this->data['truckWeightList'] = $this->mdlCommon->loadTruckWeightList();
        $this->data['equipmentList'] = $this->mdlCommonBulk->loadEquipmentList();
        $this->load->view('scales/scales', $this->data);
        $this->load->view('footer');
    }
}
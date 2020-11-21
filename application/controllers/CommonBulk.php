<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonBulk extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("common_bulk_model", "mdlCommonBulk");
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

    public function cmbEquipmentType(){
        $access = $this->user->access('cmbEquipmentType');
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
            
            if ($child_action == 'loadEquipmentTypeList'){
                $this->data['list'] = $this->mdlCommonBulk->loadEquipmentTypeList();        
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'add'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommonBulk->saveEquipmentType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlCommonBulk->updateEquipmentType($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlCommonBulk->deleteEquipmentType($delData);
                echo json_encode($this->data);
                exit;
            }
        }

    	$this->data['title'] = "Loại thiết bị";
        $this->load->view('header', $this->data);
        $this->data['equipmentTypeList'] = $this->mdlCommonBulk->loadEquipmentTypeList();
        $this->load->view('common_bulk/equipment_type', $this->data);
        $this->load->view('footer');
    }

    public function cmbEquipment(){
    	
    	$this->data['title'] = "Thiết bị";
        $this->load->view('header', $this->data);
        $this->data['equipmentList'] = $this->mdlCommonBulk->loadEquipmentList();
        $this->load->view('common_bulk/equipment', $this->data);
        $this->load->view('footer');
    }
}
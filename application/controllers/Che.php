<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class che extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->load->helper(array('form','url'));
        $this->ceh = $this->load->database('mssql', TRUE);
        $this->load->model("data_model", "mdlData");
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("vessel_model", "mdlVessel");
        $this->load->model("user_model", "user");
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

    public function index()
    {
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'updateCHEList'){
                $this->data['list'] = $this->mdlData->loadCHEList();
                echo json_encode($this->data);   
                exit;
            }
        }


        if($action == 'add' || $action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'updateYardJobStatus'){
                $VINNo      = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
                $JobStatus  = $this->input->post('JobStatus') ? $this->input->post('JobStatus') : '';
                $FinishDate = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';
                $Bay        = $this->input->post('Bay') ? $this->input->post('Bay') : '';
                $Row        = $this->input->post('Row') ? $this->input->post('Row') : '';

                $this->data['result'] = $this->mdlVessel->updateYardJobStatus($VINNo, $JobStatus, $FinishDate, $Bay, $Row);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'transformYardJob'){
                $VINNo      = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
                $Bay        = $this->input->post('Bay') ? $this->input->post('Bay') : '';
                $Row        = $this->input->post('Row') ? $this->input->post('Row') : '';

                $this->data['result'] = $this->mdlVessel->transformYardJob($VINNo, $Bay, $Row);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateStockData'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateStockData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'updatePositionStatus'){
                $row = $this->input->post('row')  ? $this->input->post('row') : '';
                $bay = $this->input->post('bay')  ? $this->input->post('bay') : '';
                $value = $this->input->post('value') ? $this->input->post('value') : 0;

                $this->data['result'] = $this->mdlVessel->updatePositionStatus($bay, $row, $value);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateGOTransfer'){
                $VINNo = $this->input->post('VINNo')  ? $this->input->post('VINNo') : '';
                $this->data['result'] = $this->mdlVessel->updateGOTransfer($VINNo);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateStockStatus'){
                $VMStatus = $this->input->post('VMStatus')  ? $this->input->post('VMStatus') : '';
                $StockRef = $this->input->post('StockRef')  ? $this->input->post('StockRef') : '';

                $this->data['result'] = $this->mdlData->updateStockStatus($StockRef, $VMStatus);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateYardData'){
                $VINNo = $this->input->post('VINNo')  ? $this->input->post('VINNo') : '';
                $JobTypeID = $this->input->post('JobTypeID')  ? $this->input->post('JobTypeID') : '';
                $JobStatus = $this->input->post('JobStatus')  ? $this->input->post('JobStatus') : '';
                $FinishDate = $this->input->post('FinishDate')  ? $this->input->post('FinishDate') : '';

                $this->data['result'] = $this->mdlData->updateYardData($VINNo, $JobTypeID, $JobStatus, $FinishDate);
                echo json_encode($this->data);
                exit;
            }
        }
        $this->data['title'] = "GIÁM SÁT BÃI";
        $this->data['CHEList'] = $this->mdlData->loadCHEList();
        $this->data['blockList'] = $this->mdlCommon->loadBlockByYardID('');
        $this->load->view('che', $this->data);
    }
}
    
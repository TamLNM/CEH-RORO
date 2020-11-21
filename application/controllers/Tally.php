<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tally extends CI_Controller {

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
        $this->load->model("data_bulk_model", "mdlDataBulk");
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("common_bulk_model", "mdlCommonBulk");
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
            
            if ($child_action == 'loadJobQuayList'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $this->data['list'] = $this->mdlData->loadJobQuayList($VoyageKey);
                echo json_encode($this->data);   
                exit;
            }

            if ($child_action == 'getMinPos'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $ClassID   = $this->input->post('ClassID')  ? $this->input->post('ClassID') : '';
                $IsLocalForeign = $this->input->post('IsLocalForeign') ? $this->input->post('IsLocalForeign') : '';
                $BillOfLading = $this->input->post('BillOfLading') ? $this->input->post('BillOfLading') : '';
                $this->data['list'] = $this->mdlVessel->getMinPost($VoyageKey, $ClassID, $IsLocalForeign, $BillOfLading);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadEquipmentList'){
                $this->data['list'] = $this->mdlCommonBulk->loadEquipmentList();
                echo json_encode($this->data);
                exit;
            }
        }

        if($action == 'add'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'addDamagedDetails'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->addDamagedDetails($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addYardJob'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->addYardJob($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }        

            if ($child_action == 'addStockInBulkData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockInBulkDataByTally($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }          
        }

        if($action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'updateQuayJobStatus'){
                $StockRef   = $this->input->post('StockRef') ? $this->input->post('StockRef') : '';
                $Remark     = $this->input->post('Remark') ? $this->input->post('Remark') : '';
                $JobStatus  = $this->input->post('JobStatus') ? $this->input->post('JobStatus') : '';

                $this->data['result'] = $this->mdlVessel->updateQuayJobStatus($StockRef, $Remark, $JobStatus);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateQuayJobData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateQuayJobData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'updatePosNotAvailable'){
                $Block   = $this->input->post('Block')  ? $this->input->post('Block')   : '';
                $Bay     = $this->input->post('Bay')    ? $this->input->post('Bay')     : '';
                $Row     = $this->input->post('Row')    ? $this->input->post('Row')     : '';
                $Tier    = $this->input->post('Tier')   ? $this->input->post('Tier')    : '';

                $this->data['result'] = $this->mdlVessel->updatePosNotAvailable($Block, $Bay, $Row, $Tier);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updatePosAvailable'){
                $Block   = $this->input->post('Block')  ? $this->input->post('Block')   : '';
                $Bay     = $this->input->post('Bay')    ? $this->input->post('Bay')     : '';
                $Row     = $this->input->post('Row')    ? $this->input->post('Row')     : '';
                $Tier    = $this->input->post('Tier')   ? $this->input->post('Tier')    : '';

                $this->data['result'] = $this->mdlVessel->updatePosAvailable($Block, $Bay, $Row, $Tier);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateStockVMStatus'){
                $StockRef   = $this->input->post('StockRef')  ? $this->input->post('StockRef')   : '';
                $VMStatus   = $this->input->post('VMStatus')  ? $this->input->post('VMStatus')   : '';
                $Remark     = $this->input->post('Remark')  ? $this->input->post('Remark')   : '';

                $this->data['result'] = $this->mdlVessel->updateStockVMStatus($StockRef, $VMStatus, $Remark);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateQuayData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                $data_type  = $this->input->post('data_type')  ? $this->input->post('data_type')   : '';

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateQuayData($saveData, $data_type);
                    echo json_encode($this->data);
                    exit;
                }
            }
           

            if ($child_action == 'updateStockBulkData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->updateStockBulkData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'updateQuayBulkJobData'){
                $rowguid      = $this->input->post('rowguid') ? $this->input->post('rowguid') : '';
                $TruckNumber  = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';
                $JobStatus    = $this->input->post('JobStatus') ? $this->input->post('JobStatus') : '';
                $StartDate    = $this->input->post('StartDate') ? $this->input->post('StartDate') : '';
                $FinishDate   = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';

                $this->data['result'] = $this->mdlVessel->updateQuayBulkJobData($rowguid, $TruckNumber, $JobStatus
                    , $StartDate, $FinishDate);
                echo json_encode($this->data);
                exit;
            }
        }  

        $this->data['title']        = "Tally";
        $this->data['damagedTypeList']   = $this->mdlCommon->loadDamagedTypeList();
        $this->data['damagedList']   = $this->mdlCommon->loadDamagedList();
        $this->data['vesselList']   = $this->mdlData->loadVesselListForManifestScreen('', '', '');
        $this->data['jobTypeList']  = $this->mdlCommon->loadAllColJobTypes();
        $this->load->view('tally', $this->data);
    }
}
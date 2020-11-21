<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gate extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->load->helper(array('form','url'));
        $this->ceh = $this->load->database('mssql', TRUE);
        
        $this->load->model("order_model", "mdlOrder");
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("data_model", "mdlData");
        $this->load->model("data_bulk_model", "mdlDataBulk");

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

        if ($action == 'view'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            
            if ($child_action == 'getDataByPinCodeOrEirNo'){
                $PINCodeOREirNo   = $this->input->post('PINCodeOREirNo') ? $this->input->post('PINCodeOREirNo') : '';

                $this->data['eirList']  = $this->mdlOrder->loadEirListForGate($PINCodeOREirNo, '');
                $this->data['bulkList'] = $this->mdlOrder->loadEirBulkListForGate($PINCodeOREirNo);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'getDataByVINNo'){
                $VINNo   = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';

                $this->data['list'] = $this->mdlOrder->loadEirListForGate('', $VINNo);;
                echo json_encode($this->data);
                exit;
            }
            
            if ($child_action == 'loadGateList'){
                $this->data['gateListWithStock'] = $this->mdlOrder->loadGateList();
                $this->data['gateListWithBulk']  = $this->mdlOrder->loadGateBulkList('');
                $this->data['gateBulkListWithBL']  = $this->mdlOrder->loadGateBulkListWithBL();
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadEirBulkByEirNo'){
                $EirNo   = $this->input->post('EirNo') ? $this->input->post('EirNo') : '';

                $this->data['list']  = $this->mdlOrder->loadEirBulkListForGate($EirNo);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'checkTruckInQueue'){
                $TruckNumber   = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';
                
                $this->data['list']  = $this->mdlOrder->checkTruckInQueue($TruckNumber);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'add'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'addNewGateData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlOrder->saveGateData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addNewYardData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlOrder->saveYardData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            /*
            if ($child_action == 'addStockBulk'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlOrder->saveStockBulk($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }
            */

            if ($child_action == 'addStockInBulk'){
                $saveData    = $this->input->post('data') ? $this->input->post('data') : array();
                $TruckNumber = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockInBulk($saveData, $TruckNumber);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addQuayBulkForOut'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveJobQuayForBulkOut($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addStockOut'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                $TruckNumber = $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';

                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockOutBulk($saveData, $TruckNumber);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addScalesData'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlCommon->saveScalesData($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }

            if ($child_action == 'addStockOutWithClassIn'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockOutBulkDataByTallyWithClassIn($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }
            
            if ($child_action == 'addStockOutWithClassOut'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlDataBulk->saveStockOutBulkDataByTallyWithClassOut($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }            
        }

        if ($action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if ($child_action == 'updateORDEir'){
                $FinishDate = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';
                $EirNo      = $this->input->post('EirNo') ? $this->input->post('EirNo') : '';
                $rowguid    = $this->input->post('rowguid') ? $this->input->post('rowguid') : '';
            
                $this->data['result'] = $this->mdlOrder->updateORDEir($EirNo, $FinishDate, $rowguid);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateORDBulk'){
                $FinishDate = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';
                $EirNo      = $this->input->post('EirNo') ? $this->input->post('EirNo') : '';
                $rowguid    = $this->input->post('rowguid') ? $this->input->post('rowguid') : '';
                
                $this->data['result'] = $this->mdlOrder->updateORDBulk($EirNo, $FinishDate, $rowguid);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateStockData'){
                $PINCodeOREirNo = $this->input->post('PINCodeOREirNo') ? $this->input->post('PINCodeOREirNo') : '';
                $VINNo = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
                $VMStatus = $this->input->post('VMStatus') ? $this->input->post('VMStatus') : '';
                $DateOut = $this->input->post('DateOut') ? $this->input->post('DateOut') : '';

                $this->data['result'] = $this->mdlData->updateStockDataByGate($PINCodeOREirNo, $VINNo, $VMStatus, $DateOut);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'updateGateData'){
                $StockRef   = $this->input->post('StockRef') ? $this->input->post('StockRef') : '';
                $TruckNumber= $this->input->post('TruckNumber') ? $this->input->post('TruckNumber') : '';
                $Sequence   = $this->input->post('Sequence') ? $this->input->post('Sequence') : '';
                $VINNo      = $this->input->post('VINNo') ? $this->input->post('VINNo') : '';
                $GateOutID  = $this->input->post('GateOutID') ? $this->input->post('GateOutID') : '';
                $DateOut    = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';
                $Remark     = $this->input->post('Remark') ? $this->input->post('Remark') : '';
                $PINCodeOREirNo = $this->input->post('PINCodeOREirNo') ? $this->input->post('PINCodeOREirNo') : '';

                $this->data['result'] = $this->mdlOrder->updateGateData($StockRef, $VINNo, $GateOutID, $DateOut, $Remark, $PINCodeOREirNo, $TruckNumber, $Sequence);
                echo json_encode($this->data);
                exit;
            }
        }
        $this->data['title'] = "GIAO NHẬN CỔNG";
        $this->data['gateList'] = $this->mdlCommon->loadGateList();
        $this->load->view('gate', $this->data);
    }
}
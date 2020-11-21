<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vessel extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("vessel_delivery_model", "mdlVesselDelivery");
        $this->load->model("vessel_model", "mdlVessel");
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("data_model", "mdlData");
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

    public function vsVessel()
    {
        $access = $this->user->access('vsVessel');

        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
               
        // Add, Edit, Delete, Load image
        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view')
        {
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            if ($child_action == ''){
                $vesselId           = $this->input->post('vesselId') ? $this->input->post('vesselId') : '';
                $vesselName         = $this->input->post('vesselName') ? $this->input->post('vesselName') : '';
                $this->data['list'] = $this->mdlVessel->loadVessel($vesselId, $vesselName);
                echo json_encode($this->data);               
            }
            else{   
                $imgName = $this->input->post('image_name') ? $this->input->post('image_name') : '';
                $imageNames = array();
                if($imgName != ''){
                   foreach( glob( FCPATH."/assets/img/vessel_images/".$imgName."*.{jpg,png,gif,bmp}", GLOB_BRACE) as $filename ){
                        array_push( $imageNames, basename($filename) ) ;
                    }
                }
                $this->data['image'] = $imageNames;
                echo json_encode($this->data);
            }
            exit;
        }


        if($action == 'add' || $action == 'edit'){
            $imgSrc = $this->input->post('imgSrc') ? $this->input->post('imgSrc') : '';
            $imgName = $this->input->post('imgName') ? $this->input->post('imgName') : '';
            
            if (strpos($imgSrc, '/assets/img')){}
            else
            {
                if( $imgSrc != "")
                {
                    if ( strpos( mime_content_type( $imgSrc ), "image" ) === false ) {
                        $this->data["image_deny"] = "Có hình ảnh không đúng định dạng!";
                        echo json_encode($this->data);
                        exit;
                    }

                    if( preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $imgSrc, $matchings))
                    {
                        $img = base64_decode($matchings['image']);
                        $extension = $matchings['extension'] == "jpeg" ? "jpg" : $matchings['extension'];
                        $filename = sprintf("%s/assets/img/vessel_images/%s.%s", FCPATH, $imgName, $extension);
                        file_put_contents( $filename, $img);
                    }
                }
            }
            

            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlVessel->saveVessel($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlVessel->deleteVessel($delData);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = 'Định nghĩa thông tin tàu';
        $this->load->view('header', $this->data);
        $this->data['oprList'] = $this->mdlVessel->loadOprList();
        $this->data['nationList'] = $this->mdlVessel->loadNationList();
        $this->load->view('vessel/vessel', $this->data);
        $this->load->view('footer');
    }

    public function vsVesselVisit()
    {
        $access = $this->user->access('vsVesselVisit');

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
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            if($child_action == 'loadDataForVesselVisitTable'){
                $this->data['list'] = $this->mdlVessel->loadAllColVesselVisit('');
                echo json_encode($this->data);
                exit;
            }

            if($child_action == 'loadDataForVesselVisitConfirmTable'){
                $this->data['list'] = $this->mdlVessel->loadVesselVisitConfirm();
                echo json_encode($this->data);
                exit;
            }

            if($child_action == 'loadPortDataByInOutLane'){
                $InLane     = $this->input->post('InLane') ? $this->input->post('InLane') : ''; 
                $OutLane    = $this->input->post('OutLane') ? $this->input->post('OutLane') : ''; 
                $this->data['list'] = $this->mdlVessel->loadPortDataByInOutLane($InLane, $OutLane);
                echo json_encode($this->data);
                exit;
            }

            $vesselID = $this->input->post('vesselID') ? $this->input->post('vesselID') : '';
            $this->data['list'] = $this->mdlVessel->loadAllColVesselVisit($vesselID);
            echo json_encode($this->data);
            exit;
        }

        if($action == 'add' || $action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';
            if ($child_action == 'updatedata'){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateVesselVisit($saveData);
                    echo json_encode($this->data);
                    exit;
                } 
            }

            $numTab = $this->input->post('numTab') ? $this->input->post('numTab') : '';

            if ($numTab == 1){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->saveVesselVisit($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }
            else if ($numTab == 2){
                $saveData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateVesselVisit($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }            
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlVessel->deleteVesselVisit($delData);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = "Kế hoạch tàu cập bến";
        $this->load->view('header', $this->data);
        $this->data['bittList'] = $this->mdlVessel->loadBittList();
        $this->data['berthList'] = $this->mdlVessel->loadBerthList();              
        $this->data['vesselList'] = $this->mdlVessel->loadVesselList();
        $this->data['vesselVisitList'] = $this->mdlVessel->loadAllColVesselVisit('');
        $this->data['vesselVisitConfirmList'] = $this->mdlVessel->loadVesselVisitConfirm();
        $this->data['portList'] = $this->mdlVessel->loadPortListForVesselVisitScreen();
        $this->data['laneList'] = $this->mdlCommon->loadLaneByID('');
        $this->load->view('vessel/vessel_visit', $this->data);
        $this->load->view('footer');
    }

    public function vsYardPlanning(){

        $access = $this->user->access('vsYardPlanning');

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

     
            if ($child_action == 'loadBLORBookingNo'){
                $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $this->data['list'] = $this->mdlVessel->loadBLORBookingNoList($VoyageKey);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'loadColorAndSeqList'){
                $this->data['list'] = $this->mdlVessel->loadColorAndSeqList();
                echo json_encode($this->data);
                exit;
            }

            $Block = $this->input->post('Block') ? $this->input->post('Block') : '';
            $this->data['list'] = $this->mdlVessel->loadPlan($Block);
            echo json_encode($this->data);
            exit;
        }

        if ($action == 'add'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            /*
            if ($child_action == 'saveBlockDetail'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->saveBlockDetails($saveData);
                    echo json_encode($this->data);
                    exit;
                }
            }
            */

            if ($child_action == 'savePlan'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->savePlan($saveData);
                    echo json_encode($this->data);
                    exit;
                }              
            }

            if ($child_action == 'updateSequenceInPlan'){
                $saveData   = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($saveData) > 0){
                    $this->data['result'] = $this->mdlVessel->updateSequenceInPlan($saveData);
                    echo json_encode($this->data);
                    exit;
                }              
            }
        }
        
        if ($action == 'delete'){
            //$child_action = $this->input->post('child_action') ? $this->input->post('child_action') : '';

            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlVessel->deletePlan($delData);
            }
            echo json_encode($this->data);
            exit;   

            /*
            if ($child_action == 'deleteBlockDetails'){
                 
            }

            if ($child_action == 'deletePlanWithOutBLORBookingNo'){
                $delData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($delData) > 0)
                {
                    $this->data['result'] = $this->mdlVessel->deletePlanWithOutBLORBookingNo($delData);
                }
                echo json_encode($this->data);
                exit;    
            }

            if ($child_action == 'deletePlanWithBLORBookingNo'){
                $delData = $this->input->post('data') ? $this->input->post('data') : array();
                if(count($delData) > 0)
                {
                    $this->data['result'] = $this->mdlVessel->deletePlanWithBLORBookingNo($delData);
                }
                echo json_encode($this->data);
                exit;    
            }
            */
        }

        $this->data['title'] = 'Kế hoạch bãi';
        $this->data['carBrandList'] = $this->mdlVessel->loadCarBrandList();
        $this->data['carTypeList']  = $this->mdlVessel->loadCarTypeList();
        $this->data['classList']    = $this->mdlVessel->loadClassList();
        $this->data['portList']     = $this->mdlVessel->loadPortList();
        $this->data['customerList'] = $this->mdlData->loadCustomerListForStockScreen();
        $this->data['blockList']    = $this->mdlCommon->loadBlockByYardID('');
        $this->data['vesselList'] = $this->mdlVessel->loadVesselVisitList();
        $this->data['BLORBookingList'] = $this->mdlVessel->loadBLORBookingNoList('');
        $this->data['colorAndSeqList'] = $this->mdlVessel->loadColorAndSeqList();
        $this->load->view('header', $this->data);
        $this->load->view('vessel/yard_planning', $this->data);
        $this->load->view('footer');
    }
    
    public function vsVesselChart(){
        $access = $this->user->access('vsVesselChart');
        
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Biểu đồ lịch tàu';
        $this->load->view('header', $this->data);
        $this->load->view('report/LichTau', $this->data);
        $this->load->view('footer');   
    }
}   
    
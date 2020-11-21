<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("task_model", "mdltask");
        $this->load->model("common_model", "mdlcommon");
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

    public function tskBooking(){
        $access = $this->user->access('tskBooking');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';

            if( $act == 'load_cntr_for_booking' ){
                $this->data["conts"] = $this->mdltask->loadCntrForBooking();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'search_cntr'){
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $result = $this->ceh->select('BLNo')->where('CntrNo', $cntrNo)->limit(1)->get('CNTR_DETAILS')->row_array();
                if(count($result) > 0){
                    $this->data['BLNo'] = $result['BLNo'];
                }
                echo json_encode($this->data);
                exit;
            }
            if($act == 'genSrvOdrNo'){
                $browser_eirs = $this->input->post('browser_eirs') ? $this->input->post('browser_eirs') : array();
                $maxeir = $this->input->post('maxeir') ? $this->input->post('maxeir') : array();
                $result = $this->gnrEirNo($browser_eirs, $maxeir);
                $this->data['newEIRNo'] = $result[0];
                $this->data['maxeir'] = $result[1];
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID, 'services');
                exit;
            }
        }
        
        if($action == "save") {
            $args = $this->input->post('args') ? $this->input->post('args') : array();

            $this->data["message"] = $this->mdltask->saveBooking( $args );

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Đăng ký booking';

        $this->data["oprs"] = $this->mdlcommon->getOprs();
        $this->data["sztps"] = $this->mdlcommon->getSizeType();

        $this->load->view('header', $this->data);
        
        $this->load->view('task/booking', $this->data);
        $this->load->view('footer');
    }

    public function tskServiceOrder(){
        $access = $this->user->access('tskServiceOrder');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_bill'){
                $blno = $this->input->post('billNo') ? $this->input->post('billNo') : '';
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $this->data['list'] = $this->mdltask->load_service_orders($blno, $cntrNo);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_cntr'){
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $result = $this->ceh->select('BLNo')->where('CntrNo', $cntrNo)->limit(1)->get('CNTR_DETAILS')->row_array();
                if(count($result) > 0){
                    $this->data['BLNo'] = $result['BLNo'];
                }
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID, 'services');
                exit;
            }
        }
        
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_SRV_ODR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }
    
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Lệnh dịch vụ';

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdltask->getServices('isYardSRV', 1);
        $this->load->view('task/service_order', $this->data);
        $this->load->view('footer');
    }

    public function tskStuffingOrder(){
        $access = $this->user->access('tskStuffingOrder');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'getLane'){
                $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
                $this->data['oprs'] = $this->mdltask->getLaneOprs($shipkey);
                $this->data['ports'] = $this->mdltask->getLanePortID($shipkey);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_attach_srv'){
                $orderType = $this->input->post('order_type') ? $this->input->post('order_type') : '';
                $this->data['lists'] = $this->mdltask->getAttachServices($orderType);

                echo json_encode($this->data);
                exit;
            }
            if($act == 'genSrvOdrNo'){
                $browser_eirs = $this->input->post('browser_eirs') ? $this->input->post('browser_eirs') : array();
                $maxeir = $this->input->post('maxeir') ? $this->input->post('maxeir') : array();
                $result = $this->gnrEirNo($browser_eirs, $maxeir);
                $this->data['newEIRNo'] = $result[0];
                $this->data['maxeir'] = $result[1];
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID, 'services');
                exit;
            }
        }
        
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_SRV_ODR_INV($data, array("STUFF_CHK")); // update STUFF_CHK -> Y to CNTR_DETAILS
            
            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Lệnh đóng hàng vào container';

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdltask->getServices('ischkCFS', 1);
        $this->data['contList'] = $this->mdltask->load_stuffing_conts();

        $this->data['sizeTypes'] = $this->mdlcommon->getSizeType();
        $this->data['cargoTypes'] = $this->mdltask->getCargoTypes();

        $this->load->view('task/stuffing_order', $this->data);
        $this->load->view('footer');
    }

    public function tskUnstuffingOrder(){
        $access = $this->user->access('tskUnstuffingOrder');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_attach_srv'){
                $orderType = $this->input->post('order_type') ? $this->input->post('order_type') : '';
                $this->data['lists'] = $this->mdltask->getAttachServices($orderType);

                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID, 'services');
                exit;
            }
        }
        
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_SRV_ODR_INV($data, array("UNSTUFF_CHK")); //, array("UNSTUFF_CHK") , update Y to UNSTUFF_CHK
            
            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Lệnh rút hàng từ container';

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdltask->getServices('ischkCFS', 2);
        $this->data['contList'] = $this->mdltask->load_unstuffing_conts();

        $this->load->view('task/unstuffing_order', $this->data);
        $this->load->view('footer');
    }

    public function tskTransStuffOrder(){
        $access = $this->user->access('tskTransStuffOrder');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_attach_srv'){
                $orderType = $this->input->post('order_type') ? $this->input->post('order_type') : '';
                $this->data['lists'] = $this->mdltask->getAttachServices($orderType);

                echo json_encode($this->data);
                exit;
            }
            if($act == 'genSrvOdrNo'){
                $browser_eirs = $this->input->post('browser_eirs') ? $this->input->post('browser_eirs') : array();
                $maxeir = $this->input->post('maxeir') ? $this->input->post('maxeir') : array();
                $result = $this->gnrEirNo($browser_eirs, $maxeir);
                $this->data['newEIRNo'] = $result[0];
                $this->data['maxeir'] = $result[1];
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID, 'services');
                exit;
            }
        }
        
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_SRV_ODR_INV($data);
            
            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }
            
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Lệnh đóng rút sang container';

        $this->load->view('header', $this->data);
        $this->data['services'] = $this->mdltask->getServices('ischkCFS', 2);
        $this->data['contList'] = $this->mdltask->load_transstuffing_conts();
        $this->load->view('task/transstuff_order', $this->data);
        $this->load->view('footer');
    }

    public function tskImportPickup()
    {
        $access = $this->user->access('tskImportPickup');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_bill'){
                $blno = $this->input->post('billNo') ? $this->input->post('billNo') : '';
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $this->data['list'] = $this->mdltask->load_ip_cntr_details($blno, $cntrNo);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_cntr'){
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $result = $this->ceh->select('BLNo')->where('CntrNo', $cntrNo)->limit(1)->get('CNTR_DETAILS')->row_array();
                if(count($result) > 0){
                    $this->data['BLNo'] = $result['BLNo'];
                }
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);
            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }
    
            echo json_encode($this->data);
            exit;
        }
        $this->data['title'] = "Lệnh giao cont hàng";

        $this->load->view('header', $this->data);
        $this->data['relocation'] = $this->mdltask->getRelocation();
        $this->load->view('task/import_pickup', $this->data);
        $this->load->view('footer');
    }

    public function tskEmptyPickup()
    {
        $access = $this->user->access('tskEmptyPickup');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_booking'){
                $bkno = $this->input->post('bkno') ? $this->input->post('bkno') : '';
                $cntrno = $this->input->post('cntrno') ? $this->input->post('cntrno') : '';
                $this->data['bookinglist'] = $this->mdltask->getBookingList($bkno, $cntrno);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);
            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Lệnh giao cont rỗng";

        $this->load->view('header', $this->data);
        $this->load->view('task/empty_pickup', $this->data);
        $this->load->view('footer');
    }
    public function tskFCL_Pre_Advice()
    {
        $access = $this->user->access('tskFCL_Pre_Advice');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }

            if($act == 'search_cntr'){
                $cntrNo = $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '';
                $result = $this->ceh->select('BLNo')->where('CntrNo', $cntrNo)->limit(1)->get('CNTR_DETAILS')->row_array();
                if(count($result) > 0){
                    $this->data['BLNo'] = $result['BLNo'];
                }
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }
            if($act == 'getLane'){
                $shipkey = $this->input->post('shipkey') ? $this->input->post('shipkey') : '';
                $this->data['oprs'] = $this->mdltask->getLaneOprs($shipkey);
                $this->data['ports'] = $this->mdltask->getLanePortID($shipkey);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Lệnh hạ cont hàng";

        $this->load->view('header', $this->data);
        $this->data['cargoTypes'] = json_encode($this->mdltask->getCargoTypes());
        $this->data['sizeTypes'] = json_encode($this->mdlcommon->getSizeType());
        $this->load->view('task/fcl_pre_advice', $this->data);
        $this->load->view('footer');
    }

    public function tskPre_Advice()
    {
        $access = $this->user->access('tskPre_Advice');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Lệnh hạ cont rỗng";

        $this->load->view('header', $this->data);
        $this->data['cargoTypes'] = json_encode($this->mdltask->getCargoTypes());
        $this->data['sizeTypes'] = json_encode($this->mdlcommon->getSizeType());
        $this->data['oprs'] = json_encode($this->mdlcommon->getOprs());
        $this->load->view('task/empty_pre_advice', $this->data);
        $this->load->view('footer');
    }

    public function tskPaymentCredit()
    {
        $access = $this->user->access('tskPaymentCredit');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'load_payer'){
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_barge'){
                $this->data['barges'] = $this->mdltask->getBarge();
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }
        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tính cước thu sau";

        $this->load->view('header', $this->data);
        $this->load->view('task/payment_credit', $this->data);
        $this->load->view('footer');
    }

    public function tskRenewedOrder(){
        $access = $this->user->access('tskRenewedOrder');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'search')
            {
                $args = array(
                    "fromDate" => $this->input->post('fromDate') ? $this->input->post('fromDate') : '',
                    "toDate" => $this->input->post('toDate') ? $this->input->post('toDate') : '',
                    "eirNo" => $this->input->post('eirNo') ? $this->input->post('eirNo') : '',
                    "cntrNo" => $this->input->post('cntrNo') ? $this->input->post('cntrNo') : '',
                    "pinCode" => $this->input->post('pinCode') ? $this->input->post('pinCode') : ''
                );

                $this->data['list'] = $this->mdltask->getRenewedOrder($args);
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payer')
            {
                $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserID"));
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment')
            {
                $datas = $this->input->post('datas') ? $this->input->post('datas') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : "";

                $lst = $this->mdltask->load_SSOrder_Renewed(array_column($datas, "EIRNo"));

                $yardDays = 1;
                $pluginHours = 0;
                foreach ($datas as $item) {
                    if($item["NewExpPluginDate"] != ""){
                        $timeOldPlug = strtotime($this->funcs->dbDateTime($item["ExpPluginDate"]));
                        $timeNewPlug = strtotime($this->funcs->dbDateTime($item["NewExpPluginDate"]));

                        $timePlugin = round( ( $timeNewPlug - $timeOldPlug ) / ( 60 * 60 ) );
                        foreach ($lst as $key => $value) {
                            if( $value["EIRNo"] == $item["EIRNo"] ){
                                $strNote = " [Số lệnh / Hạn điện cũ / Hạn điện mới: "
                                                                            .$item["EIRNo"]." / ".$item["ExpPluginDate"]." / ".$item["NewExpPluginDate"]."] ";
                                $lst[$key]["CJMode_CD"] = "SDD";
                                $lst[$key]["ExpPluginDate"] = $item["NewExpPluginDate"];
                                $lst[$key]["Note"] = isset($lst[$key]["Note"]) 
                                                        ? $lst[$key]["Note"].$strNote
                                                        : $strNote;

                                $pluginHours += $timePlugin;
                            }
                        }
                    }else{
                        $oldDateYard = strtotime($this->funcs->dbDateTime($item["ExpDate"]));
                        $newDateYard = strtotime($this->funcs->dbDateTime($item["NewExpDate"]));

                        $daysinYard = round( ( $newDateYard - $oldDateYard ) / ( 60 * 60 * 24 ) );
                        foreach ($lst as $key => $value) {
                            if( $value["EIRNo"] == $item["EIRNo"] ){

                                $lst[$key]["CJMode_CD"] = "LBC";
                                $lst[$key]["ExpDate"] = $item["NewExpDate"];

                                $strNote = " [Số lệnh / Hạn lệnh cũ / Hạn lệnh mới: "
                                                                            .$item["EIRNo"]." / ".$item["ExpDate"]." / ".$item["NewExpDate"]."] ";
                                
                                $lst[$key]["Note"] = isset($lst[$key]["Note"]) 
                                                        ? $lst[$key]["Note"].$strNote
                                                        : $strNote;

                                $yardDays += $daysinYard;
                            }
                        }
                    }
                }

                $addinfo = array(
                    "Quantity" => array(
                        "LBC" => $yardDays,
                        "SDD" => $pluginHours
                    )
                );

                $this->calculate_payment($lst, $cusID, 'services', $addinfo);

                exit;
            }
        }
        
        if($action == "save") {
            $act = $this->input->post('act') ? $this->input->post('act') : "";
            $updateEirs = $this->input->post('updateEIR') ? $this->input->post('updateEIR') : array();

            if( $act == "updateOnly"){
                $this->data["message"] = $this->mdltask->updateEIR_byRenewed( $updateEirs );
                echo json_encode( $this->data );
                exit;
            }

            $data = $this->input->post('data') ? $this->input->post('data') : array();

            $this->data['message'] = $this->mdltask->save_SRV_ODR_INV($data);

            $this->mdltask->updateEIR_byRenewed( $updateEirs );

            if(isset($data['invInfo'])){
                $this->data['invInfo'] = $data['invInfo'];
            }
    
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Gia hạn lệnh';

        $this->load->view('header', $this->data);
        $this->load->view('task/renewed_order', $this->data);
        $this->load->view('footer');
    }

    public function tskEirInquiry()
    {
        $access = $this->user->access('tskEirInquiry');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }
        
        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $act = $this->input->post('act') ? $this->input->post('act') : '';
            if($act == 'searh_ship'){
                $arrstt = $this->input->post('arrStatus') ? $this->input->post('arrStatus') : '';
                $year = $this->input->post('shipyear') ? $this->input->post('shipyear') : '';
                $name = $this->input->post('shipname') ? $this->input->post('shipname') : '';

                $this->data['vsls'] = $this->mdltask->searchShip($arrstt, $year, $name);
                echo json_encode($this->data);
                exit;
            }
            if($act == 'search_order'){
                $args = $this->input->post('args') ? $this->input->post('args') : array();

                $this->data["results"] = $this->mdltask->loadEirInquiry( $args );
                $this->data["countOrder"] = $this->mdltask->countOrder( $args );

                echo json_encode($this->data);
                exit;
            }

            if($act == "load_img"){
                $orderNo = $this->input->post('orderNo') ? $this->input->post('orderNo') : '';
                $imageNames = array();
                if($orderNo != ''){
                    foreach( glob( FCPATH."/assets/img/ct/".$orderNo."*.{jpg,png,gif}", GLOB_BRACE) as $filename ){
                        array_push( $imageNames, basename($filename) ) ;
                    }
                }
                $this->data["imgs"] = $imageNames;
                echo json_encode($this->data);
                exit;
            }

            if($act == 'load_payment'){
                $list = $this->input->post('list') ? $this->input->post('list') : array();
                $cusID = $this->input->post('cusID') ? $this->input->post('cusID') : '';
                $this->calculate_payment($list, $cusID);
                exit;
            }
        }

        if($action == "save") {
            $data = $this->input->post('data') ? $this->input->post('data') : array();
            $this->data['message'] = $this->mdltask->save_EIR_INV($data);
            $this->data['invInfo'] = $data['invInfo'];

            $attach_img = $this->input->post('attach_img') ? $this->input->post('attach_img') : array();
            $eirNo = $this->input->post('eirno') ? $this->input->post('eirno') : '';

            $i = 1;
            foreach ($attach_img as $imgData) 
            {
                if( !isset( $imgData ) || $imgData == "")
                {
                    continue;
                }

                if( preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $imgData, $matchings))
                {
                    $img = base64_decode($matchings['image']);
                    $extension = $matchings['extension'] == "jpeg" ? "jpg" : $matchings['extension'];
                    $filename = sprintf("%s/assets/img/ct/%s_%s.%s", FCPATH, $eirNo, $i, $extension);

                    file_put_contents( $filename, $img);

                    $i++;
                }
            }

            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Truy vấn thông tin lệnh";

        $this->load->view('header', $this->data);
        $this->data['cargoTypes'] = json_encode($this->mdltask->getCargoTypes());
        $this->data['sizeTypes'] = json_encode($this->mdlcommon->getSizeType());
        $this->data['payers'] = $this->mdltask->getPayers($this->session->userdata("UserName"));
        $this->load->view('task/eir_inquiry', $this->data);
        $this->load->view('footer');
    }

    public function payment_success()
    {
        $this->data['invInfo'] = $this->input->post('invInfo') ? (array)json_decode($this->input->post('invInfo'), true) : array();
        $this->data['title'] = "Cấp lệnh thành công!";

        $this->data['menus'] = $this->menu->getMenu();
        $this->load->view('header', $this->data);
        $this->load->view('task/payment_success', $this->data);
        $this->load->view('footer');
    }

    private function getContSize($sztype){
        switch(substr($sztype,0,1)){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
        }
        return "0";
    }

    private function calculate_payment( $list, $cusID, $task_types = '', $addInfo = array() ){
        $trf_stds = array();
        switch ($task_types) {
            case 'services':
                $trf_stds = $this->mdltask->loadServiceTariff($list);
                break;
            default:
                $trf_stds = $this->mdltask->loadTariffSTD($list);
                break;
        }

        if(count($trf_stds) == 0) {
            $this->data['results'] = array();
            echo json_encode($this->data);
            return;
        }

        $newarray = array();
        $calc_arr = array();
        $sumAMT = 0; $sumVAT_AMT = 0; $sumSub_AMT = 0; $sumDIS_AMT = 0;

        $err = array();
        foreach ($trf_stds as $key=>$val ) {
            if(!is_array($val)){
                array_push($err, $val);
                continue;
            }

            $newKey =$val['ISO_SZTP']."-".$val["FE"]."-".$val["CARGO_TYPE"]."-".$val["IsLocal"];

            $newarray[$newKey][$key] = $val;
        }

        foreach($newarray as $newkey => $newitem){
            $cont_count_in_tariff = count($newitem);
            foreach ($newitem as $ka=>$kv) {
                $check_continue = false;
                if(count($calc_arr) > 0 ){
                    foreach ($calc_arr as $idx => $tr) {
                        $prefix_compare = $tr['ISO_SZTP']."-".$tr['FE']."-".$tr['Cargotype']."-".$tr['IsLocal'];

                        if( $kv['TRF_CODE'] == $tr['TariffCode'] && $newkey == $prefix_compare ){
                            $check_continue = true;
                            continue;
                        }
                    }
                }

                if($check_continue) continue;
//                        && in_array($kv['TRF_CODE'], $calculated_trfcode) && in_array($newkey, array_column($calc_arr, 'SIZE'))

                $cont_ISO_SIZE = $this->getContSize(explode( "-" ,$newkey)[0]);

                $rs = array(
                    'DraftInvoice'=>'',
                    // 'OrderNo'=> $kv['OrderNo'],
                    'TariffCode'=>$kv['TRF_CODE'],
                    'TariffDescription'=>$kv['TRF_STD_DESC'],
                    'Unit'=> '',
                    'JobMode'=>$kv['JOB_KIND'],
                    'DeliveryMethod'=>$kv['DMETHOD_CD'],
                    'Cargotype'=>$kv['CARGO_TYPE'],
                    'ISO_SZTP'=>$kv['ISO_SZTP'],
                    'FE'=>$kv['FE'],
                    'IsLocal'=>$kv['IsLocal'],
                    'Quantity'=> 0,
                    'StandardTariff'=> $kv['AMT_'.$kv['FE'].$cont_ISO_SIZE],
                    'DiscountTariff'=> 0,
                    'DiscountedTariff'=>0,
                    'Amount'=> 0,
                    'VatRate'=>$kv['VAT'],
                    'VATAmount'=>0,
                    'SubAmount'=>0,
                    'Currency'=>$kv['CURRENCYID'],
                    'SIZE' => $cont_ISO_SIZE,
                    'CNTR_JOB_TYPE' => $kv['CNTR_JOB_TYPE'],
                    'IX_CD' => $kv['IX_CD'],
                    'VAT_CHK' => $kv['INCLUDE_VAT']
                );


                $rs['Unit'] = $this->mdltask->getTRF_unitCode($kv['TRF_CODE']);

                if( isset( $addInfo["Quantity"][ $kv["CJMode_CD"] ] ) ){
                    $rs["Quantity"] = $addInfo["Quantity"][ $kv["CJMode_CD"] ];
                }else{
                    $rs['Quantity'] = $cont_count_in_tariff;
                }

                //get discount for tariff
                $wheres = array(
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $this->funcs->dbDateTime($kv['IssueDate']),
                    $kv['TRF_CODE'],
                    $kv['OprID'],
                    $cusID,
                    $kv['CARGO_TYPE'],
                    $kv['IX_CD'],
                    $kv['DMETHOD_CD'],
                    $kv['JOB_KIND'],
                    $kv['CNTR_JOB_TYPE'],
                    $kv['CURRENCYID'],
                    $kv['IsLocal'],
                );

                $rs['DiscountTariff'] = ($rs['Quantity'] === null || $rs['Quantity'] == 0) ? 0 : $this->mdltask->getDiscount($cont_ISO_SIZE, $rs['FE'], $wheres);
                $rs['DiscountedTariff'] = $kv['INCLUDE_VAT'] === "1" ? ($rs['StandardTariff'] + $rs['DiscountTariff'])/(((int)$kv['VAT']/100)+1) : ($rs['StandardTariff'] + $rs['DiscountTariff']);

                $rs['Amount'] = ($rs['Quantity'] * $rs['DiscountedTariff']);
                $rs['VATAmount'] = ($rs['Amount'] * ($rs['VatRate']/100));
                $rs['SubAmount'] = ($rs['Amount'] + $rs['VATAmount']);

                $sumAMT += $rs['Amount'];
                $sumVAT_AMT += $rs['VATAmount'];
                $sumSub_AMT += $rs['SubAmount'];

                $sumDIS_AMT += $rs['DiscountTariff'];

                array_push($calc_arr, $rs);
            }
        }

        if(count($err) > 0){
            $this->data['error'] = $err;
        }

        if( debug_backtrace()[1]['function'] == "tskRenewedOrder"){
            $this->data["renewed_ord"] = $list;
        }

        $this->data['results'] = $calc_arr;
        $this->data['SUM_AMT'] = $sumAMT;
        $this->data['SUM_VAT_AMT'] = $sumVAT_AMT;
        $this->data['SUM_SUB_AMT'] = $sumSub_AMT;
        $this->data['SUM_DIS_AMT'] = $sumDIS_AMT;
        echo json_encode($this->data);
    }
}

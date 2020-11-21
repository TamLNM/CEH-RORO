<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportAndStatistics extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();
        
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));

        $this->load->model("order_model", "mdlOrder");
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

    public function rpTally()
    {
        $access = $this->user->access('rpTally');
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
            $StartDate  = $this->input->post('StartDate') ? $this->input->post('StartDate') : '';
            $FinishDate = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';

            $this->data['list'] = $this->mdlOrder->loadQuayListForReport($StartDate, $FinishDate);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Báo cáo - Dữ liệu Tally';
        $this->load->view('header', $this->data);
        $this->load->view('report_and_statistics/report_tally', $this->data);
        $this->load->view('footer');
    }

    public function rpGate()
    {
        $access = $this->user->access('rpGate');
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
            $StartDate  = $this->input->post('StartDate') ? $this->input->post('StartDate') : '';
            $FinishDate = $this->input->post('FinishDate') ? $this->input->post('FinishDate') : '';

            $this->data['list'] = $this->mdlOrder->loadGateListForReport($StartDate, $FinishDate);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = 'Báo cáo - Dữ liệu cổng';
        $this->load->view('header', $this->data);
        $this->load->view('report_and_statistics/report_gate', $this->data);
        $this->load->view('footer');
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("data_model", "mdlData");
        $this->load->model("order_model", "mdlOrder");
        $this->load->model("job_model", "mdlJob");
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

    public function jobQuay(){
        $access = $this->user->access('jobQuay');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = 'Xếp dỡ hàng với tàu';
        $this->load->view('header', $this->data);
        $this->data['oprList'] = $this->mdlCommon->loadOprList();
        $this->data['customerList'] = $this->mdlCommon->loadCus();
        $this->data['portList'] = $this->mdlCommon->loadPortList();
        $this->data['classList'] = $this->mdlCommon->loadAllColClass();
        $this->data['jobModeList'] = $this->mdlCommon->loadJobModesList();
        $this->data['methodList'] = $this->mdlCommon->loadAllColMethodList();
        $this->load->view('jobs/jobQuay', $this->data);
        $this->load->view('footer');
    }

    public function jobGate(){
        $access = $this->user->access('jobGate');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = 'Giao nhận cổng';
        $this->load->view('header', $this->data);
        $this->load->view('jobs/jobGate', $this->data);
        $this->load->view('footer');
    }

    public function jobService(){
        $access = $this->user->access('jobService');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        $this->data['title'] = 'Dịch vụ tại bãi';
        $this->load->view('header', $this->data);
        $this->load->view('jobs/jobService', $this->data);
        $this->load->view('footer');
    }
}
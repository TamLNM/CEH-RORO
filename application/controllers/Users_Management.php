<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Management extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }

        $this->load->helper(array('form','url'));
        $this->load->model("common_model", "mdlCommon");
        $this->load->model("users_management_model", "mdlUM");
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

    public function umSysGroup(){
        $access = $this->user->access('umSysGroup');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'add' || $action == 'edit'){
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlUM->saveUsersGroup($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlUM->deleteUsersGroup($delData);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = 'Quản lý nhóm người dùng';
        $this->load->view('header', $this->data);
        $this->data['sysMenuList'] = $this->mdlUM->loadSysGroups();
        $this->load->view('users_management/sys_menus', $this->data);
        $this->load->view('footer');
    }
    
    public function umSysUsers(){
        $access = $this->user->access('umSysUsers');
        if($access === false) {
            show_404(); 
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if ($action == 'add' || $action == 'edit'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') : array();

            if ($child_action == 'change_password'){
                $id     = $this->input->post('id') ? $this->input->post('id') : '';
                $pass   = $this->input->post('pass') ? $this->input->post('pass') : '';
                $this->data['result'] = $this->mdlUM->changeUserPassword($id, $pass);
                echo json_encode($this->data);
                exit;
            }

            $saveData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlUM->saveSysUsers($saveData);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'delete'){
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlUM->deleteSysUsers($delData);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = 'Quản lý người dùng';
        $this->load->view('header', $this->data);
        $this->data['sysUsersList'] = $this->mdlUM->loadSysUsers();
        $this->data['sysGroupsList'] = $this->mdlUM->loadSysGroups();
        $this->data['customerList'] = $this->mdlUM->loadCustomer();
        $this->load->view('users_management/sys_users', $this->data);
        $this->load->view('footer');
    }

    public function umSysPermission(){
        $access = $this->user->access('umSysPermission');

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

            if ($child_action == 'load_user_list'){
                $GroupID = $this->input->post('GroupID') ? $this->input->post('GroupID') : '';
                $this->data['list'] = $this->mdlUM->loadUserListByGroupID($GroupID);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'load_contenttable'){
                $rowguid = $this->input->post('rowguid') ? $this->input->post('rowguid') : '';
                $this->data['list'] = $this->mdlUM->loadSysMenuList($rowguid);
                echo json_encode($this->data);
                exit;
            }
        }

        if ($action == 'add' || $action == 'edit'){
            $groupID    = $this->input->post('GroupID') ? $this->input->post('GroupID') : '';
            $saveData = $this->input->post('data') ? $this->input->post('data') : array();

            if(count($saveData) > 0){
                $this->data['result'] = $this->mdlUM->saveSysPermission($saveData, $groupID);
                echo json_encode($this->data);
                exit;  
            }  
        }

        if ($action == 'delete'){
            $groupID = $this->input->post('GroupID') ? $this->input->post('GroupID') : '';
            $userID  = $this->input->post('UserID')  ? $this->input->post('UserID')  : '';
            $delData = $this->input->post('data') ? $this->input->post('data') : array();
            if(count($delData) > 0)
            {
                $this->data['result'] = $this->mdlUM->deleteUserPermission($delData, $groupID, $userID);
            }
            echo json_encode($this->data);
            exit;    
        }

        $this->data['title'] = 'Phân quyền người dùng';
        $this->load->view('header', $this->data);
        $this->data['sysGroupList'] = $this->mdlUM->loadSysGroups();
        $this->data['sysMenuList'] = $this->mdlUM->loadSysMenuList('');
        $this->data['sysPermissionList'] = $this->mdlUM->loadSysPermissionList();
        $this->data['userList'] = $this->mdlUM->loadUserList();
        $this->data['menuActList'] = $this->mdlUM->loadMenuActList();
        $this->load->view('users_management/sys_permission', $this->data);
        $this->load->view('footer');
    }
}
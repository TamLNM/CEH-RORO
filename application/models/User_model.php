<?php
defined('BASEPATH') OR exit('');

class user_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $_GroupAdmin = 'GroupAdmin';
    private $_GroupVesselOwner = 'GroupVesselOwner';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function validate_user($data) {
        $where = array(
            'UserID'    => $data['UserID'],
            'Pwd'       => $this->Encrypt($data['password']),
            //"YardID" => $this->session->userdata("YardID")
        );

        $stmt = $this->ceh->where($where)->limit(1)->get('SYS_USERS');

        $result = $stmt->row_array();
        return $result;
    }
    public function check_exist_login_user($UserID){
        $count_user = $this->ceh->select('COUNT(UserID) CountUser')
                                    ->where('UserID', $UserID)
                                    ->where("YardID", $this->session->userdata("YardID"))
                                    ->limit(1)
                                    ->get('SYS_USERS');

        return $count_user->row_array();
    }

    public function Encrypt($string = '') {
        return md5(md5($this->config->item('encryption_key')) . md5($string));
    }

    public function is_Admin() {
        if($this->session->userdata('GroupID') == $this->_GroupAdmin) {
            return true;
        } else {
            return false;
        }
    }

    public function access($method = '') {
        $where = array(
            'p.GroupID' => $this->session->userdata('GroupID')
        );

        $this->ceh->select('count(*) AS c');
        $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuID = m.MenuID', 'inner');
        $this->ceh->where($where);
        $stmt = $this->ceh->get('SYS_MENUS AS m');

        $mnu = $stmt->row_array();
        if ($mnu['c'] > 0) {
            $where = array(
                'p.GroupID'  => $this->session->userdata('GroupID'),
                'm.MenuAct' => $method
            );
            //delete ,p.IsAddNew, p.IsModify, p.IsDelete

            $this->ceh->select('*');
            $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuAct = m.MenuAct', 'inner');
            $this->ceh->where($where);
            $this->ceh->limit(1);
            $stmt = $this->ceh->get('SYS_MENUS AS m');

            $fmenu = $stmt->row_array();
        } else {
            $where = array(
                'p.GroupID'  => $this->session->userdata('GroupID'),
                'm.MenuAct' => $method
            );
            //delete , p.IsAddNew, p.IsModify, p.IsDelete
            $this->ceh->select('*');
            $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuAct = m.MenuAct', 'inner');
            $this->ceh->where($where);
            $this->ceh->limit(1);
            $stmt = $this->ceh->get('SYS_MENUS AS m');
            $fmenu = $stmt->row_array();
        }

        if ($this->session->userdata('GroupID') != $this->_GroupAdmin && 
            $this->session->userdata('GroupID') != $this->_GroupVesselOwner
        ){
            if(count($fmenu) == 0) {
                return false;
            } else {
                $action = $this->input->post('action') ? strtolower($this->input->post('action')) : 'view';

                $access = array();
                
                /*if($fmenu['IsAddNew'] === 1)
                {
                    array_push($access, "add");

                }
                if($fmenu['IsModify'] === 1)
                {
                    array_push($access, "edit");
                }
                if($fmenu['IsDelete'] === 1)
                {
                    array_push($access, "delete");
                }*/
                if(count($access) == 0) {
                    if($action != 'view') {
                        return "Bạn không được cấp phép thực hiện chức năng này!";
                    }
                } else {
                    if(!in_array($action, $access) && $action != 'view') {
                        return "Bạn không được cấp phép thực hiện chức năng này!";
                    } else {
                        return $inAction; 
                    }
                }
            }
        } else {
            return true;
        }
    }

    public function allGroups() {
        $result = $this->ceh->where("YardID", $this->session->userdata("YardID"))->get('SYS_PERMISSION');
        return $result->result_array();
    }
    public function saveGroups($grID, $grName) {
        $item = array(
            'GroupMenuName' => UNICODE.$grName,
            'ModifiedBy' => $this->session->userdata("UserID"),
            'UpdateTime' => date('Y-m-d H:i:s')
        );
        $item["YardID"] = $this->session->userdata("YardID");

        if($grID != ''){
            //update database
            $this->ceh->where('GroupMenuAct', $grID)
                        ->where('YardID', $item["YardID"])
                        ->limit(1)
                        ->update('SYS_PERMISSION', $item);
        }else{
            //insert database
            $item = array(
                'GroupMenuName' =>  UNICODE.$grName,
                'ModifiedBy' => $this->session->userdata("UserID"),
                'UpdateTime' => date('Y-m-d H:i:s')
            );

            $item["YardID"] = $this->session->userdata("YardID");
            $item['CreatedBy'] = $item['ModifiedBy'];
            $this->ceh->insert('SYS_PERMISSION', $item);
        }
    }

    public function allUsers() {

        $this->ceh->select('u.*, g.GroupMenuName');
        $this->ceh->join('SYS_PERMISSION AS g', 'g.GroupID = u.GroupID', 'inner');
        $this->ceh->where("YardID", $this->session->userdata("YardID"));
        $this->ceh->order_by('u.UserID', 'ASC');
        $stmt = $this->ceh->get('SYS_USERS AS u');
        return $stmt->result_array();
    }

    public function byUserGroupID($gId) {
        $stmt = $this->ceh->where('GroupID', $gId)
                            ->where('YardID', $this->session->userdata("YardID"))
                            ->get('SYS_USERS');

        return $stmt->result_array();
    }

    public function byId($userId) {

        $this->ceh->select('u.*, g.GroupMenuName');
        $this->ceh->join('SYS_PERMISSION AS g', 'g.GroupID = u.GroupID', 'inner');
        $this->ceh->where('u.UserID', $userId);
        $this->ceh->where('u.YardID', $this->session->userdata("YardID"));
        $this->ceh->order_by('u.UserID', 'ASC');
        $stmt = $this->ceh->get('SYS_USERS AS u');

        return $stmt->row_array();
    }
//
//    public function countOnline() {
//        $munit = time() - 900;
//
//        $sql = "SELECT s.*, u.user_name, g.group_name FROM sessions s INNER JOIN SYS_USERS u ON u.user_id = s.user_id INNER JOIN SYS_PERMISSION g ON u.group_id = g.group_id WHERE s.start_time > ? ORDER BY s.start_time DESC";
//
//        return $this->functions->query_my($sql, array($munit));
//    }

    public function getCustomers(){
        $this->ceh->select('CusID, VAT_CD, CusType, Address, CusName');
        $this->ceh->where('IsOpr', 1);
        $this->ceh->where('YardID', $this->session->userdata("YardID"));
        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }
}
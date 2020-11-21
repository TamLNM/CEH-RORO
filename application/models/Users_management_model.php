<?php
defined('BASEPATH') OR exit('');

class Users_management_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function loadSysGroups(){
    	$this->ceh->select('GroupID, GroupName');
    	$this->ceh->order_by('GroupID', 'ASC');
    	$stmt = $this->ceh->get('SYS_GROUPS');
    	return $stmt->result_array();
    }

    public function saveUsersGroup($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['GroupName'])){
                $item['GroupName'] = UNICODE.$item['GroupName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("GroupID")->where('GroupID', $item['GroupID'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('SYS_GROUPS')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('GroupID', $checkitem["GroupID"])->update('SYS_GROUPS', $item);
                }else{
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('SYS_GROUPS', $item);
                }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function deleteUsersGroup($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('GroupID', $item)->delete('SYS_GROUPS');      
            array_push($result['success'], 'Xóa thành công:'.$item);
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    /* Sys_users table */
    public function loadSysUsers(){
        $this->ceh->select('UserID, Pwd, FullName, Email, Tel, PersonalID, CusID, CusName, Address, BirthDay, A.GroupID as GroupID, GroupName, IsActive');
        $this->ceh->order_by('UserID', 'ASC');
        $this->ceh->join('SYS_GROUPS B', 'A.GroupID = B.GroupID');
        $stmt = $this->ceh->get('SYS_USERS A');
        return $stmt->result_array();
    }

    public function changeUserPassword($id = '', $pass = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        if ($id != '' && $pass != ''){
            $item['UserID'] = $id;
            $item['Pwd'] = $pass;

            $checkitem = $this->ceh->select("UserID")->where('UserID', $item['UserID'])->limit(1)->get('SYS_USERS')->row_array();

            if(count($checkitem) > 0){
                $this->ceh->where('UserID', $checkitem["UserID"])->update('SYS_USERS', $item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function loadCustomer(){
        $this->ceh->select('CusID, CusName');
        $this->ceh->order_by('CusID', 'ASC');
        $stmt = $this->ceh->get('BS_CUSTOMER');
        return $stmt->result_array();
    }

    public function saveSysUsers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['FullName'])){
                $item['FullName'] = UNICODE.$item['FullName'];
            }

            if(isset($item['CusName'])){
                $item['CusName'] = UNICODE.$item['CusName'];
            }

            if(isset($item['Address'])){
                $item['Address'] = UNICODE.$item['Address'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("UserID")->where('UserID', $item['UserID'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('SYS_USERS')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('UserID', $checkitem['UserID'])->update('SYS_USERS', $item);
                }else{
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('SYS_USERS', $item);
                }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function deleteSysUsers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('UserID', $item)->delete('SYS_USERS');      
            array_push($result['success'], 'Xóa thành công:'.$item);
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }

    /* SYS_PERMISSION table */
    public function loadUserListByGroupID($GroupID = ''){
        $this->ceh->select('A.GroupID as GroupID, GroupName, UserID, FullName, Email, Tel, PersonalID, CusID, CusName, Address, BirthDay');
        if ($GroupID != '')
            $this->ceh->where('A.GroupID', $GroupID);

        $this->ceh->where('IsActive', 1);
        
        $this->ceh->join('SYS_GROUPS B', 'A.GroupID = B.GroupID');
        $this->ceh->order_by('UserID', 'ASC');
        $stmt = $this->ceh->get('SYS_USERS A');
        return $stmt->result_array();
    }

    public function loadSysMenuList($rowguid = ''){
        if ($rowguid != '')
            $this->ceh->where('parentID', $rowguid);
        $this->ceh->order_by('MenuAct');
        $stmt = $this->ceh->get('SYS_MENUS');
        return $stmt->result_array();
    }

    public function loadSysPermissionList(){
        $this->ceh->order_by('MenuAct');
        $stmt = $this->ceh->get('SYS_PERMISSION');
        return $stmt->result_array();
    }

    public function loadUserList(){
        $this->ceh->distinct();
        $this->ceh->select('UserID, GroupID');
        $stmt = $this->ceh->get('SYS_USERS');
        return $stmt->result_array();
    }

    public function loadMenuActList(){
        $this->ceh->distinct();
        $this->ceh->select('MenuAct');
        $stmt = $this->ceh->get('SYS_PERMISSION');
        return $stmt->result_array();
    }

    public function saveSysPermission($datas, $groupID = '', $userID = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($groupID != '')
                $item['GroupID'] = $groupID;

            $checkitem = $this->ceh->where('GroupID', $item['GroupID'])
                                    ->where('UserID', $item['UserID'])
                                    ->where('MenuAct', $item['MenuAct'])
                                    ->where('PerDetail', $item['PerDetail'])
                                    ->limit(1)->get('SYS_PERMISSION')->row_array();

                if(count($checkitem) > 0){
                    /* Do nothing */
                }
                else{
                    $item['YardID'] = $this->session->userdata("YardID");
                    $this->ceh->insert('SYS_PERMISSION', $item);
                }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function deleteUserPermission($datas, $groupID = '', $userID = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            if ($groupID != '')
                $this->ceh->where('GroupID', $groupID);

            if ($userID != '')
                $this->ceh->where('UserID', $userID);

            
            $this->ceh->where('MenuAct', $item['MenuAct'])
                        ->where('PerDetail', $item['PerDetail'])
                        ->delete('SYS_PERMISSION');      

            array_push($result['success'], 'Xóa thành công!');
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    }
}
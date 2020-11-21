<?php
defined('BASEPATH') OR exit('');

class menu_model extends CI_Model
{
    private $ceh;
    function __construct() {
        parent::__construct();

        $this->load->helper(array('form','url'));
        $this->load->library(array('session'));
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function getMenu() {
        $stmt = $this->ceh->where('ParentID IS NULL')
                            ->order_by('OrderBy', 'ASC')
                            ->get('SYS_MENUS');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['MenuIcon'] = $result['MenuIcon'];
            $submenu = $this->getSubMenu($result['rowguid']);
            $menu_r[$result['MenuAct']]['submenu'] = $submenu;
            foreach ($submenu as $val) {
                $subsubmenu = $this->getSubMenu($val['MenuAct']);
                $menu_r[$result['MenuAct']]['submenu'][$val['MenuAct']]['MenuAct'] = $val['MenuAct'];
                $menu_r[$result['MenuAct']]['submenu'][$val['MenuAct']]['MenuName'] = $val['MenuName'];
                $menu_r[$result['MenuAct']]['submenu'][$val['MenuAct']]['MenuAct'] = $val['MenuAct'];
                $menu_r[$result['MenuAct']]['submenu'][$val['MenuAct']]['MenuIcon'] = $val['MenuIcon'];
                $menu_r[$result['MenuAct']]['submenu'][$val['MenuAct']]['subsubmenu'] = $subsubmenu;
            }
        }
        return $menu_r;
    }

    public function getParentMenu() {
        $stmt = $this->ceh->where('ParentID IS NULL')
                            ->order_by('OrderBy', 'ASC')
                            ->get('SYS_MENUS');
        return $stmt->result_array();
    }

    public function getMenuAct($menuAct) {
        $stmt = $this->ceh->where('MenuAct', $menuAct)
                            ->order_by('OrderBy', 'ASC')
                            ->get('SYS_MENUS');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuAct']]['MenuIcon'] = $result['MenuIcon'];
            $menu_r[$result['MenuAct']]['submenu'] = $this->getSubMenu($result['MenuAct']);
        }
        return $menu_r;
    }

    public function getSubMenu($pMenu) {
        $submenu_r = array();
        if ($this->session->userdata('GroupID') == 'GroupAdmin' || $this->session->userdata('GroupID') == 'GroupVesselOwner')
        {
            $this->ceh->get('SYS_MENUS');

            $stmt = $this->ceh->where('ParentID', $pMenu)
                                ->order_by('OrderBy', 'ASC')
                                ->get('SYS_MENUS');

            $menus = $stmt->result_array();
        } else {
            $where = array(
                'p.GroupID' => $this->session->userdata('GroupID')
            );
            $this->ceh->select('count(*) AS c');
            $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuAct = m.MenuAct', 'inner');
            $this->ceh->where($where);
            $stmt = $this->ceh->get('SYS_MENUS AS m');

            $mnu = $stmt->row_array();
            if ($mnu['c'] > 0) {
                $where = array(
                    'p.GroupID'  => $this->session->userdata('GroupID'),
                    'm.ParentID' => $pMenu
                );
                $this->ceh->select('m.*');
                $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuAct = m.MenuAct', 'inner');
                $this->ceh->where($where);
                $this->ceh->order_by('m.OrderBy', 'ASC');
                $stmt = $this->ceh->get('SYS_MENUS AS m');

            } else {
                $where = array(
                    'm.ParentID' => $pMenu,
                    'p.GroupID'    => $this->session->userdata('GroupID')
                );
                $this->ceh->select('m.*');
                $this->ceh->join('SYS_PERMISSION AS p', 'p.MenuAct = m.MenuAct', 'inner');
                $this->ceh->where($where);
                $this->ceh->order_by('m.OrderBy', 'ASC');
                $stmt = $this->ceh->get('SYS_MENUS AS m');
            }
            $menus = $stmt->result_array();
        }

        foreach($menus as $menu) {
            $submenu_r[$menu['MenuAct']]['MenuAct'] = $menu['MenuAct'];
            $submenu_r[$menu['MenuAct']]['MenuName'] = $menu['MenuName'];
            $submenu_r[$menu['MenuAct']]['MenuAct'] = $menu['MenuAct'];
            $submenu_r[$menu['MenuAct']]['MenuIcon'] = $menu['MenuIcon'];
        }
        return $submenu_r;
    }

    public function getAllMenus() {
        $stmt = $this->ceh->where('ParentID IS NULL')
                            ->order_by('OrderBy', 'ASC')
                            ->get('SYS_MENUS');

        $results = $stmt->result_array();
        $menu_r = array();

        foreach($results as $result) {
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['MenuName'] = $result['MenuName'];
            $menu_r[$result['MenuAct']]['MenuAct'] = $result['MenuAct'];
            $menu_r[$result['MenuAct']]['submenu'] = $this->getSubMenu($result['MenuAct']);
        }
        return $menu_r;
    }

    public function getAllSubs($p_id) {

        $submenu_r = array();

        $this->ceh->get('SYS_MENUS');

        $stmt = $this->ceh->where('ParentID', $p_id)
                            ->order_by('OrderBy', 'ASC')
                            ->get('SYS_MENUS');

        $menus = $stmt->result_array();

        foreach($menus as $menu) {
            $submenu_r[$menu['MenuAct']]['MenuAct'] = $menu['MenuAct'];
            $submenu_r[$menu['MenuAct']]['MenuAct'] = $menu['MenuAct'];
            $submenu_r[$menu['MenuAct']]['MenuName'] = $menu['MenuName'];
            $submenu_r[$menu['MenuAct']]['MenuIcon'] = $menu['MenuIcon'];
        }
        return $submenu_r;
    }
}
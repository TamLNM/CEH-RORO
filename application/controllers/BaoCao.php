<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//die("123");
class BaoCao extends CI_Controller {
	public $data;
    private $ceh;

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form','url'));
        $this->load->model("user_model", "user");
        $this->ceh = $this->load->database('mssql', TRUE);
        $vdt=trim($this->uri->segment(3));
        if(@$vdt=="")
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
    public function ReportOrder() {

        $access = $this->user->access('ReportOrder');
        if($access === false) {
            show_404();
        };
        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        };
        $this->load->model("InOut_model", "InOut");
        $this->data['title'] = "Báo cáo biến động kho";
        $this->load->view('header', $this->data);
        $this->data['data']=$this->InOut->OrderList_NK_load();
        $this->data['data2']=$this->InOut->OrderList_XK_load();
        $this->load->view('InOut/ReportOrder', $this->data);
        $this->load->view('footer');
    }

    public function Voyage() {
        $this->load->library('Barcode');
        $this->load->helper('url');
        $this->load->library('qrmaker');

        
        //$this->load->model("InOut_model", "InOut");
        $vdt=trim($this->uri->segment(3));
        $this->data['title'] = "Phiếu nhập kho";
        $vdata=$this->ceh->query("SELECT V.VesselName,V.InboundVoyage,V.OutboundVoyage,S.BillOfLading,S.BookingNo,S.ClassID,S.JobModeOutID,O.DateOut ,O.Sequence,O.CargoWeightGetOut,O.UnitID FROM DT_STOCK_BULK AS S LEFT JOIN DT_GETOUT_BULK AS O ON S.rowguid = O.StockRef LEFT JOIN DT_VESSEL_VISIT AS V ON S.VoyageKey = V.VoyageKey  WHERE S.VoyageKey = '".$this->ceh->escape_like_str($vdt)."' AND O.DateOut IS NOT NULL")->result_array();
        if(is_array($vdata)){
            $this->data['vdata']=$vdata;
        }
        else
            $this->data['vdata']=array();


//print_r($vdata);die();

        //$this->data['data']=$this->InOut->xemPhieu_load_ord($vdt);
        //$this->data['urlb']=urlencode( $this->config->base_url()."index.php/".md5("Baocao")."/".md5("xemPhieu")."/".$vdt);
        //$this->data['qr']=$this->qrmaker->make_base64_url($this->config->base_url()."index.php/".md5("Baocao")."/".md5("xemPhieu")."/".$vdt);
        //$this->data['barcode']=$this->barcode->make_base64_url($this->data['data']['ORDER_LIST'][0]['PINCODE']);
        $this->load->view('BaoCao/Voyage', $this->data);

    }

}
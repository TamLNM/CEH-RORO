<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//die("123");
class Api extends CI_Controller {
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
    public function GetTruckBarCode() {
        $TruckNo = $this->input->post('TruckNo') ? $this->input->post('TruckNo') : '';
        $OrderNo = $this->input->post('OrderNo') ? $this->input->post('OrderNo') : '';
        if($TruckNo!="" && $OrderNo!=""){
            $JG=$this->ceh->where('TruckNumber',$TruckNo)->where('EirNo',$OrderNo)->get('JOB_GATE')->row_array();
            if(is_array($JG) && count($JG)>0)
            {
            $TW=$this->ceh->where('TruckNumber',$TruckNo)->get('BS_TRUCK_WEIGHT')->row_array();
            $NOTE="Yêu cầu cân 2 Lần";
            $WEIGHT=0;
            if(is_array($TW) && count($TW)>0){
                $WEIGHT=floatval(@$TW['SecondWeightScale']);
                if($TW['SecondWeightScale']!=null)
               $NOTE="Yêu cầu cân 1 Lần";
            }
            $this->load->library('qrmaker');
            $code='{"TruckNo":"'.$TruckNo.'","OrderNo":"'.$OrderNo.'","JobModeID":"'.$JG['JobModeID'].'"}';
            $md5Code=md5($code);
            $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$md5Code.".png";
            //$imgurl=$this->config->base_url()."assets/img/qrcode_gen/".$md5Code.".png";
            $imgurl=$this->qrmaker->make_base64_url($code);
            //$this->qrmaker->make_png($code,$pngAbsoluteFilePath);
            die('{"img":"'.$imgurl.'","TruckNo":"'.$TruckNo.'","OrderNo":"'.$OrderNo.'","JobModeID":"'.$JG['JobModeID'].'","NOTE":"'.$NOTE.'","WEIGHT":"'.$WEIGHT.'"}');
            }
        }
    }
    public function GetLichTauData() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        //die('[{"name":"CAPE NATI","desc":"1904N\/1904N","values":[{"from":1562848766000,"dataObj":{"from":"2019-07-11 19:39:26.000","to":"2019-07-12 19:00:00.000"},"to":1562932800000,"label":"CAPE NATI","customClass":"ganttRed"}]},{"name":"LEO PERDANA","desc":"0215-084N\/0217-085S","values":[{"from":1562845086000,"dataObj":{"from":"2019-07-11 18:38:06.000","to":"2019-07-12 10:00:00.000"},"to":1562900400000,"label":"LEO PERDANA","customClass":"ganttRed"}]},{"name":"MEKONG 02","desc":"125W\/125W","values":[{"from":1562768402000,"dataObj":{"from":"2019-07-10 21:20:02.000","to":"2019-07-10 21:35:03.000"},"to":1562769303000,"label":"MEKONG 02","customClass":"ganttGMD"}]},{"name":"MEKONG 8","desc":"048E\/048E","values":[{"from":1562857200000,"dataObj":{"from":"2019-07-11 22:00:00.000","to":"2019-07-12 00:00:40.000"},"to":1562864440000,"label":"MEKONG 8","customClass":"ganttGMD"}]}]');
        $FROM = $this->input->post('FROMTIME') ? $this->input->post('FROMTIME') : '';
        $TO = $this->input->post('TOTIME') ? $this->input->post('TOTIME') : '';
        $FROM=date("Y-m-d H:i:s",strtotime(str_replace("/", "-", $FROM) ));
        $TO=date("Y-m-d H:i:s",strtotime(str_replace("/", "-", $TO) ));
        $newrs=array();
        //echo strtotime($FROM).">=".strtotime($TO);die();
        if($FROM!="" && $TO!=""){
            if(strtotime($FROM)<=strtotime($TO)){
                $VS=$this->ceh->select('DT_VESSEL_VISIT.*,DT_VESSEL.VesselType')->join('DT_VESSEL','DT_VESSEL.VesselID=DT_VESSEL_VISIT.VesselID','left')->where('DT_VESSEL_VISIT.ETA>=',$FROM)->where('DT_VESSEL_VISIT.ETD<=',$TO)->get('DT_VESSEL_VISIT')->result_array();
                foreach ($VS as $key => $iVS) {
                    if(intval($iVS['VesselType'])==1){
 $VSum=$this->ceh->select('COUNT(*) as tong')->where('VoyageKey',$iVS['VoyageKey'])->where('ClassID',1)->get('DT_MANIFEST')->row_array();
 $iVS['sumnhap']=floatval(@$VSum['tong']);
 $iVS['UnitID']='Unit';
 $VSum=$this->ceh->select('COUNT(*) as tong')->where('VoyageKey',$iVS['VoyageKey'])->where('ClassID',2)->get('DT_MANIFEST')->row_array();
$iVS['sumxuat']=floatval(@$VSum['tong']);
$iVS['UnitID']='Unit';
                    }
                    else
                    if(intval($iVS['VesselType'])==3){
$VSum=$this->ceh->select('sum(CargoWeight) as tong, max(UnitID) as UnitID')->where('VoyageKey',$iVS['VoyageKey'])->where('ClassID',1)->get('DT_MNF_LD_BULK')->row_array();
$iVS['sumnhap']=floatval(@$VSum['tong']);
$iVS['UnitID']=@$VSum['UnitID'];
$VSum=$this->ceh->select('sum(CargoWeight) as tong, max(UnitID) as UnitID')->where('VoyageKey',$iVS['VoyageKey'])->where('ClassID',2)->get('DT_MNF_LD_BULK')->row_array();
$iVS['sumxuat']=floatval(@$VSum['tong']);
$iVS['UnitID']=@$VSum['UnitID'];
                    }
                    $item=array('name'=>$iVS['VesselName'],'desc'=>$iVS['VesselID'],'values'=>array());
                    //{"from":1562848766000,"dataObj":{"from":"2019-07-11 19:39:26.000","to":"2019-07-12 19:00:00.000"},"to":1562932800000,"label":"CAPE NATI","customClass":"ganttRed"}
                    $item['values'][]=array('from'=>strtotime($iVS['ETA'])*1000,
                        'dataObj'=>array('from'=>$iVS['ETA'],'to'=>$iVS['ETD'],'name'=>$iVS['VesselName'],'vdata'=>$iVS),
                        'to'=>strtotime($iVS['ETD'])*1000,
                        'label'=>$iVS['VesselName'],
                        'customClass'=>'Mod'.$iVS['Status']
                );
                    $newrs[]=$item;
                }
                echo json_encode(array('maxDate'=>strtotime(str_replace("/", "-", $TO)),'minDate'=>strtotime(str_replace("/", "-", $FROM)),'DATA'=>$newrs));
                die();
            }
            else
            {
                die('{"deny":"Ngày bắt đầu lớn hơn ngày kết thúc kìa !"}');
            }
        }
    }

}
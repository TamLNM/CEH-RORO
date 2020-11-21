<?php
defined('BASEPATH') OR exit('');

class vessel_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function loadVesselList(){
        $this->ceh->select('VesselID, VesselName, A.OprID, OprName, IMO');
        $this->ceh->join('BS_OPR B', 'A.OprID = B.OprID');
        $this->ceh->order_by('VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL A');
        return $stmt->result_array(); 
    }

    public function loadPortListForVesselVisitScreen(){
        $this->ceh->select('PortID, PortName');
        $this->ceh->order_by('PortID', 'ASC'); 
        $this->ceh->where('YardID', $this->session->userdata["YardID"]);
        $stmt = $this->ceh->get('BS_PORT');
        return $stmt->result_array();
    }        

    public function loadVesselTypeList(){
        $this->ceh->select('A.NationID, NationName, PortID, PortName');
        $this->ceh->join('BS_NATIONAL B', 'A.NationID = B.NationID');
        $this->ceh->order_by('A.NationID', 'ASC'); 
        $this->ceh->where('A.YardID', $this->session->userdata["YardID"]);
        $stmt = $this->ceh->get('BS_PORT A');
        return $stmt->result_array();
    }       
 
    public function loadVessel($vesselID = '', $vesselName = ''){
        $this->ceh->select('VesselID, VesselName, VesselType, A.OprID, OprName, A.NationID, NationName, CallSign, Inmarsat, LLoyd, IMO, LOA, LBP, MaxBeam, AntenaHeight, Depth, GRT, DWT');

        $this->ceh->join('BS_OPR B', 'A.OprID = B.OprID');
        $this->ceh->join('BS_NATIONAL C', 'A.NationID = C.NationID');
        
        if($vesselID != '')
            $this->ceh->where('VesselID', $vesselID);
        if($vesselName != '')
            $this->ceh->where('VesselName', $vesselName);
        
        $this->ceh->where('A.YardID', $this->session->userdata["YardID"]);
        $this->ceh->order_by('VesselID', 'ASC');
        $stmt = $this->ceh->get('DT_VESSEL A');
        return $stmt->result_array();
    }

    public function  loadAllColVesselVisit($vesselID = ''){
        $this->ceh->select('VoyageKey, A.VesselID as VesselID, A.VesselName as VesselName, A.OprID, OprName, E.IMO, InboundVoyage, OutboundVoyage, BerthID, BittID, AlongSide, InLane, OutLane, LastPort as LastPortID, C.PortName as LastPortName, NextPort as NextPortID, D.PortName as NextPortName, ETA, ETB, ETW, ETC, ETD, Remark, Status');

        if($vesselID != '')
            $this->ceh->where('A.VesselID', $vesselID);
        
        $this->ceh->join("BS_OPR B", "A.OprID = B.OprID");
        $this->ceh->join("BS_PORT C", "A.LastPort = C.PortID", "left");
        $this->ceh->join("BS_PORT D", "A.NextPort = D.PortID", "left");
        $this->ceh->join("DT_VESSEL E", "A.VesselID = E.VesselID");
        $this->ceh->order_by('A.VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL_VISIT A');
        return $stmt->result_array();
    }

    public function loadVesselVisitConfirm(){
        $this->ceh->select('VoyageKey, VesselID, VesselName, InboundVoyage, OutboundVoyage, ETB, ETD, BerthID, BittID, LastPort as LastPortID, B.PortName as LastPortName, NextPort as NextPortID, C.PortName as NextPortName, Status, ATA, ATB, ATWD, ATCD, ATWL, ATCL, ATD');
        $this->ceh->join("BS_PORT B", "LastPort = B.PortID", "left");
        $this->ceh->join("BS_PORT C", "NextPort = C.PortID", "left");
        $this->ceh->order_by('A.VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL_VISIT A');
        return $stmt->result_array();
    }

    public function loadPortDataByInOutLane($InLane = '', $OutLane = ''){
        $this->ceh->distinct();
        $this->ceh->where('LaneID', $InLane);
        $this->ceh->or_where('LaneID', $OutLane);
        $this->ceh->select('A.PortID, PortName');
        $this->ceh->join('BS_PORT B', 'A.PortID = B.PortID');
        $this->ceh->order_by("A.PortID", 'ASC');
        $stmt = $this->ceh->get('BS_LANE_DETAILS A');
        return $stmt->result_array();
    }

    public function saveVessel($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['VesselName'])){
                $item['VesselName'] = UNICODE.$item['VesselName']; 
            }

            $item['YardID']     = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("VesselID")->where('VesselID', $item['VesselID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('DT_VESSEL')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('VesselID', $checkitem["VesselID"])->update('DT_VESSEL', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('DT_VESSEL', $item);
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

    
    public function saveVesselVisit($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['VesselName'])){
                $item['VesselName'] = UNICODE.$item['VesselName']; 
            }

            $item['YardID']     = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("VoyageKey")->where('VoyageKey', $item['VoyageKey'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('DT_VESSEL_VISIT')->row_array();
            if(count($checkitem) > 0){
                $this->ceh->where('VoyageKey', $checkitem["VoyageKey"])->update('DT_VESSEL_VISIT', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('DT_VESSEL_VISIT', $item);
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

    public function updateVesselVisit( $data ){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $data[0]['YardID']     = $this->session->userdata("YardID");

        $checkitem = $this->ceh->where('VoyageKey', $data[0]['VoyageKey'])
                                ->where('YardID', $data[0]['YardID'])
                                ->limit(1)->get('DT_VESSEL_VISIT')
                                ->row_array();
        if(count($checkitem) > 0){
            $this->ceh->where('VoyageKey', $checkitem['VoyageKey'])->update('DT_VESSEL_VISIT', $data[0]);
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

    // Delete info in vessel table
    public function deleteVessel($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('VesselID', $item)->delete('DT_VESSEL');      
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

    // Delete info in vessel visit table
    public function deleteVesselVisit($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('VoyageKey', $item)->delete('DT_VESSEL_VISIT');      
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

    public function loadBittList(){
        $this->ceh->select('BerthID, BittID, CoordX, CoordY');
        $this->ceh->order_by('BittID', 'ASC'); 
        $stmt = $this->ceh->get('BS_BITT');
        return $stmt->result_array();        
    }

    public function loadBerthList(){       
        $this->ceh->order_by('BerthID', 'ASC'); 
        $stmt = $this->ceh->get('BS_BERTH');
        return $stmt->result_array();    
    }

    public function loadOprList(){
        $this->ceh->select('OprID, OprName');
        $this->ceh->order_by('OprID', 'ASC'); 
        $stmt = $this->ceh->get('BS_OPR');
        return $stmt->result_array();
    }

    public function loadNationList(){
        $this->ceh->select('NationID, NationName');
        $this->ceh->order_by('NationID', 'ASC'); 
        $stmt = $this->ceh->get('BS_NATIONAL');
        return $stmt->result_array();
    }

    public function loadCarBrandList(){
        $this->ceh->select('BrandID, BrandName');
        $this->ceh->order_by('BrandID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CAR_BRAND');
        return $stmt->result_array();
    }

    public function loadCarTypeList(){
        $this->ceh->select('CarTypeID, CarTypeName, BrandID');
        $this->ceh->order_by('CarTypeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CAR_TYPE');
        return $stmt->result_array();
    }

    public function loadClassList(){
        $this->ceh->select('ClassID, ClassName');
        $this->ceh->order_by('ClassID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CLASS');
        return $stmt->result_array();
    }

    public function loadPortList(){
        $this->ceh->select('PortID, PortName');
        $this->ceh->order_by('PortID', 'ASC'); 
        $stmt = $this->ceh->get('BS_PORT');
        return $stmt->result_array();
    }

    public function loadVesselVisitList(){
        $this->ceh->distinct();
        $this->ceh->select('VoyageKey, VesselID, VesselName, InboundVoyage, OutboundVoyage');
        $this->ceh->order_by('VoyageKey', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL_VISIT');
        return $stmt->result_array();  
    }

    public function loadBLORBookingNoList($VoyageKey = ''){
        $this->ceh->select('BillOfLading, BookingNo, ClassID');

        if ($VoyageKey != ''){
            $this->ceh->where('VoyageKey', $VoyageKey);
        }
        
        $stmt = $this->ceh->get('DT_MANIFEST');
        return $stmt->result_array();
    }

    public function loadColorAndSeqList(){
        $this->ceh->distinct();
        $this->ceh->select('Color, PlanSequence');
        $this->ceh->order_by('PlanSequence');
        $stmt = $this->ceh->get('BS_YP_PLAN');
        return $stmt->result_array();
    }
    
    public function loadPlan($Block = ''/*, $BillOfLading = '', $BookingNo = ''*/){
        $this->ceh->distinct();

        /*
        if ($BillOfLading){
            $this->ceh->where('BillOfLading', $BillOfLading);
        }
        else if ($BookingNo){
            $this->ceh->where('BookingNo', $BookingNo);
        }
        */
        $this->ceh->select('Bay, Row, Tier, Color, VoyageKey, BillOfLading, BookingNo, PlanSequence');
        $this->ceh->where('Block', $Block);
        $this->ceh->order_by('PlanSequence', 'ASC');
        $this->ceh->order_by('Bay', 'ASC');
        $this->ceh->order_by('Row', 'ASC');
        $stmt = $this->ceh->get('BS_YP_PLAN');
        return $stmt->result_array();
    }

    public function saveBlockDetails($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("Block, Bay, Row, Tier")
                                    ->where('YardID', $item['YardID'])
                                    ->where('Block', $item['Block'])
                                    ->where('Bay', $item['Bay'])
                                    ->where('Row', $item['Row'])
                                    ->where('Tier', $item['Tier'])                                    
                                    ->limit(1)->get('BS_YP_BLOCK_DETAILS')->row_array();
            if(count($checkitem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_YP_BLOCK_DETAILS', $item);
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

    public function savePlan($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $this->ceh->select("YardID, Block, Bay, Row, Tier, BillOfLading, BookingNo, ClassID")
                                    ->where('YardID', $item['YardID'])
                                    ->where('Block', $item['Block'])
                                    ->where('Bay', $item['Bay'])
                                    ->where('Row', $item['Row'])
                                    ->where('Tier', $item['Tier']);                                
            if (isset($item['ClassID'])){
                if ($item['ClassID'] == '1'){
                    $this->ceh->where('BillOfLading', $item['BillOfLading']);   
                }
                else if ($item['ClassID'] == '2'){
                    $this->ceh->where('BookingNo', $item['BookingNo']);   
                }
            }            
                                                                                                                                   
            $checkitem = $this->ceh->limit(1)->get('BS_YP_PLAN')->row_array();

            if(count($checkitem) > 0){
                $this->ceh->where('YardID', $checkitem['YardID'])
                            ->where('Block', $checkitem['Block'])
                            ->where('Bay', $checkitem['Bay'])
                            ->where('Row', $checkitem['Row'])
                            ->where('Tier', $checkitem['Tier']);

                if ($checkitem['ClassID'] == '1'){
                    $this->ceh->where('BillOfLading', $checkitem['BillOfLading']);   
                }
                else if ($checkitem['ClassID'] == '2'){
                    $this->ceh->where('BookingNo', $checkitem['BookingNo']);   
                }
                            
                $this->ceh->update('BS_YP_PLAN', $item);
            }
            else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_YP_PLAN', $item);

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

    public function updateSequenceInPlan($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $checkitem = $this->ceh->select('Color')
                                    ->where('Color', $item['Color'])
                                    ->limit(1)
                                    ->get('BS_YP_PLAN')
                                    ->row_array();

            if(count($checkitem) > 0){
                 $this->ceh->where('Color', $checkitem['Color'])->update('BS_YP_PLAN', $item);
            }   
            else{
                /* Do nothing */
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

    public function deleteBlockDetails($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item['YardID'])
                ->where('Block', $item['Block'])
                ->where('Bay', $item['Bay'])
                ->where('Row', $item['Row'])
                ->where('Tier', $item['Tier'])
                ->delete('BS_YP_BLOCK_DETAILS');
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

    public function deletePlan($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item['YardID'])
                ->where('Block', $item['Block'])
                ->where('Bay', $item['Bay'])
                ->where('Row', $item['Row'])
                ->where('Tier', $item['Tier']);

            /*
            if ($item['BillOfLading'] != ''){
                $this->ceh->where('BillOfLading', $item['BillOfLading']);
            }
            
            if ($item['BookingNo'] != ''){
                $this->ceh->where('BookingNo', $item['BookingNo']);
            } 
            */

            $this->ceh->delete('BS_YP_PLAN');
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

    public function deletePlanWithOutBLORBookingNo($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item['YardID'])
                ->where('Block', $item['Block'])
                ->where('Bay', $item['Bay'])
                ->where('Row', $item['Row'])
                ->where('Tier', $item['Tier'])
                ->delete('BS_YP_PLAN');
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

    public function deletePlanWithBLORBookingNo($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item['YardID'])
                ->where('Block', $item['Block'])
                ->where('Bay', $item['Bay'])
                ->where('Row', $item['Row'])
                ->where('Tier', $item['Tier']);
            
            if (isset($item['BillOfLading'])){
                $this->ceh->where('BillOfLading', $item['BillOfLading']);
            }
            else if (isset($item['BookingNo'])){
                $this->ceh->where('BookingNo', $item['BookingNo']);
            } 

            $this->ceh->delete('BS_YP_PLAN');
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

    public function getMinPost($VoyageKey = '', $ClassID = '', $IsLocalForeign = '', $BillOfLading = ''){
        $this->ceh->select('Block, Bay, Row, Tier, IsAvailable');
        $this->ceh->where('IsAvailable', '1');

        if ($VoyageKey != ''){
            $this->ceh->where('VoyageKey', $VoyageKey);
        }

        if ($ClassID != ''){
            $this->ceh->where('ClassID', $ClassID);
        }

        if ($IsLocalForeign != ''){
            $this->ceh->where('IsLocalForeign', $IsLocalForeign);
        }

        if ($BillOfLading != ''){
            $this->ceh->where('BillOfLading', $BillOfLading);
            $this->ceh->or_where('BillOfLading', '*');
        }

        $this->ceh->order_by('Row', 'ASC'); 
        $this->ceh->order_by('Bay', 'ASC'); 
        $stmt = $this->ceh->get('BS_YP_PLAN');
        return $stmt->result_array();
    }

    public function updateQuayJobStatus($StockRef = '', $Remark = '', $JobStatus = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('StockRef', $StockRef)->set('JobStatus', $JobStatus);
        
        if ($Remark){
            $this->ceh->set('Remark', UNICODE.$Remark);    
        }               
                
        $this->ceh->update('JOB_QUAY');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function updateQuayJobData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['Remark'])){
                $item['Remark'] = UNICODE.$item['Remark']; 
            }

            $checkitem = $this->ceh->select("StockRef")
                                    ->where('StockRef', $item['StockRef'])
                                    ->limit(1)->get('JOB_QUAY')->row_array();

                if(count($checkitem) > 0){
                    $this->ceh->where('StockRef', $checkitem["StockRef"])->update('JOB_QUAY', $item);
                }
                else{
                    /* Do nothing */
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
    
    public function updatePosNotAvailable($Block = '', $Bay = '', $Row = '', $Tier = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('Block', $Block)
                ->where('Bay', $Bay)
                ->where('Row', $Row)
                ->where('Tier', $Tier)
                ->set('IsAvailable', 0)
                ->update('BS_YP_PLAN');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function updatePosAvailable($Block = '', $Bay = '', $Row = '', $Tier = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('Block', $Block)
                ->where('Bay', $Bay)
                ->where('Row', $Row)
                ->where('Tier', $Tier)
                ->set('IsAvailable', 1)
                ->update('BS_YP_PLAN');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function updateStockVMStatus($StockRef = '', $VMStatus = '', $Remark = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        if ($StockRef != ''){
            $this->ceh->where('rowguid', $StockRef)
                        ->set('VMStatus', $VMStatus)
                        ->set('Remark', $Remark);
            $this->ceh->update('DT_STOCK');
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
    }

    public function addDamagedDetails($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID']     = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("StockRef, DamagedID")
                                ->where('StockRef', $item['StockRef'])
                                ->where('DamagedID', $item['DamagedID'])                        
                                ->limit(1)->get('JQ_DAMAGED_DETAILS')->row_array();

            if(count($checkitem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('JQ_DAMAGED_DETAILS', $item);
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

    public function addYardJob($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID']     = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("StockRef")
                                ->where('StockRef', $item['StockRef'])                       
                                ->limit(1)->get('JOB_YARD')->row_array();

            if(count($checkitem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('JOB_YARD', $item);
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

    public function updateYardJobStatus($VINNo = '', $JobStatus = '', $FinishDate = '', $Bay = '', $Row = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('VINNo', $VINNo)->set('JobStatus', $JobStatus)
                                            ->set('FinishDate', $FinishDate);

        if ($Bay != ''){
            $this->ceh->where('VINNo', $VINNo)->set('Bay', $Bay);
        }
    
        if ($Row != ''){
            $this->ceh->where('VINNo', $VINNo)->set('Row', $Row);
        }        
        
        if ($JobStatus == 'KT'){
            $this->ceh->where('VINNo', $VINNo)->set('OldBlock', '')
                                            ->set('OldBay', '')
                                            ->set('OldRow', '')
                                            ->set('OldTier', '');
        }
    
        $this->ceh->update('JOB_YARD');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function transformYardJob($VINNo = '', $Bay = '', $Row = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $checkitem = $this->ceh->where('VINNo', $VINNo)->limit(1)->get('JOB_YARD')->row_array();

        if (count($checkitem) > 0){
            $this->ceh->where('VINNo', $checkitem['VINNo'])
                ->set('OldBlock', $checkitem['Block'])
                ->set('OldBay', $checkitem['Bay'])
                ->set('OldRow', $checkitem['Row'])
                ->set('OldTier', $checkitem['Tier'])
                ->set('OldArea', $checkitem['Area']);
            
            if ($Bay != ''){
                $this->ceh->where('VINNo', $checkitem['VINNo'])->set('Bay', $Bay);
            }   

            if ($Row != ''){
                $this->ceh->where('VINNo', $checkitem['VINNo'])->set('Row', $Row);
            }        
                
            $this->ceh->update('JOB_YARD');
        }
        else{
            /* Do nothing */
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
    }

    public function updateStockData($datas = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $checkitem = $this->ceh->select('rowguid, VINNo')
                                   ->where('rowguid', $item['rowguid'])
                                   ->where('VINNo', $item['VINNo'])
                                   ->limit(1)->get('DT_STOCK')->row_array();

            if(count($checkitem) > 0){
                $this->ceh->where('rowguid', $checkitem["rowguid"])
                           ->where('VINNo', $checkitem["VINNo"])
                           ->update('DT_STOCK', $item);
            }else{
                /* Do nothing */
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
    }

    public function updatePositionStatus($Bay = '', $Row = '', $value = 0){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('Bay', $Bay)->where('Row', $Row)->set('IsAvailable', $value)->update('BS_YP_PLAN');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function updateGOTransfer($VINNo = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('VINNO', $VINNo)
                    //->where('JobTypeID', 'GO')
                    //->or_where('JobTypeID', 'DF')
                    ->set('IsGOTransfered', 1)
                    ->update('JOB_YARD');

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }
    }

    public function updateQuayData($datas, $data_type = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($data_type == 'bulk'){
                if ($item['EirNo']){
                    $this->ceh->where('EirNo', $item['EirNo']);    
                }
                
                $this->ceh->where('Sequence', $item['Sequence'])
                        ->where('TruckNumber', $item['TruckNumber']);
            }

            $this->ceh->where('StockRef', $item['StockRef'])->update('JOB_QUAY', $item);     

            /* BULK CARGO: UPDATE DT_STOCKIN_BULK */
            if ($data_type == 'bulk'){
                $this->ceh->where('StockRef', $item['StockRef'])
                        ->where('Sequence', $item['Sequence'])
                        ->where('EirNo is NULL')
                        ->set('IsFinish', 1)
                        ->update('DT_STOCKIN_BULK');
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

    public function updateQuayBulkJobData($rowguid = '', $TruckNumber = '', $JobStatus = '', $StartDate = '', $FinishDate = '')
    {
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $checkSeq = $this->ceh->where('rowguid', $rowguid)->limit(1)->get('JOB_QUAY')->row_array();

        $this->ceh->where('rowguid', $rowguid);

        $this->ceh->set('Sequence', $checkSeq['Sequence'] + 1);

        if ($TruckNumber != ''){
            $this->ceh->set('TruckNumber', $TruckNumber);
        }

        $this->ceh->set('JobStatus', $JobStatus);

        if ($StartDate != ''){
            $this->ceh->set('StartDate', $StartDate);
        }

        if ($FinishDate != ''){
            $this->ceh->set('FinishDate', $FinishDate);
        }

        $this->ceh->update('JOB_QUAY');

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
}
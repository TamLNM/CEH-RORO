<?php
defined('BASEPATH') OR exit('');

class data_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function tracking($col, $val){
        $this->ceh->select('cd.*, v.ShipName, dm.CJModeName, ISNULL(cd.cBlock,\'\')+\'-\'+ISNULL(cd.cBay,\'\')+\'-\'+ISNULL(cd.cRow,\'\')+\'-\'+ISNULL(cd.cTier,\'\') cLocation
                            , CASE WHEN cd.cTLHQ = 1 THEN N\'Thanh lý hải quan\' ELSE N\'Chưa thanh lý hải quan\' END AS cTLHQ
                            , ISNULL( CONVERT( varchar(10), CLASS) , \'\')+\'-\'+ISNULL(UNNO,\'\') AS ClassUno
                            , v.ShipName+\'/\'+ImVoy+\'/\'+ExVoy AS ShipInfo
                            , ImVoy+\'/\'+ExVoy AS imexvoy');
        $this->ceh->join('DELIVERY_MODE AS dm', 'cd.CJMode_CD = dm.CJMode_CD', 'left');
        $this->ceh->join('VESSELS as v', 'cd.ShipID = v.ShipID', 'left');
        if($col == "CntrNo"){
            $this->ceh->where('cd.'.$col, $val);
            $this->ceh->order_by('cd.DateIn', 'DESC');
        }
        if($col == "BLNo"){
            $this->ceh->where_in('cd.CntrClass', array('1','4'));
            $this->ceh->where_in('cd.CMStatus', array('B','I','S','D'));
            $this->ceh->where('cd.BLNo', $val);
        }
        if($col == "BookingNo"){
            $this->ceh->where_in('cd.CntrClass', array('3','5'));
            $this->ceh->where_in('cd.CMStatus', array('B','I','S','O','D'));
            $this->ceh->where('cd.BookingNo', $val);
        }

        $this->ceh->where('cd.YardID', $this->YardID);

        $stmt = $this->ceh->get('CNTR_DETAILS AS cd');
        return $stmt->result_array();
    }

    public function loadVesselListForStockScreen(){
        $this->ceh->select('VoyageKey, VesselID, VesselName, InboundVoyage, OutboundVoyage, ETA, ETD, Status');
        $this->ceh->order_by('VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL_VISIT');
        return $stmt->result_array(); 
    }

    public function loadUnitListForStockScreen(){
        $this->ceh->select('UnitID, UnitName');
        $this->ceh->order_by('UnitID', 'ASC'); 
        $stmt = $this->ceh->get('BS_UNIT');
        return $stmt->result_array(); 
    }

    public function loadCustomerListForStockScreen(){
        $this->ceh->select('CusID, CusName');
        $this->ceh->order_by('CusID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CUSTOMER');
        return $stmt->result_array(); 
    }

    public function loadMethodListForStockScreen(){
        $this->ceh->select('MethodID, MethodName');
        $this->ceh->order_by('MethodID', 'ASC'); 
        $stmt = $this->ceh->get('BS_METHOD');
        return $stmt->result_array(); 
    }

    public function loadJobModeListForStockScreen(){
        $this->ceh->select('JobModeID, JobModeName');
        $this->ceh->order_by('JobModeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_JOB_MODE');
        return $stmt->result_array(); 
    }

     public function loadJobModeListHasIsVessel(){
        $this->ceh->select('JobModeID, JobModeName');
        $this->ceh->where('IsVessel', 1);
        $this->ceh->order_by('JobModeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_JOB_MODE');
        return $stmt->result_array(); 
    }

    public function loadPortListForStockScreen(){
        $this->ceh->select('PortID, PortName');
        $this->ceh->order_by('PortID', 'ASC'); 
        $stmt = $this->ceh->get('BS_PORT');
        return $stmt->result_array(); 
    }

    public function loadPortByLane($InLane = '', $OutLane = ''){
        $this->ceh->select('A.PortID as PortID, PortName');
        $this->ceh->where("(LaneID LIKE '%".$InLane."%' OR LaneID LIKE '%".$OutLane."%')", NULL, FALSE);
        $this->ceh->join('BS_PORT B', 'A.PortID = B.PortID');
        $this->ceh->order_by('A.PortID', 'ASC'); 
        $stmt = $this->ceh->get('BS_LANE_DETAILS A');
        return $stmt->result_array(); 
    }

    public function loadBrandListForManifestScreen(){
        $this->ceh->select('BrandID, BrandName');
        $this->ceh->order_by('BrandID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CAR_BRAND');
        return $stmt->result_array(); 
    }

    public function loadCarTypeListForManifestScreen(){
        $this->ceh->select('CarTypeID, CarTypeName, EngineType');
        $this->ceh->order_by('CarTypeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CAR_TYPE');
        return $stmt->result_array(); 
    }

    public function loadAllColForStockScreen($VoyageKey = '', $VINNo = '', $BillOfLadingORBookingNo = '', $IsLocalForeign = '', $ClassID = '')
    {
        $this->ceh->select('A.rowguid as rowguid, A.VoyageKey as VoyageKey, A.IsLocalForeign as IsLocalForeign, A.VINNo as VINNo, A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.Sequence as Sequence, A.VMStatus as VMStatus, VMStatusDesc, DateIn, JobModeInID, MethodInID, DateOut, JobModeOutID, MethodOutID, Block, Bay, Row, Tier, Area, InvNo, EirNo, OrderNo, PinCode, A.CusID as CusID, A.POL as POL, B.PortName as POLName, A.POD as POD, C.PortName as PODName, A.FPOD as FPOD, D.PortName as FPODName, A.ClassID as ClassID, ClassName, A.TransitID as TransitID, TransitName, G.CusTypeID as CusTypeID, CusTypeName, A.Remark as Remark, IsInJobQuay');

        if ($VoyageKey != '')
            $this->ceh->where('A.VoyageKey', $VoyageKey);
        
        if ($VINNo != '')
            $this->ceh->where('A.VINNo', $VINNo);

        if ($IsLocalForeign != ''){
            $this->ceh->where("A.IsLocalForeign", $IsLocalForeign);
        }

        if ($ClassID != ''){
            $this->ceh->where("A.ClassID", $ClassID);
            if ($BillOfLadingORBookingNo != ''){
                if ($ClassID == 1){
                    $this->ceh->where("A.BillOfLading", $BillOfLadingORBookingNo);
                }
                else{
                    $this->ceh->where("A.BookingNo", $BillOfLadingORBookingNo);
                }
            }
        }

        $this->ceh->join('BS_PORT B', 'A.POL = B.PortID', 'left');
        $this->ceh->join('BS_PORT C', 'A.POD = C.PortID', 'left');
        $this->ceh->join('BS_PORT D', 'A.FPOD = D.PortID', 'left');
        $this->ceh->join('BS_TRANSIT E', 'A.TransitID = E.TransitID', 'left');
        $this->ceh->join('BS_CLASS F', 'A.ClassID = F.ClassID', 'left');
        $this->ceh->join('BS_CUSTOMER G', 'A.CusID = G.CusID', 'left');
        $this->ceh->join('BS_CUSTOMER_TYPE H', 'G.CusTypeID = H.CusTypeID', 'left');      
        $this->ceh->join('BS_VMSTATUS I', 'A.VMStatus = I.VMStatus', 'left');      

        $this->ceh->order_by('A.VINNo', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCK A');
        return $stmt->result_array();         
    }


    public function loadAllColForStockScreen_Order($VoyageKey = '', $VINNo = '', $BillOfLadingORBookingNo = '', $IsLocalForeign = '', $ClassID = '')
    {
        $this->ceh->select('A.rowguid as rowguid, A.VoyageKey as VoyageKey, A.IsLocalForeign as IsLocalForeign, A.VINNo as VINNo, A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.Sequence as Sequence, VMStatus, DateIn, JobModeInID, MethodInID, DateOut, JobModeOutID, MethodOutID, Block, Bay, Row, Tier, Area, InvNo, EirNo, OrderNo, PinCode, A.CusID as CusID, A.POL as POL, B.PortName as POLName, A.POD as POD, C.PortName as PODName, A.FPOD as FPOD, D.PortName as FPODName, A.ClassID as ClassID, ClassName, A.TransitID as TransitID, TransitName, G.CusTypeID as CusTypeID, CusTypeName, CarWeight, KeyNo, A.Remark as Remark, I.BrandID as BrandID,  BrandName, I.CarTypeID as CarTypeID, CarTypeName');

        if ($VoyageKey != '')
            $this->ceh->where('A.VoyageKey', $VoyageKey);
        
        if ($VINNo != '')
            $this->ceh->where('A.VINNo', $VINNo);

        if ($BillOfLadingORBookingNo != ''){
            $this->ceh->where("A.BillOfLading", $BillOfLadingORBookingNo);
            $this->ceh->or_where("A.BookingNo", $BillOfLadingORBookingNo);
        }

        if ($IsLocalForeign != ''){
            $this->ceh->where("A.IsLocalForeign", $IsLocalForeign);
        }

        if ($ClassID != ''){
            $this->ceh->where("A.ClassID", $ClassID);
        }

        $this->ceh->join('BS_PORT B', 'A.POL = B.PortID');
        $this->ceh->join('BS_PORT C', 'A.POD = C.PortID');
        $this->ceh->join('BS_PORT D', 'A.FPOD = D.PortID');
        $this->ceh->join('BS_TRANSIT E', 'A.TransitID = E.TransitID', 'left');
        $this->ceh->join('BS_CLASS F', 'A.ClassID = F.ClassID', 'left');
        $this->ceh->join('BS_CUSTOMER G', 'A.CusID = G.CusID', 'left');
        $this->ceh->join('BS_CUSTOMER_TYPE H', 'G.CusTypeID = H.CusTypeID', 'left');
        $this->ceh->join('DT_MANIFEST I', 'A.VoyageKey = I.VoyageKey and A.VINNo = I.VINNo and (A.BillOfLading = I.BillOfLading or A.BookingNo = I.BookingNo)');
        $this->ceh->join('BS_CAR_BRAND J', 'I.BrandID = J.BrandID', 'left');
        $this->ceh->join('BS_CAR_TYPE L', 'I.CarTypeID = L.CarTypeID', 'left');
        
        $this->ceh->order_by('A.VINNo', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCK A');
        return $stmt->result_array();         
    }

    public function loadAllColForManifestScreen($VoyageKey = '', $IsLocalForeign = '', $ClassID = '')
    {

        $this->ceh->select('A.rowguid, VoyageKey, A.ClassID as ClassID, IsLocalForeign, BillOfLading, BookingNo, Sequence, VINNo, A.JobModeID as JobModeID, JobModeName, A.MethodID as MethodID, MethodName, A.BrandID as BrandID, BrandName, A.CarTypeID as CarTypeID, CarTypeName, A.EngineType as EngineType, CaseNo, ModelName, ChassisNumber, EngineSerial, BodyColor, Interier, Option, VonNo, CarWeight, KeyNo, POL, B.PortName as POLName, POD, C.PortName as PODName, FPOD, D.PortName as FPODName, A.Remark as Remark');

        if ($VoyageKey != '')
            $this->ceh->where('VoyageKey', $VoyageKey);

        if ($IsLocalForeign != '')
            $this->ceh->where('IsLocalForeign', $IsLocalForeign);

        if ($ClassID != '')
            $this->ceh->where('A.ClassID', $ClassID);

        $this->ceh->join('BS_PORT B', 'A.POL = B.PortID', 'left');        
        $this->ceh->join('BS_PORT C', 'A.POD = C.PortID', 'left');
        $this->ceh->join('BS_PORT D', 'A.FPOD = D.PortID', 'left');
        $this->ceh->join('BS_CAR_BRAND E', 'A.BrandID = E.BrandID', 'left');
        $this->ceh->join('BS_JOB_MODE F', 'A.JobModeID = F.JobModeID', 'left');
        $this->ceh->join('BS_METHOD G', 'A.MethodID = G.MethodID', 'left');
        $this->ceh->join('BS_CAR_TYPE H', 'A.CarTypeID = H.CarTypeID', 'left');

        $this->ceh->order_by('VINNo', 'ASC'); 
        $stmt = $this->ceh->get('DT_MANIFEST A');
        return $stmt->result_array();         
    }

    public function loadVesselListForManifestScreen($VBType = '', $VesselName = '', $Year = ''){
        $this->ceh->select('VoyageKey, A.VesselID as VesselID, A.VesselName as VesselName, InboundVoyage, OutboundVoyage, ETA, ETD, Status, InLane, OutLane, VesselType, Status, C.Email as Email');

        if ($VBType == 2)
            $this->ceh->where("Status", 7);
        else
            $this->ceh->where("Status !=", 7);

        if ($VesselName != '')
            //$this->ceh->where('VesselName', $VesselName);
            $this->ceh->like('VesselName', $VesselName);

        if ($Year != '')
            $this->ceh->where('YEAR(ETA)', $Year);

        $this->ceh->join('DT_VESSEL B', 'A.VesselID = B.VesselID');
        $this->ceh->join('BS_OPR C', 'B.OprID = C.OprID');
        $this->ceh->order_by('VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_VESSEL_VISIT A');
        return $stmt->result_array(); 
    }

    /* Stock */
    public function saveStock($datas, $VoyageKey = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($VoyageKey != '')
                $item['VoyageKey'] = $VoyageKey;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("VoyageKey")->where('VoyageKey', $item['VoyageKey'])
                                                        ->where('VINNo', $item['VINNo'])
                                                        ->where('BillOfLading', $item['BillOfLading'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('DT_STOCK')->row_array();
            if(count($checkitem) > 0){
                $this->ceh->where('VoyageKey', $checkitem["VoyageKey"])->update('DT_STOCK', $item);
            }else{
                //Insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('DT_STOCK', $item);
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

    public function updateStockData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $checkitem = $this->ceh->where('rowguid', $item['rowguid'])->limit(1)->get('DT_STOCK')->row_array();

            if (count($checkitem) > 0){
                $this->ceh->where('rowguid', $checkitem['rowguid'])->update('DT_STOCK', $item);
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

    public function deleteStock($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            if ($item['BillOfLading'] != '')
                $this->ceh->where('BillOfLading', $item['BillOfLading']);

            if ($item['BookingNo'] != '')
                $this->ceh->where('BookingNo', $item['BookingNo']);

            $this->ceh->where('VoyageKey', $item["VoyageKey"])
                      ->where('VINNo', $item['VINNo'])                                            
                      ->limit(1)
                      ->delete('DT_STOCK');
                         
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

    /* Manifest */
    public function saveManifest($datas, $VoyageKey = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($VoyageKey != '')
                $item['VoyageKey'] = $VoyageKey;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            if(isset($item['EngineType'])){
                $item['EngineType'] = UNICODE.$item['EngineType'];
            }

            if ($item['ClassID'] == 1){
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('BillOfLading', $item['BillOfLading'])
                                        ->where('VINNo', $item['VINNo'])                                           
                                        ->limit(1)->get('DT_MANIFEST')->row_array();

                if(count($checkitem) > 0){
                    $this->ceh->where('VoyageKey', $checkitem["VoyageKey"])
                          ->where('BillOfLading', $checkitem['BillOfLading'])
                          ->where('VINNo', $checkitem['VINNo'])                                            
                          ->update('DT_MANIFEST', $item);
                }
                else{
                    //Insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('DT_MANIFEST', $item);
                }            
            }
            else{
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('BookingNo', $item['BookingNo'])
                                        ->where('VINNo', $item['VINNo'])                                           
                                        ->where('YardID', $item['YardID'])
                                        ->limit(1)->get('DT_MANIFEST')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('VoyageKey', $checkitem["VoyageKey"])
                          ->where('BookingNo', $checkitem['BookingNo'])
                          ->where('VINNo', $checkitem['VINNo'])                                            
                          ->where('YardID', $checkitem['YardID'])
                          ->update('DT_MANIFEST', $item);
                }
                else{
                    //Insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('DT_MANIFEST', $item);
                }          
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

    public function deleteManifest($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $this->ceh->where('rowguid', $item)->delete('DT_MANIFEST');             
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

    // Get Manifest List
    public function getManifestList(){
        $this->ceh->select('ClassID, IsLocalForeign, BillOfLading');
        $this->ceh->order_by('ClassID', 'ASC'); 
        $stmt = $this->ceh->get('DT_MANIFEST');
        return $stmt->result_array();     
    }

    public function loadJobQuayList($VoyageKey = ''){ 
        if ($VoyageKey){
            $this->ceh->where('VoyageKey', $VoyageKey);
        }
    
        $stmt = $this->ceh->get('JOB_QUAY');
        return $stmt->result_array(); 
    }

    public function loadCHEList(){
        $stmt = $this->ceh->get('JOB_YARD');
        return $stmt->result_array();     
    }

    public function updateStockStatus($StockRef = '', $VMStatus = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('rowguid', $StockRef)->set('VMStatus', $VMStatus)->update('DT_STOCK');

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

    public function updateYardData($VINNo = '', $JobTypeID = '', $JobStatus = '', $FinishDate = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('VINNo', $VINNo)
                    ->where('JobTypeID', $JobTypeID)
                    ->set('JobStatus', $JobStatus)
                    ->set('FinishDate', $FinishDate)
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

        return $result;
    }

    public function updateStockDataByGate($PINCodeOREirNo = '', $VINNo = '', $VMStatus = '', $DateOut = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('VINNo', $VINNo);

        $this->ceh->where('EirNo', $PINCodeOREirNo)->or_where('PinCode', $PINCodeOREirNo);

        $this->ceh->set('VMStatus', $VMStatus)->set('DateOut', $DateOut)->update('DT_STOCK');

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

    public function saveJobQuay($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->where('ClassID', 1)
                                        ->where('VINNo', $item['VINNo'])
                                        ->where('BillOfLading', $item['BillOfLading'])
                                        ->limit(1)->get('JOB_QUAY')->row_array();
            if(count($checkitem) > 0){
                /* Do nothing */
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('JOB_QUAY', $item);
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
}
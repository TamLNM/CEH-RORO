<?php
defined('BASEPATH') OR exit('');

class common_model extends CI_Model
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
//                $this->ceh->join('DELIVERY_METHODS AS dme', 'cd.DMethod_CD = dme.DMethod_CD', 'left');
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

    //get function code
    public function getTariff(){
        $this->ceh->select('TRF_CODE ID, TRF_DESC NAME');
        $this->ceh->order_by('TRF_DESC', 'ASC');

        $this->ceh->where('YardID', $this->YardID);

        $stmt = $this->ceh->get('TRF_CODES');
        return $stmt->result_array();
    }

    public function getOprs(){
        $inWhere = $this->ceh->select("OprID")->get_compiled_select("CNTR_SZTP_MAP", TRUE);
        
        $this->ceh->select('CusID, CusName');
        $this->ceh->where('IsOpr', 1);
        $this->ceh->where("CusID IN ($inWhere)");

        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('BS_CUSTOMER');
        return $stmt->result_array();
    }

    public function getPayers( $user = '' ){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('IsOwner', 1);
        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('BS_CUSTOMER');
        return $stmt->result_array();
    }
    public function getSizeType( $opr = '' ){
        $this->ceh->select('OprID, LocalSZPT, ISO_SZTP');
        
        if($opr != ''){
            $this->ceh->where('OprID', $opr);
        }

        $this->ceh->order_by('LocalSZPT', 'ASC');
        $stmt = $this->ceh->get('CNTR_SZTP_MAP');
        return $stmt->result_array();
    }
    public function getPayers_Inv(){
        $this->ceh->distinct();
        $this->ceh->select('PAYER ID, CusName NAME');
        $this->ceh->join('BS_CUSTOMER c', 'c.CusID = i.PAYER');
        $this->ceh->where('PAYER IS NOT NULL');

        $this->ceh->where('i.YardID', $this->YardID);

        $this->ceh->order_by('c.CusName', 'ASC');
        $stmt = $this->ceh->get('INV_VAT i');
        return $stmt->result_array();
    }
    public function getPayers_InvDFT(){
        $this->ceh->distinct();
        $this->ceh->select('PAYER, CusName');
        $this->ceh->join('BS_CUSTOMER c', 'c.CusID = i.PAYER');
        $this->ceh->where('PAYER IS NOT NULL');

        $this->ceh->where('i.YardID', $this->YardID);

        $this->ceh->order_by('c.CusName', 'ASC');
        $stmt = $this->ceh->get('INV_DFT i');
        return $stmt->result_array();
    }
    public function searchShip($arrStatus = '', $year = '', $name = ''){
        $this->ceh->select('ShipKey, ShipID, ShipYear, ShipVoy, ImVoy, ExVoy, ETB, ETD');
        if($arrStatus != ''){
            if( $arrStatus == "1" ){
                $this->ceh->where('ShipArrStatus IN (0, 1)');
            }else{
                $this->ceh->where('ShipArrStatus', $arrStatus);
            }
        }
        if($year != ''){
            $this->ceh->where('ShipYear', $year);
        }
        if($name != ''){
            $this->ceh->like('ShipID', $name);
        }

        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->order_by('ETB', 'DESC');
        $stmt = $this->ceh->get('VESSEL_SCHEDULE');
        return $stmt->result_array();
    }

    //load data
    public function loadVesselSchedule($fromdate = '', $todate = ''){
        $this->ceh->select('vv.ShipID, ShipName, ShipYear, ShipVoy, Opr_CD, CALL_NO, BERTH_NO, ALONGSIDE, ImVoy, ExVoy, ETA, ETB, ETW, ETD, ATA, ATW, ATD');
        $this->ceh->join('VESSELS vv','vs.ShipID = vv.ShipID');
        if($fromdate != '')
            $this->ceh->where('ETB >=', $fromdate);
        if($todate != '')
            $this->ceh->where('ETB <=', $todate);
        $this->ceh->order_by('ETB', 'DESC');

        $this->ceh->where('vs.YardID', $this->YardID);

        $stmt = $this->ceh->get('VESSEL_SCHEDULE vs');
        return $stmt->result_array();
    }

    public function loadCustomers($type = '', $id = '', $name = '', $taxcode = ''){
        $this->ceh->select('B.YardID as YardID, A.CusTypeID as CusTypeID, CusTypeName, C.PaymentTypeID as PaymentTypeID, PaymentTypeName, CusID, CusName, TaxCode, Tel, Fax, Address, Email, IsActive, B.rowguid as rowguid');

        $this->ceh->join('BS_CUSTOMER_TYPE A', 'A.CusTypeID = B.CusTypeID', 'left');
        $this->ceh->join('BS_INV_PAYMENT_TYPE C', 'B.PaymentTypeID = C.PaymentTypeID', 'left');
        //$this->ceh->join('BS_CUSTOMER_TYPE A', 'A.CusTypeID = B.CusTypeID', 'left');
        
        if($type != '')
            $this->ceh->where('A.CusTypeID', $type);
        if($id != '')
            $this->ceh->where('CusID', $id);
        if($name != '')
            $this->ceh->like('CusName', $name);
        if($taxcode != '')
            $this->ceh->like('TaxCode', $taxcode);

        $this->ceh->where('B.YardID', $this->session->userdata["YardID"]);
        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('BS_CUSTOMER B');
        return $stmt->result_array();
    }

    public function loadSizeTypeMapping($oprs = ''){
        if($oprs != '')
            $this->ceh->where('OprID', $oprs);

        $this->ceh->order_by('OprID', 'ASC');
        $stmt = $this->ceh->get('CNTR_SZTP_MAP');
        return $stmt->result_array();
    }

    public function loadLaneDetailByID($LaneID = ''){
        if($LaneID != '')
            $this->ceh->where('A.LaneID', $LaneID);

        $this->ceh->select('A.LaneID as LaneID, LaneName, A.PortID as PortID, A.ShortPort as ShortPort, PortSeq, BackColor, ForeColor, C.NationID as NationID, B.OprID as OprID');

        $this->ceh->join('BS_LANE B', 'A.LaneID = B.LaneID');
        $this->ceh->join('BS_PORT C', 'A.PortID = C.PortID');
        $this->ceh->join('BS_NATIONAL D', 'C.NationID = D.NationID');

        $this->ceh->order_by('PortSeq', 'ASC');
        $stmt = $this->ceh->get('BS_LANE_DETAILS A');
        return $stmt->result_array();
    }
    
    public function loadExistPortListByLaneID($LaneID = ''){
        $this->ceh->select('PortID');
        $this->ceh->where('LaneID', $LaneID);
        $this->ceh->order_by('PortID', 'ASC');
        $stmt = $this->ceh->get('BS_LANE_DETAILS');
        return $stmt->result_array();
    }

    public function loadLaneByID($LaneID = ''){
        if($LaneID != '')
            $this->ceh->where('LaneID', $LaneID);
        $this->ceh->order_by('LaneID', 'ASC');
        $stmt = $this->ceh->get('BS_LANE');
        return $stmt->result_array();
    }

    public function loadCargoType(){
        $this->ceh->order_by('Code', 'ASC');
        $stmt = $this->ceh->get('CARGO_TYPE');
        return $stmt->result_array();
    }

    public function loadUnitCodes(){
        $this->ceh->select('UnitID, UnitName');
        $this->ceh->order_by('UnitID', 'ASC');
        $stmt = $this->ceh->get('BS_UNIT');
        return $stmt->result_array();
    }

    public function loadDamagedTypeList(){
        $this->ceh->select('DamagedTypeID, DamagedTypeName, rowguid');
        $this->ceh->order_by('DamagedTypeID', 'ASC');
        $stmt = $this->ceh->get('BS_DAMAGED_TYPE');
        return $stmt->result_array();
    }

    public function loadDamagedList(){
        $this->ceh->select('A.DamagedTypeID as DamagedTypeID, DamagedTypeName, DamagedID, DamagedName, A.rowguid as rowguid');    
        $this->ceh->join('BS_DAMAGED_TYPE B', 'A.DamagedTypeID = B.DamagedTypeID');
        $this->ceh->order_by('DamagedID', 'ASC');
        $stmt = $this->ceh->get('BS_DAMAGED A');
        return $stmt->result_array();
    }

    public function loadCusType(){
        // $this->ceh->select(array('',''))
        $this->ceh->select('CusTypeID, CusTypeName, rowguid');
        $this->ceh->order_by('CusTypeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CUSTOMER_TYPE');
        return $stmt->result_array();
    }

    public function loadCus(){
        $this->ceh->select('CusID, CusName, Address, A.CusTypeID as CusTypeID, CusTypeName, A.rowguid as rowguid, A.PaymentTypeID as PaymentTypeID, PaymentTypeName');
        $this->ceh->join('BS_CUSTOMER_TYPE B', 'A.CusTypeID = B.CusTypeID', 'left');
        $this->ceh->join('BS_INV_PAYMENT_TYPE C', 'A.PaymentTypeID = C.PaymentTypeID', 'left');
        $this->ceh->order_by('CusID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CUSTOMER A');
        return $stmt->result_array();
    }

    public function loadPaymentTypeList(){
        $this->ceh->select('PaymentTypeID, PaymentTypeName');
        $this->ceh->order_by('PaymentTypeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_INV_PAYMENT_TYPE');
        return $stmt->result_array();
    }
    
    public function loadBittList(){
        $this->ceh->select('BerthID, BittID, CoordX, CoordY, rowguid');
        $this->ceh->order_by('BittID', 'ASC'); 
        $stmt = $this->ceh->get('BS_BITT');
        return $stmt->result_array();        
    }

    public function loadBerthList(){       
        $this->ceh->order_by('BerthID', 'ASC'); 
        $stmt = $this->ceh->get('BS_BERTH');
        return $stmt->result_array();    
    }

    public function loadBerthID(){       
        $this->ceh->select('BerthID');
        $this->ceh->order_by('BerthID', 'ASC'); 
        $stmt = $this->ceh->get('BS_BERTH');
        return $stmt->result_array();    
    }

    public function loadWorkerGroupTypeList(){
        $this->ceh->select('WorkerGroupType, WorkerGroupTypeName');
        $this->ceh->order_by('WorkerGroupType', 'ASC'); 
        $stmt = $this->ceh->get('BS_WORKER_GROUP_TYPE');
        return $stmt->result_array();    
    }

    public function loadWorkerGroupList(){
        $this->ceh->select('A.WorkerGroupType as WorkerGroupType, WorkerGroupTypeName, WorkerGroupID, WorkerGroupName');
        $this->ceh->join('BS_WORKER_GROUP_TYPE B', 'A.WorkerGroupType = B.WorkerGroupType');
        $this->ceh->order_by('WorkerGroupID', 'ASC'); 
        $stmt = $this->ceh->get('BS_WORKER_GROUP A');
        return $stmt->result_array();    
    }

    public function loadNationList(){
        $this->ceh->select('NationID, NationName, Flag');
        $this->ceh->order_by('NationID', 'ASC'); 
        $stmt = $this->ceh->get('BS_NATIONAL');
        return $stmt->result_array();
    }

    public function loadPortListForPortScreen(){
        $this->ceh->select('A.NationID, NationName, PortID, PortName');
        $this->ceh->join('BS_NATIONAL B', 'A.NationID = B.NationID');
        $this->ceh->order_by('A.NationID', 'ASC'); 
        $this->ceh->where('A.YardID', $this->session->userdata["YardID"]);
        $stmt = $this->ceh->get('BS_PORT A');
        return $stmt->result_array();
    }

    public function loadPortList(){
        $this->ceh->select('A.PortID as PortID, PortName, A.NationID as NationID, NationName');
        $this->ceh->join('BS_NATIONAL B', 'A.NationID = B.NationID');
        $this->ceh->order_by('PortID', 'ASC');
        $stmt = $this->ceh->get('BS_PORT A');
        return $stmt->result_array();
    }

     public function loadLaneList(){
        $this->ceh->distinct();
        $this->ceh->select('LaneID');
        $this->ceh->order_by('LaneID', 'ASC');
        $stmt = $this->ceh->get('BS_LANE');
        return $stmt->result_array();
    }

    public function loadAllColCustomer(){
        $this->ceh->select('CusTypeID, CusID, CusName, TaxCode, PaymentTypeID, Tel, Fax, Address, Email, IsActive');
        $this->ceh->order_by('CusID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CUSTOMER');
        return $stmt->result_array();
    }

    public function loadAllColJobModes(){
        $this->ceh->select('A.ClassID as ClassID, ClassName, A.TransitID as TransitID, TransitName,  InOut, JobModeID, JobModeName, IsYard, IsVessel, CustomsJobType, Remark');
        $this->ceh->join('BS_TRANSIT B', 'A.TransitID = B.TransitID', 'left');
        $this->ceh->join('BS_CLASS C', 'A.ClassID = C.ClassID', 'left');
        $this->ceh->order_by('JobModeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_JOB_MODE A');
        return $stmt->result_array();
    }

    public function loadJobModesList(){
        $this->ceh->select('JobModeID, JobModeName, IsYard, IsVessel');
        $this->ceh->order_by('JobModeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_JOB_MODE');
        return $stmt->result_array();
    }
    
    public function loadOprList(){
        $this->ceh->order_by('OprID', 'ASC'); 
        $stmt = $this->ceh->get('BS_OPR');
        return $stmt->result_array();
    }

    public function loadTransitList(){
        $this->ceh->select('TransitID, TransitName');
        $this->ceh->order_by('TransitID', 'ASC'); 
        $stmt = $this->ceh->get('BS_TRANSIT');
        return $stmt->result_array();
    }

    public function loadAllColGateList(){
        $this->ceh->select('GateID, GateName, InOut, A.ClassID as ClassID, ClassName, A.rowguid as rowguid');
        $this->ceh->order_by('GateID', 'ASC'); 
        $this->ceh->join('BS_CLASS B', 'A.ClassID = B.ClassID');
        $stmt = $this->ceh->get('BS_GATE A');
        return $stmt->result_array();
    }

    public function loadAllColServices(){
        $this->ceh->select('ServiceID, ServiceName, A.JobModeID as JobModeID, JobModeName, IsQuayJob, IsYardJob, IsGateJob');
        $this->ceh->join('BS_JOB_MODE B', 'A.JobModeID = B.JobModeID');
        $this->ceh->order_by('ServiceID', 'ASC');
        $this->ceh->where('A.YardID', $this->session->userdata["YardID"]); 
        $stmt = $this->ceh->get('BS_SERVICE A');
        return $stmt->result_array();
    }

    public function loadAllColJobTypes(){
        $this->ceh->select('JobTypeID, JobTypeName, MoveType, IsQuayJob, IsYardJob, IsGateJob');
        $this->ceh->order_by('JobTypeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_JOB_TYPE');
        return $stmt->result_array();
    }

    public function loadAllColMethodList(){
        $this->ceh->select('A.JobModeID, JobModeName, MethodID, MethodName');
        $this->ceh->join("BS_JOB_MODE B", "A.JobModeID = B.JobModeID");
        $this->ceh->order_by('JobModeID', 'ASC'); 
        $stmt = $this->ceh->get('BS_METHOD A');
        return $stmt->result_array();
    }

    public function loadAllColShiftList(){
        $this->ceh->select('ShiftID, ShiftName, FromTime, ToTime');
        $this->ceh->order_by('ShiftID', 'ASC'); 
        $stmt = $this->ceh->get('BS_SHIFT');
        return $stmt->result_array();
    }         

    public function loadAllColCarBrand(){
        $this->ceh->select('BrandID, BrandName, rowguid');
        $this->ceh->order_by('BrandID', 'ASC'); 
        $stmt = $this->ceh->get('BS_CAR_BRAND A');
        return $stmt->result_array();
    }  

    public function loadAllColCarType(){
        $this->ceh->select('A.BrandID as BrandID, BrandName, CarTypeID, CarTypeName, EngineType, CarYear, CarColor, A.rowguid as rowguid');
        $this->ceh->order_by('CarTypeID', 'ASC'); 
        $this->ceh->join("BS_CAR_BRAND B", "A.BrandID = B.BrandID");
        $stmt = $this->ceh->get('BS_CAR_TYPE A');
        return $stmt->result_array();
    } 

    public function loadAllColPaymentType(){
        $this->ceh->select('PaymentTypeID, PaymentTypeName');
        $this->ceh->order_by('PaymentTypeID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_PAYMENT_TYPE');
        return $stmt->result_array();
    } 

    public function loadAllColPaymentForm(){
        $this->ceh->select('A.PaymentTypeID as PaymentTypeID, PaymentTypeName, PayFormID, PayFormName');
        $this->ceh->join("BS_INV_PAYMENT_TYPE B", "A.PaymentTypeID = B.PaymentTypeID");
        $this->ceh->order_by('PayFormID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_PAY_FORM A');
        return $stmt->result_array();
    }

    public function loadAllColRateList(){
        $this->ceh->select('RateID, A.BrandID as BrandID, BrandName, ExchangeRate');
        $this->ceh->join("BS_CAR_BRAND B", "A.BrandID = B.BrandID");
        $this->ceh->order_by('RateID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_RATE A');
        return $stmt->result_array();
    } 

    public function loadAllColTransit(){
        $this->ceh->select('TransitID, TransitName');
        $this->ceh->order_by('TransitID', 'ASC');
        $stmt = $this->ceh->get('BS_TRANSIT');
        return $stmt->result_array();
    }

    public function loadAllColArea(){
        $this->ceh->select('Area, AreaName, Capacity, rowguid');
        $this->ceh->order_by('Area', 'ASC');
        $stmt = $this->ceh->get('BS_YP_AREA');
        return $stmt->result_array();
    }
    // Get cus data array to export
    public function getCusList(){
        $this->ceh->select(array('c.CusTypeID', 'c.cusID', 'c.CusName', 'TaxCode', 'Tel', 'Fax', 'Address', 'Email', 'IsActive'));   
        $this->ceh->from('import as c');
        $query = $this->ceh->get();
        return $query->result_array();
    }

    public function loadPaymentMethod(){
        $this->ceh->select('rowguid, ACC_CD, ACC_NO, ACC_TYPE, ACC_NAME');

        $stmt = $this->ceh->get('ACCOUNTS');
        return $stmt->result_array();
    }

    public function loadDeliveryMode(){
        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->where_in('CJMode_CD', array('LAYN', 'CAPR', 'HBAI', 'TRAR'));

        $this->ceh->order_by('CJMode_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function loadExchangeRate(){
        $this->ceh->select('CURRENCYID, DATEOFRATE, RATE');

        $this->ceh->order_by('CURRENCYID', 'ASC');
        $stmt = $this->ceh->get('EXCHANGE_RATE');
        return $stmt->result_array();
    }

    public function loadMethodMode(){
        $this->ceh->select('MAPA_Code, MAPA_Name');

        $this->ceh->order_by('MAPA_Code', 'ASC');
        $stmt = $this->ceh->get('MENTHOD_MODE');
        return $stmt->result_array();
    }

    public function loadCntrClass(){
        $this->ceh->select('CLASS_Code, CLASS_Name');

        $this->ceh->order_by('CLASS_Code', 'ASC');
        $stmt = $this->ceh->get('CLASS_MODE');
        return $stmt->result_array();
    }

    public function loadDMethodInServices(){
        $this->ceh->select('CJMode_CD, CJModeName, isLoLo, ischkCFS, isYardSRV');

        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->where('isLoLo', 1);
        $this->ceh->or_where('isYardSRV', 1);
        $this->ceh->or_where('ischkCFS !=', 0);

        $this->ceh->order_by('CJMode_CD', 'ASC');

        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function loadServiceMore(){
        $this->ceh->select('ORD_TYPE, CjMode_CD, chkPrint');

        $this->ceh->where('YardID', $this->YardID);

        $stmt = $this->ceh->get('SRVMORE');
        return $stmt->result_array();
    }

    public function loadServiceList(){
        $this->ceh->select('ServiceID, ServiceName');
        $this->ceh->order_by('ServiceID');
        $stmt = $this->ceh->get('BS_SERVICE');
        return $stmt->result_array();
    }

    public function loadPayFormByPaymentTypeID($PaymentTypeID = ''){
        $this->ceh->distinct();
        $this->ceh->select('PayFormID, PayFormName');
        if ($PaymentTypeID){
            $this->ceh->where('PaymentTypeID', $PaymentTypeID);
        }
        $stmt = $this->ceh->get('BS_INV_PAY_FORM');
        return $stmt->result_array();
    }

    public function loadServiceTemplate(){
        $getOrdType = $this->ceh->select("ORD_TYPE")->where("TPLT_NM = i.TPLT_NM")
                                                    ->where("YardID = ".$this->YardID)
                                                    ->limit(1)
                                                    ->get_compiled_select("ORD_TPLT", TRUE);

        $this->ceh->distinct();
        $this->ceh->select("i.TPLT_NM, i.TPLT_DESC, ($getOrdType) AS ORD_TYPE");

        $this->ceh->where('i.YardID', $this->YardID);

        $stmt = $this->ceh->get("INV_TPLT i");
        return $stmt->result_array();
    }

    public function loadEir($oprs = array()){
        $this->ceh->select('CntrNo, EIRNo, IssueDate, ExpDate, ExpPluginDate, bXNVC, OprID, LocalSZPT, ISO_SZTP, CARGO_TYPE, Status, ShipID, ImVoy, ExVoy
                            , CJMode_CD, DMethod_CD, TruckNo, CMDWeight, BLNo, BookingNo, SealNo, SealNo1, SealNo2, RetLocation, IsLocal, CusName, Note, CreatedBy
                            , DRAFT_INV_NO, InvNo');
        if($oprs['FROM_DATE'] != '')
            $this->ceh->where('IssueDate >=', $oprs['FROM_DATE']);
        if($oprs['TO_DATE'] != '')
            $this->ceh->where('IssueDate <=', $oprs['TO_DATE']);
        if($oprs['OprID'] != '')
            $this->ceh->where('OprID', $oprs['OprID']);
        if($oprs['PAYMENT_TYPE'] != '')
            $this->ceh->where('PAYMENT_TYPE', $oprs['PAYMENT_TYPE']);
        if($oprs['CntrNo'] != '')
            $this->ceh->like('CntrNo', $oprs['CntrNo']);
        if($oprs['ShipKey'] != '')
            $this->ceh->where('ShipKey', $oprs['ShipKey']);
        if($oprs['bXNVC'] != '')
            $this->ceh->where('bXNVC <= ', $oprs['bXNVC']);
        if(isset($oprs['CJMode_CD']) && count($oprs['CJMode_CD']) > 0)
            $this->ceh->where_in('CJMode_CD', $oprs['CJMode_CD']);

        $this->ceh->where('YardID', $this->YardID);

        $this->ceh->order_by('IssueDate', 'DESC');
        $stmt = $this->ceh->get('EIR');
        return $stmt->result_array();
    }

    public function loadInvDraff($wheres = array()){
        $this->ceh->distinct();
        $this->ceh->select('inv_dtl.rowguid, inv.INV_DATE, inv.ShipID, inv.ShipYear, inv.ShipVoy, cc.Opr_CD as VSL_OWNER, inv.INV_NO, inv.OPR, inv.PAYER, m.CusName, inv_dft.REF_NO
				                , inv_dtl.DRAFT_INV_NO, inv_dtl.TRF_CODE, inv_dtl.TRF_DESC, inv_dtl.CARGO_TYPE, inv_dtl.FE, inv_dtl.SZ, inv_dtl.QTY, inv_dtl.Remark
		                        , inv_dtl.AMOUNT as AMOUNT , inv_dtl.VAT_RATE as VAT_RATE,inv_dtl.VAT as VAT, inv.DISCOUNT_AMT, inv.DISCOUNT_VAT, inv_dtl.TAMOUNT AS TAMOUNT');
        $this->ceh->join('VESSEL_SCHEDULE cc', 'inv.ShipKey=cc.ShipKey', 'left');
        $this->ceh->join('BS_CUSTOMER m', 'inv.payer=m.CusID', 'left');
        $this->ceh->join('INV_DFT inv_dft', 'inv.INV_NO=inv_dft.INV_NO', 'left');
        $this->ceh->join('INV_DFT_DTL inv_dtl', 'inv_dft.DRAFT_INV_NO=inv_dtl.DRAFT_INV_NO', 'left');
        $this->ceh->where('inv_dtl.DRAFT_INV_NO IS NOT NULL');

        if($wheres['FROM_DATE'] != '')
            $this->ceh->where('inv.INV_DATE >=', $wheres['FROM_DATE']);

        if($wheres['TO_DATE'] != '')
            $this->ceh->where('inv.INV_DATE <=', $wheres['TO_DATE']);

        if($wheres['OprID'] != '')
            $this->ceh->where('inv.OPR', $wheres['OprID']);

        if(isset($wheres['PAYMENT_STATUS']) && count($wheres['PAYMENT_STATUS']) > 0)
            $this->ceh->where_in('inv.PAYMENT_STATUS', $wheres['PAYMENT_STATUS']);

        if($wheres['CreatedBy'] != '')
            $this->ceh->like('inv.CreatedBy', $wheres['CreatedBy']);

        if($wheres['CusID'] != '')
            $this->ceh->where('inv.PAYER', $wheres['CusID']);

        if(isset($wheres['INV_TYPE']) && count($wheres['INV_TYPE']) > 0)
            $this->ceh->where_in('inv.INV_TYPE', $wheres['INV_TYPE']);

        if(isset($wheres['CURRENCYID']) && count($wheres['CURRENCYID']) > 0)
            $this->ceh->where_in('inv.CURRENCYID', $wheres['CURRENCYID']);

        $this->ceh->where('inv.YardID', $this->YardID);

        $this->ceh->order_by('inv.INV_DATE', 'DESC');
        $stmt = $this->ceh->get('INV_VAT inv');
        return $stmt->result_array();
    }

    public function loadInv($wheres = array()){
        $this->ceh->select('a.DISCOUNT_AMT,a.DISCOUNT_VAT,a.inv_no , c.VAT_RATE,a.inv_date,a.ShipID,a.ShipYear,a.ShipVoy, a.payer,m.VAT_CD, a.CreatedBy, a.OPR
                            , a.REF_NO, a.Remark,sum(c.amount) as amount,c.TRF_CODE ,sum(c.vat) as vat,sum(c.tamount) as tamount,c.dis_amt, b.draft_inv_no
                            , b.draft_inv_date, m.CusName,c.TRF_DESC');
        $this->ceh->join('BS_CUSTOMER m', 'a.payer=m.CusID', 'left');
        $this->ceh->join('INV_DFT b', 'a.inv_no=b.inv_no');
        $this->ceh->join('INV_DFT_DTL c', 'b.draft_inv_no=c.draft_inv_no');
        $this->ceh->where('a.INV_TYPE', 'CAS');
        $this->ceh->where('a.PAYMENT_STATUS', 'Y');

        if($wheres['FROM_DATE'] != '')
            $this->ceh->where('a.INV_DATE >=', $wheres['FROM_DATE']);

        if($wheres['TO_DATE'] != '')
            $this->ceh->where('a.INV_DATE <=', $wheres['TO_DATE']);

        if($wheres['ShipKey'] != '')
            $this->ceh->where('a.ShipKey', $wheres['ShipKey']);

        if($wheres['PAYER'] != '')
            $this->ceh->where('a.PAYER', $wheres['PAYER']);

        if($wheres['CreatedBy'] != '')
            $this->ceh->like('a.CreatedBy', $wheres['CreatedBy']);

        if($wheres['TRF_CODE'] != '')
            $this->ceh->where('c.TRF_CODE', $wheres['TRF_CODE']);

        if(isset($wheres['CURRENCYID']) && count($wheres['CURRENCYID']) > 0)
            $this->ceh->where_in('a.CURRENCYID', $wheres['CURRENCYID']);

        $this->ceh->group_by(array('a.DISCOUNT_AMT','a.DISCOUNT_VAT','a.inv_no ',' c.VAT_RATE','a.inv_date','a.ShipID','a.ShipYear'
                                    ,'a.ShipVoy',' a.payer','m.VAT_CD',' a.CreatedBy',' a.OPR',' a.REF_NO','a.Remark'
                                    ,'c.TRF_CODE','c.dis_amt',' b.draft_inv_no',' b.draft_inv_date','  m.CusName','c.TRF_DESC'));

        $this->ceh->where('a.YardID', $this->YardID);

        $this->ceh->order_by('a.inv_date','ASC');
        $this->ceh->order_by('a.inv_no','ASC');
        $this->ceh->order_by('a.payer', 'ASC');

        $stmt = $this->ceh->get('INV_VAT a');
        return $stmt->result_array();
    }

    /* Customer */
    public function saveCustomers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
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
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkitem = $this->ceh->select("CusID")->where('CusID', $item['CusID'])
                                                    ->where('YardID', $item['YardID'])
                                                    ->limit(1)
                                                    ->get('BS_CUSTOMER')
                                                    ->row_array();
            if(count($checkitem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_CUSTOMER', $item);
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

    public function updateCustomers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            if(isset($item['CusName'])){
                $item['CusName'] = UNICODE.$item['CusName'];
            }

            if(isset($item['Address'])){
                $item['Address'] = UNICODE.$item['Address'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, CusID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_CUSTOMER')->row_array();

            if(count($checkItem) > 0){
                $checkExistStock        = $this->ceh->where('CusID', $checkItem['CusID'])
                                                ->limit(1)
                                                ->get('DT_STOCK')->row_array();

                $checkExistTRFDiscount  = $this->ceh->where('CusID', $checkItem['CusID'])
                                                ->limit(1)
                                                ->get('TRF_DISCOUNT')->row_array();

                if ((count($checkExistStock)      == 0 &&
                     count($checkExistTRFDiscount   == 0)
                    ) 
                    || ($item['CusID'] == $checkItem['CusID']))
                {                    
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_CUSTOMER', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{
                    if (count($checkExistStock) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh dữ liệu Stock với Mã khách hàng: '.$checkItem['CusID'].$checkItem['rowguid']);
                    }

                    if (count($checkExistTRFDiscount) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Hợp đồng với Mã khách hàng: '.$checkItem['CusID'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }        
    }

    public function savePorts($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['PortName'])){
                $item['PortName'] = UNICODE.$item['PortName']; // = N'' trong SQL
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("PortID")->where('PortID', $item['PortID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_PORT')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('PortID', $checkitem["PortID"])->update('BS_PORT', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('BS_PORT', $item);
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

    public function saveJobModes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['JobModeName'])){
                $item['JobModeName'] = UNICODE.$item['JobModeName']; 
            }


            if(isset($item['Remark'])){
                $item['Remark'] = UNICODE.$item['Remark']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("JobModeID")->where('JobModeID', $item['JobModeID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_JOB_MODE')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('JobModeID', $checkitem["JobModeID"])->update('BS_JOB_MODE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_JOB_MODE', $item);
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

    public function saveJobTypes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['JobTypeName'])){
                $item['JobTypeName'] = UNICODE.$item['JobTypeName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("JobTypeID")->where('JobTypeID', $item['JobTypeID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_JOB_TYPE')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('JobTypeID', $checkitem["JobTypeID"])->update('BS_JOB_TYPE', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('BS_JOB_TYPE', $item);
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

    public function saveServices($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['ServiceName'])){
                $item['ServiceName'] = UNICODE.$item['ServiceName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("ServiceID")->where('ServiceID', $item['ServiceID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_SERVICE')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('ServiceID', $checkitem["ServiceID"])->update('BS_SERVICE', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('BS_SERVICE', $item);
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
    
    public function saveMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['MethodName'])){
                $item['MethodName'] = UNICODE.$item['MethodName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("MethodID")->where('MethodID', $item['MethodID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_METHOD')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('MethodID', $checkitem["MethodID"])->update('BS_METHOD', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('BS_METHOD', $item);
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

    public function saveShifts($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['ShiftName'])){
                $item['ShiftName'] = UNICODE.$item['ShiftName']; 
            }

            $item['YardID']     = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("ShiftID")->where('ShiftID', $item['ShiftID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_SHIFT')->row_array();
                if(count($checkitem) > 0){
                    $this->ceh->where('ShiftID', $checkitem["ShiftID"])->update('BS_SHIFT', $item);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('BS_SHIFT', $item);
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

    public function savePaymentType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['PaymentTypeName'])){
                $item['PaymentTypeName'] = UNICODE.$item['PaymentTypeName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("PaymentTypeID")->where('PaymentTypeID', $item['PaymentTypeID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_INV_PAYMENT_TYPE')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('PaymentTypeID', $checkitem["PaymentTypeID"])->update('BS_INV_PAYMENT_TYPE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_INV_PAYMENT_TYPE', $item);
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

    public function savePayForm($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['PayFormName'])){
                $item['PayFormName'] = UNICODE.$item['PayFormName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("PaymentTypeID, PayFormID")
                                        ->where('PaymentTypeID', $item['PaymentTypeID'])
                                        ->where('PayFormID', $item['PayFormID'])
                                        ->where('YardID', $item['YardID'])
                                        ->limit(1)->get('BS_INV_PAY_FORM')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('PaymentTypeID', $checkitem['PaymentTypeID'])
                            ->where('PayFormID', $checkitem['PayFormID'])
                            ->update('BS_INV_PAY_FORM', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_INV_PAY_FORM', $item);
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

    public function saveRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("RateID")->where('RateID', $item['RateID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_INV_RATE')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('RateID', $checkitem["RateID"])->update('BS_INV_RATE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_INV_RATE', $item);
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

    public function saveTransit($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['TransitName'])){
                $item['TransitName'] = UNICODE.$item['TransitName']; 
            }


            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("TransitID")->where('TransitID', $item['TransitID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_TRANSIT')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('TransitID', $checkitem["TransitID"])->update('BS_TRANSIT', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_TRANSIT', $item);
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

    public function saveArea($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['AreaName'])){
                $item['AreaName'] = UNICODE.$item['AreaName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("Area")->where('Area', $item['Area'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('BS_YP_AREA')->row_array();

            if (count($checkitem) > 0){
               return FALSE;
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_YP_AREA', $item);
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

    public function updateArea($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['AreaName'])){
                $item['AreaName'] = UNICODE.$item['AreaName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("rowguid")->where('rowguid', $item['rowguid'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_YP_AREA')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('rowguid', $checkitem["rowguid"])->update('BS_YP_AREA', $item);
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

        return $result;
    }

    // Delete info in customer table
    public function deleteCustomers($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            /*
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('', $item)
                                                        ->get('')->row_array();
            if ($checkInv['COUNTEXIST'] == 0) {
            */
            $this->ceh->where('CusID', $item)->delete('BS_CUSTOMER');      
            array_push($result['success'], 'Xóa thành công:'.$item);
            /*}else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh khách hàng:'.$item);                
            } */
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

    // Delete info in port table
    public function deletePort($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('POL', $item)
                                    ->or_where('POD', $item)
                                    ->or_where('FPOD', $item)
                                    ->get("DT_MANIFEST")->row_array();

            if ($checkExistManifest['countExist'] == 0){
                $this->ceh->where('PortID', $item)->delete('BS_PORT');
                array_push($result['success'], 'Xóa thành công Mã cảng: '.$item);
            }
            else{
                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã cảng: '.$item);
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
            return $result;
        }
    }

    // Delete info in job mode table
    public function deleteJobModes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();
        
        foreach ($datas as $item) {
            $checkExistService = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('JobModeID', $item)
                                    ->get("BS_SERVICE")->row_array();

            $checkExistMethod = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('JobModeID', $item)
                                    ->get("BS_METHOD")->row_array();

            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('JobModeID', $item)
                                    ->get("DT_MANIFEST")->row_array(); 


            if ($checkExistService['countExist']    == 0 && 
                $checkExistMethod['countExist']     == 0 && 
                $checkExistManifest['countExist']   == 0)
            {
                $this->ceh->where('JobModeID', $item)->delete('BS_JOB_MODE');
                array_push($result['success'], 'Xóa thành công Mã phương án: '.$item);
            }
            else{
                if ($checkExistService['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Dịch vụ với Mã phương án: '.$item);
                }

                if ($checkExistMethod['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Phương thức với Mã phương án: '.$item);
                } 

                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã phương án: '.$item);
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
            return $result;
        }
    }

    // Delete info in Service table
    public function deleteServices($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('ServiceID', $item)->delete('BS_SERVICE');      
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

    
    // Delete info in Job type table
    public function deleteJobTypes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('JobTypeID', $item)->delete('BS_JOB_TYPE');      
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

    // Delete info in Job type table
    public function deleteMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('MethodID', $item)
                                    ->get("DT_MANIFEST")->row_array();

            if ($checkExistManifest['countExist'] == 0){
                $this->ceh->where('MethodID', $item)->delete('BS_METHOD');
                array_push($result['success'], 'Xóa thành công Mã loại khách hàng: '.$item);
            }
            else{
                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã phương thức: '.$item);
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
            return $result;
        }
    }   
    
    // Delete info in shift table
    public function deleteShifts($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('ShiftID', $item)->delete('BS_SHIFT');      
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

    // Delete info in Transit table
    public function deleteTransit($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistJobModes = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('TransitID', $item)
                                    ->get("BS_JOB_MODE")->row_array();

            $checkExistStock = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('TransitID', $item)
                                    ->get("DT_STOCK")->row_array();     

            $checkExistTRFStandard = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('TransitID', $item)
                                    ->get("TRF_STANDARD")->row_array(); 

            $checkExistTRFDiscount = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('TransitID', $item)
                                    ->get("TRF_DISCOUNT")->row_array();                    

            if ($checkExistJobModes['countExist'] == 0 &&
                $checkExistTRFStandard['countExist'] == 0 &&
                $checkExistTRFDiscount['countExist'] == 0 &&
                $checkExistStock['countExist'] == 0)
            {
                $this->ceh->where('TransitID', $item)->delete('BS_TRANSIT');   
                array_push($result['success'], 'Xóa thành công Mã loại hình vận chuyển: '.$item);
            }
            else{
                if ($checkExistJobModes['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Phương án với Mã loại hình vận chuyển: '.$item);
                }    

                if ($checkExistStock['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Stock với Mã loại hình vận chuyển: '.$item);
                }  

                if ($checkExistTRFStandard['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Biểu cước chuẩn với Mã loại hình vận chuyển: '.$item);
                }  

                if ($checkExistTRFDiscount['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Hợp đồng (theo khách hàng) với Mã loại hình vận chuyển: '.$item);
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
            return $result;
        }
    }

     // Delete info in Area table
    public function deleteArea($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item){
            $this->ceh->where('Area', $item)->delete('BS_YP_AREA');      
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

    // payment method save data function
    public function savePaymentMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $existItem = array();

            if(isset($item['ACC_NO'])){
                $item['ACC_NO'] = UNICODE.$item['ACC_NO'];
            }

            if(isset($item['ACC_NAME'])){
                $item['ACC_NAME'] = UNICODE.$item['ACC_NAME'];
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkitem = $this->ceh->select("rowguid")
                                    ->where('ACC_CD', $item['ACC_CD'])
                                    ->limit(1)
                                    ->get('ACCOUNTS')->result_array();
            if(count($checkitem) > 0){
                $this->ceh->where('rowguid', $checkitem["rowguid"])->update('ACCOUNTS', $checkitem);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('ACCOUNTS', $item);
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

    /* Nation Table */
    public function saveNation($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['NationName'])){
                $item['NationName'] = UNICODE.$item['NationName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("NationID")->where('NationID', $item['NationID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_NATIONAL')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('NationID', $checkitem["NationID"])->update('BS_NATIONAL', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_NATIONAL', $item);
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

    public function deleteNation($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistPort = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('NationID', $item)
                                    ->get("BS_PORT")->row_array();

            if ($checkExistPort['countExist'] == 0){
                $this->ceh->where('PortID', $item)->delete('BS_PORT');
                array_push($result['success'], 'Xóa thành công Mã quốc gia: '.$item);
            }
            else{
                if ($checkExistPort['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh cảng với Mã quốc gia: '.$item);
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
            return $result;
        }
    }

    /* Opr Table */
    public function saveOpr($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['OprName'])){
                $item['OprName'] = UNICODE.$item['OprName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("OprID")->where('OprID', $item['OprID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_OPR')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('OprID', $checkitem["OprID"])->update('BS_OPR', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_OPR', $item);
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

    public function deleteOpr($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('OprID', $item)->delete('BS_OPR');      
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

    /* Gate Table */
    public function saveGate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['GateName'])){
                $item['GateName'] = UNICODE.$item['GateName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("GateID")->where('GateID', $item['GateID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_GATE')->row_array();
            if (count($checkitem) > 0){
               /* Do nothing */
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_GATE', $item);
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
    public function updateGate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, GateID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_GATE')->row_array();

            if(count($checkItem) > 0){
                if ($item['GateID'] == $checkItem['GateID']){ // Update cols except GateID
                    if(isset($item['GateName'])){
                        $item['GateName'] = UNICODE.$item['GateName']; 
                    }

                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_GATE', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');         
                }
                else{
                    $checkExistGateID = $this->ceh->select('GateID')
                                                    ->where('GateID', $item['GateID'])
                                                    ->get('BS_GATE')->row_array();
                    if (count($checkExistGateID) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - trùng Mã cổng: '.$item['GateID'].$checkItem['rowguid']);
                    }
                    else{
                        if(isset($item['GateName'])){
                            $item['GateName'] = UNICODE.$item['GateName']; 
                        }

                        $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_GATE', $item);                    
                        array_push($result['success'], 'Chỉnh sửa thành công!');
                    }
                }
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
            return $result;
        }  
    }

    public function deleteGate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('GateID', $item)->delete('BS_GATE');      
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

    /* Lane Table */
    public function saveLane($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {

            if(isset($item['LaneName'])){
                $item['LaneName'] = UNICODE.$item['LaneName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("LaneID, OprID")->where('LaneID', $item['LaneID'])
                                                     ->where('OprID', $item['OprID'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_LANE')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('LaneID', $checkitem["LaneID"])->where('OprID', $checkitem['OprID'])->update('BS_LANE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_LANE', $item);
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

    public function saveLaneDetail($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("LaneID, PortSeq")
                                                    ->where('LaneID', $item['LaneID'])
                                                    ->where('PortSeq', $item['PortSeq'])
                                                    ->where('YardID', $item['YardID'])
                                                    ->limit(1)->get('BS_LANE_DETAILS')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('LaneID', $checkitem['LaneID'])
                         ->where('PortSeq', $checkitem['PortSeq'])
                         ->update('BS_LANE_DETAILS', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_LANE_DETAILS', $item);
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

    public function deleteLaneDetails($datas, $datas2, $LaneID){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('LaneID', $LaneID)
                        ->where('PortSeq', $item)
                        ->delete('BS_LANE_DETAILS');      

            $this->ceh->where('LaneID', $LaneID)
                      ->where('PortSeq > ', $item)                      
                      ->set('PortSeq', 'PortSeq - 1', false)
                      ->update('BS_LANE_DETAILS');

            array_push($result['success'], 'Xóa thành công:'.$item);
        }

        foreach ($datas2 as $item){
            $this->ceh->where('LaneID', $LaneID)
                        ->where('OprID', $item)
                        ->delete('BS_LANE');   
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

    public function deleteLaneDetailsByOpr($datas, $LaneID){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('LaneID', $LaneID)
                        ->where('OprID', $item)
                        ->delete('BS_LANE_DETAILS');      

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
    // payment method delete function
    public function deletePaymentMethod($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                        ->limit(1)
                                                        ->where('ACC_CD', $item)
                                                        ->get('INV_VAT')->row_array();
            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('ACC_CD', $item)
                            ->delete('ACCOUNTS');

                array_push($result['success'], 'Xóa thành công:'.$item);
            }else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh hóa đơn:'.$item);
            }
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
    
    /* Delete info in Payment Type table */
    public function deletePaymentType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('PaymentTypeID', $item)
                                    ->get("BS_INV_PAY_FORM")->row_array();

            if ($checkExist['countExist'] == 0){
                $this->ceh->where('PaymentTypeID', $item)->delete('BS_INV_PAYMENT_TYPE');
                array_push($result['success'], 'Xóa thành công Loại hình thanh toán: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh Hình thức thanh toán với Mã loại hình thanh toán: '.$item);
            }               
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

    /* Delete info in Pay Fomr table */
    public function deletePayForm($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('PayFormID', $item)->delete('BS_INV_PAY_FORM');      
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

    /* Delete info in Rate table */
    public function deleteRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('RateID', $item)->delete('BS_INV_RATE');      
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

    /* Customer Type */
    public function saveCustomerType($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['CusTypeName'])){
                $item['CusTypeName'] = UNICODE.$item['CusTypeName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("CusTypeID")->where('CusTypeID', $item['CusTypeID'])
                                                        ->limit(1)
                                                        ->get('BS_CUSTOMER_TYPE')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }
                else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_CUSTOMER_TYPE', $item);
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

    public function updateCustomerType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, CusTypeID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_CUSTOMER_TYPE')->row_array();

            if(count($checkItem) > 0){
                $checkExistCustomer   = $this->ceh->where('CusTypeID', $checkItem['CusTypeID'])
                                                ->limit(1)
                                                ->get('BS_CUSTOMER')
                                                ->row_array();

                if ((count($checkExistCustomer)   == 0) || ($item['CusTypeID'] == $checkItem['CusTypeID']))
                {
                    if(isset($item['CusTypeName'])){
                        $item['CusTypeName'] = UNICODE.$item['CusTypeName']; 
                    }
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_CUSTOMER_TYPE', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{ 
                    if (count($checkExistCustomer) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Khách hàng với Mã loại khách hàng: '.$checkItem['CusTypeID'].$item['rowguid']);
                    }
                }              
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
            return $result;
        }
    }

    public function deleteCustomerType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('CusTypeID', $item)
                                    ->get("BS_CUSTOMER")->row_array();
            if ($checkExist['countExist'] == 0){
                $this->ceh->where('CusTypeID', $item)->delete('BS_CUSTOMER_TYPE');
                array_push($result['success'], 'Xóa thành công Mã loại khách hàng: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh khách hàng với mã loại: '.$item);
            }               
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

     /* Damaged Type */
    public function saveDamagedType($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['DamagedTypeName']))
                $item['DamagedTypeName'] = UNICODE.$item['DamagedTypeName'];            

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("DamagedTypeID")
                                    ->where('DamagedTypeID', $item['DamagedTypeID'])
                                    ->limit(1)
                                    ->get('BS_DAMAGED_TYPE')
                                    ->row_array();

            if(count($checkItem) > 0){
                /* Do nothing */
            }else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_DAMAGED_TYPE', $item);
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

    public function updateDamagedType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, DamagedTypeID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_DAMAGED_TYPE')->row_array();

            if(count($checkItem) > 0){
                $checkExistDamaged   = $this->ceh->where('DamagedTypeID', $checkItem['DamagedTypeID'])
                                                ->limit(1)
                                                ->get('BS_DAMAGED')
                                                ->row_array();

                if ((count($checkExistDamaged)   == 0) || ($item['DamagedTypeID'] == $checkItem['DamagedTypeID']))
                {
                    if(isset($item['DamagedTypeName'])){
                        $item['DamagedTypeName'] = UNICODE.$item['DamagedTypeName']; 
                    }
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_DAMAGED_TYPE', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{ 
                    if (count($checkExistDamaged) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Hư hỏng với Mã loại hư hỏng: '.$checkItem['DamagedTypeID'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }
    }

    public function deleteDamagedType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('DamagedTypeID', $item)
                                    ->get("BS_DAMAGED")->row_array();
            if ($checkExist['countExist'] == 0){
                $this->ceh->where('DamagedTypeID', $item)->delete('BS_DAMAGED_TYPE');
                array_push($result['success'], 'Xóa thành công Mã loại hư hỏng: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh hư hỏng với mã loại: '.$item);
            }               
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

    /* Damaged */
    public function saveDamaged($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['DamagedName']))
                $item['DamagedName'] = UNICODE.$item['DamagedName'];

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("DamagedID")->where('DamagedID', $item['DamagedID'])
                                                        ->limit(1)
                                                        ->get('BS_DAMAGED')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_DAMAGED', $item);
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

     public function updateDamaged($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, DamagedID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_DAMAGED')->row_array();

            if (count($checkItem) > 0){
                if (isset($item['DamagedName']))
                    $item['DamagedName'] = UNICODE.$item['DamagedName'];

                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_DAMAGED', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
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
            return $result;
        }
    }

    public function deleteDamaged($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('DamagedID', $item)->delete('BS_DAMAGED');
            array_push($result['success'], 'Xóa thành công Mã nguy hiểm: '.$item);
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

    /* Berth */
    public function saveBerth($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("BerthID")->where('BerthID', $item['BerthID'])
                                                      ->limit(1)
                                                      ->get('BS_BERTH')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_BERTH', $item);
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

    public function updateBerth($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, BerthID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_BERTH')->row_array();

            if(count($checkItem) > 0){
                $checkExistBerthID = $this->ceh->where('BerthID', $checkItem['BerthID'])
                                                ->limit(1)
                                                ->get('BS_BITT')->row_array();

                if ((count($checkExistBerthID) == 0) || ($item['BerthID'] == $checkItem['BerthID'])){                    
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_BERTH', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{
                    array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Bitt với Mã bến: '.$checkItem['BerthID'].$checkItem['rowguid']);
                }              
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
            return $result;
        }        
    }

    public function deleteBerth($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('BerthID', $item)
                                    ->get("BS_BITT")->row_array();
            if ($checkExist['countExist'] == 0){
                $this->ceh->where('BerthID', $item)->delete('BS_BERTH');
                array_push($result['success'], 'Xóa thành công Mã bến: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh Bitt với Mã bến: '.$item);
            }               
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

    /* Bitt */    
    public function saveBitt($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("BittID")->where('BittID', $item['BittID'])
                                                      ->limit(1)
                                                      ->get('BS_BITT')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_BITT', $item);
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

    public function updateBitt($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, BittID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_BITT')->row_array();

            if(count($checkItem) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_BITT', $item);                    
                array_push($result['success'], 'Chỉnh sửa thành công!');            
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
            return $result;
        }        
    }

    public function deleteBitt($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('BittID', $item)->delete('BS_BITT');
            array_push($result['success'], 'Xóa thành công Mã bitt: '.$item);
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

    /* Car Brand*/
    public function saveCarBrand($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['BrandName'])){
                $item['BrandName'] = UNICODE.$item['BrandName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("BrandID")->where('BrandID', $item['BrandID'])
                                                      ->limit(1)
                                                      ->get('BS_CAR_BRAND')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_CAR_BRAND', $item);
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

    public function updateCarBrand($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, BrandID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_CAR_BRAND')->row_array();

            if(count($checkItem) > 0){
                $checkExistInvRate  = $this->ceh->where('BrandID', $checkItem['BrandID'])
                                                ->limit(1)
                                                ->get('BS_INV_RATE')->row_array();

                $checkExistCarType  = $this->ceh->where('BrandID', $checkItem['BrandID'])
                                                ->limit(1)
                                                ->get('BS_CAR_TYPE')->row_array();

                $checkExistManifest = $this->ceh->where('BrandID', $checkItem['BrandID'])
                                                ->limit(1)
                                                ->get('DT_MANIFEST')->row_array();

                if ((count($checkExistInvRate)   == 0 &&
                    count($checkExistCarType)   == 0 &&
                    count($checkExistManifest)  == 0) ||
                    ($item['BrandID'] == $checkItem['BrandID']))
                {   
                    if(isset($item['BrandName'])){
                        $item['BrandName'] = UNICODE.$item['BrandName']; 
                    }

                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_CAR_BRAND', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{
                    if (count($checkExistInvRate) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Tỷ giá với Mã hãng xe: '.$checkItem['BrandID'].$checkItem['rowguid']);
                    }

                    if (count($checkExistCarType) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Loại xe với Mã hãng xe: '.$checkItem['BrandID'].$checkItem['rowguid']);
                    }
                    
                    if (count($checkExistManifest) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh dữ liệu Manifest với Mã hãng xe: '.$checkItem['BrandID'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }        
    }

    public function deleteCarBrand($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistRate = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('BrandID', $item)
                                    ->get("BS_INV_RATE")->row_array();

            $checkExistCarType = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('BrandID', $item)
                                    ->get("BS_CAR_TYPE")->row_array();

            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('BrandID', $item)
                                    ->get("DT_MANIFEST")->row_array();

            if ($checkExistRate['countExist'] == 0 && $checkExistCarType['countExist'] == 0){
                $this->ceh->where('BrandID', $item)->delete('BS_CAR_BRAND');
                array_push($result['success'], 'Xóa thành công Mã hãng: '.$item);
            }
            else{
                if ($checkExistRate['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Tỷ giá với Mã hãng: '.$item);
                }
                
                if ($checkExistCarType['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Loại xe với Mã hãng: '.$item);
                }
                
                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã phương thức: '.$item);
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
            return $result;
        }
    }

    /* Car Type */
    public function saveCarType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['CarTypeName'])){
                $item['CarTypeName'] = UNICODE.$item['CarTypeName']; 
            }

            if(isset($item['EngineType'])){
                $item['EngineType'] = UNICODE.$item['EngineType']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("CarTypeID")->where('CarTypeID', $item['CarTypeID'])
                                                      ->limit(1)
                                                      ->get('BS_CAR_TYPE')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_CAR_TYPE', $item);
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

    public function updateCarType($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, CarTypeID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_CAR_TYPE')->row_array();

            if(count($checkItem) > 0){
                $checkExistManifest = $this->ceh->where('CarTypeID', $checkItem['CarTypeID'])
                                                ->limit(1)
                                                ->get('DT_MANIFEST')->row_array();

                if ((count($checkExistManifest)   == 0) || ($item['CarTypeID'] == $checkItem['CarTypeID']))
                {
                    if(isset($item['CarTypeName'])){
                        $item['CarTypeName'] = UNICODE.$item['CarTypeName']; 
                    }
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_CAR_TYPE', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{                    
                    if (count($checkExistManifest) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh dữ liệu Manifest với Mã loại xe: '.$checkItem['CarTypeID'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }        
    }

    public function deleteCarType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('CarTypeID', $item)
                                    ->get("DT_MANIFEST")->row_array();


            if ($checkExistManifest['countExist'] == 0){
                $this->ceh->where('CarTypeID', $item)->delete('BS_CAR_TYPE');
                array_push($result['success'], 'Xóa thành công Mã loại xe: '.$item);
            }
            else{
                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã loại xe: '.$item);
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
            return $result;
        }
    }

    /* Color */    
    public function saveColor($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("VesselID, BrandID, CarTypeID")->where('VesselID', $item['VesselID'])
                                                                        ->where('VesselID', $item['VesselID'])
                                                                        ->where('CarTypeID', $item['CarTypeID'])
                                                                        ->limit(1)
                                                                        ->get('BS_YP_COLOR')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('BittID', $checkItem["BittID"])
                            ->where('VesselID', $item['VesselID'])
                            ->where('CarTypeID', $item['CarTypeID'])
                            ->update('BS_YP_COLOR', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_YP_COLOR', $item);
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

    public function deleteColor($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh
                ->where('VesselID', $item['VesselID'])
                ->where('BrandID', $item['BrandID'])
                ->where('CarTypeID', $item['CarTypeID'])
                ->delete('BS_YP_COLOR');
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

    /* Worker Group Type */
    public function saveWorkerGroupType($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['WorkerGroupTypeName'])){
                $item['WorkerGroupTypeName'] = UNICODE.$item['WorkerGroupTypeName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("WorkerGroupType")->where('WorkerGroupType', $item['WorkerGroupType'])
                                                      ->limit(1)
                                                      ->get('BS_WORKER_GROUP_TYPE')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('WorkerGroupType', $checkItem["WorkerGroupType"])->update('BS_WORKER_GROUP_TYPE', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_WORKER_GROUP_TYPE', $item);
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

    public function deleteWorkerGroupType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('WorkerGroupType', $item)
                                    ->get("BS_WORKER_GROUP")->row_array();
            if ($checkExist['countExist'] == 0){
                $this->ceh->where('WorkerGroupType', $item)->delete('BS_WORKER_GROUP_TYPE');
                array_push($result['success'], 'Xóa thành công Mã loại tổ đội công nhân: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh Tổ đội công nhân với Mã loại tổ đội công nhân: '.$item);
            }               
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

    /* Worker Group */
    public function saveWorkerGroup($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['WorkerGroupName'])){
                $item['WorkerGroupName'] = UNICODE.$item['WorkerGroupName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select('WorkerGroupID')->where('WorkerGroupID', $item['WorkerGroupID'])
                                                      ->limit(1)
                                                      ->get('BS_WORKER_GROUP')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('WorkerGroupID', $checkItem['WorkerGroupID'])->update('BS_WORKER_GROUP', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_WORKER_GROUP', $item);
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

    public function deleteWorkerGroup($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('WorkerGroupID', $item)->delete('BS_WORKER_GROUP');
            array_push($result['success'], 'Xóa thành công Mã tổ đội công nhân: '.$item);
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

    //save unit_codes
    public function saveUnitCode($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['UnitName']))
                $item['UnitName'] = UNICODE.$item['UnitName'];

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->select("UnitID")->where('UnitID', $item['UnitID'])
                                                        ->limit(1)
                                                        ->get('BS_UNIT')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('UnitID', $checkItem["UnitID"])->update('BS_UNIT', $item);
            }else{
                //insert database

                //$item['YardID'] = $item['YardID'];

                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_UNIT', $item);
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

    // Delete unit codes
    public function deleteUnitCode($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('UnitID', $item)->delete('BS_UNIT');
            array_push($result['success'], 'Xóa thành công mã ĐVT: '.$item);
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

    /* Class */
    public function saveClass($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['ClassName'])){
                $item['ClassName'] = UNICODE.$item['ClassName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("ClassID")->where('ClassID', $item['ClassID'])
                                                        ->limit(1)
                                                        ->get('BS_CLASS')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }
                else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_CLASS', $item);
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

    public function updateClass($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, ClassID")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_CLASS')->row_array();

            if(count($checkItem) > 0){
                $checkExistJobMob   = $this->ceh->where('ClassID', $checkItem['ClassID'])
                                                ->limit(1)
                                                ->get('BS_JOB_MODE')
                                                ->row_array();

                $checkExistGate     = $this->ceh->where('ClassID', $checkItem['ClassID'])
                                                ->limit(1)
                                                ->get('BS_GATE')
                                                ->row_array();

                $checkExistManifest = $this->ceh->where('ClassID', $checkItem['ClassID'])
                                                ->limit(1)
                                                ->get('DT_MANIFEST')
                                                ->row_array();

                if ((count($checkExistJobMob)   == 0 &&
                     count($checkExistGate)     == 0 &&
                     count($checkExistManifest) == 0)|| 
                    ($item['ClassID'] == $checkItem['ClassID']))
                {
                    if(isset($item['ClassName'])){
                        $item['ClassName'] = UNICODE.$item['ClassName']; 
                    }
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_CLASS', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{ 
                    if (count($checkExistJobMob) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Phương án với Mã hướng nhập xuất: '.$checkItem['ClassID'].$checkItem['rowguid']);
                    }

                    if (count($checkExistGate) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Cổng với Mã hướng nhập xuất: '.$checkItem['ClassID'].$checkItem['rowguid']);
                    }

                    if (count($checkExistManifest) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh dữ liệu Manifest với Mã hướng nhập xuất: '.$checkItem['ClassID'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }        
    }

    public function deleteClass($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistGate = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('ClassID', $item)
                                    ->get("BS_GATE")->row_array();

            $checkExistJobModes = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('ClassID', $item)
                                    ->get("BS_JOB_MODE")->row_array();

            $checkExistManifest = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('ClassID', $item)
                                    ->get("DT_MANIFEST")->row_array();

            if ($checkExistGate['countExist'] == 0 && $checkExistJobModes['countExist'] == 0){
                $this->ceh->where('ClassID', $item)->delete('BS_CLASS');
                array_push($result['success'], 'Xóa thành công Mã hướng nhập xuất: '.$item);
            }
            else{
                if ($checkExistGate['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Cổng với Mã hướng nhập xuất: '.$item);
                }

                if ($checkExistJobModes['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh Phương án với Mã hướng nhập xuất: '.$item);
                }

                if ($checkExistManifest['countExist'] != 0){
                    array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Manifest với Mã phương thức: '.$item);
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
            return $result;
        }
    }

    /* Yard */
    public function saveYard($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['YardName']))
                $item['YardName'] = UNICODE.$item['YardName'];

            if(isset($item['Address']))
                $item['Address'] = UNICODE.$item['Address'];

            if(isset($item['CustomsName']))
                $item['CustomsName'] = UNICODE.$item['CustomsName'];

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->select("YardID")->where('YardID', $item['YardID'])
                                                        ->limit(1)
                                                        ->get('BS_YARD')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('YardID', $checkItem["YardID"])->update('BS_YARD', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_YARD', $item);
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

    public function deleteYard($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item)->delete('BS_YARD');
            array_push($result['success'], 'Xóa thành công hướng nhập xuất: '.$item);
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

    /* Block */
    public function saveBlock($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->where('YardID', $item['YardID'])
                                    ->where('MaxBay', $item['MaxBay'])
                                    ->where('MaxRow', $item['MaxRow'])
                                    ->where('MaxTier', $item['MaxTier'])
                                    ->limit(1)
                                    ->get('BS_YP_BLOCK')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('YardID', $checkItem["YardID"])
                            ->where('MaxBay', $checkItem['MaxBay'])
                            ->where('MaxRow', $checkItem['MaxRow'])
                            ->where('MaxTier', $checkItem['MaxTier'])->update('BS_YP_BLOCK', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_YP_BLOCK', $item);
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

    public function deleteBlock($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('YardID', $item['YardID'])
                ->where('Block', $item['Block'])
                ->where('MaxBay', $item['MaxBay'])
                ->where('MaxRow', $item['MaxRow'])
                ->where('MaxTier', $item['MaxTier'])
                ->delete('BS_YP_BLOCK');
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

    /* Inv Prefix */
    public function savePrefix($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['YardID'] = $this->session->userdata("YardID");

            $checkItem = $this->ceh->where('InvPrefixID', $item['InvPrefixID'])
                                    ->limit(1)
                                    ->get('BS_INV_PREFIX')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('InvPrefixID', $checkItem["InvPrefixID"])->update('BS_INV_PREFIX', $item);
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_INV_PREFIX', $item);
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

    public function deletePrefix($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('InvPrefixID', $item)->delete('BS_INV_PREFIX');
            array_push($result['success'], 'Xóa thành công hướng nhập xuất: '.$item);
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
    //save exchange rate
    public function saveExchangeRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['DATEOFRATE'])){
                $item['DATEOFRATE'] = $this->funcs->dbDateTime($item['DATEOFRATE']);
            }

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid")
                                                    ->where('CURRENCYID', $item['CURRENCYID'])
                                                    ->limit(1)
                                                    ->get('EXCHANGE_RATE')->row_array();

            if(count($checkItem) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('EXCHANGE_RATE', $item);
            }else{
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['insert_time'] = $item['update_time'];
                $this->ceh->insert('EXCHANGE_RATE', $item);
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
    } // ------------end exchange rate save data function

    // delete exchange rate
    public function deleteExchangeRate($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkInv = $this->ceh->select('COUNT(rowguid) AS COUNTEXIST')
                                                    ->limit(1)
                                                    ->where('CURRENCYID', $item)
                                                    ->get('INV_DFT')->row_array();

            if ($checkInv['COUNTEXIST'] == 0) {
                $this->ceh->where('CURRENCYID', $item)
                            ->delete('EXCHANGE_RATE');

                array_push($result['success'], 'Xóa thành công: '.$item);
            }else{
                array_push($result['error'], "Không thể xóa - [$item] đã phát sinh tính cước!");
            }
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

    public function saveServiceAddon($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item["SRM_NO"] = $item["ORD_TYPE"]."_".$item["CjMode_CD"];

            if($item["IsChecked"] == "1"){

                $item['YardID'] = $this->YardID;

                $item['ModifiedBy'] = $this->session->userdata("UserID");
                $item['update_time'] = date('Y-m-d H:i:s');

                $checkItem = $this->ceh->select("rowguid")->where("ORD_TYPE", $item["ORD_TYPE"])
                                                            ->where("CjMode_CD", $item["CjMode_CD"])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)
                                                            ->get("SRVMORE")->row_array();
                if(count($checkItem) > 0){
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update("SRVMORE", array("chkPrint" => $item["chkPrint"]));
                }else{
                    unset($item["IsChecked"]);
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $item['insert_time'] = $item['update_time'];
                    $this->ceh->insert('SRVMORE', $item);
                }
            }else{
                $this->ceh->where("ORD_TYPE", $item["ORD_TYPE"])
                            ->where("CjMode_CD", $item["CjMode_CD"])
                            ->where('YardID', $this->YardID)
                            ->delete("SRVMORE");
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

    public function saveTRFTempConfig($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item["ORD_TPLT_NO"] = $item["ORD_TYPE"]."_".$item["TPLT_NM"];

            if($item["IsChecked"] == "1"){

                $item['YardID'] = $this->YardID;

                $item['ModifiedBy'] = $this->session->userdata("UserID");
                $item['update_time'] = date('Y-m-d H:i:s');

                $checkItem = $this->ceh->select("rowguid")->where("ORD_TYPE", $item["ORD_TYPE"])
                                                            ->where("TPLT_NM", $item["TPLT_NM"])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)
                                                            ->get("ORD_TPLT")->row_array();

                if(count($checkItem) == 0){
                    unset($item["IsChecked"]);
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'] = $this->session->userdata("UserID");
                    $item['insert_time'] = $item['update_time'] = date('Y-m-d H:i:s');
                    $this->ceh->insert('ORD_TPLT', $item);
                }
            }else{
                $this->ceh->where("ORD_TYPE", $item["ORD_TYPE"])
                            ->where("TPLT_NM", $item["TPLT_NM"])
                            ->where('YardID', $this->YardID)
                            ->delete("ORD_TPLT");
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

    public function LoadVesselListFromManifestForColorScreen(){
        $this->ceh->select('VesselID, VesselName, A.BrandID as BrandID, BrandName, A.CarTypeID as CarTypeID, CarTypeName, A.EngineType as EngineType, POL, D.PortName as POLName, POD, E.PortName as PODName, FPOD, E.PortName as FPODName, A.Remark as Remark');

        $this->ceh->join('DT_VESSEL_VISIT B', 'A.VoyageKey = B.VoyageKey');
        $this->ceh->join('BS_CAR_BRAND C', 'A.BrandID = C.BrandID');
        $this->ceh->join('BS_PORT D', 'POL = D.PortID');
        $this->ceh->join('BS_PORT E', 'POD = E.PortID');
        $this->ceh->join('BS_PORT F', 'FPOD = F.PortID');
        $this->ceh->join('BS_CAR_TYPE G', 'A.CarTypeID = G.CarTypeID');

        $this->ceh->order_by('VesselID', 'ASC'); 
        $stmt = $this->ceh->get('DT_MANIFEST A');
        return $stmt->result_array(); 
    }

    public function loadAllColColor(){
        $this->ceh->select('A.VesselID as VesselID, VesselName, A.BrandID as BrandID, BrandName, A.CarTypeID as CarTypeID, CarTypeName, A.EngineType as EngineType, POL, E.PortName as POLName, POD, F.PortName as PODName, FPOD, G.PortName as FPODName, BackColor, ForeColor, A.Remark as Remark');

        $this->ceh->join("DT_VESSEL_VISIT B", 'A.VesselID = B.VesselID');
        $this->ceh->join("BS_CAR_BRAND C", 'A.BrandID = C.BrandID');
        $this->ceh->join("BS_CAR_TYPE D", 'A.CarTypeID = D.CarTypeID');
        $this->ceh->join("BS_PORT E", 'POL = E.PortID');
        $this->ceh->join("BS_PORT F", 'POD = F.PortID');
        $this->ceh->join("BS_PORT G", 'FPOD = G.PortID');

        $stmt = $this->ceh->get('BS_YP_COLOR A');
        return $stmt->result_array(); 
    }

    public function loadAllColClass(){
        $this->ceh->select('ClassID, ClassName, rowguid');
        $this->ceh->order_by('ClassID', 'ASC');
        $stmt = $this->ceh->get('BS_CLASS A');
        return $stmt->result_array();
    }

    public function loadAllColYard(){
        $this->ceh->order_by('YardID', 'ASC');
        $stmt = $this->ceh->get('BS_YARD');
        return $stmt->result_array();
    }

    public function loadAllColPrefix(){
        $this->ceh->order_by('PackageID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_PREFIX');
        return $stmt->result_array();
    }


    public function loadBlockByYardID($YardID = ''){
        $this->ceh->select('YardID, Block, MaxBay, MaxRow, MaxTier, Capacity');

        if ($YardID != '')
            $this->ceh->where('YardID', $YardID);

        $this->ceh->order_by('YardID', 'ASC');
        $stmt = $this->ceh->get('BS_YP_BLOCK');
        return $stmt->result_array();
    }

    /* VM Status */
    public function loadVMStatusList(){
        $this->ceh->select('VMStatus, VMStatusDesc, rowguid');
        $this->ceh->order_by('VMStatus', 'ASC'); 
        $stmt = $this->ceh->get('BS_VMSTATUS');
        return $stmt->result_array();
    }


    public function saveVMStatus($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['VMStatusDesc'])){
                $item['VMStatusDesc'] = UNICODE.$item['VMStatusDesc'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("VMStatus")->where('VMStatus', $item['VMStatus'])
                                                        ->limit(1)
                                                        ->get('BS_VMSTATUS')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_VMSTATUS', $item);
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

    public function updateVMStatus($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkItem = $this->ceh->select("rowguid, VMStatus")
                                    ->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('BS_VMSTATUS')->row_array();

            if(count($checkItem) > 0){
                $checkExistStock   = $this->ceh->where('VMStatus', $checkItem['VMStatus'])
                                                ->limit(1)
                                                ->get('DT_STOCK')
                                                ->row_array();

                if ((count($checkExistStock)   == 0) || ($item['VMStatus'] == $checkItem['VMStatus']))
                {
                    if(isset($item['VMStatusDesc'])){
                        $item['VMStatusDesc'] = UNICODE.$item['VMStatusDesc']; 
                    }
                    $this->ceh->where('rowguid', $checkItem["rowguid"])->update('BS_VMSTATUS', $item);                    
                    array_push($result['success'], 'Chỉnh sửa thành công!');
                }
                else{ 
                    if (count($checkExistStock) != 0){
                        array_push($result['error'], 'Không thể chỉnh sửa - đã phát sinh Dữ liệu Biến động bãi với Mã tình trạng xe: '.$checkItem['VMStatus'].$checkItem['rowguid']);
                    }
                }              
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
            return $result;
        }
    }

    public function deleteVMStatus($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExistStock = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('VMStatus', $item)
                                    ->get("DT_STOCK")->row_array();
            if ($checkExistStock['countExist'] == 0){
                $this->ceh->where('VMStatus', $item)->delete('BS_VMSTATUS');
                array_push($result['success'], 'Xóa thành công Mã tình trạng xe: '.$item);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh dữ liệu Biến động bãi với Mã tình trạng xe: '.$item);
            }               
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

    public function loadGateList(){
        $this->ceh->order_by('GateID');
        $stmt = $this->ceh->get('BS_GATE');
        return $stmt->result_array();
    }

    public function insertScalesDataForIn($datas, $StockRef = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkSeq = $this->ceh->select('max(Sequence) as Sequence')
                                ->where('TruckNumber', $item['TruckNumber'])
                                ->where('ClassID', 1)
                                ->where('BookingNo is NULL')
                                ->limit(1)
                                ->get('JOB_QUAY')
                                ->row_array();
                                
            $sequence = -1;
            if (intval(@$checkSeq['Sequence']) > 0){
                $sequence = $checkSeq['Sequence'];
            }

            $item['Sequence'] = $sequence;
            $this->ceh->insert('BS_TRUCK_WEIGHT', $item);

            /* UPDATE STOCK IN BULK */
            $this->ceh->where('TruckNumber', $item['TruckNumber'])
                        ->where('Sequence', $item['Sequence'])
                        ->where('StockRef', $StockRef)
                        ->where('CargoWeightGetIn is NULL')
                        ->set('CargoWeightGetIn', $item['CargoWeight'])
                        ->update('DT_STOCKIN_BULK');
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

    public function insertScalesDataWithBLForIn($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['CreatedBy'] = $this->session->userdata("UserID");
            $item['ModifiedBy'] = $item['CreatedBy'];
            $item['CreateTime'] = date('Y-m-d H:i:s');
            $item['UpdateTime'] = $item['CreateTime'];

            $checkSeq = $this->ceh->select('max(Sequence) as Sequence')
                                    ->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('BillOfLading', $item['BillOfLading'])
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

            $sequence = -1;
            if (intval(@$checkSeq['Sequence']) > 0){
                $sequence = $checkSeq['Sequence'];
                $item['Sequence'] = $sequence;
                $this->ceh->insert('BS_TRUCK_WEIGHT', $item);
            }
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

    public function updateScalesDataWithBLForIn($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $checkExist = $this->ceh->where('TruckNumber', $item['TruckNumber'])
                                ->where('EirNo', $item['EirNo'])
                                ->where('Sequence', $item['Sequence'])
                                ->limit(1)
                                ->get('BS_TRUCK_WEIGHT')
                                ->row_array();

            if (count($checkExist) > 0){
                $this->ceh->where('TruckNumber', $checkExist['TruckNumber'])
                                ->where('Sequence', $checkExist['Sequence'])
                                ->where('EirNo', $checkExist['EirNo'])
                                ->set('CargoWeight', $item['CargoWeight'])
                                ->set('FirstWeightScale', $item['FirstWeightScale'])
                                ->update('BS_TRUCK_WEIGHT');
            }   
            else{
                $item['YardID'] = $this->session->userdata("YardID");
                $item['CreatedBy'] = $this->session->userdata("UserID");
                $item['ModifiedBy'] = $item['CreatedBy'];
                $item['CreateTime'] = date('Y-m-d H:i:s');
                $item['UpdateTime'] = $item['CreateTime'];
                $this->ceh->insert('BS_TRUCK_WEIGHT', $item);                
            }
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

    /*
    public function updateScalesDataForIn($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('rowguid', $item['rowguid'])
                    ->set('FirstWeightScale', $item['FirstWeightScale'])
                    ->set('CargoWeight', $item['CargoWeight'])
                    ->update('BS_TRUCK_WEIGHT');

            // Update Stock In Data 
            $checkSeq = $this->ceh->where('rowguid', $item['rowguid'])->limit(1)->get('BS_TRUCK_WEIGHT')->row_array();

            if (count($checkSeq) > 0){
                $this->ceh->where('Sequence', $checkSeq['Sequence'])
                        ->where('TruckNumber', $checkSeq['TruckNumber'])
                        ->where('EirNo is NULL')
                        ->set('CargoWeightGetIn', $item['FirstWeightScale'])
                        ->set('UnitID', 'TNE')
                        ->update("DT_STOCKIN_BULK");
            }
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
    */

    public function saveScalesDataForOut($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $eirNo = $item['EirNo'];         

            $checkExistFinishTwoScales = $this->ceh->where('TruckNumber', $item['TruckNumber'])
                                    ->where('FirstWeightScale is NOT NULL')
                                    ->where('SecondWeightScale is NOT NULL')
                                    ->limit(1)  
                                    ->get('BS_TRUCK_WEIGHT')
                                    ->row_array();

            $checkIsSecondScale = false;

            $firstWeightScale = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('FirstWeightScale is NOT NULL')
                                    ->where('SecondWeightScale is NULL')
                                    ->limit(1)  
                                    ->get('BS_TRUCK_WEIGHT')
                                    ->row_array();   
            if (count($firstWeightScale) > 0){
                $checkIsSecondScale = true;
            }

            /*
            $maxSequenceExist = $this->ceh->select('max(Sequence) as maxSequence')
                                    ->where('EirNo', $item['EirNo'])
                                    ->limit(1)
                                    ->get('BS_TRUCK_WEIGHT')
                                    ->row_array();
            */
            $gateSequence = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('FinishDate is NULL')
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

            /* Get sequence */
            if ($checkIsSecondScale){
                $sequence = $firstWeightScale['Sequence'];
            }
            else{
                $sequence = $gateSequence['Sequence'];
            }
            

            if (count($checkExistFinishTwoScales) == 0){ // Not have two scale before                
                $item['CreatedBy'] = $item['ModifiedBy'];                
                $item['Sequence'] = $sequence;

                if ($checkIsSecondScale){ // In second scale
                    $item['CargoWeight'] = $item['FirstWeightScale'] - $item['SecondWeightScale'];

                    $this->ceh->where('TruckNumber', $item['TruckNumber'])
                            ->where('EirNo', $item['EirNo'])
                            ->where('Sequence', $sequence)
                            ->update('BS_TRUCK_WEIGHT', $item);
                }
                else{ // In the first scale
                    $this->ceh->insert('BS_TRUCK_WEIGHT', $item);
                }
            }
            else{ // Have two scale before
                $item['Sequence']          = $sequence;
                $item['CargoWeight']       = $item['FirstWeightScale'] - $checkExistFinishTwoScales['SecondWeightScale'];
                $item['TruckWeight']       = $checkExistFinishTwoScales['SecondWeightScale'];
                $item['SecondWeightScale'] = $checkExistFinishTwoScales['SecondWeightScale'];
                $item['CreatedBy']         = $item['ModifiedBy'];

                $this->ceh->insert('BS_TRUCK_WEIGHT', $item);
            }

            if (isset($item['CargoWeight'])){
                /* Update data for STOCK_IN and JOB_GATE */
                $this->ceh->where('EirNo', $eirNo)
                    ->where('Sequence', $sequence)
                    ->set('CargoWeightGetIn', $item['CargoWeight'])
                    ->update('DT_STOCKIN_BULK');
                
                $this->ceh->where('EirNo', $eirNo)
                    ->where('Sequence',  $sequence)
                    ->set('CarWeight', $item['CargoWeight'])
                    ->update('JOB_GATE');
                
                /* Update JOB QUAY */
                $stockRef = $this->ceh->select('StockRef')
                    ->where('EirNo', $eirNo)
                    ->where('Sequence', $sequence)
                    ->limit(1)
                    ->get('JOB_GATE')
                    ->row_array()['StockRef'];
                
                $this->ceh->where('StockRef', $stockRef)
                    ->where('Sequence',  $sequence)
                    ->set('CarWeight', $item['CargoWeight'])
                    ->update('JOB_QUAY');   
            }
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

    public function loadTruckWeightList($YardID = ''){
        $this->ceh->select('A.rowguid as rowguid, EirNo, TruckNumber, FirstWeightScale, SecondWeightScale, A.JobModeID as JobModeID, JobModeName, Sequence, BillOfLading, BookingNo');
        $this->ceh->order_by('EirNo', 'ASC');
        $this->ceh->order_by('Sequence', 'ASC');
        $this->ceh->join('BS_JOB_MODE B', 'A.JobModeID = B.JobModeID AND (A.FirstWeightScale is NULL)', 'left');
        $stmt = $this->ceh->get('BS_TRUCK_WEIGHT A');
        return $stmt->result_array();
    }

    public function loadTruckWeightDataByTruckNumber($TruckNumber = ''){
        $this->ceh->where('TruckNumber', $TruckNumber);
        $this->ceh->where('SecondWeightScale is NOT NULL');
        $stmt = $this->ceh->get('BS_TRUCK_WEIGHT');
        return $stmt->result_array();
    }  

    public function loadCargoTypeList(){
        $this->ceh->select('CargoTypeID, CargoTypeName, rowguid');
        $stmt = $this->ceh->get('BS_CARGOTYPE');
        return $stmt->result_array();
    }

    public function saveCargoType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['CargoTypeName'])){
                $item['CargoTypeName'] = UNICODE.$item['CargoTypeName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkitem = $this->ceh->select("CargoTypeID")->where('CargoTypeID', $item['CargoTypeID'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('BS_CARGOTYPE')->row_array();

            if (count($checkitem) > 0){
               return FALSE;
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('BS_CARGOTYPE', $item);
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

    public function updateCargoType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['CarTypeName'])){
                $item['CarTypeName'] = UNICODE.$item['CarTypeName']; 
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            $checkitem = $this->ceh->select("rowguid")->where('rowguid', $item['rowguid'])
                                                            ->where('YardID', $item['YardID'])
                                                            ->limit(1)->get('BS_CARGOTYPE')->row_array();
            if (count($checkitem) > 0){
               $this->ceh->where('rowguid', $checkitem["rowguid"])->update('BS_CARGOTYPE', $item);
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

        return $result;
    }

    public function deleteCargoType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item){
            $this->ceh->where('CargoTypeID', $item)->delete('BS_CARGOTYPE');      
            array_push($result['success'], 'Xóa thành công: '.$item);
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
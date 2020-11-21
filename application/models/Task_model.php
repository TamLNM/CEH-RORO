<?php
defined('BASEPATH') OR exit('');

class task_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = "";

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
    }

    public function generatePinCode($digits = 8, $pinCodeNumeric = 1){
        $chk = array();
        $pinCodeArr = array();

        for ($i = 0; $i < $pinCodeNumeric; $i++){
            do{
                $nb = rand(1, pow(10, $digits)-1);
                $nb = 'B'.substr("0000000".$nb, -8);
                $chkEir = $this->ceh->select('COUNT(*) as CountID')
                                    ->where('PinCode', $nb)
                                    ->limit(1)
                                    ->get('ORD_EIR_BULK')->row_array();
            }while($chkEir['CountID'] > 0);
            $pinCodeArr[$i] = $nb;
        }
        
        return $pinCodeArr;
    }
    
    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'Admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function getRelocation(){
        $this->ceh->select('GNRL_CODE, GNRL_NM');
        $this->ceh->where('GNRL_TYPE', 'REP');

        $this->ceh->order_by('GNRL_NM', 'ASC');
        $stmt = $this->ceh->get('DMG_CODES');
        return $stmt->result_array();
    }

    public function getServices($colname, $value){
        $this->ceh->select('CJMode_CD, CJModeName');
        $this->ceh->where($colname, $value);

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CJMode_CD', 'ASC');
        $stmt = $this->ceh->get('DELIVERY_MODE');
        return $stmt->result_array();
    }

    public function getAttachServices($orderType){
        $this->ceh->select(" '' AS SSOderNo, sm.CJMode_CD, CJModeName, '' AS CntrNo_List, 0 AS PTI_Hour");
        $this->ceh->join('DELIVERY_MODE dm', 'sm.CJMode_CD = dm.CJMode_CD', 'left');
        $this->ceh->where('ORD_TYPE', $orderType);

        $this->ceh->where('sm.YARD_ID', $this->yard_id);

        $this->ceh->order_by('sm.CJMode_CD', 'ASC');
        $stmt = $this->ceh->get('SRVMORE sm');
        return $stmt->result_array();
    }

    public function searchShip($arrStatus = '', $year = '', $name = ''){
        $this->ceh->select('vs.ShipKey, vv.ShipName, vs.ShipID, vs.ShipYear, vs.ShipVoy, vs.ImVoy, vs.ExVoy, vs.ETB, vs.ETD, vs.BerthDate');
        $this->ceh->join('VESSELS vv', 'vv.ShipID = vs.ShipID');

        $this->ceh->where('vs.YARD_ID', $this->yard_id);

        if($arrStatus != ''){
            $this->ceh->where('vs.ShipArrStatus', $arrStatus);
        }
        if($year != ''){
            $this->ceh->where('vs.ShipYear', $year);
        }
        if($name != ''){
            $this->ceh->like('vs.ShipID', $name);
        }
        $this->ceh->order_by('vs.ETB', 'DESC');
        $stmt = $this->ceh->get('VESSEL_SCHEDULE vs');
        return $stmt->result_array();
    }

    public function generateEirNo()
    {
        $prefix_t = date('y').date('m').date('d');

        $cdb = $this->ceh->select('ISNULL(Max(EIRNo), 0) MaxEirNo')
                                        ->where('LEFT(EIRNo, 6) = ', $prefix_t)
                                        ->where('YARD_ID', $this->yard_id)
                                        ->get("EIR")->row_array();

        return ( intval( $cdb[ 'MaxEirNo' ] ) > 0 ) ? ( intval( $cdb[ 'MaxEirNo' ] ) + 1 ) : $prefix_t."0001";
    }

    public function generateSSOrderNo()
    {
        $prefix_t = date('y').date('m').date('d');

        $cdb = $this->ceh->select('ISNULL(Max(SSOderNo), 0) MaxSSOderNo')
                                        ->where('LEFT(SSOderNo, 6) = ', $prefix_t)
                                        ->where('YARD_ID', $this->yard_id)
                                        ->get("SRV_ODR")->row_array();

        return ( intval( $cdb[ 'MaxSSOderNo' ] ) > 0 ) ? ( intval( $cdb[ 'MaxSSOderNo' ] ) + 1 ) : $prefix_t."0001";
    }

    public function getRenewedOrder( $args='' )
    {
        $this->ceh->select( "rowguid, EIRNo, CntrNo, ExpDate, ExpPluginDate, PinCode, CusID" );
        $this->ceh->where("ExpDate IS NOT NULL");
        $this->ceh->where("bXNVC", "0");

        if( $args["fromDate"] != ""){
            $this->ceh->where("ExpDate >=", $this->funcs->dbDateTime($args['fromDate']) );
        }

        if( $args["toDate"] != ""){
            $this->ceh->where("ExpDate <=", $this->funcs->dbDateTime($args['toDate']) );
        }

        if( $args["eirNo"] != ""){
            $this->ceh->where("EIRNo", $args["eirNo"] );
        }

        if( $args["cntrNo"] != ""){
            $this->ceh->where("CntrNo", $args["cntrNo"] );
        }

        if( $args["pinCode"] != ""){
            $this->ceh->where("PinCode", $args["pinCode"] );
        }

        $this->ceh->order_by("EIRNo");

        return $this->ceh->get("EIR")->result_array();
    }

    public function loadEirInquiry($args = array())
    {

        $wShip = ( isset( $args["ShipKey"] ) && $args["ShipKey"] != "" ) ? "ShipKey =".$args["ShipKey"] : "";

        $wLike_EIR = ( isset( $args["searchValue"] ) && $args["searchValue"] != "" ) 
                            ? sprintf( "( EIRNo = '%s' OR PinCode = '%s' OR CntrNo = '%s' )", $args["searchValue"], $args["searchValue"], $args["searchValue"] )
                            : "";

        $wLike_SRV = $wLike_EIR != "" ? str_replace("EIRNo", "SSOderNo", $wLike_EIR) : "";

        $checkCJMode_CD = array();
        $appendCJModeWheres = '';

        $finalWhere = "";
        if ( isset( $args["CJMode_CDs"] ) && count( $args["CJMode_CDs"] ) > 0 )
        {
            $checkCJMode_CD = $args["CJMode_CDs"];

            if( in_array( "ALL", $checkCJMode_CD ) ){
                goto all_cjmode;
            }

            if (in_array( "DH", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " ischkCFS = 1 " : " OR ischkCFS = 1 ";
                unset( $checkCJMode_CD[ array_search( "DH", $checkCJMode_CD ) ] );
            }
            if (in_array( "RH", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " ischkCFS = 2 " : " OR ischkCFS = 2 ";
                unset( $checkCJMode_CD[ array_search( "RH", $checkCJMode_CD ) ] );
            }
            if (in_array( "OTHER", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " isYardSRV = 1 " : " OR isYardSRV = 1 ";
                unset( $checkCJMode_CD[ array_search( "OTHER", $checkCJMode_CD ) ] );
            }
        }

        if( count( $checkCJMode_CD ) > 0 ){
            $finalWhere = sprintf(" CJMode_CD IN ('%s') ", implode( "','", $checkCJMode_CD ) );
        }

        if( $appendCJModeWheres != "" ){
           $temp = $this->ceh->select("CJMode_CD")->get_compiled_select("DELIVERY_MODE", TRUE);
           $finalWhere = sprintf("(%s OR CJMode_CD IN (%s))", $finalWhere, $temp." WHERE ".$appendCJModeWheres );
        }

all_cjmode:

        $getCJModeName = $this->ceh->select("CJModeName")->where("dm.CJMode_CD = srv.CJMode_CD")
                                                            ->limit(1)
                                                            ->get_compiled_select("DELIVERY_MODE dm", TRUE);

        $unionEIR = $this->ceh->select('CJMode_CD, CJModeName, EIRNo AS OrderNo, PinCode, CntrNo, ISO_SZTP, CusID, SHIPPER_NAME, Note')
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )

                                ->where( $wShip != "" ? $wShip : "1=1" )
                                ->where( $wLike_EIR != "" ? $wLike_EIR : "1=1" )
                                ->where( $finalWhere != "" ? $finalWhere : "1=1" )

                                ->get_compiled_select('EIR', TRUE);

        $unionSRV = $this->ceh->select("CJMode_CD, (".$getCJModeName.") AS CJModeName, SSOderNo AS OrderNo, PinCode, CntrNo, ISO_SZTP, CusID, SHIPPER_NAME, Note")
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )

                                ->where( $wShip != "" ? $wShip : "1=1" )
                                ->where( $wLike_SRV != "" ? $wLike_SRV : "1=1" )
                                ->where( $finalWhere != "" ? $finalWhere : "1=1" )

                                ->get_compiled_select("SRV_ODR srv", TRUE);

        $stmt = $this->ceh->query( $unionEIR." UNION ALL ".$unionSRV )->result_array();

        return $stmt;
    }

    public function countOrder( $args = array() )
    {
        $wShip = ( isset( $args["ShipKey"] ) && $args["ShipKey"] != "" ) ? "ShipKey =".$args["ShipKey"] : "";

        $wLike_EIR = ( isset( $args["searchValue"] ) && $args["searchValue"] != "" ) 
                            ? sprintf( "( EIRNo = '%s' OR PinCode = '%s' OR CntrNo = '%s' )", $args["searchValue"], $args["searchValue"], $args["searchValue"] )
                            : "";

        $wLike_SRV = $wLike_EIR != "" ? str_replace("EIRNo", "SSOderNo", $wLike_EIR) : "";

        $checkCJMode_CD = array();
        $appendCJModeWheres = '';

        $finalWhere = "";
        if ( isset( $args["CJMode_CDs"] ) && count( $args["CJMode_CDs"] ) > 0 )
        {
            $checkCJMode_CD = $args["CJMode_CDs"];

            if( in_array( "ALL", $checkCJMode_CD ) ){
                goto all_cjmode;
            }

            if (in_array( "DH", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " ischkCFS = 1 " : " OR ischkCFS = 1 ";
                unset( $checkCJMode_CD[ array_search( "DH", $checkCJMode_CD ) ] );
            }
            if (in_array( "RH", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " ischkCFS = 2 " : " OR ischkCFS = 2 ";
                unset( $checkCJMode_CD[ array_search( "RH", $checkCJMode_CD ) ] );
            }
            if (in_array( "OTHER", $checkCJMode_CD ))
            {
                $appendCJModeWheres .= $appendCJModeWheres == "" ? " isYardSRV = 1 " : " OR isYardSRV = 1 ";
                unset( $checkCJMode_CD[ array_search( "OTHER", $checkCJMode_CD ) ] );
            }
        }

        if( count( $checkCJMode_CD ) > 0 ){
            $finalWhere = sprintf(" CJMode_CD IN ('%s') ", implode( "','", $checkCJMode_CD ) );
        }

        if( $appendCJModeWheres != "" ){
           $temp = $this->ceh->select("CJMode_CD")->get_compiled_select("DELIVERY_MODE", TRUE);
           $finalWhere = sprintf("(%s OR CJMode_CD IN (%s))", $finalWhere, $temp." WHERE ".$appendCJModeWheres );
        }

all_cjmode:

        $getCJModeName = $this->ceh->select("CJModeName")->where("dm.CJMode_CD = srv.CJMode_CD")
                                                            ->limit(1)
                                                            ->get_compiled_select("DELIVERY_MODE dm", TRUE);

        $unionEIR = $this->ceh->select('CJMode_CD, CJModeName, ISO_SZTP, COUNT(ISO_SZTP) COUNT_ISO')
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )

                                ->where( $wShip != "" ? $wShip : "1=1" )
                                ->where( $wLike_EIR != "" ? $wLike_EIR : "1=1" )
                                ->where( $finalWhere != "" ? $finalWhere : "1=1" )

                                ->group_by( array( "CJMode_CD", "ISO_SZTP", "CJModeName" ) )
                                ->get_compiled_select('EIR', TRUE);

        $unionSRV_ODR = $this->ceh->select("CJMode_CD, (".$getCJModeName.") AS CJModeName, ISO_SZTP, COUNT(ISO_SZTP) COUNT_ISO")
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )
                                
                                ->where( $wShip != "" ? $wShip : "1=1" )
                                ->where( $wLike_SRV != "" ? $wLike_SRV : "1=1" )
                                ->where( $finalWhere != "" ? $finalWhere : "1=1" )


                                ->where( $finalWhere != "" ? $finalWhere : "1=1" )
                                ->group_by( array( "CJMode_CD", "ISO_SZTP" ) )
                                ->get_compiled_select('SRV_ODR srv', TRUE);

        $stmt = $this->ceh->query( $unionEIR." UNION ALL ".$unionSRV_ODR );
        $stmt = $stmt->result_array();

        $newarray = array();

        foreach ($stmt as $k => $v ) {
            $newarray[ $v[ "CJMode_CD" ] ][ $k ] = $v;
        }

        $result = array();
        foreach ($newarray as $key => $value) {
            if( is_array( $value ) ){
                $bySize = array(
                    "CJMode_CD" => $key,
                    "CJModeName" => array_column($value, "CJModeName")[0],
                    "SZ_20" => 0,
                    "SZ_40" => 0,
                    "SZ_45" => 0,
                    "SumRow" => (float)array_sum( array_column($value, "COUNT_ISO") )
                );

                foreach ($value as $n => $m) {
                    $size = "SZ_".$this->getContSize( $m["ISO_SZTP"] );
                    if ( $bySize[ $size ] != 0 ){
                        $bySize[ $size ] += (float)$m["COUNT_ISO"];
                    }else{
                        $bySize[ $size ] = (float)$m["COUNT_ISO"];
                    }
                }

                array_push($result, $bySize);
            }
        }

        if ( count( $result ) > 0 ){
            array_push( $result, array(
                                    "CJMode_CD" => "TOTAL",
                                    "CJModeName" => "TỔNG CỘNG",
                                    "SZ_20" => array_sum( array_column($result, "SZ_20") ),
                                    "SZ_40" => array_sum( array_column($result, "SZ_40") ),
                                    "SZ_45" => array_sum( array_column($result, "SZ_45") ),
                                    "SumRow" => array_sum( array_column($result, "SumRow") )
                                )
                        );
        }

        return $result;
    }

    public function sumaryOrder( $args = array() )
    {
        $getCJModeName = $this->ceh->select("CJModeName")->where("dm.CJMode_CD = srv.CJMode_CD")
                                                            ->limit(1)
                                                            ->get_compiled_select("DELIVERY_MODE dm", TRUE);

        $joinEIR = $this->ceh->distinct()->select( "EIRNo, CJMode_CD, ISO_SZTP, CJModeName, IssueDate" )->get_compiled_select("EIR", TRUE);

        $unionEIR = $this->ceh->select('CJMode_CD, CJModeName, ISO_SZTP, SUM(TAMOUNT) SUM_AMOUNT')
                                ->join( "(".$joinEIR.") e", "i.REF_NO = e.EIRNo", "LEFT" )
                                ->where( "CJMode_CD IS NOT NULL" )
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )
                                ->group_by( array( "CJMode_CD", "ISO_SZTP", "CJModeName" ) )
                                ->get_compiled_select('INV_DFT i', TRUE);

        $joinSRV_ODR = $this->ceh->distinct()->select( "SSOderNo, CJMode_CD, ISO_SZTP, (".$getCJModeName.") AS CJModeName, IssueDate" )
                                                ->get_compiled_select("SRV_ODR srv", TRUE);

        $unionSRV_ODR = $this->ceh->select('CJMode_CD, CJModeName, ISO_SZTP, SUM(TAMOUNT) SUM_AMOUNT')
                                ->join( "(".$joinSRV_ODR.") s", "i.REF_NO = s.SSOderNo", "LEFT" )
                                ->where( "CJMode_CD IS NOT NULL" )
                                ->where('YARD_ID', $this->yard_id)
                                ->where( "IssueDate >=", $this->funcs->dbdatetime( $args["IssueDateFrom"]." 23:59:59" ) )
                                ->where( "IssueDate <=", $this->funcs->dbdatetime( $args["IssueDateTo"]." 23:59:59" ) )
                                ->group_by( array( "CJMode_CD", "ISO_SZTP", "CJModeName" ) )
                                ->get_compiled_select('INV_DFT i', TRUE);

        $stmt = $this->ceh->query( $unionEIR." UNION ALL ".$unionSRV_ODR )->result_array();

        $newarray = array();

        foreach ($stmt as $k => $v ) {
            $newarray[ $v[ "CJMode_CD" ] ][ $k ] = $v;
        }

        $result = array();
        foreach ($newarray as $key => $value) {
            if( is_array( $value ) ){
                $bySize = array(
                    "CJMode_CD" => $key,
                    "CJModeName" => array_column($value, "CJModeName")[0],
                    "SZ_20" => 0,
                    "SZ_40" => 0,
                    "SZ_45" => 0,
                    "SumRow" => (float)array_sum( array_column($value, "SUM_AMOUNT") )
                );

                foreach ($value as $n => $m) {
                    $size = "SZ_".$this->getContSize( $m["ISO_SZTP"] );
                    if ( $bySize[ $size ] != 0 ){
                        $bySize[ $size ] += (float)$m["SUM_AMOUNT"];
                    }else{
                        $bySize[ $size ] = (float)$m["SUM_AMOUNT"];
                    }
                }

                array_push($result, $bySize);
            }
        }

        if ( count( $result ) > 0 ){
            array_push( $result, array(
                                    "CJMode_CD" => "TOTAL",
                                    "CJModeName" => "TỔNG CỘNG",
                                    "SZ_20" => array_sum( array_column($result, "SZ_20") ),
                                    "SZ_40" => array_sum( array_column($result, "SZ_40") ),
                                    "SZ_45" => array_sum( array_column($result, "SZ_45") ),
                                    "SumRow" => array_sum( array_column($result, "SumRow") )
                                )
                        );
        }

        return $result;
    }

    public function loadCntrForBooking( $args = array() )
    {
        $this->ceh->select( "rowguid, OprID, LocalSZPT, ISO_SZTP, CntrNo, cBlock, cBay, cRow, cTier, SealNo, ContCondition, cTLHQ" );
        $this->ceh->where( "ContCondition IN ('A', 'B')" );
        $this->ceh->where( "CMStatus", 'S');
        $this->ceh->where( "Status", "E" );
        $this->ceh->where( "BookingNo IS NULL" );
        $this->ceh->where( "EIRNo IS NULL" );

        if( count( $args ) > 0 ){
            if( isset( $args["OprID"] ) ){
                $this->ceh->where( "OprID", $args["OprID"] );
            }
            if( isset( $args["LocalSZPT"] ) ){
                $this->ceh->where( "LocalSZPT", $args["LocalSZPT"] );
            }
        }

        $temp = $this->ceh->get("CNTR_DETAILS");
        return $temp->result_array();
    }

    public function checkCntrForBooking( $args = array() ){

    }

    public function saveBooking( $args = array() )
    {
        $rowguidCntrs = array();
        if ( $args[ "isAssignCntr" ] == "Y" ){
            $rowguidCntrs = $args[ "rowguids" ];
            unset( $args[ "rowguids" ] );
        }

        $checkBkNo = $this->ceh->where( "BookingNo", $args["BookingNo"] )->get("EMP_BOOK")->row_array();
        if( count( $checkBkNo ) > 0 ){
            return "error:Số Booking [".$args[ "BookingNo" ]."] đã tồn tại! Vui lòng nhập số Booking khác!";
        }

        if( isset( $args[ "BookingDate" ] ) ){
            $args[ "BookingDate" ] = $this->funcs->dbDateTime( $args[ "BookingDate" ] );
        }

        if( isset( $args[ "ExpDate" ] ) ){
            $args[ "ExpDate" ] = $this->funcs->dbDateTime( $args[ "ExpDate" ] );
        }

        if( isset( $args[ "ShipName" ] ) ){
            $args[ "ShipName" ] = UNICODE.$args[ "ShipName" ];
        }

        //multi yard
        $args["YARD_ID"] = $this->yard_id;

        $args['ModifiedBy'] = $this->session->userdata("UserID");
        $args['update_time'] = date('Y-m-d H:i:s');
        $args['insert_time'] = date('Y-m-d H:i:s');
        $args['CreatedBy'] = $args['ModifiedBy'];

        $this->ceh->insert('EMP_BOOK', $args);
        if($this->ceh->affected_rows() != 1){
            return 'error:'.$this->ceh->_error_message();
        }

        if( count( $rowguidCntrs ) > 0 ){
            $this->ceh->where_in( "rowguid", $rowguidCntrs )
                        ->update( "CNTR_DETAILS", array( "BookingNo" => $args[ "BookingNo" ] ) );
        }

        return 'success';
    }

    public function load_SSOrder_Renewed($eirs = array())
    {
        $this->ceh->select('cd.rowguid AS RowguidCntrDetails, cd.ShipKey, cd.EIRNo, cd.BerthDate, cd.ShipID, cd.ShipYear, cd.ShipVoy, cd.CntrNo, cd.BLNo, cd.CntrClass
                            , cd.OprID, cd.LocalSZPT, cd.ISO_SZTP, cd.Status, cd.DateIn, cd.VGM
                            , e.NameDD, e.PersonalID, e.SHIPPER_NAME, e.PAYER_TYPE, e.cBlock as cBlock1, e.cBay as cBay1, e.cRow as cRow1, e.cTier as cTier1
                            , cd.SealNo, cd.SealNo1, cd.SealNo2, cd.IsLocal, cd.CMDWeight, cd.CARGO_TYPE, cd.Temperature, cd.CJMode_CD, dm.CJModeName
                            , cd.ImVoy, cd.ExVoy, cd.CmdID, cd.POD, cd.FPOD, cd.Port_CD, cd.OOG_TOP, cd.OOG_LEFT, cd.OOG_RIGHT, cd.OOG_BACK, cd.OOG_FRONT, cd.Transist
                            , cd.UNNO, cd.Note, cd.cTLHQ, ct.Description');
        $this->ceh->join('EIR e', 'e.EIRNo = cd.EIRNo');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');

        if( count($eirs) > 0 ){
            $this->ceh->where_in('cd.EIRNo', $eirs);
        }

        $this->ceh->where('CMStatus', 'S');

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function load_ip_cntr_details($billno = '', $cntrNo = ''){
        $inBL = array();
        if($cntrNo != ''){
            $inBL = $this->ceh->select('BLNo')
                                ->where('CntrNo', $cntrNo)
                                ->where('YARD_ID', $this->yard_id)
                                ->get('CNTR_DETAILS')->result_array();
        }

        $this->ceh->select('ShipKey, BerthDate, ShipID, ShipYear, ShipVoy, CntrNo, BLNo, cd.CntrClass, OprID, LocalSZPT, ISO_SZTP, Status, DateIn, VGM
                            , SealNo, SealNo1, SealNo2, IsLocal, CMDWeight, CARGO_TYPE, Temperature, cd.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, CmdID, POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist, TERMINAL_CD
                            , cBlock, cBay, cRow, cTier, CLASS ,UNNO, Note, cTLHQ, ct.Description');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');
        if($cntrNo == ''){
            $this->ceh->where('BLNo', $billno);
        }
        if($billno == ''){
            $this->ceh->where_in('BLNo', count($inBL) > 0 ? array_column($inBL, 'BLNo') : array(''));
        }

        $this->ceh->where('Status', 'F');
        $this->ceh->where('CMStatus', 'S');
        $this->ceh->where('cd.CntrClass IN (1, 4)');
        $this->ceh->where('DateIn IS NOT NULL');
        $this->ceh->where('DateOut IS NULL');
        $this->ceh->where('EIRNo IS NULL');
        $this->ceh->where('CntrNo NOT IN (SELECT CntrNo FROM Eir WHERE (bXNVC = 0 OR bXNVC IS NULL))');

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function load_service_orders($billno = '', $cntrNo = ''){
        $inBL = array();
        if($cntrNo != ''){
            $inBL = $this->ceh->select('BLNo')->where('CntrNo', $cntrNo)->get('CNTR_DETAILS')->result_array();
        }

        $this->ceh->select('cd.rowguid AS RowguidCntrDetails, ShipKey, BerthDate, ShipID, ShipYear, ShipVoy, CntrNo, BLNo, cd.CntrClass
                            , OprID, LocalSZPT, ISO_SZTP, Status, DateIn, VGM
                            , SealNo, SealNo1, SealNo2, IsLocal, CMDWeight, CARGO_TYPE, Temperature, cd.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, CmdID, POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist
                            , cBlock, cBay, cRow, cTier, UNNO, Note, cTLHQ, ct.Description');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');
        if($cntrNo == ''){
            $this->ceh->where('BLNo', $billno);
        }
        if($billno == ''){
            $this->ceh->where_in('BLNo', count($inBL) > 0 ? array_column($inBL, 'BLNo') : array(''));
        }
        $this->ceh->where('CMStatus', 'S');

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function load_stuffing_conts($cntrNo = ''){
        $this->ceh->select('cd.rowguid AS RowguidCntrDetails, ShipKey, BerthDate, ShipID, ShipYear, ShipVoy, CntrNo, BookingNo
                            , BLNo, cd.CntrClass, OprID, LocalSZPT, ISO_SZTP, Status, DateIn, VGM, Vent, Vent_Unit
                            , SealNo, SealNo1, SealNo2, IsLocal, CWeight, CMDWeight, Temperature, DG_CD, cd.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, CmdID, POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist
                            , cBlock, cBay, cRow, cTier, Note, cTLHQ, ct.Description');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');

        $this->ceh->where('CMStatus', 'S');
        $this->ceh->where('Status', 'E');
        $this->ceh->where('cd.CntrClass', '2');
        $this->ceh->where(" cd.ContCondition IN('A', 'B') ");

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function load_unstuffing_conts($cntrNo = ''){
        $this->ceh->select('cd.rowguid AS RowguidCntrDetails, ShipKey, BerthDate, ShipID, ShipYear, ShipVoy, CntrNo, BookingNo
                            , BLNo, cd.CntrClass, OprID, LocalSZPT, ISO_SZTP, Status, DateIn, VGM, Vent, Vent_Unit, Ter_Hold_CHK
                            , SealNo, SealNo1, SealNo2, IsLocal, CWeight, CMDWeight, CARGO_TYPE, Temperature, DG_CD, cd.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, CmdID, POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist
                            , cBlock, cBay, cRow, cTier, Note, cTLHQ, ct.Description');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');

        $this->ceh->where('BLNo IS NOT NULL');
        $this->ceh->where('CMStatus', 'S');
        $this->ceh->where('Status', 'F');
        // $this->ceh->where('cTLHQ', '1');
        $this->ceh->where('cd.CntrClass', '1');

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function load_transstuffing_conts($cntrNo = ''){
        $this->ceh->select('cd.rowguid AS RowguidCntrDetails, ShipKey, BerthDate, ShipID, ShipYear, ShipVoy, CntrNo, BookingNo
                            , BLNo, cd.CntrClass, OprID, LocalSZPT, ISO_SZTP, Status, DateIn, VGM, Vent, Vent_Unit
                            , SealNo, SealNo1, SealNo2, IsLocal, CWeight, CMDWeight, CARGO_TYPE, Temperature, DG_CD, cd.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, CmdID, POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist
                            , cBlock, cBay, cRow, cTier, Note, cTLHQ, ct.Description');
        $this->ceh->join('CARGO_TYPE ct', 'ct.Code = cd.CARGO_TYPE' , 'LEFT');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cd.CJMode_CD' , 'LEFT');

        $this->ceh->where('CMStatus', 'S');
        // $this->ceh->where('Status', 'F');
        $this->ceh->where('cd.CntrClass', '1');

        $this->ceh->where('cd.YARD_ID', $this->yard_id);

        $this->ceh->order_by('CntrNo','ASC');
        $stmt = $this->ceh->get('CNTR_DETAILS cd');
        return $stmt->result_array();
    }

    public function getBarge(){
        $this->ceh->select('vs.ShipID, ShipName, ShipVoy, ShipYear');
        $this->ceh->join('VESSELS vv', 'vv.ShipID = vs.ShipID');
        $this->ceh->where('VESSEL_TYPE', 'B');
        $this->ceh->where('ShipArrStatus <', '2');

        $this->ceh->where('vs.YARD_ID', $this->yard_id);

        $this->ceh->order_by('ShipName','ASC');
        $stmt = $this->ceh->get('VESSEL_SCHEDULE vs');
        return $stmt->result_array();
    }

    public function getLanePortID($shipkey = ''){
        $this->ceh->select('Port_CD, LaneID');
        $this->ceh->where(sprintf('LaneID IN (select LaneID from VESSEL_SCHEDULE WHERE ShipKey = \'%1$s\')', $shipkey));

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('Port_CD', 'ASC');
        $stmt = $this->ceh->get('LANE_FPOD');
        return $stmt->result_array();
    }

    public function getLaneOprs($shipkey = ''){
        $this->ceh->select('CusID, LaneID');
        $this->ceh->where(sprintf('LaneID IN (select LaneID from VESSEL_SCHEDULE WHERE ShipKey = \'%1$s\')', $shipkey));

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusID', 'ASC');
        $stmt = $this->ceh->get('LANE_OPR');
        return $stmt->result_array();
    }

    public function getCargoTypes($cargo_id = ''){
        $this->ceh->select('Code, Description');
        if($cargo_id != ''){
            $this->ceh->where('Code', $cargo_id);
        }
        $this->ceh->where('Code != ', '*');
        $this->ceh->order_by('Description', 'ASC');
        $stmt = $this->ceh->get('CARGO_TYPE');
        return $stmt->result_array();
    }

    private function getUnitRate($sz, $fe, $currency, $trf_code, $IsLocal){
        $this->ceh->select('AMT_'.$fe.$sz.' AMT');
        $this->ceh->where('CURRENCYID', $currency);
        $this->ceh->where('TRF_CODE', $trf_code);
        $this->ceh->where('IsLocal', $IsLocal);

        $this->ceh->where('YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('TRF_STD')->row_array();
        if(count($stmt) > 0){
            return $stmt['AMT'];
        }
        return 0;
    }

    private function filter_trf_dis($inputs, $fwheres, $mskey){ //$mskey là khóa (tên cột) để xác định dòng/item sẽ được remove khỏi $inputs nếu k thỏa điêu kiện
        foreach ($fwheres as $k => $v) { //$k : col name, $v : col val
            $arrcol_val = array_column($inputs, $k, $mskey);
            if(in_array($fwheres[$k], $arrcol_val)){
                foreach ($arrcol_val as $idx=>$item) {
                    if($fwheres[$k] == $item) continue; //thoa dieu kien filter
                    unset($inputs[$idx]);
                }
            }else{
                foreach ($arrcol_val as $idx=>$item) {
                    if($item == '*') continue;
                    unset($inputs[$idx]);
                }
            }
            if(count($inputs) > 1){
                unset($fwheres[$k]);
                return $this->filter_trf_dis($inputs, $fwheres, $mskey);
            }else{
                return $inputs;
            }
        }
        return array();
    }

    public function getDiscount($sz, $fe, $wheres){
        array_push($wheres, $this->yard_id);
        
        $sql = 'SELECT rowguid, AMT_'.$fe.$sz.' AMT, FIX_RATE, Opr, PAYER, CARGO_TYPE, IX_CD, DMETHOD_CD, JOB_KIND, CNTR_JOB_TYPE, CURRENCYID, IsLocal FROM TRF_DIS';
        $sql.=' WHERE ((EXPIRE_DATE IS NULL AND (APPLY_DATE=\'*\' OR (APPLY_DATE<>\'*\'
                            AND (CONVERT(datetime,CASE WHEN APPLY_DATE=\'*\' THEN \'1900-01-01\' ELSE APPLY_DATE END,103)) <= ? )))
                            OR (EXPIRE_DATE IS NOT NULL AND (EXPIRE_DATE >= ?) AND (APPLY_DATE=\'*\' OR (APPLY_DATE<>\'*\'
                            AND ? BETWEEN (CONVERT(datetime,CASE WHEN APPLY_DATE=\'*\' THEN \'1900-01-01\' ELSE APPLY_DATE END,103)) AND EXPIRE_DATE ))))';
        $sql.=' AND (TRF_CODE = ? OR TRF_CODE = \'*\')';

        $sql.=' AND (Opr = ? OR Opr = \'*\')';
        $sql.=' AND (PAYER = ? OR PAYER = \'*\')';
        $sql.=' AND (CARGO_TYPE = ? OR CARGO_TYPE = \'*\')';
        $sql.=' AND (IX_CD = ? OR IX_CD = \'*\')';
        $sql.=' AND (DMETHOD_CD = ? OR DMETHOD_CD = \'*\')';
        $sql.=' AND (JOB_KIND = ? OR JOB_KIND = \'*\')';
        $sql.=' AND (CNTR_JOB_TYPE = ? OR CNTR_JOB_TYPE = \'*\')';
        $sql.=' AND (CURRENCYID = ? OR CURRENCYID = \'*\')';
        $sql.=' AND (IsLocal = ? OR IsLocal = \'*\')';
        $sql.=' AND (EQU_TYPE = \'*\')';
        $sql.=' AND (YARD_ID = ?)';

        $sql.=' ORDER BY OPR DESC,LANE DESC,PAYER_TYPE DESC,PAYER DESC,APPLY_DATE DESC';

        $stmt = $this->ceh->query($sql, $wheres);
        $stmt = $stmt->result_array();

        if(count($stmt) == 0) return 0;

        if(count($stmt) > 1){
            $fwhere = array(
                'PAYER' => $wheres[5],
                'Opr' => $wheres[4],
                'CARGO_TYPE' => $wheres[6],
                'IX_CD' => $wheres[7],
                'DMETHOD_CD' => $wheres[8],
                'JOB_KIND' => $wheres[9],
                'CNTR_JOB_TYPE' => $wheres[10],
                'CURRENCYID' => $wheres[11],
                'IsLocal' => $wheres[12]
            );

            //đổi key của từng row trong $stmt thành giá trị của cột ID
            foreach ($stmt as $k=>$v ) {
                $stmt[$v['rowguid']] = $v;
                unset($stmt[$k]);
            }

            $temp = $this->filter_trf_dis($stmt, $fwhere, 'rowguid');
            if(count($temp) == 0) return 0;
            $temp = array_reverse($temp);
            $result = array_pop($temp);
        }else{
            if(count($stmt) == 1) {
                $result = $stmt[0];
            }
        }

        if(count($result) > 0){
            $result = count(array_keys($result)) == 1 ? reset($result) : $result;
            if($result['FIX_RATE'] == 1){
                $unit_rate = $this->getUnitRate($sz, $fe, $wheres[8], $wheres[4], $wheres[9]);
                return $unit_rate*($result['AMT'] !== null ? $result['AMT'] : 0)*0.01;
            }else{
                return $result['AMT'] !== null ? $result['AMT'] : 0;
            }
        }

        return 0;
    }

    public function loadTariffSTD($listeir){
        $sql = 'SELECT * FROM TRF_STD WHERE (CARGO_TYPE = ? OR CARGO_TYPE = \'*\') ';
        $sql.=' AND (IX_CD = ? OR IX_CD = \'*\')';
        $sql.=' AND (DMETHOD_CD = ?)';
        $sql.=' AND (JOB_KIND = ?)';
        $sql.=' AND (CNTR_JOB_TYPE = ? OR CNTR_JOB_TYPE = \'*\')';
        $sql.=' AND (IsLocal = ? OR IsLocal = \'*\')';
        $sql.=' AND ((CONVERT(date, ?, 104) >= CONVERT(date, FROM_DATE, 104) and TO_DATE = \'*\') or
	                (CONVERT(date, ?, 104) between CONVERT(date, FROM_DATE, 104) AND CONVERT(date, TO_DATE, 104)))';

        $sql.=' AND (YARD_ID = ?)';

        $result = array();
        $final_result=array();
        if(isset($listeir) && is_array($listeir)){
            foreach($listeir as $item){
                $JOB_KIND = ($item['CJMode_CD'] == 'LAYN' || $item['CJMode_CD'] == 'NTAU' || $item['CJMode_CD'] == 'CAPR')
                    ? "GO" : (($item['CJMode_CD'] == 'HBAI' || $item['CJMode_CD'] == 'TRAR') ? "GF" : "*");
                $wheres = array(
                    $item['CARGO_TYPE'],
                    $item['CntrClass'],
                    $item['DMETHOD_CD'],
                    $JOB_KIND,
                    $item['CJMode_CD'],
                    $item['IsLocal'],
                    date('d/m/Y'),
                    date('d/m/Y'),
                    $this->yard_id
                );
                $stmt = $this->ceh->query($sql, $wheres);
                $stmt = $stmt->result_array();
                if(count($stmt) > 1){
                    $fwhere = array(
                        'CARGO_TYPE' => $item['CARGO_TYPE'],
                        'IX_CD' => $item['CntrClass'],
                        'DMETHOD_CD' => $item['DMETHOD_CD'],
                        'JOB_KIND' => $JOB_KIND,
                        'CNTR_JOB_TYPE' => $item['CJMode_CD'],
                        'IsLocal' => $item['IsLocal']
                    );
                    //đổi key của từng row trong $stmt thành giá trị của cột rowguid
                    foreach ( $stmt as $k=>$v ) {
                        $stmt[$v['rowguid']] = $v;
                        unset($stmt[$k]);
                    }

                    $temp = $this->filter_trf_dis($stmt, $fwhere, 'rowguid');
                    if(count($temp) == 0) continue;
                    $temp = array_reverse($temp);
                    $result = array_pop($temp);
                }else{
                    if(count($stmt) == 1) {
                        $result = $stmt[0];
                    }
                }

                // $ordNo = isset($item['EIRNo']) ? $item['EIRNo'] : $item['SSOderNo'];

                if(count($result) > 0){
                    // $result['OrderNo'] = $ordNo;
                    $result['CJMode_CD'] = $item['CJMode_CD'];
                    $result['ISO_SZTP'] = $item['ISO_SZTP'];
                    $result['FE'] = $item['Status'];
                    $result['CntrNo'] = $item['CntrNo'];
                    $result['OprID'] = $item['OprID'];
                    $result['IssueDate'] = $item['IssueDate'];
                    
                    array_push($final_result, $result);
                }else{
                    $cjmode = $item['CJMode_CD'];
                    array_push($final_result, "[$cjmode] không tìm thấy biểu cước phù hợp!");
                }
            }
        }

        return $final_result;
    }

    public function loadServiceTariff($listeir){
        $sql = 'SELECT * FROM TRF_STD WHERE (CNTR_JOB_TYPE = ?)';
        $sql.= ' AND ((CONVERT(date, ?, 104) >= CONVERT(date, FROM_DATE, 104) and TO_DATE = \'*\') or
                    (CONVERT(date, ?, 104) between CONVERT(date, FROM_DATE, 104) AND CONVERT(date, TO_DATE, 104)))';

        $sql.= ' AND (YARD_ID = ?)';

        $final_result=array();
        if(isset($listeir) && is_array($listeir)){
            foreach($listeir as $item){
                
                $result = array();

                $wheres = array(
                    $item['CJMode_CD'],
                    date('d/m/Y'),
                    date('d/m/Y'),

                    $this->yard_id
                );

                $stmt = $this->ceh->query($sql, $wheres);
                $stmt = $stmt->result_array();
                if(count($stmt) > 1){
                    $fwhere = array(
                        'CURRENCYID' => 'VND',
                        'CARGO_TYPE' => $item['CARGO_TYPE'],
                        'IX_CD' => $item['CntrClass'],
                        'DMETHOD_CD' => isset( $item['DMETHOD_CD'] ) ? $item['DMETHOD_CD'] : "*",
                        'JOB_KIND' => '*',
                        'CNTR_JOB_TYPE' => $item['CJMode_CD'],
                        'IsLocal' => $item['IsLocal']
                    );
                    //đổi key của từng row trong $stmt thành giá trị của cột rowguid
                    foreach ($stmt as $k=>$v ) {
                        $stmt[$v['rowguid']] = $v;
                        unset($stmt[$k]);
                    }

                    $temp = $this->filter_trf_dis($stmt, $fwhere, 'rowguid');
                    if(count($temp) == 0) continue;
                    $temp = array_reverse($temp);
                    $result = array_pop($temp);
                }else{
                    if(count($stmt) == 1) {
                        $result = $stmt[0];
                    }
                }

                if(count($result) > 0){
                    $result['CntrNo'] = $item['CntrNo'];
                    $result['CJMode_CD'] = $item['CJMode_CD'];
                    $result['ISO_SZTP'] = $item['ISO_SZTP'];
                    $result['FE'] = $item['Status'];
                    $result['CntrNo'] = $item['CntrNo'];
                    $result['OprID'] = $item['OprID'];
                    $result['IssueDate'] = isset($item['IssueDate']) ? $item['IssueDate'] : date("Y-m-d H:i:s");

                    array_push($final_result, $result);
                }else{
                    $cjmode = $item['CJMode_CD'];
                    array_push($final_result, "[$cjmode] Không tìm thấy biểu cước phù hợp!");
                }
            }
        }
        return $final_result;
    }

    public function getTRF_unitCode($tarriffcode){
        $stmt = $this->ceh->select('INV_UNIT')
                                ->where('TRF_CODE', $tarriffcode)
                                ->where('YARD_ID', $this->yard_id)
                                ->limit(1)
                                ->get('TRF_CODES')->row_array();
        return $stmt['INV_UNIT'];
    }

    public function getBookingList($bkno = '', $cntrno = ''){
        $incont = array();
        if($cntrno != ''){
            $incont = $this->ceh->select('BookingNo')
                                            ->where('CntrNo', $cntrno)
                                            ->where('BookingNo IS NOT NULL')
                                            ->where('YARD_ID', $this->yard_id)
                                            ->get('CNTR_DETAILS');
            $incont = $incont->result_array();
            if(count($incont) == 0){
                return array("error" => "Container này chưa được đăng ký Booking!");
            }
        }

        if($bkno != ''){
            $bktemp = $this->ceh->select('BookNo, LocalSZPT, ISO_SZTP, BookingDate, ExpDate, Status, BookAmount, StackingAmount, OprID, isAssignCntr')
                                ->where('BookNo', $bkno)
                                // ->where('ExpDate >=', date('Y-m-d H:i:s'))
                                ->where('YARD_ID', $this->yard_id)
                                ->get('EMP_BOOK')->result_array();

            if(count($bktemp) == 0){
                return array("error" => "Số Booking này không tồn tại! <br/>Vui lòng kiểm tra lại!");
            }

            if($bktemp[0]['isAssignCntr'] == "N"){
                if($bktemp[0]['ExpDate'] < date("Y-m-d H:i:s")){
                    return array("error" => "Booking này đã hết hạn!");
                }

                if($bktemp[0]['StackingAmount'] == $bktemp[0]['BookAmount']){
                    return array("error" => "Booking hết chỗ!");
                }

                return $bktemp;
            }
        }

        $this->ceh->select('bk.BookNo, bk.LocalSZPT, bk.ISO_SZTP, BookingDate, bk.ExpDate, ISNULL(bk.Status, cn.Status) Status, BookAmount, StackingAmount, bk.OprID, cn.CARGO_TYPE
                            , CntrNo, cn.CntrClass, SealNo, IsLocal, CMDWeight, cn.Note, cTLHQ, cBlock, cBay, cRow, cTier, ContCondition, isAssignCntr
							, ShipKey, BerthDate, cn.ShipID, cn.ShipYear, cn.ShipVoy, cn.BerthDate, BLNo, DateIn, VGM, SealNo1, SealNo2, bk.Temperature, cn.CJMode_CD, dm.CJModeName
                            , ImVoy, ExVoy, bk.CmdID, bk.POD, FPOD, Port_CD, OOG_TOP, OOG_LEFT, OOG_RIGHT, OOG_BACK, OOG_FRONT, Transist, TERMINAL_CD, CLASS ,UNNO');
        $this->ceh->join('Cntr_Details cn', 'cn.BookingNo = bk.BookNo AND cn.LocalSZPT = bk.LocalSZPT', 'left');
        $this->ceh->join('DELIVERY_MODE dm', 'dm.CJMode_CD = cn.CJMode_CD' , 'LEFT');
        // $this->ceh->where('cn.CntrClass', '2');
        // $this->ceh->where('bk.ExpDate >=', date('Y-m-d H:i:s'));
        // $this->ceh->where('CMStatus', 'S');
        // $this->ceh->where('DateOut IS NULL');
        // $this->ceh->where('EIRNo IS NULL');
        $this->ceh->where('isAssignCntr', 'Y');

        //nếu filter theo số book
        if($cntrno == ''){
            $this->ceh->where('cn.Status', 'E');
            $this->ceh->where('cn.CntrClass', '2');
            $this->ceh->where('CMStatus', 'S');
            $this->ceh->where('DateOut IS NULL');
            $this->ceh->where('EIRNo IS NULL');

            $this->ceh->where('(ContCondition IN(\'A\',\'B\') OR ContCondition IS NULL)');

            $this->ceh->where('BookNo', $bkno);
        }

        //nếu filter theo số cont
        if($bkno == ''){
            $this->ceh->where_in('BookingNo', array_column($incont, 'BookingNo'));
        }

        $this->ceh->where('bk.YARD_ID', $this->yard_id);

        $stmt = $this->ceh->get('EMP_BOOK bk');

        if(count($stmt) > 0){
            if($cntrno != ''){
                if($stmt[0]["ExpDate"] < date('Y-m-d H:i:s')){
                    return array("error" => "Booking này đã hết hạn!");
                }

                if($stmt[0]["CntrClass"] != '2' || $stmt[0]["Status"] != "E"){
                    return array("error" => "Chỉ có container LƯU RỖNG [Storage Empty] mới được phép cấp lệnh!");
                }

                if($stmt[0]["DateOut"] !== NULL){
                    return array("error" => "Container đã ra khỏi bãi không thể cấp lệnh!");
                }
                 
                if($stmt[0]["EIRNo"] !== NULL){
                    return array("error" => "Container đang đự!");
                }

                if($stmt[0]["ContCondition"] !== NULL && in_array($stmt[0]["ContCondition"], array("A", "B"))){
                    return array("error" => "Container không đủ điều kiện cấp lệnh!");
                }
            }
        }else{
            return array("error" => "Không tìm thấy thông tin booking! Vui lòng kiểm tra lại!");
        }

        $stmt = $stmt->result_array();
        return $stmt;
    }

    public function updateEIR_byRenewed($args)
    {
        foreach ($args as $arg) {
            $updateItem = array();

            if( $arg[ "NewExpDate" ] != "" ){
                $updateItem[ "ExpDate" ] = $arg[ "NewExpDate" ];
            }

            if( $arg[ "NewExpPluginDate" ] != "" ){
                $updateItem[ "ExpPluginDate" ] = $arg[ "NewExpPluginDate" ];
            }

            $updateItem[ "update_time" ] = date("Y-m-d H:i:s");

            $this->ceh->where("rowguid", $arg["rowguid"])->update("EIR", $updateItem);

            if($this->ceh->affected_rows() != 1){
                return 'error:'.$this->ceh->_error_message();
            }
        }

        return 'success';
    }

    public function saveInvoice($args, $order, $cntrRowguids = array()){
        if(!is_array($args) || count($args) == 0) return true;

        $draft_details = array();
        if(isset($args['draft_detail']) && count($args['draft_detail'])){
            $draft_details = $args['draft_detail'];
        }

        $draft_total = array();
        if(isset($args['draft_total']) && count($args['draft_total'])){
            $draft_total = $args['draft_total'];
        }

        $invPrefix = $args["INV_CONTENT"]["INV_PREFIX"];
        $invNoPre = $args["INV_CONTENT"]["INV_NO_PRE"];
        $draftno = $args["INV_CONTENT"]["DRAFT_NO"];
        $pincode = $args["INV_CONTENT"]["PIN_CODE"];

        //get inv draft
        $inv_draft = array(
            "DRAFT_INV_NO" => $draftno,
            "INV_NO" =>  $invPrefix.$invNoPre,
            "DRAFT_INV_DATE" => date('Y-m-d H:i:s'),
            "REF_NO" => implode( ", " , $args['REF_NOs']),
            "ShipKey" => $order['ShipKey'],
            "ShipID" => $order['ShipID'],
            "ShipYear" => $order['ShipYear'],
            "ShipVoy" => $order['ShipVoy'],
            "PAYER_TYPE" => $order['PAYER_TYPE'],
            "PAYER" => $order['CusID'],
            "OPR" => $order['OprID'],
            "AMOUNT" => (float)str_replace(',', '', $draft_total['AMOUNT']),
            "VAT" => (float)str_replace(',', '', $draft_total['VAT']),
            "DIS_AMT" => (float)str_replace(',', '', $draft_total['DIS_AMT']),
            "PAYMENT_STATUS" => $order['PAYMENT_TYPE'] == "C" ? "U" : "Y",
            "REF_TYPE" => "A",
            "CURRENCYID" => $draft_details[0]["CURRENCYID"],
            "RATE" => 1,
            "INV_TYPE" => $order['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
            "INV_TYPE_2" => "L",
            "TPLT_NM" => "EB",
            "TAMOUNT" => (float)str_replace(',', '', $draft_total['TAMOUNT']),

            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s'),
            "CreatedBy" => $this->session->userdata("UserID")
        );

        //get inv draft details
        $inv_draft_details = array();
        foreach ($draft_details as $idx => $dd) {
            $dd['DRAFT_INV_NO'] = $draftno;
            $dd['SEQ'] = $idx;
            $dd['SZ'] =  $this->getContSize($dd['ISO_SZTP']);
            $dd['DIS_AMT'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['standard_rate'] = (float)str_replace(',', '', $dd['standard_rate']);
            $dd['DIS_RATE'] = (float)str_replace(',', '', $dd['DIS_RATE']);
            $dd['extra_rate'] = (float)str_replace(',', '', $dd['extra_rate']);
            $dd['UNIT_RATE'] = (float)str_replace(',', '', $dd['UNIT_RATE']);
            $dd['AMOUNT'] = (float)str_replace(',', '', $dd['AMOUNT']);
            $dd['VAT'] = (float)str_replace(',', '', $dd['VAT']);
            $dd['TAMOUNT'] = (float)str_replace(',', '', $dd['TAMOUNT']);
            $dd['TRF_DESC'] = UNICODE.$dd['TRF_DESC'];

            $dd['GRT'] = 1;
            $dd['SOGIO'] = 1;
            $dd['ModifiedBy'] = $this->session->userdata("UserID");
            $dd['CreatedBy'] = $this->session->userdata("UserID");
            $dd['update_time'] =date('Y-m-d H:i:s');

            unset($dd['REF_NO'], $dd['JobMode'], $dd['ISO_SZTP'], $dd['CURRENCYID']);
            array_push($inv_draft_details, $dd);
        }

        //get inv VAT
        $inv_vat = array(
            "INV_NO" => $invPrefix.$invNoPre,
            "INV_DATE" => date('Y-m-d H:i:s'),
            "REF_NO" => implode( ", " , $args['REF_NOs']),
            "ShipKey" => $order['ShipKey'],
            "ShipID" => $order['ShipID'],
            "ShipYear" => $order['ShipYear'],
            "ShipVoy" => $order['ShipVoy'],
            "PAYER_TYPE" => $order['PAYER_TYPE'],
            "PAYER" => $order['CusID'],
            "OPR" => $order['OprID'],
            "AMOUNT" => (float)str_replace(',', '', $draft_total['AMOUNT']),
            "VAT" => (float)str_replace(',', '', $draft_total['VAT']),
            "DIS_AMT" => (float)str_replace(',', '', $draft_total['DIS_AMT']),
            "PAYMENT_STATUS" => $order['PAYMENT_TYPE'] == "C" ? "U" : "Y",
            "REF_TYPE" => "A",
            "CURRENCYID" => $draft_details[0]["CURRENCYID"],
            "RATE" => 1,
            "INV_TYPE" => $order['PAYMENT_TYPE'] == "C" ? "CRE" : "CAS",
            "INV_TYPE_2" => "L",
            "TPLT_NM" => "EB",
            "PRINT_CHECK" => 0,
            "TAMOUNT" => (float)str_replace(',', '', $draft_total['TAMOUNT']),
            "ACC_CD" => $order['PAYMENT_TYPE'] == "C" ? "TM/CK" : "CK",
            "INV_PREFIX" => $invPrefix,
            "INV_NO_PRE" => $invNoPre,
            "PinCode" => $pincode,
            "CreatedBy" => $this->session->userdata("UserID"),
            "ModifiedBy" => $this->session->userdata("UserID"),
            "update_time" => date('Y-m-d H:i:s')
            // "CreatedBy" => $this->session->userdata("UserID")
//            "DISCOUNT_AMT" => "",
//            "DISCOUNT_DESC" => "",
//            "DISCOUNT_VAT" => "",
//            "exportCount" => "",
        );

        //get inv Cont
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $inv_draft["YARD_ID"] = $this->yard_id;

        $this->ceh->insert('INV_DFT', $inv_draft);
        foreach ($inv_draft_details as $item) {

            $item["YARD_ID"] = $this->yard_id;

            $this->ceh->insert('INV_DFT_DTL', $item);
        }
        $this->ceh->insert('INV_VAT', $inv_vat);

        if(count($cntrRowguids) > 0){
            $this->ceh->where('YARD_ID', $this->yard_id)
                        ->where_in('rowguid', $cntrRowguids)
                        ->update('CNTR_DETAILS', array("InvNo" => $inv_vat["INV_NO"]));
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

    public function save_EIR_INV($args){
        //$lst, $pincode
        if(!is_array($args) || count($args) == 0) return "";

        $eirs = array();
        if(isset($args['eir']) && count($args['eir'])){
            $eirs = $args['eir'];
        }

        if(count($eirs) == 0){
            return "";
        }

        //get invoice info
        $invInfo = isset($args['invInfo']) ? $args['invInfo'] : array();

        $invContents = count($invInfo) == 0 ? array() : array(
                                                            "INV_NO_PRE" => substr("0000000".$invInfo['invno'], -7),
                                                            "INV_PREFIX" => $invInfo['serial'],
                                                            "DRAFT_NO" => $this->getDraftTemp(),
                                                            "PIN_CODE" => $invInfo['fkey']
                                                        );

        $arrCntrRowguids = array();
        $arrEIRNo = array();
        $eirSeq = 1;

        $checkEIRNo = array();

        foreach ($eirs as $item) {
            //unset column use for inv
            unset($item['ShipYear'], $item['ShipVoy']);

            //unset column in importpickup
            unset($item['cTLHQ'], $item['Description']);

            //unset column in emptypickup
            unset($item['BookingDate'], $item['BookAmount'], $item['StackingAmount'], $item['ContCondition'], $item['isAssignCntr']);

            //VIET HOA SO CONTAINER
            if(isset($item['CntrNo'])){
                $item['CntrNo'] = strtoupper($item['CntrNo']);
            }

            //convert datetime in client to dbdatetime
            $item['IssueDate'] = $this->funcs->dbDateTime($item['IssueDate']);

            if(isset($item['ExpDate'])){
                $item['ExpDate'] = $this->funcs->dbDateTime($item['ExpDate']);
            }
            if(isset($item['BerthDate'])){
                $item['BerthDate'] = $this->funcs->dbDateTime($item['BerthDate']);
            }

            if(isset($item['CJModeName'])){
                $item['CJModeName'] = UNICODE.$item['CJModeName'];
            }

            if(isset($item['SHIPPER_NAME'])){
                $item['SHIPPER_NAME'] = UNICODE.$item['SHIPPER_NAME'];
            }

            if(isset($item['NameDD'])){
                $item['NameDD'] = UNICODE.$item['NameDD'];
            }

            if( isset( $invContents["PIN_CODE"] ) ){
                $item['PinCode'] = $invContents["PIN_CODE"];
            }

            //update inv info into 
            if(count($invContents) > 0){
                $item["DRAFT_INV_NO"] = $invContents["DRAFT_NO"];
                $item["InvNo"] = $invContents["INV_PREFIX"].$invContents["INV_NO_PRE"];
            }
            
            //multi yard
            $item["YARD_ID"] = $this->yard_id;

            //basic info
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] =date('Y-m-d H:i:s');

//            $where = array(
//                'VoyageKey'    => $item['VoyageKey'],
//                'BillOfLading' => $item['BillOfLading'],
//                'ImExType'     => $item['ImExType'],
//            );
//            $checkitem = $this->ceh->where($where)->get('DT_PACKAGE_MNF_LD')->row_array();
//            if(count($checkitem) > 0)
//            {
//                //update database
//                $this->ceh->where($where)->limit(1)->update('DT_PACKAGE_MNF_LD',$item);
//                $result = 'Cập nhật thành công';
//            }
//            else
//            {
//
//            }
            //insert database

            $item['CreatedBy'] = $item['ModifiedBy'];

            $item["EIRNo"] = isset( $checkEIRNo[ $item["CJMode_CD"] ] ) ? $checkEIRNo[ $item["CJMode_CD"] ] : $this->generateEirNo();

            $eirSeq = isset( $checkEIRNo[ $item["CJMode_CD"] ] ) ? ( $eirSeq + 1 ) : 1;

            $item["EIR_SEQ"] = $eirSeq;

            $checkEIRNo[ $item["CJMode_CD"] ] = $item["EIRNo"];
            
            array_push( $arrEIRNo, $item["EIRNo"] );

            $this->ceh->insert('EIR', $item);
            if($this->ceh->affected_rows() != 1){
                return 'error:'.$this->ceh->_error_message();
            }

            $cntrWhere = array(
                "CntrNo" => $item["CntrNo"] ? $item["CntrNo"] : "",
                "CMStatus" => 'S',
                "CntrClass" => $item["CntrClass"] ? $item["CntrClass"] : "",
                "ShipKey" => $item["ShipKey"] ? $item["ShipKey"] : "",
                "OprID" => $item["OprID"] ? $item["OprID"] : "",

                "YARD_ID" => $this->yard_id
            );

            $uCntr = $this->ceh->select('rowguid')
                                    ->where($cntrWhere)
                                    ->limit(1)
                                    ->get('CNTR_DETAILS')->row_array();

            if(count($uCntr) > 0 && $uCntr['rowguid'] != ''){
                $updateVals = array(
                    "EIRNo" => $item["EIRNo"],
                    "CJMode_OUT_CD" => $item["CJMode_CD"],
                    "DMethod_OUT_CD" => $item["DMETHOD_CD"]
                );

                $this->ceh->where('rowguid', $uCntr['rowguid'])->update('CNTR_DETAILS', $updateVals);
                array_push($arrCntrRowguids, $uCntr['rowguid']);
            }
        }

        if(count($invContents) > 0){
            //set Inv Content to args
            $args["INV_CONTENT"] = $invContents;

            //add to args for save INV
            $args["REF_NOs"] = $arrEIRNo;

            $results = $this->saveInvoice($args, $eirs[0], $arrCntrRowguids);
            return $results;
        }
        
        return TRUE;
    }

    public function save_SRV_ODR_INV($args, $stuff_unstuff_chk = array()){
        //$lst, $pincode
        if(!is_array($args) || count($args) == 0) return "";

        $orders = array();
        if(isset($args['odr']) && count($args['odr'])){
            $orders = $args['odr'];
        }

        if(count($orders) == 0){
            return "";
        }

         //get invoice info
        $invInfo = isset($args['invInfo']) ? $args['invInfo'] : array();

        $invContents = count($invInfo) == 0 ? array() : array(
                                                            "INV_NO_PRE" => substr("0000000".$invInfo['invno'], -7),
                                                            "INV_PREFIX" => $invInfo['serial'],
                                                            "DRAFT_NO" => $this->getDraftTemp(),
                                                            "PIN_CODE" => $invInfo['fkey']
                                                        );

        $arrCntrRowguids = array();
        $arrSSOderNo = array();

        $forSSMore = "";

        foreach ($orders as $item) {
            //unset column use for inv
            unset($item['ShipYear'], $item['ShipVoy']);

            //unset column
            unset($item['cTLHQ'], $item['Description'], $item['CJModeName'], $item['Transist'], $item["UNNO"]);

            if(isset($item['CntrNo'])){
                $item['CntrNo'] = strtoupper($item['CntrNo']);
            }

            //convert datetime in client to dbdatetime
            $item['IssueDate'] = $this->funcs->dbDateTime( isset( $item['IssueDate'] ) ? $item['IssueDate'] : date("Y-m-d H:i:s") );
            if(isset($item['ExpDate'])){
                $item['ExpDate'] = $this->funcs->dbDateTime($item['ExpDate']);
            }
            if(isset($item['ExpPluginDate'])){
                $item['ExpPluginDate'] = $this->funcs->dbDateTime($item['ExpPluginDate']);
            }
            if(isset($item['BerthDate'])){
                $item['BerthDate'] = $this->funcs->dbDateTime($item['BerthDate']);
            }
            if(isset($item['Note'])){
                $item['Note'] = UNICODE.$item['Note'];
            }

            // if(isset($item['CJModeName'])){
            //     $item['CJModeName'] = UNICODE.$item['CJModeName'];
            // }

            if(isset($item['SHIPPER_NAME'])){
                $item['SHIPPER_NAME'] = UNICODE.$item['SHIPPER_NAME'];
            }

            if(isset($item['NameDD'])){
                $item['NameDD'] = UNICODE.$item['NameDD'];
            }

            if(isset($item['Port_CD'])){
                $item['POL'] = $item['Port_CD'];
                unset($item['Port_CD']);
            }

            if( isset( $invContents["PIN_CODE"] ) ){
                $item['PinCode'] = $invContents["PIN_CODE"];
            }

            //update inv info into 
            if(count($invContents) > 0){
                $item["DRAFT_INV_NO"] = $invContents["DRAFT_NO"];
                $item["InvNo"] = $invContents["INV_PREFIX"].$invContents["INV_NO_PRE"];
            }

            //multi yard
            $item["YARD_ID"] = $this->yard_id;

            //basic info
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] =date('Y-m-d H:i:s');

            //insert database

            $item['CreatedBy'] = $item['ModifiedBy'];

            //generate SSOderNo for save data
            $item["SSOderNo"] = $this->generateSSOrderNo();

            array_push($arrSSOderNo, $item["SSOderNo"]);

            $this->ceh->insert('SRV_ODR', $item);
            if($this->ceh->affected_rows() != 1){
                return 'error:'.$this->ceh->_error_message();
            }

            //update to CNTR_DETAILS
            if(isset($item["RowguidCntrDetails"])){
                $updateVals = array(
                   "SSOderNo" => $item["SSOderNo"]
                );

                if(count($stuff_unstuff_chk) > 0){
                    $updateVals[$stuff_unstuff_chk[0]] = "Y";
                    $updateVals["CJMode_OUT_CD"] = $item["CJMode_CD"];
                    $updateVals["DMethod_OUT_CD"] = $item["DMETHOD_CD"];
                }

                $this->ceh->where('rowguid', $item['RowguidCntrDetails'])->update('CNTR_DETAILS', $updateVals);
                array_push($arrCntrRowguids, $item['RowguidCntrDetails']);
            }

            //unset session EIRNO
            unset($_SESSION['EirNoQueue'][$item['SSOderNo']]);
        }

        if(count($invContents) > 0){
            //set Inv Content to args
            $args["INV_CONTENT"] = $invContents;

            //add to args for save INV
            $args["REF_NOs"] = $arrSSOderNo;

            $results = $this->saveInvoice($args, $orders[0], $arrCntrRowguids);
            return $results;
        }

        return TRUE;
    }

    private function getContSize($sztype){
        switch(substr($sztype,0,1)){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
        }
        return "0";
    }

    public function getDraftTemp(){
        $this->ceh->select('DRAFT_INV_NO');
        $this->ceh->where("YARD_ID", $this->yard_id);
        $this->ceh->order_by('DRAFT_INV_NO', 'DESC');
        $stmt = $this->ceh->limit(1)->get('INV_DFT');
        $stmt = $stmt->row_array();
        if($stmt['DRAFT_INV_NO'] === null){
            return 'DR/'.date('Y').'/000001';
        }else{
            $tmp = explode('/', $stmt['DRAFT_INV_NO']);
            if(count($tmp) == 0) return 'DR/'.date('Y').'/000001';
            if($tmp[1] !== date('Y')) return 'DR/'.date('Y').'/000001';

            return 'DR/'.date('Y').'/'.substr('000000'.((int)$tmp[2] + 1), -6);
        }
    }
}
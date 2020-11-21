<?php
defined('BASEPATH') OR exit('');

class order_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function loadVinInEirTable(){
    	$this->ceh->distinct();
    	$this->ceh->select('VINNo');
    	$this->ceh->order_by('VINNo');
    	$stmt = $this->ceh->get('ORD_EIR');
    	return $stmt->result_array();
    }

    public function getEirNoList(){
        $this->ceh->distinct();
        $this->ceh->select('EirNo');
        $this->ceh->order_by('EirNo');
        $stmt = $this->ceh->get('ORD_EIR');
        return $stmt->result_array();
    }

    public function getEirNoBulkList(){
        $this->ceh->distinct();
        $this->ceh->select('EirNo');
        $this->ceh->order_by('EirNo');
        $stmt = $this->ceh->get('ORD_EIR_BULK');
        return $stmt->result_array();
    }
    public function saveOrdDelivery($datas, $PaymentTypeID = '', $PayFormID = '', $JobModeID = '', $MethodID = ''){
    	$this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {        	
           	$item['PaymentTypeID'] = $PaymentTypeID;
           	$item['PayFormID'] = $PayFormID;
           	$item['JobModeID'] = $JobModeID;
           	$item['MethodID'] = $MethodID;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];
            $item['CreateTime'] = $item['UpdateTime'];
            
            if ($item['ClassID'] == 1){
                $checkItem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('ClassID', $item['ClassID'])
                                        ->where('VINNo', $item['VINNo'])
                                        ->where('BillOfLading', $item['BillOfLading'])
                                        ->limit(1)
                                        ->get('ORD_EIR')
                                        ->row_array();
            } 
            else{
                $checkItem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('ClassID', $item['ClassID'])
                                        ->where('VINNo', $item['VINNo'])
                                        ->where('BookingNo', $item['BookingNo'])
                                        ->limit(1)
                                        ->get('ORD_EIR')
                                        ->row_array();
            }

            if (count($checkItem) > 0){
                if ($item['ClassID'] == 1){
                    $this->ceh->where('VoyageKey', $checkItem['VoyageKey'])
                                ->where('ClassID', $checkItem['ClassID'])
                                ->where('VINNo', $checkItem['VINNo'])
                                ->where('BillOfLading', $checkItem['BillOfLading'])
                                ->update('ORD_EIR', $item);
                }
                else{
                    $this->ceh->where('VoyageKey', $checkItem['VoyageKey'])
                                ->where('ClassID', $checkItem['ClassID'])
                                ->where('VINNo', $checkItem['VINNo'])
                                ->where('BookingNo', $checkItem['BookingNo'])
                                ->update('ORD_EIR', $item);
                }
            }
            else{
                $this->ceh->insert('ORD_EIR', $item);
            }
           
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            $this->send_mail($item);
            return TRUE;
        }

        return $result;
    }

    public function saveOrdService($datas, $PaymentTypeID = '', $PayFormID = '', $JobModeID = '', $MethodID = '', $ServiceID = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            /*
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }
            */
            
            $item['PaymentTypeID'] = $PaymentTypeID;
            $item['PayFormID'] = $PayFormID;
            $item['JobModeID'] = $JobModeID;
            $item['MethodID'] = $MethodID;
            $item['ServiceID'] = $ServiceID;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];
            $item['CreateTime'] = $item['UpdateTime'];
            
            $this->ceh->insert('ORD_SERVICE', $item);
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

    public function generatePinCode($digits = 8, $pinCodeNumeric = 0){
        $chk = array();
        $pinCodeArr = array();

        for ($i = 0; $i < $pinCodeNumeric; $i++){
            do{
                $nb = rand(1, pow(10, $digits)-1);
                $nb = substr("0000000".$nb, -8);
                $chk    = $this->ceh->select('COUNT(*) as CountID')
                                    ->where('PinCode', $nb)
                                    ->limit(1)
                                    ->get('ORD_EIR')->row_array();

                $chkEir = $this->ceh->select('COUNT(*) as CountID')
                                    ->where('PinCode', $nb)
                                    ->limit(1)
                                    ->get('ORD_EIR_BULK')->row_array();
            }while($chk['CountID'] > 0 && $chkEir['CountID'] > 0);
            $pinCodeArr[$i] = $nb;
        }
        
        return $pinCodeArr;
    }

    public function generatePinCodeBulk($digits = 8, $pinCodeNumeric = 0){
        $chk = array();
        $pinCodeArr = array();

        for ($i = 0; $i < $pinCodeNumeric; $i++){
            do{
                $nb = rand(1, pow(10, $digits)-1);
                $nb = substr("0000000".$nb, -8);
                $chk    = $this->ceh->select('COUNT(*) CountID')
                                    ->where('PinCode', $nb)
                                    ->limit(1)
                                    ->get('ORD_EIR_BULK')->row_array();

                $chkEir = $this->ceh->select('COUNT(*) CountID')
                                    ->where('PinCode', $nb)
                                    ->limit(1)
                                    ->get('ORD_EIR')->row_array();
            }while($chk['CountID'] > 0 && $chkEir['CountID'] > 0);
            $pinCodeArr[$i] = $nb;
        }
        
        return $pinCodeArr;
    }

    public function updateStockData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $this->ceh->where('VoyageKey', $item['VoyageKey'])
                    ->where('ClassID', $item['ClassID'])
                    ->where('VINNo', $item['VINNo']);

            if ($item['ClassID'] == 1){
                $this->ceh->where('BillOfLading', $item['BillOfLading']);
            }
            else if ($item['ClassID'] == 2){
                $this->ceh->where('BookingNo', $item['BookingNo']);
            }

            $this->ceh->update('DT_STOCK', $item);
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

    public function loadEirListForGate($PINCodeOREirNo = '', $VINNo = ''){
        $this->ceh->select('B.rowguid as rowguid, A.VoyageKey as VoyageKey, A.EirNo as EirNo, A.PinCode as PinCode, A.ClassID as ClassID, A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, IssueDate, ExpDate, A.CarWeight as CarWeight, B.Remark as Remark, B.IsLocalForeign as IsLocalForeign, A.VINNo as VINNo, B.Block as Block, B.Bay as Bay, B.Row as Row, B.Tier as Tier, B.Area as Area, C.BrandID as BrandID, BrandName, C.CarTypeID as CarTypeID, CarTypeName, A.JobModeID as JobModeID,  A.MethodID as MethodID, ETB, ETD, C.POD as POD, C.FPOD as FPOD, B.TransitID as TransitID, ShipperName, F.InboundVoyage as InboundVoyage, F.OutboundVoyage as OutboundVoyage, F.VesselName as VesselName, A.CusTypeID as CusTypeID, A.CusID as CusID, A.PaymentTypeID as PaymentTypeID, A.InvNo as InvNo, A.InvDraftNo as InvDraftNo, C.KeyNo as KeyNo, C.Sequence as Sequence, TruckNumber, A.FinishDate as FinishDate, G.Sequence as GateSequence');

        if ($PINCodeOREirNo != ''){
            $this->ceh->where('A.PinCode', $PINCodeOREirNo)->or_where('A.EirNo', $PINCodeOREirNo);
        }

        if ($VINNo != ''){
            $this->ceh->where('A.VINNo', $VINNo);
        }

        $this->ceh->join('DT_STOCK B', 'A.VoyageKey = B.VoyageKey and A.VINNo = B.VINNo');
        $this->ceh->join('DT_MANIFEST C', 'B.VoyageKey = C.VoyageKey and B.VINNo = C.VINNo and (B.BillOfLading = C.BillOfLading or B.BookingNo = C.BookingNo)');
        $this->ceh->join('BS_CAR_BRAND D', 'C.BrandID = D.BrandID', 'left');
        $this->ceh->join('BS_CAR_TYPE E', 'C.CarTypeID = E.CarTypeID', 'left');
        $this->ceh->join('DT_VESSEL_VISIT F', 'A.VoyageKey = F.VoyageKey');
        $this->ceh->join('JOB_GATE G', 'A.VINNo = G.VINNo', 'left');

        $this->ceh->order_by('A.EirNo');
        $stmt = $this->ceh->get('ORD_EIR A');
        return $stmt->result_array();
    }

    public function loadEirBulkListForGate($PINCodeOREirNo = ''){
        $this->ceh->select('D.rowguid as rowguid, A.VoyageKey as VoyageKey, A.EirNo as EirNo, A.PinCode as PinCode, A.ClassID as ClassID, A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.CargoWeight as CargoWeight, A.POL as POL, A.POD as POD, A.FPOD as FPOD, VesselName, B.InboundVoyage as InboundVoyage, B.OutboundVoyage as OutboundVoyage, ETB, ETD, A.InvNo as InvNo, A.JobModeID as JobModeID,  A.MethodID as MethodID, IssueDate, ExpDate, D.TransitID as TransitID, ShipperName, D.IsLocalForeign as IsLocalForeign, A.PaymentTypeID as PaymentTypeID, A.InvNo as InvNo, A.InvDraftNo as InvDraftNo, A.CusTypeID as CusTypeID, A.CusID as CusID, A.FinishDate as FinishDate, A.UnitID as UnitID, A.ClassID');

        if ($PINCodeOREirNo != ''){
            $this->ceh->where('A.PinCode', $PINCodeOREirNo)->or_where('A.EirNo', $PINCodeOREirNo);
        }

        $this->ceh->join('DT_VESSEL_VISIT B', 'A.VoyageKey = B.VoyageKey');
        $this->ceh->join('DT_MNF_LD_BULK C', 'A.VoyageKey = C.VoyageKey and (A.BillOfLading = C.BillOfLading or A.BookingNo = C.BookingNo)', 'left');
        $this->ceh->join('DT_STOCK_BULK D', 'A.VoyageKey = D.VoyageKey and  (A.BillOfLading = D.BillOfLading or A.BookingNo = D.BookingNo)');
        //$this->ceh->join('JOB_GATE E', 'A.EirNo = E.EirNo and (A.BillOfLading = E.BillOfLading OR A.BookingNo = E.BookingNo) and E.StockRef = D.rowguid');

        $this->ceh->order_by('A.EirNo');
        $stmt = $this->ceh->get('ORD_EIR_BULK A');
        
        return $stmt->result_array();
    }

    public function saveGateData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];
            $item['CreateTime'] = $item['UpdateTime'];
            
            $checkExist = $this->ceh->limit(1)
                                ->where('StockRef', $item['StockRef'])
                                ->where('TruckNumber', $item['TruckNumber'])
                                ->where('FinishDate is NULL')
                                ->get('JOB_GATE')
                                ->row_array();

            $checkSeq = $this->ceh->limit(1)
                                ->select('max(Sequence) as maxSequence')
                                ->where('EirNo', $item['EirNo'])
                                ->get('JOB_GATE')
                                ->row_array();

            if (count($checkExist) > 0){
                $item['Sequence'] =  $checkExist['Sequence'];
                $this->ceh->where('StockRef', $checkExist['StockRef'])
                        ->where('TruckNumber', $item['TruckNumber'])
                        ->update('JOB_GATE', $item);
            }
            else{
                $item['Sequence'] = 1;
                if (intval(@$checkSeq['maxSequence']) > 0){
                    $item['Sequence'] = $checkSeq['maxSequence'] + 1;
                }

                $this->ceh->insert('JOB_GATE', $item);    
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

    public function saveYardData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];
            $item['CreateTime'] = $item['UpdateTime'];
            
            $checkExist = $this->ceh->limit(1)->where('StockRef', $item['StockRef'])
                                                ->where('JobTypeID', $item['JobTypeID'])
                                                ->get("JOB_YARD")->row_array();

            if (count($checkExist) > 0){
                $this->ceh->where('StockRef', $checkExist['StockRef'])->where('JobTypeID', $checkExist['JobTypeID'])->update('JOB_YARD', $item);
            }
            else{
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

    public function updateORDEir($EirNo = '', $FinishDate = '', $rowguid = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('EirNo', $EirNo)->where('rowguid', $rowguid)->set('FinishDate', $FinishDate)->update('ORD_EIR');

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

    public function updateORDBulk($EirNo = '', $FinishDate = '', $rowguid = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->where('EirNo', $EirNo)->where('rowguid', $rowguid)->set('FinishDate', $FinishDate)->update('ORD_EIR_BULK');

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

    public function loadGateList(){
        $this->ceh->select('A.VINNo as VINNo, A.JobTypeID as JobTypeID, A.JobModeID as JobModeID, TruckNumber, VMStatus, A.StockRef as StockRef, B.BillOfLading as BillOfLading, B.BookingNo as BookingNo, A.EirNo as EirNo, A.Sequence as Sequence');
        $this->ceh->join('DT_STOCK B', 'A.StockRef = B.rowguid');
        $this->ceh->order_by('A.VINNo');
        $stmt = $this->ceh->get('JOB_GATE A');
        return $stmt->result_array();
    }

    public function loadGateBulkList($BillOfLadingORBookingNo = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        $this->ceh->select('A.TruckNumber as TruckNumber, A.VINNo as VINNo, A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.EirNo as EirNo, A.StockRef as StockRef, JobModeID, A.Sequence as Sequence');

        if ($BillOfLadingORBookingNo != ''){
            $this->ceh->where('A.BillOfLading', $BillOfLadingORBookingNo)->or_where('A.BookingNo', $BillOfLadingORBookingNo);
        }

        $this->ceh->where("substring(A.EirNo, 0, 2) = 'B'");
        $this->ceh->where('A.FinishDate is  NULL', NULL, false);

        $this->ceh->join('JOB_QUAY B', 'A.EirNo = B.EirNo and A.Sequence = B.Sequence and A.TruckNumber = B.TruckNumber and B.FinishDate is NOT NULL');

        $this->ceh->order_by('A.EirNo');

        $stmt = $this->ceh->get('JOB_GATE A');

        return $stmt->result_array();

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

    public function loadGateBulkListWithBL(){
        $this->ceh->where('JobModeID', 'LAYN');
        $this->ceh->where('MethodID', 'BAI-XE');
        $this->ceh->where('BillOfLading is NOT NULL');
        $this->ceh->where('CargoType', 'B');

        $stmt = $this->ceh->get('JOB_GATE');

        return $stmt->result_array();

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

    public function updateGateData($StockRef = '', $VINNo = '', $GateOutID = '', $FinishDate = '', $Remark = '', $PINCodeOREirNo = '', $TruckNumber = '', $Sequence = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        if ($StockRef != ''){
            $this->ceh->where('StockRef', $StockRef);
        }
        
        if ($VINNo != ''){
            $this->ceh->where('VINNo', $VINNo);
        }

        if ($PINCodeOREirNo != ''){
            $this->ceh->where('EirNo', $PINCodeOREirNo);
        }

        if ($TruckNumber != ''){
            $this->ceh->where('TruckNumber', $TruckNumber);
        }

        if ($Sequence != ''){
            $this->ceh->where('Sequence', $Sequence);
        }

        $this->ceh->set('GateOutID', $GateOutID)
                    ->set('FinishDate', $FinishDate)
                    ->set('Remark', $Remark)
                    ->update('JOB_GATE');

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

    public function loadQuayListForReport($StartDate = '', $FinishDate = ''){
        if ($StartDate){
            $this->ceh->where("FinishDate >=", $StartDate);
        }

        if ($FinishDate != '*'){
            $this->ceh->where("FinishDate <=", $FinishDate);
        }

        $this->ceh->order_by('VINNo');
        $stmt = $this->ceh->get('JOB_QUAY');
        return $stmt->result_array();
    }

    public function loadGateListForReport($StartDate = '', $FinishDate = ''){
        if ($StartDate){
            $this->ceh->where("FinishDate >=", $StartDate);
        }

        if ($FinishDate != '*'){
            $this->ceh->where("FinishDate <=", $FinishDate);
        }

        $this->ceh->order_by('VINNo');
        $stmt = $this->ceh->get('JOB_GATE');
        return $stmt->result_array();
    }

	public function send_mail($item){
        $this->load->library('qrmaker');
        $this->load->library('Email');
        $ORDER=$item;
        if(is_array($ORDER) && count($ORDER)>0){
            $pinCode = $ORDER['PinCode'];
            $orderNo = $ORDER['EirNo'];
            $invContent = "<li><b>Số Lệnh : $orderNo</b></li>";
            
            $printOrderUrl = $this->config->base_url()."index.php/".md5("BaoCao")."/".md5("Order")."/".$pinCode;
            $table="";
            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => "smtp.gmail.com",
                'smtp_port' => 587,
                'smtp_user' => 'doanvanhieu.info@gmail.com',
                'smtp_pass' => 'matkhaumoi',
                'charset' => 'utf-8',
                'smtp_crypto' => 'tls',
                'wordwrap' => TRUE,
                'crlf' => "\r\n",
                'newline' => "\r\n",
                'mailtype'=>'html'
            );

            $this->email->initialize($config);
            $this->email->clear(TRUE);
            $this->email->SMTPDebug = 0;
            $this->email->CharSet = 'UTF-8';
            $this->email->Debugoutput = 'html';
            $this->email->SMTPAuth = true;
            $this->email->SMTPSecure = 'tls';
            $this->email->Host = "smtp.gmail.com";
            $this->email->Port = 587;
            $this->email->from( 'doanvanhieu.info@gmail.com', "RORO Mail Center" );
            $this->email->to( $item['Email'] );
            $this->email->subject('[Thông báo] Xác nhận lệnh hạ hàng!');

            $pngAbsoluteFilePath = FCPATH."assets/img/qrcode_gen/".$pinCode.".png";
            $this->qrmaker->make_png($printOrderUrl,$pngAbsoluteFilePath);
            $embedQRCode = "";
            if( file_exists( $pngAbsoluteFilePath ) ){
                $this->email->attach($pngAbsoluteFilePath);

                $cid = $this->email->attachment_cid( $pngAbsoluteFilePath );

                if( $cid !== FALSE ){
                    $embedQRCode = '<img style="width:95px;height:95px" src="cid:'.$cid.'" alt="'.$pinCode.'" />';
                }
            }

            if ($ORDER['ClassID'] == 1){
                $classType = 'lệnh nhập hàng';
                $color = 'green';
            }
            else{
                $classType = 'lệnh hạ hàng';
                $color = '#f10f0f';
            }

            $mailContent = <<<EOT

            <body>
            <div style="padding: 40px;">
            <div style="background-color: $color;border-top-left-radius:4px;border-top-right-radius:4px;height:60px;padding-top:30px">
            <span style="margin-top:20px;margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff">Xác nhận $classType</span>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px">
            <b>Kính gửi: Quý khách hàng</b>
            <br>
            <span>Thông tin $classType của quý khách như sau: </span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
            <ul style="margin-left:25px;list-style:disc;">
            <li>Số PIN: <b>$pinCode</b></li>
            $invContent                                
            </ul>
            
            <div style="margin:auto;padding-top:10px">
            $embedQRCode
            </div>
            </div>
            $table
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <br>
            <span>Để tra cứu thông tin lệnh, Quý khách vui lòng nhấn nút:</span>
            <br><br>
            <div style="display:inline-flex">
            <a href="$printOrderUrl" style="margin-right:20px;font-family:Tahoma,serif;background-color:#ff9600;color:#ffffff;font-weight:500;padding:10px 50px 10px 50px;border-radius:4px;border-style:none;text-decoration:none" target="_blank" >TRA CỨU LỆNH</a>
            </div>
            </div>
            <div style="padding:30px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px;">
            <span>Trân trọng!</span>
            <br>
            <span><b>CTY CEH</b></span>
            </div>
            </div>
            </div>
            </body>
EOT;
            $this->email->message($mailContent);
            return $this->email->send() ? 'sent' : $this->email->print_debugger();
        }
    }
    
    public function saveOrdBulk($datas, $PaymentTypeID = '', $PayFormID = '', $JobModeID = '', $MethodID = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {         
            $item['PaymentTypeID'] = $PaymentTypeID;
            $item['PayFormID'] = $PayFormID;
            $item['JobModeID'] = $JobModeID;
            $item['MethodID'] = $MethodID;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];
            $item['CreateTime'] = $item['UpdateTime'];
            
            if ($item['ClassID'] == 1){
                $checkItem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('ClassID', $item['ClassID'])
                                        ->where('BillOfLading', $item['BillOfLading'])
                                        ->limit(1)
                                        ->get('ORD_EIR_BULK')
                                        ->row_array();
            } 
            else{
                $checkItem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('ClassID', $item['ClassID'])
                                        ->where('BookingNo', $item['BookingNo'])
                                        ->limit(1)
                                        ->get('ORD_EIR_BULK')
                                        ->row_array();
            }

            if (count($checkItem) > 0){
                if ($item['ClassID'] == 1){
                    $this->ceh->where('VoyageKey', $checkItem['VoyageKey'])
                                ->where('ClassID', $checkItem['ClassID'])
                                ->where('BillOfLading', $checkItem['BillOfLading'])
                                ->update('ORD_EIR_BULK', $item);
                }
                else{
                    $this->ceh->where('VoyageKey', $checkItem['VoyageKey'])
                                ->where('ClassID', $checkItem['ClassID'])
                                ->where('BookingNo', $checkItem['BookingNo'])
                                ->update('ORD_EIR_BULK', $item);
                }
            }
            else{
                $this->ceh->insert('ORD_EIR_BULK', $item);
            }
           
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            $this->send_mail($item);
            return TRUE;
        }

        return $result;
    }

    public function loadJobGateList($TruckNumber = ''){
        if ($TruckNumber != ''){
            $this->ceh->where('TruckNumber', $TruckNumber);
        }
        
        $stmt = $this->ceh->get('JOB_GATE');
        return $stmt->result_array();
    }

    public function getRemainCargoWeight($TruckNumber = ''){
        $eirNo = ($this->ceh->select('EirNo')->where('TruckNumber', $TruckNumber)->limit(1)->get('JOB_GATE')->row_array())['EirNo'];

        $gateSequence = $this->ceh->where('EirNo', $eirNo)
                                    ->where('TruckNumber', $TruckNumber)
                                    ->where('FinishDate is NULL')                                   
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

        $sequence = 0;
        if (count($gateSequence) > 0){
            $sequence = $gateSequence['Sequence'];
        }

        $checkCurrentSumCargoWeight = $this->ceh->select('sum(CargoWeight) as currentSumCargoWeight')
                                    ->where('A.EirNo', $eirNo)
                                    ->where('A.EirNo = B.EirNo')
                                    ->where('A.Sequence = B.Sequence')
                                    ->where('A.TruckNumber = B.TruckNumber')
                                    ->where('B.FinishDate is NOT NULL')                                   
                                    ->limit(1)                                    
                                    ->get('BS_TRUCK_WEIGHT A, JOB_GATE B')
                                    ->row_array()['currentSumCargoWeight'];
        
        $currentSumCargoWeight = 0;                  
        if (intval(@$checkCurrentSumCargoWeight) > 0){
            $currentSumCargoWeight = $checkCurrentSumCargoWeight;
        }

        $sumCargoWeight = ($this->ceh->select('CargoWeight')
                                    ->where('EirNo', $eirNo)
                                    ->limit(1)
                                    ->get('ORD_EIR_BULK')
                                    ->row_array())['CargoWeight'];

        return ($sumCargoWeight - $currentSumCargoWeight);
    }

    public function getTwoScalesBefByTruckNo($TruckNumber = ''){
        $secondWeightScale = $this->ceh->where('TruckNumber', $TruckNumber)
                                    ->where('FirstWeightScale is NOT NULL')
                                    ->where('SecondWeightScale is NOT NULL')
                                    ->get('BS_TRUCK_WEIGHT')
                                    ->row_array();

        if (count($secondWeightScale) > 0){
            return $secondWeightScale['SecondWeightScale'];
        } 
        else{
            return -1;
        }
    }

    public function checkTruckInQueue($TruckNumber = ''){
        $checkTruckInQueue = $this->ceh->where('TruckNumber', $TruckNumber)
                                    ->where('StartDate is NOT NULL')
                                    ->where('FinishDate is NULL')
                                    ->get('JOB_GATE')
                                    ->row_array();

        if (count($checkTruckInQueue) > 0){
            return 1;
        }
        else{
            return 0;
        }
    }
}
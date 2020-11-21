<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public $data;
    private $ceh;

    function __construct() {
        parent::__construct();

        $this->load->helper(array('form','url'));
        $this->load->model("report_model", "mdlRpt");
        $this->load->model("user_model", "user");

        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function checkAndRedirectURL(){
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
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

    public function getVesselReportForBoth(){
        $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
        $InboundVoyage = $this->input->post('InboundVoyage') ? $this->input->post('InboundVoyage') : '';
        $OutboundVoyage = $this->input->post('OutboundVoyage') ? $this->input->post('OutboundVoyage') : '';
        $ClassID = 1;
        $result = array();
        $haveNoData = true;

        $dataIn = $this->ceh->select("V.VesselName, V.InboundVoyage, V.OutboundVoyage, S.CargoWeight, S.BillOfLading, S.BookingNo, S.ClassID, S.JobModeInID, O.DateIn, O.Sequence, O.CargoWeightGetIn, S.UnitID as UnitID_I, O.UnitID as UnitID_O")
                ->where('S.VoyageKey', $VoyageKey)
                ->where('S.ClassID', $ClassID."")
                ->where('V.InboundVoyage', $InboundVoyage)
                ->where('V.OutboundVoyage', $OutboundVoyage)
                ->where('S.BookingNo is NULL')
                ->where('O.EirNo is NULL')
                ->where('O.Sequence is NOT NULL')
                ->join('DT_STOCKIN_BULK O','S.rowguid = O.StockRef AND O.DateIn IS NOT NULL')
                ->join('DT_VESSEL_VISIT V','S.VoyageKey = V.VoyageKey')
                ->order_by('S.BillOfLading, S.BookingNo, O.DateIn')
                ->get('DT_STOCK_BULK S')
                ->result_array();

        if(is_array($dataIn) && count($dataIn)>0){
            $haveNoData = false;

            $totalIn = array();
            foreach ($dataIn as $key => $value) {
               $totalIn[$value['BillOfLading'].$value['BookingNo']]=floatval(@$totalIn[$value['BillOfLading'].$value['BookingNo']])+floatval(@$value['CargoWeightGetIn']);
            }

            $result['dataInList'] = $dataIn;
            $result['totalIn'] = $totalIn;
        }

        $ClassID = 2;

        $dataOut = $this->ceh->select("V.VesselName, V.InboundVoyage, V.OutboundVoyage, S.CargoWeight, S.BillOfLading, S.BookingNo, S.ClassID, S.JobModeOutID as JobModeOutID, O.DateOut as DateOut, O.Sequence as Sequence, O.CargoWeightGetOut as CargoWeightGetOut, S.UnitID as UnitID_I, O.UnitID as UnitID_O, O.RemainCargoWeight")
                ->where('S.VoyageKey', $VoyageKey)
                ->where('S.ClassID', $ClassID."")
                ->where('V.InboundVoyage', $InboundVoyage)
                ->where('V.OutboundVoyage', $OutboundVoyage)
                ->join('DT_STOCKOUT_BULK O','S.rowguid = O.StockRef AND O.DateOut IS NOT NULL')
                ->join('DT_VESSEL_VISIT V','S.VoyageKey = V.VoyageKey')
                ->order_by('S.BillOfLading, S.BookingNo, O.DateOut')
                ->get('DT_STOCK_BULK S')
                ->result_array();

        if(is_array($dataOut) && count($dataOut)>0){
            $haveNoData = false;

            $totalOut = array();
            foreach ($dataOut as $key => $value) {
               $totalOut[$value['BillOfLading'].$value['BookingNo']]=floatval(@$totalOut[$value['BillOfLading'].$value['BookingNo']])+floatval(@$value['CargoWeightGetIn']);
            }

            $result['dataOutList'] = $dataOut;
            $result['totalOut'] = $totalOut;
        }
        
        if (!$haveNoData){
            echo json_encode($result);
        }
        else{
            echo '{"deny":"Không có dữ liệu tàu: '.$VoyageKey.'!"}';
        }
    }

    public function getVesselReportForIn(){
        $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
        $ClassID = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';
        $ClassID = intval($ClassID);
        $InboundVoyage= $this->input->post('InboundVoyage') ? $this->input->post('InboundVoyage') : '';
        $OutboundVoyage= $this->input->post('OutboundVoyage') ? $this->input->post('OutboundVoyage') : '';

        $this->ceh->select("V.VesselName, V.InboundVoyage, V.OutboundVoyage, S.CargoWeight, S.BillOfLading, S.BookingNo, S.ClassID, S.JobModeInID, O.DateIn, O.Sequence, O.CargoWeightGetIn, S.UnitID as UnitID_I, O.UnitID as UnitID_O");
        
        $this->ceh->where('S.VoyageKey', $VoyageKey);
        $this->ceh->where('S.ClassID', $ClassID."");
        $this->ceh->where('V.InboundVoyage', $InboundVoyage);
        $this->ceh->where('V.OutboundVoyage', $OutboundVoyage);
        $this->ceh->where('S.BookingNo is NULL');
        $this->ceh->where('O.EirNo is NULL');
        $this->ceh->where('O.Sequence is NOT NULL');

        $this->ceh->join('DT_STOCKIN_BULK O','S.rowguid = O.StockRef AND O.DateIn IS NOT NULL','left');
        $this->ceh->join('DT_VESSEL_VISIT V','S.VoyageKey = V.VoyageKey','left');
        $stmt = $this->ceh->order_by('S.BillOfLading, S.BookingNo, O.DateIn')->get('DT_STOCK_BULK S');

        $data = $stmt->result_array();

        if(is_array($data) && count($data)>0)
        {
            $data2 = array();
            foreach ($data as $key => $value) {
               $data2[$value['BillOfLading'].$value['BookingNo']]=floatval(@$data2[$value['BillOfLading'].$value['BookingNo']])+floatval(@$value['CargoWeightGetIn']);
           }

           $result = array();
           $result['list'] = $data;
           $result['total'] = $data2;
           echo json_encode($result);
        }
        else{
            echo '{"deny":"Không có dữ liệu tàu: '.$VoyageKey.'!"}';
        }

        exit;
    }

    public function getVesselReportForOut(){
        $VoyageKey = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
        $ClassID = $this->input->post('ClassID') ? $this->input->post('ClassID') : '';
        $ClassID=intval($ClassID);
        $InboundVoyage= $this->input->post('InboundVoyage') ? $this->input->post('InboundVoyage') : '';
        $OutboundVoyage= $this->input->post('OutboundVoyage') ? $this->input->post('OutboundVoyage') : '';
        $this->ceh->select("V.VesselName,V.InboundVoyage,V.OutboundVoyage,S.CargoWeight,S.BillOfLading,S.BookingNo,S.ClassID,S.JobModeOutID,O.DateOut,O.Sequence,O.CargoWeightGetOut,S.UnitID as UnitID_I,O.UnitID as UnitID_O,O.RemainCargoWeight");
        $this->ceh->where('S.VoyageKey',$VoyageKey);
        $this->ceh->where('S.ClassID',$ClassID."");
        $this->ceh->where('V.InboundVoyage',$InboundVoyage);
        $this->ceh->where('V.OutboundVoyage',$OutboundVoyage);

        $this->ceh->join('DT_STOCKOUT_BULK O','S.rowguid = O.StockRef AND O.DateOut IS NOT NULL');
        $this->ceh->join('DT_VESSEL_VISIT V','S.VoyageKey = V.VoyageKey');
        $smt=$this->ceh->order_by('S.BillOfLading,S.BookingNo,O.DateOut')->get('DT_STOCK_BULK S');

        $data=$smt->result_array();

        if(is_array($data) && count($data)>0)
        {
            $data2=array();
            foreach ($data as $key => $value) {
               $data2[$value['BillOfLading'].$value['BookingNo']]=floatval(@$data2[$value['BillOfLading'].$value['BookingNo']])+floatval(@$value['CargoWeightGetOut']);
           }
           $result=array();
           $result['list']=$data;
           $result['total']=$data2;
           echo json_encode($result);
        }
        else{
            echo '{"deny":"Không có dữ liệu tàu: '.$VoyageKey.'!"}';
        }

        exit;
    }   

    public function get_BaoCao_xe(){
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->data['menus'] = $this->menu->getMenu();

        $TIMEIN= $this->input->post('TIMEIN') ? $this->input->post('TIMEIN') : '';
        $TIMEOUT= $this->input->post('TIMEOUT') ? $this->input->post('TIMEOUT') : '';
        $TIMEIN=date('Y-m-d',strtotime(str_replace('/', '-', $TIMEIN))).' 00:00:00';
        $TIMEOUT=date('Y-m-d',strtotime(str_replace('/', '-', $TIMEOUT))).' 23:59:59';
        $this->ceh->select("G.EirNo,G.BillOfLading,G.BookingNo,T.Sequence,G.TruckNumber,T.TruckWeight,T.CargoWeight,G.StartDate, G.FinishDate, ClassID");
        $this->ceh->join('BS_TRUCK_WEIGHT as T','T.EirNo =g.EirNo and T.TruckNumber = G.TruckNumber and T.Sequence = G.Sequence','left');
        $this->ceh->where('G.FinishDate>=',$TIMEIN);
        $this->ceh->where('G.FinishDate<=',$TIMEOUT);
        $this->ceh->where('T.Sequence is not null');
        $smt=$this->ceh->order_by('T.Sequence')->get('JOB_GATE As G');

       // print_r($smt);die();
        $data=$smt->result_array();
        if(is_array($data) && count($data)>0)
        {
            echo json_encode($data);
        }
        else{
            echo '{"deny":"Không có dữ liệu xe nào !"}';
        }
    }

    public function BaoCao_tau(){
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->data['menus'] = $this->menu->getMenu();

        $action = $this->input->post('action') ? $this->input->post('action') : '';

        if($action == 'view'){
            $child_action = $this->input->post('child_action') ? $this->input->post('child_action') :  '';

            if ($child_action == 'sendMailByAdmin'){
                $Email      = $this->input->post('Email') ? $this->input->post('Email') : array();
                $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $VesselName = $this->input->post('VesselName') ? $this->input->post('VesselName') : '';
                $ReportURL  = $this->input->post('ReportURL') ? $this->input->post('ReportURL') : '';
                $ConfirmURL  = $this->input->post('ConfirmURL') ? $this->input->post('ConfirmURL') : '';

                $this->data['result'] = $this->mdlRpt->sendConfirmMail($Email, $VoyageKey, $VesselName, $ReportURL, $ConfirmURL);
                echo json_encode($this->data);
                exit;
            }

            if ($child_action == 'sendMailAfterConfirm'){
                $Email      = $this->input->post('Email') ? $this->input->post('Email') : array();
                $VoyageKey  = $this->input->post('VoyageKey') ? $this->input->post('VoyageKey') : '';
                $VesselName = $this->input->post('VesselName') ? $this->input->post('VesselName') : '';
                $ReportURL  = $this->input->post('ReportURL') ? $this->input->post('ReportURL') : '';

                $this->data['result'] = $this->mdlRpt->sendMailAfterConfirm($Email, $VoyageKey, $VesselName, $ReportURL);
                echo json_encode($this->data);
                exit;
            }
        }

        $this->data['title'] = 'Báo cáo tàu';
        $this->load->view('header', $this->data);
        $this->data['GroupID'] = $this->session->userdata("GroupID");
        $this->data['portsEmployeeEmailList'] = $this->mdlRpt->loadPortEmployeeEmailList();
        $this->data['vesselOwnerEmailList'] = $this->mdlRpt->loadVesselOwnerEmailList();
        $this->load->view('report/voyage', $this->data);
        $this->load->view('footer');   
    }

    public function BaoCao_xe(){
        if(empty($this->session->userdata('UserID'))) {
            redirect(md5('user') . '/' . md5('login'));
        }
        $this->data['menus'] = $this->menu->getMenu();

        $this->data['title'] = 'Báo cáo xe';
        $this->load->view('header', $this->data);
        $this->load->view('report/car', $this->data);
        $this->load->view('footer');   
    }


    public function rptRevenue(){
        $access = $this->user->access('rptRevenue');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $todate = $this->input->post('todate') ? $this->input->post('todate') : '';
            $sysname = $this->input->post('sysname') ? $this->input->post('sysname') : array();
            $jmode = $this->input->post('jmode') ? $this->input->post('jmode') : '';

            $this->data['results'] = $this->mdlRpt->rptRevenue($fromdate, $todate, $sysname, $jmode);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Tổng hợp doanh thu";

        $this->load->view('header', $this->data);
        $this->load->view('report/revenue', $this->data);
        $this->load->view('footer');
    }

    public function rptReleasedInv(){
        $access = $this->user->access('rptReleasedInv');
        if($access === false) {
            show_404();
        }

        if(strlen($access) > 5) {
            $this->data['deny'] = $access;
            echo json_encode($this->data);
            exit;
        }

        $action = $this->input->post('action') ? $this->input->post('action') : '';
        if($action == "view"){
            $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
            $todate = $this->input->post('todate') ? $this->input->post('todate') : '';
            $sysname = $this->input->post('sysname') ? $this->input->post('sysname') : '';
            $jmode = $this->input->post('jmode') ? $this->input->post('jmode') : '';

            $this->data['results'] = $this->mdlRpt->rptReleasedInv($fromdate, $todate, $sysname, $jmode);
            echo json_encode($this->data);
            exit;
        }

        $this->data['title'] = "Báo cáo phát hành hóa đơn";

        $this->load->view('header', $this->data);
        $this->load->view('report/releasedInv', $this->data);
        $this->load->view('footer');
    }

    public function export_revenue() {
        $datajson = $this->input->post('exportdata') ? $this->input->post('exportdata') : '';
        $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
        $todate = $this->input->post('todate') ? $this->input->post('todate') : '';

        $args = json_decode($datajson, true);

        $this->load->library('excel');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
        ob_end_clean();

        $this->excel->getDefaultStyle()->getFont()->setName('Times New Roman');
        $this->excel->getDefaultStyle()->getFont()->setSize(12);

        $objSheet0 = $this->excel->getActiveSheet();

            //row header
        $objSheet0->mergeCells('B2:K2');
        $objSheet0->getStyle('B2:K2')->getFont()->setBold(true)->setSize(20);
        $objSheet0->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            , 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getCell('B2')->setValue("BÁO CÁO PHÁT HÀNH HÓA ĐƠN");
        $objSheet0->getRowDimension('2')->setRowHeight(35);
        $objSheet0->getStyle('B')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));


    //        //tu ngay, den ngay
        $objSheet0->getStyle('C4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('C4')->setValue("Từ Ngày");
        $objSheet0->getStyle('C4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('D4:E4');
        $objSheet0->getStyle('D4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('D4')->setValue($fromdate);
        $objSheet0->getStyle('D4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('F4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('F4')->setValue("Đến Ngày");
        $objSheet0->getStyle('F4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('G4:H4');
        $objSheet0->getStyle('G4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('G4')->setValue($todate);
        $objSheet0->getStyle('G4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getRowDimension('4')->setRowHeight(25);

    //      sheet name
        $objSheet0->setTitle('Issued Invoice');
    //
    //        //header
        $objSheet0->getStyle('B6:J6')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('B6:J6')->getFont()->setBold(true)->setSize(12);
        $objSheet0->getStyle('B6:J6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDDCEF'))));

        $objSheet0->getCell('B6')->setValue('STT');
        $objSheet0->getCell('C6')->setValue('SỐ PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('D6')->setValue('NGÀY PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('E6')->setValue('QUYỂN HÓA ĐƠN');
        $objSheet0->getCell('F6')->setValue('SỐ HÓA ĐƠN');
        $objSheet0->getCell('G6')->setValue('NGÀY HÓA ĐƠN');
        $objSheet0->getCell('H6')->setValue('THÀNH TIỀN');
        $objSheet0->getCell('I6')->setValue('THUẾ VAT');
        $objSheet0->getCell('J6')->setValue('TỔNG TIỀN');
        $objSheet0->getRowDimension('6')->setRowHeight(50);

        $a=6;
        $grID = ""; $j = 0;
        if($args === null) goto xxx;
        foreach($args as $arg) {
            $a++;
            $j++;
            $objSheet0->getCell('B' . $a)->setValue($j);
            $objSheet0->getCell('C' . $a)->setValue($arg['DRAFT_INV_NO']);
            $objSheet0->getCell('D' . $a)->setValue($arg['DRAFT_INV_DATE']);
            $objSheet0->getCell('E' . $a)->setValue($arg['INV_PREFIX']);
            $objSheet0->getCell('F' . $a)->setValue($arg['INV_NO']);
            $objSheet0->getCell('G' . $a)->setValue($arg['INV_DATE']);
            $objSheet0->getCell('H' . $a)->setValue($arg['AMOUNT']);
            $objSheet0->getCell('I' . $a)->setValue($arg['VAT']);
            $objSheet0->getCell('J' . $a)->setValue($arg['TAMOUNT']);
            $objSheet0->getRowDimension($a)->setRowHeight(20);
        }

        xxx:
    //        $objSheet0->getStyle('C9:C' . $a)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* ""_);_(@_)');

        $objSheet0->getStyle('B6:K' . $a)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '9EBAE0')))));

        $objSheet0->getColumnDimension('B')->setWidth(6);
        $objSheet0->getColumnDimension('C')->setWidth(40);
        $objSheet0->getColumnDimension('D')->setWidth(12);
        $objSheet0->getColumnDimension('E')->setWidth(12);
        $objSheet0->getColumnDimension('F')->setWidth(12);
        $objSheet0->getColumnDimension('G')->setWidth(12);
        $objSheet0->getColumnDimension('H')->setWidth(12);
        $objSheet0->getColumnDimension('I')->setWidth(12);
        $objSheet0->getColumnDimension('J')->setWidth(12);
        $objSheet0->getColumnDimension('K')->setWidth(12);
        $objSheet0->setShowGridlines(false);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ThongKeSanLuong.xls"');
        $objWriter->save('php://output');
    }

    public function export_releaseInv() {
        $datajson = $this->input->post('exportdata') ? $this->input->post('exportdata') : '';
        $fromdate = $this->input->post('fromdate') ? $this->input->post('fromdate') : '';
        $todate = $this->input->post('todate') ? $this->input->post('todate') : '';

        $args = json_decode($datajson, true);

        $this->load->library('excel');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
        ob_end_clean();

        $this->excel->getDefaultStyle()->getFont()->setName('Times New Roman');
        $this->excel->getDefaultStyle()->getFont()->setSize(12);

        $objSheet0 = $this->excel->getActiveSheet();

            //row header
        $objSheet0->mergeCells('B2:K2');
        $objSheet0->getStyle('B2:K2')->getFont()->setBold(true)->setSize(20);
        $objSheet0->getStyle('B2')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            , 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getCell('B2')->setValue("BÁO CÁO PHÁT HÀNH HÓA ĐƠN");
        $objSheet0->getRowDimension('2')->setRowHeight(35);
        $objSheet0->getStyle('B')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));


    //        //tu ngay, den ngay
        $objSheet0->getStyle('C4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('C4')->setValue("Từ Ngày");
        $objSheet0->getStyle('C4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('D4:E4');
        $objSheet0->getStyle('D4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('D4')->setValue($fromdate);
        $objSheet0->getStyle('D4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('F4')->getFont()->setSize(13)->setUnderline(true);
        $objSheet0->getCell('F4')->setValue("Đến Ngày");
        $objSheet0->getStyle('F4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->mergeCells('G4:H4');
        $objSheet0->getStyle('G4')->getFont()->setBold(true)->setSize(13);
        $objSheet0->getCell('G4')->setValue($todate);
        $objSheet0->getStyle('G4')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            ,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getRowDimension('4')->setRowHeight(25);

    //      sheet name
        $objSheet0->setTitle('Issued Invoice');
    //
    //        //header
        $objSheet0->getStyle('B6:J6')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));

        $objSheet0->getStyle('B6:J6')->getFont()->setBold(true)->setSize(12);
        $objSheet0->getStyle('B6:J6')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'BDDCEF'))));

        $objSheet0->getCell('B6')->setValue('STT');
        $objSheet0->getCell('C6')->setValue('SỐ PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('D6')->setValue('NGÀY PHIẾU TÍNH CƯỚC');
        $objSheet0->getCell('E6')->setValue('QUYỂN HÓA ĐƠN');
        $objSheet0->getCell('F6')->setValue('SỐ HÓA ĐƠN');
        $objSheet0->getCell('G6')->setValue('NGÀY HÓA ĐƠN');
        $objSheet0->getCell('H6')->setValue('THÀNH TIỀN');
        $objSheet0->getCell('I6')->setValue('THUẾ VAT');
        $objSheet0->getCell('J6')->setValue('TỔNG TIỀN');
        $objSheet0->getRowDimension('6')->setRowHeight(50);

        $a=6;
        $grID = ""; $j = 0;
        if($args === null) goto xxx;
        foreach($args as $arg) {
            $a++;
            $j++;
            $objSheet0->getCell('B' . $a)->setValue($j);
            $objSheet0->getCell('C' . $a)->setValue($arg['DRAFT_INV_NO']);
            $objSheet0->getCell('D' . $a)->setValue($arg['DRAFT_INV_DATE']);
            $objSheet0->getCell('E' . $a)->setValue($arg['INV_PREFIX']);
            $objSheet0->getCell('F' . $a)->setValue($arg['INV_NO']);
            $objSheet0->getCell('G' . $a)->setValue($arg['INV_DATE']);
            $objSheet0->getCell('H' . $a)->setValue($arg['AMOUNT']);
            $objSheet0->getCell('I' . $a)->setValue($arg['VAT']);
            $objSheet0->getCell('J' . $a)->setValue($arg['TAMOUNT']);
            $objSheet0->getRowDimension($a)->setRowHeight(20);
        }

        xxx:
    //        $objSheet0->getStyle('C9:C' . $a)->getAlignment()->applyFromArray(array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER));
        $objSheet0->getStyle('H7:J' . $a)->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* ""_);_(@_)');

        $objSheet0->getStyle('B6:K' . $a)->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '9EBAE0')))));

        $objSheet0->getColumnDimension('B')->setWidth(6);
        $objSheet0->getColumnDimension('C')->setWidth(40);
        $objSheet0->getColumnDimension('D')->setWidth(12);
        $objSheet0->getColumnDimension('E')->setWidth(12);
        $objSheet0->getColumnDimension('F')->setWidth(12);
        $objSheet0->getColumnDimension('G')->setWidth(12);
        $objSheet0->getColumnDimension('H')->setWidth(12);
        $objSheet0->getColumnDimension('I')->setWidth(12);
        $objSheet0->getColumnDimension('J')->setWidth(12);
        $objSheet0->getColumnDimension('K')->setWidth(12);
        $objSheet0->setShowGridlines(false);

        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="ThongKeSanLuong.xls"');
        $objWriter->save('php://output');
    }

    public function exportVesselReportFile(){
        checkAndRedirectURL();

        $VoyageKey   = trim($this->uri->segment(3));
        $ClassID   = trim($this->uri->segment(4));
        $ClassID = intval($ClassID);

        if ($ClassID == 1 || $ClassID == 2){
            if ($ClassID == 1){
                $stmt = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetIn, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', $ClassID)
                                    ->join('DT_STOCKIN_BULK B', 'B.StockRef = A.rowguid and DateIn is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateIn')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();
            }
            else{
                $stmt = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetOut, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', $ClassID)
                                    ->join('DT_STOCKOUT_BULK B', 'B.StockRef = A.rowguid and DateOut is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateOut')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();
            }

            $checkNation = $this->ceh->select('NationName, ATA, ATD')
                                        ->join('DT_VESSEL B', 'A.VesselID = B.VesselID')
                                        ->join('BS_NATIONAL C', 'B.NationID = C.NationID')
                                        ->where('A.VoyageKey', $VoyageKey)
                                        ->limit(1)
                                        ->get('DT_VESSEL_VISIT A')
                                        ->row_array();

            $result_array = array();
            if (count($stmt) > 0){
                for ($i = 0; $i < count($stmt); $i++){
                    $tempBL = $stmt[$i]['BillOfLading'];
                    $tempBK = $stmt[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmt[$i]['VesselName'];
                    $LastPort = $stmt[$i]['LastPort'];
                    $NextPort = $stmt[$i]['NextPort'];
                    $InboundVoyage = $stmt[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmt[$i]['OutboundVoyage'];
                    $UnitID = $stmt[$i]['UnitID'];
                    $JobModeInID = $stmt[$i]['JobModeInID'];

                    if ($ClassID == 1){
                        while ($tempIndex < count($stmt) && $stmt[$tempIndex]['BillOfLading'] == $tempBL){
                            $sumCargoWeight += $stmt[$tempIndex]['CargoWeight'];
                            $sumCargoWeightGetInOut += $stmt[$tempIndex++]['CargoWeightGetIn'];
                        }
                        $numericIn = count($stmt);
                        $numericOut = 0;
                    }
                    else{
                        while ($tempIndex < count($stmt) && $stmt[$tempIndex]['BookingNo'] == $tempBK){
                            $sumCargoWeight += $stmt[$tempIndex]['CargoWeight'];
                            $sumCargoWeightGetInOut += $stmt[$tempIndex++]['CargoWeightGetOut'];
                        }
                        $numericIn = 0;
                        $numericOut = count($stmt);
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmt[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }
        }
        else{
            $stmtIn = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.ClassID as ClassID, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetIn, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', 1)
                                    ->join('DT_STOCKIN_BULK B', 'B.StockRef = A.rowguid and DateIn is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateIn')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();

            $stmtOut = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.ClassID as ClassID, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetOut, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', 2)
                                    ->join('DT_STOCKOUT_BULK B', 'B.StockRef = A.rowguid and DateOut is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateOut')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();

            $checkNation = $this->ceh->select('NationName, ATA, ATD')
                                        ->join('DT_VESSEL B', 'A.VesselID = B.VesselID')
                                        ->join('BS_NATIONAL C', 'B.NationID = C.NationID')
                                        ->where('A.VoyageKey', $VoyageKey)
                                        ->limit(1)
                                        ->get('DT_VESSEL_VISIT A')
                                        ->row_array();

            $result_array = array();

            if (count($stmtIn) > 0){
                $numericIn = count($stmtIn);
                for ($i = 0; $i < count($stmtIn); $i++){
                    $tempBL = $stmtIn[$i]['BillOfLading'];
                    $tempBK = $stmtIn[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmtIn[$i]['VesselName'];
                    $LastPort = $stmtIn[$i]['LastPort'];
                    $NextPort = $stmtIn[$i]['NextPort'];
                    $InboundVoyage = $stmtIn[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmtIn[$i]['OutboundVoyage'];
                    $UnitID = $stmtIn[$i]['UnitID'];
                    $ClassID = $stmtIn[$i]['ClassID'];
                    $JobModeInID = $stmtIn[$i]['JobModeInID'];

                    while ($tempIndex < count($stmtIn) && $stmtIn[$tempIndex]['BillOfLading'] == $tempBL){
                        $sumCargoWeight += $stmtIn[$tempIndex]['CargoWeight'];
                        $sumCargoWeightGetInOut += $stmtIn[$tempIndex++]['CargoWeightGetIn'];
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmtIn[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }

            if (count($stmtOut) > 0){
                $numericOut = count($stmtOut);
                for ($i = 0; $i < count($stmtOut); $i++){
                    $tempBL = $stmtOut[$i]['BillOfLading'];
                    $tempBK = $stmtOut[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmtOut[$i]['VesselName'];
                    $LastPort = $stmtOut[$i]['LastPort'];
                    $NextPort = $stmtOut[$i]['NextPort'];
                    $InboundVoyage = $stmtOut[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmtOut[$i]['OutboundVoyage'];
                    $UnitID = $stmtOut[$i]['UnitID'];
                    $ClassID = $stmtOut[$i]['ClassID'];
                    $JobModeInID = $stmtOut[$i]['JobModeInID'];

                    while ($tempIndex < count($stmtOut) && $stmtOut[$tempIndex]['BookingNo'] == $tempBK){
                        $sumCargoWeight += $stmtOut[$tempIndex]['CargoWeight'];
                        $sumCargoWeightGetInOut += $stmtOut[$tempIndex++]['CargoWeightGetOut'];
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmtOut[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }
        }
        
        $this->data['title'] = "BIÊN BẢN KẾT TOÁN NHẬN HÀNG VỚI TÀU";
        $this->data['numericIn'] = $numericIn;
        $this->data['numericOut'] = $numericOut;
        $this->data['dataList'] = $result_array;
        $this->data['ClassID'] = $ClassID;
        $this->data['VesselName'] = $VesselName;
        $this->data['LastPort'] = $LastPort;
        $this->data['NextPort'] = $NextPort;
        $this->data['NationName'] = $checkNation['NationName'];
        $this->data['ATA'] = $checkNation['ATA'] ? $checkNation['ATA'] : -1;
        $this->data['ATD'] = $checkNation['ATD'] ? $checkNation['ATD'] : -1;
        $this->data['InboundVoyage'] = $InboundVoyage;
        $this->data['OutboundVoyage'] = $OutboundVoyage;
        $this->load->view('report/vessel_report_file', $this->data);
    }

    public function exportVesselReportFileForGuess(){        
        $VoyageKey   = trim($this->uri->segment(3));
        $ClassID   = trim($this->uri->segment(4));
        $ClassID = intval($ClassID);

        if ($ClassID == 1 || $ClassID == 2){
            if ($ClassID == 1){
                $stmt = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetIn, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', $ClassID)
                                    ->join('DT_STOCKIN_BULK B', 'B.StockRef = A.rowguid and DateIn is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateIn')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();
            }
            else{
                $stmt = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetOut, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', $ClassID)
                                    ->join('DT_STOCKOUT_BULK B', 'B.StockRef = A.rowguid and DateOut is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateOut')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();
            }

            $checkNation = $this->ceh->select('NationName, ATA, ATD')
                                        ->join('DT_VESSEL B', 'A.VesselID = B.VesselID')
                                        ->join('BS_NATIONAL C', 'B.NationID = C.NationID')
                                        ->where('A.VoyageKey', $VoyageKey)
                                        ->limit(1)
                                        ->get('DT_VESSEL_VISIT A')
                                        ->row_array();

            $result_array = array();
            if (count($stmt) > 0){
                for ($i = 0; $i < count($stmt); $i++){
                    $tempBL = $stmt[$i]['BillOfLading'];
                    $tempBK = $stmt[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmt[$i]['VesselName'];
                    $LastPort = $stmt[$i]['LastPort'];
                    $NextPort = $stmt[$i]['NextPort'];
                    $InboundVoyage = $stmt[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmt[$i]['OutboundVoyage'];
                    $UnitID = $stmt[$i]['UnitID'];
                    $JobModeInID = $stmt[$i]['JobModeInID'];

                    if ($ClassID == 1){
                        while ($tempIndex < count($stmt) && $stmt[$tempIndex]['BillOfLading'] == $tempBL){
                            $sumCargoWeight += $stmt[$tempIndex]['CargoWeight'];
                            $sumCargoWeightGetInOut += $stmt[$tempIndex++]['CargoWeightGetIn'];
                        }
                        $numericIn = count($stmt);
                        $numericOut = 0;
                    }
                    else{
                        while ($tempIndex < count($stmt) && $stmt[$tempIndex]['BookingNo'] == $tempBK){
                            $sumCargoWeight += $stmt[$tempIndex]['CargoWeight'];
                            $sumCargoWeightGetInOut += $stmt[$tempIndex++]['CargoWeightGetOut'];
                        }
                        $numericIn = 0;
                        $numericOut = count($stmt);
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmt[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }
        }
        else{
            $stmtIn = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.ClassID as ClassID, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetIn, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', 1)
                                    ->join('DT_STOCKIN_BULK B', 'B.StockRef = A.rowguid and DateIn is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateIn')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();

            $stmtOut = $this->ceh->select('A.BillOfLading as BillOfLading, A.BookingNo as BookingNo, A.ClassID as ClassID, VesselName, LastPort, NextPort, InboundVoyage, OutboundVoyage, CargoWeight, CommodityDescription, CargoWeightGetOut, A.UnitID as UnitID, JobModeInID')
                                    ->where('A.VoyageKey', $VoyageKey)
                                    ->where('ClassID', 2)
                                    ->join('DT_STOCKOUT_BULK B', 'B.StockRef = A.rowguid and DateOut is NOT NULL', 'left')
                                    ->join('DT_VESSEL_VISIT C', 'A.VoyageKey = C.VoyageKey')
                                    ->order_by('A.BillOfLading, A.BookingNo, DateOut')
                                    ->get('DT_STOCK_BULK A')
                                    ->result_array();

            $checkNation = $this->ceh->select('NationName, ATA, ATD')
                                        ->join('DT_VESSEL B', 'A.VesselID = B.VesselID')
                                        ->join('BS_NATIONAL C', 'B.NationID = C.NationID')
                                        ->where('A.VoyageKey', $VoyageKey)
                                        ->limit(1)
                                        ->get('DT_VESSEL_VISIT A')
                                        ->row_array();

            $result_array = array();

            if (count($stmtIn) > 0){
                $numericIn = count($stmtIn);
                for ($i = 0; $i < count($stmtIn); $i++){
                    $tempBL = $stmtIn[$i]['BillOfLading'];
                    $tempBK = $stmtIn[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmtIn[$i]['VesselName'];
                    $LastPort = $stmtIn[$i]['LastPort'];
                    $NextPort = $stmtIn[$i]['NextPort'];
                    $InboundVoyage = $stmtIn[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmtIn[$i]['OutboundVoyage'];
                    $UnitID = $stmtIn[$i]['UnitID'];
                    $ClassID = $stmtIn[$i]['ClassID'];
                    $JobModeInID = $stmtIn[$i]['JobModeInID'];

                    while ($tempIndex < count($stmtIn) && $stmtIn[$tempIndex]['BillOfLading'] == $tempBL){
                        $sumCargoWeight += $stmtIn[$tempIndex]['CargoWeight'];
                        $sumCargoWeightGetInOut += $stmtIn[$tempIndex++]['CargoWeightGetIn'];
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmtIn[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }

            if (count($stmtOut) > 0){
                $numericOut = count($stmtOut);
                for ($i = 0; $i < count($stmtOut); $i++){
                    $tempBL = $stmtOut[$i]['BillOfLading'];
                    $tempBK = $stmtOut[$i]['BookingNo'];
                    $sumCargoWeight = 0;
                    $sumCargoWeightGetInOut = 0;
                    $tempIndex = $i;
                    $VesselName = $stmtOut[$i]['VesselName'];
                    $LastPort = $stmtOut[$i]['LastPort'];
                    $NextPort = $stmtOut[$i]['NextPort'];
                    $InboundVoyage = $stmtOut[$i]['InboundVoyage'];
                    $OutboundVoyage = $stmtOut[$i]['OutboundVoyage'];
                    $UnitID = $stmtOut[$i]['UnitID'];
                    $ClassID = $stmtOut[$i]['ClassID'];
                    $JobModeInID = $stmtOut[$i]['JobModeInID'];

                    while ($tempIndex < count($stmtOut) && $stmtOut[$tempIndex]['BookingNo'] == $tempBK){
                        $sumCargoWeight += $stmtOut[$tempIndex]['CargoWeight'];
                        $sumCargoWeightGetInOut += $stmtOut[$tempIndex++]['CargoWeightGetOut'];
                    }

                    $i = $tempIndex - 1;

                    $object = new stdClass();
                    $object->ClassID = $ClassID;
                    $object->UnitID = $UnitID;
                    $object->BillOfLading = $tempBL;
                    $object->BookingNo = $tempBK;
                    $object->JobModeInID = $JobModeInID;
                    $object->ExpectedWeight = $sumCargoWeight."";
                    $object->RealityWeight = $sumCargoWeightGetInOut."";
                    $object->CommodityDescription = $stmtOut[$i]['CommodityDescription'];
                    array_push($result_array, $object);
                }   
            }
        }
        
        $this->data['title'] = "BIÊN BẢN KẾT TOÁN NHẬN HÀNG VỚI TÀU";
        $this->data['numericIn'] = $numericIn;
        $this->data['numericOut'] = $numericOut;
        $this->data['dataList'] = $result_array;
        $this->data['ClassID'] = $ClassID;
        $this->data['VesselName'] = $VesselName;
        $this->data['LastPort'] = $LastPort;
        $this->data['NextPort'] = $NextPort;
        $this->data['NationName'] = $checkNation['NationName'];
        $this->data['ATA'] = $checkNation['ATA'] ? $checkNation['ATA'] : -1;
        $this->data['ATD'] = $checkNation['ATD'] ? $checkNation['ATD'] : -1;
        $this->data['InboundVoyage'] = $InboundVoyage;
        $this->data['OutboundVoyage'] = $OutboundVoyage;
        $this->load->view('report/vessel_report_file', $this->data);
    }
}
<?php
defined('BASEPATH') OR exit('');

class report_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);

        $this->yard_id = $this->config->item("YARD_ID");
    }

    public function getPayers($user = ''){
        $this->ceh->select('CusID, CusName, Address, VAT_CD, CusType, IsOpr, IsAgency, IsOwner, IsLogis, IsTrans, IsOther ');
        if($user != '' && $user != 'admin')
            $this->ceh->where('NameDD', $user);

        $this->ceh->where('VAT_CD IS NOT NULL');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('CusName', 'ASC');
        $stmt = $this->ceh->get('CUSTOMERS');
        return $stmt->result_array();
    }

    public function rptRevenue($fromdate = '', $todate = '', $sysname = '', $jmode){
        $this->ceh->select('TRF_CODE, TRF_DESC, SZ, SUM(QTY) SUMQTY, SUM(idd.TAMOUNT) SUMAMOUNT');
        $this->ceh->join('INV_DFT id', 'id.DRAFT_INV_NO = idd.DRAFT_INV_NO');
        $this->ceh->where('INV_NO IS NOT NULL');

        $this->ceh->where('idd.YARD_ID', $this->yard_id);

        if($fromdate != ''){
            $this->ceh->where('idd.insert_time >=', $this->funcs->dbDateTime($fromdate));
        }
        if($todate != ''){
            $this->ceh->where('idd.insert_time <=', $this->funcs->dbDateTime($todate));
        }
        if($jmode != ''){
            $this->ceh->where('idd.CntrJobType', $jmode);
        }
        $this->ceh->where_in('id.TPLT_NM', count($sysname) > 0 ? $sysname : array(""));

        $this->ceh->group_by(array("TRF_CODE", "TRF_DESC", "SZ"));

        $stmt = $this->ceh->get("INV_DFT_DTL idd")->result_array();

        $newarray = array();
        foreach ($stmt as $key=>$val ) {
            $newarray[$val["TRF_DESC"]][!isset($newarray[$val["TRF_DESC"]])?0:count($newarray[$val["TRF_DESC"]])] = $val;
        }

        if(count($newarray) == 0) return array();

        $results = array();
        foreach ($newarray as $k=>$item) {
            $colsz = array();
            foreach ($item as $n) {
                @$colsz[$n["SZ"]] += $n['SUMQTY'];
            }

            $tamout = array_sum(array_column($item, "SUMAMOUNT"));

            $item[0]["20"] = isset($colsz["20"]) ? (int)$colsz["20"] : 0;
            $item[0]["40"] = isset($colsz["40"]) ? (int)$colsz["40"] : 0;
            $item[0]["45"] = isset($colsz['45']) ? (int)$colsz["45"] : 0;
            $item[0]['SUMAMOUNT'] = $tamout;
            array_push($results, $item[0]);
        }

        return $results;
    }

    public function rptReleasedInv($fromdate = '', $todate = '', $sysname = '', $jmode){
        $this->ceh->select('id.DRAFT_INV_NO, DRAFT_INV_DATE, INV_PREFIX, iv.INV_NO, iv.INV_DATE, iv.AMOUNT, iv.VAT, iv.TAMOUNT');
        $this->ceh->join('INV_DFT id', 'id.INV_NO = iv.INV_NO');
        $this->ceh->join('INV_DFT_DTL idd', 'idd.DRAFT_INV_NO = id.DRAFT_INV_NO AND SEQ = 0');
        $this->ceh->where('iv.INV_NO IS NOT NULL');

        $this->ceh->where('iv.YARD_ID', $this->yard_id);

        if($fromdate != ''){
            $this->ceh->where('iv.INV_DATE >=', $this->funcs->dbDateTime($fromdate));
        }
        if($todate != ''){
            $this->ceh->where('iv.INV_DATE <=', $this->funcs->dbDateTime($todate));
        }
        if($jmode != ''){
            $this->ceh->where('idd.CntrJobType', $jmode);
        }
        $this->ceh->where_in('id.TPLT_NM', count($sysname) > 0 ? $sysname : array(""));

        $stmt = $this->ceh->get("INV_VAT iv");
        return $stmt->result_array();
    }

    public function sendConfirmMail($Email, $VoyageKey = '', $VesselName = '', $ReportURL = '', $ConfirmURL = ''){
        $this->load->library('qrmaker');
        $this->load->library('Email');
        
            $invContent = '';
            
            $reportSearching = $ReportURL;
            $color = 'green';

            $receiveEmail = '';
            foreach ($Email as $item) {
                $receiveEmail .= ($item['Email'].', ');
            }

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
            $this->email->to( $receiveEmail );
            $this->email->subject('[Thông báo] XÁC NHẬN BIÊN BẢN KẾT TOÁN VÀ DỪNG KHAI THÁC TÀU');


            $mailContent = <<<EOT
            <body>
            <div style="padding: 40px;">
            <div style="background-color: $color;border-top-left-radius:4px;border-top-right-radius:4px;height:60px;padding-top:30px">
            <span style="margin-top:20px;margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff">Xác nhận biên bản kết toán và dừng khai thác tàu</span>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px">
                <b>Kính gửi: Quý khách hàng</b>
                <br>
                <span>Thông tin về chi tiết về biên bản kết toán tàu $VoyageKey của quý khách như sau:</span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <ul style="margin-left:25px;list-style:disc;"
            </div>
            $table
                <div style="padding:10px 10px 10px 10px;font-family:Tahoma,serif;color:#030303;line-height:26px;"<br>
                    <span>Để tra cứu thông tin biên bản, quý khách vui lòng nhấn nút:</span>
                    <br><br>
                    
                    <div style="display:inline-flex">
                        <a href="$reportSearching" style="margin-right:20px; font-family:Tahoma,serif; background-color: #ff9600; color:#ffffff; font-weight:500; padding:10px 30px 10px 50px; border-radius:4px; border-style:none; text-decoration:none" target="_blank">TRA CỨU BIÊN BẢN</a>
                    </div>

                    <br><br>
                    <span>Để xác nhận dừng khai thác tàu, quý khách vui lòng nhấn nút bên dưới, đăng nhập tài khoản Chủ tàu và ấn nút "Xác nhận":</span>
                    <br><br>
                    
                    <div style="display:inline-flex">
                        <a href="$ConfirmURL" style="margin-right:20px; font-family:Tahoma, serif; background-color: #f13c20; color: white; font-weight:500; padding:10px 30px 10px 50px; border-radius:4px; border-style:none; text-decoration: none" target="_blank" >XÁC NHẬN DỪNG KHAI THÁC TÀU</a>
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

    public function sendMailAfterConfirm($Email, $VoyageKey = '', $VesselName = '', $ReportURL = ''){
        $this->load->library('qrmaker');
        $this->load->library('Email');
        
        $receiveEmail = '';
        foreach ($Email as $item) {
            $receiveEmail .= ($item['Email'].', ');
        }

            $invContent = '';
            
            $reportSearching = $ReportURL;
            $color = 'green';

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
            $this->email->to( $receiveEmail );
            $this->email->subject('[Thông báo] XÁC NHẬN BIÊN BẢN KẾT TOÁN VÀ DỪNG KHAI THÁC TÀU THÀNH CÔNG');


            $mailContent = <<<EOT
            <body>
            <div style="padding: 40px;">
            <div style="background-color: $color;border-top-left-radius:4px;border-top-right-radius:4px;height:60px;padding-top:30px">
            <span style="margin-top:20px;margin-left:20px;font-family:Tahoma;font-size:22px;color:#fff">Xác nhận biên bản kết toán và dừng khai thác tàu thành công</span>
            </div>
            <div style="border-style:none solid solid;border-width:1px;border-color:#e1e1e1;background-color:#fafafa">
            <div style="padding:10px 20px 10px 20px;font-family:Tahoma,serif;color:#030303;line-height:26px">
                <b>Kính gửi: Quý khách hàng</b>
                <br>
                <span>Thông tin về chi tiết về biên bản kết toán tàu $VoyageKey của quý khách như sau:</span>
            </div>
            <div style="line-height:30px;background-color:#e1eefb;padding:1px;display:inline-flex;width:100%">
                <ul style="margin-left:25px;list-style:disc;"
            </div>
            $table
                <div style="padding:10px 10px 10px 10px;font-family:Tahoma,serif;color:#030303;line-height:26px;"<br>
                    <span>Để tra cứu thông tin biên bản, quý khách vui lòng nhấn nút:</span>
                    <br><br>
                    
                    <div style="display:inline-flex">
                        <a href="$reportSearching" style="margin-right:20px; font-family:Tahoma,serif; background-color: #ff9600; color:#ffffff; font-weight:500; padding:10px 30px 10px 50px; border-radius:4px; border-style:none; text-decoration:none" target="_blank">TRA CỨU BIÊN BẢN</a>
                    </div>

                    <br><br>
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

    public function loadPortEmployeeEmailList(){
        $stmt = $this->ceh->select('Email')
                        ->order_by('Email', 'ASC')
                        ->where('GroupID', 'GroupAdmin')
                        ->get('SYS_USERS');
        return $stmt->result_array();
    }

    public function loadVesselOwnerEmailList(){
        $stmt = $this->ceh->select('Email')
                        ->order_by('Email', 'ASC')
                        ->where('GroupID', 'GroupVesselOwner')
                        ->get('SYS_USERS');
        return $stmt->result_array();
    }
}
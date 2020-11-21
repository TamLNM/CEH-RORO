<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?=$title;?></title>
    <!--    favicon-->
    <link rel="icon" href="<?=base_url('assets/img/icons/favicon.ico');?>" type="image/ico">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url('assets/vendors/jquery-ui/jquery-ui.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/line-awesome/css/line-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/themify-icons/css/themify-icons.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />

    <!-- PLUGINS STYLES-->
    <link href="<?=base_url('assets/vendors/dataTables/datatables.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/dataTables/jquery.dataTables.min.css');?>" rel="stylesheet" />
    <!--    DATATABLES SCROLL-->
    <link href="<?=base_url('assets/vendors/dataTables/scroller.dataTables.min.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/toastr/toastr.min.css');?>" rel="stylesheet" type="text/css" />

    <!--    CUSTOMIZE FOR DATATABLES-->
    <link href="<?=base_url('assets/css/custom.datatables.css');?>" rel="stylesheet" />

    <!-- THEME STYLES-->
    <link href="<?=base_url('assets/css/main.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/css/ro2.css');?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
	
	<!-- CORE PLUGINS-->
    <script src="<?=base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery2-1-4.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/metisMenu/dist/metisMenu.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>

    <script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
    
    <script src="<?=base_url('assets/js/contextmenu.js');?>"></script>

    <link href="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.css');?>" rel="stylesheet" />
    <script src="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.js');?>"></script>

    <!--    custom for eblling js-->
    <script src="<?=base_url('assets/js/ro2.js');?>"></script>
    <script src="<?=base_url('assets/js/datatables.ext.js');?>"></script>
    
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?=base_url('assets/vendors/dataTables/datatables.min.js');?>"></script>

    <!--    TABLES SCROLL-->
    <script src="<?=base_url('assets/vendors/dataTables/dataTables.scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/key_table.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/mindmup-editabletable.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/numeric-input-example.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/autofill.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/select.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/buttons.min.js');?>"></script>

    <!-- Toastr js -->
    <script src="<?=base_url('assets/vendors/toastr/toastr.min.js');?>"></script>

    <!-- Loader -->
    <script src="<?=base_url('assets/vendors/loaders/blockui.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/loaders/progressbar.min.js');?>"></script>

    <!-- Shorten text
    <script type="text/javascript" src="jquery.shorten.1.0.js"></script> -->

    <style>
        .no-pointer{
            pointer-events: none;
        }

        input[type="text"]:focus{
            background-color: #f6fcff;
        }
        .top-bar{
            position: relative;
            background-color: #207b99;
            height: 50px;
            margin: 0;
            display: flex;
        }
        .trapezoid{
            height: 100px;
            width: 300px;
            background: #005b7f;
            transform: perspective(100px) rotateX(-30deg);
            margin: 0 auto; 
            padding: 0px;
        }
        .right-btn-group{
            display: flex;
            position: absolute;
            top: 8px;
            right: 0;
            width: 30%;
        
        }
        .left-btn-group{
            position: absolute;
            top: 10px;
            width: 25%;
            width: 30%;
        }
        .btn{
            margin-right: 15px;
        }
        .user-info{
            position: fixed;
            top: 2%;
            left: 46.5%;
            font-size: 18px;
            color: white;
        }
        .middle-info{
            position: fixed;
            top: 6.25%;
            left: 39%;
            font-size: 18px;
            color: white;
        }
        .input-in-top-style, .input-in-top-style:focus{
            border-bottom: solid 1px white;
            border-top: none;
            border-left: none;
            border-right: none;
            background-color: #207b99;
            margin-left: 10px;
            width: 30%;
            color: white;
        }

        .btn.btn-white.btn-rounded{
            margin-bottom: 10px;
            height: 2.25rem;
        }

        #contenttable_wrapper .dataTables_scroll #cell-context   .dropdown-menu  .dropdown-item .sub-text{
            margin-left: 7px;
            font-size: 1rem;
            font-style: italic;
        }
        ::placeholder { 
            color: white;
        }
        /*
        a {
            color: #0254EB
        }
        a:visited {
            color: #0254EB
        }
        a.morelink {
            text-decoration:none;
            outline: none;
        }
        .morecontent span {
            display: none;
        }
        .comment {
            width: 400px;
            background-color: #f0f0f0;
            margin: 10px;
        }
        */
    </style>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<body style="background-color: #f2f4f8;">
    <div class="col-xl-12 top-bar">
        <div class="left-btn-group col-xl-4">
            <input class="input-in-top-style col-4" id='VesselName' placeholder="Tàu">
            <input class="input-in-top-style col-4" id='InOutBoundVoyage' placeholder="Chuyến">
        </div>
        <div  class="trapezoid col-xl-4">
            
        </div>
        <div class="right-btn-group col-xl-4" id='controlButtonDiv'>
            <button class="btn btn-white btn-rounded" id="NT"><b><span class="button-text">NHẬP TÀU</span></b></button>
            <button class="btn btn-white btn-rounded" id="XT"><b><span class="button-text">XUẤT TÀU</span></b></button>
            <button class="btn btn-white btn-rounded" id="DC"><b><span class="button-text">ĐẢO CHUYỂN</span></b></button>
        </div>   
    </div>
    <div class="col-xl-12 mt-5">
        <div class="ibox collapsible-box">
            <div class="row ibox-footer border-top-0">
                <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                    <table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
                        <thead>
                        <tr>
                            <th class="editor-cancel" col-name="STT">STT</th>
                            <th col-name="StockRef">StockRef</th>
                            <th col-name="VoyageKey">VoyageKey</th>
                            <th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
                            <th col-name="ClassID">Loại nhập/ xuất</th>
                            <th col-name="BillOfLading">Số vận đơn</th>
                            <th col-name="BookingNo">Số booking</th>
                            <th col-name="JobStatus">Trạng thái</th>
                            <th col-name="JobTypeID">Loại công việc</th>
                            <th col-name="VINNo">Số VIN</th>
                            <th col-name="TransitID">Loại hình vận chuyển</th>
                            <th col-name="CarWeight">Trọng lượng</th>                           
                            <th col-name="JobModeInID">Phương án vào</th>
                            <th col-name="MethodInID">Phương thức vào</th>
                            <th col-name="JobModeOutID">Phương án ra</th>
                            <th col-name="MethodOutID">Phương thức ra</th>
                            <th col-name="DamagedTypeID">Loại hình hư hỏng</th>
                            <th col-name="DamagedID">Loại hư hỏng</th>
                            <th col-name="KeyCheck">Sequence</th>
                            <th col-name="Block">Block</th>
                            <th col-name="Bay">Bay</th>
                            <th col-name="Row">Row</th>
                            <th col-name="Tier">Tier</th>
                            <th col-name="Area">Area</th>
                            <th col-name="PaymentTypeID">Loại hình thanh toán</th>
                            <!--
                            <th col-name="JobModeInOut">Phương án</th>
                            <th col-name="MethodInOut">Phương thức</th>
                        -->
                            <th col-name="BillCheck">BillCheck</th>                            
                            <th col-name="Remark">Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                            <!--
                            <?php if(count($jobQuayList) > 0) {
                                $i = 1; ?>
                                <?php foreach($jobQuayList as $item){  ?> 
                                    <tr>
                                        <td class="editor-cancel" col-name="STT"><?=$i?></td>
                                        <td col-name="StockRef"><?=$item['rowguid']?></td>
                                        <td col-name="VoyageKey"><?=$item['VoyageKey']?></td>
                                        <td col-name="IsLocalForeign"><?=$item['IsLocalForeign']?></td>
                                        <td col-name="ClassID"><?=$item['ClassID']?></td>
                                        <td col-name="BillOfLading"><?=$item['BillOfLading']?></td>
                                        <td col-name="BookingNo"><?=$item['BookingNo']?></td>
                                        <td col-name="VINNo"><?=$item['VINNo']?></td>
                                        <td col-name="TransitID"><?=$item['TransitID']?></td>
                                        <td col-name="CarWeight"></td>
                                        <td col-name="JobTypeID"></td>
                                        <td col-name="JobStatus">
                                            <input class='hiden-input' value='<?=$item['JobStatus']?>'><?=$item['VMStatusDesc']?>
                                        </td>
                                        <td col-name="JobModeInID"><?=$item['JobModeInID']?></td>
                                        <td col-name="MethodInID"><?=$item['MethodInID']?></td>
                                        <td col-name="JobModeOutID"><?=$item['JobModeOutID']?></td>
                                        <td col-name="MethodOutID"><?=$item['MethodOutID']?></td>
                                        <td col-name="DamagedTypeID"></td>
                                        <td col-name="DamagedID"></td>
                                        <td col-name="KeyCheck"></td>
                                        <td col-name="Block"></td>
                                        <td col-name="Bay"></td>
                                        <td col-name="Row"></td>
                                        <td col-name="Tier"></td>
                                        <td col-name="Area"></td>
                                        <td col-name="PaymentTypeID"></td>
                                        <td col-name="JobModeInOut">
                                            <?php 
                                                if ($item['JobModeInID']){
                                                    echo ($item['JobModeInID']);
                                                }
                                                else{
                                                    echo ('<i>Không có phương án vào</i>');
                                                }
                                                echo(" | ");
                                                if ($item['JobModeOutID']){
                                                    echo ($item['JobModeOutID']);
                                                }
                                                else{
                                                    echo ('<i>Không có phương án ra</i>');
                                                }
                                            ?>
                                        </td>
                                        <td col-name="MethodInOut">
                                            <?php 
                                                if ($item['MethodInID']){
                                                    echo ($item['MethodInID']);
                                                }
                                                else{
                                                    echo ('<i>Không có phương thức vào</i>');
                                                }
                                                echo(" | ");
                                                if ($item['MethodOutID']){
                                                    echo ($item['MethodOutID']);
                                                }
                                                else{
                                                    echo ('<i>Không có phương thức ra</i>');
                                                }
                                            ?>
                                        </td>
                                        <td col-name="BillCheck"></td>                            
                                        <td col-name="Remark"><?=$item['Remark']?></td>
                                    </tr>
                                    <?php $i++; 
                                }                                
                            } ?>
                        -->
                        </tbody>
                    </table>
                    <input style="position: absolute; z-index: 2; top: 1px; left: 347px; padding: 6px 8px; text-align: center; font: 400 14px/21px apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif; border: 1px solid rgb(183, 202, 226); width: 407px; height: 33px; display: none;" id="editor-input">
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer">
        <div class="font-13">2018 © <b>C.E.H</b> - Certified Ethical Hacker</div>
        <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
    </footer>
</body>

<div class="user-info"><b>User:</b> Tally</div>     
<div class="middle-info">
    <input class="input-in-top-style" style="background-color: #005b7f!important">
    <input class="input-in-top-style" style="background-color: #005b7f!important">
</div>     

<div id="cell-context" class="btn-group">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
    <div class="dropdown-menu dropdown-menu-right"></div>
</div>

<!-- Vessel modal-->
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding: auto; padding-top: 4%">
    <div class="modal-dialog" role="document" style="min-width: 1250px!important">
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="groups-modalLabel-1">Danh mục tàu</h5>
            </div>
            <div class="modal-body" style="padding: 0px 15px 15px 15px">
                <div class="row ibox-footer border-top-0 mt-3">
                    <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                        <table id="tblVessel" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
                            <thead>
                                <tr style="width: 100%">
                                    <th col-name="STT">STT</th>
                                    <th col-name="VoyageKey"></th>
                                    <th col-name="VesselID">Mã tàu</th>
                                    <th col-name="VesselName">Tên tàu</th>
                                    <th col-name="InboundVoyage">Chuyến nhập</th>
                                    <th col-name="OutboundVoyage">Chuyến xuất</th>                                  
                                    <th col-name="ETA" class="data-type-datetime">ETA</th>
                                    <th col-name="ETD" class="data-type-datetime">ETD</th>
                                    <th col-name="Status">Status</th>
                                    <th col-name="InLane">Chuyến xuất</th>
                                    <th col-name="OutLane">Chuyến xuất</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($vesselList) > 0) {
                                    $i = 1; ?>
                                    <?php foreach($vesselList as $item){  ?> 
                                        <tr>
                                            <td class="editor-cancel" col-name="STT"><?=$i?></td>
                                            <td col-name="VoyageKey"><?=$item['VoyageKey']?></td>
                                            <td col-name="VesselID"><?=$item['VesselID']?></td>
                                            <td col-name="VesselName"><?=$item['VesselName']?></td>
                                            <td col-name="InboundVoyage"><?=$item['InboundVoyage']?></td>
                                            <td col-name="OutboundVoyage"><?=$item['OutboundVoyage']?></td>
                                            <td col-name="ETA" class="ETA"><?=$item['ETA']?></td>
                                            <td col-name="ETD" class="ETD"><?=$item['ETD']?></td>
                                            <td col-name="Status"><?=$item['Status']?></td>
                                            <td col-name="InLane"><?=$item['InLane']?></td>
                                            <td col-name="OutLane" ><?=$item['OutLane']?></td>                                         
                                        </tr>
                                        <?php $i++; 
                                    }                                
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div  style="margin: 0 auto!important;">
                    <button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-vessel">
                        <span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
                    <button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" id="close-vessel">
                        <span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="margin-left: 0%!important; margin-top: 5%">
    <div class="modal-dialog" role="document" style="min-width: 1024px!important">
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="groups-modalLabel">CÔNG VIỆC</h5>
                <button class="btn btn-danger btn-icon-only btn-circle btn-sm btn-air" id="closeButton">
                    <i class="la la-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12" id="detailContentTab"> 
                            <div class="row form-group">
                                <label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Số VIN</label>
                                <input id="VINNo" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số VIN" type="text" readonly>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Vị trí</label>
                                <input id="" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="" type="text">
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Hư hỏng</label>
                                <label class="checkbox checkbox-success">
                                    <input type="checkbox" name="chbDamaged">
                                    <span class="input-span mt-2"></span>
                                </label>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Ghi chú</label>
                                <input id="" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="" type="text">
                            </div>
                        </div>
                        <div class="col-6" id='damagedDiv'>
                            <div class="row">
                                <div class="col-4">
                                    <div class="row form-group">x
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row form-group">y
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row form-group">u
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div  style="margin: 0 auto!important;">
                    <button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="StartJob">
                        <span class="btn-label"><i class="ti-check"></i></span>Bắt đầu
                    </button>

                    <button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" id="FinishJob">
                        <span class="btn-label"><i class="ti-close"></i></span>Kết thúc
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var _columns    = ["STT", "StockRef", "VoyageKey", "IsLocalForeign", "ClassID", "BillOfLading", "BookingNo", "JobStatus", "JobTypeID", "VINNo", "TransitID", "CarWeight", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "DamagedTypeID", "DamagedID", "KeyCheck", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID", /*"JobModeInOut", "MethodInOut",*/ "BillCheck", "Remark"],
            _vesselColumns  = ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane"],
            tbl         = $("#contenttable"),
            tblVessel   = $("#tblVessel"),
            vesselModal = $("#vessel-modal"),
            stockList   = {},
            jobTypeList = {},
            jobQuayList = {};
$("#modal").modal('show');
        $('#NT').hide();
        $('#XT').hide();
        $('#DC').hide();
        $("#damagedDiv").hide()

        $('.ETA, .ETD').each((key, val) => {
            let text = $(val).text();
            $(val).text(getDateTime(text));
        });


        <?php if(isset($stockList) && count($stockList) >= 0){?>
            stockList = <?= json_encode($stockList);?>;
        <?php } ?>

        <?php if(isset($jobTypeList) && count($jobTypeList) >= 0){?>
            jobTypeList = <?= json_encode($jobTypeList);?>;
        <?php } ?>

        <?php if(isset($jobQuayList) && count($jobQuayList) >= 0){?>
            jobQuayList = <?= json_encode($jobQuayList);?>;
        <?php } ?>

        var dataTable = tbl.newDataTable({
            scrollY: '55vh',
            columnDefs: [
                { type: "num", className: "text-center", targets: _columns.indexOf('STT') },
                { className: "text-center", targets: _columns.getIndexs(['JobTypeID', 'VINNo', "JobModeInID", "MethodInID", /*'JobModeInOut', 'MethodInOut',*/ 'JobStatus', 'Remark'])},           
                { className: "hiden-input", targets: _columns.getIndexs(["StockRef", "VoyageKey", "IsLocalForeign", "ClassID", "BillOfLading", "BookingNo", "TransitID", "CarWeight", "JobModeOutID", "MethodOutID", "DamagedTypeID", "DamagedID", "KeyCheck", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID",  "BillCheck"])},     
            ],
            order: [[ _columns.indexOf('STT'), 'asc' ]],
            paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            buttons: [],
            arrayColumns: _columns,
        });
        tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

        /* Initial vessel table */  
        tblVessel.newDataTable({
            scrollY: '30vh',
            columnDefs: [
                { type: "num", className: "text-center", targets: _vesselColumns.indexOf('STT')},       
                { className: "text-center", targets: _vesselColumns.getIndexs(["VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "InLane", "OutLane"])},
                { className: "hiden-input", targets: _vesselColumns.getIndexs(["VoyageKey", "VesselID", "Status"])},
            ],
            order: [[ _vesselColumns.indexOf('STT'), 'asc' ]],
            paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
                style: 'single',
                info: false,
            },
            rowReorder: false,
            buttons: [],
            arrayColumns: _vesselColumns,
        });

        $('#vessel-modal').on('shown.bs.modal', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $("#VesselName").on('click', function(){
            vesselModal.modal('show');
        });

        tbl.setExtendDropdown({
            target: "#cell-context",
            source: jobTypeList,
            colIndex: _columns.indexOf("JobTypeID"), 
            onSelected: function(cell, value){ 
                var jobTypeName = jobTypeList.filter( p => p.JobTypeID == value).map( x => x.JobTypeName );
                tbl.DataTable().cell(cell).data(
                    '<input class="hiden-input" value="'+ value  +'">' + jobTypeName
                ).draw(false);

                var rowIdx = tbl.DataTable().cell(cell).index()['row'];

                if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
                    tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");

                $("#modal").modal('show');
            },
        }); 

        $(document).on("dblclick", "#contenttable td",  function(e){
            var target = e['currentTarget'][''];
            if (target == _columns.indexOf("Remark")){
                var row     = e['target']['_DT_CellIndex'].row,
                    col     = e['target']['_DT_CellIndex'].column,
                    cell    = tbl.find("tbody tr:eq(" + row + ") td:eq("+ col +")");
 
            }
        });

        $(document).on("click", "#contenttable td",  function(e){
            $('#NT').show();
        });

        $("#NT").on('click', function(){
            $("#modal").modal('show');

            var tblData = tbl.getSelectedRows().data().toArray()[0],
                VINNo   = tblData[_columns.indexOf("VINNo")];

            $("#VINNo").val(VINNo);
        });

        /*
        $('#timeStart, #timeFinish').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: 'dd/mm/yy',
            timeFormat: 'HH:mm:00',
            timeInput: true,  
        });
        */

        $("#StartJob").on('click', function(){
            /*
            var date = new Date();
            $('#timeStart').datetimepicker('setDate', date);
            $('#timeStart').selectpicker("refresh");
            */
        });

        $("#FinishJob").on('click', function(){
            /*
            var date = new Date();
            $('#timeFinish').datetimepicker('setDate', date);
            $('#timeFinish').selectpicker("refresh");
            */
        });

        $("#closeButton").on('click', function(){
            $("#modal").modal('hide');
        });

        /* Add code from footer file */
        $('#sidebar-collapse').slimScroll({height:"100%",railOpacity:"0.9"});
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "swing",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('a.nav-link.sidebar-toggler.js-sidebar-toggler').on('click', function () {
            setTimeout(function () {
                $('.dataTable tbody').closest('table').each(function (k, v) {
                    $(v).realign();
                });
            }, 250);
        });

        tblVessel.find("tbody tr").on("dblclick", function(){
            var vesselData      = tblVessel.getSelectedRows().data().toArray()[0];
            
            $("#VesselName").val(vesselData[_vesselColumns.indexOf('VesselName')]);
            $("#InOutBoundVoyage").val(vesselData[_vesselColumns.indexOf('InboundVoyage')] + " | " + vesselData[_vesselColumns.indexOf('OutboundVoyage')]);

            vesselModal.modal('hide');

            tbl.waitingLoad();

            var formData = {
                'action': 'view',
                'child_action': 'loadJobQuayList',
                'VoyageKey': vesselData[_vesselColumns.indexOf("VoyageKey")],
            };
            
            $.ajax({
                url: "<?=site_url(md5('tally'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    var rows = [], i = 0;
                    if(data.list.length > 0) {                        
                        var rData = data.list[i], r = [];
                        $.each(_columns, function(idx, colname){
                            var val = "";
                            switch(colname){
                                case "STT": 
                                    val = ++i; 
                                   break;
                                case "StockRef":
                                    val = rData['rowguid'];
                                    break;
                                case "JobStatus":
                                    val = '<input class="hiden-input" value="KT">Khởi tạo';
                                    break;
                                case "JobTypeID":
                                    val = '<input class="hiden-input" value="DF">Dở tàu';
                                    break;
                                /*
                                case "JobModeInOut":
                                    if (rData['JobModeInID']){
                                        val += rData['JobModeInID'];
                                    }
                                    else{
                                        val += '<i>Không có phương án vào</i>';
                                    }
                                                                                
                                    val += " | ";
                                    
                                    if (rData['JobModeOutID']){
                                        val += rData['JobModeOutID'];
                                    }
                                    else{
                                        val += '<i>Không có phương án ra</i>';
                                    }
                                    break;
                                case "MethodInOut":
                                    if (rData['MethodInID']){
                                        val += rData['MethodInID'];
                                    }
                                    else{
                                        val += '<i>Không có phương thức vào</i>';
                                    }
                                                                                
                                    val += " | ";
                                    
                                    if (rData['MethodOutID']){
                                        val += rData['MethodOutID'];
                                    }
                                    else{
                                        val += '<i>Không có phương thức ra</i>';
                                    }
                                    break;
                                */
                                case "CarWeight":
                                case "JobTypeID":
                                case "DamagedTypeID":
                                case "DamagedID":
                                case "KeyCheck":
                                case "Block":
                                case "Bay":
                                case "Row":
                                case "Tier":
                                case "Area":
                                case "PaymentTypeID":
                                case "Area":
                                case "BillCheck":
                                    break;
                                default:
                                    val = rData[colname];
                                    break;  
                            }
                            r.push(val);
                        });
                        rows.push(r);
                    }

                    tbl.dataTable().fnClearTable();
                    if(rows.length > 0){
                        tbl.dataTable().fnAddData(rows);
                    }
                },
                error: function(err){
                    console.log(err);
                    return;
                }
            });            
        });

        $("#apply-vessel").on('click', function(){
            if (tblVessel.getSelectedRows().length == 0){
                toastr['error']("Vui lòng chọn tàu!");
                return;
            }
            else{
                var vesselData      = tblVessel.getSelectedRows().data().toArray()[0];
            
                $("#VesselName").val(vesselData[_vesselColumns.indexOf('VesselName')]);
                $("#InOutBoundVoyage").val(vesselData[_vesselColumns.indexOf('InboundVoyage')] + "|" + vesselData[_vesselColumns.indexOf('OutboundVoyage')]);

                vesselModal.modal('hide');
            }
        });

        $("#close-vessel").on('click', function(){
            if ($("#VesselName").val() == ''){
                toastr['error']("Vui lòng chọn tàu!");
                return;
            }
            else{
                vesselModal.modal('hide');
            }
        });


        $('input[type="checkbox"][name="chbDamaged"]').change(function() {
            if (this.checked){
                $("#detailContentTab").removeClass();
                $("#detailContentTab").addClass('col-6');
                $("#damagedDiv").show();
            }
            else{
                $("#detailContentTab").removeClass();
                $("#detailContentTab").addClass('col-12');
                $("#damagedDiv").hide();
            }
        });

        // Remove class error when change value
        $(document).on('input', '.error input', function () {
            $(this).parent().removeClass('error');
        });

        $('[data-action="reloadUI"]').on('click', function (e) {
            var block = $(this).attr('data-reload-target');
            $(block).block({ 
                message: '<i class="la la-spinner spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait',
                    'box-shadow': '0 0 0 1px #ddd'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });
    });
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>

<script>
    var resizefunc = [];

    $.extend( true, $.fn.dataTable.defaults, {
        language: {
            info: "Số dòng: _TOTAL_",
            emptyTable: "------------ Không có dữ liệu hiển thị ------------",
            infoFiltered: "(trên _MAX_ dòng)",
            infoEmpty: "Số dòng: 0",
            search: '<span>Tìm:</span> _INPUT_',
            zeroRecords:    "------------ Không có dữ liệu được tìm thấy ------------",
            sThousands: ",",
            sDecimal: ".",
            select: {
                rows: {
                    _: "Đã chọn %d dòng",
                    0: ""
                }
            }
        },
        search: {
            regex: true
        },
        info: true,
        orderClasses: false,
        paging: false,
        scrollY: 419,
        scrollX: true,
        lengthChange: false,
        scrollCollapse: false,
        deferRender: true,
        processing: true,
        autoWidth: true,
        dom: '<"datatable-header"fl<"datatable-info-right"Bip>><"datatable-scroll-wrap"t>',
        buttons: [
            {extend: 'selectAll', text: 'Chọn tất cả', className: 'btn btn-xs btn-default'},
            {extend: 'selectNone', text: 'Bỏ chọn', className: 'btn btn-xs btn-default'}
        ],
        destroy: true
    });
</script>


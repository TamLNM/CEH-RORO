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
    <style>
        @media (max-width: 767px) {
            .f-text-right    {
                text-align: right;
            }
        }
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
            left: 6%;
            width: 25%;
            width: 30%;
        }
        .btn{
            margin-right: 15px;
        }
        .user-info{
            position: absolute;
            top: 2%;
            left: 46.5%;
            font-size: 18px;
            color: white;
        }
        .middle-info{
            position: absolute;
            top: 6.25%;
            left: 41%;
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
            width: 25%;
            color: white;
        }

        .btn.btn-white.btn-rounded{
            font-size: 1em;
            margin-bottom: 10px;
            height: 2.25rem;
        }

        #contenttable_wrapper .dataTables_scroll #cell-context   .dropdown-menu  .dropdown-item .sub-text{
            margin-left: 7px;
            font-size: 12px;
            font-style: italic;
        }
    </style>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<body style="background-color: #f2f4f8;">
    <div class="top-bar">
        <div class="left-btn-group" style="max-width: 33%">
            <input class="input-in-top-style" id=''>
            <input class="input-in-top-style" id=''>
            <input class="input-in-top-style" id=''>
        </div>
        <div  class="trapezoid" style="max-width: 33%">
            
        </div>
        <div class="right-btn-group"  style="max-width: 33%">
            <button class="btn btn-white btn-rounded"><b>NHẬP TÀU</b></button>
            <button class="btn btn-white btn-rounded"><b>XUẤT TÀU</b></button>
            <button class="btn btn-white btn-rounded"><b>ĐẢO CHUYỂN</b></button>
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
                            <th col-name="VINNo">Số VIN</th>
                            <th col-name="TransitID">Loại hình vận chuyển</th>
                            <th col-name="CarWeight">Trọng lượng</th>
                            <th col-name="JobTypeID">Loại công việc</th>
                            <th col-name="JobStatus">Trạng thái</th>
                            <th col-name="JobModeInID">Phương án vào</th>
                            <th col-name="MethodInID">Phương thức vào</th>
                            <th col-name="JobModeOutID">Phương án vào</th>
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
                            <th col-name="JobModeInOut">Phương án</th>
                            <th col-name="BillCheck">BillCheck</th>                            
                            <th col-name="Remark">Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="margin-left: 0%!important">
    <div class="modal-dialog" role="document" style="width: 1024px!important">
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="groups-modalLabel">CÔNG VIỆC</h5>
            </div>
            <div class="modal-body">
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
        var _columns    = ["STT", "StockRef", "VoyageKey", "IsLocalForeign", "ClassID", "BillOfLading", "BookingNo", "VINNo", "TransitID", "CarWeight", "JobTypeID", "JobStatus", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "DamagedTypeID", "DamagedID", "KeyCheck", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID", "JobModeInOut", "BillCheck", "Remark"],
            tbl         = $("#contenttable"),
            stockList   = {},
            jobTypeList = {};

        var dataTable = tbl.newDataTable({
            scrollY: '55vh',
            columnDefs: [
                { type: "num", className: "text-center", targets: _columns.indexOf('STT') },
                { className: "text-center", targets: _columns.getIndexs(['JobTypeID', 'VINNo', 'JobModeInOut', 'JobStatus', 'Remark'])},
                { className: "hiden-input", targets: _columns.getIndexs(["StockRef", "VoyageKey", "IsLocalForeign", "ClassID", "BillOfLading", "BookingNo", "TransitID", "CarWeight", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "DamagedTypeID", "DamagedID", "KeyCheck", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID",  "BillCheck"])},
            ],
            order: [[ _columns.indexOf('STT'), 'asc' ]],
            paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns
        });

        tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

        tbl.waitingLoad();
        var formData = {
            'action': 'view',
        };
        $.ajax({
            url: "<?=site_url(md5('tally'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                var rows = [];
                if(data.list.length > 0) {
                    stockList = data.list;
                    for (i = 0; i < data.list.length; i++) {
                        var rData = data.list[i], r = [];
                        $.each(_columns, function(idx, colname){
                            var val = "";
                            switch(colname){
                                case "STT": 
                                    val = i+1; 
                                    break;
                                case "StockRef":
                                    val = rData['rowguid'];
                                    break;
                                case "JobModeInOut":
                                    if (!(rData['JobModeInID']) && !(rData['JobModeOutID'])){
                                        val = '-';
                                    }
                                    else{
                                        if ((rData['JobModeInID']) && (rData['JobModeOutID'])){
                                            val = rData['JobModeInID'] + " | " + rData['JobModeOutID'];
                                        }
                                    }
                                    break;
                                case "JobTypeID":
                                case "CarWeight":
                                case "DamagedTypeID":
                                case "DamagedID":
                                case "KeyCheck":
                                case "Block":
                                case "Bay":
                                case "Row":
                                case "Tier":
                                case "Area":
                                case "PaymentTypeID":
                                case "BillCheck":
                                    break;
                                case "JobStatus":
                                    val = '<input class="hiden-input" value="' + rData['VMStatus'] + '">' + rData['VMStatusDesc'];
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
                }                    
            },
            error: function(err){
                console.log(err);
                return;
            }
        });

        formData = {
            'action': 'view',
            'child_action': 'loadJobTypeList',
        };

        $.ajax({
            url: "<?=site_url(md5('tally'));?>",
            dataType: 'json',
            data: formData,
            type: 'POST',
            success: function (data) {
                var rows = [];
                if(data.list.length > 0) {
                    jobTypeList = data.list;
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


                        },
                    }); 
                }                    
            },
            error: function(err){
                console.log(err);
                return;
            }
        });

        $("#FinishJob").on('click', function(){
            $("#modal").modal('hide');
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

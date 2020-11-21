<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}
	/*
	#cus-type-modal .modal-content input[type="search"]{
		width: 65%;
	}

	#cus-type-modal .modal-content label:after{
		right: 27%;
	}
	*/

	#contenttable_wrapper .dataTables_scroll #cell-context 	 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu  .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BÁO CÁO - DỮ LIỆU TALLY</div>
				<div class="button-bar-group mr-3">					
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>				
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-2 col-form-label">Từ</label>
									<div class="col-8">
										<input id="StartDate" class="form-control form-control-sm" placeholder="Từ ngày" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-2 col-form-label">Đến</label>
									<div class="col-8">
										<input id="FinishDate" class="form-control form-control-sm" placeholder="Đến ngày" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid">rowguid</th>
							<th col-name="StockRef">StockRef</th>
							<th col-name="VoyageKey">VoyageKey</th>
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="ClassID">Hướng nhập/ xuất</th>
							<th col-name="BillOfLadingORBookingNo">Số vận đơn/ booking</th>
							<th col-name="BillOfLading">Số vận đơn</th>
							<th col-name="BookingNo">Số booking</th>
							<th col-name="VINNo">Số VIN</th>
							<th col-name="TransitID">TransitID</th>
							<th col-name="CarWeight">Trọng lượng</th>
							<th col-name="JobTypeID">Phương án</th>
							<th col-name="JobStatus">Tình trạng xe</th>
							<th col-name="StartDate">Thời gian bắt đầu</th>
							<th col-name="FinishDate">Thời gian hoàn tất</th>
							<th col-name="JobModeInID">Phương án vào</th>
							<th col-name="MethodInID">Phương thức vào</th>
							<th col-name="KeyCheck">Mã chìa khóa</th>
							<th col-name="Sequence">Sequence</th>
							<th col-name="Block">Block</th>
							<th col-name="Bay">Bay</th>
							<th col-name="Row">Row</th>
							<th col-name="Tier">Tier</th>
							<th col-name="Area">Area</th>
							<th col-name="PaymentTypeID">Loại hình thanh toán</th>
							<th col-name="BillCheck">Bill Check</th>
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
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 	= ["STT", "rowguid", "StockRef", "VoyageKey", "IsLocalForeign", "ClassID", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "VINNo", "TransitID", "CarWeight", "JobTypeID", "JobStatus", "StartDate", "FinishDate", "JobModeInID", "MethodInID", "KeyCheck", "Sequence", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID", "BillCheck", "Remark"],
			tbl 		= $('#contenttable'),
			parentMenuList 	= {};

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'ReportAndStatistics'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		var tblData = tbl.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},		
				{ className: "text-center", targets: _columns.getIndexs(["IsLocalForeign", "ClassID", "BillOfLadingORBookingNo",, "VINNo", "TransitID", "CarWeight", "JobTypeID", "JobStatus", "StartDate", "FinishDate", "JobModeInID", "MethodInID", "KeyCheck", "Sequence", "Block", "Bay", "Row", "Tier", "Area", "PaymentTypeID", "BillCheck", "Remark"])},
				{ className: "hiden-input", targets: _columns.getIndexs(["rowguid", "StockRef", "VoyageKey", "BillOfLading", "BookingNo"])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus',
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns,
		});

		$("#FinishDate").val('*');
		$("#StartDate, #FinishDate").datepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',			
		});

		$("#search").on('click', function(){
			if (!($("#StartDate").val())){
				toastr['error']("Vui lòng chọn ngày bắt đầu!");
				return;
			}

			if ($("#FinishDate").val() != '*'){
				if (new Date(getSQLDateFormat($("#StartDate").val())) > new Date(getSQLDateFormat($("#FinishDate").val()))){
					toastr['error']("Vui lòng chọn ngày bắt đầu < ngày kết thúc!");
					return;
				}
			}			

			var formData = {
				'action': 'view',
				'StartDate': getSQLDateFormat($("#StartDate").val() + " 00:00:00"),
				'FinishDate': $("#FinishDate").val() == '*' ? '*' : getSQLDateFormat($("#FinishDate").val() + " 23:59:59"),
			}

			tbl.waitingLoad();

			$.ajax({
                url: "<?=site_url(md5('ReportAndStatistics') . '/' . md5('rpTally'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if (data.list.length == 0){
						toastr['info']("Không tồn tại dữ liệu trong khoảng thời gian đã nhập!");
						tbl.dataTable().fnClearTable();
						return;
					}
					else{
						var dataList = data.list,
							rows = [];

						for(k = 0; k < dataList.length; k++){
							var r = [] , rData = dataList[k];

                                $.each(_columns, function(idx, colname){
									var val = "";
                                    switch(colname){
                                    	case "STT":
                                    		val = k + 1;
                                    		break;
                                    	case "BillOfLadingORBookingNo":
                                    		if (rData['BillOfLading']){
                                    			val = rData['BillOfLading'];
                                    		}
                                    		else if (rData['BookingNo']){
                                    			val = rData['BookingNo'];
                                    		}
                                    		break;
                                    	case "ClassID":
                                    		if (rData[colname] == 1){
                                    			val = '<input class="hiden-input">Nhập'
                                    		}
                                    		else{
                                    			val = '<input class="hiden-input">Xuất';
                                    		}
                                    		break;                                    
                                 		case "IsLocalForeign":
                                    		if (rData[colname] == 1){
                                    			val = '<input class="hiden-input">Nội'
                                    		}
                                    		else{
                                    			val = '<input class="hiden-input">Ngoại';
                                    		}
                                    		break; 
                                    	case "BillOfLading":
                                    	case "BookingNo":
                                    		if (rData[colname]){
                                    			val = rData[colname]
                                    		}		
                                    		else{
                                    			val = '';
                                    		}
                                    		break; 
                                    	default:
                                    		val = rData[colname];
                                    		break;
                                    };
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
				}
			});
		});

		function getSQLDateFormat(date){
        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, 19);
        	else
        		return date;
        }
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
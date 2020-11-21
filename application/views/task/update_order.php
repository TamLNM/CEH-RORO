<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">

<style>
	.m-row-selected{
		background: violet;
	}
	.MT-toggle, .PY-toggle{
		display: none;
	}
	.MT-toggle button, .PY-toggle button {
		background-color: #fff!important;
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold!important;
		padding-right: 0 !important;
	}
	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
	}

	.modal-dialog-mw-py   {
		position: fixed;
		top:20%;
		margin: 0;
		width: 100%;
		height: 100%;
		padding: 0;
		max-width: 100%!important;
	}

	.modal-dialog-mw-py .modal-body{
		width: 90%!important;
		margin: auto;
	}

	.unchecked-Salan{
		pointer-events: none;
	}
	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label{
		width: 64%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox">
			<div class="ibox-head">
				<div class="ibox-title">CẬP NHẬT THÔNG TIN LỆNH</div>
				<div class="ibox-tools">
					<a class="ibox-collapse"><i class="la la-angle-double-down dock-right"></i></a>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-md-3 col-sm-12 col-12 ibox mb-1">
						<div class="ibox-head">
							<div class="ibox-title">
								Truy vấn lệnh
							</div>
						</div>
						<div class="row pt-2">
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Số lệnh</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<input class="form-control form-control-sm" id="ref-no" type="text" placeholder="Số lệnh">
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<label class="col-sm-4 col-4 col-form-label">Số container</label>
									<div class="col-sm-8 col-12 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No.">
											<span class="input-group-addon bg-white btn text-warning" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<div class="col-sm-4 col-form-label">
										<label for="contOrder" class="checkbox checkbox-blue text-warning">
											<input type="checkbox" name="" id="contOrder">
											<span class="input-span"></span>
											Lệnh nâng hạ Container
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-12">
								<div class="row form-group">
									<div class="col-sm-4 col-form-label">
										<label for="serviceOrder" class="checkbox checkbox-blue text-warning">
											<input type="checkbox" name="" id="serviceOrder">
											<span class="input-span"></span>
											Lệnh dịch vụ Container
										</label>
									</div>
								</div>								
							</div>
							<div class="col-12 ibox-footer p-2">
								<div class="row form-group ml-auto">
									<button id="refreshFilter" class="btn btn-outline-primary btn-sm mr-1">
										<span class="btn-icon"><i class="fa fa-atom"></i>Tải lại(ctrl+R)</span>
									</button>
									<button id="saveChange" class="btn btn-outline-success btn-sm mr-1">
										<span class="btn-icon"><i class="fa fa-save"></i>Lưu(ctrl+S)</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- end truy vấn lệnh -->
					<!-- begin danh sách lệnh -->
					<div class="col-md-9 col-sm-12 col-12 ibox mb-1" style="width: 95%">
						<div class="ibox-head">
							<div class="ibox-title">
								Danh sách lệnh
							</div>
							<div class="ibox-tools">
								<a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ibox-body p-0">
							<table id="tbl-ord" class="table table-striped display table-bordered nowrap" cellspacing="0">
								<thead>
								<tr>
									<td>STT</td>
									<td>Số lệnh</td>
									<td>Phương án</td>
									<td>Phương thức</td>
									<td>Ngày lệnh</td>
									<td>Tàu/Năm/Chuyến</td>
									<td>Số vận đơn</td>
									<td>Số Booking</td>
									<td>Chủ hàng</td>
									<td style="min-width: 150px">Đối tượng thanh toán</td>
									<td>Hình thức thanh toán </td>
									<td>Người đại diện</td>
									<td>CMND/Điện thoại</td>
									<td>Nơi trả rỗng</td>
									<td>Phương tiện vận chuyển</td>
									<td>Sà lan/(Năm/Chuyến)</td>
								</tr>
								</thead>

								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- ///////////////////////////// -->
				<div class="row MT-toggle mt-2 border-e bg-white">
					<div class="col-sm-12 pt-2">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Nơi trả *</label>
											<div class="col-sm-8">
												<div class="input-group">
													<select id="MT-retlocation" class="selectpicker MT-change-required" data-style="btn-default btn-sm" data-width="100%" data-live-search="true">
														<option value="" selected>--[Nơi trả rỗng]--</option>
														<?php if(isset($relocation) && count($relocation) > 0){ foreach ($relocation as $item){ ?>
															<option value="<?= $item['GNRL_CODE'] ?>"><?= $item['GNRL_NM'] ?></option>
														<?php }} ?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Hạn trả *</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm MT-change-required" id="MT-exp-date" type="text" placeholder="Hạn trả">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Ghi chú</label>
									<div class="col-sm-10 input-group input-group-sm">
										<input class="form-control form-control-sm" id="MT-remark" type="text" placeholder="Ghi chú trả rỗng">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 ibox">
				<div class="ibox-head">
					<div class="ibox-title">
						Danh sách Container
					</div>
					<div class="ibox-tools">
						<a class="fullscreen-link"><i class="ti-fullscreen"></i></a>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive ibox-body p-0 pb-2">
					<table id="tbl-conts" class="table table-striped display table-bordered nowrap" cellspacing="0">
						<thead>
						<tr>
							<td>STT</td>
							<td>Số Container</td>
							<td>Ngày hạn lệnh</td>
							<td>Ngày hạn điện</td>
							<td>Hạn lưu Container</td>
							<td>Hãng khai thác</td>
							<td>Kích cỡ</td>
							<td>Cỡ ISO</td>
							<td>Hàng/Rỗng</td>
							<td>Hướng</td>
							<td>Loại hàng</td>
							<td>Hàng hóa</td>
							<td>Trọng lượng</td>
							<td>Phương án</td>
							<td>Phương thức</td>
							<td>Cảng dỡ</td>
							<td>Cảng xếp</td>
							<td>Cảng đích</td>
							<td>Số niêm chì 1</td>
							<td>Nội/Ngoại</td>
							<td>Nhiệt độ</td>
							<td>Class</td>
							<td>Mã nguy hiểm</td>
							<td>Thông gió</td>
							<td>Đơn vị</td>
							<td>Xác nhận vận chuyển</td>
							<td>Số phiếu tính cước</td>
							<td>Số hóa đơn</td>
							<td>Xác nhận thanh toán</td>
							<td>Chuyển cảng</td>
							<td>Ghi chú</td>
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
	var _eirforMTReturn = '';
	jQuery.expr[':'].regex = function(elem, index, match) {
		var matchParams = match[3].split(','),
			validLabels = /^(data|css):/,
			attr = {
				method: matchParams[0].match(validLabels) ?
					matchParams[0].split(':')[0] : 'attr',
				property: matchParams.shift().replace(validLabels,'')
			},
			regexFlags = 'ig',
			regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
		return regex.test(jQuery(elem)[attr.method](attr.property));
	};
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};

	window.onbeforeunload = PreUnloadJavaScript;
	function PreUnloadJavaScript() {
		var cName = $('#ref-no').val();
		if(cName){
			deleteCookie("eir__"+cName);
		}
		deleteCookie("eir__"+_eirforMTReturn);
	}

	$(document).ready(function () {
		var _colsOrder = ["EIRNo", "CJMode_CD", "DMethod_CD", "IssueDate", "ShipID/ImVoy/ExVoy", "BLNo", "BookingNo", "Chủ hàng", "Đối tượng thanh toán"
			, "Hình thức thanh toán", "Người đại diện", "CMND/Điện thoại", "nơi trả rỗng", "Phương tiện vận chuyển", "Sà lan/(Năm/chuyến)"];

		var _colsCont = ["CntrNo", "Ngày hạn lệnh", "ExpPluginDate", "Hạn lưu cont", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "CntrClass", "Loại hàng"
			, "Hàng hóa", "CMDWeight", "CJMode_CD", "DMethod_CD", "Cảng dỡ", "cảng xếp", "Cảng Đích", "SealNo", "Nội/Ngoại", "Temperature","Class", "UNNO", "Thông gió", "đơn vị", "Xác nhận vận chuyển", "Số phiếu tính cước", "Số hóa đơn", "Xác Nhận thanh toán", "Transit", "ghi chú"];
		var _result = [], _lstEir = [];
		var selected_cont = [];

		var tempService;
		var ctrlDown = false;

		$('#tbl-conts').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});
		$('#tbl-ord').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '25vh'
		});

		//--------cancel modal-------
		$('#cancel-service').click(function(){
			$('#service-modal tbody').html(tempService);
		});

		// -------eir datepicker function----------
		$('#eir_date').daterangepicker({
			autoUpdateInput: true,
			startDate: moment().subtract(1, 'month'),
			endDate: moment(),
			locale: {
				cancelLabel: 'Xóa',
				applyLabel: 'Chọn',
				format: 'DD/MM/YYYY'
			}
		});
		$('#eir_date').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
		});

		$('#eir_date').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		$('#eir_date + span').on('click', function () {
			$('#eir_date').val('');
		});

		// ------------button function-------------
		$('#saveChange').click(function(){
			toastr['success']('lưu dữ liệu thành công!');
		});

		$('#refreshFilter').click(function(){
			toastr['warning']('!');
		});

		// ------------binding shortcut key press------------
        ctrlKey = 17,
        cmdKey = 91,
        rKey = 82,

	    $(document).keydown(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
	    }).keyup(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
	    });

	    $(document).keydown(function(e) {
	    	if (ctrlDown) {
	    		switch(e.keyCode){
		    		case 82:
		    		$('#refreshFilter').trigger('click');
		    		break;
		    		case 83:
		    		$('#saveChange').trigger('click');
		    		break;
		    	}
	    	}
	    	return false;
	    });

	    //---------

	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
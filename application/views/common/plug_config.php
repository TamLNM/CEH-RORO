<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet">

<style>
	.nav-tabs{
		height: inherit!important;
	}
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
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">CẤU HÌNH CẮM RÚT ĐIỆN LẠNH</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm mẫu mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm mới</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" title="Xóa mẫu">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row">
					<div class="col-4 ibox mb-0 border-e pb-1 pt-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Tên</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm input-required" id="nickName" type="text" placeholder="Tìm theo tên">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">ĐTTT *</label>
							<div class="col-sm-8 input-group">
								<input class="form-control form-control-sm input-required" id="payer" placeholder="Đối tượng thanh toán" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .64rem" title="Đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
									<i class="ti-search"></i>
								</span>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Hàng nội/ngoại</label>
							<div class="col-sm-8">
								<select id="isLocal" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" title="Chọn loại hàng">
									<option disabled="true" selected>*</option>
									<option value="">Nội/Ngoại</option>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Hãng khai thác</label>
							<div class="col-sm-8">
								<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%" title="Chọn hãng khai thác">
									<option value="" selected>[Chọn hãng khai thác]</option>
									<option value="*">*</option>
									<?php if(isset($oprs) && count($oprs) > 0){ foreach ($oprs as $item){ ?>
										<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Ngày hiệu lực</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="dateStart" value="*" type="text" placeholder="Ngày hiệu lực" readonly>
									<span class="input-group-addon bg-white btn text-success" title="Không xác định" style="padding: 0 .5rem; font-size: .8rem">ALL</span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Ngày hết hạn *</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="dateEnd" type="text" placeholder="Ngày hết hạn">
									<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .72rem"><i class="fa fa-times"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Thời gian cắm</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="datePlugin" type="text" placeholder="Thời gian cắm" readonly>
									<!-- <span class="input-group-addon bg-white btn text-success" title="Không xác định" style="padding: 0 .5rem">ALL</span> -->
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Thời gian rút</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="datePlugout" type="text" placeholder="Thời gian rút">
									<!-- <span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span> -->
								</div>
							</div>
						</div>
					</div>
					<!-- ///////////////////////////////// -->
					<div class="col-8 pl-3 pr-0">
						<div class="ibox mb-0 border-e pb-1 pt-3 table-responsive p-3 pl-3 pr-3">
							<table id="tbl-content" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
								<thead>
								<tr>
									<th style="max-width: 20px">STT</th>
									<th class="editor-cancel">Loại</th>
									<th class="editor-round-type">Giờ sử dụng điện</th>
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
	</div>
</div>

<!--select payer-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body pt-0">
				<div class="row p-3">
					<div class="col-6">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Loại khách hàng</label>
							<div class="col-sm-8">
								<select id="payerType" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
									<option disabled="true" selected>*</option>
									<option value="">Loại khách hàng</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Tìm theo tên">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th>Mã khách hàng</th>
							<th>Tên khách hàng</th>
							<th>VAT</th>
							<th>Mã số thuế</th>
							<th>Địa chỉ</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="select-ship" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>
</div>

<select id="rf-type" style="display: none">
	<option value="IM">Import</option>
	<option value="EX">Export</option>
	<option value="RS">Reefer Stuffing</option>
	<option value="RU">Reefer Unstuffing</option>
</select>

<select id="time-plug" style="display: none">
	<option value="ATB">Actual Time of Berth</option>
	<option value="ATW">Actual Time of Work</option>
</select>

<select id="round-type" style="display: none">
	<option value="R1">Up to 0.5 hour</option>
	<option value="R2">Up to 1 hour</option>
	<option value="R3">Round half up</option>
</select>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns = ["STT", "RF_TYPE", "TIMEPLUGIN", "TIMEPLUGOUT", "ROUNDING"];
		var _defaultGridData = [
			{
				"RF_TYPE": "IM", "TIMEPLUGIN": "", "TIMEPLUGOUT": "", "ROUNDING": ""
			},
			{
				"RF_TYPE": "EX", "TIMEPLUGIN": "", "TIMEPLUGOUT": "", "ROUNDING": ""
			},
			{
				"RF_TYPE": "RS", "TIMEPLUGIN": "", "TIMEPLUGOUT": "", "ROUNDING": ""
			},
			{
				"RF_TYPE": "RU", "TIMEPLUGIN": "", "TIMEPLUGOUT": "", "ROUNDING": ""
			}
		];

		var rfType = {"IM":"Import", "EX":"Export", "RS":"Reefer Stuffing", "RU":"Reefer Unstuffing"};
		
		var tbl = $('#tbl-content');

		loadGrid(_defaultGridData);

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
	        if (ctrlDown && e.keyCode == rKey){
	        	alert('reload filter');
	        	return false;
	        } 
	    });

	    //---------datepicker modified---------
	    $('#dateStart, #dateEnd').datepicker({
			format: "dd/mm/yyyy",
			startDate: moment().format('DD/MM/YYYY'),
			todayHighlight: true,
			autoclose: true
		});

		$('#dateStart + span').on('click', function(){
			$('#dateStart').val("*");
		});

		// ----------function button (add, delete, save)--------
		$('#addrow').on('click', function(){
            tbl.newRow();
        });

        var tblPayer = $('#search-payer').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '25vh'
		});

        function loadGrid(data){
        	var rows = [];
        	if(data && data.length > 0){
        		var i = 0;
	        	$.each(data, function(index, rData){
	        		var r = [];
					$.each(_columns, function(idx, colname){
						var val = "";
						switch(colname){
							case "STT": val = i+1; break;
							case "RF_TYPE":
								val='<input class="hiden-input" value="'+rData[colname]+'">' + rfType[rData[colname]];
								break;
							case "TIMEPLUGIN":
							case "TIMEPLUGOUT":
								val='<input class="hiden-input" value="'+rData[colname]+'">' + $("#time-plug option[value='"+rData[colname]+"']").text();
								break;
							case "ROUNDING":
								val='<input class="hiden-input" value="'+rData[colname]+'">' + $("#round-type option[value='"+rData[colname]+"']").text();
								break;
							default:
								val = rData[colname] ? rData[colname] : "";
								break;
						}
						r.push(val);
					});
					i++;
					rows.push(r);
	        	});
        	}

        	tbl.DataTable( {
				data: rows,
				paging: false,
				columnDefs: [
					{ type: "num", className:"text-center", targets: _columns.indexOf("STT") }
				],
				order: [[ _columns.indexOf("STT"), 'asc' ]],
				keys: {
			        columns: ':not(:eq(0), :eq(1))'
			    },
	            autoFill: {
	                focus: 'focus'
	            },
	            scrollY: '40vh',
	            select: true
			} );

			tbl.realign();
	        tbl.editableTableWidget({editor: $("#rf-type, #time-plug, #round-type, #editor-input")});
        }

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
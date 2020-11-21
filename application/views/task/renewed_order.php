<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />

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
		width: 100%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	#INV_DRAFT_TOTAL span.col-form-label{
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.add-payer {
		flex: 1;          /* shorthand for: flex-grow: 1, flex-shrink: 1, flex-basis: 0 */
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}

	.add-payer-container {
		transform: scaleX(0);
		position: absolute;
		width: 100%;
		height: 100%;

		top: 0;
		left: 0;

		background: #8e9eab; /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #8e9eab, #eef2f3); /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #8e9eab, #eef2f3);

		-webkit-transition: transform 1s linear; /* For Safari 3.1 to 6.0 */
		transition: transform 1s linear;
		transform-origin: left center;
		z-index: 1;
		padding: 7px 0 7px 20px;
	}

	.payer-show{
		transform: scaleX(1);
	}

	#payer-modal .dataTables_filter{
		padding-left: 10px!important;
	}

</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">GIA HẠN LỆNH</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row pl-1">
					<div class="col-3 ibox mb-0 border-e pb-1 pt-3">
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Từ ngày</label>
							<div class="col-sm-7 input-group input-group-sm">
								<input class="form-control form-control-sm text-center input-required" id="fromDate" type="text" placeholder="Từ ngày" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Đến ngày</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm text-center input-required" id="toDate" placeholder="Đến ngày" type="text" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số PIN</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="pinCode" placeholder="Số PIN" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số lệnh</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="eirNo" placeholder="Số lệnh" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số container</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="cntrNo" placeholder="Số container" type="text">
							</div>
						</div>

						<div class="row form-group mt-4">
							<div class="col-sm-7 input-group ml-sm-auto">
								<button id="reload" class="btn btn-warning btn-sm btn-block" title="Tìm kiếm">
									<span class="btn-icon"><i class="fa fa-search"></i>Tìm kiếm</span>
								</button>
							</div>
						</div>

						<span class="row" style="border-bottom: 1px solid #ddd"></span>
						
						<div class="row form-group mt-3">
							<div class="col-sm-5 input-group m-sm-auto">
								<label class="checkbox checkbox-inline checkbox-blue col-form-label">
									<input type="checkbox" name="hasPayment" id="hasPayment" value="0">
									<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
									Tính cước
								</label>
							</div>
							<div class="col-sm-7">
								<button id="save" class="btn btn-primary btn-sm btn-block" 
																data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu"
																title="Lưu dữ liệu">

									<span class="btn-icon"><i class="fa fa-save"></i>Lưu dữ liệu</span>
								</button>
							</div>
						</div>

						<div class="payment-details mt-4" style="display: none; ">
							<div class="row form-group">
								<label class="col-sm-5 col-form-label" title="Đối tượng thanh toán">Đối tượng TT</label>
								<div class="col-sm-7 input-group">
									<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
									<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
											title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
										<i class="ti-search"></i>
									</span>
								</div>
								<input class="hiden-input" id="cusID" readonly>
								<input class="hiden-input" id="payment-type" readonly>
							</div>
							<div id="INV_DRAFT_TOTAL">
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Thành tiền</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-blue" id="AMOUNT"></span>
									</div>
								</div>
								<div class="row form-group hiden-input">
									<label class="col-sm-4 col-form-label">Giảm trừ</label>
									<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT"></span>
								</div>
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Tiền thuế</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-blue" id="VAT"></span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-5 col-form-label">Tổng tiền</label>
									<div class="col-sm-7 input-group">
										<span class="col-form-label text-right font-bold text-danger" id="TAMOUNT"></span>
									</div>
								</div>
							</div>

							<div class="row form-group mt-4">
								<div class="col-sm-7 ml-sm-auto">
									<button id="calculate" class="btn btn-outline-secondary btn-sm btn-block" 
															data-loading-text="<i class='la la-spinner spinner'></i>Đang tính"
															title="Tính cước">

										<span class="btn-icon"><i class="fa fa-calculator"></i>Tính cước</span>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- ///////////////////////////////// -->
					<div class="col-9 pl-3 pr-0">
						<div class="ibox mb-0 border-e p-3 content-group">
							<div class="table-responsive">
								<table id="tbl-content" class="table table-striped display nowrap" cellspacing="0"  style="width: 100%">
									<thead>
									<tr>
										<th col-name="STT">STT</th>
										<th col-name="rowguid">RowGuid</th>
										<th col-name="EIRNo" class="editor-cancel">Số lệnh</th>
										<th col-name="CntrNo" class="editor-cancel">Số container</th>
										<th col-name="PinCode" class="editor-cancel">Số PIN</th>
										<th col-name="ExpDate" class="editor-cancel">Hạn lệnh</th>
										<th col-name="ExpPluginDate" class="editor-cancel">Hạn điện lạnh</th>
										<th col-name="NewExpDate" class="data-type-date">Gia hạn lệnh</th>
										<th col-name="NewExpPluginDate" class="data-type-datetime">Gia hạn điện lạnh</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>

						<div class="ibox mb-0 border-e p-3 mt-3 payment-details" style="display: none;">
							<div class="table-responsive">
								<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0">
									<thead>
									<tr>
										<th>STT</th>
										<th>Số phiếu tính cước</th>
										<th>Số lệnh</th>
										<th>Mã biểu cước</th>
										<th>Tên biểu cước</th>
										<th>ĐVT</th>
										<th>Loại công việc</th>
										<th>PTGN</th>
										<th>Loại hàng</th>
										<th>Kích cỡ ISO</th>
										<th>Hàng/rỗng</th>
										<th>Nội/ngoại</th>
										<th>Số lượng</th>
										<th>Đơn giá</th>
										<th>Chiết khấu (%)</th>
										<th>Đơn giá CK</th>
										<th>Đơn giá sau CK</th>
										<th>Thành tiền</th>
										<th>Thuế (%)</th>
										<th>Tiền thuế</th>
										<th>Tổng tiền</th>
										<th>Loại tiền</th>
										<th>IX_CD</th>
										<th>CNTR_JOB_TYPE</th>
										<th>VAT_CHK</th>
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
</div>

<!--payer modal-->
<div class="modal fade" id="payer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn đối tượng thanh toán</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-payer" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0"  style="width: 100%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Mã ĐT</th>
							<th>MST</th>
							<th>Tên</th>
							<th>Địa chỉ</th>
							<th>HTTT</th>
						</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer" style="position: relative; padding: 22px 15px !important">
				<div class="add-payer-container">
					<div class="row">
						<div class="col-sm-11 col-xs-11">
							<div class="row">
								<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
									<div class="row form-group">
										<label class="col-sm-3 col-form-label" title="Mã số thuế">MST</label>
										<div class="col-sm-9">
											<input class="form-control form-control-sm" id="add-payer-taxcode" type="text" placeholder="Mã số thuế">
										</div>
									</div>
								</div>

								<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<div class="row form-group">
										<label class="col-sm-2 col-form-label" title="Tên đối tượng thanh toán">Tên</label>
										<div class="col-sm-10">
											<input class="form-control form-control-sm" id="add-payer-name" type="text" placeholder="Tên">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="row form-group">
										<label class="col-sm-1 col-form-label" title="Địa chỉ">Địa chỉ</label>
										<div class="col-sm-11">
											<input class="form-control form-control-sm" id="add-payer-address" type="text" placeholder="Địa chỉ">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-1 col-xs-1" style="margin: auto 0;">
							<div class="row">
								<div class="col-sm-12 col-xs-12">
									<div class="row form-group">
										<a id="save-payer" class="btn btn-sm text-primary" title="Lưu" style="padding: 14px; font-size: 1.2rem">
											<span class="btn-icon"><i class="fa fa-save"></i></span>
										</a>
									</div>
									<div class="row form-group">
										<a id="close-payer-content" class="btn btn-sm text-danger" title="Đóng lại" style="padding: 14px; font-size: 1.3rem">
											<span class="btn-icon"><i class="fa fa-close"></i></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="add-payer">
					<button id="b-add-payer" class="btn btn-outline-success" title="Thêm khách hàng">
						<i class="fa fa-plus"></i>
						Thêm khách hàng
					</button>
				</div>

				<button type="button" id="select-payer" class="btn btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _colContent = ["STT", "rowguid", "EIRNo", "CntrNo", "PinCode", "ExpDate", "ExpPluginDate", "NewExpDate", "NewExpPluginDate"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"],
			_colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
								, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
								, "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"];

		var tblContent = $('#tbl-content');

		var payers= {}, _lstOrder = {};

		// ------------binding shortcut key press------------
		ctrlDown = false,
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
	    $('#fromDate, #toDate').datepicker({
			format: "dd/mm/yyyy",
			startDate: moment().format('DD/MM/YYYY'),
			todayHighlight: true,
			autoclose: true
		});

		$('#fromDate').val(moment().subtract(1, "months").format('DD/MM/YYYY'));
		$('#toDate').val(moment().format('DD/MM/YYYY'));

        var dtContent = tblContent.DataTable({
			columnDefs: [
				{
					 type: "num", className: "text-center", targets: _colContent.indexOf("STT")
				},
				{
					 visible: false, targets: _colContent.indexOf("rowguid")
				},
				{
					className: 'text-center',
					width: "150px",
					visible: false,
					targets: _colContent.getIndexs(["ExpPluginDate", "NewExpPluginDate"])
				},
				{
					className: 'text-center',
					width: "150px",
					targets: _colContent.indexOf("NewExpDate"),
					render: function (data, type, full, meta) {
						data = data ? data.split(" ")[0] + " 23:59:59" : "";
						return data;
					}
				},
				{
					className: 'text-center',
					targets: _colContent.getIndexs(["EIRNo", "CntrNo", "PinCode", "ExpDate", "NewExpDate"])
				}
			],
			buttons: [],
			infor: false,
			scrollY: '236px',
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus',
                columns: _colContent.getIndexs(["ExpPluginDate", "NewExpDate", "NewExpPluginDate"])
            },
            select: true,
            rowReorder: false,
            arrayColumns: _colContent
		});

		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '217px'
		});

		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 9,
				boundaryScale: 0.95
			},
			columnDefs: [
				{
					 type: "num"
					,targets: [0]
				},
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-250'>" + data + "</div>";
					},
					targets: _colPayer.getIndexs(["CusName", "Address"])
				}
			],
			buttons: [],
			infor: false,
			scrollY: '45vh'
		});

		load_payer();

		tblContent.editableTableWidget();

///////// SEARCH PAYER
		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val( $( r ).find( 'td:eq(' + _colPayer.indexOf("VAT_CD") + ')' ).text() );
			$('#cusID').val( $( r ).find( 'td:eq( ' + _colPayer.indexOf("CusID") + ')' ).text() );

			$("#payment-type").val( $( r ).find( 'td:eq( ' + _colPayer.indexOf("CusType") + ')' ).text() );

			// fillPayer();

			$('#taxcode').trigger("change");
		});
		$('#search-payer').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			$("#payment-type").val( $( r ).find( 'td:eq( ' + _colPayer.indexOf("CusType") + ')' ).text() );

			// fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
///////// END SEARCH PAYER

		$('#hasPayment').on("change", function(){
			if( $(this).is(":checked") ){
				$("#save").attr({"title": "Tính tiền", "data-loading-text": "<i class='la la-spinner spinner'></i>Đang tính"})
							.html('<span class="btn-icon"><i class="fa fa-credit-card"></i>Tính tiền</span>');

				tblContent.parent().css("height", "158px");

				$( ".payment-details" ).show("slide", { direction: "up" }, 1000);

			}else{
				$("#save").attr({"title": "Lưu dữ liệu", "data-loading-text": "<i class='la la-spinner spinner'></i>Đang lưu"})
							.html('<span class="btn-icon"><i class="fa fa-save"></i>Lưu dữ liệu</span>');

				$( ".payment-details" ).hide("slide", { direction: "up" }, 1000, function(){
					tblContent.parent().css( "height", "236px" );
				});
			}
		});

		$("#reload").on("click", function(){

			$('#tbl-inv').dataTable().fnClearTable();

			$('#AMOUNT').text("");
			$('#DIS_AMT').text("");
			$('#VAT').text("");
			$('#TAMOUNT').text("");

			tblContent.waitingLoad();

			var formData = {
				"action": "view",
				"act": "search",
				"fromDate": $("#fromDate").val(),
				"toDate": $("#toDate").val(),
				"eirNo": $("#eirNo").val(),
				"cntrNo": $("#cntrNo").val(),
				"pinCode": $("#pinCode").val()
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					var rows = [];

		        	if(response.list && response.list.length > 0){
						var data = response.list;

		        		var i = 0;
		        		var showPluginCol = false;

		        		$("#cusID").val(data[0]["CusID"]);
		        		$("#taxcode").val( payers.filter(p=> p.CusID == data[0]["CusID"]).map( x => x.VAT_CD )[ 0 ] );
		        		$("#payment-type").val( payers.filter(p=> p.CusID == data[0]["CusID"]).map( x => x.CusType )[ 0 ] );

			        	$.each(data, function(index, rData){
			        		var r = [];
							$.each(_colContent, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "ExpPluginDate":
										if( rData[ colname ] ){
											showPluginCol = true;
											val = getDateTime( rData[ colname ] );
										}
										break;
									case "ExpDate":
									case "NewExpDate":
									case "NewExpPluginDate":
										val = getDateTime( rData[ colname ] );
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

		        	tblContent.dataTable().fnClearTable();

		        	if(rows.length > 0){
						tblContent.dataTable().fnAddData(rows);
		        	}

		        	tblContent.DataTable()
					        		.columns( _colContent.getIndexs(["ExpPluginDate", "NewExpPluginDate"]) ).visible(showPluginCol);
				},
				error: function(err){
					console.log(err);
				}
			});
		});

		$('#calculate').on("click", function(){
			if( !$("#cusID").val() ){

				$("#cusID").parent().addClass("error");

				$(".toast").remove();

				toastr["error"]("Chưa chọn đối tượng thanh toán!");

				return;
			}

			$("#cusID").parent().removeClass("error");

			$(this).button('loading');
			load_payment();
		});

		$('#save').on('click', function () {
			$(this).button("loading");

			if( $( "#hasPayment" ).is(":checked") ){
				switch( $("#payment-type").val() ){
					case "M":
						publishInv();
						break;
					case "C":
						saveData();
						break;
					case "":
					default:
						toastr["error"]("Không xác định được hình thức thanh toán của đối tượng này!");
						break;
				}
			}else{
				updateData();
			}
		});

		function load_payer(){
			var tblPayer = $('#search-payer');

			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_payer'
				},
				type: 'POST',
				success: function (data) {
					var rows = [];

					if(data.payers && data.payers.length > 0){
						payers = data.payers;

		        		var i = 0;
			        	$.each(payers, function(index, rData){
			        		var r = [];
							$.each(_colPayer, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "CusType":
										val = !rData[colname] ? "" : (rData[colname] == "M" ? "Thu ngay" : "Thu sau");
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

		        	tblPayer.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblPayer.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					tblPayer.dataTable().fnClearTable();
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		};

		function getEirInfoUpdated()
		{
			var checkData = tblContent.DataTable().rows(".editing").data().toArray();
			if(checkData.length == 0){
				return [];
			}

			var datas = [];
			$.each(checkData, function(idx, item){
				if( item[ _colContent.indexOf( "NewExpDate" ) ] || item[ _colContent.indexOf( "NewExpPluginDate" ) ] ){
					var ret = {
						"rowguid": item[ _colContent.indexOf( "rowguid" ) ],
						"EIRNo": item[ _colContent.indexOf( "EIRNo" ) ],
						"ExpDate": item[ _colContent.indexOf( "ExpDate" ) ],
						"NewExpDate": item[ _colContent.indexOf( "NewExpDate" ) ] ? item[ _colContent.indexOf( "NewExpDate" ) ].split(" ")[0] + " 23:59:59" : "",
						"ExpPluginDate": item[ _colContent.indexOf( "ExpPluginDate" ) ],
						"NewExpPluginDate": item[ _colContent.indexOf( "NewExpPluginDate" ) ]
					};
					datas.push(ret);
				}
			});

			return datas;
		}

		function load_payment()
		{
			var datas = getEirInfoUpdated();

			if(datas.length == 0){
				$(".toast").remove();
				toastr["warning"]("Chưa nhập thông tin gia hạn!");
				$("#calculate").button("reset");
				return;
			}

			var tblInv = $('#tbl-inv');

			tblInv.waitingLoad();

			var formdata = {
				"action": "view",
				"act": "load_payment",
				"cusID": $("#cusID").val(),
				"datas": datas
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {

					if(!data.results || data.results.length == 0){
						toastr["warning"]("Không tìm thấy biểu cước phù hợp! Vui lòng kiểm tra lại!");
						$('#tbl-inv').DataTable().clear().draw();
						return;
					}

					if(data.error && data.error.length > 0){
						$.each(data.error, function(){
							toastr["warning"](this);
						});
					}

					var rows = [];
					if(data.results && data.results.length > 0)
					{
						var lst = data.results, stt = 1;
						_lstOrder = data.renewed_ord ? data.renewed_ord : {};

						for (i = 0; i < lst.length; i++) {
							rows.push([
								(stt++)
								, lst[i].DraftInvoice
								, lst[i].OrderNo ? lst[i].OrderNo : ""
								, lst[i].TariffCode
								, lst[i].TariffDescription
								, lst[i].Unit
								, lst[i].JobMode
								, lst[i].DeliveryMethod
								, lst[i].Cargotype
								, lst[i].ISO_SZTP
								, lst[i].FE
								, lst[i].IsLocal
								, lst[i].Quantity
								, lst[i].StandardTariff
								, 0
								, lst[i].DiscountTariff
								, lst[i].DiscountedTariff
								, lst[i].Amount
								, lst[i].VatRate
								, lst[i].VATAmount
								, lst[i].SubAmount
								, lst[i].Currency
								, lst[i].IX_CD
								, lst[i].CNTR_JOB_TYPE
								, lst[i].VAT_CHK
							]);
						}
					}

					if(rows.length > 0){
						var n = rows.length;
						rows.push([
							n
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, ''
							, data.SUM_AMT
							, ''
							, data.SUM_VAT_AMT
							, data.SUM_SUB_AMT
							, ''
							, ''
							, ''
							, ''
						]);
						$('#AMOUNT').text($.formatNumber(data.SUM_AMT, { format: "#,###", locale: "us" }));
						$('#DIS_AMT').text($.formatNumber(data.SUM_DIS_AMT, { format: "#,###", locale: "us" }));
						$('#VAT').text($.formatNumber(data.SUM_VAT_AMT, { format: "#,###", locale: "us" }));
						$('#TAMOUNT').text($.formatNumber(data.SUM_SUB_AMT, { format: "#,###", locale: "us" }));
					}

					$('#tbl-inv').DataTable( {
						data: rows,
						info: false,
						paging: false,
						searching: false,
						buttons: [],
						columnDefs: [
							{ targets: [0, 21], className: "text-center" },
							{ targets: [12], className: "text-right" },
							{ targets: [13, 14, 15, 16, 17, 18, 19, 20], className: "text-right"
								, render: $.fn.dataTable.render.number( ',', '.', 2)
							},
							{ targets: [22, 23, 24], className: "hiden-input" }
						],
						scrollY: '30vh',
						createdRow: function(row, data, dataIndex){
							if(dataIndex == rows.length - 1){
								$(row).addClass('row-total');

								$('td:eq(0)', row).attr('colspan', 17);
								$('td:eq(0)', row).addClass('text-center');
								for(var i = 1; i <= 16; i++ ){
									$('td:eq('+i+')', row).css('display', 'none');
								}

								this.api().cell($('td:eq(0)', row)).data('TỔNG CỘNG');
							}
						}
					} );

					$('#calculate').button("reset");
				},
				error: function(err){
					tblInv.dataTable().fnClearTable();
					$('#calculate').button("reset");
					$(".toast").remove();
					toastr["error"]( "Có lỗi xảy ra! Vui lòng liên hệ với quản trị viên!" );
					console.log(err);
				}
			});
		}

		function addOrdersInfo(){

			$.each(_lstOrder, function(idx, item) {
				item['PTI_Hour'] = 0;

				item['DMETHOD_CD'] = 'NULL';
				item['CusID'] = $('#taxcode').val(); //*
				item['PAYER_TYPE'] = getPayerType( item['CusID'] );

				item['OPERATIONTYPE'] = 'NULL';

				item['PAYMENT_TYPE'] = $('#payment-type').val();
				item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

				delete item["EIRNo"];
			});
		}

		function getPayerType(id){
			if(payers.length == 0 ) return "";
			var py =payers.filter(p=> p.CusID == id);
			if(py.length == 0) return "";
			if(py[0].IsOpr == "1") return "SHP";
			if(py[0].IsAgency == "1") return "SHA";
			if(py[0].IsOwner == "1") return "CNS";
			if(py[0].IsLogis == "1") return "FWD";
			if(py[0].IsTrans == "1") return "TRK";
			if(py[0].IsOther == "1") return "DIF";
			return "";
		}

		//PUBLISH INV
		function publishInv()
		{
			var selectPayer = payers.filter( p => p.CusID == $("#taxcode").val() && p.VAT_CD == $("#cusID").val() );

			if(!selectPayer){
				$("toast").remove();
				toastr["error"]( "Không xác định được đối tượng thanh toán!" );
				return;
			}

			addOrdersInfo();

			var datas = getInvDraftDetail();

			var formData = {
				cusTaxCode : $('#taxcode').val(),
				cusAddr : selectPayer.map( x => x.Address )[0],
				cusName : selectPayer.map( x => x.CusName )[0],
				sum_amount : $('#AMOUNT').text(),
				vat_amount : $('#VAT').text(),
				total_amount : $('#TAMOUNT').text(),
				datas : datas
			};

			$.ajax({
				url: "<?=site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if(data.error){
						$("#save").button("reset");
						$('.toast').remove();
						toastr["error"]( data.error );
						return;
					}
					saveData(data);
				},
				error: function(err){
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi phát hành hóa đơn! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
					console.log(err);
				}
			});
		}

		//SAVE DATA
		function saveData(invInfo){
			var drDetail = getInvDraftDetail();
			var drTotal = {};

			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});

			if(drDetail.length == 0) {
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin hóa đơn!');
				return;
			}

			var formData = {
				'action': 'save',
				'updateEIR': getEirInfoUpdated(),
				'data': {
					'odr': _lstOrder
				}
			};

			if (typeof invInfo !== "undefined" && invInfo !== null) {
				formData.data["draft_detail"] = drDetail;
				formData.data["draft_total"] = drTotal;
				formData.data["invInfo"] = invInfo;
			}else{
				//trg hop thu sau, block ui ở đây
				$('#payment-modal').find('.modal-content').blockUI();
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if(data.invInfo){
						var form = document.createElement("form");
						form.setAttribute("method", "post");
						form.setAttribute("action", "<?=site_url(md5('Task') . '/' . md5('payment_success'));?>");

						var input = document.createElement('input');
						input.type = 'hidden';
						input.name = "invInfo";
						input.value = JSON.stringify(data.invInfo);
						form.appendChild(input);

						document.body.appendChild(form);
						form.submit();
						document.body.removeChild(form);
					}else{
						toastr["success"]("Lưu dữ liệu thành công!");
						location.reload(true);
					}
				},
				error: function(xhr, status, error){
					console.log(xhr);
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi lưu lệnh! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
				}
			});
		}

		//UPDATE DATA ONLY
		function updateData(){
			var formData = {
				"action": "save",
				"act": "updateOnly",
				"updateEIR": getEirInfoUpdated()
			};

			if(formData.updateEIR.length == 0){
				$(".toast").remove();
				toastr["warning"]( "Chưa nhập thông tin gia hạn" );
				$("#save").button("reset");
				return;
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskRenewedOrder'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					if( data.message ){
						if(data.message.includes("error")){
							$("#save").button("reset");
							$(".toast").remove();
							toastr["error"]( data.message );
							return;
						}
					}

					toastr["success"]("Cập nhật thành công!");
					location.reload(true);
				},
				error: function(xhr, status, error){
					console.log(xhr);
					$("#save").button("reset");
					$('.toast').remove();
					toastr["error"]("Có lỗi xảy ra khi cập nhật thông tin! <br/>Vui lòng thao tác lại hoặc liên hệ với QTV !");
				}
			});
		}

		function getInvDraftDetail(){
			var rows = [];
			$('#tbl-inv').find('tbody tr:not(.row-total)').each(function() {
				var nrows = [];
				var ntds = $(this).find('td:not(.dataTables_empty)');
				if(ntds.length > 0)
				{
					ntds.each(function(td){
						nrows.push($(this).text() == "null" ? "" : $(this).text());
					});
					rows.push(nrows);
				}
			});

			var drd = [];
			if(rows.length == 0 ) return;
			$.each(rows, function (idx, item) {
				var temp = {};
				for(var i = 1; i <= _colsPayment.length - 1; i++){
					temp[_colsPayment[i]] = item[i];
				}
				temp['Remark'] = $.unique(_lstOrder.map(p=> p.CntrNo)).toString();
				drd.push(temp);
			});
			return drd;
		}

	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
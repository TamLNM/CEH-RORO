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

	.inputGroup label{
		padding: 12px 17px;
	    width: 100%;
	    display: block;
	    text-align: left;
	    color: #949393;
	    cursor: pointer;
	    position: relative;
	    z-index: 2;
	    transition: color 200ms ease-in;
	    overflow: hidden;

	    border: 1px inset;
	    box-shadow: inset 0 1px 4px #cecece!important;
	}

	.inputGroup label:before{
		width: 10px;
        height: 10px;
        border-radius: 50%;
        content: '';
        background-color: #2f8db1;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%) scale3d(1, 1, 1);
        transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
        opacity: 0;
        z-index: -1;
	}

	.inputGroup label:after{
		width: 32px;
        height: 32px;
        content: '';
        border: 2px solid #D1D7DC;
        background-color: #fff;
        background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
        background-repeat: no-repeat;
        background-position: 2px 3px;
        border-radius: 50%;
        z-index: 2;
        position: absolute;
        right: 7px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        transition: all 200ms ease-in;
	}

	.inputGroup input:checked ~ label {
		color: #fff;
	}

	.inputGroup input:checked ~ label:before {
		transform: translate(-50%, -50%) scale3d(56, 56, 1);
	    opacity: 1;
	}

	.inputGroup input:checked ~ label:after {
		background-color: #28a745;
	    border-color: #fff;
	}

	.inputGroup input {
	    width: 32px;
	    height: 32px;
	    order: 1;
	    z-index: 2;
	    position: absolute;
	    right: 5px;
	    top: 50%;
	    transform: translateY(-50%);
	    cursor: pointer;
	    visibility: hidden;
    }

	.inputGroup {
	    background-color: #fff;
	    display: block;
	    margin-top: 7px;
	    position: relative;
	    min-width: 170px;
	}
	.new-booking{
		padding: 1.5rem!important;
		font-size: 15px!important;
	}

	.new-booking .form-group{
		margin-bottom: 1.5rem!important;
	}
	.transition-width{
		-webkit-transition: width 1s, height 2s; /* For Safari 3.1 to 6.0 */
		transition: width 1s, height 2s;
	}

	#conts-modal .dataTables_filter{
		padding-left: 15px;
	}

	#conts-modal .dt-buttons {
		padding-right: 15px;
	}

	.fleft {
		flex: 1;          /* shorthand for: flex-grow: 1, flex-shrink: 1, flex-basis: 0 */
		display: flex;
		justify-content: flex-start;
		align-items: center;
	}
</style>

<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title mr-4">BOOKING</div>
				<div class="button-bar-group mr-3">
					<button id="find-booking" class="btn btn-outline-warning btn-sm mr-1" title="Tìm booking">
						<span class="btn-icon"><i class="fa fa-search"></i>Tìm Booking</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" 
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e" >
				<div class="row pl-1">
					<div class="col-4 ibox border-e new-booking mx-auto" >
						<div class="input-group mb-3" style="border-bottom: 1px solid #eee">
							<div class="inputGroup mx-auto">
								<input id="assignCntr" name="isAssignCntr" value="Y" type="radio" checked="" />
								<label for="assignCntr">Chỉ định</label>
							</div>
							<div class="inputGroup mx-auto">
								<input id="notAssignCntr" name="isAssignCntr" value="N" type="radio"/>
							    <label for="notAssignCntr">Không chỉ định</label>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Ngày tạo</label>
							<div class="col-sm-7 input-group input-group-sm">
								<input class="form-control form-control-sm text-center" id="fromDate" type="text" placeholder="Ngày tạo" readonly>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Hiệu lực đến *</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm text-center input-required" id="toDate" placeholder="Hiệu lực đến" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Số Booking *</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm input-required" id="bookingNo" placeholder="Số Booking" type="text">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Hãng KT *</label>
							<div class="col-sm-7 input-group">
								<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-live-search="true" data-width="100%" >
									<option value="" selected>--[chọn hãng khai thác]--</option>
									<?php if(isset($oprs) && count($oprs) > 0){ foreach ($oprs as $item){ ?>
										<option value="<?= $item['CusID'] ?>"><?= $item['CusID'] ?></option>
									<?php }} ?>
								</select>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Kích cỡ *</label>
							<div class="col-sm-7 input-group">
								<select id="sizetype" class="selectpicker input-required" data-live-search="true" data-style="btn-default btn-sm" data-width="100%" >
									<option value="" selected>--[chọn kích cỡ]--</option>
								</select>
							</div>
						</div>

						<div id="opt-qty" class="row form-group hiden-input">
							<label class="col-sm-5 col-form-label">Số lượng *</label>
							<div class="col-sm-7 input-group">
								<input type="number" min="1" value="1" class="form-control form-control-sm input-required" id="cntrQty" placeholder="Số lượng" type="text">
							</div>
						</div>

						<div id="opt-cont" class="row form-group">
							<label class="col-sm-5 col-form-label">Số container *</label>
							<div class="col-sm-7 input-group">
								<div class="input-group">
									<input class="form-control form-control-sm" id="cntrNo" type="text" placeholder="Container No.">
									<span id="cntrno-search" class="input-group-addon bg-white btn text-warning" title="Chọn" 
															 data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
								</div>
							</div>
						</div>

						<div class="row form-group">
							<label class="col-sm-5 col-form-label">Chủ hàng</label>
							<div class="col-sm-7 input-group">
								<input class="form-control form-control-sm" id="shipperName" placeholder="Chủ hàng" type="text">
							</div>
						</div>

						<span class="row" style="border-bottom: 1px solid #ddd"></span>
						
						<div class="row form-group mt-3" style="margin-bottom: 0px!important">
							<div class="col-sm-7 ml-sm-auto">
								<button id="save-booking" class="btn btn-primary btn-sm btn-block" 
																data-loading-text="<i class='la la-spinner spinner'></i>Đang lưu"
																title="Lưu dữ liệu">

									<span class="btn-icon"><i class="fa fa-save"></i>Lưu Booking</span>
								</button>
							</div>

						</div>
					</div>
					<!-- ///////////////////////////////// -->
					<div id="gridbooking" class="col-8 pl-3 pr-0" style="display: none;">
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

<!--conts modal-->
<div class="modal fade" id="conts-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 800px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách container</h5>
			</div>
			<div class="modal-body px-0">
				<div class="table-responsive">
					<table id="conts-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 100%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">Chọn</th>
							<th>Số container</th>
							<th>Vị trí bãi</th>
							<th>Số Niêm Chì</th>
							<th>Tình Trạng</th>
							<th>TLHQ</th>
							<th class="hiden-input" >rowguid</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div class="fleft">
					<button id="reload-conts" class="btn btn-sm btn-outline-warning" title="Tải lại danh sách container">
						<i class="fa fa-refresh"></i>
						Tải lại
					</button>
				</div>
				<button class="btn btn-sm btn-outline-primary" id="cont-select-all">
					<i class="fa fa-check-circle"></i>
					Chọn hết
				</button>

				<button class="btn btn-sm btn-outline-secondary" id="cont-clear-all">
					<i class="fa fa-ban"></i>
					Bỏ chọn hết
				</button>

				<button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
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

			_colsContList = ["Check", "CntrNo", "Location", "SealNo", "ContCondition", "cTLHQ", "rowguid"];

		var tblContent = $('#tbl-content'), tblConts = $( "#conts-list" );

		var payers= {}, _lstOrder = {}, _sizetypes = [], _conts = [];

		loadCntrBefore();

		<?php if( isset( $sztps ) && count( $sztps ) > 0 ) { ?>
			_sizetypes = <?= json_encode( $sztps ) ?>;
		<?php } ?>

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

		var dtContList = $('#conts-list').DataTable({
			columnDefs: [
				{
					className: 'hiden-input',
					targets: _colsContList.indexOf( "rowguid" )
				}
			],
			info: false,
			paging: false,
			buttons: [],
			scrollY: '300px'
		});

		new $.fn.dataTable.Buttons( dtContList, {
	        buttons: [
	            {
	                text: '<i class="fa fa-check"></i> Tất cả',
	                className: "btn btn-sm btn-outline-info all-cont",
	                action: function ( e, dt, node, conf ) {
	                   $( e.currentTarget ).parent().find("i.fa-check").remove();
	                   $( e.currentTarget ).parent().find(".btn-outline-info").removeClass("btn-outline-info").addClass("btn-outline-default");
	                   $( e.currentTarget ).addClass("btn-outline-info").find("span").prepend("<i class='fa fa-check'></i>");

	                   tblConts.DataTable().columns( 0 )
									        .search( "" )
									        .draw( false );
	                }
	            },
	            {
	                text: ' Đã chọn',
	                className: "btn btn-sm btn-outline-default checked-cont",
	                action: function ( e, dt, node, conf ) {
	                	$( e.currentTarget ).parent().find("i.fa-check").remove();
	                    $( e.currentTarget ).parent().find(".btn-outline-info").removeClass("btn-outline-info").addClass("btn-outline-default");
	                    $( e.currentTarget ).addClass("btn-outline-info").find("span").prepend("<i class='fa fa-check'></i>");

	                   tblConts.DataTable().columns( 0 )
									        .search( "checked" )
									        .draw( false );
	                }
	            },
	            {
	                text: ' Chưa chọn',
	                className: "btn btn-sm btn-outline-default uncheck-cont",
	                action: function ( e, dt, node, conf ) {
	                    $( e.currentTarget ).parent().find("i.fa-check").remove();
	                    $( e.currentTarget ).parent().find(".btn-outline-info").removeClass("btn-outline-info").addClass("btn-outline-default");
	                    $( e.currentTarget ).addClass("btn-outline-info").find("span").prepend("<i class='fa fa-check'></i>");

	                    tblConts.DataTable().columns( 0 )
									        .search( "uncheck" )
									        .draw( false );
	                }
	            }
	        ]
	    } );
	 
	    dtContList.buttons( 0, null ).container().prependTo(
	        dtContList.table().container()
	    );

		//---------datepicker modified---------

		$( '#toDate' ).datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:ss',
			minDate: new Date( moment() ),
			timeInput: true
		});

		$('#fromDate').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#toDate').val(moment().format('DD/MM/YYYY 23:59:59'));

		// tblContent.editableTableWidget();

		tblConts.on('click','tbody tr td', function () {
			var rowIdx = dtContList.cell( this ).index().row;

			var c = dtContList.cell( rowIdx, 0).node();
			var r = dtContList.row( rowIdx ).node();

			var chked = $( r ).find( "td:eq("+ _colsContList.indexOf("Check") +")" ).hasClass("ti-check");

			if( chked ){
				$( c ).removeClass( 'ti-check' );
				$( r ).removeClass( 'selected' );
			}else{
				$( c ).addClass( 'ti-check' );
				$( r ).addClass( 'selected' );
			}

			dtContList.cell( rowIdx, 0 ).data("<span class='hiden-input'>" + ( !chked ? "checked" : "uncheck" ) + "</span>");

			$( "#cntrNo" ).val( dtContList.rows( ".selected" ).count() + " cont được chọn" );
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

		$( "input[name='isAssignCntr']" ).on("change", function(e){
			// $( "#opt-cont" ).
			if( $( e.target ).val() == "1" ){
				$( "#opt-cont" ).removeClass("hiden-input");
				$( "#opt-qty" ).addClass("hiden-input");
			}else{
				$( "#opt-cont" ).addClass("hiden-input");
				$( "#opt-qty" ).removeClass("hiden-input");
			}
		});

		$( "#opr" ).on("change", function(){
			$( "#sizetype" ).find( "option[value != '']" ).remove();
			$( "#sizetype" ).selectpicker( "refresh" );

			tblConts.dataTable().fnClearTable();

			load_size_type( $( this ).val() );
		});

		$( "#conts-modal" ).on("shown.bs.modal", function(){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		$( "#find-booking" ).on("click", function(){
			$( "#gridbooking" ).toggle("slide", { direction: "right" }, 1000);

			if( $( "#gridbooking" ).is(":visible") ){
				$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
			}
		});

		$('#cntrno-search').on('click', function (e) {
			// #conts-modal

			if ( tblConts.DataTable().rows().count() > 0 ){
				if( tblConts.find("td.ti-check").length > 0 ){
					$("a.checked-cont").trigger( "click" );
				} 
				$(this).attr('data-target', '#conts-modal');
				return;
			}else{
				$(this).attr('data-target', '');
			}

			tblConts.dataTable().fnClearTable();

			var oprSelected = $( "#opr" ).val(), sztpSelected = $( "#sizetype" ).val();

			if( !oprSelected ){
				$( ".toast" ).remove();
				toastr["warning"]( "Chưa chọn hãng khai thác!" );
				return;
			}

			if( !sztpSelected ){
				$( ".toast" ).remove();
				toastr["warning"]( "Chưa chọn hãng kích cỡ container!" );
				return;
			}

			var findConts = _conts.filter( p=> p.OprID == oprSelected && p.ISO_SZTP == sztpSelected );

			if( !findConts || findConts.length == 0 ){
				$( ".toast" ).remove();
				toastr["warning"]( "Không có container nào đủ điều kiện làm lệnh!" );
				return;
			}

			loadGridConts( findConts );
			
		});

		$('#save-booking').on('click', function () {
			saveBooking();
		});

		function load_size_type( opr )
		{
			if( !_sizetypes || _sizetypes.length == 0 ){
				return;
			}

			var sztpByOpr = _sizetypes.filter( p => p.OprID == opr );
			var sz = $( "#sizetype" );

			if( sztpByOpr.length > 0 ){
				$.each( sztpByOpr, function( idx, item ){
					sz.append( "<option value='" + item.ISO_SZTP + "'>" + item.LocalSZPT + "</option>" );
				} );

				sz.selectpicker( "refresh" );
			}
		}

		function loadGridConts( findConts )
		{
			var rows = [];
			$.each( findConts, function( idx, item ){
				var r=[];
				$.each( _colsContList, function(i, t){
					var vlue = "";
					switch(t){
						case "Check": vlue = "<span class='hiden-input'>uncheck</span>"; break;
						case "cTLHQ":
							vlue = "<input type='text' class='hiden-input' value='"+ item[t] +"'> " 
									+ (item[t] == "1" ? "Đã thanh lý" : "Chưa thanh lý");
							break;
						case "Location": 
							vlue = item["cBlock"] + "-" + item["cBay"] + "-" + item["cRow"] + "-" + item["cTier"];
							vlue = vlue.replace("null-", "");
							break;
						default:
							vlue = item[t] ? item[t] : "";
					}
					r.push(vlue);
				})
				rows.push(r);
			} );

			tblConts.dataTable().fnClearTable();
        	if(rows.length > 0){
				tblConts.dataTable().fnAddData(rows);
        	}

        	$( "#cntrno-search" ).attr('data-target', '#conts-modal');
		}

		function loadCntrBefore()
		{
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskBooking'));?>",
				dataType: 'json',
				data: {
					'action': 'view',
					'act': 'load_cntr_for_booking'
				},
				type: 'POST',
				success: function (data) {
					if(data.conts && data.conts.length > 0){
						_conts = data.conts;
		        	}
				},
				error: function(err){
					console.log(err);
					toastr["error"]("Có lỗi xảy ra! Vui lòng liên hệ với kỹ thuật viên! <br/>Cảm ơn!");
				}
			});
		}

		function saveBooking()
		{
			if( $( ".input-required" ).has_required() ){
				$( ".toast" ).remove();
				toastr["error"]( "Các trường bắt buộc (*) không được để trống!" );
				return;
			}

			var isAssignCntr = $( 'input[name="isAssignCntr"]:checked' ).val();
			var cntrSelected = tblConts.DataTable().rows( ".selected" );

			if( isAssignCntr == "Y" && cntrSelected.count() == 0 ){
				$( "toast" ).remove();
				toastr["error"]( "Chưa chọn container để làm booking chỉ định!" );
				return;
			}

			var btnSaveBK = $( "#save-booking" );
			btnSaveBK.button("loading");

			var formData = {
				args: {
					isAssignCntr : isAssignCntr,
					BookingDate : $( '#fromDate' ).val(),
					ExpDate : $( '#toDate' ).val(),
					BookingNo : $( '#bookingNo' ).val(),
					OprID : $( '#opr' ).val(),
					ISO_SZTP : $('#sizetype').val(),
					LocalSZPT : $('#sizetype option:selected').text(),
					ShipName : $( "#shipperName" ).val(),
					StackingAmount : 0,
					CJMode_CD: "CAPR"
				},
				action: "save"
			};

			if( isAssignCntr == "Y" ){
				formData[ "args" ][ "BookAmount" ] = cntrSelected.count();
				formData[ "args" ][ "rowguids" ] = cntrSelected.data().toArray().map( p => p[ _colsContList.indexOf( "rowguid" ) ] );
			}else{
				formData[ "args" ]["BookAmount"] = $( "#cntrQty" ).val();
			}

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskBooking'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					btnSaveBK.button( "reset" );
					$( "toast" ).remove();
					$( "#bookingNo" ).val( "" );

					if( data.message ){
						var msg = data.message.split(":");
						if( msg && msg.length > 1 ){
							if( msg[0] == "success" ){
								dtContList.rows('.selected').remove().draw( false );
								$( ".all-cont" ).trigger( "click" );
							}

							toastr[ msg[0] ]( msg[1] );
							return;
						}
					}

					toastr["success"]( "Tạo mới booking thành công!" );

				},
				error: function(err){
					btnSaveBK.button( "reset" );
					$( "toast" ).remove();
					toastr["error"]( "Phát sinh lỗi khi lưu mới booking! <br/>Vui lòng liên hệ quản trị viên" );

					console.log(err);
				}
			});
		}

	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
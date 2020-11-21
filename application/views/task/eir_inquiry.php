<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<style>
	.wrapok {
		white-space:normal!important;
	}
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold;
		padding-right: 0 !important;
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

	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
	}
	.unchecked-Salan{
		pointer-events: none;
	}

	@media (min-width: 1024px) {
		.modal-dialog-mw   {
			min-width: 960px!important;
		}
	}

	@media (min-width: 960px) and (max-width: 1024px) {
		.modal-dialog-mw{
			min-width: 720px!important;
		}
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

	.img-thumbnail-detail{
		width: 80px;
		height: 80px;
		min-width: 80px;
		min-height: 80px;
		position: relative;
	}
	.img-thumbnail-detail + i.load-img {
		font-size: 26px;
		color: #ddd;
		position: absolute;
		left: calc(100% - (1.8rem * 2));
		top: calc(100% - (1.8rem * 2));
	}

	.img-thumbnail-detail i:hover{
		color: #adacac;
	}

	div.img-thumbnail-detail:hover{
		cursor: pointer;
		border: 2px dashed #adacac!important;
	}

	div.img-contain{
		position: relative;
	}

	div.img-contain:hover img.img-thumbnail-detail{
		cursor: pointer;
		border: 2px solid #adacac!important;
		opacity: 0.5;
	}

	table.dataTable.tbl-sumary-style thead tr,
	table.dataTable.tbl-sumary-style td{
		background: none!important;
		border: 0 none !important;
		cursor: default!important;
	}

	table.dataTable.tbl-sumary-style thead tr th{
		border-bottom: 1px solid #ccc!important;
	}

	table.dataTable.tbl-sumary-style tbody tr.selected{
		background-color: rgba(255,231,112,0.4)!important;
	}

	table.dataTable th, table.dataTable td {
	    border: 1px solid #fff !important;
	}

	table.tableDetails thead tr th{
        text-align: center;
        vertical-align: middle!important;
    }

    table.tableDetails th, table.tableDetails td{
        border: 1px solid #9EBAE0 !important;
    }

    table.tableDetails {
        border-right-color: #9EBAE0;
        margin: auto 0 !important;
    }

    table.tableDetails thead tr th{
        /*color: #000060;*/
        /*background-color: #bddcef;*/

        color: #000060;
        font-weight: bold;
        background: rgb(222,239,255); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(222,239,255,1) 0%, rgba(152,190,222,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(222,239,255,1) 0%,rgba(152,190,222,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(222,239,255,1) 0%,rgba(152,190,222,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#deefff', endColorstr='#98bede',GradientType=0 ); /* IE6-9 */
    }

    .tableDetails th label.checkbox span.input-span,
    .tableDetails td label.checkbox span.input-span{
    	height: 16px!important;
    	width: 16px!important;
    	left: 5px!important;
    	border-color: #000060!important;

    }
    .tableDetails th label.checkbox span.input-span:after,
    .tableDetails td label.checkbox span.input-span:after{
    	left: 5px!important;
    	top: 1px!important;
    }

    .link-cell:hover{
    	text-decoration: underline;
    }
</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">TRUY VẤN THÔNG TIN LỆNH</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row bg-white border-e pb-1 pt-3">
					<div class="col-12">
						<div class="row">

							<div class="col-xl-5 col-lg-5 col-md-6 col-sm-12 col-xs-12" style="border-right: 1px solid #eee">
								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Trạng thái</label>
									<div class="col-sm-9 form-group col-form-label">
										<label class="radio radio-outline-primary" style="padding-right: 15px!important;">
											<input name="SyncMark" type="radio" value="" checked>
											<span class="input-span"></span>
											Tất cả
										</label>
										<label class="radio radio-outline-primary" style="padding-right: 15px!important;">
											<input name="SyncMark" value="1" type="radio">
											<span class="input-span"></span>
											Đã đồng bộ
										</label>
										<label class="radio radio-outline-primary">
											<input name="SyncMark" value="0" type="radio">
											<span class="input-span"></span>
											Chưa đồng bộ
										</label>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Tàu/chuyến</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 col-form-label">Thời gian</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="issueDate" type="text" placeholder="Ngày tạo lệnh" readonly>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-3 col-form-label" for="orderNo">Tìm kiếm</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="searchValue" type="text" placeholder="Số lệnh, số PIN, số container">
									</div>
								</div>
							</div>

							<div class="col-xl-7 col-lg-7 col-md-6 col-sm-12 col-xs-12">
								
								<div class="row" style="border-bottom: 1px solid #eee">
									<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Tác nghiệp</label>
											<div class="col-sm-8 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="ALL" value="" checked="">
													<span class="input-span"></span>
													Tất cả
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-8 col-form-label ml-sm-auto">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="LAYN" value="0" checked="">
													<span class="input-span"></span>
													Giao container hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-8 col-form-label ml-sm-auto">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="CAPR" value="0" checked="">
													<span class="input-span"></span>
													Giao container vỏ
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="HBAI" value="0" checked="">
													<span class="input-span"></span>
													Hạ container hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="TRAR" value="0" checked="">
													<span class="input-span"></span>
													Hạ container vỏ
												</label>
											</div>
										</div>
									</div>

									<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12">
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="DH" value="0" checked="">
													<span class="input-span"></span>
													Đóng hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="RH" value="0" checked="">
													<span class="input-span"></span>
													Rút hàng
												</label>
											</div>
										</div>
										<div class="row form-group">
											<div class="col-sm-12 col-form-label">
												<label class="checkbox checkbox-blue">
													<input type="checkbox" name="cjmode" id="OTHER" value="0" checked="">
													<span class="input-span"></span>
													Dịch vụ thông thường
												</label>
											</div>
										</div>
									</div>
								</div>

								<div class="row pt-2" style="float: right; padding-right: 13px">
									<div class="col-sm-12">
										<div class="row form-group">
											<button type="button" id="loadData" 
													data-loading-text="<i class='la la-spinner spinner'></i>Đang nạp" class="btn btn-sm btn-primary ml-2">

												<i class="fa fa-refresh"></i>
												Nạp dữ liệu
											</button>
										</div>
									</div>
									
								</div>
							
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="ibox-footer border-top-0 mt-3">
				<div class="row">
					<div class="col-sm-4">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-sumary" class="table table-striped display nowrap tbl-sumary-style" cellspacing="0" style="width: 99.9%">
									<thead>
									<tr>
										<th class="editor-cancel">Tác nghiệp</th>
										<th class="editor-cancel">20</th>
										<th class="editor-cancel">40</th>
										<th class="editor-cancel">45</th>
										<th class="editor-cancel">Tổng</th>
									</tr>
									</thead>

									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<table id="tbl-ord-detail" class="table table-striped display table-bordered nowrap tableDetails"
					                                        cellspacing="0" style="border-collapse: collapse!important;">
			                <thead>
				                <tr>
									<th>STT</th>
									<th>
										<label class="checkbox checkbox-outline-ebony">
											<input type="checkbox" name="checkSync" value="*" style="display: none;">
											<span class="input-span"></span>
										</label>
									</th>
									<th>Trạng thái</th>
									<th >Tác nghiệp</th>
									<th >Số lệnh</th>
									<th >Số PIN</th>
									<th >Số container</th>
									<th >Kích cỡ</th>
									<th >Người thanh toán</th>
									<th >Chủ hàng</th>
									<th >Ghi chú</th>
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

<!--payment modal-->
<div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id">
	<div class="modal-dialog modal-dialog-mw-py" role="document">
		<div class="modal-content p-3">
			<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Thông tin thanh toán</h5>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-form-label" title="Mã KH/ MST">Mã KH/ MST</label>
							<span class="col-form-label" id="p-taxcode"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tên</label>
							<span class="col-form-label" id="p-payername"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Địa chỉ</label>
							<span class="col-form-label" id="p-payer-addr"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Thanh toán</label>
							<a class="col-form-label pr-5" id="p-money" style="pointer-events: none;"><i class="fa fa-check-square"></i> Chuyển khoản</a>
							<a class="col-form-label" id="p-credit" style="pointer-events: none;"><i class="fa fa-square"></i> Thu sau</a>
						</div>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4" id="INV_DRAFT_TOTAL">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tổng tiền thanh toán</h5>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Thành tiền</label>
							<span class="col-form-label text-right font-bold text-blue" id="AMOUNT"></span>
						</div>
						<div class="row form-group hiden-input">
							<label class="col-sm-4 col-form-label">Giảm trừ</label>
							<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Tiền thuế</label>
							<span class="col-form-label text-right font-bold text-blue" id="VAT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Tổng tiền</label>
							<span class="col-form-label text-right font-bold text-danger" id="TAMOUNT"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto">
					<button id="pay-atm" class="btn btn-rounded btn-gradient-purple">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ ATM</span>
					</button>
					<button class="btn btn-rounded btn-rounded btn-gradient-lime">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ MASTER, VISA</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-header">
				<div class="row col-xl-12">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt-1">
						<div class="form-group">
							<label class="radio radio-outline-primary" style="padding-right: 15px!important;">
								<input name="shipArrStatus" type="radio" value="1" checked>
								<span class="input-span"></span>
								Đến cảng
							</label>
							<label class="radio radio-outline-primary">
								<input name="shipArrStatus" value="2" type="radio">
								<span class="input-span"></span>
								Rời Cảng
							</label>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 pr-0">
						<div class="row form-group">
							<div class="col-sm-12 pr-0">
								<div class="input-group">
									<select id="cb-searh-year" class="selectpicker" data-width="30%" data-style="btn-default btn-sm">
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Nhập tên tàu">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body" style="padding: 10px 0">
				<div class="table-responsive">
					<table id="search-ship" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th>Mã Tàu</th>
							<th style="width: 20px">STT</th>
							<th>Tên Tàu</th>
							<th>Chuyến Nhập</th>
							<th>Chuyến Xuất</th>
							<th>Ngày Cập</th>
							<th>ShipKey</th>
							<th>BerthDate</th>
							<th>ShipYear</th>
							<th>ShipVoy</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div style="display: flex; flex: 1; justify-content: flex-start; align-items: center;">
					<button type="button" id="reload-ship" class="btn btn-sm btn-warning">
						<i class="fa fa-refresh"></i>
						Tải lại
					</button>
				</div>
				<button type="button" id="select-ship" class="btn btn-sm btn-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>
			</div>
		</div>
	</div>
</div>

<!--upload picture-->
<div class="modal fade" id="picture-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content" style="border-radius: .25rem; min-width: 100%">
			<div class="modal-body">
				<div class="row">
					<div class="col-10 text-center">
						<img id="preview-img" src="" class="rounded" style="height: 420px; margin: auto;">
					</div>
					<div id="show-image-side" class="col-2" style="border-left: 1px solid #ddd">
						<div class="row form-group mx-auto">
							<div class="img-contain mx-auto">
								<img src="" alt class="img-thumbnail img-thumbnail-detail rounded">
								<i class='la la-spinner spinner load-img'></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _colDetails = ["STT", "Select", "SyncMark", "CJModeName", "OrderNo", "PinCode", "CntrNo", "SIZE", "CusID", "SHIPPER_NAME", "Note"];
		var _colSumary = ["CJModeName", "SZ_20", "SZ_40", "SZ_45", "SumRow"];

		var _selectShipKey = '';

		var tblSumary = $("#tbl-sumary"), tblDetail = $( "#tbl-ord-detail" );

		var payers= {};
		<?php if(isset($payers) && count($payers) > 0){ ?>
			payers = <?= json_encode($payers);?>;
		<?php } ?>

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh',
			buttons: []
		});

		tblSumary.DataTable({
			language: { emptyTable: "", zeroRecords: "" },
			paging: false,
			searching: false,
			infor: false,
			ordering: false,
			scrollY: '40vh',
			buttons: [],
			columnDefs: [
				{ type: "num", className: "text-right", targets: _colSumary.getIndexs(["SZ_20", "SZ_40", "SZ_45", "SumRow"]) },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-200'>" + data + "</div>";
					},
					targets: _colSumary.indexOf("CJModeName")
				}
			]
		});

		$(".datatable-info-right").remove();

		$("#tbl-ord-detail").DataTable({
			paging: false,
			infor: false,
			scrollY: '35vh',
			buttons: [],
			rowsGroup: [4],
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colDetails.indexOf('STT') },
				{ className: "text-center", targets: _colDetails.indexOf('Select') },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-300'>" + data + "</div>";
					},
					targets: _colDetails.indexOf("Note")
				}
			],
			order: [[ _colDetails.indexOf('STT'), 'asc' ]],
		});

		// $('#issueDate').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#issueDate').daterangepicker({
		    timePicker: true,
		    startDate: moment().subtract('month', 1),
		    endDate: moment().format('DD/MM/YYYY'),
		    timePicker: false,
		    ranges: {
	           'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Tuần trước': [moment().subtract(6, 'days'), moment()],
	           'Tháng này': [moment().startOf('month'), moment().endOf('month')],
	           'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        },
		    locale: {
		      format: 'DD/MM/YYYY',
		      cancelLabel: "Hủy",
		      applyLabel: "Chọn",
		      customRangeLabel: "Tùy chọn"
		    }
		});

///////// SEARCH SHIP
		search_ship();

		$('#btn-search-ship').on('click', function () {
			search_ship();
		});
		$('#reload-ship').on("click", function(){
			$('#search-ship-name').val("");
			search_ship();
		})
		$(document).on('click','#search-ship tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#search-ship-name').on('keypress', function (e) {
			if(e.which == 13) {
				search_ship();
			}
		});
		$('#select-ship').on('click', function () {
			var r = $('#search-ship tbody').find('tr.m-row-selected').first();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

		});
		$('#unselect-ship').on('click', function () {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();

			$('#ship-modal').modal("toggle");
		});
///////// END SEARCH SHIP

// READ IMAGE
		$("#preview-img").attr("src", '<?=base_url('assets/img/no-img.jpg');?>');

		$("#picture-modal").on("show.bs.modal", function(e) {
			var orderNo = $( e.relatedTarget ).text();
			loadImage( orderNo  );
		});

		$(document).on("click", "img.img-thumbnail-detail", function(){
			$("#preview-img").attr("src", $( this ).attr( "src" ) );
		});

//END READ IMAGE

		$('#ship-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		$("input[id='ALL']").on("change", function() {
			$("input[name='cjmode']:not(#ALL)").prop("checked", $( this ).is(":checked"));
		});

		$("input[name='cjmode']:not(#ALL)").on("change", function() {
			$("input#ALL").prop("checked", false );
		});

		$(document).on("change", "th input[type='checkbox']", function() {
			$("input[name='checkSync']").prop("checked", $( this ).is(":checked"));
		});

		$("#loadData").on("click", function(){
			$( this ).button("loading");
			search_order();
		});

		function search_order(){
			tblSumary.dataTable().fnClearTable();
			tblDetail.waitingLoad();

			var isSync = $("input[name='SyncMark']:checked").val(),
				cjmodes = $("input[name='cjmode']:checked").map( function() { return this.id; }).get(),
				issueFrom = $("#issueDate").val().split("-")[0],
				issueTo = $("#issueDate").val().split("-")[1],
				searchVal = $("#searchValue").val();

			var formData = {
				"action": "view",
				"act": "search_order",
				"args" : {
					"SyncMark": isSync,
					"CJMode_CDs": cjmodes,
					"ShipKey": _selectShipKey,
					"IssueDateFrom": issueFrom.trim(),
					"IssueDateTo": issueTo.trim(),
					"searchValue": searchVal
				}
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEirInquiry'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					$( "#loadData" ).button("reset");
					var rows = [];
					if(data.results && data.results.length > 0) {
						
						var results = data.results.sort((a,b) => (a.OrderNo > b.OrderNo) ? 1 : ((b.OrderNo > a.OrderNo) ? -1 : 0));
						
						$.each( results, function( i, item ) {
							var r = [];
							$.each( _colDetails, function( idx, colname ){
								var val = "";
								switch(colname){
									case "STT":
										val = i+1;
										break;
									case "Select":
										if( item[ "SyncMark" ] != "1" )
										{
											val = '<label class="checkbox checkbox-outline-ebony">'
													+ '<input type="checkbox" name="checkSync" value="0" style="display: none;">'
													+ '<span class="input-span"></span>';
												+ '</label>';
										}else{
											val = "";
										}

										break;
									case "SyncMark":
										val = item[ colname ] == "1" ? "Đã đồng bộ" : "Chưa đồng bộ";
										break;
									case "PinCode":
										if ( item[ colname ] ){
											val = '<a target="_blank"'
												+' href="<?=site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=");?>'+ item[ colname ] +'" class="link-cell" title="Xem hóa đơn">'
												+ item[ colname ]
											+ '</a>';
										}else{
											val = "";
										}
										
										break;
									case "OrderNo":
										if( item[ colname ] ){
											val = '<a href="#" class="link-cell" data-toggle="modal" data-target="#picture-modal" title="Xem chứng từ đính kèm">'
												+ item[ colname ]
											+ '</a>';
										}else{
											val = "";
										}
										
										break;
									case "SIZE":
										val = getContSize( item[ "ISO_SZTP" ] );
										break;
									default:
										val = item[ colname ] ? item[ colname ] : "";
										break;
								}
								r.push( val );
							} );

							rows.push( r );

						} );
					}

					tblDetail.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblDetail.dataTable().fnAddData(rows);
		        	}

		        	var rowsCounter = [];
		        	if( data.countOrder && data.countOrder.length > 0 ){
		        		$.each( data.countOrder, function(i, item) {
		        			rowsCounter.push(
			        				[
			        					item.CJModeName,
			        					item.SZ_20,
			        					item.SZ_40,
			        					item.SZ_45,
			        					item.SumRow
			        				]
		        			);
		        		});
		        	}

		        	if(rowsCounter.length > 0){
						tblSumary.dataTable().fnAddData(rowsCounter);
		        	}
				},
				error: function(err){
					tblDetail.dataTable().fnClearTable();
					$( "#loadData" ).button("reset");
					$('.toast').remove();
					toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
					console.log(err);
				}
			});
		}

	});
	
	var contains = $("#show-image-side"),
		temp = contains.html();

	function loadImage( orderNo ){
		contains.html("").append( temp );
		$("#preview-img").attr( "src", '<?=base_url('assets/img/no-img.jpg');?>' );

		var formData = {
			'action': 'view',
			'act': 'load_img',
			'orderNo': orderNo
		};

		$.ajax({
			url: "<?=site_url(md5('Task') . '/' . md5('tskEirInquiry'));?>",
			dataType: 'json',
			data: formData,
			type: 'POST',
			success: function (data) {
				if( data.imgs && data.imgs.length > 0 ){
					$.each( data.imgs, function(index, fileName) {
						var testImg = new Image();
						testImg.onload = function(){

							var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

							img.next().css("display", "none");
							img.attr("src", this.src);

							$("#preview-img").attr( "src", this.src );

							if( index < data.imgs.length - 1 ){
								contains.append( temp );
							}
						};

						testImg.onerror = function(e){
							var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

							img.next().css("display", "none");
							img.attr("src", '<?=base_url('assets/img/no-img.jpg');?>' );
							$("#preview-img").attr( "src", '<?=base_url('assets/img/no-img.jpg');?>' );
						};

						testImg.src = '<?=base_url('assets/img/ct/');?>' + fileName;
					});
				}else{
					var img = contains.find(".img-thumbnail.img-thumbnail-detail:last");

					img.next().css("display", "none");
					img.attr("src", '<?=base_url('assets/img/no-img.jpg');?>' );
					$("#preview-img").attr( "src", '<?=base_url('assets/img/no-img.jpg');?>' );
				}
			},
			error: function(err){
				$('.toast').remove();
				toastr['error']("Có lỗi xảy ra! <br/>  Vui lòng liên hệ với bộ phận kỹ thuật! ");
				console.log(err);
			}
		});
	}

	function testImage(URL) {
	    var tester = new Image();
	    tester.onload = imageFound;
	    tester.onerror=imageNotFound;
	    tester.src=URL;
	}

	function imageFound() {
	    alert('That image is found and loaded');
	}

	function imageNotFound() {
	    alert('That image was not found.');
	}

	function getContSize(sztype){
        switch( sztype.substring(0, 1) ){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
        }
        return "0";
    }

	function search_ship(){
		$("#search-ship").waitingLoad();
		var formdata = {
			'action': 'view',
			'act': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-searh-year').val(),
			'shipname': $('#search-ship-name').val()
		};

		$.ajax({
			url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				var rows = [];
				if(data.vsls.length > 0) {
					for (i = 0; i < data.vsls.length; i++) {
						rows.push([
							data.vsls[i].ShipID
							, (i+1)
							, data.vsls[i].ShipName
							, data.vsls[i].ImVoy
							, data.vsls[i].ExVoy
							, getDateTime(data.vsls[i].ETB)
							, data.vsls[i].ShipKey
							, getDateTime(data.vsls[i].BerthDate)
							, data.vsls[i].ShipYear
							, data.vsls[i].ShipVoy
						]);
					}
				}
				$('#search-ship').DataTable( {
					scrollY: '35vh',
					paging: false,
					order: [[ 1, 'asc' ]],
					columnDefs: [
						{ className: "input-hidden", targets: [0, 6, 7] },
						{ className: "text-center", targets: [1] }
					],
					buttons: [],
					info: false,
					searching: false,
					data: rows
				} );
			},
			error: function(err){console.log(err);}
		});
	}
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>

<script src="<?=base_url('assets/vendors/dataTables/dataTables.rowsGroup.js');?>"></script>

<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
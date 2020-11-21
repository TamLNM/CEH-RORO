<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
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

	.scrollable-menu {
	    height: auto;
	    max-height: 200px;
	    overflow-x: hidden;
	}

	span.sub-text{
		padding-left: 10px;
		font-size: 75%;
	    color: #bbb;
	    font-style: italic;
	}

</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH HẠ CONTAINER HÀNG</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row bg-white border-e pb-1">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ngày lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="ref-date" type="text" placeholder="Ngày lệnh" readonly>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương án</label>
									<div class="col-sm-8">
										<select id="cntrclass" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="3" cjmode="HBAI" dmethod="BAI-XE" dmethod-salan="BAI-SALAN" selected>Hạ bãi xuất tàu</option>
											<option value="4" cjmode="HBAI" dmethod="BAI-XE" dmethod-salan="BAI-SALAN">Hạ nhập chuyển cảng</option>
											<option value="3" cjmode="XGTH" dmethod="TAU-XE" dmethod-salan="TAU-SALAN">Xuất giao thẳng</option>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-4 col-form-label">
										<label class="checkbox checkbox-blue">
											<input type="checkbox" name="chkSalan" id="chkSalan">
											<span class="input-span"></span>
											Sà lan
										</label>
									</div>
									<div class="col-sm-8 input-group input-group-sm">
										<div id="barge-ischecked" class="input-group unchecked-Salan">
											<input class="form-control form-control-sm" id="barge-info" type="text" placeholder="Mã/Năm/Chuyến" readonly>
											<span class="input-group-addon bg-white btn text-warning" id="btn-search-barge" data-toggle="modal" data-target="#barge-modal" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Tàu/chuyến *</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" 		data-target="#ship-modal">
											<i class="ti-search"></i>
										</span>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" for="bkno-blno">Số booking *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm input-required" id="bkno-blno" type="text" placeholder="Số booking">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-2 col-form-label" title="Chủ hàng">Chủ hàng *</label>
							<div class="col-sm-10">
								<input class="form-control form-control-sm input-required" id="shipper-name" type="text" placeholder="Chủ hàng">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-2 col-form-label">CMND/ĐT</label>
							<div class="col-sm-4 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cmnd" type="text" placeholder="CMND/ĐT">
							</div>
							<div class="col-sm-6 input-group input-group-sm">
								<input class="form-control form-control-sm" id="personal-name" type="text" placeholder="Người đại diện">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-2 col-form-label">Ghi chú</label>
							<div class="col-sm-10 input-group input-group-sm">
								<input class="form-control form-control-sm" id="remark" type="text" placeholder="Ghi chú">
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Đối tượng thanh toán">ĐTTT *</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="taxcode" placeholder="ĐTTT" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem"
												title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal">
											<i class="ti-search"></i>
										</span>
									</div>
									<input class="hiden-input" id="cusID" readonly>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name">[Tên đối tượng thanh toán]</span>&emsp;
								<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr">[Địa chỉ]</span>&emsp;
								<i class="fa fa-tags" style="font-size: 15px!important;"></i>-<span id="payment-type" data-value="C">[Hình thức thanh toán]</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="addnew" class="btn btn-outline-success btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
							</button>
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
							</button>
							<button id="import-file" class="btn btn-outline-warning btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-share-square"></i>Import File</span>
							</button>
							<a class="linked col-form-label text-primary" href="<?=base_url('download/empty-pickup-template.xls');?>" style="padding-left: 10px;">Tải tệp mẫu</a>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" >
						<div class="row form-group" style="display: inline-block; float: right; margin: 0 auto">
							<label class="radio radio-outline-success pr-4">
								<input name="view-opt" type="radio" id="chk-view-cont" value="cont" checked>
								<span class="input-span"></span>
								Danh sách container
							</label>
							<label class="radio radio-outline-success pr-4">
								<input name="view-opt" id="chk-view-inv" value="inv" type="radio">
								<span class="input-span"></span>
								Tính cước
							</label>
							<button id="show-payment-modal" class="btn btn-warning btn-sm" title="Thông tin thanh toán" data-toggle="modal">
								<i class="fa fa-print"></i>
								Thanh toán
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row grid-toggle" style="padding: 10px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="tbl-cont" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="CntrNo" >Số Container</th>
							<th col-name="OprID" class="autocomplete">Hãng Khai Thác</th>
							<th col-name="LocalSZPT" class="autocomplete">Kích cỡ nội bộ</th>
							<th col-name="ISO_SZTP" class="editor-cancel">Kích cỡ ISO</th>
							<th col-name="Status" class="autocomplete">Hàng/rỗng</th>
							<th col-name="POD" class="autocomplete">Cảng dỡ</th>
							<th col-name="FPOD" class="autocomplete">Cảng đích</th>
							<th col-name="CARGO_TYPE" class="autocomplete">Loại hàng</th>
							<th col-name="CmdID">Hàng hóa</th>
							<th col-name="VGM" class="editor-cancel data-type-checkbox">VGM</th>
							<th col-name="CMDWeight" class="data-type-numeric">Trọng lượng</th>
							<th col-name="SealNo">Seal H/Tàu</th>
							<th col-name="SealNo1">Seal H/Quan</th>
							<th col-name="IsLocal" class="autocomplete">Nội/ngoại</th>
							<th class="hiden-input">contAddInf</th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
					<table id="tbl-inv" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
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

<!--select barge-->
<div class="modal fade" id="barge-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn sà lan</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="search-barge" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th style="max-width: 15px">STT</th>
							<th>Mã sà lan</th>
							<th>Tên sà lan</th>
							<th>Năm</th>
							<th>Chuyến</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="select-barge" class="btn btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
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
				<div id="dv-cash" style="margin: 0 auto">
					<button id="pay-atm" class="btn btn-rounded btn-gradient-purple">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ ATM</span>
					</button>
					<button class="btn btn-rounded btn-rounded btn-gradient-lime">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ MASTER, VISA</span>
					</button>
				</div>
				<div id="dv-credit" class="hiden-input" style="margin: 0 auto">
					<button id="save-credit" class="btn btn-rounded btn-rounded btn-gradient-lime btn-fix">
						<span class="btn-icon"><i class="fa fa-save"></i> Lưu dữ liệu </span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--select ship-->
<div class="modal fade" id="ship-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document" style="min-width: 960px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn tàu</h5>
			</div>
			<div class="modal-body" style="padding: 10px 0">
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
				<button type="button" id="select-ship" class="btn btn-sm btn-outline-primary" data-dismiss="modal">
					<i class="fa fa-check"></i>
					Chọn
				</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">
					<i class="fa fa-close"></i>
					Đóng
				</button>
			</div>
		</div>
	</div>
</div>

<!--container additional info-->
<div class="modal fade" id="cntr-addinfo-modal" tabindex="-1" role="dialog" data-backdrop="static"
						data-keyboard="false" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="">

	<div class="modal-dialog" role="document">
		<div class="modal-content p-2">
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group pb-1">
							<h5 id="cntrAdd-cargoType" class="text-primary" style="border-bottom: 1px solid #eee">Chi tiết theo loại hàng</h5>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Nhiệt độ">Nhiệt độ</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cntrAdd-Temperature" type="text" placeholder="Nhiệt độ">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Thông gió">Vent</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cntrAdd-Vent" type="text" placeholder="Thông gió">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Đơn vị thông gió">Vent Unit</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cntrAdd-Vent_Unit" type="text" placeholder="Đơn vị thông gió">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Mã nguy hiểm">UNNO</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cntrAdd-UNNO" type="text" placeholder="Mã nguy hiểm">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Loại nguy hiểm">CLASS</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="cntrAdd-CLASS" type="text" placeholder="Loại nguy hiểm">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-form-label" title="Quá khổ">OOG (Quá khổ)</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm text-right" id="cntrAdd-OOG_TOP" type="text" placeholder="Top">
								<input class="form-control form-control-sm text-right border-left-0" id="cntrAdd-OOG_LEFT" type="text" placeholder="Left">
								<input class="form-control form-control-sm text-right border-left-0" id="cntrAdd-OOG_RIGHT" type="text" placeholder="Right">
								<input class="form-control form-control-sm text-right border-left-0" id="cntrAdd-OOG_BACK" type="text" placeholder="Back">
								<input class="form-control form-control-sm text-right border-left-0" id="cntrAdd-OOG_FRONT" type="text" placeholder="Front">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="margin: 0 auto">
					<button type="button" id="apply-add-infor-cont" class="btn btn-success btn-labeled btn-labeled-right btn-icon btn-sm" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button type="button" id="cancel-add-infor-cont" class="btn btn-danger btn-labeled btn-labeled-right btn-icon btn-sm" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Hủy bỏ</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="context-opr" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-sztp" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-cargoType" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-localforeign" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-status" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-pod" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<div id="context-fpod" class="btn-group" style="position: absolute; z-index: 105; display: none;">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right scrollable-menu">
  </div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
						, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
						, "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],

			_cols = ["STT", "CntrNo", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "POD", "FPOD", "CARGO_TYPE", "CmdID", "VGM"
						, "CMDWeight", "SealNo", "SealNo1", "IsLocal", "cntrAddInf"],

			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

		var _oprs = [], _sztp = <?= $sizeTypes;?>, _lstEir = [];
		var _ports = []; var _cargoTypes = <?= $cargoTypes;?>;
		var _selectShipKey = '', _berthdate = '', _shipYear='', _shipVoy = '', tblConts = $('#tbl-cont'), tblInv = $("#tbl-inv");

		var payers= {},
			_localForeign = [
				{ "Code": "L", "Name": "Nội" },
				{ "Code": "F", "Name": "Ngoại" }
			],
			_status = [
				{ "Code": "F", "Name": "Hàng" },
				{ "Code": "E", "Name": "Rỗng" }
			];

//INIT TABLES

		$('#search-barge').DataTable({
			paging: false,
			infor: false,
			scrollY: '25vh'
		});

		$('#search-ship').DataTable({
			paging: false,
			infor: false,
			searching: false,
			buttons: [],
			scrollY: '35vh'
		});

		$('#search-payer').DataTable({
			paging: true,
			scroller: {
				displayBuffer: 12,
				boundaryScale: 0.5
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
		
		tblConts.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh',

			columnDefs: [
				{ type: "num", className: "text-center", targets: _cols.indexOf("STT") },
				{ className: "hiden-input", targets: _cols.indexOf("contAddInf") },
				{ className: "text-center", targets: _cols.indexOf("VGM") },
				{ 
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 2),
					targets: _cols.indexOf("CMDWeight")
				},
				{
					render: function (data, type, full, meta) {
						return data ? data.trim().toUpperCase() : "";
					},
					className: "text-center",
					targets: _cols.getIndexs(["CntrNo", "OprID", "LocalSZPT", "Status", "POD", "FPOD", "CARGO_TYPE", "IsLocal"])
				},
				{
					render: function (data, type, full, meta) {
						return !data ? '<label class="checkbox checkbox-primary"><input type="checkbox" value="0"><span class="input-span"></span></label>' : data;
					},
					className: "text-center",
					targets: _cols.indexOf("VGM")
				}
			],
			order: [],
            keys:true,
            autoFill: {
                focus: 'focus',
                columns: ':not( :eq( ' + _cols.indexOf( 'STT' ) + ') )'
            },
            select: true,
            rowReorder: false
		});

		tblInv.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});
//END INIT TABLES

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		
		search_ship();

		load_payer();

		$('input[name="chkSalan"]').on('change', function () {
			$('#barge-ischecked').toggleClass('unchecked-Salan');
			if(!$(this).is(':checked')) $('#barge-info').val('');
		});

		$('#b-add-payer').on("click", function(){
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function(){
			$('.add-payer-container').removeClass("payer-show");
		});

///////// SEARCH PAYER
		$(document).on('click','#search-payer tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});

		$('#select-payer').on('click', function () {
			var r = $('#search-payer tbody').find('tr.m-row-selected').first();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#taxcode').trigger("change");
		});

		$('#search-payer').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();

			$('#taxcode').val($(r).find('td:eq('+ _colPayer.indexOf("VAT_CD") +')').text());
			$('#cusID').val($(r).find('td:eq('+ _colPayer.indexOf("CusID") +')').text());

			fillPayer();

			$('#payer-modal').modal("toggle");
			$('#taxcode').trigger("change");
		});
///////// END SEARCH PAYER

///////// SEARCH BARGE
		$('#btn-search-barge').on('click', function () {
			search_barge();
		});

		$(document).on('click','#search-barge tbody tr', function() {
			$('.m-row-selected').removeClass('m-row-selected');
			$(this).addClass('m-row-selected');
		});
		$('#select-barge').on('click', function () {
			var r = $('#search-barge tbody').find('tr.m-row-selected').first();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
		});
		$('#search-barge').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#barge-modal').modal("toggle");
		});
///////// END SEARCH BARGE

///////// SEARCH SHIP
		$('#btn-search-ship').on('click', function () {
			search_ship();
		});

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
			_berthdate = $(r).find('td:eq(7)').text();
			_shipYear = $(r).find('td:eq(8)').text();
			_shipVoy = $(r).find('td:eq(9)').text();

			getLane(_selectShipKey);
		});
		$('#unselect-ship').on('click', function () {
			$('#shipid').val('');
		});
		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
			_berthdate = $(r).find('td:eq(7)').text();
			_shipYear = $(r).find('td:eq(8)').text();
			_shipVoy = $(r).find('td:eq(9)').text();

			getLane(_selectShipKey);
			$('#ship-modal').modal("toggle");
		});

		$('#reload-ship').on("click", function(){
			$('#search-ship-name').val("");
			search_ship();
		})
///////// END SEARCH SHIP

		$('#ship-modal, #barge-modal, #payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable()
											.columns
											.adjust();
		});

		$('#show-payment-modal').on("click", function(){
			 // data-target="#payment-modal"
			 if(!$("#taxcode").val()){
				$('#taxcode').addClass("error");
				toastr["warning"]("Chưa chọn đối tượng thanh toán!");
				e.preventDefault();
				return;
			}

			var paymentType = $('#payment-type').attr('data-value');
			if(paymentType == "M"){
				$("#dv-cash").removeClass("hiden-input");
				$("#dv-credit").addClass("hiden-input");
			}else{
				$("#dv-cash").addClass("hiden-input");
				$("#dv-credit").removeClass("hiden-input");
			}

			$(this).attr("data-target", "#payment-modal");
		});

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			$('#tbl-cont, #tbl-inv').realign();
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				var tdrequired = $('#tbl-cont tbody').find('td.input-required').find('input');
				if(tdrequired.has_required()){
					$('.toast').remove();
					toastr['error']('Vui lòng nhập đầy đủ thông tin!');
					$('#chk-view-cont').trigger('click');
					return;
				}

				var newrows = $('#tbl-cont').getNewRows();
				_lstEir = [];
				if(newrows.length == 0 ) return;
				$.each(newrows, function (idx, item) {
					addCntrToEir(item);
				});
				loadpayment();
			}
		});

		$('#cntrclass').on('change', function () {
			if($(this).val() == 3){
				$('#bkno-blno').attr('placeholder', 'Số booking');
				$('label[for="bkno-blno"]').text('Số booking *');
			}else{
				$('#bkno-blno').attr('placeholder', 'Số vận đơn');
				$('label[for="bkno-blno"]').text('Số vận đơn *');
			}
		});

		tblConts.DataTable().on( 'autoFill', function ( e, datatable, cells ) {
			// if autofill not contain Local SZTP column -> return;
			var fillLocalSZTPCol = cells[0].filter( p => p.index.column == _cols.indexOf("LocalSZPT") );

			if( !fillLocalSZTPCol || fillLocalSZTPCol.length == 0 ){ return; }

        	var startRowIndex = cells[0][0].index.row,
        		dtTbl = tblConts.DataTable();

        	var localSZ = dtTbl.cell( startRowIndex, _cols.indexOf( "LocalSZPT" ) ).data(),
        		opr = dtTbl.cell( startRowIndex, _cols.indexOf( "OprID" ) ).data(),
        		iso = "";

        	console.log(localSZ, opr);

        	if( localSZ && opr){
        		iso = _sztp.filter( p => p.OprID == opr && p.LocalSZPT == localSZ ).map( x => x.ISO_SZTP );
        	}
        		
        	$.each(cells, function(idx, item){
        		dtTbl.cell( item[0].index.row, _cols.indexOf( "ISO_SZTP" ) ).data( iso );
        	});

    //     	$.each(rows, function(){
    //     		var crRow = tbl.find("tbody tr:eq("+this+")");
				// if(!crRow.hasClass("addnew")){
		  //       	dtTbl.row(crRow).nodes().to$().addClass("editing");
	   //      	}
    //     	})
		} );

		tblConts.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td'),
        		crRow = inp.closest('tr');

        	tblConts.DataTable().cell(crCell).data(crCell.html()).draw(false);
        });

		$('#addnew').on('click', function () {
			if($('.input-required').has_required()){
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}
			
			if(_oprs.length == 0){
				$('.toast').remove();
				toastr['error']('Không có hãng khai thác nào phù hợp với lịch trình tàu!');
				return;
			}

			tblInv.DataTable().clear().draw();

			tblConts.newRow();

			//set on changed event for cargo type
        	tblConts.find("tbody tr").each(function(){

        		$(this).find("td:eq(" + _cols.indexOf("OprID") + ")").each(function(){
        			$(this).on("change", onChangeOPR); //
        		});

        		$(this).find("td:eq(" + _cols.indexOf("CARGO_TYPE") + ")").each(function(){
        			$(this).on("change", onChangeCargoType); //
        		});

        		$(this).find("td:eq(" + _cols.indexOf("LocalSZPT") + ")").each(function(){
        			$(this).on("change", onChangeLocalSZTP); //
        		});
        	});
		});

		$('#remove').on('click', function () {
			if($('#chk-view-inv').is(':checked')) return;
			
			tblConts.confirmDelete(function(){
				tblInv.DataTable().clear().draw();
			});
		});

		$(document).on('change','input, select', function (e) {
			if($(this).parent().is('td')){
				var colidx = $(this).closest('tr').children().index($(this).parent());
				var ridx = $(this).closest('tr').index();
				if(_lstEir.length > 0){
					_lstEir[ridx][_cols[colidx]] = $(this).val();
				}

				if($.inArray(colidx, [2, 4, 5, 8, 19]) != "-1"){
					$('#tbl-inv').DataTable().clear().draw();
				}
			}else{
				changed(e);
			}
		});

		$('#cntr-addinfo-modal').on('hidden.bs.modal', function (e) {
			var cntrAddInf = {};
			var cmodal = $('#cntr-addinfo-modal');
			var rindex = cmodal.attr('data-whatever');
			var hasRequired = false;
			cmodal.find("div.row.form-group:not(.hiden-input)").find('input').each(function (index, item) {
				if($(item).val()){
					cntrAddInf[$(item).attr('id').split("-")[1]] = $(item).val();
				}else{
					hasRequired = true;
				}
			});

			var addinf = $('#tbl-cont tbody tr:eq('+rindex+') td:eq(15) input').first();
			if(hasRequired){
				addinf.val('');
				var cgo = $('#tbl-cont tbody tr:eq('+rindex+') td:eq('+_cols.indexOf("CARGO_TYPE")+') input');
				cgo.val('')
					.focus()
					.select();
			}else{
				addinf.val(JSON.stringify(cntrAddInf));
				$('#tbl-cont tbody tr:eq('+rindex+') td:eq('+_cols.indexOf("CmdID")+') input')
					.focus()
					.select();
			}
		});

		$('#apply-add-infor-cont').on("click", function(){
			var cmodal = $('#cntr-addinfo-modal'),
				applyRowIdx = cmodal.attr("data-whatever"),
				cntrAddInf = {},
				hasRequired = false;

			cmodal.find("div.row.form-group:not(.hiden-input)").find('input').each(function (index, item) {
				if($(item).val()){
					cntrAddInf[$(item).attr('id').split("-")[1]] = $(item).val();
				}else{
					hasRequired = true;
				}
			});

			var addinf = tblConts.find("tbody tr:eq(" + applyRowIdx + ") td:eq(" + _cols.indexOf("cntrAddInf") + ")");

			if(hasRequired){
				addinf.html('');
				var cgo = tblConts.find("tbody tr:eq(" + applyRowIdx + ") td:eq(" + _cols.indexOf("CARGO_TYPE") + ")");

				tblConts.DataTable().cell(cgo).data("");
				cgo.addClass("error").trigger("click");
			}else{
				addinf.html(JSON.stringify(cntrAddInf));
				tblConts.find("tbody tr:eq(" + applyRowIdx + ") td:eq(" + _cols.indexOf("CmdID") + ")").trigger("click");
			}
		});

		$('#pay-atm').on('click', function () {
//			saveEIR();
			publishInv();
		});

		$('#save-credit').on("click", function(){
			saveData();
		});

		function search_barge(){
			$("#search-barge").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_barge'
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.barges.length > 0) {
						for (i = 0; i < data.barges.length; i++) {
							rows.push([
								(i+1)
								, data.barges[i].ShipID
								, data.barges[i].ShipName
								, data.barges[i].ShipYear
								, data.barges[i].ShipVoy
							]);
						}
						$('#search-barge').DataTable( {
							paging: false,
							searching: false,
							infor: false,
							scrollY: '25vh',
							data: rows
						} );
					}
				},
				error: function(err){console.log(err);}
			});
		}

		function getLane(shipkey){
			$('.ibox.collapsible-box').blockUI();

			var formdata = {
				'action': 'view',
				'act': 'getLane',
				'shipkey': shipkey
			};
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					_oprs = data.oprs;
					_ports = data.ports;

					extendSelectOnGrid();

					$('.ibox.collapsible-box').unblock();
				},
				error: function(err){console.log(err);}
			});
		}

		function extendSelectOnGrid(){
			var tblContsHeader = tblConts.parent().prev().find('table');

			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ').attr("select-source", "");

			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'OprID' ) + ') ').setSelectSource(_oprs.map(p=>p.CusID));
			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'CARGO_TYPE' ) + ') ').setSelectSource(_cargoTypes.map(p=>p.Code));
			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'IsLocal' ) + ') ').setSelectSource(_localForeign.map(p=>p.Code));

			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'POD' ) + ') ').setSelectSource(_ports.map(p=>p.Port_CD));
			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'FPOD' ) + ') ').setSelectSource(_ports.map(p=>p.Port_CD));


			tblConts.setExtendDropdown({
				target: "#context-opr",
				source: _oprs,
				colIndex: _cols.indexOf( "OprID" ),
				onSelected: function(cell, value){
					var dtConts = tblConts.DataTable(),
						oldVal = dtConts.cell( cell ).data(),
						localSZHeader = tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ');

					//if no change value and had select source of local size => return
					if( oldVal == value && localSZHeader.attr( "select-source" ) ) {
						return;
					}
					
					dtConts.cell( cell ).data( value );

					dtConts.cell( cell.parent().find( "td:eq( " + _cols.indexOf("LocalSZPT") + " )" ) ).data("");
					dtConts.cell( cell.parent().find( "td:eq( " + _cols.indexOf("ISO_SZTP") + " )" ) ).data("");
					

					var sourceSZTP = _sztp.filter(p=> p.OprID.trim().toUpperCase() == value.trim().toUpperCase()).map(x=> x.LocalSZPT);

					tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ').setSelectSource(sourceSZTP);
					
					tblConts.setExtendDropdown({
						target: "#context-sztp",
						source: sourceSZTP,
						colIndex: _cols.indexOf("LocalSZPT"),
						onSelected: function(c, v){
							var isosz = "";

							if( !tblConts.find("tbody tr:eq(" + c.parent().index() + ") td:eq(" + _cols.indexOf("OprID") + ")").html() ){
								tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ').attr("select-source", "");
								toastr["warning"]("Chưa chọn hãng khai thác!");
								v = "";
							}else{
								isosz = _sztp.filter(p=> p.LocalSZPT.trim().toUpperCase() == v.trim().toUpperCase()).map(x=> x.ISO_SZTP)[0];
							}

							dtConts.cell( c ).data(v);
							dtConts.cell( c.parent().find( "td:eq(" + _cols.indexOf("ISO_SZTP") + ")" ) ).data(isosz);
						}
					});
				}
			});

			tblConts.setExtendDropdown({
				target: "#context-cargoType",
				source: _cargoTypes,
				colIndex: _cols.indexOf( "CARGO_TYPE" ),
				onSelected: function(cell, value){
					tblConts.DataTable().cell(cell).data(value);

					cell.trigger("change");
				}
			});

			tblConts.setExtendDropdown({
				target: "#context-localforeign",
				source: _localForeign,
				colIndex: _cols.indexOf( "IsLocal" ),
				onSelected: function(cell, value){
					tblConts.DataTable().cell(cell).data(value);
				}
			});

			tblConts.setExtendDropdown({
				target: "#context-status",
				source: _status,
				colIndex: _cols.indexOf( "Status" ),
				onSelected: function(cell, value){
					tblConts.DataTable().cell(cell).data(value);
				}
			});

			tblConts.setExtendDropdown({
				target: "#context-pod",
				source: _ports,
				colIndex: _cols.indexOf( "POD" ),
				onSelected: function(cell, value){
					tblConts.DataTable().cell(cell).data(value);
				}
			});

			tblConts.setExtendDropdown({
				target: "#context-fpod",
				source: _ports,
				colIndex: _cols.indexOf( "FPOD" ),
				onSelected: function(cell, value){
					tblConts.DataTable().cell(cell).data(value);
				}
			});

			tblConts.editableTableWidget();
		}

		function onChangeOPR(){
			var currentTD = $(this);
			var opr = currentTD.text(),
				tblContsHeader = tblConts.parent().prev().find('table'),
				dtConts = tblConts.DataTable(),
				localSZHeader = tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ');

			dtConts.cell( currentTD.parent().find( "td:eq( " + _cols.indexOf("LocalSZPT") + " )" ) ).data("");
			dtConts.cell( currentTD.parent().find( "td:eq( " + _cols.indexOf("ISO_SZTP") + " )" ) ).data("");
			
			var sourceSZTP = _sztp.filter(p=> p.OprID.trim().toUpperCase() == opr.trim().toUpperCase()).map(x=> x.LocalSZPT);

			tblContsHeader.find(' th:eq(' + _cols.indexOf( 'LocalSZPT' ) + ') ').setSelectSource(sourceSZTP);
		}

		function onChangeCargoType(){
			var currentTD = $(this);
			var cargoID = currentTD.text();

			var Reefer = ["Temperature", "Vent", "Vent_Unit"];
			var Dangerous = ["UNNO", "CLASS"];
			var OOG = ["OOG_TOP", "OOG_LEFT", "OOG_RIGHT", "OOG_BACK", "OOG_FRONT"];
			var DaR = Reefer.concat(Dangerous);
			var OaD = OOG.concat(Dangerous);

			var cntrAddInfModal = $('#cntr-addinfo-modal');
			if(cargoID == "RF"){
				cntrAddInfModal.find('input').closest(".row").removeClass('hiden-input');
				cntrAddInfModal.attr('data-whatever', currentTD.closest('tr').index());

				$.each(cntrAddInfModal.find('input'), function (index, item) {
					if($.inArray($(item).attr("id").split('-')[1], Reefer) == "-1"){
						$(item).closest('.row').addClass('hiden-input');
					}
				});
				cntrAddInfModal.modal();
			}

			if(cargoID == "DG"){
				cntrAddInfModal.find('input').closest(".row").removeClass('hiden-input');
				cntrAddInfModal.attr('data-whatever', currentTD.closest('tr').index());

				$.each(cntrAddInfModal.find('input'), function (index, item) {
					if($.inArray($(item).attr("id").split('-')[1], Dangerous) == "-1"){
						$(item).closest('.row').addClass('hiden-input');
					}
				});
				cntrAddInfModal.modal();
			}

			if(cargoID == "OG"){
				cntrAddInfModal.find('input').closest(".row").removeClass('hiden-input');
				cntrAddInfModal.attr('data-whatever', currentTD.closest('tr').index());

				$.each(cntrAddInfModal.find('input'), function (index, item) {
					if($.inArray($(item).attr("id").split('-')[1], OOG) == "-1"){
						$(item).closest('.row').addClass('hiden-input');
					}
				});
				cntrAddInfModal.modal();
			}

			if(cargoID == "DR"){
				cntrAddInfModal.find('input').closest(".row").removeClass('hiden-input');
				cntrAddInfModal.attr('data-whatever', currentTD.closest('tr').index());

				$.each(cntrAddInfModal.find('input'), function (index, item) {
					if($.inArray($(item).attr("id").split('-')[1], DaR) == "-1"){
						$(item).closest('.row').addClass('hiden-input');
					}
				});
				cntrAddInfModal.modal();
			}

			if(cargoID == "OD"){
				cntrAddInfModal.find('input').closest(".row").removeClass('hiden-input');
				cntrAddInfModal.attr('data-whatever', currentTD.closest('tr').index());

				$.each(cntrAddInfModal.find('input'), function (index, item) {
					if($.inArray($(item).attr("id").split('-')[1], OaD) == "-1"){
						$(item).closest('.row').addClass('hiden-input');
					}
				});
				cntrAddInfModal.modal();
			}
		}

		function onChangeLocalSZTP() {
			var localSZ = $(this).text(),
				rowIdx = $(this).parent().index(),
				opr = tblConts.DataTable().cell( rowIdx, _cols.indexOf( "OprID" ) ).data();

			var iso = "";
			if( localSZ && opr ){
				iso = _sztp.filter( p => p.LocalSZPT == localSZ && p.OprID == opr ).map( x => x.ISO_SZTP );
			}

			tblConts.DataTable().cell( rowIdx, _cols.indexOf( "ISO_SZTP" ) ).data(iso);
		}

		function eir_base(item){
			item['ShipKey'] =  _selectShipKey;
			item['ShipID'] =  $('#shipid').val().split('/')[0];
			item['ImVoy'] =  $('#shipid').val().split('/')[1];
			item['ExVoy'] =  $('#shipid').val().split('/')[2];
			item['ShipYear'] = _shipYear;
			item['ShipVoy'] = _shipVoy;
			item['BerthDate'] = _berthdate;
			
			// item['EIRNo'] =  $('#ref-no').val();

			item['IssueDate'] =  $('#ref-date').val(); //*
//			item['ExpDate'] =  $('#ref-exp-date').val(); //*
			item['NameDD'] =  $('#personal-name').val();

			item['IsTruckBarge'] =  $('input[name="chkSalan"]').is(':checked') ? "B" : "T";
			item['BARGE_CODE'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[0] : "";
			item['BARGE_YEAR'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[1] : "";
			item['BARGE_CALL_SEQ'] =  $('#barge-info').val() ? $('#barge-info').val().split('/')[2] : "";

			item['DMETHOD_CD'] = $('input[name="chkSalan"]').is(':checked') ?  $('#cntrclass option:checked').attr("dmethod-salan") 
																			: $('#cntrclass option:checked').attr("dmethod");
			item['TruckNo'] = '';

			item['PersonalID'] =  $('#cmnd').val();
			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*

			item['PAYER_TYPE'] = getPayerType($('#taxcode').val());
			item['CusID'] = $('#taxcode').val(); //*

			item['CntrClass'] = $('#cntrclass').val(); //*
			if( $('#cntrclass').val() == 3){
				item['BookNo'] = $('#bkno-blno').val(); //*
				item['BLNo'] = ''; //*
			}else{
				item['BookNo'] = item['BLNo'] = $('#bkno-blno').val(); //*
			}

			//add new 2018-12-17
			item["Port_CD"] = "VN<?=$this->config->item("YARD_ID");?>";
			item['BerthDate'] = _berthdate;

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['CJMode_CD'] = $('#cntrclass option:checked').attr("cjmode");
			item['CJModeName'] = item['CJMode_CD'] == "HBAI" ? 'Hạ bãi' : $('#cntrclass option:checked').text(); //*
		}

		function addCntrToEir(row){
			var item = {};
			eir_base(item);
			for( var i = 1; i <= _cols.length - 1; i++ ){
				if( i == _cols.indexOf( "cntrAddInf" ) ){
					if( row[ i ] ){
						var cntrAddInf = JSON.parse( row[ i ] );
						for( var key in cntrAddInf ) {
							item[ key ] = cntrAddInf[ key ];
						}
					}
				}else{
					item[ _cols[ i ] ] = row[ i ];
				}
			}

			if(item.EIR_SEQ == 0){
				item['EIR_SEQ'] = 1;
			}
			_lstEir.push(item);
		}

		function loadpayment(){
			if(_lstEir.length == 0) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if($('.input-required.error').length > 0) {
				$('#tbl-inv').DataTable().clear().draw();
				return;
			}
			if($('.input-required').has_required()){
				$('#tbl-inv').DataTable().clear().draw();
				$('.toast').remove();
				toastr['error']('Các trường bắt buộc (*) không được để trống!');
				return;
			}

			$('#tbl-inv').waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#taxcode').val(),
				'list': _lstEir
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];

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

					var lst = data.results, stt = 1;
					for (i = 0; i < lst.length; i++) {
						rows.push([
							(stt++)
							, lst[i].DraftInvoice
							, lst[i].OrderNo ? lst[i].OrderNo : ""
							, lst[i].TariffCode
							, lst[i].TariffDescription
							, lst[i].Unit
							, lst[i].JobMode == 'GO' ? "Nâng container" : "Hạ container"
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
				},
				error: function(err){console.log(err);}
			});
		}
		function getPayerType(id){
			if(payers.length == 0 ) return "";
			var py =payers.filter(p=> p.VAT_CD == id);
			if(py.length == 0) return "";
			if(py[0].IsOpr == "1") return "SHP";
			if(py[0].IsAgency == "1") return "SHA";
			if(py[0].IsOwner == "1") return "CNS";
			if(py[0].IsLogis == "1") return "FWD";
			if(py[0].IsTrans == "1") return "TRK";
			if(py[0].IsOther == "1") return "DIF";
			return "";
		}

		var typingTimer;
		function changed(e){
			var cr = e.target;
			if($(cr).attr('id') == "taxcode"){
				fillPayer();
				clearTimeout(typingTimer);
			}
			if($(cr).val()){
				$(cr).removeClass('error');
				$(cr).parent().removeClass('error');
			}

			if(_lstEir.length > 0){
				$.each(_lstEir, function (idx, item) {
					eir_base(item);
				});
			}
			typingTimer = window.setTimeout(function () {
				//reset list eir
				if($('.input-required.error').length == 0 && $(cr).attr('id') == "taxcode" && $(cr).val() && $('#chk-view-inv').is(':checked')){
					loadpayment();
				}
			}, 1000);
		}

		function fillPayer(){
			var py = payers.filter(p=> p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());
			if(py.length > 0){ //fa-check-square
				$('#p-taxcode').text($('#taxcode').val());
				$('#payer-name, #p-payername').text(py[0].CusName);
				$('#payer-addr, #p-payer-addr').text(py[0].Address);
				$('#payment-type').attr('data-value', py[0].CusType);
				$('#payment-type').text(py[0].CusType == 'M' ? "Chuyển khoản" : "Thu sau");
				if(py[0].CusType == "M"){
					$('#p-money i').removeClass('fa-square').addClass('fa-check-square');
					$('#p-credit i').removeClass('fa-check-square').addClass('fa-square');
				}else{
					$('#p-money i').removeClass('fa-check-square').addClass('fa-square');
					$('#p-credit i').removeClass('fa-square').addClass('fa-check-square');
				}

				$("#taxcode").removeClass("error");
			}
		}

		//PUBLISH INV
		function publishInv(){
			$('#payment-modal').find('.modal-content').blockUI();
			var datas = getInvDraftDetail();
			var formData = {
				cusTaxCode : $('#p-taxcode').text(),
				cusAddr : $('#p-payer-addr').text(),
				cusName : $('#p-payername').text(),
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
					saveData(data);
				},
				error: function(err){
					$('#payment-modal').find('.modal-content').unblock();
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
				'data': {
					'eir': _lstEir
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
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
					$('.toast').remove();
					$('#payment-modal').find('.modal-content').unblock();
					toastr['error']("Internal Error!");
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
				temp['Remark'] = $.unique(_lstEir.map(p=> p.CntrNo)).toString();
				drd.push(temp);
			});
			return drd;
		}

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskFCL_Pre_Advice'));?>",
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
	});

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
<script language = "javascript" type = "text/javascript" >
	Array.prototype.max = function() {
		return Math.max.apply(null, this);
	};

	Array.prototype.min = function() {
		return Math.min.apply(null, this);
	};
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
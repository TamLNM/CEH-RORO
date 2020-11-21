<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />


<style>
	label {
		text-overflow: ellipsis;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		vertical-align: middle;
		font-weight: bold!important;
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

	.un-pointer{
		pointer-events: none;
	}
	.form-group{
		margin-bottom: .5rem!important;
	}
	.grid-hidden{
		display: none;
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
		/*background: #2c3e50; /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #2c3e50, #3498db); /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #2c3e50, #3498db);
		color: white;*/

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
		<div class="ibox collapsible-box" id="parent-loading">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH CẤP CONTAINER RỖNG</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row border-e bg-white pb-1">
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Ngày lệnh</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm" id="ref-date" type="text" placeholder="Ngày lệnh">
								</div>
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text"  placeholder="Hạn lệnh">
									<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
								</div>
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
								<div id="barge-ischecked" class="input-group un-pointer">
									<input class="form-control form-control-sm" id="barge-info" type="text" placeholder="Mã/Năm/Chuyến" readonly>
									<span class="input-group-addon bg-white btn text-warning" id="btn-search-barge" data-toggle="modal" data-target="#barge-modal" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group hiden-input">
							<label class="col-sm-4 col-form-label">Tàu/chuyến</label>
							<div class="col-sm-8 input-group">
								<input class="form-control form-control-sm" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
								<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()">
									<i class="ti-search"></i>
								</span>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">D/O</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm" id="do" type="text" placeholder="D/O">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label pr-0">Số booking *</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm input-required" id="bookingno" type="text" placeholder="Số booking">
									<span class="input-group-addon bg-white btn text-warning hiden-input" title="Tìm booking" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group show-non-cont hiden-input">
							<label class="col-sm-4 col-form-label">OPR/SzType</label>
							<div class="col-sm-8">
								<div class="input-group">
									<input class="form-control form-control-sm" id="opr" type="text" placeholder="OPR" readonly>
									<select id="sizetype" class="selectpicker pl-1" data-style="btn-default btn-sm" data-width="50%">
										<option value="" selected>--</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row form-group hide-non-cont">
							<label class="col-sm-4 col-form-label">Số container</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No.">
									<span class="input-group-addon bg-white btn text-warning" data-toggle="modal" id="cntrno-search" data-target="" title="Chọn" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
								</div>
							</div>
						</div>
						<div class="row form-group hiden-input show-non-cont">
							<label class="col-sm-4 col-form-label">Số lượng cont</label>
							<div class="col-sm-8 input-group input-group-sm">
								<div class="input-group">
									<input class="form-control form-control-sm" id="noncont" type="number" placeholder="Số lượng" value="0" min="0" max="999">
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
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name"> [Tên đối tượng thanh toán]</span>&emsp;
								<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr"> [Địa chỉ]</span>&emsp;
								<i class="fa fa-tags" style="font-size: 15px!important;"></i>-<span id="payment-type" data-value="C"> [Hình thức thanh toán]</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-2 pt-2 border-e bg-white">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row form-group ml-auto">
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1" title="Xóa những dòng đang chọn">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
							</button>
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
					<table id="tbl-cont" class="table table-striped display nowrap" cellspacing="0"  style="min-width: 99.4%">
						<thead>
						<tr>
							<th>STT</th>
							<th>Số cont</th>
							<th>Số booking</th>
							<th>Hướng</th>
							<th>Hãng khai thác</th>
							<th>Kích cỡ nội bộ</th>
							<th>Kích cỡ ISO</th>
							<th>Hàng/Rỗng</th>
							<th>Số chì</th>
							<th>Nội/ngoại</th>
							<th>Trọng lượng</th>
							<th>Loại hàng</th>
							<th>Ghi chú</th>
							<th>TLHQ</th>
						</tr>
						</thead>

						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
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
			<div class="row ibox-footer">

			</div>
		</div>
	</div>
</div>
<!--select barge-->
<div class="modal fade" id="barge-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-mw" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn xà lan</h5>
			</div>
			<div class="modal-body pt-0">
				<div class="table-responsive">
					<table id="search-barge" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th style="max-width: 15px">STT</th>
							<th>Mã xà lan</th>
							<th>Tên xà lan</th>
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
										<option value="2015" >2015</option>
										<option value="2016" >2016</option>
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
										<option value="2021" >2021</option>
										<option value="2022" >2022</option>
										<option value="2023" >2023</option>
										<option value="2024" >2024</option>
										<option value="2025" >2025</option>
									</select>
									<input class="form-control form-control-sm mr-2 ml-2" id="search-ship-name" type="text" placeholder="Nhập tên tàu">
									<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/icons/Search.ico');?>" style="height:25px; width:25px; margin-top: 5px;cursor: pointer" title="Tìm kiếm"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-body pt-0">
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
							<th>Ngày Rời</th>
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
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
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
<!--booking modal-->
<div class="modal fade" id="booking-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 700px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Chi tiết booking</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="booking-detail" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">Chọn</th>
							<th>Số container</th>
							<th>Hãng tàu</th>
							<th>Kích cỡ</th>
							<th>Vị trí bãi</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-booking" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Chuyển tính tiền</button>
					<button class="btn btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
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
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
							, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
							, "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

		var _bookingList = [], _bookingFiltered = [], selected_cont = [], _lstEir = [];
		var payers= {};
		<?php if(isset($payers) && count($payers) > 0){ ?>
			payers = <?= json_encode($payers);?>;
		<?php } ?>

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			buttons: [],
			scrollY: '20vh'
		});
		$('#booking-detail').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '20vh'
		});
		$('#tbl-cont').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});
		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
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

		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});
		
		$('#ref-exp-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function () {
			$('#ref-exp-date').val('');
		});

		$('#barge-modal, #booking-modal, #payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

		$('#b-add-payer').on("click", function(){
			$('.add-payer-container').addClass("payer-show");
		});

		$('#close-payer-content').on("click", function(){
			$('.add-payer-container').removeClass("payer-show");
		});

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			$('#tbl-cont, #tbl-inv').realign();
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				loadpayment();
			}
		});

		$('input[name="chkSalan"]').on('change', function () {
			$('#barge-ischecked').toggleClass('un-pointer');
			if(!$(this).is(':checked')) $('#barge-info').val('');
		});

		$(document).on('click','#booking-detail tbody tr td', function () {
			$(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			$(this).parent().toggleClass('m-row-selected');
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
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
		});
		$('#unselect-ship').on('click', function () {
			$('#shipkey').val('');
			$('#shipid').val('');
			$('#shipyear').val('');
			$('#voy').val('');
			$('#etb').val('');
			$('#etd').val('');
			$('#imvoy').val('');
			$('#exvoy').val('');
		});
		$('#search-ship').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#shipid').val($(r).find('td:eq(2)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#ship-modal').modal("toggle");
		});
///////// END SEARCH SHIP
		var _ktype = "";
		$('#bookingno').on('keypress', function (e) {
			if(!$(this).val()) return;
			if(e.which == 13){
				_ktype = "enter";
				$('#cntrno-search').trigger('click');
			}
		});

		var _ktypecntr = "";
		$('#cntrno').on('change keypress', function (e) {
			if((e.which == 13 || e.type == "change") && _ktypecntr == ""){
				load_booking(e);
				_ktypecntr = e.type;
				return;
			}
			_ktypecntr = "";
		});

		$('#cntrno-search').on('click', function (e) {
			var rl = $('#booking-detail').DataTable().rows().to$();
			if(rl.length == 1 && rl[0].length > 0){
				$(this).attr('data-target', '#booking-modal');
			}else{
				load_booking(e);
			}
		});

		$('#apply-booking').on('click', function () {
			$.each( $('#booking-detail').find('tr:visible').find('td.ti-check'), function (k,v) {
				var cntrNo = $(v).parent().find('td:eq(1)').first().text();
				if($.inArray(cntrNo, selected_cont) == "-1"){
					selected_cont.push(cntrNo);
				}
			});
			apply_booking();
		});
		$('#noncont').on('change', function () {
			if(parseInt($(this).val()) > (parseInt($(this).attr('max')) + $('#tbl-cont tbody').find('tr').length - 1)){
				$(this).val('');
				$('.toast').remove();
				toastr["error"]("Quá số lượng đặt chỗ!");
				return;
			}
			selected_cont = ['*'];
			var temp = _bookingFiltered[0];
			temp.CntrNo = "*";
			var temp1 = [];
			if(temp){
				for(i=1; i<=parseInt($(this).val()); i++){
					temp1.push(temp);
				}
			}
			_bookingFiltered = temp1;
			apply_booking();
		});
		$('#noncont').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode >= 35 && e.keyCode <= 40) || e.keyCode >= 112) {
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		//for number ,space, / and :
		$('#ref-exp-date').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [32, 46, 8, 9, 27, 13, 191]) !== -1 ||
				((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 112 && e.keyCode <= 123) || (e.shiftKey && e.keyCode == 59)) {
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		$('#remove').on('click', function () {
			if($('#chk-view-inv').is(':checked')) return;
			$.confirm({
				title: 'Thông báo!',
				type: 'orange',
				icon: 'fa fa-warning',
				content: 'Các dòng dữ liệu được chọn sẽ được xóa?',
				buttons: {
					ok: {
						text: 'Chấp nhận',
						btnClass: 'btn-warning',
						keys: ['Enter'],
						action: function(){
							if($('#tbl-cont tbody').find('td.dataTables_empty').length > 0) {
								return;
							}

							var tdtexts = $('#tbl-cont').find('tr.m-row-selected').find('td:eq(1)').text();
							$('#tbl-cont').find('tr.m-row-selected').remove();

							if($('#tbl-cont tbody').find('tr').length==0){
								$('#tbl-cont').DataTable().clear().draw();
							}else{
								var i = 1;
								$.each($('#tbl-cont tbody').find('tr'), function (idx, item) {
									$(item).find('td:eq(0)').text(i++);
								})
							}
							selected_cont = selected_cont.filter(p=> tdtexts.indexOf(p) == "-1");
							$.each($('#booking-detail tbody ').find('tr').find('td:eq(1)'), function (idx, td) {
								if(tdtexts.indexOf($(td).text()) != "-1"){
									$(td).parent().removeClass('m-row-selected');
									$(td).parent().find('td:eq(0)').removeClass('ti-check');
								}
							}) ;

							//remove all row to recalculate
							$('#tbl-inv').DataTable().clear().draw();
						}
					},
					cancel: {
						text: 'Hủy bỏ',
						btnClass: 'btn-default',
						keys: ['ESC']
					}
				}
			});
		});

		$('#pay-atm').on('click', function () {
			publishInv();
		});

		$('#save-credit').on("click", function(){
			saveData();
		});

		var typingTimer;
		$(document).on('input change', '.input-required', function (e) {
			clearTimeout(typingTimer);
			var cr = e.target;
			if($(cr).val()){
				$(cr).removeClass('error');
				$(cr).parent().removeClass('error');
			}
			if($(cr).attr('id') == 'taxcode'){
				var taxcode = $(cr).val(); var pytype = getPayerType(taxcode);
				$.each(_lstEir, function (k, v) {
					_lstEir[k].CusID = taxcode;
					_lstEir[k].PAYER_TYPE = pytype;
				});
				fillPayer();
			}
			if($(cr).attr('id') == "bookingno"){
				$('#cntrno-search').attr('data-target', '');
				if(e.type == 'change' && _ktype == ""){
					$('#cntrno-search').trigger('click');
				}
				//reset list eir
				_lstEir = [];
				if($('#tbl-cont').find('tr').length > 1){
					$('#tbl-cont').DataTable().clear().draw();
				}
				if($('#tbl-inv').find('tr').length > 1){
					$('#tbl-inv').DataTable().clear().draw();
				}
				if($('#booking-detail').find('tr').length > 1){
					$('#booking-detail').DataTable().clear().draw();
				}
				return;
			}

			typingTimer = window.setTimeout(function () {
				//reset list eir
				_lstEir = [];
				if($('.input-required.error').length == 0){
					if(_bookingFiltered.length > 0 && selected_cont.length > 0){
						for (i = 0; i < _bookingFiltered.length; i++) {
							if (selected_cont.indexOf(_bookingFiltered[i].CntrNo) == '-1') continue;
							addCntrToEir(_bookingFiltered[i]);
						}
					}
					if($('#chk-view-inv').is(':checked')){
						loadpayment();
					}
				}
			}, 1000);
		});

		//function
		function search_barge(){
			$("#search-barge").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_barge'
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
		function load_booking(e){
			// neu tim kim bang so cont
			if($(e.target).attr('id') == 'cntrno'){
				//loc so cont trong list _bookinglist
				filtercontainer();
				// neu tim duoc so cont trong bookinglist, apply so cont nay va return
				if(_bookingFiltered.length > 0){
					apply_container(true);
					return;
				}
			}

			var formdata = {
				'action': 'view',
				'act': 'load_booking',
				'bkno': $('#bookingno').val().trim(),
				'cntrno': $('#cntrno').val().trim()
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					if(data.bookinglist.error){
						toastr["error"](data.bookinglist.error);
						return;
					}
					_bookingList = data.bookinglist;
					if($(e.target).attr('id') == 'cntrno-search'){
						_ktype = "";
						check_booking();
					}
					if($(e.target).attr('id') == 'cntrno'){
						apply_container(false);
					}
				},
				error: function(err){console.log(err);}
			});
		}
		function check_booking(){
			$('#opr').val('');
			$('#sizetype option:not(:eq(0))').remove();
			$('#sizetype option:selected').prop('selected', false);
			$('#sizetype').selectpicker('refresh');
			$('#cntrno-search').attr('data-target', '');
			var bkNo = $('#bookingno').val(); if(!bkNo) {
				return;
			}

			_bookingFiltered = _bookingList;
			if(_bookingFiltered.length == 0){
				$('.toast').remove();
				toastr['info']('Số booking này không đúng hoặc đã hết hạn!\nVui lòng kiểm tra lại!');
				return;
			}
			if(_bookingFiltered[0].BookAmount - _bookingFiltered[0].StackingAmount == 0){
				toastr['info']('Booking này đã hết số lượng đặt chỗ!');
				return;
			}
			$('#opr').val(_bookingFiltered[0].OprID);
			var lcSize = $.unique(_bookingFiltered.map(p=> p.LocalSZPT));
			$.each(lcSize, function (idx, val) {
				$('#sizetype').append($("<option></option>").attr("value", val).text(val));
			});

			$('#sizetype option:eq(1)').prop('selected', true);
			$('#sizetype').selectpicker('refresh');

			//CHECK NON CONT///
			if(_bookingFiltered.filter(item => item.CntrNo).length > 0){
				//if is not non cont -> show input cont /hide input noncont
				$('.show-non-cont').addClass('hiden-input');
				$('.hide-non-cont').removeClass('hiden-input');

				$('#cntrno-search').attr('data-target', '#booking-modal');
				$('#booking-detail').waitingLoad();
				var rows = [];
				$.each(_bookingFiltered, function (idx, item) {
//					if(item.LocalSZPT != $('#sizetype').val()) return;
					rows.push([
						''
						, item.CntrNo
						, item.OprID
						, item.LocalSZPT
						, item.cTier ? (item.cBlock + "-" + item.cBay + "-" + item.cRow + "-" + item.cTier) : ""
					]);
				});

				var applied_cntr = $('#tbl-cont').DataTable().columns(1).data().to$()[0];
				$('#booking-detail').DataTable({
					paging: false,
					searching: false,
					infor: false,
					scrollY: '20vh',
					data: rows,
					createdRow: function(row, items, dataIndex){
						if(applied_cntr.length > 0){
							if($.inArray(items[1] , applied_cntr) != "-1"){
								$('td:eq(0)', row).addClass("ti-check");
								$(row).addClass('m-row-selected');
							}
//							if(items[3] != $('#sizetype').val()){
//								$(row).hide();
//							}
						}else{
							$('td:eq(0)', row).addClass("ti-check");
							$(row).addClass('m-row-selected');
//							if(items[3] != $('#sizetype').val()){
//								$(row).hide();
//							}
						}
					}
				});
				$('#booking-modal').modal("show");
			}else{
				$('#noncont').attr('max', _bookingFiltered[0].BookAmount - _bookingFiltered[0].StackingAmount);
				//if is non cont -> show input noncont /hide input cont
				$('.show-non-cont').removeClass('hiden-input');
				$('.hide-non-cont').addClass('hiden-input');
			}
		}

		function filtercontainer(){
			var cntrNo = $('#cntrno').val();
			if(_bookingFiltered.length > 0){
				if(_bookingFiltered.filter(item => item.CntrNo == cntrNo).length == 0){
					var temp = _bookingList.filter(item => item.CntrNo == cntrNo && item.BookNo == _bookingFiltered[0].BookNo);
					if(temp.length > 0){
						$.each(temp, function (m,n) {
							_bookingFiltered.push(n);
						});
					}else{
						_bookingFiltered = _bookingList.filter(item => item.CntrNo == cntrNo);
					}
				}
			}else{
				_bookingFiltered = _bookingList.filter(item => item.CntrNo == cntrNo);
			}
		}

		function apply_container(isfiltered){
			$('#bookingno').val('');
			$('#opr').val('');
			$('#sizetype option:not(:eq(0))').remove();
			$('#sizetype option:selected').prop('selected', false);

			var cntrNo = $('#cntrno').val(); if(!cntrNo) return;
			if(_bookingList.length == 0) {
				$('.toast').remove();
				toastr['warning']('Số container chưa được đăng ký booking!');
				return;
			}

			if(!isfiltered){
				filtercontainer();
			}

			if(_bookingFiltered.length == 0){
				$('.toast').remove();
				toastr['warning']('Số container chưa được đăng ký booking!');
				return;
			}

			if(_bookingFiltered[0].BookAmount - _bookingFiltered[0].StackingAmount == 0){
				$('.toast').remove();
				toastr['warning']('Booking này đã hết số lượng đặt chỗ!');
				return;
			}
			var item = _bookingList.filter(item => item.CntrNo == cntrNo)[0];
			$('#sizetype').append($("<option></option>").attr("value", item.LocalSZPT)
															.prop("selected", item.CntrNo == cntrNo)
															.text(item.LocalSZPT));

			$('#bookingno').val(_bookingFiltered[0].BookNo);
			$('#opr').val(_bookingFiltered[0].OprID);
			$('#sizetype').selectpicker('refresh');

			if($.inArray(cntrNo, selected_cont) == "-1"){
				selected_cont.push(cntrNo);
			}
			apply_booking();
		}
		function apply_booking(){
			var hasrequired = false;
			if($('.input-required.error').length > 0){
				hasrequired = true;
			}else{
				hasrequired = $('.input-required').has_required();
				if(hasrequired){
					$('.toast').remove();
					toastr['error']('Các trường bắt buộc (*) không được để trống!');
				}
			}

			$("#tbl-cont").waitingLoad();
			var rows = [];
			if(_bookingFiltered.length > 0 && selected_cont.length > 0){
				var stt = 1;
				//reset list eir
				_lstEir = [];
				for (i = 0; i < _bookingFiltered.length; i++) {
					var item = _bookingFiltered[i];
					if(selected_cont.indexOf(item.CntrNo) == '-1') continue;

					//add item cntr_details to _lst;
					if($('.input-required.error').length == 0){
						if(!hasrequired){
							addCntrToEir(item);
						}
					}
					var status = item.Status == "F" ? "Hàng" : "Rỗng";
					var isLocal = item.IsLocal ? (item.IsLocal == "F" ? "Ngoại" : "Nội") : "";
					rows.push([
						(stt++)
						, item.CntrNo ? item.CntrNo : ""
						, item.BookNo ? item.BookNo : ""
						, "Empty Storage"
						, item.OprID ? item.OprID : ""
						, item.LocalSZPT ? item.LocalSZPT : ""
						, item.ISO_SZTP ? item.ISO_SZTP : ""
						, status
						, item.SealNo ? item.SealNo : ""
						, isLocal
						, item.CMDWeight ? item.CMDWeight : ""
						, item.CARGO_TYPE ? item.CARGO_TYPE : ""
						, item.Note ? item.Note : ""
						, item.cTLHQ ? item.cTLHQ : ""
					]);
				}
			}
			$('#chk-view-cont').trigger('click');
			$('#tbl-cont').DataTable( {
				data: rows,
				info: false,
				paging: false,
				searching: false,
				buttons: [],
				scrollY: '30vh'
			} );
			$('#tbl-inv').DataTable().clear().draw();
		}
		function addCntrToEir(item){
			item['IssueDate'] =  $('#ref-date').val(); //*
			item['ExpDate'] =  $('#ref-exp-date').val(); //*
			item['NameDD'] =  $('#personal-name').val();

			item['IsTruckBarge'] =  $('input[name="chkSalan"]').is(':checked') ? "B" : "T";
			item['BARGE_CODE'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[0] : "";
			item['BARGE_YEAR'] = $('#barge-info').val() ? $('#barge-info').val().split('/')[1] : "";
			item['BARGE_CALL_SEQ'] =  $('#barge-info').val() ? $('#barge-info').val().split('/')[2] : "";

			item['DMETHOD_CD'] = $('input[name="chkSalan"]').is(':checked') ?  "BAI-SALAN" : "BAI-XE";
			item['TruckNo'] = '';

			item['PersonalID'] =  $('#cmnd').val();
			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*

			item['PAYER_TYPE'] = getPayerType($('#taxcode').val());
			item['CusID'] = $('#taxcode').val(); //*

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['DELIVERYORDER'] = $("#do").val(); //*
			item['CJMode_CD'] = 'CAPR'; //*
			item['CJModeName'] = 'Cấp rỗng'; //*
			item['Status'] = 'E'; //*

			if(!item['ShipKey']){
				item['ShipKey'] = 'STORE';
				item['ShipID'] = 'STORAGE';
				item['ShipYear'] = '0000';
				item['ShipVoy'] = '0000';
			}

			if(!item['CARGO_TYPE']) {
				item['CARGO_TYPE'] = item["ISO_SZTP"].charAt(2) == "R" ? "ER" : "MT";
			}

			if(!item['CntrClass']) {
				item['CntrClass'] = "2";
			}

			if(!item['IsLocal']) {
				item['IsLocal'] = "*";
			}

			if(item.EIR_SEQ == 0){
				item['EIR_SEQ'] = 1;
			}
			_lstEir.push(item);
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					if(data.error && data.error.length > 0){
						$(".toast").remove();
						$.each(data.error, function(idx, err){
							toastr["error"](err);
						});

						$('#tbl-inv').dataTable().fnClearTable();
						return;
					}

					var rows = [];

					if(data.results && data.results.length > 0){
						var lst = data.results, stt = 1;
						for (i = 0; i < lst.length; i++) {
							var cntrclass = lst[i].CntrClass == 1 ? "Nhập" : (lst[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
							var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
							var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ? "Nội" : "");
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
				},
				error: function(err){console.log(err);}
			});
		}

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
					toastr['error'](error);
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
				temp['Remark'] = selected_cont.toString();
				drd.push(temp);
			});
			return drd;
		}
	});
	function search_ship(){
		$("#search-ship").waitingLoad();
		var formdata = {
			'action': 'view',
			'act': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-search-ship').val(),
			'shipname': $('#search-ship-name').val()
		};
		$.ajax({
			url: "<?=site_url(md5('Task') . '/' . md5('tskEmptyPickup'));?>",
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
							, getDateTime(data.vsls[i].ETD)
						]);
					}
					$('#search-ship').DataTable( {
						scrollY: '35vh',
						paging: false,
						order: [[ 1, 'asc' ]],
						columnDefs: [
							{ className: "input-hidden", targets: [0] },
							{ className: "text-center", targets: [0] }
						],
						info: false,
						searching: false,
						data: rows
					} );
				}
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
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />

<style>
	#tb-attach-srv tbody tr td .btn-sm {
		padding-top: 0.15rem!important;
		padding-bottom: 0.15rem!important;
	}
	
	.selected{
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

	.match-content{
		width: auto!important;
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

	span.col-form-label {
		width: 70%;
		border-bottom: dotted 1px;
		display: inline-block;
		word-wrap: break-word;
	}

	.nav-tabs{
		margin-bottom: 0!important;
		border-bottom: none!important;
	}

    .nav-tabs .nav-link.active{
    	color: #5c6bc0 !important;
    	font-weight: 400!important;
    	font-size: 16px!important;
    }

    .nav-tabs .nav-link{
    	font-size: 15px!important;
    }

	.bootstrap-select.btn-group:not(.input-group-btn), .bootstrap-select.btn-group[class*="col-"] {
	    float: left!important;
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

</style>
<div class="row" style="font-size: 12px!important;">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH ĐÓNG RÚT SANG CONTAINER</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="nav nav-tabs">
	                        <li class="nav-item">
	                            <a class="nav-link active" href="#tab-order" data-value="tab-order" data-toggle="tab"><i class="mr-2"></i>Thông tin lệnh</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" href="#tab-attach-service" data-value="tab-attach-service" data-toggle="tab"><i class="mr-2"></i>Dịch vụ đính kèm</a>
	                        </li>
	                    </ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-order">
						<div class="row border-e has-block-content bg-white pb-1">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Số lệnh</label>
											<div class="col-sm-8 input-group input-group-sm">
												<input class="form-control form-control-sm" id="ref-no" type="text" placeholder="Số lệnh" readonly style="background-color:#d3ddd433 !important">
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Ngày lệnh</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="ref-date" type="text" placeholder="Ngày lệnh" readonly>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="ref-exp-date" type="text" placeholder="Hạn lệnh">
													<span class="input-group-addon bg-white btn text-danger" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Phương án</label>
											<div class="col-sm-8">
												<select id="service_code" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
													<option value="" selected="">-- Chọn phương án --</option>
													<?php if(isset($services) && count($services) > 0){ foreach ($services as $item){ ?>
														<option value="<?= $item['CJMode_CD'] ?>"><?= $item['CJMode_CD']." : ".$item['CJModeName'] ?></option>
													<?php }} ?>
												</select>
											</div>
										</div>
									</div>
									<!-- //////////////////////////////// -->
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Tàu/chuyến *</label>
											<div class="col-sm-8 input-group">
												<input class="form-control form-control-sm input-required" id="shipid" placeholder="Tàu/chuyến" type="text" readonly>
												<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="chọn tàu" data-toggle="modal" data-target="#ship-modal" onclick="search_ship()">
													<i class="ti-search"></i>
												</span>
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">D/O *</label>
											<div class="col-sm-8 input-group input-group-sm">
												<input class="form-control form-control-sm input-required" id="do" type="text" placeholder="D/O">
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label pr-0">Số Booking *</label>
											<div class="col-sm-8 input-group input-group-sm">
												<input class="form-control form-control-sm input-required" id="bookNo" type="text" placeholder="Số booking">
											</div>
										</div>
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">Số container</label>
											<div class="col-sm-8 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm" id="cntrno" type="text" placeholder="Container No.">
													<span class="input-group-addon bg-white btn text-warning" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
												</div>
											</div>
										</div>
										<!-- <div class="row form-group">
											<label class="col-sm-4 col-form-label">Hãng khai thác</label>
											<div class="col-sm-8">
												<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
													<option value="" selected>--chọn--</option>
												</select>
											</div>
										</div> -->
									</div>
								</div>
							</div>
							<!-- ///////////////////////// -->
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
					</div>
					<div class="tab-pane fade" id="tab-attach-service">
						<div class="row border-e has-block-content bg-white pb-1" style="padding-top: 10px">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tb-attach-srv" class="table table-striped display nowrap single-row-select" cellspacing="0" style="width: 99.8%">
									<thead>
									<tr>
										<th style="max-width: 15px">STT</th>
										<th>Số lệnh</th>
										<th>Mã phương án</th>
										<th>Tên phương án</th>
										<th>Danh sách cont</th>
										<th>Thời gian</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
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
							<button id="remove" class="btn btn-outline-danger btn-sm mr-1">
								<span class="btn-icon"><i class="fa fa-trash"></i>Xóa</span>
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
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>STT</th>
							<th style="min-width: 80px; text-align: center;">Số lệnh</th>
							<th>Số container</th>
							<th>Số vận đơn</th>
							<th>Số Booking</th>
							<th>Phương án</th>
							<th>Hãng khai thác</th>
							<th>Kích cỡ nội bộ</th>
							<th>Kích cỡ ISO</th>
							<th>Hàng/Rỗng</th>
							<th>Số chì</th>
							<th>Loại hàng</th>
							<th>Hàng hóa</th>
							<th>Trọng lượng</th>
							<th>VGM</th>
							<th>Hàng Nội/Ngoại</th>
							<th>Chuyển cảng</th>
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
							<th>Hàng/rỗng </th>
							<th>Nội/ngoại</th>
							<th>Số lượng</th>
							<th>Đơn giá</th>
							<th>CK (%)</th>
							<th>Đơn giá CK</th>
							<th>Đơn giá sau CK</th>
							<th>Thành tiền</th>
							<th>VAT (%)</th>
							<th>Tiền VAT</th>
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

<!--conts modal-->
<div class="modal fade" id="conts-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 700px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách container</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="conts-list" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">Chọn</th>
							<th>Số container</th>
							<th>Kích cỡ</th>
							<th>Kích cỡ ISO</th>
							<th>Full/Empty</th>
							<th>Hãng Khai Thác</th>
							<th>Trọng Lượng</th>
							<th>Vị trí bãi</th>
							<th>Số Niêm Chì</th>
							<th>Hướng</th>
							<th>Ghi Chú</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-conts" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác Nhận</button>
					<button class="btn btn-sm btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
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
				<button type="button" id="select-ship" class="btn btn-sm btn-success" data-dismiss="modal">Chọn</button>
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Đóng</button>
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

		var attachServicesOrderNo = $('#tb-attach-srv tbody tr').find('td:eq(1)');
		$.each(attachServicesOrderNo, function(idx, item){
			var cok = $(item).text();
			if(cok){
				deleteCookie("eir__"+cok);
			}
		});
	}

	$(document).ready(function () {
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
							, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
							, "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],

			_cols = ["STT", "SSOderNo", "CntrNo" ,"BLNo" ,"BookingNo", "CJMode_CD", "OprID", "LocalSZPT", "ISO_SZTP", "Status", "SealNo", "CARGO_TYPE", "CmdID", "CMDWeight", "VGM"
							, "IsLocal", "Transist", "cTLHQ"],

			_attachServices = ["STT", "SSOderNo", "CJMode_CD", "CJModeName", "CntrNo_List", "PTI_Hour"],

			_colsContList = ["Check", "CntrNo", "LocalSZPT", "ISO_SZTP", "Status", "OprID", "CMDWeight", "Location", "SealNo", "CntrClass", "Remark"],

			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];
		
		var  _lstOrder = [], _lstAttachSRV = [], selected_cont = [];
		var _selectShipKey = '', _berthdate = '';

		var tempService;

		var payers= {};
		<?php if(isset($payers) && count($payers) > 0){ ?>
			payers = <?= json_encode($payers);?>;
		<?php } ?>

		var _lstContainer = {};
		<?php if(isset($contList) && count($contList) > 0){ ?>
			_lstContainer = <?= json_encode($contList);?>;
		<?php } ?>

		var rContList = [];
		$.each(_lstContainer, function(idx, item){
			var r=[];
			$.each(_colsContList, function(i, t){
				var vlue = "";
				switch(t){
					case "Status" : 
						vlue = item[t] == "F" ? "Full" : "Empty";
						break;
					case "Location": 
						vlue = item["cBlock"] + "-" + item["cBay"] + "-" + item["cRow"] + "-" + item["cTier"];
						vlue = vlue.replace("null-", "");
						break;
					case "CntrClass" : vlue = "Storage Empty";
					break;
					default:
						vlue = item[t] ? item[t] : "";
				}
				r.push(vlue);
			})
			rContList.push(r);
		});

		$('#conts-list').DataTable({
			data: rContList,
			info: false,
			paging: false,
			ordering: false,
			searching: true,
			scrollY: '30vh'
		});

		$('#tb-attach-srv').DataTable({
			paging: false,
			order: [[ 0, 'asc' ]],
			scrollCollapse: true,
			buttons: [],
			info: false,
			searching: true,
			scrollY: ($('#tab-order').height()-50) + 'px'
		});

		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false,
			buttons: [],
			scrollY: '25vh'
		});

		$('#tbl-conts').DataTable({
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

		// genSrvOdrNo(false);
		$('#ref-date').val(moment().format('DD/MM/YYYY HH:mm:ss'));
		$('#ref-exp-date, #MT-exp-date').datepicker({
			format: "dd/mm/yyyy 23:59:59",
			startDate: moment().format('DD/MM/YYYY HH:mm:ss'),
			todayHighlight: true,
			autoclose: true
		});
		$('#ref-exp-date').val(moment().format('DD/MM/YYYY 23:59:59'));
		$('#ref-exp-date + span').on('click', function () {
			$('#ref-exp-date').val('');
		});

		genSrvOdrNo();
		load_payer();

///////// SEARCH SHIP
		$('#btn-search-ship').on('click', function () {
			search_ship();
		});
		$(document).on('click','#search-ship tbody tr', function() {
			$('.selected').removeClass('selected');
			$(this).addClass('selected');
		});
		$('#search-ship-name').on('keypress', function (e) {
			if(e.which == 13) {
				search_ship();
			}
		});
		$('#select-ship').on('click', function () {
			var r = $('#search-ship tbody').find('tr.selected').first();
			$('#shipid').val($(r).find('td:eq(0)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#shipid').removeClass('error');

			_selectShipKey = $(r).find('td:eq(6)').text();
			_berthdate = $(r).find('td:eq(7)').text();

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

			$('#ship-modal').modal("toggle");
		});
		$('#ship-modal, #payer-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});
///////// END SEARCH SHIP

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

		$('#service_code').on('change', function(){
			var table = $('#tb-attach-srv').DataTable();
			if(table.rows().data().length > 0){
				clearAttachOrderNo();
				table.clear().draw();
			}

			if(!$(this).val()){
				return;
			}

			if($('#tbl-conts').DataTable().rows().data().length > 0){
				load_attach_srv();
			}
		});

		//APPLY + SEARCH CONTAINER
		$('#cntrno + span').on('click', function () {
			if(_lstContainer.length > 0){
				$(this).attr('data-target', '#conts-modal');
			}else{
				$('.toast').remove();
				toastr['warning']('Không có container đủ điều kiện!');
				$(this).attr('data-target', '');
			}
		});
		$(document).on('click','#conts-list tbody tr td', function () {
			var rowIdx = $(this).parent().index();
			var tblconts = $('#conts-list').DataTable();
			tblconts.cell(rowIdx, 0)
				    .nodes()
				    .to$()
				    .toggleClass( 'ti-check' );

			tblconts.rows(rowIdx)
				    .nodes()
				    .to$()
				    .toggleClass( 'selected' );
			// $(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			// $(this).parent().toggleClass('selected');
		});
		$(document).on('click', '.dt-buttons a.buttons-select-all[aria-controls="conts-list"]', function(){
			$('#conts-list').DataTable().columns(0)
										.nodes()
										.flatten()  // Reduce to a 1D array
									    .to$()
									    .addClass('ti-check');
		});
		$(document).on('click', '.dt-buttons a.buttons-select-none[aria-controls="conts-list"]', function(){
			$('#conts-list').DataTable().columns(0)
										.nodes()
										.flatten()  // Reduce to a 1D array
									    .to$()
									    .removeClass('ti-check');
		});

		$('#apply-conts').on('click', function () {
			selected_cont = [];
			var table = $('#conts-list').DataTable();
			var data = table
						.rows('.selected')
						.data()
						.to$();
			$.each(data, function(i, v){
				selected_cont.push(v[_colsContList.indexOf("CntrNo")]);
			});
			apply_cont();
		});

		var _tp = "";
		$('#cntrno').on('change keypress', function (e) {
			var cntrno = $('#cntrno').val().trim();
			if(!cntrno){
				return;
			}
			if(_lstContainer.length == 0){
				toastr['warning']('Không có container đủ điều kiện!');
				return;
			}

			if((e.type == 'change' || e.which == 13) && _tp==""){
				if($.inArray(cntrno, selected_cont) == "-1"){
					$('.has-block-content').blockUI();
					selected_cont.push(cntrno);

					var table = $('#conts-list').DataTable();
					
					table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
					 	if(this.data()[_colsContList.indexOf("CntrNo")] == cntrno){
					 		table.rows( rowIdx )
								    .nodes()
								    .to$()
								    .addClass( 'selected' );

							table.cell(rowIdx, _colsContList.indexOf("Check"))
								    .nodes()
								    .to$()
								    .addClass( 'ti-check' );
					 	}
					} );
					apply_cont();
				}

				_tp = e.type;
				return;
			}
			_tp = "";
		});

		var iptimee;
		$('input').on('input', function (e) {
			clearTimeout(iptimee);
			iptimee = window.setTimeout(function () {
				$(e.target).blur();
			}, 2000);
		});

		var typingTimer;
		$(document).on('change','input[type!="radio"], select', function (e) {
			clearTimeout(typingTimer);
			if($(this).val()){
				$(this).removeClass('error');
				$(this).parent().removeClass('error');
			}
			if($(e.target).attr('id') == 'taxcode'){
				var taxcode = $(this).val(); var pytype = getPayerType(taxcode);
				$.each(_lstOrder, function (k, v) {
					_lstOrder[k].CusID = taxcode;
					_lstOrder[k].PAYER_TYPE = pytype;
				});
				fillPayer();
			}
			typingTimer = window.setTimeout(function () {
				//reset list eir
				_lstOrder = [];
				if($('.input-required.error').length == 0){
					if(_lstContainer.length > 0 && selected_cont.length > 0){
						for (i = 0; i < _lstContainer.length; i++) {
							if (selected_cont.indexOf(_lstContainer[i].CntrNo) == '-1') continue;
							addCntrToSRV_ODR(_lstContainer[i]);
						}
					}
					if($('#chk-view-inv').is(':checked') && $.inArray($(e.target).attr('id'), ['service_code', 'taxcode']) != "-1"){
						loadpayment();
					}
				}
			}, 2000);
		});

		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	        $($.fn.dataTable.tables(true)).DataTable()
	            .columns.adjust()
	            .draw();
	    });

	    $('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				loadpayment();
			}
			if($(this).val() == "inv"){
				$('#tbl-inv').DataTable().columns.adjust();
			}else{
				$('#tbl-conts').DataTable().columns.adjust();
			}
		});

		$('#pay-atm').on('click', function () {
			publishInv();
		});

		$('#save-credit').on("click", function(){
			saveData();
		});

		function addCntrToSRV_ODR(item){
			item['SSOderNo'] =  $('#ref-no').val();
			item['CJMode_CD'] =  $('#service_code').val();
			
			item['PTI_Hour'] = 0;

			item['IssueDate'] =  $('#ref-date').val(); //*
			item['ExpDate'] =  $('#ref-exp-date').val(); //*
			item['BookingNo'] = $('#bookNo').val(); //*
			item['NameDD'] =  $('#personal-name').val();
			item['PersonalID'] =  $('#cmnd').val();
			// item['DMETHOD_CD'] = $('#dmethod').val();

			item['Note'] = $('#remark').val();
			item['SHIPPER_NAME'] = $('#shipper-name').val(); //*
			item['PAYER_TYPE'] = getPayerType($('#taxcode').val());
			item['CusID'] = $('#taxcode').val(); //*
			item['DELIVERYORDER'] =  $('#do').val();

			item['ShipKey'] =  _selectShipKey;
			item['ShipID'] =  $('#shipid').val().split('/')[0];
			item['ImVoy'] =  $('#shipid').val().split('/')[1];
			item['ExVoy'] =  $('#shipid').val().split('/')[2];
			item['BerthDate'] = _berthdate;

			// item['OPERATIONTYPE'] = $('#dmethod').val();
			// item['SSRMORE'] = $('#ref-no').val();

			item['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
			item['PAYMENT_CHK'] = item['PAYMENT_TYPE'] == "C" ? "0" : "1";

			item['cBlock1'] = item['cBlock'];
			item['cBay1'] = item['cBay'];
			item['cRow1'] = item['cRow'];
			item['cTier1'] = item['cTier'];
			delete item['cBlock'];
			delete item['cBay'];
			delete item['cRow'];
			delete item['cTier'];

			_lstOrder.push(item);
		}

		function addCntrToAttachSRV(){
			_lstAttachSRV = [];

			var lst = $('#tb-attach-srv').DataTable().rows().data().toArray();
			if(lst.length == 0){
				return [];
			}

			$.each(lst, function(index, row){
				if(!row[_attachServices.indexOf("SSOderNo")]){
					return;
				}

				var selectpickerCntrList = $('#tb-attach-srv tbody').find('tr:eq('+index+')').find('td:eq('+_attachServices.indexOf("CntrNo_List")+')').first().find('select').first();

				var arrCntrAttach = $(selectpickerCntrList).val();
				var selectContArr = _lstOrder.filter(p=>arrCntrAttach.indexOf(p.CntrNo.trim()) != "-1");

				if(!selectContArr || selectContArr.length == 0){
					return;
				}

				$.each(selectContArr, function(idx, item){
					var n = $.extend( {}, item );

					n['SSOderNo'] =  row[_attachServices.indexOf("SSOderNo")];
					n['CJMode_CD'] =  row[_attachServices.indexOf("CJMode_CD")];
					
					n['PTI_Hour'] = parseInt(row[_attachServices.indexOf("PTI_Hour")]);

					n['IssueDate'] =  $('#ref-date').val(); //*
					n['ExpDate'] =  $('#ref-exp-date').val(); //*
					n['BookingNo'] = $('#bookNo').val(); //*
					n['NameDD'] =  $('#personal-name').val();
					n['PersonalID'] =  $('#cmnd').val();
					n['DELIVERYORDER'] =  $('#do').val();
					
					//n['DMETHOD_CD'] = $('#dmethod').val();

					n['Note'] = $('#remark').val();
					n['SHIPPER_NAME'] = $('#shipper-name').val(); //*
					n['PAYER_TYPE'] = getPayerType($('#taxcode').val());
					n['CusID'] = $('#taxcode').val(); //*

					// n['OPERATIONTYPE'] = $('#dmethod').val();
					n['SSRMORE'] = $('#ref-no').val();

					n['PAYMENT_TYPE'] = $('#payment-type').attr('data-value');
					n['PAYMENT_CHK'] = n['PAYMENT_TYPE'] == "C" ? "0" : "1";

					n['cBlock1'] = n['cBlock'];
					n['cBay1'] = n['cBay'];
					n['cRow1'] = n['cRow'];
					n['cTier1'] = n['cTier'];
					delete n['cBlock'];
					delete n['cBay'];
					delete n['cRow'];
					delete n['cTier'];

					_lstAttachSRV.push(n);
				});
			});
		}

		// function
		function apply_cont(){
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

			$("#tbl-conts").waitingLoad();
			var rows = [];
			if(_lstContainer.length > 0 && selected_cont.length > 0){
				var stt = 1;
				//reset list order
				_lstOrder = [];
				for (i = 0; i < _lstContainer.length; i++) {
					if(selected_cont.indexOf(_lstContainer[i].CntrNo) == '-1') continue;

					//add item cntr_details to _lst;
					if($('.input-required.error').length == 0){
						if(!hasrequired){
							addCntrToSRV_ODR(_lstContainer[i]);
						}
					}
					var cntrclass = _lstContainer[i].CntrClass == 1 ? "Nhập" : (_lstContainer[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
					var r = [];

					$.each(_cols, function(indx, item){
						var value = "";
						switch(item){
							case "STT":
								value = stt++;
								break;
							case "CARGO_TYPE":
								value = '<input class="hiden-input" value="'+ _lstContainer[i].CARGO_TYPE +'"/>' + _lstContainer[i].Description;
								break;
							case "IsLocal":
								value = _lstContainer[i].IsLocal == "F" ? "Ngoại" : (_lstContainer[i].IsLocal == "L" ? "Nội" : "");
								break;
							case "Status":
								value = _lstContainer[i].Status == "F" ? "Hàng" : "Rỗng";
								break;
							case "cTLHQ":
								value = _lstContainer[i].cTLHQ == 1 ? "Đã thanh lý" : "Chưa thanh lý";
								break;
							default:
								value = _lstContainer[i][item] ? _lstContainer[i][item] : "";
								break;
						}
						r.push(value);
					});
					rows.push(r);
				}
			}

			$('#chk-view-cont').trigger('click');
			$('#tbl-conts').DataTable( {
				data: rows,
				info: false,
				paging: false,
				searching: false,
				scrollY: '30vh',
	            select: true,
	            rowReorder: false,
				buttons: []
			} );

			$('#tbl-conts').realign();
			$('#tbl-inv').DataTable().clear().draw();
			$('.has-block-content').unblock();

			if($("#tb-attach-srv").DataTable().rows().data().length > 0){
				var selectPckCntr = $('#tb-attach-srv').find('.selectpicker').first();
				var sPVal = selectPckCntr.val();
				var compareVal = selected_cont.diff(sPVal);

				if(compareVal && compareVal.length > 0){
					$.each(compareVal, function(indx, item){
						$('#tb-attach-srv').find('.selectpicker').append('<option value="'+item+'">'+item+'</option>');
					});
				}

				$('#tb-attach-srv').find('.selectpicker').selectpicker('refresh');
			}else{
				if($('#service_code').val()){
					load_attach_srv();
				}
			}
		}

		function clearAttachOrderNo(){
			var coldata = table.column(_attachServices.indexOf("SSOderNo"))
								.data()
								.to$();

			$.each(coldata, function(i, v){
				if(v){
					deleteCookie("eir__"+v);
				}
			});
		}

		function load_attach_srv(){
			$('#tb-attach-srv').blockUI();
			$("#tb-attach-srv").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_attach_srv',
				'order_type': $('#service_code').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskTransStuffOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.lists && data.lists.length > 0) {
						for (i = 0; i < data.lists.length; i++) {
							var r = [];
							
							$.each(_attachServices, function(indx, colname){
								if(colname == "CntrNo_List"){
									var selectpicker_html = "";
									$.each(selected_cont, function(idx, item){
										selectpicker_html += "<option value='"+item+"'>"+item+"</option>";
									})
									var selectPickerContainer = '<select id="select-conts-'+i+'" class="selectpicker form-control match-content" data-selected-text-format="count" data-actions-box="true" data-style="btn-default btn-sm" multiple="" tabindex="-98">'
																+ selectpicker_html
																+ '</select>';
									r.push(selectPickerContainer);
								}else if(colname == "STT"){
									r.push(i+1);
								}else{
									r.push(data.lists[i][colname] ? data.lists[i][colname] : "");
								}
							});
							rows.push(r);
						}
					}
					$('#tb-attach-srv').DataTable( {
						scrollY: ($('#tab-order').height()-50) + 'px',
						paging: false,
						order: [[ 0, 'asc' ]],
						buttons: [],
						info: false,
						searching: true,
						data: rows
					} );

					$('#tb-attach-srv').find('.selectpicker').selectpicker({
						"selectAllText": "Chọn hết",
					 	"deselectAllText": "Bỏ chọn",
					 	"noneSelectedText": "Chọn container",
					 	"countSelectedText": function(a,b){
					 		return 1==a?"{0} cont được chọn":"{0} cont được chọn";
					 	}
					}).on('change', function(){
						var elem = $(this).closest('tr').find('td:eq('+_attachServices.indexOf("SSOderNo")+')').first();
						var vals = $(this).val();
						if(!vals){
							var addSSOderNo = elem.text();
							if(addSSOderNo){
								$(this).closest('table').DataTable().cell(elem).data('');
								deleteCookie("eir__"+addSSOderNo);
							}
							return;
						}
						if(!elem.text()){
							//set disable radio check view payment grid
							// waiting for SSOderNo had generated , set enable again (in genSrvOdrNo function)
							$('#chk-view-inv').prop("disabled", true);
							genSrvOdrNo(elem);
						}
					});

					$('#tb-attach-srv').unblock();
				},
				error: function(err){
					$('#tb-attach-srv').unblock();
					console.log(err);
				}
			});
		}

		function loadpayment(){
			if(_lstOrder.length == 0) {
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

			addCntrToAttachSRV();
			var lstSRV_ODR_Sumary = _lstOrder.concat(_lstAttachSRV);

			$('#tbl-inv').waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#taxcode').val(),
				'list': lstSRV_ODR_Sumary
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskTransStuffOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.results && data.results.length > 0){
						var lst = data.results, stt = 1;
						for (i = 0; i < lst.length; i++) {
							rows.push([
								(stt++)
								, lst[i].DraftInvoice
								, lst[i].OrderNo
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

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskTransStuffOrder'));?>",
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

		function genSrvOdrNo(elem){
			if (typeof elem === "undefined" || elem === null) {
				elem = $('#ref-no');
			}

			var onbrowsereirs = []; var maxeir = '';
			var parts = document.cookie.split(';');
			var pLen = document.cookie.split(';').length;
			for (var i = 0; i < pLen; i++) {
				var ck = parts[i].split("=");
				if(ck.length <= 1) continue;
				var itemName = ck[0].replace(" ", "");
				if(itemName.match(/eir__/) !== null){
					onbrowsereirs.push(parseInt(itemName.replace("eir__", "")));
				}
				if(itemName.match(/me__/) !== null){
					maxeir = itemName.replace('me__', '');
				}
			}

			var formdata = {
				'action': 'view',
				'act': 'genSrvOdrNo',
				'browser_eirs': onbrowsereirs,
				'maxeir': maxeir
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskTransStuffOrder'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var new_max_eir = data.maxeir;
					//before generate SSOderNo -> set disable radio check view payment grid
					//in here, set enable again
					$('#chk-view-inv').prop("disabled", false);
					if(data.newEIRNo){
						var ssNo = data.newEIRNo;
						if(elem.is("td")){
							var table = elem.closest('table').DataTable();

							var coldata = table.column(_attachServices.indexOf("SSOderNo"))
												.data()
												.toArray();
							//convert value in array to int					
							coldata = coldata.filter(p=>p!=="").map(x => parseInt(x));

							if(coldata.length > 0 && coldata.indexOf(ssNo) != "-1"){
								ssNo = coldata.max() + 1;
							}

							table.cell(elem).data(ssNo);
						}else{
							elem.is("input") ? elem.val(ssNo) : elem.text(ssNo);
						}

						setCookietoEndofDay("eir__"+ssNo, 1);

						var parts = document.cookie.split(';');
						var pLen = document.cookie.split(';').length;
						var xck = 0, x2ck = 0;
						for (var i = 0; i < pLen; i++) {
							var ck = parts[i].split("=");
							var itemName = ck[0].replace(" ", "");
							if(itemName.match(/eir__/) !== null){
								var cr_xck = parseInt(itemName.replace('eir__', ''));
								if( cr_xck > xck){
									xck = cr_xck;
								}
							}
							if(itemName.match(/me__/) !== null){
								var cr_x2ck = parseInt(itemName.replace('me__', ''));
								if( cr_x2ck > x2ck){
									x2ck = cr_x2ck;
								}
								deleteCookie(itemName);
							}
						}

						var endxck = xck>x2ck?xck:x2ck;
						var ee = (new_max_eir == "")?endxck:(new_max_eir>endxck?new_max_eir:endxck);
						setCookietoEndofDay("me__"+ee, 111);
					}
				},
				error: function(err){
					//before generate SSOderNo -> set disable radio check view payment grid
					//in here, set enable again
					$('#chk-view-inv').prop("disabled", false);
					console.log(err);
				}
			});
		}

		function fillPayer(){
			var py = payers.filter(p=> p.VAT_CD == $('#taxcode').val() && p.CusID == $("#cusID").val());
			if(py.length > 0){ //fa-check-square
				$('#p-taxcode').text(py[0].VAT_CD);
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
				eirno : $('#ref-no').val(),
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskServiceOrder'));?>",
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
				temp['Remark'] = $.unique(_lstOrder.map(p=> p.CntrNo)).toString();
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskTransStuffOrder'));?>",
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
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

<style>
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
				<div class="ibox-title">LỆNH CẤP CONTAINER HÀNG</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row border-e bg-white pb-1">
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">Phương án</label>
							<div class="col-sm-8">
								<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
									<option value="LAYN" selected>Lấy Nguyên</option>
								</select>
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
							<div class="col-sm-8 col-form-label ml-sm-auto">
								<label class="checkbox checkbox-warning text-warning">
									<input type="checkbox" name="chkMT-return" id="chkMT-return" value="0">
									<span class="input-span"></span>
									Lệnh kép trả rỗng
								</label>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-sm-4 col-form-label">D/O *</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm input-required" id="do" type="text" placeholder="D/O">
							</div>
						</div>
						<div class="row form-group">
							<label class="col-sm-4 col-form-label pr-0">Số vận đơn *</label>
							<div class="col-sm-8 input-group input-group-sm">
								<input class="form-control form-control-sm input-required" id="billno" type="text" placeholder="Số vận đơn">
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
					<table id="tbl-conts" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th>STT</th>
							<th>Số cont</th>
							<th>Số vận đơn</th>
							<th>Hướng</th>
							<th>Hãng khai thác</th>
							<th>Kích cỡ nội bộ</th>
							<th>Kích cỡ ISO</th>
							<th>Hàng/Rỗng</th>
							<th>Số chì</th>
							<th>Nội/ngoại</th>
							<th>Trọng lượng</th>
							<th>Loại hàng</th>
							<th>Nhiệt độ</th>
							<th>Mã nguy hiểm</th>
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
<!--bill modal-->
<div class="modal fade" id="bill-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" 
				data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 700px!important">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Thông tin vận đơn</h5>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="bill-detail" class="table table-striped display nowrap table-popup" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th style="max-width: 10px!important;">Chọn</th>
							<th>Số container</th>
							<th>Hãng tàu</th>
							<th>Kích cỡ</th>
							<th>Vị trí bãi</th>
							<th>Thanh lý HQ</th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-bill">
						<span class="btn-label"><i class="ti-check"></i></span>Chuyển tính tiền</button>
					<button class="btn btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
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

	$(document).ready(function () {

		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMETHOD_CD", "CARGO_TYPE", "ISO_SZTP"
							, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
							, "IX_CD", "CNTR_JOB_TYPE", "VAT_CHK"],
			_colPayer = ["STT", "CusID", "VAT_CD", "CusName", "Address", "CusType"];

		var _result = [], _lstEir = [];
		var selected_cont = [], tblConts = $( "#tbl-conts" ), tblInv = $( "#tbl-inv" );

		var payers= {};
		
		$('#search-barge').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		tblConts.DataTable({
			info: false,
			paging: false,
			searching: false,
            select: true,
			buttons: [],
			scrollY: '30vh'
		});

		tblInv.DataTable({
			info: false,
			paging: false,
			searching: false,
			buttons: [],
			scrollY: '30vh'
		});

		$('#bill-detail').DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: false,
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

		$('#chkMT-return').on('change', function () {
			$('.MT-toggle').toggle(700);
			$('.MT-toggle').find('.MT-change-required').toggleClass('input-required');

			if(!$(this).is(':checked')){
				_lstEir = _lstEir.filter(item => item.CJMode_CD != "TRAR");
			}
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

		$('input[name="view-opt"]').bind('change', function (e) {
			$('.grid-toggle').find('div.table-responsive').toggleClass('grid-hidden');
			if($('#chk-view-inv').is(':checked') && $('#tbl-inv tbody').find('tr').length <= 1){
				loadpayment();
			}
			if($(this).val() == "inv"){
				tblInv.DataTable().columns.adjust();
			}else{
				tblConts.DataTable().columns.adjust();
			}
		});

		$('input[name="chkSalan"]').on('change', function () {
			$('#barge-ischecked').toggleClass('unchecked-Salan');
			$('#barge-info').toggleClass('input-required');

			var ischecked = $(this).is(':checked');
			if(!ischecked){
				$('#barge-info').val('');
			}
			var bargeInfo = $('#barge-info').val();

			$.each(_lstEir, function (idx, item) {
				item.DMETHOD_CD = ischecked ?  "BAI-SALAN" : "BAI-XE";
				item.IsTruckBarge =  ischecked ? "B" : "T";
				item.BARGE_CODE = bargeInfo ? bargeInfo.split('/')[0] : "";
				item.BARGE_YEAR = bargeInfo ? bargeInfo.split('/')[1] : "";
				item.BARGE_CALL_SEQ = bargeInfo ? bargeInfo.split('/')[2] : "";
			});

			if($('#chk-view-inv').is(':checked')){
				loadpayment();
			}
		});

		$('input[name="chkMT-return"]').on('change', function () {
			$('.unchecked-Salan').toggleClass('unchecked-Salan');
		});

		$('#barge-modal, #bill-modal, #payer-modal').on('shown.bs.modal', function(e){
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

		var _ktype = "";
		$('#billno').on('keypress', function (e) {
			if(!$(this).val()) return;
			if(e.keyCode == 13){
				_ktype = "enter";
				search_bill($(this).val() ,'');
			}
		});

		$('#cntrno + span').on('click', function () {
			var rl = $('#bill-detail').DataTable().rows().to$();
			if(rl.length == 1 && rl[0].length > 0){
				$(this).attr('data-target', '#bill-modal');
			}else{
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin vận đơn!');
				$(this).attr('data-target', '');
			}
		});

		var _tp = "";
		$('#cntrno').on('change keypress', function (e) {
			if((e.type == 'change' || e.which == 13) && _tp==""){
				apply_cont();
				_tp = e.type;
				return;
			}
			_tp = "";
		});

		$(document).on('click','#bill-detail tbody tr td', function () {
			$(this).parent().find('td:eq(0)').first().toggleClass('ti-check');
			$(this).parent().toggleClass('m-row-selected');
		});

		//select barge
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
			$('#barge-info').trigger('change');
		});

		$('#search-barge').on('dblclick','tbody tr td', function() {
			var r = $(this).parent();
			$('#barge-info').val($(r).find('td:eq(1)').text() + "/" + $(r).find('td:eq(3)').text() + "/" + $(r).find('td:eq(4)').text());
			$('#barge-modal').modal("toggle");
			$('#barge-info').trigger('change');
		});

		$('#apply-bill').on('click', function () {
			var btn = $(this);
			var chkTLHQ_cntr = [];
// data-keyboard="false" 
			selected_cont = [];
			$.each( $('#bill-detail').find('td.ti-check'), function (k,v) {
				var isTLHQ = $(v).parent().find('td:eq(5) input').first().val(),
					applyCntrNo = $(v).parent().find('td:eq(1)').first().text();

				if(isTLHQ == "0"){
					chkTLHQ_cntr.push(applyCntrNo);
				}else{
					selected_cont.push(applyCntrNo);
				}
			});

			if(chkTLHQ_cntr.length > 0){
				$('#bill-modal').attr("data-keyboard", "false");
				var confirmBtn = {
	                ok: {
	                    text: 'Tiếp tục với những cont đã chọn',
	                    btnClass: 'btn-primary btn-sm lower-text',
	                    action: function(){
	                    	selected_cont = selected_cont.concat(chkTLHQ_cntr);

	                    	$('#bill-modal').modal("hide");

							apply_bill();
	                    }
	                }
	            };

	            if(selected_cont.length > 0){
	            	confirmBtn["need"] = {
	            		text: 'Chỉ chọn cont đã thanh lý',
	                    btnClass: 'btn-warning btn-sm lower-text',
	                    action: function(){
	                    	$('#bill-detail').find("tbody tr").each(function(k, v){
	                    		var cntrNoChk = $(v).find("td:eq(1)").text();
	                    		if(chkTLHQ_cntr.indexOf(cntrNoChk) != "-1"){
	                    			$(v).removeClass("m-row-selected");
	                    			$(v).find("td:eq(0)").removeClass("ti-check");
	                    		}
	                    	});

	                    	$('#bill-modal').modal("hide");
							apply_bill();
	                    }
	            	}
	            }else{
	            	confirmBtn.ok.text = "Tiếp tục";
	            	confirmBtn.ok["keys"] = ["Enter"];
	            }

	            confirmBtn["cancel"] = {
	            	text: 'Hủy bỏ',
                    btnClass: 'btn-default btn-sm lower-text',
                    keys: ['ESC']
	            }

				$.confirm({
		            title: 'Cảnh báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Có container chưa được thanh lý HQ!<br/>Tiếp tục làm lệnh ?',
		            buttons: confirmBtn
		        });
			}else{
				$('#bill-detail').find("tbody tr").each(function(k, v){
            		var cntrNoChk = $(v).find("td:eq(1)").text();
            		if(chkTLHQ_cntr.indexOf(cntrNoChk) != "-1"){
            			$(v).removeClass("m-row-selected");
            			$(v).find("td:eq(0)").removeClass("ti-check");
            		}
            	});

            	$('#bill-modal').modal("hide");

				apply_bill();
			}
		});

		$('#remove').on('click', function () {
			if($('#chk-view-inv').is(':checked')) return;
			
			tblConts.confirmDelete(function(selectedData){
				if( $( '#tbl-cont tbody' ).find( 'td.dataTables_empty' ).length > 0 ) {
					return;
				}

				var selectContNos = tblConts.find('tr.selected').find('td:eq('+ 1 +')').map( function(){ return $(this).text(); }  ).get();
				tblConts.DataTable().rows(".selected").remove().draw(false);
				tblConts.updateSTT();

				_lstEir = _lstEir.filter( p=> selectContNos.indexOf( p.CntrNo ) == "-1" );

				$.each($('#booking-detail tbody ').find('tr').find('td:eq(1)'), function (idx, td) {
					if(tdtexts.indexOf($(td).text()) != "-1"){
						$(td).parent().removeClass('m-row-selected');
						$(td).parent().find('td:eq(0)').removeClass('ti-check');
					}
				}) ;
        		
        		tblInv.DataTable().clear().draw();
        	});
		});

		$('#pay-atm').on('click', function () {
//			saveEIR();
//			saveData();
			publishInv();
		});

		$('#save-credit').on("click", function(){
			saveData();
		});

		var typingTimer;
		$(document).on('input change', '.input-required, #chkMT-return', function (e) {
			clearTimeout(typingTimer);
			if($(this).val()){
				$(this).removeClass('error');
				$(this).parent().removeClass('error');
			}
			if($(e.target).attr('id') == 'taxcode'){
				var taxcode = $(this).val(); var pytype = getPayerType(taxcode);
				$.each(_lstEir, function (k, v) {
					_lstEir[k].CusID = taxcode;
					_lstEir[k].PAYER_TYPE = pytype;
				});
				fillPayer();
			}

			if($(e.target).attr('id') == "billno"){
				if(e.type == 'change' && _ktype == ""){
					search_bill($('#billno').val(), '');
				}
				//reset list eir
				_lstEir = [];
				if(tblConts.find('tr').length > 1){
					tblConts.DataTable().clear().draw();
				}
				if(tblInv.find('tr').length > 1){
					tblInv.dataTable().fnClearTable();
				}
				return;
			}

			typingTimer = window.setTimeout(function () {
				//reset list eir
				_lstEir = [];
				if($('.input-required.error').length == 0){
					if(_result.length > 0 && selected_cont.length > 0){
						for (i = 0; i < _result.length; i++) {
							if (selected_cont.indexOf(_result[i].CntrNo) == '-1') continue;
							addCntrToEir(_result[i]);
						}
					}
					if($('#chk-view-inv').is(':checked') && $.inArray($(e.target).attr('id'), ['barge-ischecked', "barge-info", 'taxcode', 'chkMT-return']) != "-1"){
						loadpayment();
					}
				}
			}, 2000);
		});

		// function
		function apply_cont(){
			var cntrno = $('#cntrno').val().trim();
			if(!cntrno) return;

			if(_result.length == 0 || _result.filter(p=> p.CntrNo == cntrno).length == 0 || $('#bill-detail').DataTable().rows().to$().length == 0) {
				search_bill('', cntrno);
				return;
			}

			if($.inArray(cntrno, selected_cont) == "-1"){
				selected_cont.push(cntrno);
				var tds = $('#bill-detail').find('td:eq(1)').filter(p=> $(p).text() == cntrno);
				if(tds.length > 0){
					$(tds).parent().find('td:eq(0)').addClass('ti-check');
				}
				apply_bill();
			}
		}
		function apply_bill(){
			$('#bill-modal').attr("data-keyboard", "true");

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
			if(_result.length > 0 && selected_cont.length > 0){
				var stt = 1;
				//reset list eir
				_lstEir = [];
				for (i = 0; i < _result.length; i++) {
					if(selected_cont.indexOf(_result[i].CntrNo) == '-1') continue;

					//add item cntr_details to _lst;
					if($('.input-required.error').length == 0){
						if(!hasrequired){
							addCntrToEir(_result[i]);
						}
					}
					var cntrclass = _result[i].CntrClass == 1 ? "Nhập" : (_result[i].CntrClass == 4 ? "Nhập chuyển cảng" : "");
					var status = _result[i].Status == "F" ? "Hàng" : "Rỗng";
					var isLocal = _result[i].IsLocal == "F" ? "Ngoại" : (_result[i].IsLocal == "L" ? "Nội" : "");
					rows.push([
						(stt++)
						, _result[i].CntrNo
						, _result[i].BLNo
						, cntrclass
						, _result[i].OprID
						, _result[i].LocalSZPT
						, _result[i].ISO_SZTP
						, status
						, _result[i].SealNo
						, isLocal
						, _result[i].CMDWeight
						, '<input class="hiden-input" value="'+ _result[i].CARGO_TYPE +'"/>' + _result[i].Description
						, _result[i].Temperature
						, (_result[i].CLASS ? _result[i].CLASS : "") + "/" + (_result[i].UNNO ? _result[i].UNNO : "")
						, _result[i].Note
						, _result[i].cTLHQ == 1 ? "Đã thanh lý" : "Chưa thanh lý"
					]);
				}
			}
			$('#chk-view-cont').trigger('click');

			tblConts.dataTable().fnClearTable();
        	if(rows.length > 0){
				tblConts.dataTable().fnAddData(rows);
        	}

			tblInv.dataTable().fnClearTable();
		}

		function search_bill(billno, cntrNo){
			$('#bill-detail').waitingLoad();
			var formData = {
				'action': 'view',
				'act': 'search_bill',
				'billNo': billno,
				'cntrNo': cntrNo
			};
			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskImportPickup'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					_result = data.list;
					var rows = []; var blNo = '';

					if(_result && _result.length > 0) {
						blNo = _result[0].BLNo;
						for (i = 0; i < _result.length; i++) {
							rows.push([
								''
								, _result[i].CntrNo
								, _result[i].OprID
								, _result[i].ISO_SZTP
								, _result[i].cBlock + "-" + _result[i].cBay + "-" + _result[i].cRow + "-" + _result[i].cTier
								, "<input type='text' class='hiden-input' value='"+ _result[i].cTLHQ +"'> " 
								+ (_result[i].cTLHQ == "1" ? "Đã thanh lý" : "Chưa thanh lý")
							]);
						}
						$('#bill-detail').DataTable( {
							data: rows,
							info: true,
							paging: false,
							ordering: false,
							searching: true,
							scrollY: '51vh',
							createdRow: function(row, data, dataIndex){
								if(formData.cntrNo != '') {
									if( data[1] == formData.cntrNo){
										$('td:eq(0)', row).addClass("ti-check");
										$(row).addClass('m-row-selected');
									}
								}else{
									$('td:eq(0)', row).addClass("ti-check");
									$(row).addClass('m-row-selected');
								}
							}
						} );
					}else{
						$('#bill-detail').DataTable().clear().draw();
						$('.toast').remove();
						toastr['info']('Số vận đơn ['+ $('#billno').val()+'] không tồn tại trong hệ thống!\nVui lòng kiểm tra lại!');
					}

					if(formData.cntrNo != '' && blNo != ''){
						$.confirm({
				            title: 'Cảnh báo!',
				            type: 'orange',
				            icon: 'fa fa-warning',
				            content: 'Container chưa được thanh lý HQ! <br/>Tiếp tục làm lệnh ?',
				            buttons: {
				                ok: {
				                    text: 'Tiếp tục',
				                    btnClass: 'btn-primary',
				                    keys: ['Enter'],
				                    action: function(){

										$('#cntrno').val('');
										$('#billno').val(blNo);

										if($.inArray(cntrNo, selected_cont) == "-1"){
											selected_cont.push(cntrNo);
										}

										apply_bill();
				                    }
				                },
				                cancel: {
				                    text: 'Hủy bỏ',
				                    btnClass: 'btn-default',
				                    keys: ['ESC']
				                }
				            }
				        });

					}else{
						$('#cntrno + span').trigger('click');
					}

					_ktype = "";
				},
				error: function(err){console.log(err);}
			});
		}
		function search_barge(){
			$("#search-barge").waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'search_barge'
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskImportPickup'));?>",
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
					}
					$('#search-barge').DataTable( {
						paging: false,
						searching: false,
						infor: false,
						scrollY: '25vh',
						data: rows
					} );
				},
				error: function(err){console.log(err);}
			});
		}

		function load_payer(){
			var tblPayer = $('#search-payer');
			tblPayer.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskImportPickup'));?>",
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

		function addCntrToEir(item){
			// item['EIRNo'] =  $('#ref-no').val();
//			item['RetLocation'] =  "";
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

			item['CJMode_CD'] = 'LAYN'; //*
			item['CJModeName'] = 'Lấy nguyên'; //*

			if(item.EIR_SEQ == 0){
				item['EIR_SEQ'] = 1;
			}
			_lstEir.push(item);

			var temp = $.extend( {}, item );
			if($('#chkMT-return').is(':checked')){
				temp['EIRNo'] = _eirforMTReturn;
				temp['ShipKey'] =  'STORE';
				temp['CntrClass'] =  '2';
				temp['ShipID'] =  'STORAGE';
				temp['ShipVoy'] =  '0000';
				temp['ShipYear'] =  '0000';

				temp['ImVoy'] = null;

				temp['ExpDate'] = $('#MT-exp-date').val();
				temp['Note'] = $('#MT-remark').val();
				temp['RetLocation'] =  $('#MT-retlocation').val();

				temp['SealNo'] =  '';
				temp['SealNo1'] =  '';
				temp['CJMode_CD'] =  'TRAR';
				temp['CJModeName'] =  'Trả rỗng';
				temp['Status'] =  'E';

				temp['CARGO_TYPE'] =  temp['ISO_SZTP'].indexOf('R') != "-1" ? "ER" : "MT";
				temp['CmdID'] = '';

				//udpate 2018-12-17
				temp["cBlock"] = temp["cBay"] = temp["cRow"] = temp["cTier"] = temp["BLNo"] = null;
				temp["CMDWeight"] = 0;
				temp["ImVoy"] = "CN";
				temp["ExVoy"] = "CX";

				_lstEir.push(temp);
			}
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

			if(_lstEir.length == 0 || $('.input-required').has_required()) {
				tblInv.dataTable().fnClearTable();
				return;
			}

			tblInv.waitingLoad();
			var formdata = {
				'action': 'view',
				'act': 'load_payment',
				'cusID': $('#taxcode').val(),
				'list': _lstEir
			};

			$.ajax({
				url: "<?=site_url(md5('Task') . '/' . md5('tskImportPickup'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.results && data.results.length > 0){
						var lst = data.results, stt = 1;
						for (i = 0; i < lst.length; i++) {
							var status = lst[i].Status == "F" ? "Hàng" : "Rỗng";
							var isLocal = lst[i].IsLocal == "F" ? "Ngoại" : (lst[i].IsLocal == "L" ? "Nội" : "");
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
					tblInv.DataTable( {
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

		function publishInv()
		{
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


		function saveData(invInfo)
		{
			var drDetail = getInvDraftDetail();
			var drTotal = {};
			$.each($('#INV_DRAFT_TOTAL').find('span'), function (idx, item) {
				drTotal[$(item).attr('id')] = $(item).text();
			});

			if(drDetail.length == 0) {
				$('.toast').remove();
				toastr['warning']('Chưa có thông tin thanh toán!');
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
				url: "<?=site_url(md5('Task') . '/' . md5('tskImportPickup'));?>",
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
					toastr['error']("Có lỗi xảy ra khi lưu dữ liệu! Vui lòng liên hệ KTV! ");
				}
			});
		}

		function getInvDraftDetail(){
			var rows = [];
			var tmprow = tblInv.find('tbody tr:not(.row-total)');
			$.each(tmprow, function() {
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
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
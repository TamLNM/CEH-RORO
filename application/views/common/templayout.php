<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/css//ebilling.css');?>" rel="stylesheet" />

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
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH RÚT HÀNG CONTAINER</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h5 class="text-primary">Thông tin lệnh</h5>
					</div>
				</div>
				<div class="row border-e bg-white pb-1">
					<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Số lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="ref-no" type="text" placeholder="Số lệnh" readonly style="background-color:#d3ddd433 !important">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương án</label>
									<div class="col-sm-8">
										<select id="opr" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
											<option value="LAYN" selected>Rút hàng</option>
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
							</div>
							<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
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
								<div class="row form-group">
									<div class="col-sm-6">
										<div class="row form-group">
											<label class="col-sm-4 col-form-label">PTGN</label>
											<div class="col-sm-8">
												<select id="dmt" class="selectpicker" data-style="btn-default btn-sm" data-width="100%">
													<option value="" selected>CONT - OTO</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
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
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mt-3">
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
								<label for="chkDVDK" class="checkbox checkbox-blue text-warning">
									<input type="checkbox" name="chkDVDK" id="chkDVDK" data-toggle="modal" data-target="#service-modal">
									<span class="input-span"></span>
									Dịch vụ đính kèm
								</label>
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
									<div class="col-sm-8">
										<div class="input-group">
											<select id="taxcode" class="selectpicker input-required" data-style="btn-default btn-sm" data-live-search="true" data-width="100%">
												<?php if(isset($payers) && count($payers) > 0){ foreach ($payers as $item){ ?>
													<option value="<?= $item['VAT_CD'] ?>"><?= $item['CusID'] ?></option>
												<?php }} ?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i>-<span id="payer-name"> Công Ty CP Vận Tải Và Xếp Dỡ Hải An</span>&emsp;
								<i class="fa fa-home" style="font-size: 15px!important;"></i>-<span id="payer-addr"> 220 Tăng Bạt Hổ, P.12, Q. Tân Bình </span>&emsp;
								<i class="fa fa-tags" style="font-size: 15px!important;"></i>-<span id="payment-type" data-value="C"> Chuyển Khoản</span>
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
							<button class="btn btn-warning btn-sm" title="Thông tin thanh toán" data-toggle="modal" data-target="#payment-modal">
								<i class="fa fa-print"></i>
								Thanh toán
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="row grid-toggle" style="padding: 10px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="tbl-conts" class="table table-striped display table-bordered nowrap" cellspacing="0">
						<thead>
						<tr>
							<td>STT</td>
							<td>Số cont</td>
							<td>Số vận đơn</td>
							<td>Hướng</td>
							<td>Hãng khai thác</td>
							<td>Kích cỡ nội bộ</td>
							<td>Kích cỡ ISO</td>
							<td>Hàng/Rỗng</td>
							<td>Số chì</td>
							<td>Nội/ngoại</td>
							<td>Trọng lượng</td>
							<td>Loại hàng</td>
							<td>Nhiệt độ</td>
							<td>Mã nguy hiểm</td>
							<td>Ghi chú</td>
							<td>TLHQ</td>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive grid-hidden">
					<table id="tbl-inv" class="table table-striped display table-bordered nowrap" cellspacing="0">
						<thead>
						<tr>
							<td>STT</td>
							<td>Số phiếu tính cước</td>
							<td>Số lệnh</td>
							<td>Mã biểu cước</td>
							<td>Tên biểu cước</td>
							<td>ĐVT</td>
							<td>Loại công việc</td>
							<td>PTGN</td>
							<td>Loại hàng</td>
							<td>Kích cỡ ISO</td>
							<td>Hàng/rỗng </td>
							<td>Nội/ngoại</td>
							<td>Số lượng</td>
							<td>Đơn giá</td>
							<td>CK (%)</td>
							<td>Đơn giá CK</td>
							<td>Đơn giá sau CK</td>
							<td>Thành tiền</td>
							<td>VAT (%)</td>
							<td>Tiền VAT</td>
							<td>Tổng tiền</td>
							<td>Loại tiền</td>
							<td>IX_CD</td>
							<td>CntrJobType</td>
							<td>VAT_CHK</td>
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
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
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
<!--bill modal-->
<div class="modal fade" id="bill-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
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
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-bill" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Chuyển tính tiền</button>
					<button class="btn btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!--additional service modal-->
<div class="modal fade" id="service-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="groups-modalLabel">Chọn dịch vụ đính kèm</h5>
			</div>
			<div class="modal-body pt-0">
				<div class="table-responsive">
					<table id="search-service" class="table table-striped display nowrap table-popup single-row-select" cellspacing="0" style="width: 99.8%">
						<thead>
						<tr>
							<th style="max-width: 15px">STT</th>
							<th><input type="checkbox" name=""></th>
							<th>Số lệnh</th>
							<th>Mã phương án</th>
							<th>Tên phương án</th>
							<th>Số lượng cont</th>
							<th>Thời gian</th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td>0</td>
								<td class="m-select"><input type="checkbox" name=""></td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
							<tr>
								<td>0</td>
								<td class="m-select"><input type="checkbox" name=""></td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
							<tr>
								<td>0</td>
								<td class="m-select"><input type="checkbox" name=""></td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
							<tr>
								<td>0</td>
								<td class="m-select"><input type="checkbox" name=""></td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
							<tr>
								<td>0</td>
								<td class="m-select"><input type="checkbox" name=""></td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
								<td>sample</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="save-service" class="btn btn-success" data-dismiss="modal">Lưu</button>
				<button type="button" id="cancel-service" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
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
		var _colsPayment = ["STT", "DRAFT_INV_NO", "REF_NO", "TRF_CODE", "TRF_DESC", "INV_UNIT", "JobMode", "DMethod_CD", "CARGO_TYPE", "ISO_SZTP"
			, "FE", "IsLocal", "QTY", "standard_rate", "DIS_RATE", "extra_rate", "UNIT_RATE", "AMOUNT", "VAT_RATE", "VAT", "TAMOUNT", "CURRENCYID"
			, "IX_CD", "CntrJobType", "VAT_CHK"];
		var _result = [], _lstEir = [];
		var selected_cont = [];

		var tempService;

		$('#search-barge').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '25vh'
		});

		$('#search-service').DataTable({
			paging: false,
			searching: false,
			infor: false,
			scrollY: '50vh'
		});

		$('#tbl-conts').DataTable({
			info: false,
			paging: false,
			searching: false,
			scrollY: '30vh'
		});
		$('#tbl-inv').DataTable({
			info: false,
			paging: false,
			searching: false,
			scrollY: '30vh'
		});

		$('#bill-detail').DataTable({
			info: false,
			paging: false,
			ordering: false,
			searching: false,
			scrollY: '30vh'
		});

		//---------check additional service checkbox event------------
		$('#chkDVDK').on('change', function(){
			tempService = $('#service-modal tbody').html();
			if($('#search-service').find('.m-row-selected').length > 0){
				$(this).prop('checked', 'true');
			}else{
				$(this).prop('checked', false);
			}
		});

		//---------multy row select function - additional service datatable---------
		$('#search-service tbody').on('click', 'tr', function(){
			if ($(this).hasClass('m-row-selected')) {
				$(this).removeClass('m-row-selected');
				$('.m-select input',this).prop('checked', false);
			}else{
				$(this).addClass('m-row-selected');
				$('.m-select input',this).prop('checked', 'true');
			}
			if($('#search-service').find('.m-row-selected').length > 0){
				$('#chkDVDK').prop('checked', 'true');
			}else{
				$('#chkDVDK').prop('checked', false);
			}
		});

		//--------cancel modal-------
		$('#cancel-service').click(function(){
			$('#service-modal tbody').html(tempService);
		});
		
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
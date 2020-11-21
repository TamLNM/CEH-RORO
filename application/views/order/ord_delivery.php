<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}
	.ibox .ibox-footer {
	    padding: 10px 25px 5px 25px;
	}
	.modal_input{
		border-bottom: dotted 1px;
		width: 70%;
	}
	.cash_input{
		border-bottom: dotted 1px; 
		width: 60%;
	}
	label{
		padding-right: 0px!important;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH GIAO HÀNG</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-1">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương án</label>
									<div class="col-sm-8">
										<!--
										<select id="JobModeID" class="selectpicker" placeholder="-- Chọn phương án --" data-style="btn-default btn-sm" data-width="100%">
											<?php if(count($jobModeList) > 0) { ?>
												<?php foreach($jobModeList as $item){  ?>								<?php if ($item['IsYard'] == 1){ ?>
														<option value="<?=$item['JobModeID'];?>">
															<?=$item['JobModeName'];?>		
														</option>
													<?php }?>
												<?php }?>
											<?php } ?>			
										</select>
										-->
										<input class="form-control form-control-sm input-required" id="JobModeID" type="text" placeholder="Phương án" readonly>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương thức</label>
									<div class="col-sm-8">
										<!--
										<select id="MethodID" class="selectpicker" placeholder="-- Chọn phương thức --" data-style="btn-default btn-sm" data-width="100%">
											<?php if(count($methodList) > 0) { ?>
												<?php foreach($methodList as $item){  ?>									
													<option value="<?=$item['MethodID'];?>">
														<?=$item['MethodName'];?>		
													</option>
											<?php } } ?>			
										</select>
									-->
										<input class="form-control form-control-sm input-required" id="MethodID" type="text" placeholder="Phương thức" readonly>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ngày lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" readonly="readonly" id="IssueDate" type="text" placeholder="Ngày lệnh">
										</div>
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Hạn lệnh *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" id="ExpDate" type="text" placeholder="Hạn lệnh">
											<span class="input-group-addon bg-white btn text-danger" id="del-ref-exp-date" title="Bỏ chọn ngày" style="padding: 0 .5rem"><i class="fa fa-times"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">D/O *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm input-required" id="do" type="text" placeholder="D/O">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label pr-0">Số vận đơn *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm input-required" id="BillOfLading" type="text" placeholder="Số vận đơn">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Số VIN</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm" id="VINNoFilter" type="text" placeholder="VIN No.">
											<span class="input-group-addon bg-white btn text-warning" id="VINNoButton" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
										</div>
									</div>
								</div>								
							</div>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group" style="border-bottom: 1px solid #eee">
									<div class="col-12 col-form-label">
										<label class="checkbox checkbox-blue">
											<input type="checkbox" name="chkServiceAttach" id="chkServiceAttach">
											<span class="input-span"></span>
											Đính kèm dịch vụ
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row pl-1" id="row-transfer-right">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-1" id="col-transfer">
								<div class="row form-group">
									<label class="col-sm-2 col-form-label" title="Chủ hàng">Chủ hàng *</label>
									<div class="col-sm-10">
										<input class="form-control form-control-sm input-required" id="ShipperName" type="text" placeholder="Chủ hàng">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-2 col-form-label pr-0">Đại diện</label>
									<div class="col-sm-10 input-group">
										<input class="form-control form-control-sm mr-1" id="cmnd" type="text" placeholder="Số CMND/ Số ĐT">
										<input class="form-control form-control-sm mr-1" id="personal-name" type="text" placeholder="Họ tên người đại diện">
										<input class="form-control form-control-sm" id="Email" type="text" placeholder="Địa chỉ Email *" style="width: 5rem">
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
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-0 pt-0">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xs-3 pb-0">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label" title="Đ.tượng thanh toán">ĐTTT *</label>
									<div class="col-sm-8 input-group">
										<input class="form-control form-control-sm input-required" id="CusID" placeholder="Đối tượng thanh toán" type="text">
										<span class="input-group-addon bg-white btn mobile-hiden text-warning" style="padding: 0 .5rem" title="Chọn đối tượng thanh toán" data-toggle="modal" data-target="#payer-modal" id="chooseCustomer">
											<i class="ti-search"></i>
										</span>
									</div>
									<input class="hiden-input" id="cusID" readonly="">
									<input class="hiden-input" id="PaymentTypeID" hidden>
									<input class="hiden-input" id="CusTypeID" hidden>
								</div>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-9 col-form-label mt-1">
								<i class="fa fa-id-card" style="font-size: 15px!important;"></i> - <span id="CusName"> [Tên đối tượng thanh toán]</span>&emsp;
								<i class="fa fa-home" style="font-size: 15px!important;"></i> -<span id="Address"> [Địa chỉ]</span>&emsp;
								<i class="fa fa-tags" style="font-size: 15px!important;"></i> - <span id="PaymentTypeName" data-value="C"> [Hình thức thanh toán]</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-0 pt-0">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group ml-auto">
									<button id="removeRow" class="btn btn-outline-danger btn-sm mr-1" title="Xóa những dòng đang chọn">
										<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
									</button>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group" style="display: inline-block; float: right; margin: 0 auto">
									<label class="radio radio-outline-success pr-4">
										<input name="view-opt" type="radio" id="chk-view-cont" value="bulkList">
										<span class="input-span"></span>
										Danh sách hàng rời
									</label>
									<label class="radio radio-outline-success pr-4">
										<input name="view-opt" type="radio" id="chk-view-cont" value="carList" checked="">
										<span class="input-span"></span>
										Danh sách xe
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
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-12 table-responsive" id="tabCar">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="rowguid">rowguid</th>
								<th col-name="VoyageKey">Voyage Key</th>
								<th col-name="ClassID">Nhập/ xuất tàu</th>	
								<th col-name="BillOfLadingORBookingNo">Số vận đơn/ Booking</th>
								<th col-name="BillOfLading">Số vận đơn</th>
								<th col-name="BookingNo">Số booking</th>
								<th col-name="VINNo">Số VIN</th>
								<th col-name="ordPos">Vị trí</th>
								<th col-name="DateIn" class="data-type-datetime">Ngày vào</th>
								<th col-name="CarTypeID">Loại xe</th>
								<th col-name="BrandID">Hãng xe</th>
								<th col-name="CarWeight">Trọng lượng</th>
								<th col-name="Remark">Ghi chú</th>		
								<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							</tr>
						</thead>							
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-12 table-responsive" id="tabBulk">
					<table id="tblOrdBulk" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="rowguid">rowguid</th>
								<th col-name="VoyageKey">Voyage Key</th>
								<th col-name="ClassID">Nhập/ xuất tàu</th>	
								<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>	
								<th col-name="BillOfLadingORBookingNo">Số vận đơn/ Booking</th>
								<th col-name="BillOfLading">Số vận đơn</th>
								<th col-name="BookingNo">Số booking</th>
								<th col-name="CargoWeight">Trọng lượng hàng</th>
								<th col-name="UnitID">Đơn vị tính</th>
								<th col-name="JobModeInID">Phương án vào</th>
								<th col-name="MethodInID">Phương thức vào</th>
								<th col-name="JobModeOutID">Phương án ra</th>
								<th col-name="MethodOutID">Phương thức ra</th>
								<th col-name="CommodityDescription">Mô tả</th>		
							</tr>
						</thead>							
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-12 table-responsive" id="tabTariff">
					<table id="tblTariff" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="rowguid">rowguid</th>
								<th col-name="">Số phiếu tính cước</th>
								<th col-name="EirNo">Số lệnh</th>	
								<th col-name="">Mã biểu cước</th>	
								<th col-name="">Tên biểu cước</th>
								<th col-name="">Đơn vị tính</th>
								<th col-name="">Loại công việc</th>
								<th col-name="">Phương thức</th>
								<th col-name="">Số lượng</th>
								<th col-name="">Đơn giá</th>
								<th col-name="">Giảm giá (%)</th>
								<th col-name="">Thành tiền</th>
								<th col-name="">Thuế</th>		
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
	
<!-- Customer modal-->
<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-2" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 5em;">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-2">DANH MỤC KHÁCH HÀNG</h5>
			</div>
			<div class="modal-body">
				<table id="tblCustomer" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT">STT</th>
							<th col-name="CusID">Mã khách hàng</th>
							<th col-name="CusName">Tên khách hàng</th>
							<th col-name="Address">Địa chỉ</th>
							<th col-name="CusTypeID"></th>
							<th col-name="CusTypeName">Loại khách</th>
							<th col-name="PaymentTypeID"></th>
							<th col-name="PaymentTypeID">Loại hình thanh toán</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($customerList) > 0) {$i = 1; ?>
						<?php foreach($customerList as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['CusID'];?></td>
								<td><?=$item['CusName'];?></td>							
								<td><?=$item['Address'];?></td>							
								<td><?=$item['CusTypeID']?></td>				
								<td><?=$item['CusTypeName']?></td>				
								<td><?=$item['PaymentTypeID']?></td>				
								<td><?=$item['PaymentTypeName']?></td>				
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-customer" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Stock modal-->
<div class="modal fade" id="stock-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-3" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 3em;">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-3">DANH MỤC HÀNG BIẾN ĐỘNG</h5>
			</div>
			<div class="modal-body">
				<table id="tblStock" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT" class="editor-cancel">STT</th>
							<th col-name="rowguid">rowguid</th>
							<th col-name="BillOfLading">Số vận đơn</th>
							<th col-name="VINNo">Số VIN</th>							
							<th col-name="BookingNo">Số booking</th>
							<th col-name="VMStatus">Tình trạng xe</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>	
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-stock" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Stock bulk modal-->
<div class="modal fade" id="stock-bulk-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-3" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 3em;">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-3">DANH MỤC HÀNG RỜI</h5>
			</div>
			<div class="modal-body">
				<table id="tblStockBulk" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT" class="editor-cancel">STT</th>
							<th col-name="VoyageKey">VoyageKey</th>
							<th col-name="BillOfLading">Số vận đơn</th>
							<th col-name="CargoWeight">Trọng lượng hàng</th>
							<th col-name="UnitID">Đơn vị tính</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>	
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="CommodityDescription">Mô tả</th>
							<th col-name="JobModeInID">Phương án vào</th>
							<th col-name="MethodInID">Phương thức vào</th>
							<th col-name="JobModeOutID">Phương án ra</th>
							<th col-name="MethodOutID">Phương thức ra</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-stock-bulk" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Thanh toán -->
<div class="modal fade" id="bill-delivery" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 3%; margin-top: 5em;">
	<div class="modal-dialog" role="document" style="min-width: 1250px!important">
		<div class="modal-content" style="border-radius: 4px">
			<button type="button" class="close text-right" data-dismiss="modal" style="margin-top: 10px; margin-right: 10px;">×</button>
			<div class="modal-body px-5">
				<div class="row">
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">THÔNG TIN THANH TOÁN</h5>
						</div>
						<div class="row form-group">
							<label class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-form-label" title="Mã KH/ MST">Mã KH/ MST</label>
							<span class="col-form-label modal_input" id="CusID_Bill"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tên</label>
							<span class="col-form-label modal_input" id="CusName_Bill"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Địa chỉ</label>
							<span class="col-form-label modal_input" id="Address_Bill"></span>
						</div>
						
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Thanh toán</label>
							<div class="col-sm-9">
								<div class="row">
									<a class="col-form-label pr-5" style="pointer-events: none;">
										<i class="fa fa-square" id="p-money"></i> THU NGAY
									</a>
									<a class="col-form-label" style="pointer-events: none;">
										<i class="fa fa-square" id="p-credit"></i> THU SAU
									</a>	
								</div>
							</div>
						</div>

						<div class="row form-group mt-3">
							<div class="col-9 ml-sm-auto">
								<div class="row input-group">
									<label class="col-form-label radio radio-outline-blue text-blue mr-4 mx-auto">
										<input name="publish-opt" type="radio" value="dft">
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span> PHIẾU TẠM THU
									</label>
									<label class="col-form-label radio radio-outline-danger text-danger mr-4 mx-auto">
										<input name="publish-opt" value="m-inv" type="radio">
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
										HÓA ĐƠN GIẤY
									</label>
									<label class="col-form-label radio radio-outline-warning text-warning mx-auto">
										<input name="publish-opt" value="e-inv" type="radio" checked>
										<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>
										HÓA ĐƠN ĐIỆN TỬ
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4" id="INV_DRAFT_TOTAL">
						<div class="form-group pb-1">
							<h5 class="text-primary" style="border-bottom: 1px solid #eee">Tổng tiền thanh toán</h5>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Thành tiền</label>
							<span class="col-form-label text-right font-bold text-success cash_input" id="AMOUNT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tiền thuế</label>
							<span class="col-form-label text-right font-bold text-blue cash_input" id="VAT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tổng tiền</label>
							<span class="col-form-label text-right font-bold text-danger cash_input" id="TAMOUNT"></span>
						</div>
						<div class="row form-group hiden-input">
							<label class="col-sm-3 col-form-label">Giảm trừ</label>
							<span class="col-form-label text-right font-bold text-blue" id="DIS_AMT"></span>
						</div>

						<div class="row form-group mt-3" id="payFormIDDiv">
							<label class="col-form-label radio radio-outline-secondary mr-5 ml-5">
								<input name="PayFormID" type="radio" value="M" checked>
								<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>TIỀN MẶT
							</label>

							<label class="col-form-label radio radio-outline-secondary mr-5">
								<input name="PayFormID" type="radio" value="C">
								<span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>CHUYỂN KHOẢN
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div id="dv-cash" style="margin: 0 auto">
					<button class="btn btn-rounded btn-gradient-purple" id="pay-atm">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ ATM</span>
					</button>
					<button class="btn btn-rounded btn-rounded btn-gradient-lime" id="pay-master-visa">
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

<script type="text/javascript">
	$(document).ready(function () {
		var _columns = ["STT", "rowguid", "VoyageKey", "ClassID", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "VINNo", "ordPos", "DateIn", "CarTypeID", "BrandID", "CarWeight", "Remark", "IsLocalForeign"],
			_customerColumns 	= ["STT", "CusID", "CusName", "Address","CusTypeID", "CusTypeName", "PaymentTypeID", "PaymentTypeName"],
			_stockColumns 		= ["STT", "rowguid", "BillOfLading", "VINNo", "BookingNo", "VMStatus", "IsLocalForeign", "TransitID"],
			_ordBulkColumns 		= ["STT", "rowguid", "VoyageKey", "ClassID", "IsLocalForeign", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "CargoWeight", "UnitID", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "CommodityDescription"],
			_stockBulkColumns   = ["STT", "VoyageKey", "BillOfLading", "CargoWeight", "UnitID", "ClassID", "IsLocalForeign", "CommodityDescription", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID"],
			jobModeList 		= {},
			methodList 			= {},
			customerList		= {},
			stockList			= {},
			parentMenuList 		= {},
			VINExistList		= {},
			tbl 	 			= $("#contenttable"),
			tblCustomer			= $("#tblCustomer"),
			tblStock			= $("#tblStock"),
			tblOrdBulk	 		= $("#tblOrdBulk"),
			tblStockBulk 		= $("#tblStockBulk"),
			stockModal 			= $("#stock-modal"),
			stockBulkModal 			= $("#stock-bulk-modal"),
			customerModal 		= $("#customer-modal");

		/* Load data for job mode list */
		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		/* Load data for method list */
		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?>

		/* Load data for Customer list */
		<?php if(isset($customerList) && count($customerList) >= 0){?>
			customerList = <?= json_encode($customerList);?>;
		<?php } ?>	

		/* Load data for Stock list */
		<?php if(isset($stockList) && count($stockList) >= 0){?>
			stockList = <?= json_encode($stockList);?>;
		<?php } ?>

		/* Load VIN data in Eir Table */
		<?php if(isset($VINExistList) && count($VINExistList) >= 0){?>
			VINExistList = <?= json_encode($VINExistList);?>;
		<?php } ?>	

		/* Load data for Parent Menu list */
		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Order'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		$("#JobModeID").val('LAYN');
		for (i = 0; i < methodList.length; i++){
			if (methodList[i]['JobModeID'] == 'LAYN'){
				$('#MethodID').val(methodList[i]['MethodID']);	
				i = methodList.length;
			}
		}

		$("#ExpDate").datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true,
			onSelect: function () {
				/* Do nothing */
			}	
		});

		// Set date for Ngày lệnh, Ngày hạn lệnh
		var d = new Date();
		$("#IssueDate").val(returnDateTimeFormatString(d));
		$("#ExpDate").val($("#IssueDate").val().substring(0, 10) + " 23:59:59");

		$("#del-ref-exp-date").on('click', function(){
			$("#ExpDate").val('');
		});

		/* Initial contenttable */
		tbl.newDataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.getIndexs(["STT", "Bay", "Row", "Tier"])},		
				{ className: "text-center", targets: _columns.getIndexs(["ClassID", "IsLocalForeign", "BillOfLadingORBookingNo", "VINNo", "ordPos", "DateIn", "CarTypeID", "BrandID", "CarWeight", "Remark"]) },
				{ className: "hiden-input", targets: _columns.getIndexs(["rowguid", "VoyageKey", "BillOfLading", "BookingNo"])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            searching: false,
            paging: false,
            info: false,
            rowReorder: false,
            arrayColumns: _columns,            
		});

		/* Initial customer table */
		var dataTbl2 = tblCustomer.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _customerColumns.indexOf('STT')},		
				{ className: "text-center", targets: _customerColumns.getIndexs(["CusID", "CusName", "Address", "CusTypeName", "PaymentTypeName"])},
				{ className: "hiden-input", targets: _customerColumns.getIndexs(["CusTypeID", "PaymentTypeID"])},
			],
			order: [[ _customerColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select:{
            	style: 'single',
            	info: false,
            },
            rowReorder: false,
            arrayColumns: _customerColumns,
		});

		customerModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		/* Initial stock table */
		tblStock.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _stockColumns.getIndexs(["STT"])},		
				{ className: "text-center", targets: _stockColumns.getIndexs(["BillOfLading", "VINNo", "BookingNo", "VMStatus", "IsLocalForeign", "TransitID"]) },
				{ className: "hiden-input", targets: _stockColumns.getIndexs(["rowguid"])},
			],
			order: [[ _stockColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _stockColumns
		});

		stockModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		/* Initial ORD bulk table */
		tblOrdBulk.newDataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _ordBulkColumns.getIndexs(["STT"])},		
				{ className: "text-center", targets: _ordBulkColumns.getIndexs([ "ClassID", "BillOfLadingORBookingNo", "CargoWeight", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "CommodityDescription", "UnitID", "IsLocalForeign"]) },
				{ className: "hiden-input", targets: _ordBulkColumns.getIndexs(["rowguid", "VoyageKey", "BillOfLading", "BookingNo"])},
			],
			order: [[ _ordBulkColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            searching: false,
            paging: false,
            info: false,
            rowReorder: false,
            arrayColumns: _ordBulkColumns,            
		});

		/* Initial Stock bulk table */
		tblStockBulk.newDataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _stockBulkColumns.getIndexs(["STT"])},		
				{ className: "text-center", targets: _stockBulkColumns.getIndexs(["BillOfLading", "CargoWeight", "ClassID", "IsLocalForeign", "CommodityDescription", "UnitName", "JobModeInID", "MethodInID", "JobModeOutID", "MethodOutID", "UnitID"]) },
				{ className: "hiden-input", targets: _stockBulkColumns.getIndexs(["rowguid", "VoyageKey"])},
			],
			order: [[ _stockBulkColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            searching: false,
            paging: false,
            info: false,
            rowReorder: false,
            arrayColumns: _stockBulkColumns,            
		});

		stockBulkModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		/* Choose ĐTTT (customers) event */
		$("#chooseCustomer").on('click', function(){
			customerModal.modal('show');
		});

		$("#apply-customer").on("click", function(){
			var customerData 	= tblCustomer.getSelectedRows().data().toArray()[0],
				cusID 			= customerData[_customerColumns.indexOf('CusID')],
				cusName			= customerData[_customerColumns.indexOf('CusName')],
				cusTypeID		= customerData[_customerColumns.indexOf('CusTypeID')],
				address			= customerData[_customerColumns.indexOf('Address')],
				paymentTypeID  	= customerData[_customerColumns.indexOf('PaymentTypeID')],
				paymentTypeName	= customerData[_customerColumns.indexOf('PaymentTypeName')];
			
			$("#CusID").val(cusID);
			$("#CusName").text(cusName);
			$("#Address").text(address == '' ? '- Không có địa chỉ --' : ' ' + address);
			$("#PaymentTypeID").val(paymentTypeID);	
			$("#PaymentTypeName").text(paymentTypeName);
			$("#CusTypeID").val(cusTypeID);	
		});

		tblCustomer.find("tbody tr").on("dblclick", function(){
			var	cusID 			= $(this).find("td:eq("+_customerColumns.indexOf("CusID")+")").text(),
				cusName 	 	= $(this).find("td:eq("+_customerColumns.indexOf("CusName")+")").text(),
				cusTypeID 	 	= $(this).find("td:eq("+_customerColumns.indexOf("CusTypeID")+")").text(),
				address 	 	= $(this).find("td:eq("+_customerColumns.indexOf("Address")+")").text(),
				paymentTypeID  	= $(this).find("td:eq("+_customerColumns.indexOf("PaymentTypeID")+")").text(),
				paymentTypeName	= $(this).find("td:eq("+_customerColumns.indexOf("PaymentTypeName")+")").text();

			$("#CusID").val(cusID);
			$("#CusName").text(cusName);
			$("#Address").text(address == '' ? '- Không có địa chỉ --' : ' ' + address);
			$("#PaymentTypeID").val(paymentTypeID);	
			$("#PaymentTypeName").text(paymentTypeName);	
			$("#CusTypeID").val(cusTypeID);
			
			customerModal.modal("hide");
		});

		// Get current Date-Time String
		function returnDateTimeFormatString(d){
			year 	= d.getFullYear();
			month 	= d.getMonth() + 1;
			day 	= d.getDate();
			hour 	= d.getHours(),
			min  	= d.getMinutes(),
			sec  	= d.getSeconds(),
			fillMonth = '',
			fillDay	  = '',
			fillHour  = '',
			fillMin   = '',
			fillSec   = '';
			
			if (month < 10)
				fillMonth = '0';
			if (day < 10)
				fillDay = '0';
			if (hour < 10)
				fillHour = '0';
			if (min < 10)
				fillMin = '0';
			if (sec < 10)
				fillSec = '0';

			return (fillDay + day + '/' + fillMonth + month + '/' + year + ' ' + fillHour + hour + ':' + fillMin + min + ':' + fillSec + sec);
		}

		$("#tabCar").hide();
		$("input[type=radio][name=view-opt]").on('change', function(){
			var optChoose = this.value;

			$("#tabCar").hide();
			$("#tabBulk").hide();
			$('#tabTariff').hide();

			if (optChoose == 'carList'){
				$("#tabCar").show();
				return;
			}

			if (optChoose == 'bulkList'){
				$("#tabBulk").show();
				return;
			}

			if (optChoose == 'inv'){
				$("#tabTariff").show();
				return;
			}

		});

		$("#show-payment-modal").on('click', function(){
			if (!($("#CusID").val())){
				toastr['error']("Vui lòng chọn Đối tượng thanh toán (ĐTTT)!");
				return;
			}

			if (!($("#Email").val())){
				toastr['error']("Vui lòng nhập Email!");
				return;
			}

			if (!($("#ShipperName").val())){
				toastr['error']("Vui lòng nhập thông tin Chủ hàng!");
				return;
			}

			var CusID 			= $("#CusID").val(),
				CusName 		= $("#CusName").text(),
				Address 		= $("#Address").text(),
				PaymentTypeID 	= $("#PaymentTypeID").val(),
				PaymentTypeName = $("#PaymentTypeName").text();

			$("#CusID_Bill").text(CusID);
			$("#CusName_Bill").text(CusName);
			$("#Address_Bill").text(Address == "- Không có địa chỉ --" ? '' : Address);

			if (PaymentTypeName != "THU SAU"){
				$("#p-money").removeClass();
				$("#p-money").addClass('fa fa-check-square');
				$("#p-credit").removeClass();
				$("#p-credit").addClass('fa fa-square');
			}
			else{
				$("#p-money").removeClass();
				$("#p-money").addClass('fa fa-square');
				$("#p-credit").removeClass();
				$("#p-credit").addClass('fa fa-check-square');
			}

			var optChoose = $("input[type=radio][name=view-opt]:checked").val();

			if (optChoose == "carList"){
				var formData = {
					'action': 'view',
					'child_action': 'load_pay_form',
					'PaymentTypeID': PaymentTypeID,
				}

				$.ajax({
					url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						if (data.list.length > 0){

							$("#payFormIDDiv").append(
								'<label class="col-form-label radio radio-outline-secondary mr-5 ml-5"><input name="PayFormID" type="radio" value="' + data.list[0]['PayFormID'] + '" checked><span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>' + data.list[0]['PayFormName'] + '</label>'
							)

							for (i = 1; i < data.list.length; i++){
								$("#payFormIDDiv").append(
									'<label class="col-form-label radio radio-outline-secondary mr-5"><input name="PayFormID" type="radio" value="' + data.list[i]['PayFormID'] + '"><span class="input-span" style="margin-top: calc(.5rem - 1px * 2);"></span>' + data.list[i]['PayFormName'] + '</label>'
								)
							}
						}	
					},
					error: function(err){
						console.log(err);
					}
				});

				if ($("#PaymentTypeID").val() == 'TNGAY'){
					$("#bill-delivery").modal('show');
				}
				else{
					$("#save-credit").trigger('click');
				}
			}
			else if (optChoose == "bulkList"){
				$("#save-credit").trigger('click');
			}
		});

		$("#BillOfLading").on('keydown', function(event){
			if (event.which == 13){
				var optChoose = $("input[type=radio][name=view-opt]:checked").val(),
					BillOfLading = $("#BillOfLading").val();

				if (BillOfLading == ''){
					toastr['error']("Vui lòng nhập giá trị Số vận đơn cần tìm!");
					return;
				}

				if (optChoose == "carList"){

					$("#VINNoFilter").val('');	

					/* Load data for contenttable*/
					formData = {
						'action': 'view',
						'BillOfLading': BillOfLading,
					};

					$.ajax({
						url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
						dataType: 'json',
						data: formData,
						type: 'POST',
						success: function (data) {
							var rows = [];
							if (data.list.length == 0){
								toastr['warning']("Không tìm thấy dữ liệu tương ứng với số vận đơn đã nhập!");
							}
							else {
								var index   = 1;
								for (i = 0; i < data.list.length; i++) {
									var rData 	= data.list[i], 
										r 		= [];
									if (rData['VMStatus'] == "S" && (!(rData['PinCode']) || (!(rData['EirNo'])))){
										$.each(_stockColumns, function(idx, colname){
											var val = "";
											switch(colname){
												case "STT": 	
													val = index++; 
													break;
												case "IsLocalForeign":
													if (rData[colname] == 1)
														val='<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội";
													else
														val='<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại";
													break;
												/*
												case "CusTypeID":
													val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CusTypeName'];
													break; 
												*/
												case "VMStatus":
													if (rData[colname] == 'B')
														val='<input class="hiden-input" value="B">' + "Trên tàu";
													else if (rData[colname] == 'I')
														val='<input class="hiden-input" value="I">' + "Đang vào bãi";
													else if (rData[colname] == 'S')
														val='<input class="hiden-input" value="S">' + "Trên bãi";
													else if (rData[colname] == 'O')
														val='<input class="hiden-input" value="O">' + "Đang ra bãi";
													else if (rData[colname] == 'D')
														val='<input class="hiden-input" value="D">' + "Đã ra bãi";
													break;
												/*
												case "ClassID":
													if (rData[colname] == 1)
														val='<input class="hiden-input" value="1">' + "Nhập";
													else
														val='<input class="hiden-input" value="2">' + "Xuất";
													break;
												*/
												case "TransitID":
													if (!rData[colname]){
														val = '';
													}
													else{
														val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'];
													}
													break;
												default:
													if (!rData[colname]){
														val = '';
													}
													else{
														val = rData[colname];
													}								
													break;
											}
											r.push(val);
										});
										rows.push(r);
									}
								}
								tblStock.dataTable().fnClearTable();
						    	if(rows.length > 0){
									tblStock.dataTable().fnAddData(rows);
									stockModal.modal('show');
						    	}
						    	else{
						    		toastr['info']("Tất cả dữ liệu với số vận đơn " + $("#BillOfLading").val() + " không đủ điều kiện làm lệnh");
						    	}
							}
						},
						error: function(err){
							console.log(err);
						}
					});
					return;
				}

				if (optChoose == "bulkList"){
					/* Load data for tblORDBulk */
					var formData = {
						'action': 'view',
						'child_action': 'loadStockBulkList',
						'BillOfLading': BillOfLading,
					};

					$.ajax({
						url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
						dataType: 'json',
						data: formData,
						type: 'POST',
						success: function (data) {
							var rows = [];
							if (data.list.length == 0){
								toastr['warning']("Không tìm thấy dữ liệu tương ứng với số vận đơn đã nhập!");
							}
							else {
								for (i = 0; i < data.list.length; i++) {
									var rData = data.list[i], r = [];
									if (rData['VMStatus'] == "S" && (!(rData['PinCode']) || (!(rData['EirNo'])))){
										$.each(_stockBulkColumns, function(idx, colname){
											var val = "";
											switch(colname){
												case "STT": 	
													val = i+1; 
													break;
												case "IsLocalForeign":
													if (rData[colname] == 1)
														val = '<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội";
													else
														val = '<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại";
													break;
												case "ClassID":
													val = '<input class="hiden-input" id="IsLocalForeign" value="' + rData[colname] + '">' + rData['ClassName'];
													break;					
												case "JobModeInID":
													val = '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeInName'];
													break;
												case "MethodInID":
													val = '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodInName'];
													break;	
												case "JobModeOutID":
													if (rData[colname]){
														val = '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeOutName'];
													}
													else{
														val = '';
													}
													break;		
												case "MethodOutID":
													if (rData[colname]){
														val = '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodOutName'];
													}
													else{
														val = '';
													}	
													break;					
												case "UnitID":
													val = '<input class="hiden-input" value="' + rData[colname] + '">' + rData['UnitName'];
													break;
												case "CargoWeight":
													val = (data.CargoWeight != -1) ? data.CargoWeight : 0;
													break; 
												default:
													if (!rData[colname]){
														val = '';
													}
													else{
														val = rData[colname];
													}								
													break;
											}
											r.push(val);
										});
										rows.push(r);
									}
								}
								tblStockBulk.dataTable().fnClearTable();
						    	if(rows.length > 0){
									tblStockBulk.dataTable().fnAddData(rows);
									stockBulkModal.modal('show');
						    	}
						    	else{
						    		toastr['info']("Tất cả dữ liệu với số vận đơn " + $("#BillOfLading").val() + " không đủ điều kiện làm lệnh");
						    	}							
							}
						},
						error: function(err){
							console.log(err);
						}
					});
					return;
				}
			}
		});

		$(document).on("dblclick", "#tblStock tbody tr",  function(){
			tbl.waitingLoad();

			var applyBtn 	= $("#apply-stock"),
				rIdx 		= applyBtn.val().split(".")[0],
				cIdx 		= applyBtn.val().split(".")[1],
				rows 		= [],
				rowguid     = $(this).find("td:eq("+_stockColumns.indexOf("rowguid")+")").text(),
				BillOfLading = $(this).find("td:eq("+_stockColumns.indexOf("BillOfLading")+")").text(),
				BookingNo 	= $(this).find("td:eq("+_stockColumns.indexOf("BookingNo")+")").text(),
				VINNo       = $(this).find("td:eq("+_stockColumns.indexOf("VINNo")+")").text();

			for (i = 0; i < stockList.length; i++){
				var check = false;

				if (stockList[i]['rowguid'] == rowguid){
					check = true;
				}
				
				if (check){
					var rData 	= stockList[i], 
						index 	= 1;
					if ((rData['VMStatus'] == "S") && (!(rData['PinCode'])) || (!(rData['EirNo']))){
						var r = [];
						$.each(_columns, function(idx, colname){
							var val = "";
							switch(colname){
								case "STT": 	
									val = index++; 
									break;
								case "BillOfLadingORBookingNo":
									if (rData['BillOfLading']){
										val = rData['BillOfLading'];
									}
									else{
										val = rData['BookingNo'];
									}
									break;
								case "ordPos":
									if (rData['Block'] && rData['Bay'] && rData['Row'] && rData['Tier']){
										val = rData['Block'] + '-';
									
										if (parseInt(rData['Bay']) < 10){
											val += '0';
										}
										val += parseInt(rData['Bay']) + '-';

										if (parseInt(rData['Row']) < 10){
											val += '0';
										}
										val += parseInt(rData['Row']);

										if (rData['Tier'] != 1){
											val += ('-' + rData['Tier']);
										}
									}
									else{
										val = '';
									}
									break;
								case "IsLocalForeign":
									if (rData[colname] == 1){
										val='<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội";
									}
									else{
										val='<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại";
									}
									break;
								case "VMStatus":
									val='<input class="hiden-input" value="S">' + "Trên bãi";
									break;
								case "ClassID":
									val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ClassName'];
									break;
								case "BrandID":
									if (!rData[colname]){
										val = '';
									}
									else{
										val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['BrandName'];
									}
									break;
								case "CarTypeID":
									if (!rData[colname]){
										val = '';
									}
									else{
										val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CarTypeName'];
									}
									break
								default:
									if (!rData[colname]){
										val = '';
									}
									else{
										val = rData[colname];
									}						
									break;
							}
							r.push(val);
						});
						rows.push(r);
					}
				}
			}
			tbl.dataTable().fnClearTable();
				    	
			if(rows.length > 0){
				tbl.dataTable().fnAddData(rows);
			}
			
			stockModal.modal("hide");
		});

		$("#apply-stock").on('click', function(){
			tbl.waitingLoad();

			var stockData 	= tblStock.getSelectedRows().data().toArray();
			 	rows  		= [],
			 	index 		= 1;

			for (i = 0; i < stockData.length; i++){
				var rData 		= stockData[i],
					VINNo 		= rData[_stockColumns.indexOf('VINNo')],
					BillOfLading = rData[_stockColumns.indexOf('BillOfLading')];
					
				for (j = 0; j < stockList.length; j++){
					if (stockList[j]['VINNo'] == VINNo && stockList[j]['BillOfLading'] == BillOfLading){
						var rData = stockList[j], r = [];
						
						if ((rData['VMStatus'] == "S") && (!(rData['PinCode'])) || (!(rData['EirNo']))){
							$.each(_stockColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 	
									val = index++; 
									break;
								case "BillOfLadingORBookingNo":
									if (rData['BillOfLading']){
										val = rData['BillOfLading'];
									}
									else{
										val = rData['BookingNo'];
									}
									break;
								case "ordPos":
									if (rData['Block'] && rData['Bay'] && rData['Row'] && rData['Tier']){
										val = rData['Block'] + '-';
									
										if (parseInt(rData['Bay']) < 10){
											val += '0';
										}
										val += parseInt(rData['Bay']) + '-';

										if (parseInt(rData['Row']) < 10){
											val += '0';
										}
										val += parseInt(rData['Row']);

										if (rData['Tier'] != 1){
											val += ('-' + rData['Tier']);
										}
									}
									else{
										val = '';
									}
									break;
								case "IsLocalForeign":
									if (rData[colname] == 1){
										val='<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội";
									}
									else{
										val='<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại";
									}
									break;
								case "VMStatus":
									val='<input class="hiden-input" value="S">' + "Trên bãi";
									break;
								case "ClassID":
									val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ClassName'];
									break;
								case "BrandID":
									if (!rData[colname]){
										val = '';
									}
									else{
										val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['BrandName'];
									}
									break;
								case "CarTypeID":
									if (!rData[colname]){
										val = '';
									}
									else{
										val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CarTypeName'];
									}
									break
								default:
									if (!rData[colname]){
										val = '';
									}
									else{
										val = rData[colname];
									}						
									break;
								}
								r.push(val);
							});
							rows.push(r);
							j = stockList.length;
						}
					}
				}
			}

			tbl.dataTable().fnClearTable();
			if(rows.length > 0){
				tbl.dataTable().fnAddData(rows);
			}
		});

		$(document).on("dblclick", "#tblStockBulk tbody tr",  function(){
			tblOrdBulk.waitingLoad();

			var tblStockBulkData = tblStockBulk.getSelectedRows().data().toArray(),
				rows = [];

			for (i = 0; i < tblStockBulkData.length; i++){
				var rData = tblStockBulkData[i], r = [];
				
				r.push(i + 1);
				r.push('');
				r.push(rData[_stockBulkColumns.indexOf('VoyageKey')]);
				r.push(rData[_stockBulkColumns.indexOf('ClassID')]);

				if (rData[_stockBulkColumns.indexOf('IsLocalForeign')] == 1){
					r.push('<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội");
				}
				else{
					r.push('<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại");
				}

				if (rData[_stockBulkColumns.indexOf('BillOfLading')]){
					r.push(rData[_stockBulkColumns.indexOf('BillOfLading')]);
				}
				else{
					r.push(rData[_stockBulkColumns.indexOf('BookingNo')]);
				}

				r.push(rData[_stockBulkColumns.indexOf('BillOfLading')]);
				r.push('');
				r.push(rData[_stockBulkColumns.indexOf('CargoWeight')]);
				r.push(rData[_stockBulkColumns.indexOf('UnitID')]);
				r.push(rData[_stockBulkColumns.indexOf('JobModeInID')] ? rData[_stockBulkColumns.indexOf('JobModeInID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('MethodInID')] ? rData[_stockBulkColumns.indexOf('MethodInID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('JobModeOutID')] ? rData[_stockBulkColumns.indexOf('JobModeOutID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('MethodOutID')] ? rData[_stockBulkColumns.indexOf('MethodOutID')]: '');
				r.push(rData[_stockBulkColumns.indexOf('CommodityDescription')]);
				
				rows.push(r);
			}

			tblOrdBulk.dataTable().fnClearTable();
			if(rows.length > 0){
				tblOrdBulk.dataTable().fnAddData(rows);
			}

			stockBulkModal.modal('hide');
		});

		$("#apply-stock-bulk").on('click', function(){
			tblOrdBulk.waitingLoad();

			var tblStockBulkData = tblStockBulk.getSelectedRows().data().toArray(),
				rows = [];

			for (i = 0; i < tblStockBulkData.length; i++){
				var rData = tblStockBulkData[i], r = [];
				
				r.push(i + 1);
				r.push('');
				r.push(rData[_stockBulkColumns.indexOf('VoyageKey')]);
				r.push(rData[_stockBulkColumns.indexOf('ClassID')]);

				if (rData[_stockBulkColumns.indexOf('IsLocalForeign')] == 1){
					r.push('<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội");
				}
				else{
					r.push('<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại");
				}

				if (rData[_stockBulkColumns.indexOf('BillOfLading')]){
					r.push(rData[_stockBulkColumns.indexOf('BillOfLading')]);
				}
				else{
					r.push(rData[_stockBulkColumns.indexOf('BookingNo')]);
				}

				r.push(rData[_stockBulkColumns.indexOf('BillOfLading')]);
				r.push('');
				r.push(rData[_stockBulkColumns.indexOf('CargoWeight')]);
				r.push(rData[_stockBulkColumns.indexOf('UnitID')]);
				r.push(rData[_stockBulkColumns.indexOf('JobModeInID')] ? rData[_stockBulkColumns.indexOf('JobModeInID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('MethodInID')] ? rData[_stockBulkColumns.indexOf('MethodInID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('JobModeOutID')] ? rData[_stockBulkColumns.indexOf('JobModeOutID')] : '');
				r.push(rData[_stockBulkColumns.indexOf('MethodOutID')] ? rData[_stockBulkColumns.indexOf('MethodOutID')]: '');
				r.push(rData[_stockBulkColumns.indexOf('CommodityDescription')]);
				
				rows.push(r);
			}

			tblOrdBulk.dataTable().fnClearTable();
			if(rows.length > 0){
				tblOrdBulk.dataTable().fnAddData(rows);
			}
		});

		$("#VINNoFilter").on("keydown", function(event){
			if (event.which == 13){
				$("#VINNoButton").trigger('click');
			}
		});

		$("#VINNoButton").on('click', function(){
			tbl.waitingLoad();
			var VINNo = $('#VINNoFilter').val();

			formData = {
				'action': 'view',
				'VINNo': VINNo,
			};

			$.ajax({
				url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [], BillOfLading, index = 1;
					tbl.dataTable().fnClearTable();

					if (data.ordEirList.length > 0){
						toastr['error']('Số VIN: ' + formData.VINNo + ' đã được làm lệnh theo số lệnh: ' + data.ordEirList[0]['EirNo']);
					}
					else{
						if(data.list.length > 0) {
							var BillOfLading = data.list[0]['BillOfLading'];
							$("#BillOfLading").val(BillOfLading);

							for (i = 0; i < data.list.length; i++) {
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = index++; 
											break;
										case "SequenceVIN":
											val = rData['Sequence'];
											break;
										case "IsLocalForeign":
											if (rData[colname] == 1)
												val='<input class="hiden-input" id="IsLocalForeign" value="1">' + "Hàng nội";
											else
												val='<input class="hiden-input" id="IsLocalForeign" value="2">' + "Hàng ngoại";
											break;
										case "CusTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CusTypeName'];
											break; 
										case "DateIn":
										case "DateOut":
											val = getDateTime( rData[colname] ) ;
											break;
										case "VMStatus":
											if (rData[colname] == 'B')
												val='<input class="hiden-input" value="B">' + "Trên tàu";
											else if (rData[colname] == 'I')
												val='<input class="hiden-input" value="I">' + "Đang vào bãi";
											else if (rData[colname] == 'S')
												val='<input class="hiden-input" value="S">' + "Trên bãi";
											else if (rData[colname] == 'O')
												val='<input class="hiden-input" value="O">' + "Đang ra bãi";
											else if (rData[colname] == 'D')
												val='<input class="hiden-input" value="D">' + "Đã ra bãi";
											break;
										case "ClassID":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nhập";
											else
												val='<input class="hiden-input" value="2">' + "Xuất";
											break;
										case "IssueDate":
											val = $("#IssueDate").val();
											break; 
										case "ExpDate":
											val = $("#ExpDate").val();
											break;
										case "FinishDate":
											val = '';
											break;
										case "TransitID":
										if (rData[colname] == 'null'){
												val = '';
											}
											else{
												val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'];
											}
											break;
										default:
											if (!rData[colname]){
												val = '';
											}
											else{
												val = rData[colname];
											}			
											break;
									}
									r.push(val);
								});
								rows.push(r);
							}
					    	if(rows.length > 0){
								tbl.dataTable().fnAddData(rows);
					    	}
					    }
					    else{
					    	toastr['warning']("Không tìm thấy dữ liệu tương ứng với số vận đơn đã nhập!");
					    	return;
					    }
					}
					
				},
				error: function(err){
					console.log(err);
				}
			});
		});

		$("#removeRow").on('click', function(){});

		$("input[name='publish-opt']").on('change', function(){
			var temp = $("input[name='publish-opt']:checked").val();

			if (temp == 'dft'){
				$("#payFormIDDiv").hide();
				return;
			}

			if (temp == 'm-inv'){
				$("#payFormIDDiv").show();
				return;
			}

			if (temp == 'e-inv'){
				$("#payFormIDDiv").show();
				return;
			}
		});

		$("#pay-atm, #pay-master-visa").on('click', function(){
			$("#save-credit").trigger('click');
		});

		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		$("#save-credit").on('click', function(){
			var optChoose = $("input[type=radio][name=view-opt]:checked").val();

			if (optChoose == 'carList'){
				var tblData	= tbl.getDataByColumns(_columns),
					temp 	= $("input[name='publish-opt']:checked").val(),
					paymentTypeID = $("#PaymentTypeID").val(),
					formDataEir,
					payFormID = '',
					saveData = [];
				/*
				if (temp == 'dft'){
				}
				else if (temp == 'm-inv' || temp == 'e-inv'){
					payFormID = $("input[name='PayFormID']:checked").val();
				}
				*/

				if (paymentTypeID == 'TSAU'){
					payFormID = 'C';
				}
				else{
					payFormID = 'M';
				}		

				var formData = {
						'action': 'view',
						'child_action': 'getAutoCode',
						'pinCodeNumeric': 1,
						'digits': 6,
					};

				$.ajax({
		        	url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
		            dataType: 'json',
		            data: formData,
		            type: 'POST',
		            success: function (data) {
		                if(data.deny) {
		                    toastr["error"](data.deny);
		                    return;
		                }

		                /* Create auto Eir No */
		                eirNoList 	= data.eirNoList;
		                
		                var d 		= new Date(),
							eirNo 	= '',
							year 	= d.getFullYear(),
							month 	= d.getMonth() + 1,
							day 	= d.getDate(),
							defaultIndex = 1,
							maxIndex = 0,
							saveData = [],
							saveStockData = [];

						eirNo += ('R' + year.toString().substring(2,4));

						if (month < 10){
							eirNo += '0';
						}
						eirNo += month;

						if (day < 10){
							eirNo += '0';
						}
						eirNo += day;

						for (k = 0; k < eirNoList.length; k++){
							if (eirNoList[k]['EirNo']){
								if (checkInSameDate(eirNoList[k]['EirNo'], eirNo)){
									var eirNoIndex = eirNoList[k]['EirNo'];
									if (maxIndex < parseInt(eirNoIndex.toString().substring(7, eirNoIndex.length))){
										maxIndex  = parseInt(eirNoIndex.toString().substring(7, eirNoIndex.length));
									}
								}
							}		
						}

						maxIndex++;

						for (k = 0; k < 5 - maxIndex.toString().length; k++){
							eirNo += '0';
						}

						eirNo = eirNo + maxIndex;

						for (i = 0; i < tblData.length; i++){
							var r = {
								'VoyageKey' : tblData[i]['VoyageKey'],
								'ClassID'	: tblData[i]['ClassID'],
								'VINNo'		: tblData[i]['VINNo'],
								'BillOfLading'	: tblData[i]['BillOfLading'],
								'BookingNo'	: tblData[i]['BookingNo'],
								'SequenceVIN'	: '',
								'InvNo' 	: '',
								'EirNo' 	: eirNo,
								'PinCode' 	: 'R' + data.pinCodeList[0],
								'CusID' 	: $("#CusID").val(),
								'CusTypeID' : $("#CusTypeID").val(),
								'TransitID' : '',
								'IssueDate' : $("#IssueDate").val() ? getSQLDateTimeFormat($("#IssueDate").val()) 	: '',
								'ExpDate' 	: $("#ExpDate").val() 	? getSQLDateTimeFormat($("#ExpDate").val()) 	: '',
								'FinishDate': '',
								'CarWeight' : tblData[i]['CarWeight'],
								'CargoType' : 1,
								'KeyNo' 	: tblData[i]['KeyNo'],
								'Remark' 	: tblData[i]['Remark'],	
								'ShipperName': $("#ShipperName").val(),
								'Email' 	: $("#Email").val(),
							};
							saveData.push(r);

							var r = {
								'VoyageKey' : tblData[i]['VoyageKey'],
								'ClassID'	: tblData[i]['ClassID'],
								'VINNo'		: tblData[i]['VINNo'],
								'BillOfLading'	: tblData[i]['BillOfLading'],
								'BookingNo'	: tblData[i]['BookingNo'],
								'EirNo' 	: eirNo,
								'PinCode' 	: data.pinCodeList[0],
							}
							saveStockData.push(r);
						}

						var formDataEir = {
							'action': 'add',
							'PaymentTypeID': (paymentTypeID) ? paymentTypeID : '',
							'PayFormID': (payFormID) ? payFormID : '',
							'JobModeID': ($("#JobModeID").val()) ? $("#JobModeID").val() : '',
							'MethodID': ($("#MethodID").val())  ? $("#MethodID").val() : '',
							'data': saveData,
						}
						postSave(formDataEir);

						var formUpdateStock = {
							'action': 'edit',
							'child_action': 'updateStockData',
							'data': saveStockData,
						};
						
						postSave(formUpdateStock);
		            },
		            error: function(err){
		            	toastr["error"]("Error!");
		            	console.log(err);
		            }
		        });
		    }
		    else if (optChoose == 'bulkList'){
		    	var formData = {
						'action': 'view',
						'child_action': 'getAutoCode',
						'pinCodeNumeric': 1,
						'digits': 6,
					},
					payFormID;

				if ($("#PaymentTypeID").val() == 'TSAU'){
					payFormID = 'C';
				}
				else{
					payFormID = 'M';
				}	

				$.ajax({
		        	url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
		            dataType: 'json',
		            data: formData,
		            type: 'POST',
		            success: function (data) {
		                if(data.deny) {
		                    toastr["error"](data.deny);
		                    return;
		                }

		                /* Create auto Eir Bulk No */
		                eirBulkNoList 	= data.eirBulkNoList;

		                var d 		= new Date(),
							eirNo 	= '',
							year 	= d.getFullYear(),
							month 	= d.getMonth() + 1,
							day 	= d.getDate(),
							defaultIndex = 1,
							maxIndex = 0,
							saveData = [],
							saveStockData = [];

						eirNo += ('B' + year.toString().substring(2,4));

						if (month < 10){
							eirNo += '0';
						}
						eirNo += month;

						if (day < 10){
							eirNo += '0';
						}
						eirNo += day;

						for (k = 0; k < eirBulkNoList.length; k++){
							if (eirBulkNoList[k]['EirNo']){
								if (checkInSameDate(eirBulkNoList[k]['EirNo'], eirNo)){
									var eirNoIndex = eirBulkNoList[k]['EirNo'];
									if (maxIndex < parseInt(eirNoIndex.toString().substring(7, eirNoIndex.length))){
										maxIndex  = parseInt(eirNoIndex.toString().substring(7, eirNoIndex.length));
									}
								}
							}		
						}

						maxIndex++;

						for (k = 0; k < 5 - maxIndex.toString().length; k++){
							eirNo += '0';
						}

						eirNo = eirNo + maxIndex;

						var tblData = tblOrdBulk.getDataByColumns(_ordBulkColumns),
							ordBulkData = [];

				    	for (i = 0; i < tblData.length; i++){
				    		var objData = {
				    				'VoyageKey': tblData[i]['VoyageKey'],
				    				'ClassID': tblData[i]['ClassID'],
				    				'TransitID': tblData[i]['TransitID'],				    				
				    				'EirNo': eirNo,
				    				'PinCode': 'B' + data.pinCodeList[0],
				    				'IssueDate' : $("#IssueDate").val() ? getSQLDateTimeFormat($("#IssueDate").val()) 	: '',
									'ExpDate' 	: $("#ExpDate").val() 	? getSQLDateTimeFormat($("#ExpDate").val()) 	: '',
									'BillOfLading': tblData[i]['BillOfLading'],
									'CargoWeight': tblData[i]['CargoWeight'],
									'CargoType': 2,
									'UnitID': tblData[i]['UnitID'],
									'ShipperName': $("#ShipperName").val(),
									'CusID' 	: $("#CusID").val(),
									'CusTypeID' : $("#CusTypeID").val(),
									'Email': $("#Email").val(),
									'Remark': $("#remark").val(),
				    			};
				    		ordBulkData.push(objData);
				    	}

				    	var formData = {
								'action': 'add',
								'child_action': 'addORDBulkData',
								'JobModeID': ($("#JobModeID").val()) ? $("#JobModeID").val() : '',
								'MethodID': ($("#MethodID").val())  ? $("#MethodID").val() : '',
					    		'PaymentTypeID': $("#PaymentTypeID").val(),
								'PayFormID': payFormID,
								'data': ordBulkData,
							};
						postSave(formData);
				    },
		            error: function(err){
		            	toastr["error"]("Error!");
		            	console.log(err);
		            }
		        });
		    }
		});

		function postSave(formData){
			$.ajax({
                url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");                    
                    	
                    	/* Reload input data */
	                	var d = new Date();
						$("#IssueDate").val(returnDateTimeFormatString(d));
						$("#ExpDate").val($("#IssueDate").val().substring(0, 10) + " 23:59:59");

						$("#BillOfLading").val('');
						$("#BookingNo").val('');
						$("#ShipperName").val('');
						$("#cmnd").val('');
						$("#personal-name").val('');
						$("#Email").val('');
						$("#remark").val('');
						$("#CusID").val('');
						$("#CusName").html('[Tên đối tượng thanh toán]');
						$("#Address").html(' [Địa chỉ]');
						$("#PaymentTypeName").html(' [Hình thức thanh toán]');
						
						tbl.dataTable().fnClearTable();
						tblOrdBulk.dataTable().fnClearTable();
                    }

                    if(formData.action == 'edit'){
                    	toastr["success"]("Cập nhật dữ liệu Biến động bãi thành công!");

                    	if (formData.child_action == 'updateStockData'){
                    		/* Reload contenttable */
							var indexes = tbl.filterRowIndexes( _columns.indexOf( "BillOfLading" ), $("#BillOfLading").val());
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );

	                		/* Reload input data */
	                		var d = new Date();
							$("#IssueDate").val(returnDateTimeFormatString(d));
							$("#ExpDate").val($("#IssueDate").val().substring(0, 10) + " 23:59:59");

							$("#BillOfLading").val('');
							$("#BookingNo").val('');
							$("#ShipperName").val('');
							$("#cmnd").val('');
							$("#personal-name").val('');
							$("#Email").val('');
							$("#remark").val('');
							$("#CusID").val('');
							$("#CusName").html('[Tên đối tượng thanh toán]');
							$("#Address").html(' [Địa chỉ]');
							$("#PaymentTypeName").html(' [Hình thức thanh toán]');

							tbl.dataTable().fnClearTable();
							tblOrdBulk.dataTable().fnClearTable();
                    	}
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$("#JobModeID").on('change', function(){
			var JobModeID = $("#JobModeID").val();

			$('#MethodID').val('');
			for (i = 0; i < methodList.length; i++){
				if (methodList[i]['JobModeID'] == JobModeID){
					$('#MethodID').val(methodList[i]['MethodID']);	
					i = methodList.length;
				}
			}
		});

		function checkInSameDate(e1, e2){
			if (e1.toString().substring(0, 7) == e2.toString().substring(0, 7)){
				return true;
			}
			return false;
		}

		function getNewEirNo(){
			var formData = {
				'action': 'view',
				'child_action': 'getEirNoList',
			};

			$.ajax({
                url: "<?=site_url(md5('Order') . '/' . md5('ordDelivery'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                   	eirNoList = data.list;

                  	var d 		= new Date(),
						eirNo 	= '',
						year 	= d.getFullYear(),
						month 	= d.getMonth() + 1,
						day 	= d.getDate(),
						defaultIndex = 1,
						maxIndex = 0;

					eirNo += year.toString().substring(2,4);

					if (month < 10){
						eirNo += '0';
					}
					eirNo += month;

					if (day < 10){
						eirNo += '0';
					}
					eirNo += day;

					for (k = 0; k < eirNoList.length; k++){
						if (eirNoList[k]['EirNo']){
							if (checkInSameDate(eirNoList[k]['EirNo'], eirNo)){
								var eirNoIndex = eirNoList[k]['EirNo'];
								if (maxIndex < parseInt(eirNoIndex.toString().substring(6, eirNoIndex.length))){
									maxIndex  = parseInt(eirNoIndex.toString().substring(6, eirNoIndex.length));
								}
							}
						}
						
					}
					maxIndex++;

					for (k = 0; k < 5 - maxIndex.toString().length; k++){
						eirNo += '0';
					}
					eirNo += maxIndex;
					return eirNo; 	
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });			
		}

		

	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>						
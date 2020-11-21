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

	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-4 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-5 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-6 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-7 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">LỆNH HẠ HÀNG</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-1">
					<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-2 col-form-label">Tàu</label>
									<div class="col-sm-10 input-group">
										<input class="form-control form-control-sm input-required" id="VesselName" placeholder="Tên tàu" type="text" readonly>
										<span class="input-group-addon bg-white btn mobile-hiden text-success" style="padding: 0 .5rem" title="Chọn tàu" data-toggle="modal" data-target="#payer-modal" id="chooseVessel">
											<i class="la la-anchor"></i>
										</span>										
									</div>
								</div>
							</div>

							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<!--
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">CN - CX</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm input-required" id="InOutBoundVoyage" type="text" placeholder="Ch.nhập - Ch.xuất" readonly>
										
									</div>
								</div>
								-->
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương án</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm input-required" id="JobModeID" type="text" placeholder="Phương án" readonly>
										<input hidden id="VoyageKey">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Phương thức</label>
									<div class="col-sm-8">										
										<input class="form-control form-control-sm input-required" id="MethodID" type="text" placeholder="Phương thức" readonly>
									</div>
								</div>																	
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ngày lệnh</label>
									<div class="col-sm-8 input-group input-group-sm">
										<div class="input-group">
											<input class="form-control form-control-sm input-required" readonly="readonly" id="IssueDate" type="text" placeholder="Ngày lệnh">
										</div>
									</div>
								</div>			
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">Ghi chú</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm" id="remark" type="text" placeholder="Ghi chú">
									</div>
								</div>				
								<!--
								<div class="row form-group">
									<label class="col-sm-4 col-form-label">D/O *</label>
									<div class="col-sm-8 input-group input-group-sm">
										<input class="form-control form-control-sm input-required" id="do" type="text" placeholder="D/O">
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
								-->					
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
									<button id="addRow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm dòng mới">
										<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
									</button>

									<button id="removeRow" class="btn btn-outline-danger btn-sm mr-1" title="Xóa những dòng đang chọn">
										<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
									</button>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group" style="display: inline-block; float: right; margin: 0 auto">
									<label class="radio radio-outline-success pr-4">
										<input name="view-opt" type="radio" id="chk-view-cont" value="bulkList" checked="">
										<span class="input-span"></span>
										Danh sách hàng
									</label>
									<label class="radio radio-outline-success pr-4">
										<input name="view-opt" id="chk-view-cont" value="tariffList" type="radio">
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
				<div class="col-12 table-responsive" id="tabBulk">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="VoyageKey">Voyage Key</th>
								<th col-name="BillOfLadingORBookingNo">Số vận đơn/ booking</th>
								<th col-name="BillOfLading">Số vận đơn</th>								
								<th col-name="BookingNo">Số booking</th>
								<th col-name="ClassID">Nhập/ xuất tàu</th>	
								<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>	
								<th col-name="POL">Cảng xếp</th>							
								<th col-name="POD">Cảng dỡ</th>							
								<th col-name="FPOD">Cảng đích</th>
								<th col-name="TransitID">TransitID</th>	
								<!--<th col-name="CargoTypeID">Loại hàng</th>-->
								<th col-name="CargoWeight">Trọng lượng hàng</th>
								<th col-name="UnitID">Đơn vị tính</th>
								<th col-name="CntrNo">Số Cont</th>
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
								<th col-name="TRFCode">Mã biểu cước</th>	
								<th col-name="TRFCodeName">Tên biểu cước</th>
								<th col-name="TRFDesc">Diễn giải</th>
								<th col-name="JobModeID">Loại công việc</th>
								<th col-name="MethodID">Phương thức</th>
								<th col-name="UnitID">Đơn vị tính</th>
								<th col-name="CargoWeight">Trọng lượng hàng</th>
								<th col-name="Price">Đơn giá</th>
								<th col-name="Discount">Giảm giá (%)</th>
								<th col-name="Total">Thành tiền</th>
								<th col-name="VAT">Thuế</th>
								<th col-name="RateID"></th>
								<th col-name="ExchangeRate"></th>

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

<!-- Vessel modal-->
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 5%; padding-top: 2%">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-1">Danh mục tàu</h5>
				<button id="VesselSearch" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
									data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
								 	title="Nạp dữ liệu">
					<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
				</button>
			</div>
			<div class="modal-body" style="padding: 0px 15px 15px 15px">
				<div class="row mb-0 border-e border-top-0 pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="col-md-2 col-sm-4 col-xs-4 col-form-label">Tàu</label>
										<input id="VesselNameFilter" class="col-md-8 col-sm-10 col-xs-10 form-control form-control-sm" placeholder="Tên tàu" type="text">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Năm</label>
										<div class="col-md-8 col-sm-10 col-xs-10 input-group input-group-sm">
											<select id="YearFilter" data-width="100%" data-style="btn-default btn-sm"
													title="Năm"
													style="width: 80%; border-radius: 2px; border-color: rgba(0, 0, 0, .1);">
												<?php for ($i = 2016; $i < 2026; $i++){ ?>
													<option value="<?=$i?>">
														<?=$i?>		
													</option>
												<?php } ?>												
											</select>
										</div>										
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="radio radio-success ml-5 mt-1">
					                        <input type="radio" checked name="VesselFilter" class="css-checkbox" value="1" />
					                            <span class="input-span"></span>Đến cảng
					                    </label>								

										<label class="radio radio-success ml-3 mt-1 mr-3">
					                       <input type="radio" name="VesselFilter" class="css-checkbox" value="2" />
					                            <span class="input-span"></span>Rời cảng
					                    </label>   
									</div>
								</div>
							</div>
					</div>
				</div>
				<div class="row ibox-footer border-top-0 mt-3">
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
						<table id="tblVessel" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
							<thead>
								<tr style="width: 100%">
									<th col-name="STT">STT</th>
									<th col-name="VoyageKey"></th>
									<th col-name="VesselID">Mã tàu</th>
									<th col-name="VesselName">Tên tàu</th>
									<th col-name="InboundVoyage">Chuyến nhập</th>
									<th col-name="OutboundVoyage">Chuyến xuất</th>
									<th col-name="ETA">ETA</th>
									<th col-name="ETD">ETD</th>
									<th col-name="Status">Status</th>
									<th col-name="InLane">Chuyến nhập</th>
									<th col-name="OutLane">Chuyến xuất</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-vessel" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Customer modal-->
<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-2" aria-hidden="true" data-whatever="id" style="padding-left: 5%; padding-top: 2%">
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
							<span class="col-form-label text-center font-bold text-success cash_input" id="AMOUNT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tiền thuế</label>
							<span class="col-form-label text-center font-bold text-blue cash_input" id="VAT"></span>
						</div>
						<div class="row form-group">
							<label class="col-sm-3 col-form-label">Tổng tiền</label>
							<span class="col-form-label text-center font-bold text-danger cash_input" id="TAMOUNT"></span>
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
						<span class="btn-icon"><i class="fa fa-id-card"></i> Xác nhận thanh toán</span>
					</button>
					<!--
					<button class="btn btn-rounded btn-rounded btn-gradient-lime" id="pay-master-visa">
						<span class="btn-icon"><i class="fa fa-id-card"></i> Thanh toán bằng thẻ MASTER, VISA</span>
					</button>
				-->
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

<!-- Drop down list -->
<div id="cell-context-1" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-2" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-3" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-4" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-5" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-6" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<!--
<div id="cell-context-7" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>
-->

<!-- Add more row modal --> 
<div class="modal fade" id="add-row-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
	<div class="modal-dialog" role="document" style="width: 300px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Số dòng</label>
						<input id="rowsNumeric" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số dòng" type="number" value="1" min="0">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-add-row" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var tbl 				= $("#contenttable"),
			tblTariff			= $("#tblTariff"),
			tblCustomer			= $("#tblCustomer"),
			tblVessel			= $("#tblVessel"),
			_columns 			= ["STT", "VoyageKey", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "ClassID", "IsLocalForeign", "POL", "POD", "FPOD", "TransitID", /*"CargoTypeID",*/ "CargoWeight", "UnitID", "CntrNo", "CommodityDescription"],
			_vesselColumns 		= ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane"],
			_customerColumns 	= ["STT", "CusID", "CusName", "Address","CusTypeID", "CusTypeName", "PaymentTypeID", "PaymentTypeName"],
			_tariffColumns  	= ["STT", "TRFCode", "TRFCodeName", "TRFDesc", "JobModeID", "MethodID", "UnitID", "CargoWeight", "Price", "Discount", "Total", "VAT", "RateID", "ExchangeRate"],
			vesselModal 		= $("#vessel-modal"),
			customerModal  		= $("#customer-modal"),
			YardID,
			rateIDList 			= [],
			updateMNFBulkList 	= [],
			customerList 		= {},
			portList 			= {},
			jobModeList 		= {},
			methodList 			= {},
			unitList 			= {},
			classList			= {},
			cargoTypeList		= {},
			manifestBulkList 	= {},
			trfStandardList		= {},
			parentMenuList 		= {};

		/* Load data for job mode list */
		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		/* Load data for method list */
		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?>

		/* Load data for method list */
		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?= json_encode($portList);?>;
		<?php } ?>

		/* Load data for Class Menu list */
		<?php if(isset($classList) && count($classList) >= 0){?>
			classList = <?=json_encode($classList);?>;
		<?php } ?>

		/* Load data for Unit Menu list */
		<?php if(isset($unitList) && count($unitList) >= 0){?>
			unitList = <?=json_encode($unitList);?>;
		<?php } ?>

		/* Load YardID */
		<?php if(isset($YardID) && count($YardID) >= 0){?>
			YardID = <?= json_encode($YardID);?>;
		<?php } ?>

		/* Load Manifest Bulk List */
		<?php if(isset($manifestBulkList) && count($manifestBulkList) >= 0){?>
			manifestBulkList = <?= json_encode($manifestBulkList);?>;
		<?php } ?>

		/* Load Cargo Type */
		<?php if(isset($cargoTypeList) && count($cargoTypeList) >= 0){?>
			cargoTypeList = <?= json_encode($cargoTypeList);?>;
		<?php } ?>

		/* Load TRF Standard List */
		<?php if(isset($trfStandardList) && count($trfStandardList) >= 0){?>
			trfStandardList = <?= json_encode($trfStandardList);?>;
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

		/* Initial contenttable table */	
		tbl.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},		
				{ className: "text-center", targets: _columns.getIndexs(["ClassID", "IsLocalForeign", "POL", "POD", "FPOD", "TransitID", /*"CargoTypeID",*/ "CargoWeight", "UnitID", "CommodityDescription", "BillOfLadingORBookingNo"])},
				{ className: "hiden-input", targets: _columns.getIndexs(["VoyageKey", "BookingNo", "BillOfLading", "CntrNo"])},
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
            rowReorder: false,
            arrayColumns: _columns,
		});
		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});


		/* Initial table tariff */	
		tblTariff.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _tariffColumns.indexOf('STT')},		
				{ className: "text-center", targets: _tariffColumns.getIndexs(["STT", "TRFCode", "TRFCodeName", "TRFDesc", "JobModeID", "MethodID", "UnitID", "CargoWeight", "Price", "Discount", "Total", "VAT"])},
				{ className: "hiden-input", targets: _tariffColumns.getIndexs(["RateID", "ExchangeRate"])},
			],
			order: [[ _tariffColumns.indexOf('STT'), 'asc' ]],
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
            rowReorder: false,
            arrayColumns: _tariffColumns,
		});
		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

		/* Initial vessel table */	
		tblVessel.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _vesselColumns.indexOf('STT')},		
				{ className: "text-center", targets: _vesselColumns.getIndexs(["VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "InLane", "OutLane"])},
				{ className: "hiden-input", targets: _vesselColumns.getIndexs(["VoyageKey", "VesselID", "Status"])},
			],
			order: [[ _vesselColumns.indexOf('STT'), 'asc' ]],
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
            rowReorder: false,
            arrayColumns: _vesselColumns,
		});

		$('#vessel-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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

		tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: portList,
			colIndex: _columns.indexOf("POL"),
			onSelected: function(cell, value){
				var portName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + portName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: portList,
			colIndex: _columns.indexOf("POD"),
			onSelected: function(cell, value){
				var portName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + portName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl.setExtendDropdown({
			target: "#cell-context-3",
			source: portList,
			colIndex: _columns.indexOf("FPOD"),
			onSelected: function(cell, value){
				var portName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + portName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl.setExtendDropdown({
			target: "#cell-context-4",
			source: classList,
			colIndex: _columns.indexOf("ClassID"),
			onSelected: function(cell, value){
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		/* Set dropdown list for IsLocalForeign */
		var localForeignList = {1: 'Nội', 2: 'Ngoại'};
       	tbl.setExtendDropdown({
			target: "#cell-context-5",
			source: localForeignList,
			colIndex: _columns.indexOf("IsLocalForeign"),
			onSelected: function(cell, value){
				if (value == "Nội"){
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl.setExtendDropdown({
			target: "#cell-context-6",
			source: unitList,
			colIndex: _columns.indexOf("UnitID"),
			onSelected: function(cell, value){
				var unitName = unitList.filter( p => p.UnitID == value).map( x => x.UnitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + unitName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		/*
		tbl.setExtendDropdown({
			target: "#cell-context-7",
			source: cargoTypeList,
			colIndex: _columns.indexOf("CargoTypeID"),
			onSelected: function(cell, value){
				var cargoTypeName = cargoTypeList.filter( p => p.CargoTypeID == value).map( x => x.CargoTypeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + cargoTypeName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});
		*/

		$("#tabTariff").hide();
		$("input[type=radio][name=view-opt]").on('change', function(){
			var optChoose = this.value;

			$("#tabBulk").hide();
			$("#tabTariff").hide();

			if (optChoose == 'bulkList'){
				$("#tabBulk").show();
				return;
			}

			if (optChoose == 'tariffList'){
				var currentData = tbl.getDataByColumns(_columns),
					totalCargoWeight = 0,
					totalCost = 0,
					totalVAT = 0;
					rows = [],
					index = 1;

				for (i = 0; i < currentData.length; i++){
					if (currentData[i]['BillOfLadingORBookingNo'] && currentData[i]['CargoWeight']){
						for (j = 0; j < manifestBulkList.length; j++){
							if ($("#VoyageKey").val() == manifestBulkList[j]['VoyageKey']
								&& (currentData[i]['BillOfLadingORBookingNo'] == manifestBulkList[j]['BillOfLading']
								|| currentData[i]['BillOfLadingORBookingNo'] == manifestBulkList[j]['BookingNo']))
							{
								for (k = 0; k < trfStandardList.length; k++){
									if (trfStandardList[k]['JobModeID'] == manifestBulkList[j]['JobModeID']){
										var r = [],
											total = trfStandardList[k]['Price'] * currentData[i]['CargoWeight']
											VAT = total * trfStandardList[k]['VAT'];
										r.push(index++);
										r.push(trfStandardList[k]['TRFCode']);
										r.push(trfStandardList[k]['TRFCodeName']);
										r.push(trfStandardList[k]['TRFDesc']);
										r.push(trfStandardList[k]['JobModeID']);
										r.push(trfStandardList[k]['MethodID']);
										r.push(currentData[i]['UnitID']);
										r.push(currentData[i]['CargoWeight']);
										r.push(trfStandardList[k]['Price']);
										r.push('');
										r.push(total);
										r.push(VAT);
										r.push(trfStandardList[k]['RateID']);
										r.push(trfStandardList[k]['ExchangeRate']);
										rows.push(r);

										totalCargoWeight += currentData[i]['CargoWeight'];
										totalCost += parseInt(total);
										totalVAT += VAT;

										rateIDList.push(trfStandardList[k]['RateID']);
									}
								}
							}
						}
					}
				}	

				tblTariff.dataTable().fnClearTable();
			    if(rows.length > 0){
					tblTariff.dataTable().fnAddData(rows);
			    }

			    var sumary = totalCost + totalVAT;
			    $("<tr style='color: red; font-weight: bold;'><td colspan=10 align=right>Tổng Cộng : </td><td style='text-align: center'>" + sumary + "</td><td></td>").insertAfter($("#tblTariff tr").last());
			    $("#AMOUNT").html(totalCost);
			    $("#VAT").html(totalVAT);
			    $("#TAMOUNT").html(sumary);

				$("#tabTariff").show();

				return;
			}
		});

		$("#VesselSearch").on('click', function(){
			tblVessel.waitingLoad();
			var formData = {
				'action': 		'view',
				'childAction': 	'loadVesselFilterList',
				'VBType': 		$("input[type='radio'][name='VesselFilter']:checked").val(),
				'VesselName':   $("#VesselNameFilter").val(),
				'Year': 		'',
			};			

		    $.ajax({
				url: "<?=site_url(md5('Data') . '/' . md5('dtManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [], index = 1;
					tblVessel.dataTable().fnClearTable();
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];

							if (rData['VesselType'] == 3 && rData['Status'] >= 2){
								$.each(_vesselColumns, function(idx, colname){
								var val = "";
									switch(colname){
										case "STT": 
											val = index++; 
											break;
										case "ETA":
										case "ETD":
											val = getDateTime(rData[colname]);
											break;
										default:
											val = (rData[colname] ? rData[colname] : '');
											break;	
									}
									r.push(val);
								});
								rows.push(r);
							}
						}
					}
					tblVessel.dataTable().fnClearTable();
				    if(rows.length > 0){
						tblVessel.dataTable().fnAddData(rows);
			    	}
			    
				},
				error: function(err){
					tblVessel.dataTable().fnClearTable();
					console.log(err);
				}
			});
		});

		$("#JobModeID").val('XGT');
		for (i = 0; i < methodList.length; i++){
			if (methodList[i]['JobModeID'] == 'XGT'){
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
			
		/* Choose vessel */
		$("#chooseVessel").on('click', function(){
			$('#vessel-modal').modal("show");
			$("#YearFilter").val(new Date().getFullYear());
			$("#VesselSearch").trigger('click');
		});

		$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			formData = {
					'action': 					'view',
					'VoyageKey': 				VoyageKey,
					'IsLocalForeign': 			'',
					'ClassID': 					'',
				};

			$("#VesselName").val(VesselName);
			$("#InOutBoundVoyage").val(InboundVoyage + " - " + OutboundVoyage);
			$("#VoyageKey").val(VoyageKey);

			/*
			tbl.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];

							if (rData['IsInOrdEirBulk'] == 0){
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i + 1;
											break;
										case "IsLocalForeign":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nội";
											else
												val='<input class="hiden-input" value="2">' + "Ngoại";
											break;
										case "ClassID":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nhập";
											else
												val='<input class="hiden-input" value="2">' + "Xuất";
											break;
										case "JobModeID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
											break;
										case "MethodID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
											break;
										case "UnitID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['UnitName'];
											break;
										case "BillOfLadingORBookingNo":
											if (rData['BillOfLading']){
												val = rData['BillOfLading'];
											}
											else if (rData['BookingNo']){
												val = rData['BookingNo'];
											}
											break;
										default:
											val = (rData[colname] == null) ? '' : rData[colname];
											break;	
									}
									r.push(val);
								});
								rows.push(r);
							}
							
						}
					}
					tbl.dataTable().fnClearTable();
		        	if (rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					console.log(err);
				}
			});
			*/

       		vesselModal.modal('hide');
       	});

       	$("#apply-vessel").on("click", function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			formData = {
					'action': 					'view',
					'VoyageKey': 				VoyageKey,
					'IsLocalForeign': 			'',
					'ClassID': 					'',
				};

			$("#VesselName").val(VesselName);
			$("#InOutBoundVoyage").val(InboundVoyage + " - " + OutboundVoyage);
			$("#VoyageKey").val(VoyageKey);
			
			/*
			tbl.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i + 1;
										break;
									case "IsLocalForeign":
										if (rData[colname] == 1)
											val='<input class="hiden-input" value="1">' + "Nội";
										else
											val='<input class="hiden-input" value="2">' + "Ngoại";
										break;
									case "ClassID":
										if (rData[colname] == 1)
											val='<input class="hiden-input" value="1">' + "Nhập";
										else
											val='<input class="hiden-input" value="2">' + "Xuất";
										break;
									case "JobModeID":
										val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
										break;
									case "MethodID":
										val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
										break;
									case "UnitID":
										val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['UnitName'];
										break;
									case "BillOfLadingORBookingNo":
										if (rData['BillOfLading']){
											val = rData['BillOfLading'];
										}
										else if (rData['BookingNo']){
											val = rData['BookingNo'];
										}
										break;
									default:
										val = (rData[colname] == null) ? '' : rData[colname];
										break;	
								}
								r.push(val);
							});

							rows.push(r);
						}
					}
					tbl.dataTable().fnClearTable();
		        	if (rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}
				},
				error: function(err){
					console.log(err);
				}
			});
			*/
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

       	$("#show-payment-modal").on('click', function(){
       		if (!($("#VesselName").val())){
				toastr['error']("Vui lòng chọn Tàu!");
				return;
			}

			if (!($("#CusID").val())){
				toastr['error']("Vui lòng chọn Đối tượng thanh toán (ĐTTT)!");
				return;
			}

			if (!($("#Email").val())){
				toastr['error']("Vui lòng nhập Email!");
				return;
			}
			else{
				if (!(isEmail($("#Email").val()))){
					toastr['error']("Vui lòng nhập Email hợp lệ!");
					return;
				}
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

			if ($("#PaymentTypeID").val() == 'TNGAY'){
				$("#bill-delivery").modal('show');

				$("#p-money").removeClass();
				$("#p-money").addClass('fa fa-check-square');
			}
			else{
				$("#save-credit").trigger('click');
			}
		});

       	$("#save-credit").on('click', function(){
			var tblData	= tbl.getDataByColumns(_columns),
				temp 	= $("input[name='publish-opt']:checked").val(),
				paymentTypeID = $("#PaymentTypeID").val(),
				formDataEir,
				payFormID = '',
				saveData = [];

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
	        	url: "<?=site_url(md5('Order') . '/' . md5('ordBulk'));?>",
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

					eirNo += ('B' + year.toString().substring(2,4));

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

					/* Prepare data for saving */
					for (i = 0; i < tblData.length; i++){
						var r = {
							'VoyageKey' : $("#VoyageKey").val(),
							'ClassID'	: tblData[i]['ClassID'],
							'BillOfLading'	: tblData[i]['ClassID'] == 1 ? tblData[i]['BillOfLadingORBookingNo'] : '',
							'BookingNo'	: tblData[i]['ClassID'] == 1 ? '' : tblData[i]['BillOfLadingORBookingNo'],
							'InvNo' 	: '',
							'InvDraftNo': '',
							'EirNo' 	: eirNo,
							'PinCode' 	: 'B' + data.pinCodeList[0],
							'CusID' 	: $("#CusID").val(),
							'CusTypeID' : $("#CusTypeID").val(),
							'TransitID' : '', //tblData[i]['TransitID'],
							'IssueDate' : $("#IssueDate").val() ? getSQLDateTimeFormat($("#IssueDate").val()) 	: '',
							'ExpDate' 	: $("#ExpDate").val() 	? getSQLDateTimeFormat($("#ExpDate").val()) 	: '',
							'FinishDate': '',
							'CargoWeight' : tblData[i]['CargoWeight'],
							'CargoType' : 2,
							//'KeyNo' 	: '', //tblData[i]['KeyNo'],
							'Remark' 	: '', //tblData[i]['Remark'],	
							'ShipperName': $("#ShipperName").val(),
							'POL':  tblData[i]['POL'],
							'POD':  tblData[i]['POD'],
							'FPOD': tblData[i]['FPOD'],
							'UnitID': tblData[i]['UnitID'],
							'Email': $("#Email").val(),
						};
						saveData.push(r);

						var rMNF = {
							'VoyageKey' : tblData[i]['VoyageKey'],
							'ClassID'	: tblData[i]['ClassID'],
							'BillOfLading'	: tblData[i]['BillOfLading'],
							'BookingNo'	: tblData[i]['BookingNo'],
						};
						updateMNFBulkList.push(rMNF);
					}

					var formDataEir = {
						'action': 'add',
						'PaymentTypeID': (paymentTypeID) ? paymentTypeID : '',
						'PayFormID': (payFormID) ? payFormID : '',
						'JobModeID': ($("#JobModeID").val()) ? $("#JobModeID").val() : '',
						'MethodID': ($("#MethodID").val())  ? $("#MethodID").val() : '',
						'data': saveData,
					}
					
					$("#ShipperName").val('');
           			$("#Email").val('');

					postSave(formDataEir);
	            },
	            error: function(err){
	            	toastr["error"]("Error!");
	            	console.log(err);
	            }
	        });
		});

       	function postSave(formData){
			$.ajax({
                url: "<?=site_url(md5('Order') . '/' . md5('ordBulk'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'add'){                  	
                    	toastr["success"]("Thêm lệnh " + formData.data[0]['EirNo'] + " thành công!");
                    	tbl.DataTable().rows('.selected').remove().draw(false);
               			tbl.updateSTT(_columns.indexOf("STT"));
               			
               			/* Delete row is inserted */
               			for (index = 0; index < formData.data.length; index++){
               				var data = formData.data[index],
               					indexes;

               				if (data['ClassID'] == 1){
               					indexes = tbl.filterRowIndexes( _columns.indexOf( "BillOfLading" ), data['BillOfLading']);
               				}
               				else{
               					indexes = tbl.filterRowIndexes( _columns.indexOf( "BookingNo" ), data['BookingNo']);               					
               				}
               				
               				tbl.DataTable().rows( indexes ).remove().draw( false );
               			}
               			tbl.updateSTT( _columns.indexOf( "STT" ) );

               			/* Update MNF Status */
               			var manifestBulkFormData = {
               				'action': 'edit',
               				'child_action': 'updateMNFBulk',
               				'data': updateMNFBulkList,
               			};
               			postSave(manifestBulkFormData);
                    }

                    if(formData.action == 'edit'){
                    	if (formData.child_action == 'updateMNFBulk'){
                    		toastr['success']("Cập nhật trạng thái dữ liệu Manifest thành công!");
                    		return;
                    	}
                    }

                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$("#addRow").on('click', function(){
			if ($("#VesselName").val() == ''){
				toastr['error']("Vui lòng chọn tàu!");
				return;
			}

			$('#add-row-modal').modal("show");
		});

		var sumNumRows = 0;
		$("#apply-add-row").on("click", function(){
			numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
			sumNumRows += numRows;
			if (numRows == 1){
				tbl.newRow();
				rowsExist = $("#contenttable").DataTable().rows().nodes().length;
				for (i = 0; i < rowsExist; i++){
					cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
					tbl.DataTable().cell(cell).data(i+1).draw(false);
				}

				var newData = tbl.getAddNewData();
				for (i = 0; i < newData.length; i++){
					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");					
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">Xuất'
					).draw(false);

					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("POL") +")");					
					tbl.DataTable().cell(cell).data(YardID).draw(false);

					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("UnitID") +")");					
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="TNE">tấn'
					).draw(false);
				}
			}
			else{
				numRowsExist = $("#contenttable").DataTable().rows().nodes().length;
				numRowHasAddNewClass = 0;
				index = 1;
				for (i = numRowsExist - 1; i >= 0 ; i--){
					var crRow = tbl.find("tbody tr:eq("+i+")");
					if(crRow.hasClass("addnew"))
						numRowHasAddNewClass++;
					else{
						cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl.DataTable().cell(cell).data(sumNumRows + index).draw(false);
						index++;
					}
				}
				tbl.newMoreRows(numRows, numRowHasAddNewClass);

				var newData = tbl.getAddNewData();
				for (i = 0; i < newData.length; i++){
					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");					
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">Xuất'
					).draw(false);

					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("POL") +")");					
					tbl.DataTable().cell(cell).data(YardID).draw(false);

					var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("UnitID") +")");					
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="TNE">tấn'
					).draw(false);
				}
			}
		});

		$("#removeRow").on('click', function(){
			if (tbl.getSelectedRows().length > 0){
				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Tất cả các dòng được chọn sẽ bị xóa!\nTiếp tục?',
		            buttons: {
		                ok: {
		                    text: 'Xác nhận xóa',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
		                       	tbl.DataTable().rows('.selected').remove().draw(false);
               					tbl.updateSTT(_columns.indexOf("STT"));
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC']
		                }
		            }
		        });

				
			}
			else{
				toastr['error']("Vui lòng chọn dòng cần xóa!");
			}
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

		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		function checkInSameDate(e1, e2){
			if (e1.toString().substring(0, 7) == e2.toString().substring(0, 7)){
				return true;
			}
			return false;
		}

		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  	return regex.test(email);
		}

		$("#pay-atm").on('click', function(){
			var trfData = tblTariff.getDataByColumns(_tariffColumns),
				formData = {
					'datas': trfData,
					'cusName': $("#CusName").html(),
					'cusAddr': ($("#Address").text() == '- Không có địa chỉ --') ? '' : $("#Address").text(),
					'sum_amount': $("#AMOUNT").html(),
					'vat_amount': $("#VAT").html(),
					'total_amount': $("#TAMOUNT").html(),
					//'inv_type': '',
					//'exchange_rate': '',
				};

			$.ajax({
				url: "<?=site_url(md5('InvoiceManagement') . '/' . md5('importAndPublish'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					console.log(data);	    
				},
				error: function(err){
					console.log(err);
				}
			});

		});
	});
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>						
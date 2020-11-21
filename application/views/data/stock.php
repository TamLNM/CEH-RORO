<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-4 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-5 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-6 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-7 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-8 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-9 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-10 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-11 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-12 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-22 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-32 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-42 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-52 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-62 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-72 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-82 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-92 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-102 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-112 .dropdown-menu .dropdown-item .sub-text{
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
				<div class="ibox-title">Giám sát hàng biến động</div>
				<div class="button-bar-group mr-3">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>

					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>

					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dòng"
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e" style="display: block;">
				<div class="row ibox mb-0 border-e pb-0 pt-3">			
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<div class="row form-group">			
							<!--
							<button id="chooseVessel" class="btn btn-outline-success btn-rounded btn-sm ml-2" style="width: 75px;">Chọn tàu...</button>		
							-->	

							<label class="ml-3" style="width: 2.75rem; margin-top: 0.4rem">Tên tàu</label>		
							<input id="VesselName" placeholder="Tên tàu" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 11.5rem" type="text">

							<button id="chooseVessel" class="btn btn-success btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 2rem; width: 2rem" title="Chọn tàu">
								<i class="ti-plus"></i>
							</button>

							<button id="nochooseVessel" class="btn btn-danger btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 2rem; width: 2rem" title="Bỏ chọn">
								<i class="ti-close"></i>
							</button>
						</div>
						<div class="row form-group">			
							<label class="mt-1 radio radio-info ml-3">
                                <input type="radio" name="ClassID" class="css-checkbox" checked value="1" />
                                <span class="input-span"></span>Nhập tàu
                            </label>
                            <label class="ml-3 mt-1	 radio radio-info">
                                <input type="radio" name="ClassID" class="css-checkbox" value="2" />
                                <span class="input-span"></span>Xuất tàu
                            </label>       
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
						<div class="row form-group">												
							<label class="ml-3" style="width: 3.5rem; margin-top: 0.4rem">ETA/ ETD</label>
							<input id="ETA" placeholder="ETA" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 8.75rem" type="text">
							<input id="ETD" placeholder="ETD" style="border-radius: 5px; margin-left: 0.5rem; padding-left: 7.55px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 8.75rem" type="text">
						</div>
						<div class="row form-group">												
							<label class="radio radio-warning mt-1 ml-3">
                                <input type="radio" name="IsLocalForeign" class="css-checkbox" value="1" />
                                <span class="input-span"></span>Hàng nội
                            </label>								
							<label class="radio radio-warning ml-3 mt-1">
                                <input type="radio" name="IsLocalForeign" class="css-checkbox" checked value="2" />
                                <span class="input-span"></span>Hàng ngoại
                            </label>				
                        </div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">	
						<div class="row form-group">	
							<label style="margin-top: 0.4rem" class="ml-3">Chuyến</label>
							<input id="VoyageKey" class="form-control form-control-sm" type="text" hidden>
							<input id="InboundVoyage" placeholder="Chuyến nhập" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.55px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 8.75rem" type="text">
							<input id="OutboundVoyage" placeholder="Chuyến xuất" style="border-radius: 5px; margin-left: 0.5rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 8.75rem" type="text">
						</div>
						<div class="row form-group">	
							<button class="btn btn-outline-info btn-fix btn-rounded btn-sm ml-3" id="transferJobQuay">
                                <span class="btn-icon"><i class="la la-mail-forward"></i>Công việc tàu</span>
                            </button>
						</div>	
					</div>									
				</div>					
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="tableIn">
					<table id="contenttable"  oncontextmenu="return false;" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid">rowguid</th>
							<th col-name="VoyageKey">Voyage Key</th>
							<th col-name="BillOfLading">Số vận đơn</th>
							<th col-name="VINNo">Số VIN</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>	
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="CusID">Khách hàng</th>							
							<th col-name="POL">Cảng xếp</th>							
							<th col-name="POD">Cảng dỡ</th>							
							<th col-name="FPOD">Cảng đích</th>							
							<th col-name="VMStatus">Tình trạng xe</th>
							<th col-name="DateIn" class="data-type-datetime">Ngày vào</th>
							<th col-name="JobModeInID">Phương án vào</th>
							<th col-name="MethodInID">Phương thức vào</th>
							<th col-name="DateOut" class="data-type-datetime">Ngày ra</th>							
							<th col-name="JobModeOutID">Phương án ra</th>						
							<th col-name="MethodOutID">Phương thức ra</th>
							<th col-name="Block">Block</th>
							<th col-name="Bay" type="num">Bay</th>
							<th col-name="Row">Row</th>
							<th col-name="Tier">Tier</th>							
							<th col-name="Area">Area</th>							
							<th col-name="InvNo">Số hóa đơn</th>							
							<th col-name="EirNo">Số lệnh giao nhận</th>							
							<th col-name="OrderNo">Số lệnh dịch vụ</th>							
							<th col-name="PinCode">Mã pin</th>	
							<th col-name="Sequence">Sequence</th>						
							<th col-name="TransitID">Transit ID</th>								
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="tableOut">
					<table id="contenttable2" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid">rowguid</th>
							<th col-name="VoyageKey">Voyage Key</th>
							<th col-name="BookingNo">Số booking</th>
							<th col-name="VINNo">Số VIN</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>	
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="CusID">Khách hàng</th>							
							<th col-name="POL">Cảng xếp</th>							
							<th col-name="POD">Cảng dỡ</th>							
							<th col-name="FPOD">Cảng đích</th>							
							<th col-name="VMStatus">Tình trạng xe</th>
							<th col-name="DateIn" class="data-type-datetime">Ngày vào</th>
							<th col-name="JobModeInID">Phương án vào</th>
							<th col-name="MethodInID">Phương thức vào</th>
							<th col-name="DateOut" class="data-type-datetime">Ngày ra</th>							
							<th col-name="JobModeOutID">Phương án ra</th>						
							<th col-name="MethodOutID">Phương thức ra</th>
							<th col-name="Block">Block</th>
							<th col-name="Bay" type="num">Bay</th>
							<th col-name="Row">Row</th>
							<th col-name="Tier">Tier</th>							
							<th col-name="Area">Area</th>							
							<th col-name="InvNo">Số hóa đơn</th>							
							<th col-name="EirNo">Số lệnh giao nhận</th>							
							<th col-name="OrderNo">Số lệnh dịch vụ</th>							
							<th col-name="PinCode">Mã pin</th>	
							<th col-name="Sequence">Sequence</th>						
							<th col-name="TransitID">Transit ID</th>								
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
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
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
										<div class="col-sm-8 input-group input-group-sm">
											<div class="input-group">
												<input class="form-control form-control-sm" id="VINNoFilter" type="text" placeholder="VIN No.">
												<span class="input-group-addon bg-white btn text-warning" id="VINNoButton" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
											</div>
										</div>										
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Năm</label>
										<div class="col-md-8 col-sm-10 col-xs-10 input-group input-group-sm">
											<select class="selectpicker show-tick form-control border-e mb-4" tabindex="-98" id="YearFilter" title="Chọn năm">
                                                <?php for ($i = 2016; $i < 2026; $i++){ ?>
													<option value="<?=$i?>"><?=$i?></option>
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
									<th col-name="ETA" class="data-type-datetime">ETA</th>
									<th col-name="ETD" class="data-type-datetime">ETD</th>
									<th col-name="Status">Status</th>
									<th col-name="InLane">Chuyến xuất</th>
									<th col-name="OutLane">Chuyến xuất</th>
								</tr>
							</thead>
							<tbody></tbody>
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
<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-2" aria-hidden="true" data-whatever="id" style="padding-left: 10%; padding-top: 5%">
	<div class="modal-dialog" role="document" style="min-width: 800px!important">
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
						</tr>
					</thead>
					<tbody>
					<?php if(count($customerList) > 0) {$i = 1; ?>
						<?php foreach($customerList as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['CusID'];?></td>
								<td><?=$item['CusName'];?></td>							
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

<!-- Add more row modal --> 
<div class="modal fade" id="add-row-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
	<div class="modal-dialog" role="document" style="width: 300px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Số dòng</label>
						<input id="rowsNumeric" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số dòng" type="number" value="1">
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

<div id="cell-context-7" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-8" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-9" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-10" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-11" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-12" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-22" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-32" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-42" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-52" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-62" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-72" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-82" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-92" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-102" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-112" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
		var _columns = ["STT", "rowguid", "VoyageKey", "BillOfLading", "VINNo", "ClassID", "IsLocalForeign", "CusID", "POL", "POD", "FPOD", "VMStatus", "DateIn", "JobModeInID",  "MethodInID", "DateOut", "JobModeOutID", "MethodOutID", "Block", "Bay", "Row", "Tier", "Area", "InvNo", "EirNo", "OrderNo", "PinCode", "Sequence", "TransitID"],
			_columns2 = ["STT", "VoyageKey", "BookingNo", "VINNo", "ClassID", "IsLocalForeign", "CusID", "POL", "POD", "FPOD", "VMStatus", "DateIn", "JobModeInID",  "MethodInID", "DateOut", "JobModeOutID", "MethodOutID", "Block", "Bay", "Row", "Tier", "Area", "InvNo", "EirNo", "OrderNo", "PinCode", "Sequence", "TransitID"],
			_vesselColumns 	= ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane"],
			_customerColumns= ["STT", "CusID", "CusName"],
			//_unitColumn		= ["STT", "UnitID", "UnitName"],
			tbl 	 		= $("#contenttable"),
			tbl2 	 		= $("#contenttable2"),
			tblVessel 		= $("#tblVessel"),
			tblCustomer		= $("#tblCustomer"),
			tblUnit			= $("#tblUnit"),
			unitList		= {},
			/*
			VMStatusList	= {
							'B': "Trên tàu",
							'I': "Đang vào bãi",
							'S': "Trên bãi",
							'O': "Đang ra bãi",
							'D': "Đã ra bãi",},*/
			VMStatusList 	= {},
			stockList		= {},
			tblCustomer		= $("#tblCustomer"),
			customerModal 	= $("#customer-modal"),
			unitModal 		= $("#unit-modal"),
			jobModeList		= {},
			methodList		= {},
			portList		= {},
			transitList		= {},
			classList		= {},
			parentMenuList 	= {},
			countRowsAdded  = 0;

		/* Initial contenttable */
		tbl.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.getIndexs(["STT", "Bay", "Row", "Tier"])},		
				{ className: "text-center", targets: _columns.getIndexs(["BillOfLading", "VINNo", "ClassID", "IsLocalForeign", "POL", "POD", "FPOD", "VMStatus", "JobModeInID", "JobModeOutID", "MethodInID", "MethodOutID", "Block", "Area", "PinCode", "Sequence", "TransitID", "DateIn", "DateOut"])},
				{ className: "hiden-input", targets: _columns.getIndexs(["rowguid", "VoyageKey", "CusID", "InvNo", "EirNo", "OrderNo"])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns,
		});
		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

		tbl2.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns2.getIndexs(["STT", "Bay", "Row", "Tier"])},		
				{ className: "text-center", targets: _columns2.getIndexs(["BookingNo", "VINNo", "ClassID", "IsLocalForeign", "CusID", "POL", "POD", "FPOD", "VMStatus", "JobModeInID", "JobModeOutID", "MethodInID", "MethodOutID", "Block", "Area", "InvNo", "EirNo", "OrderNo", "PinCode", "Sequence", "TransitID", "DateIn", "DateOut"])},
				{ className: "hiden-input", targets: _columns2.getIndexs(["rowguid", "VoyageKey", "CusID"])},
			],
			order: [[ _columns2.indexOf('STT'), 'asc' ]],
			paging: false,
			keys:true,
            autoFill: {
                focus: 'focus',
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns2,
		});
		tbl2.editableTableWidget({editor: $("#status, #httt, #editor-input")});

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
            rowReorder: false,
            arrayColumns: _vesselColumns
		});

		$('#vessel-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		/* Initial customer table */
		tblCustomer.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _customerColumns.indexOf('STT')},		
				{ className: "text-center", targets: _customerColumns.getIndexs(["CusID", "CusName"])},
			],
			order: [[ _customerColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _customerColumns
		});

		/* Initial unit table 
		tblUnit.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _customerColumns.indexOf('STT')},		
				{ className: "text-center", targets: _customerColumns.getIndexs(["UnitID", "UnitName"])},
			],
			order: [[ _customerColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            rowReorder: false,
            arrayColumns: _customerColumns,
		});
		*/

		/* Reset value Voyage Key */
		$("#VoyageKey").val('');

		/* Load data from Unit table */
		<?php if(isset($unitList) && count($unitList) >= 0){?>
			unitList = <?= json_encode($unitList);?>;
		<?php } ?>

		/* Load data from Unit table */
		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		/* Load data from Unit table */
		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?>

		/* Load data from Port table */
		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?= json_encode($portList);?>;
		<?php } ?>

		/* Load data from Stock table */
		<?php if(isset($stockList) && count($stockList) >= 0){?>
			stockList = <?= json_encode($stockList);?>;
		<?php } ?>

		/* Load data from Transit table */
		<?php if(isset($transitList) && count($transitList) >= 0){?>
			transitList = <?= json_encode($transitList);?>;
		<?php } ?>

		/* Load data from Class table */
		<?php if(isset($classList) && count($classList) >= 0){?>
			classList = <?= json_encode($classList);?>;
		<?php } ?>

		/* Load data from VM Status table */
		<?php if(isset($vmStatusList) && count($vmStatusList) >= 0){?>
			vmStatusList = <?= json_encode($vmStatusList);?>;
		<?php } ?>

		/* Load data for Parent Menu */
		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Data'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		/* Set dropdown list for Unit 
       	tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: unitList,
			colIndex: _columns.indexOf("UnitID"), // ô cần show drop-down box
			onSelected: fuSnction(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var UnitName = unitList.filter( p => p.UnitID == value).map( x => x.UnitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + UnitName	
				).draw(false);			
			}	
		});
		*/

		/* Set dropdown list for VMStatus */
       	tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: vmStatusList,
			colIndex: _columns.indexOf("VMStatus"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				/*
				switch(value)
				{
					case 'Trên tàu':
						tbl.DataTable().cell(cell).data('<input class="hiden-input" value="B">' + value).draw(false);
						break
					case 'Đang vào bãi':
						tbl.DataTable().cell(cell).data('<input class="hiden-input" value="I">' + value).draw(false);
						break;
					case 'Trên bãi':
						tbl.DataTable().cell(cell).data('<input class="hiden-input" value="S">' + value).draw(false);
						break;
					case 'Đang ra bãi':
						tbl.DataTable().cell(cell).data('<input class="hiden-input" value="O">' + value).draw(false);
						break;
					case 'Đã ra bãi':
						tbl.DataTable().cell(cell).data('<input class="hiden-input" value="D">' + value).draw(false);
						break;
				}
				*/
				var vmStatusDesc = vmStatusList.filter( p => p.VMStatus == value).map( x => x.VMStatusDesc );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + vmStatusDesc
				).draw(false);			
			}	
		});
		
		/* Set dropdown list for Job-Mode-In */
       	tbl.setExtendDropdown({
			target: "#cell-context-3",
			source: jobModeList,
			colIndex: _columns.indexOf("JobModeInID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Job-Mode-Out */
       	tbl.setExtendDropdown({
			target: "#cell-context-5",
			source: jobModeList,
			colIndex: _columns.indexOf("JobModeOutID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Method-In */
       	tbl.setExtendDropdown({
			target: "#cell-context-4",
			source: methodList,
			colIndex: _columns.indexOf("MethodInID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Method-Out */
       	tbl.setExtendDropdown({
			target: "#cell-context-6",
			source: methodList,
			colIndex: _columns.indexOf("MethodOutID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);			
			}	
		});

		/* Set dropdown list for POL */
       	tbl.setExtendDropdown({
			target: "#cell-context-7",
			source: portList,
			colIndex: _columns.indexOf("POL"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for POD */
       	tbl.setExtendDropdown({
			target: "#cell-context-8",
			source: portList,
			colIndex: _columns.indexOf("POD"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for FPOD */
       	tbl.setExtendDropdown({
			target: "#cell-context-9",
			source: portList,
			colIndex: _columns.indexOf("FPOD"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for IsLocalForeign */
		var localForeignList = {1: 'Nội', 2: 'Ngoại'};
       	tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: localForeignList,
			colIndex: _columns.indexOf("IsLocalForeign"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
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
			}	
		});

		/* Set dropdown list for Class */
		//var localForeignList = {1: 'Nhập', 2: 'Xuất'};
       	tbl.setExtendDropdown({
			target: "#cell-context-10",
			source: classList,
			colIndex: _columns.indexOf("ClassID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				/*
				if (value == "Nhập"){
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}
				*/
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);	
			}	
		});

		/* Set dropdown list for Transit */
       	tbl.setExtendDropdown({
			target: "#cell-context-11",
			source: transitList,
			colIndex: _columns.indexOf("TransitID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var transitName = transitList.filter( p => p.TransitID == value).map( x => x.TransitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + transitName
				).draw(false);			
			}	
		});

       	/**** Set drop-down data for tbl2 ****/
       	/* Set dropdown list for VMStatus */
       	tbl2.setExtendDropdown({
			target: "#cell-context-22",
			source: vmStatusList,
			colIndex: _columns2.indexOf("VMStatus"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				/*
				switch(value)
				{
					case 'Trên tàu':
						tbl2.DataTable().cell(cell).data('<input class="hiden-input" value="B">' + value).draw(false);
						break
					case 'Đang vào bãi':
						tbl2.DataTable().cell(cell).data('<input class="hiden-input" value="I">' + value).draw(false);
						break;
					case 'Trên bãi':
						tbl2.DataTable().cell(cell).data('<input class="hiden-input" value="S">' + value).draw(false);
						break;
					case 'Đang ra bãi':
						tbl2.DataTable().cell(cell).data('<input class="hiden-input" value="O">' + value).draw(false);
						break;
					case 'Đã ra bãi':
						tbl2.DataTable().cell(cell).data('<input class="hiden-input" value="D">' + value).draw(false);
						break;
				}
				*/
				var vmStatusDesc = vmStatusList.filter( p => p.VMStatus == value).map( x => x.VMStatusDesc );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + vmStatusDesc
				).draw(false);			
			}	
		});
		
		/* Set dropdown list for Job-Mode-In */
       	tbl2.setExtendDropdown({
			target: "#cell-context-32",
			source: jobModeList,
			colIndex: _columns2.indexOf("JobModeInID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Job-Mode-Out */
       	tbl2.setExtendDropdown({
			target: "#cell-context-52",
			source: jobModeList,
			colIndex: _columns2.indexOf("JobModeOutID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Method-In */
       	tbl2.setExtendDropdown({
			target: "#cell-context-42",
			source: methodList,
			colIndex: _columns2.indexOf("MethodInID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);			
			}	
		});

		/* Set dropdown list for Method-Out */
       	tbl2.setExtendDropdown({
			target: "#cell-context-62",
			source: methodList,
			colIndex: _columns2.indexOf("MethodOutID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);			
			}	
		});

		/* Set dropdown list for POL */
       	tbl2.setExtendDropdown({
			target: "#cell-context-72",
			source: portList,
			colIndex: _columns2.indexOf("POL"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for POD */
       	tbl2.setExtendDropdown({
			target: "#cell-context-82",
			source: portList,
			colIndex: _columns2.indexOf("POD"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for FPOD */
       	tbl2.setExtendDropdown({
			target: "#cell-context-92",
			source: portList,
			colIndex: _columns2.indexOf("FPOD"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var PortName = portList.filter( p => p.PortID == value).map( x => x.PortName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + PortName
				).draw(false);			
			}	
		});

		/* Set dropdown list for IsLocalForeign */
		var localForeignList = {1: 'Nội', 2: 'Ngoại'};
       	tbl2.setExtendDropdown({
			target: "#cell-context-12",
			source: localForeignList,
			colIndex: _columns2.indexOf("IsLocalForeign"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				if (value == "Nội"){
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}
			}	
		});

		/* Set dropdown list for Class */
		//var localForeignList = {1: 'Nhập', 2: 'Xuất'};
       	tbl2.setExtendDropdown({
			target: "#cell-context-102",
			source: classList,
			colIndex: _columns2.indexOf("ClassID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				/*
				if (value == "Nhập"){
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}
				*/
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);	
			}	
		});

		/* Set dropdown list for Transit */
       	tbl2.setExtendDropdown({
			target: "#cell-context-112",
			source: transitList,
			colIndex: _columns2.indexOf("TransitID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var transitName = transitList.filter( p => p.TransitID == value).map( x => x.TransitName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + transitName
				).draw(false);			
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

		/* Change ClassID selected radio event */
		$("#tableOut").hide();

	    $('input[type=radio][name=ClassID]').change(function() {
	    	$("#transferJobQuay").show();
			$("#tableIn").hide();
			$("#tableOut").hide();
	    	if (this.value == 1){	    		
				$("#tableIn").show();
			}
	    	else if (this.value == 2){	    		
	    		$("#tableOut").show();
				$("#transferJobQuay").hide();
	    	}
	    });

	    $("#transferJobQuay").on('click', function(){
	    	if ($('#VoyageKey').val() == ''){
				toastr['error']('Vui lòng chọn tàu trước khi Chuyển dữ liệu!');
				return;
			}

	    	var formData = {
					'action': 		'view',
					'childAction': 	'loadStockList',
					'VoyageKey': 	$("#VoyageKey").val(),
				},
				dataSave = [],
				updateStockData = [];

			$.ajax({	
				url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					for (i  = 0; i < data.list.length; i++){
						var rData 	= data.list[i];
						if (rData['ClassID'] == 1 && rData['IsInJobQuay'] == 0 && rData['VMStatus'] == 'B'){						
							var obj = {
								'StockRef': 	rData['rowguid'],
								'VoyageKey': 	rData['VoyageKey'],
								'ClassID': 		1,
								'IsLocalForeign': rData['IsLocalForeign'],
								'BillOfLading': rData['BillOfLading'],
								'VINNo': 		rData['VINNo'],
								'TransitID': 	rData['TransitID'],
								'JobModeInID': 	rData['JobModeInID'],
								'JobModeOutID': rData['JobModeOutID'],
								'MethodInID': 	rData['MethodInID'],
								'MethodOutID':  rData['MethodOutID'],
								'JobStatus': 	'KT',
								'PaymentTypeID': 'TSAU',
								'CargoType': 'R',
							},
							objUpdateStock = {
								'rowguid': rData['rowguid'],
								'IsInJobQuay': 1,
							};

							dataSave.push(obj);
							updateStockData.push(objUpdateStock);
						}
					}
					if (dataSave.length > 0){
						var formData = {
							'action': 'add',
							'childAction': 'addJobQuay',
							'data': dataSave,
						};
						postSave(formData);

						var formUpdateData = {
							'action': 'edit',
							'childAction': 'updateStockData',
							'data': updateStockData,
						};
						postSave(formUpdateData);
					}
					else{
						toastr['info']("Tất cả các dữ liệu của tàu đều đã được chuyển!");
						return;
					}
				},
				error: function(err){
					console.log(err);
				},
			});			
	    });

	    var numCount = 0;
		/* Add new row event */
		$('#addrow').on('click', function(){
       		if ($('#VoyageKey').val() == ''){
				toastr['error']('Vui lòng chọn tàu trước khi Thêm mới dòng!');
				return;
			}
            $('#add-row-modal').modal("show"); 
        });

       	var sumNumRows = 0;
        $("#apply-add-row").on("click", function(){
        	numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
        	sumNumRows += numRows;
        	if (numRows == 1){ // Table In
        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
        			tbl.newRow();
	        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl.DataTable().cell(cell).data(i+1).draw(false);
					}
					
					var newData 	= tbl.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}
					}
        		}
        		else{
        			tbl2.newRow();
	        		rowsExist = $("#contenttable2").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl2.DataTable().cell(cell).data(i+1).draw(false);
					}
					
					var newData 	= tbl2.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}
					}
        		}
			}
			/* Add more than 1 row */
			else
			{	
        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
        			numRowsExist = tbl.DataTable().rows().nodes().length;
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

					var newData 	= tbl.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}					
					}
        		}
				else{
					numRowsExist = tbl2.DataTable().rows().nodes().length;
					numRowHasAddNewClass = 0;
					index = 1;
					for (i = numRowsExist - 1; i >= 0 ; i--){
						var crRow = tbl2.find("tbody tr:eq("+i+")");
						if(crRow.hasClass("addnew"))
							numRowHasAddNewClass++;
						else{
							cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("STT") +")");
				        	tbl2.DataTable().cell(cell).data(sumNumRows + index).draw(false);
				        	index++;
						}
					}
					tbl2.newMoreRows(numRows, numRowHasAddNewClass);

					var newData 	= tbl2.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}					
					}
				}
			}
		});

        $("#add-row-modal").bind('keypress', function(e) {
       		if(e.which == 13){
	       		numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
	        	sumNumRows += numRows;
	        	if (numRows == 1){ // Table In
	        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
	        			tbl.newRow();
		        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
						for (i = 0; i < rowsExist; i++){
							cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
							tbl.DataTable().cell(cell).data(i+1).draw(false);
						}
						
						var newData 	= tbl.getAddNewData();
						for (i = 0; i < newData.length; i++){
							/* Set value for ClassID */
							if (newData[i]['ClassID'] == ''){
								var id  	= $("input[name='ClassID']:checked").val(),
									cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
									classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="'+ id  +'">' + classCellValue
								).draw(false);
							}
								
							/* Set value for IsForeignLocal */
							if (newData[i]['IsLocalForeign'] == ''){
								var id  	= $("input[name='IsLocalForeign']:checked").val(),
									cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
								if (id == 1){
									tbl.DataTable().cell(cell).data(
										'<input class="hiden-input" value="1">Nội'
									).draw(false);
								}
								else{
									tbl.DataTable().cell(cell).data(
										'<input class="hiden-input" value="2">Ngoại'
									).draw(false);
								}				
							}
						}
	        		}
	        		else{
	        			tbl2.newRow();
		        		rowsExist = $("#contenttable2").DataTable().rows().nodes().length;
						for (i = 0; i < rowsExist; i++){
							cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
							tbl2.DataTable().cell(cell).data(i+1).draw(false);
						}
						
						var newData 	= tbl2.getAddNewData();
						for (i = 0; i < newData.length; i++){
							/* Set value for ClassID */
							if (newData[i]['ClassID'] == ''){
								var id  	= $("input[name='ClassID']:checked").val(),
									cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
									classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="'+ id  +'">' + classCellValue
								).draw(false);
							}
								
							/* Set value for IsForeignLocal */
							if (newData[i]['IsLocalForeign'] == ''){
								var id  	= $("input[name='IsLocalForeign']:checked").val(),
									cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
								if (id == 1){
									tbl2.DataTable().cell(cell).data(
										'<input class="hiden-input" value="1">Nội'
									).draw(false);
								}
								else{
									tbl2.DataTable().cell(cell).data(
										'<input class="hiden-input" value="2">Ngoại'
									).draw(false);
								}				
							}
						}
	        		}
				}
				/* Add more than 1 row */
				else
				{	
	        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
	        			numRowsExist = tbl.DataTable().rows().nodes().length;
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

						var newData 	= tbl.getAddNewData();
						for (i = 0; i < newData.length; i++){
							/* Set value for ClassID */
							if (newData[i]['ClassID'] == ''){
								var id  	= $("input[name='ClassID']:checked").val(),
									cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
									classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="'+ id  +'">' + classCellValue
								).draw(false);
							}
								
							/* Set value for IsForeignLocal */
							if (newData[i]['IsLocalForeign'] == ''){
								var id  	= $("input[name='IsLocalForeign']:checked").val(),
									cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
								if (id == 1){
									tbl.DataTable().cell(cell).data(
										'<input class="hiden-input" value="1">Nội'
									).draw(false);
								}
								else{
									tbl.DataTable().cell(cell).data(
										'<input class="hiden-input" value="2">Ngoại'
									).draw(false);
								}				
							}					
						}
	        		}
					else{
						numRowsExist = tbl2.DataTable().rows().nodes().length;
						numRowHasAddNewClass = 0;
						index = 1;
						for (i = numRowsExist - 1; i >= 0 ; i--){
							var crRow = tbl2.find("tbody tr:eq("+i+")");
							if(crRow.hasClass("addnew"))
								numRowHasAddNewClass++;
							else{
								cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("STT") +")");
					        	tbl2.DataTable().cell(cell).data(sumNumRows + index).draw(false);
					        	index++;
							}
						}
						tbl2.newMoreRows(numRows, numRowHasAddNewClass);

						var newData 	= tbl2.getAddNewData();
						for (i = 0; i < newData.length; i++){
							/* Set value for ClassID */
							if (newData[i]['ClassID'] == ''){
								var id  	= $("input[name='ClassID']:checked").val(),
									cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("ClassID") +")");			
									classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="'+ id  +'">' + classCellValue
								).draw(false);
							}
								
							/* Set value for IsForeignLocal */
							if (newData[i]['IsLocalForeign'] == ''){
								var id  	= $("input[name='IsLocalForeign']:checked").val(),
									cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("IsLocalForeign") +")");						
								if (id == 1){
									tbl2.DataTable().cell(cell).data(
										'<input class="hiden-input" value="1">Nội'
									).draw(false);
								}
								else{
									tbl2.DataTable().cell(cell).data(
										'<input class="hiden-input" value="2">Ngoại'
									).draw(false);
								}				
							}					
						}
					}
				}	
				$("#add-row-modal").modal("hide");
			}
       	});

       	/* Prevent press '-' */
       	$("#rowsNumeric").keydown(function(event) {
		  	if (event.which == 189) {
		    	event.preventDefault();
		   	}
		});

		/* Child  table when choose Vessel */
       	$("#chooseVessel").on('click', function(){
       		sumNumRows = 0;
			$('#vessel-modal').modal("show");
			$('#VesselSearch').trigger('click');
		});	

		$("#nochooseVessel").on('click', function(){
			$('#inputManifestForm').trigger("reset");
			tbl.dataTable().fnClearTable();
			$("#VesselName").val('');
			$("#InboundVoyage").val('');
			$("#OutboundVoyage").val('');
			$("#ETA").val('');
			$("#ETD").val('');
		});

		//tblVessel.find("tbody tr").on("dblclick", function(){
       	$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var vesselData 		= tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey		= vesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName 		= vesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage 	= vesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage 	= vesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			InLane 			= vesselData[_vesselColumns.indexOf("InLane")],
       			OutLane 		= vesselData[_vesselColumns.indexOf("OutLane")],
       			ETA 			= vesselData[_vesselColumns.indexOf("ETA")],
       			ETD 			= vesselData[_vesselColumns.indexOf("ETD")];

       		$("#VoyageKey").val(VoyageKey);
       		$("#VesselName").val(VesselName);
       		$("#InboundVoyage").val(InboundVoyage);
       		$("#OutboundVoyage").val(OutboundVoyage);
       		$("#ETA").val(getDateTime(ETA));
       		$("#ETD").val(getDateTime(ETD));

       		var formData = {
					'action': 		'view',
					'childAction': 	'loadPortByLane',
					'InLane':   	InLane,
					'OutLane': 		OutLane,
				},
				portListByLane = {};

			$.ajax({
				url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					portListByLane = data.list;
					/* Set dropdown list for POL */
				    tbl.setExtendDropdown({
						target: "#cell-context-7",
						source: portListByLane,
						colIndex: _columns.indexOf("POL"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value +'">' + PortName
							).draw(false);			

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for POD */
				    tbl.setExtendDropdown({
						target: "#cell-context-8",
						source: portListByLane,
						colIndex: _columns.indexOf("POD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for FPOD */
				    tbl.setExtendDropdown({
						target: "#cell-context-9",
						source: portListByLane,
						colIndex: _columns.indexOf("FPOD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);	

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}			
						}	
					});

					/* Set dropdown list for POL */
				    tbl2.setExtendDropdown({
						target: "#cell-context-72",
						source: portListByLane,
						colIndex: _columns2.indexOf("POL"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for POD */
				    tbl2.setExtendDropdown({
						target: "#cell-context-82",
						source: portListByLane,
						colIndex: _columns2.indexOf("POD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for FPOD */
				    tbl2.setExtendDropdown({
						target: "#cell-context-92",
						source: portListByLane,
						colIndex: _columns2.indexOf("FPOD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});					
				},
				error: function(err){
					console.log(err);
				},
			});
			
			/* *** */
       		$("#vessel-modal").modal("hide");
       		$("#search").trigger('click');
       	});

       	$("#apply-vessel").on("click", function(){
       		var vesselData 		= tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey		= vesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName 		= vesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage 	= vesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage 	= vesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			InLane 			= vesselData[_vesselColumns.indexOf("InLane")],
       			OutLane 		= vesselData[_vesselColumns.indexOf("OutLane")],
       			ETA 			= vesselData[_vesselColumns.indexOf("ETA")],
       			ETD 			= vesselData[_vesselColumns.indexOf("ETD")];

       		$("#VoyageKey").val(VoyageKey);
       		$("#VesselName").val(VesselName);
       		$("#InboundVoyage").val(InboundVoyage);
       		$("#OutboundVoyage").val(OutboundVoyage);
       		$("#ETA").val(getDateTime(ETA));
       		$("#ETD").val(getDateTime(ETD));

       		var formData = {
					'action': 		'view',
					'childAction': 	'loadPortByLane',
					'InLane':   	InLane,
					'OutLane': 		OutLane,
				},
				portListByLane = {};

			$.ajax({
				url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					portListByLane = data.list;

					/* Set dropdown list for POL */
				    tbl.setExtendDropdown({
						target: "#cell-context-7",
						source: portListByLane,
						colIndex: _columns.indexOf("POL"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value +'">' + PortName
							).draw(false);			

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for POD */
				    tbl.setExtendDropdown({
						target: "#cell-context-8",
						source: portListByLane,
						colIndex: _columns.indexOf("POD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for FPOD */
				    tbl.setExtendDropdown({
						target: "#cell-context-9",
						source: portListByLane,
						colIndex: _columns.indexOf("FPOD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);	

							var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}			
						}	
					});

					/* Set dropdown list for POL */
				    tbl2.setExtendDropdown({
						target: "#cell-context-72",
						source: portListByLane,
						colIndex: _columns2.indexOf("POL"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for POD */
				    tbl2.setExtendDropdown({
						target: "#cell-context-82",
						source: portListByLane,
						colIndex: _columns2.indexOf("POD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});

					/* Set dropdown list for FPOD */
				    tbl2.setExtendDropdown({
						target: "#cell-context-92",
						source: portListByLane,
						colIndex: _columns2.indexOf("FPOD"), // ô cần show drop-down box
						onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
							var PortName = portListByLane.filter( p => p.PortID == value).map( x => x.PortName );
							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ value  +'">' + PortName
							).draw(false);			

							var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

							if(!crRow.hasClass("addnew")){
					        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
				        	}	
						}	
					});					
				},
				error: function(err){
					console.log(err);
				},
			});

       		$("#search").trigger('click');
        });

		/* Child table when choose Unit cell 
        // Set extension button choose Custom 
		tbl.setExtendSelect( _columns.indexOf("UnitID"), function(rIdx, cIdx){
			unitModal.val(rIdx + "." + cIdx);
			unitModal.modal("show");
		});
		tbl.editableTableWidget();

		// Adjust column in table when show modal
		unitModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Select customer on table
		tblUnit.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#unit-modal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				unitID = $(this).find("td:eq("+_customerColumns.indexOf("UnitID")+")").text(),
				unitName  = $(this).find("td:eq("+_customerColumns.indexOf("UnitName")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ unitID  +'">' + unitName
			).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			unitModal.modal("hide");
		});

		$("#apply-unit").on("click", function(){	// Click Accept
			var rIdx = unitModal.val().split(".")[0],
				cIdx = unitModal.val().split(".")[1],
				unitID = tblUnit.getSelectedRows().data().toArray()[0][_unitColumn.indexOf("UnitID")],
				unitName = tblUnit.getSelectedRows().data().toArray()[0][_unitColumn.indexOf("UnitName")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ unitID  +'">' + unitName
				).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
		*/

		/* Child table when choose Customer cell*/
        // Set extension button choose Custom 
		tbl.setExtendSelect( _columns.indexOf("CusID"), function(rIdx, cIdx){
			customerModal.val(rIdx + "." + cIdx);
			customerModal.modal("show");
		});		
		tbl2.setExtendSelect( _columns.indexOf("CusID"), function(rIdx, cIdx){
			customerModal.val(rIdx + "." + cIdx);
			customerModal.modal("show");
		});

		// Adjust column in table when show modal
		customerModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Select customer on table
		tblCustomer.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#customer-modal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cusID = $(this).find("td:eq("+_customerColumns.indexOf("CusID")+")").text(),
				cusName  = $(this).find("td:eq("+_customerColumns.indexOf("CusName")+")").text();

			if ($('input[type=radio][name=ClassID]:checked').val() == 1){
				var cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tbl.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ cusID  +'">' + cusName
				).draw();

				var crRow = tbl.find("tbody tr:eq("+rIdx+")");

				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
			}
			else{
				var cell = tbl2.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tbl2.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ cusID  +'">' + cusName
				).draw();

				var crRow = tbl2.find("tbody tr:eq("+rIdx+")");

				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
	        }

			customerModal.modal("hide");
		});

		$("#apply-customer").on("click", function(){	// Click Accept
			var rIdx = customerModal.val().split(".")[0],
				cIdx = customerModal.val().split(".")[1],
				cusID = tblCustomer.getSelectedRows().data().toArray()[0][_customerColumns.indexOf("CusID")],
				cusName = tblCustomer.getSelectedRows().data().toArray()[0][_customerColumns.indexOf("CusName")];

			if ($('input[type=radio][name=ClassID]:checked').val() == 1){
				var cell  = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tbl.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ cusID  +'">' + cusName
				).draw();

				var crRow = tbl.find("tbody tr:eq("+rIdx+")");

				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
        	}
        	else{
        		var cell  = tbl2.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
					dtTbl = tbl2.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ cusID  +'">' + cusName
				).draw();

				var crRow = tbl2.find("tbody tr:eq("+rIdx+")");

				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
        	}
		});

		/* Set data for Vessel modal */
		$("#VesselSearch").on('click', function(){
		    var formData;

		    formData = {
				'action': 		'view',
				'childAction': 	'loadVesselFilterList',
				'VBType': 		$("input[type='radio'][name='VesselFilter']:checked").val(),
				'VesselName':   $("#VesselNameFilter").val(),
				'Year': 		$("#YearFilter").val(),
			};			

		    $.ajax({
					url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_vesselColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "ETA":
									case "ETD":
										val = getDateTime(rData[colname]);
										break;
									default:
										val = rData[colname];
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}
					tblVessel.dataTable().fnClearTable();
			        if(rows.length > 0){
						tblVessel.dataTable().fnAddData(rows);
			        }
				},
				error: function(err){
					console.log(err);
				}
			});
		});

		/*
		$(document).on("change", "#contenttable tbody tr.addnew:last td:eq("+ _columns.indexOf("DateIn") +")",  function(){
			var data = tbl.find("tbody tr.addnew:last td:eq("+ _columns.indexOf("DateIn") +")").text();
			if (data.length <= 10)
				data += " 00:00:00";
			cell = tbl.find("tbody tr.addnew:last td:eq("+ _columns.indexOf("DateIn") +")");
			tbl.DataTable().cell(cell).data(data).draw(false);
		});

		$(document).on("change", "#contenttable tbody tr.addnew:last td:eq("+ _columns.indexOf("DateOut") +")",  function(){
			var data = tbl.find("tbody tr.addnew:last td:eq("+ _columns.indexOf("DateOut") +")").text();
			if (data.length <= 10)
				data += " 00:00:00";
			cell = tbl.find("tbody tr.addnew:last td:eq("+ _columns.indexOf("DateOut") +")");
			tbl.DataTable().cell(cell).data(data).draw(false);
		});
		*/

		$("#downloadFileForImport").on('click', function(){
			if ($("input[name='ClassID']:checked").val() == 1){
				var url = '<?=site_url(md5('Data') . '/' . md5('createXLSFormForStockImportForClassIn'));?>';
				window.location.href = url;
			}
			else{
				var url = '<?=site_url(md5('Data') . '/' . md5('createXLSFormForStockImportForClassOut'));?>';
				window.location.href = url;
			}
		});

		$("#Export").on('click', function(){
	    	if ($("input[name='ClassID']:checked").val() == 1){
	    		var url = "<?=site_url(md5('Data') . '/' . md5('createXLSForStockExportWithClassIn'));?>";
				window.location.href = url;
	    	}
	    	else{
	    		var url = "<?=site_url(md5('Data') . '/' . md5('createXLSForStockExportWithClassOut'));?>";
				window.location.href = url;
	    	}
	    });

	    $("#search").on("click", function(){
			/* Load data to datatable */
			// Get data input
			var btn 					= $(this),
				VoyageKey				= $("#VoyageKey").val(),
				VesselID 				= $("#VesselID").val(),
				InboundVoyage 			= $("#InboundVoyage").val(),
				OutboundVoyage			= $("#OutboundVoyage").val(),
				//VINNo					= $("#VINNo").val(),
				//BillOfLadingORBookingNo = $("#BillOfLadingORBookingNo").val(),
				IsLocalForeign			= $("input[name='IsLocalForeign']:checked").val(),
				ClassID					= $("input[name='ClassID']:checked").val();

			if (VoyageKey == ''){
				toastr['error']('Vui lòng chọn tàu trước khi load dữ liệu!');
				return;
			}

			var formData = {
				'action': 					'view',
				'VoyageKey': 				VoyageKey,
				//'VINNo': 					VINNo,
				//'BillOfLadingORBookingNo': 	BillOfLadingORBookingNo,
				'IsLocalForeign': 			IsLocalForeign,
				'ClassID': 					ClassID,
			};

			tbl.waitingLoad();
			btn.button('loading');

			$.ajax({
				url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
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
										val = i+1; 
										break;
									case "IsLocalForeign":
										if (rData[colname] == 1)
											val='<input class="hiden-input" value="1">' + "Hàng nội";
										else
											val='<input class="hiden-input" value="2">' + "Hàng ngoại";
										break;
									case "DateIn":
									case "DateOut":
										val = getDateTime( rData[colname] ) ;
										break;
									case "VMStatus":
										val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['VMStatusDesc'];
										break;
									case "ClassID":
										if (rData[colname] == 1)
											val='<input class="hiden-input" value="1">' + "Nhập";
										else
											val='<input class="hiden-input" value="2">' + "Xuất";
										break;
									case "POL":
										if (!rData[colname]){
											val = '';
										}
										else{
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['POLName'];
										}										
										break;
									case "POD":
										if (!rData[colname]){
											val = '';
										}
										else{
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['PODName'];
										}
										break;
									case "FPOD":
										if (!rData[colname]){
											val = '';
										}
										else{
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['FPODName'];
										}										
										break;
									case "TransitID":
										if (!rData[colname]){
											val = '';
										}
										else{
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'];
										}
										break;
									default:
										val = rData[colname];
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}
					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}
		        	btn.button('reset');
				},
				error: function(err){
					console.log(err);
					btn.button('reset');
				}
			});
		});

		$("#save").on("click", function(){
			if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
            	var newData 	= tbl.getAddNewData();

				for (i = 0; i < newData.length; i++){
					if (!newData[i]['VINNo']){
						toastr['error']("Vui lòng nhập số VIN!");
						return;
					}	
					
					if (!newData[i]['BillOfLading'] && !newData[i]['BookingNo']){
						toastr['error']("Vui lòng nhập Số vận đơn hoặc Số booking!");
						return;
					}

					if (!newData[i]['Sequence']){
						toastr['error']("Vui lòng nhập Sequence!");
						return;
					}

					if (!newData[i]['VINNo']){
						toastr['error']("Vui lòng nhập Số VIN!");
						return;
					}

					if (!newData[i]['VMStatus']){
						toastr['error']("Vui lòng chọn Tình trạng xe!");
						return;
					}


					if (!newData[i]['ClassID']){
						toastr['error']("Vui lòng chọn Nhập xuất/ tàu!");
						return;
					}

					if (!newData[i]['IsLocalForeign']){
						toastr['error']("Vui lòng chọn Hàng nội/ ngoại!");
						return;
					}
				}

            	$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Tất cả các thay đổi sẽ được lưu lại!\nTiếp tục?',
		            buttons: {
		                ok: {
		                    text: 'Xác nhận lưu',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
		                        saveData();
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
		});

		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		function saveData(){
            var newData 	= tbl.getAddNewData();

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData,
					'VoyageKey': $('#VoyageKey').val(),
					/*
					'dateIn': strDayIn.slice(6,10) + '-' + strDayIn.slice(3,5) + '-' + strDayIn.slice(0,2) + ' ' + strDayIn.slice(11,20),
					'dateOut': strDayOut.slice(6,10) + '-' + strDayOut.slice(3,5) + '-' + strDayOut.slice(0,2) + ' ' + strDayOut.slice(11,20),
					*/
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();


			if(editData.length > 0){				
				var fedit = {
					'action': 'edit',
					'data': editData,
					'VoyageKey': $('#VoyageKey').val(),
					/*
					'dateIn': strDayIn.slice(6,10) + '-' + strDayIn.slice(3,5) + '-' + strDayIn.slice(0,2) + ' ' + strDayIn.slice(11,20),
					'dateOut': strDayOut.slice(6,10) + '-' + strDayOut.slice(3,5) + '-' + strDayOut.slice(0,2) + ' ' + strDayOut.slice(11,20),
					*/
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
        	
			$.ajax({
                url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'edit'){
                    	if (formData.childAction == 'updateStockData'){
                    		return;
                    	}

                    	toastr["success"]("Cập nhật thành công!");
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                    	$('#search').trigger('click');                   	
                    	return;
                    }

                    if(formData.action == 'add'){
                    	if (formData.childAction != 'addJobQuay'){
                    		$('#search').trigger('click');	
                    		toastr["success"]("Thêm mới thành công!");
                    	}                    	
                    	else{	
                    		toastr["success"]("Lưu thành công dữ liệu vào QUAY JOB!");
                    		
                    		/* Stocket real-time */
							socket.emit('reloadJobQuay', 'reloadJobQuay');
                    	}
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		
		/* Delete event */
		$('#delete').on('click', function(){
			if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }
            else{
            	tbl.confirmDelete(function(data){
            		postDel(data);
            	});
            }
		});

		function postDel(data){
			var delData;

			if ($('input[type=radio][name=ClassID]:checked').val() == 1){
				delData = data.map( function( item ){
					var objDel = {
						"VoyageKey" 	: item[ _columns.indexOf( "VoyageKey" ) ],
						"BillOfLading" 	: item[ _columns.indexOf( "BillOfLading" ) ],
						"BookingNo" 	: '',
						"VINNo" 		: item[ _columns.indexOf( "VINNo" ) ],
					};
					return objDel;
				});
			}
			else{
				delData = data.map( function( item ){
					var objDel = {
						"VoyageKey" 	: item[ _columns.indexOf( "VoyageKey" ) ],
						"BillOfLading" 	: '',
						"BookingNo" 	: item[ _columns.indexOf( "BookingNo" ) ],
						"VINNo" 		: item[ _columns.indexOf( "VINNo" ) ],
					};
					return objDel;
				});
			}
			
			/*
			var VoyageKey = data.map(p=>p[_columns.indexOf("VoyageKey")]),
				BillOfLading = data.map(p=>p[_columns.indexOf("BillOfLading")]),
				BookingNo = data.map(p=>p[_columns.indexOf("BookingNo")]),
				VINNo = data.map(p=>p[_columns.indexOf("VINNo")]);
			*/

			var fdel = {
					'action': 'delete',
					'data': delData,
				};

			$.ajax({
                url: "<?=site_url(md5('Data') . '/' . md5('dtStock'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    tbl.DataTable().rows('.selected').remove().draw(false); // Delete row in table
                	tbl.updateSTT(_columns.indexOf("STT"));
               		toastr["success"]("Xóa dữ liệu thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$("#import").on("change", function(){
			var input = this;
			var url = $(this).val();

			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0] && (ext == "xlsx" || ext =="xls"))
			{	
				var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                    	// Check valid of Voyage Key
                    	if ($("#VoyageKey").val() == ''){
                    		toastr["error"]("Vui lòng chọn tàu trước khi import dữ liệu!");
                    		return;
                    	}

                    	ProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(input.files[0]);
                    //$("#chooseVessel").trigger('click');
                }
                else{
                	reader.onload = function (e) {
                		// Check valid of Voyage Key
                    	if ($("#VoyageKey").val() == ''){
                    		toastr["error"]("Vui lòng chọn tàu trước khi import dữ liệu!");
                    		return;
                    	}
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(input.files[0]);
                }
			}
			else
			{
				toastr['error']("Vui lòng chọn file đúng định dạng");				
			}

			$("#import").val("");
		});	

		function ProcessExcel(data) {
        	//Read the Excel File data.
	        var workbook = XLSX.read(data, { type: 'binary' });
	 
	        //Fetch the name of First Sheet.
	        var firstSheet = workbook.SheetNames[0];
	 
	        //Read all rows from First Sheet into an JSON array.
	        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

	        // Add data to stock table
			var rows = [],
				VoyageKey = $("#VoyageKey").val(),				
				listAddEdit = {};
			if(excelRows.length > 0) {
				for (i = 0; i < excelRows.length; i++) {
					var rData = excelRows[i], 
						r = [];

					if (!rData['Số VIN'])
						continue;

					listAddEdit[i] = 0;
					for (j = 0; j < stockList.length; j++){
							if (!rData['Số vận đơn']){
								if (!stockList[j]['BillOfLading'] && (stockList[j]['BookingNo'] == rData['Số booking']) && 
									(stockList[j]['VINNo'] == rData['Số VIN'])){
									listAddEdit[i] = 1;
									break;
								}
							}
							else{
								if (!rData['Số booking']){
									if (!stockList[j]['BookingNo'] && (stockList[j]['BillOfLading'] == rData['Số vận đơn']) && 
										(stockList[j]['VINNo'] == rData['Số VIN'])){
										listAddEdit[i] = 1;
										break;
									}
								}
								else{
									if ((stockList[j]['BookingNo'] == rData['Số booking']) && 
										(stockList[j]['BillOfLading'] == rData['Số vận đơn']) && 
										(stockList[j]['VINNo'] == rData['Số VIN'])){
										listAddEdit[i] = 1;
										break;
									}
								}
							}					
					}

					$.each(_columns, function(idx, colname){
						var val = "";
						switch(colname){
							case "VoyageKey":
								val = VoyageKey;
								break;
							case "ClassID":
								if (rData['Nhập/ xuất tàu (Nhập = 1, Xuất = 2)'] == "Nhập")
									val = '<input class="hiden-input" value="1">' + "Nhập";
								else
									val = '<input class="hiden-input" value="2">' + "Xuất";
								break;
							case "IsLocalForeign":
								if (rData['Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'] == "Nội")
									val = '<input class="hiden-input" value="1">' + "Nội";
								else
									val = '<input class="hiden-input" value="2">' + "Ngoại";
								break;
							case "BillOfLading":
								if (rData['Số vận đơn'])
									val = rData['Số vận đơn']
								else
									val = '';
								break;
							case "BookingNo":
								if (rData['Số booking'])
									val = rData['Số booking']
								else
									val = '';
								break;
							case "VINNo":
								val = rData['Số VIN'];
								break;
							case "DateIn":
								val = rData['Ngày vào (theo định dạng dd/mm/yyyy)'];
								break;
							case "JobModeInID":
								val = rData['Mã phương án vào (xem ở cột AG - AI)'];
								break;
							case "MethodInID":
								val = rData['Mã phương thức vào (xem ở cột AK - AM)'];
								break;
							case "DateOut":
								val = rData['Ngày ra (theo định dạng dd/mm/yyyy)'];
								break;
							case "JobModeOutID":
								val = rData['Mã phương án ra (xem ở cột AG - AI)'];
								break;
							case "MethodOutID":
								val = rData['Mã phương thức ra (xem ở cột AK - AM)'];
								break;
							case "InvNo":
								val = rData['Số hóa đơn'];
								break;
							case "EirNo":
								val = rData['Số lệnh giao nhận'];
								break;
							case "OrderNo":
								val = rData['Số lệnh dịch vụ'];
								break;
							case "PinCode":
								val = rData['Mã pin'];
								break;
							case "CusID":
								val = rData['Mã khách hàng (xem ở cột AO - AQ)'];
								break;
							case "POL":
								val = rData['Mã cảng xếp (xem ở cột AS - AU)'];
								break;
							case "POD":
								val = rData['Mã cảng dở (xem ở cột AS - AU)'];
								break;
							case "FPOD":
								val = rData['Mã cảng đích (xem ở cột AS - AU)'];
								break;
							case "TransitID":
								val = rData['Transit ID'];
								break;
							case "VMStatus":
								if (rData['Tình trạng xe'] == 'B')
									val='<input class="hiden-input" value="B">' + "Trên tàu";
								else if (rData['Tình trạng xe'] == 'I')
									val='<input class="hiden-input" value="I">' + "Đang vào bãi";
								else if (rData['Tình trạng xe'] == 'S')
									val='<input class="hiden-input" value="S">' + "Trên bãi";
								else if (rData['Tình trạng xe'] == 'O')
									val='<input class="hiden-input" value="O">' + "Đang ra bãi";
								else if (rData['Tình trạng xe'] == 'D')
									val='<input class="hiden-input" value="D">' + "Đã ra bãi";
								break;
							default:
								val = rData[colname];
								break;								
						}
						r.push(val);
					});
					rows.push(r);	
				}
			}
			tbl.dataTable().fnClearTable();
			if(rows.length > 0){
				tbl.dataTable().fnAddData(rows);
			}

			for (i = 0; i < excelRows.length; i++){
				crRow = tbl.find("tbody tr:eq("+i+")");
				if (listAddEdit[i] == 0)
					tbl.DataTable().rows(crRow).nodes().to$().addClass("addnew")
				else
					tbl.DataTable().rows(crRow).nodes().to$().addClass("editing");
			}
	    };	

	    socket.on('updateStockFromYard', function(data){
	    	data = JSON.parse(data);
console.log(data);
	    	var rowguid = data[0]['rowguid'], 
	    		VMStatus = data[0]['VMStatus'],
	    		Block   = data[0]['Block'],
	    		Bay	   	= data[0]['Bay'],
	    		Row   	= data[0]['Row'],
	    		Tier   	= data[0]['Tier'],
	    		DateIn  = data[0]['DateIn'],
                index   = tbl.filterRowIndexes( _columns.indexOf( "rowguid" ), rowguid),
                row     = parseInt(tbl.DataTable().rows(index).data()['selector'].rows[0]),
                colVMStatus = _columns.indexOf('VMStatus'),
                colBlock 	= _columns.indexOf('Block'),
                colBay 		= _columns.indexOf('Bay'),
                colRow 		= _columns.indexOf('Row'),
                colTier 	= _columns.indexOf('Tier'),
                colDateIn 	= _columns.indexOf('DateIn'),
                cellVMStatus = tbl.find("tbody tr:eq(" + row + ") td:eq("+ colVMStatus +")"),
                cellBlock 	= tbl.find("tbody tr:eq(" + row + ") td:eq("+ colBlock +")"),
                cellBay		= tbl.find("tbody tr:eq(" + row + ") td:eq("+ colBay +")"),
                cellRow		= tbl.find("tbody tr:eq(" + row + ") td:eq("+ colRow +")"),
                cellTier	= tbl.find("tbody tr:eq(" + row + ") td:eq("+ colTier +")");
                cellDateIn	= tbl.find("tbody tr:eq(" + row + ") td:eq("+ colDateIn +")"),
                value = '';

            if (row >= 0){
            	if (VMStatus == 'S'){
            		value = '<input class="hiden-input" value="S">Trên bãi';	
            	}
                tbl.DataTable().cell(cellVMStatus).data(value).draw(false);

                tbl.DataTable().cell(cellBlock).data(Block).draw(false);
                tbl.DataTable().cell(cellBay).data(Bay).draw(false);
                tbl.DataTable().cell(cellRow).data(Row).draw(false);
                tbl.DataTable().cell(cellTier).data(Tier).draw(false);
                tbl.DataTable().cell(cellDateIn).data(DateIn).draw(false);
            }      
	    });
	});	
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
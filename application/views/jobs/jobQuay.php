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
	.ibox .ibox-body{
		padding-top: 0.5rem!important;
	    padding-bottom: 0.5rem!important;
	    padding-left: 2rem!important;
	    padding-right: 2rem!important;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">TẬP HỢP THU SAU - XẾP DỠ HÀNG VỚI TÀU</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl-0 pr-0">
						<div class="ibox-body pt-3 pb-3 bg-f9">
							<div class="row ibox mb-0 border-e">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row form-group mt-2 ml-2">
										<div class="col-6" style="padding-left: 0!important">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="row">
													<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
														<label class="checkbox checkbox-grey checkbox-success" style="margin-top: 0.25rem">
				                                            <input type="checkbox" checked="">
				                                            <span class="input-span"></span>Định kỳ
				                                        </label>
				                                    </div>
				                                    <div class="col-lg-4 col-md-5 col-sm-5 col-xs-5">
				                                        <input id="" placeholder="Từ ngày" type="text" style="border-radius: 5px; margin-left: 1rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem">
				                                    </div>
				                                    <div class="col-1">
				                                        <label style="margin-left: 0.5rem"> ~ </label>
				                                    </div>
				                                     <div class="col-lg-4 col-md-5 col-sm-5 col-xs-5">
				                                        <input id="" placeholder="Đến ngày" type="text" style="border-radius: 5px; margin-left: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem">
				                                    </div>
												</div>
												<div class="row">
													<label class="radio radio-outline-success mt-3">
			                                            <input type="radio" name="vessel" checked="">
			                                            <span class="input-span"></span>Tàu đến cảng
		                                        	</label>
												</div>
		                                      	<div class="row">
			                                        <label class="radio radio-outline-success mt-3">
			                                            <input type="radio" name="vessel">
			                                            <span class="input-span"></span>Tàu rời cảng
			                                        </label>
			                                    </div>
			                                    <div class="row">
			                                    	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
			                                    		<label style="margin-top: 0.9rem;">Chủ hàng</label> 
			                                    		<input id='' placeholder="Chủ hàng" style="border-radius: 5px; margin-right: 0.2rem; margin-top: 0.75rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 11rem" type="text">                                   		
			                                    	</div>
			                                    	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
			                                    		<label class="checkbox checkbox-grey checkbox-warning" style="margin-top: 0.25rem; margin-left: 0.5rem;">
							                                <input type="checkbox" checked="">
							                                    <span class="input-span"></span>Optimize
							                            </label>

							                            <label class="radio radio-outline-warning mt-3 ml-3">
						                                    <input type="radio" name="x" checked>
						                                    <span class="input-span"></span>H.ngoại
						                                </label>

						                                <label class="radio radio-outline-warning mt-3 ml-3">
						                                    <input type="radio" name="x">
						                                    <span class="input-span"></span>H.nội
						                                </label>
			                                    	</div>
			                                    </div>
		                                    </div>
	                                    </div>
	                                   	<div class="col-6">
		                                   		<div style="border: #0b4660 solid 1px; border-radius: 5px;">
		                                   			<div style="margin: 0; background-color: #0b4660; text-align: center;	">
		                                   				<label style="color: #ffffff; margin-top: 0.25rem"><b>MAX SLOTS</b></label><br>
		                                   			</div>	
		                                   			<label style="margin-left: 0.5rem; width: 6rem;">Hãng khai thác</label>
		                                   			<select id="OprID" title="Hãng khai thác" style="border-radius: 5px; margin-left: 0.25rem; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; width: 10rem" type="text">
														<?php if(count($oprList) > 0){?>
															<?php foreach($oprList as $item) {  ?>
																<option value="<?=$item['OprID']?>"><?=$item['OprName'];?></option>
															<?php } ?>
														<?php } ?>
													</select><br>
	                                   				<label style="margin-left: 0.5rem; width: 6rem;">Phương án</label>
		                                   			<select id="JobModeID" title="Phương án" style="border-radius: 5px; margin-left: 0.25rem; margin-right: 0.75rem; margin-top: 0.5rem; margin-bottom: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; width: 10rem" type="text">
														<?php if(count($jobModeList) > 0){?>
															<?php foreach($jobModeList as $item) {  ?>
																<option value="<?=$item['JobModeID']?>"><?=$item['JobModeName'];?></option>
															<?php } ?>
														<?php } ?>
													</select>
		                                   		    <label style="margin-left: 0.5rem; width: 4rem;">Công việc</label>
		                                   		    <input id="" placeholder="Công việc" style="border-radius: 5px; margin-left: 0.25rem; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; width: 10rem" type="text">	
		                                   		</div>
	                                   	</div>
                                    </div>
                                   	<div class="row form-group ml-2">                                    	
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Phương thức</label>
                                    		<select id="MethodID" title="-- Chọn phương thức --" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 11rem" type="text">
												<?php if(count($methodList) > 0){?>
													<?php foreach($methodList as $item) {  ?>
														<option value="<?=$item['MethodID']?>"><?=$item['MethodName'];?></option>
													<?php } ?>
												<?php } ?>
											</select>
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Hướng nhập xuất</label>
                                    		<select id="ClassID" title="-- Chọn phương thức --" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 9.5rem;" type="text">
                                    			<?php if(count($classList) > 0){?>
													<?php foreach($classList as $item) {  ?>
														<option value="<?=$item['ClassID']?>"><?=$item['ClassName'];?></option>
													<?php } ?>
												<?php } ?>
											</select>
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Loại ĐTTT</label>
                                    		<input id='CusTypeName' placeholder="Loại ĐTTT" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 10rem" type="text">
                                    		<input id='CusTypeID' hidden>                                    		
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">ĐTTT</label>
                                    		<input id='CusName' placeholder="Đối tượng thanh toán" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 11rem" type="text">
                                    		<input id='CusID' hidden>
                                    	</div>
                                    </div>
                                    <div class="row form-group ml-2">
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Mã số thuế</label>
                                    		<input id='' placeholder="Mã số thuế" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 11rem" type="text">
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Số booking</label>
                                    		<input id='' placeholder="Số booking" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 9.5rem" type="text">
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">
                                    		<label style="margin-top: 0.5rem;">Cảng giao nhận</label>
                                    		<select id="" title="Cảng giao nhận" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 10rem" type="text">
												<?php if(count($portList) > 0){?>
													<?php foreach($portList as $item) {  ?>
														<option value="<?=$item['PortID']?>"><?=$item['PortName'];?></option>
													<?php } ?>
												<?php } ?>
											</select>
                                    	</div>
                                    	<div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" style="padding-left: 0!important">             
                                    		<label style="margin-top: 0.5rem;">Chuyển cảng</label>
                                    		<select id="" title="Cảng giao nhận" style="border-radius: 5px; margin-right: 0.75rem; margin-top: 0.5rem; padding-left: 10px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 1.75rem; float: right; width: 11rem" type="text">
												<?php if(count($portList) > 0){?>
													<?php foreach($portList as $item) {  ?>
														<option value="<?=$item['PortID']?>"><?=$item['PortName'];?></option>
													<?php } ?>
												<?php } ?>
											</select>
                                    	</div>
                                    </div>
								</div>
							</div>
						</div>
					</div>		
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-6 col-sm-6 col-xs-6 table-responsive">
					<label>Danh sách xe</label>
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid"></th>
							<th col-name="" class="editor-cancel data-type-checkbox">Xác nhận</th>
							<th col-name="">Số VIN</th>
							<th col-name="">Mã hãng</th>
							<th col-name="">Loại xe</th>
							<th col-name="">Loại động cơ</th>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<div class="table-responsive">
						<label>Thống kê</label>
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
							<thead>
							<tr>
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="rowguid"></th>
								<th col-name="" class="editor-cancel data-type-checkbox">Xác nhận</th>
								<th col-name="">Số VIN</th>
								<th col-name="">Mã hãng</th>
								<th col-name="">Loại xe</th>
								<th col-name="">Loại động cơ</th>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<label>Chi tiết số liệu</label>						
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
							<thead>
							<tr>
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="rowguid"></th>
								<th col-name="" class="editor-cancel data-type-checkbox">Xác nhận</th>
								<th col-name="">Số VIN</th>
								<th col-name="">Mã hãng</th>
								<th col-name="">Loại xe</th>
								<th col-name="">Loại động cơ</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		var _customerColumns 	= ["STT", "CusID", "CusName", "Address","CusTypeID", "CusTypeName", "PaymentTypeID", "PaymentTypeName"],
			tblCustomer			= $("#tblCustomer"),
			customerList 		= {},
			customerModal 		= $("#customer-modal");

		/* Load data for Customer list */
		<?php if(isset($customerList) && count($customerList) >= 0){?>
			customerList = <?= json_encode($customerList);?>;
		<?php } ?>	

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

		$("#CusName").on('click', function(){
			customerModal.modal('show');
		});

		$("#apply-customer").on("click", function(){
			var customerData 	= tblCustomer.getSelectedRows().data().toArray()[0],
				CusID 			= customerData[_customerColumns.indexOf('CusID')],
				CusName			= customerData[_customerColumns.indexOf('CusName')],
				CusTypeID		= customerData[_customerColumns.indexOf('CusTypeID')],
				CusTypeName		= customerData[_customerColumns.indexOf('CusTypeName')];
			
			$("#CusID").val(CusID);
			$("#CusName").val(CusName);
			$("#CusTypeID").val(CusTypeID);
			$("#CusTypeName").val(CusTypeName);
		});

		tblCustomer.find("tbody tr").on("dblclick", function(){
			var	CusID  			= $(this).find("td:eq("+_customerColumns.indexOf("CusID")+")").text(),
				CusName 	 	= $(this).find("td:eq("+_customerColumns.indexOf("CusName")+")").text(),
				CusTypeID 	 	= $(this).find("td:eq("+_customerColumns.indexOf("CusTypeID")+")").text(),
				CusTypeName 	= $(this).find("td:eq("+_customerColumns.indexOf("CusTypeName")+")").text();

			$("#CusID").val(CusID);
			$("#CusName").val(CusName);
			$("#CusTypeID").val(CusTypeID);
			$("#CusTypeName").val(CusTypeName);
			
			customerModal.modal("hide");
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
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
	#contenttable_wrapper .dataTables_scroll #cell-context .dropdown-menu  .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">QUẢN LÝ NGƯỜI DÙNG</div>
				<div class="button-bar-group mr-3">
					<button id="change_password" class="btn btn-outline-warning btn-sm mr-1" 
										title="Đổi mật khẩu">
						<span class="btn-icon"><i class="la la-key"></i>Đổi mật khẩu</span>
					</button>

					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm dòng">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
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
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="UserID">Mã người dùng</th>
							<th col-name="Pwd">Mật khẩu</th>
							<th col-name="FullName">Họ và tên</th>
							<th col-name="Email">Email</th>
							<th col-name="Tel">Số điện thoại</th>
							<th col-name="PersonalID">Số CMND</th>
							<th col-name="CusID">Mã khách hàng</th>
							<th col-name="CusName">Tên khách hàng</th>
							<th col-name="Address">Địa chỉ</th>
							<th col-name="BirthDay" class="data-type-date">Ngày sinh</th>
							<th col-name="GroupID">Nhóm người dùng</th>
							<th col-name="IsActive" class="editor-cancel data-type-checkbox">Trạng thái</th>
						</tr>
						</thead>
						<tbody>
							<?php if(count($sysUsersList) > 0) {
								  		$i = 1; ?>
								<?php foreach($sysUsersList as $item){  ?>									
									<tr>
										<td col-name="STT"><?=$i;?></td>
										<td col-name="UserID"><?=$item['UserID'];?></td>
										<td col-name="Pwd">
											<input class="hiden-input" value="<?=$item['Pwd'];?>">******
										</td>
										<td col-name="FullName"><?=$item['FullName'];?></td>			
										<td col-name="Email"><?=$item['Email'];?></td>			
										<td col-name="Tel"><?=$item['Tel'];?></td>			
										<td col-name="PersonalID"><?=$item['PersonalID'];?></td>			
										<td col-name="CusID"><?=$item['CusID'];?></td>			
										<td col-name="CusName"><?=$item['CusName'];?></td>			
										<td col-name="Address"><?=$item['Address'];?></td>			
										<td col-name="BirthDay" class="BirthDay"><?=$item['BirthDay'];?></td>			
										<td col-name="GroupID">											
											<input class="hiden-input" value="<?=$item['GroupID'];?>"><?=$item['GroupName'];?>		
										</td>			
										<td col-name="IsActive">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsActive'] == 1 ? "checked" : ""?>>
											<span class="input-span"></span></label>
										</td>						
									</tr>
									<?php $i++; }  ?>
							<?php } ?>			
						</tbody>
					</table>
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

<!-- Customer modal-->
<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-2" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 4em;">
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
	
<!-- Drop down list -->
<div id="cell-context" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<!-- Change passwork modal --> 
<div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
	<div class="modal-dialog" role="document" style="width: 512px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<label class="col-md-5 col-sm-5 col-xs-5 col-form-label" style="text-align: right;">Mật khẩu cũ (*)</label>
						<input id="beforePassword" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Mật khẩu cũ" type="text">
					</div>
					<div class="row form-group">
						<label class="col-md-5 col-sm-5 col-xs-5 col-form-label" style="text-align: right;">Mật khẩu mới (*)</label>
						<input id="newPassword" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Mật khẩu mới" type="text">
					</div>
					<div class="row form-group">
						<label class="col-md-5 col-sm-5 col-xs-5 col-form-label" style="text-align: right;	">Xác nhận mật khẩu (*)</label>
						<input id="confirmNewPassword" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Xác nhận mật khẩu mới" type="text">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-change-password">
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
		var _columns 			= ["STT", "UserID", "Pwd", "FullName", "Email", "Tel", "PersonalID", "CusID", "CusName", "Address", "BirthDay", "GroupID", "IsActive"],
			_customerColumns 	= ["STT", "CusID", "CusName"],
			tbl 	 			= $("#contenttable"),
			tblCustomer			= $("#tblCustomer"),
			changePassWordModal = $("#change-password-modal"),
			customerModal   	= $('#customer-modal'),
			customerList 		= {},
			sysUsersList 		= {},
			parentMenuList 		= {},
			sysGroupsList 		= {};

		<?php if(isset($sysUsersList) && count($sysUsersList) >= 0){?>
			sysUsersList = <?=json_encode($sysUsersList);?>;
		<?php } ?>

		<?php if(isset($sysGroupsList) && count($sysGroupsList) >= 0){?>
			sysGroupsList = <?=json_encode($sysGroupsList);?>;
		<?php } ?>

		<?php if(isset($customerList) && count($customerList) >= 0){?>
			customerList = <?=json_encode($customerList);?>;
		<?php } ?>

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Users_Management'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}
		
		$('.BirthDay').each((key, val) => {
			let text = $(val).text();
			$(val).text(getDate(text));
		});

		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		var dataTbl = tbl.newDataTable({
			scrollY: '50vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", targets: _columns.getIndexs(["UserID", "Pwd", "FullName", "Email", "Tel", "PersonalID", "CusID", "CusName", "Address", "BirthDay", "GroupID", "IsActive"])},
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
		tbl.editableTableWidget();

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		/* Initial customer table */
		var dataTbl2 = tblCustomer.newDataTable({
			scrollY: '40vh',
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
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false,
            arrayColumns: _customerColumns,
		});

		/* Add new row event */
		var numCount = 0;		
		$('#addrow').on('click', function(){
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
			}
		});

		$("#add-row-modal").bind('keypress', function(e) {
       		if(e.which == 13){
	       		numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
	        	sumNumRows += numRows;
	        	if (numRows == 1){
	        		tbl.newRow();
	        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl.DataTable().cell(cell).data(i+1).draw(false);
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

		/* Save button event */
		$('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{

            	var newData = tbl.getAddNewData();

				for (i = 0; i < newData.length; i++){
					if (!newData[i]['UserID']){
						toastr['error']("Vui lòng nhập Mã người dùng!");
						return;
					}
					else{
						for (j = 0; j < sysUsersList.length; j++){
							if (newData[i]['UserID'] == sysUsersList[j]['UserID']){
								toastr['error']("Đã tồn tại Mã người dùng: " + newData[i]['UserID']);
								return;
							}
						}	
					}

					if (!newData[i]['Pwd']){	
						toastr['error']("Vui lòng nhập Mật khẩu cho Mã người dùng: " + newData['UserID']);
						return;
					}

					if (!newData[i]['GroupID']){
						toastr['error']("Vui lòng chọn Nhóm cho Mã người dùng: " + newData[i]['UserID'] + "!");
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


        /* Save functions */
        function saveData(){        	
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				for (i = 0; i < newData.length; i++){
					newData[i]['Pwd'] = xMD5(xMD5('CEH_hZWEzNzc45622NjdiOA==') + xMD5(newData[i]['Pwd']));
					newData[i]['BirthDay'] = getSQLDateTimeFormat(newData[i]['BirthDay']);
				}

				var fnew = {
					'action': 'add',
					'data': newData,
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();
			if(editData.length > 0){
				for (i = 0; i < editData.length; i++){
					editData[i]['Pwd'] = xMD5(xMD5('CEH_hZWEzNzc45622NjdiOA==') + xMD5(editData[i]['Pwd']));
					editData[i]['BirthDay'] = getSQLDateTimeFormat(editData[i]['BirthDay']);
				}

				var fedit = {
					'action': 'edit',
					'data': editData,
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysUsers'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'edit'){
                    	toastr["success"]("Cập nhật thành công!");
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    }

                    saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox.collapsible-box').unblock(); 
                	console.log(err);
                }
            });
		}

		/* Delete rows */
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
			var delData = data.map(p=>p[_columns.indexOf("UserID")]);

			var fdel = {
					'action': 'delete',
					'data': delData
				};

			$.ajax({
                url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysUsers'));?>",
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
               		location.reload();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$("#change_password").on('click', function(){
			if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn người dùng cần thay đổi mật khẩu!");
            	return;
            }

			changePassWordModal.modal("show");

			$("#beforePassword").val('');
			$("#newPassword").val('');
			$("#confirmNewPassword").val('');
		});

		$("#apply-change-password").on('click', function(){
			var beforePassword 		= $("#beforePassword").val(),
				newPassword    		= $("#newPassword").val(),
				confirmNewPassword 	= $("#confirmNewPassword").val();

			if (beforePassword == ''){
				toastr['error']("Vui lòng nhập mật khẩu cũ!");
				return;
			}

			if (newPassword == ''){
				toastr['error']("Vui lòng nhập mật khẩu mới!");
				return;
			}

			if (confirmNewPassword == ''){
				toastr['error']("Vui lòng nhập Xác nhận mật khẩu!");
				return;
			}

			if (newPassword != confirmNewPassword){
				toastr['error']("Mật khẩu mới và xác nhận mật khẩu mới phải giống nhau!");
				return;
			}

			/* Get selected row data */
			var data = tbl.getSelectedData()[0];

			if (xMD5(xMD5('CEH_hZWEzNzc45622NjdiOA==') + xMD5(beforePassword)) == data[_columns.getIndexs("Pwd")]){
				newPassword = xMD5(xMD5('CEH_hZWEzNzc45622NjdiOA==') + xMD5(newPassword));

			}

			var fChangePassword = {
					'action': 'edit',
					'child_action': 'change_password',
					'id': data[_columns.getIndexs("UserID")],
					'pass': newPassword,
			};

			$.ajax({
                url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysUsers'));?>",
                dataType: 'json',
                data: fChangePassword,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    //tbl.DataTable().rows('.selected').remove().draw(false); // Delete row in table
                	//tbl.updateSTT(_columns.indexOf("STT"));
               		toastr["success"]("Thay đổi mật khẩu thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });

			/* Hide change password modal */
			changePassWordModal.modal("hide");
		});

		/* Set drop-down list for GroupID */
		tbl.setExtendDropdown({
			target: "#cell-context",
			source: sysGroupsList,
			colIndex: _columns.indexOf("GroupID"), 
			onSelected: function(cell, value){ 
				var groupName = sysGroupsList.filter( p => p.GroupID == value).map( x => x.GroupName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + groupName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});	

		/* Set modal for customer cell */
		tbl.setExtendSelect( _columns.indexOf("CusID"), function(rIdx, cIdx){
			$("#apply-customer").val(rIdx + "." + cIdx);
			customerModal.modal("show");
		});

		customerModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Select custom type id on table custom-type-table
		tblCustomer.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#apply-customer"),
				rIdx 	= applyBtn.val().split(".")[0],
				cIdx 	= applyBtn.val().split(".")[1],
				cusID 	= $(this).find("td:eq("+_customerColumns.indexOf("CusID")+")").text(),
				cusName = $(this).find("td:eq("+_customerColumns.indexOf("CusName")+")").text(),
				cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl 	= tbl.DataTable();
			dtTbl.cell(cell).data(cusID).draw(false);

			cIdx = _columns.getIndexs("CusName");
			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
			dtTbl.cell(cell).data(cusName).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			customerModal.modal("hide");
		});

		$("#apply-brand").on("click", function(){	// Click Accept
			var rIdx 	= $(this).val().split(".")[0],
				cIdx 	= $(this).val().split(".")[1],
				cusID 	= tblCusType.getSelectedRows().data().toArray()[0][_customerColumns.indexOf("CusID")],
				cusName = tblCusType.getSelectedRows().data().toArray()[0][_customerColumns.indexOf("CusName")],
				cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl 	= tbl.DataTable();

			dtTbl.cell(cell).data(cusID).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.getIndexs("CusName") +")").first();
			dtTbl.cell(cell).data(cusName).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
	});

	xMD5 = function(s,raw,hexcase,chrsz) {
	        raw = raw || false;     
	        hexcase = hexcase || false;
	        chrsz = chrsz || 8;

	        function safe_add(x, y){
	                var lsw = (x & 0xFFFF) + (y & 0xFFFF);
	                var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
	                return (msw << 16) | (lsw & 0xFFFF);
	        }
	        function bit_rol(num, cnt){
	                return (num << cnt) | (num >>> (32 - cnt));
	        }
	        function md5_cmn(q, a, b, x, s, t){
	                return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
	        }
	        function md5_ff(a, b, c, d, x, s, t){
	                return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
	        }
	        function md5_gg(a, b, c, d, x, s, t){
	                return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
	        }
	        function md5_hh(a, b, c, d, x, s, t){
	                return md5_cmn(b ^ c ^ d, a, b, x, s, t);
	        }
	        function md5_ii(a, b, c, d, x, s, t){
	                return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
	        }

	        function core_md5(x, len){
	                x[len >> 5] |= 0x80 << ((len) % 32);
	                x[(((len + 64) >>> 9) << 4) + 14] = len;
	                var a =  1732584193;
	                var b = -271733879;
	                var c = -1732584194;
	                var d =  271733878;
	                for(var i = 0; i < x.length; i += 16){
	                        var olda = a;
	                        var oldb = b;
	                        var oldc = c;
	                        var oldd = d;
	                        a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
	                        d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
	                        c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
	                        b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
	                        a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
	                        d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
	                        c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
	                        b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
	                        a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
	                        d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
	                        c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
	                        b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
	                        a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
	                        d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
	                        c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
	                        b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);
	                        a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
	                        d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
	                        c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
	                        b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
	                        a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
	                        d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
	                        c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
	                        b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
	                        a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
	                        d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
	                        c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
	                        b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
	                        a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
	                        d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
	                        c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
	                        b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);
	                        a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
	                        d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
	                        c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
	                        b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
	                        a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
	                        d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
	                        c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
	                        b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
	                        a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
	                        d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
	                        c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
	                        b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
	                        a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
	                        d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
	                        c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
	                        b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);
	                        a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
	                        d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
	                        c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
	                        b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
	                        a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
	                        d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
	                        c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
	                        b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
	                        a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
	                        d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
	                        c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
	                        b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
	                        a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
	                        d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
	                        c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
	                        b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);
	                        a = safe_add(a, olda);
	                        b = safe_add(b, oldb);
	                        c = safe_add(c, oldc);
	                        d = safe_add(d, oldd);
	                }
	                return [a, b, c, d];
	        }
	        function str2binl(str){
	                var bin = [];
	                var mask = (1 << chrsz) - 1;
	                for(var i = 0; i < str.length * chrsz; i += chrsz) {
	                        bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (i%32);
	                }
	                return bin;
	        }
	        function binl2str(bin){
	                var str = "";
	                var mask = (1 << chrsz) - 1;
	                for(var i = 0; i < bin.length * 32; i += chrsz) {
	                        str += String.fromCharCode((bin[i>>5] >>> (i % 32)) & mask);
	                }
	                return str;
	        }

	        function binl2hex(binarray){
	                var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
	                var str = "";
	                for(var i = 0; i < binarray.length * 4; i++) {
	                        str += hex_tab.charAt((binarray[i>>2] >> ((i%4)*8+4)) & 0xF) + hex_tab.charAt((binarray[i>>2] >> ((i%4)*8  )) & 0xF);
	                }
	                return str;
	        }
	        return (raw ? binl2str(core_md5(str2binl(s), s.length * chrsz)) : binl2hex(core_md5(str2binl(s), s.length * chrsz))     
	    );
	};
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>


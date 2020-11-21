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
				<div class="ibox-title">PHÂN QUYỀN</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm dòng mới" disabled>
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>

					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>

					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dòng"
										title="Xóa những dòng đang chọn" disabled>
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Nhóm</label>
									<div class="col-md-8 col-sm-8 col-xs-8 input-group input-group-sm">
										<select id="GroupID" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="--  Chọn nhóm người dùng --">
											<?php if(count($sysGroupList) > 0) { ?>
												<?php foreach($sysGroupList as $item) {?>
														<option value="<?=$item['GroupID']?>"><?=$item['GroupName'];?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Người dùng</label>
									<div class="col-md-8 col-sm-8 col-xs-8">
										<!--
										<input id="UserID" class="form-control form-control-sm border-e" placeholder="-- Chọn người dùng --" type="text">
										-->
										<select id="UserID" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="-- Chọn người dùng --">
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Mục</label>
									<div class="col-md-8 col-sm-8 col-xs-8">
										<select id="Parent_MenuAct" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="-- Chọn mục --">	
											<?php if(count($sysMenuList) > 0) { ?>
												<?php foreach($sysMenuList as $item) {?>
													<?php if (!($item['ParentID'])){ ?>
														<option value="<?=$item['rowguid']?>"><?=$item['MenuName'];?></option>
													<?php }?>
												<?php }?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="MenuAct" class="editor-cancel">Chi tiết</th>
							<th col-name="CheckAll" class="editor-cancel data-type-checkbox">Tất cả</th>
							<th col-name="Insert" class="editor-cancel data-type-checkbox">Thêm</th>
							<th col-name="Edit" class="editor-cancel data-type-checkbox">Sửa</th>
							<th col-name="Delete" class="editor-cancel data-type-checkbox">Xóa</th>
						</tr>
						</thead>
						<tbody>
							<!--
							<?php if(count($sysMenuList) > 0) {
								$i = 1; ?>
								<?php foreach($sysMenuList as $item){  ?>
									<?php if ($item['ParentID']){ ?>									
										<tr>
											<td col-name="STT"><?=$i;?></td>
											<td col-name="Parent_MenuAct">
												<?php 
													switch ((substr($item['MenuAct'], 0, 2))) {
														case 'cm':
															echo("DANH MỤC");
															break;
														case 'vs':
															echo("TÀU");
															break;
														case 'dt':
															echo("NHẬP LIỆU");
															break;
														case 'tr':
															echo("HỢP ĐỒNG VÀ BIỂU CƯỚC");
															break;
														case 'um':
															echo("QUẢN LÝ NGƯỜI DÙNG");
															break;
													};
												?>	
											</td>
											<td col-name="MenuAct">
												<input class="hiden-input" value="<?=$item['MenuAct'];?>"><?=$item['MenuName'];?>
											</td>	
											<td col-name="All">
												<label class="checkbox checkbox-success">
													<input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span>
												</label>
											</td>	
											<td col-name="Insert">
												<label class="checkbox checkbox-success">
													<input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span>
												</label>
											</td>	
											<td col-name="Edit">
												<label class="checkbox checkbox-success">
													<input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span>
												</label>
											</td>	
											<td col-name="Delete">
												<label class="checkbox checkbox-success">
													<input id="isActiveChb" type="checkbox" value="0">
													<span class="input-span"></span>
												</label>
											</td>	
										</tr>
									<?php $i++; }  ?>
								<?php } ?>
							<?php } ?>	
							-->		
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Customer modal-->
<!--
<div class="modal fade" id="sys-users-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 4em;">
	<div class="modal-dialog" role="document" style="min-width: 800px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">DANH MỤC NGƯỜI DÙNG</h5>
			</div>
			<div class="modal-body">
				<table id="tblSysUsers" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="GroupID">Nhóm người dùng</th>
							<th col-name="UserID">Mã người dùng</th>
							<th col-name="FullName">Họ và tên</th>
							<th col-name="Email">Email</th>
							<th col-name="Tel">Số điện thoại</th>
							<th col-name="PersonalID">Số CMND</th>
							<th col-name="CusID">Mã khách hàng</th>
							<th col-name="CusName">Tên khách hàng</th>
							<th col-name="Address">Địa chỉ</th>
							<th col-name="BirthDay" class="data-type-date">Ngày sinh</th>							
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-sys-users" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>
-->

<script type="text/javascript">
	$(document).ready(function(){
		/*var sysUsersModal 	= $("#sys-users-modal"),
			tblSysUsers		= $("#tblSysUsers"),
			_sysUsesColumns = ["STT", "GroupID", "UserID", "FullName", "Email", "Tel", "PersonalID", "CusID", "CusName", "Address", "BirthDay"],*/
		var tbl 			= $("#contenttable"),
			_columns 		= ["STT", "MenuAct", "All", "Insert", "Edit", "Delete"],
			sysPermissionList = {},
			userList 		= {},
			parentMenuList 	= {},
			menuActList 	= {};


		/* Load data from Job-mode-table */
		<?php if(isset($sysMenuList) && count($sysMenuList) >= 0){?>
			sysMenuList = <?= json_encode($sysMenuList);?>;
		<?php } ?>

		<?php if(isset($sysPermissionList) && count($sysPermissionList) >= 0){?>
			sysPermissionList = <?= json_encode($sysPermissionList);?>;
		<?php } ?>

		<?php if(isset($userList) && count($userList) >= 0){?>
			userList = <?= json_encode($userList);?>;
		<?php } ?>

		<?php if(isset($menuActList) && count($menuActList) >= 0){?>
			menuActList = <?= json_encode($menuActList);?>;
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
		
		var dataTbl = tbl.newDataTable({
			scrollY: '50vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},		
				{ className: "text-center", targets: _columns.getIndexs(["MenuAct", "All", "Insert", "Edit", "Delete" ])},
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

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);

        	crCell = inp.closest('td');
        	crRow = inp.closest('tr');

        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");

        		if (crCell[0]["_DT_CellIndex"].column == _columns.indexOf('All')){
					var row 	= crCell[0]["_DT_CellIndex"].row,
						col 	= _columns.indexOf("Insert");

						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
		        		).draw(false);

		        		col 	= _columns.indexOf("Edit");
						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
		        		).draw(false);

		        		col 	= _columns.indexOf("Delete");
						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
		        		).draw(false);
				}
				else{
					if (crCell[0]["_DT_CellIndex"].column == _columns.indexOf('Insert')){ // Click Insert checkbox
						var row 		= crCell[0]["_DT_CellIndex"].row,
							colEdit		= _columns.indexOf("Edit"),
							colDelete	= _columns.indexOf("Delete"),
							colInsert   = _columns.indexOf("colInsert"),
							cellEdit    = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colEdit + ")").first(),
							cellDelete  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colDelete + ")").first(),
							compareString = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="1" checked="checked"><span class="input-span"></span></label>';

						if (cellEdit[0]["innerHTML"] == compareString && cellDelete[0]["innerHTML"] == compareString){
							col 	= _columns.indexOf("All");
							crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
			        		tbl.DataTable().cell(crCell).data(
			        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
			        		).draw(false);
						}
					}
					else{
						if (crCell[0]["_DT_CellIndex"].column == _columns.indexOf('Edit')){
							var row 		= crCell[0]["_DT_CellIndex"].row,
								colInsert   = _columns.indexOf("Insert"),
								colDelete	= _columns.indexOf("Delete"),
								cellInsert  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colInsert + ")").first(),
								cellDelete  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colDelete + ")").first(),
								compareString = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="1" checked="checked"><span class="input-span"></span></label>';

							if (cellInsert[0]["innerHTML"] == compareString && cellDelete[0]["innerHTML"] == compareString){
								col 	= _columns.indexOf("All");
								crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
				        		tbl.DataTable().cell(crCell).data(
				        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
				        		).draw(false);
							}
						}
						else{
							if (crCell[0]["_DT_CellIndex"].column == _columns.indexOf('Delete')){
								var row 		= crCell[0]["_DT_CellIndex"].row,
									colInsert   = _columns.indexOf("Insert"),
									colEdit		= _columns.indexOf("Edit"),
									cellInsert  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colInsert + ")").first(),
									cellEdit    = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colEdit + ")").first(),
									compareString = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="1" checked="checked"><span class="input-span"></span></label>';

								if (cellInsert[0]["innerHTML"] == compareString && cellEdit[0]["innerHTML"] == compareString){
									col 	= _columns.indexOf("All");
									crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
					        		tbl.DataTable().cell(crCell).data(
					        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" checked><span class="input-span"></span></label>'
					        		).draw(false);
								}
							}
						}
					}
				}
        	}
        	else{
        		inp.removeAttr("checked");
        		inp.val("0");

        		if (crCell[0]["_DT_CellIndex"].column == _columns.indexOf('All')){
					var row 	= crCell[0]["_DT_CellIndex"].row;
						col 	= _columns.indexOf("Insert");
						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox"><span class="input-span"></span></label>'
		        		).draw(false);

		        		col 	= _columns.indexOf("Edit");
						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox"><span class="input-span"></span></label>'
		        		).draw(false);

		        		col 	= _columns.indexOf("Delete");
						crCell  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + col + ")").first();
		        		tbl.DataTable().cell(crCell).data(
		        			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox"><span class="input-span"></span></label>'
		        		).draw(false);
				}
				else{
					var row 		= crCell[0]["_DT_CellIndex"].row, 
						colInsert	= _columns.indexOf("Insert"),
						colEdit     = _columns.indexOf("Edit"),
						colDelete   = _columns.indexOf("Delete"),
						colAll 		= _columns.indexOf("All"),
						cellInsert   = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colInsert + ")").first(),
						cellEdit    = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colEdit + ")").first(),
						cellDelete  = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colDelete + ")").first(),
						cellAll     = tbl.find("tbody tr:eq(" + (row) + ") td:eq(" + colAll + ")").first(),
						compareString1 = '<label class="checkbox checkbox-success"><input type="checkbox" value="0"><span class="input-span"></span></label>';
						
					if (((cellInsert[0]["innerHTML"] == compareString1) || (cellEdit[0]["innerHTML"] == compareString1) || (cellDelete[0]["innerHTML"] == compareString1))){
						tbl.DataTable().cell(cellAll).data(
			       			'<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox"><span class="input-span"></span></label>'
			       		).draw(false);
					}
				}
			}

        	var eTable = tbl.DataTable();
        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		$("#GroupID").on('change', function(){
			var GroupID	 = $("#GroupID").val(),
				formData = {
					'action': 'view',
					'child_action': 'load_user_list',
					'GroupID': GroupID,
				};

			//tblSysUsers.waitingLoad();
			$.ajax({
				url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					/*
					var rows = [];
					if (data.list.length > 0){
						for (i = 0; i < data.list.length; i++){
							var rData = data.list[i], r = [];
							$.each(_sysUsesColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "GroupID":
										val = rData['GroupName'];
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

					tblSysUsers.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblSysUsers.dataTable().fnAddData(rows);
		        	}
		        	*/	        	
		        	$('#UserID').empty();
		        	if (data.list.length > 0){
		        		for (i = 0; i < data.list.length; i++){
			        		var rData 		= data.list[i];
			        		$('#UserID').append("<option value='" + rData['UserID'] +"'> " + rData['FullName'] + "</option>");
			        		$('.selectpicker').selectpicker('refresh');
			        	}
		        	}
				},
				error: function(err){
					toastr['error'](err);
					console.log(err);

				},
			});

			if ($("#UserID").val() == ''){
				var dataList = [], currentL = 0;

				for (i = 0; i < userList.length; i++){	
					if (userList[i]['GroupID'] == $("#GroupID").val()){
						currentL++;
					}
				}

				for (j = 0; j < menuActList.length; j++){
					var countInsert = 0,
						countEdit 	= 0,
						countDelete = 0;

					for (i = 0; i < userList.length; i++){			
						for (k = 0; k < sysPermissionList.length; k++){
							if (sysPermissionList[k]['UserID'] == userList[i]['UserID'] &&
								sysPermissionList[k]['MenuAct'] == menuActList[j]['MenuAct'])
							{
								if (sysPermissionList[k]['PerDetail'] == 'Insert'){
									countInsert++;
									if (countInsert == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}
								
								if (sysPermissionList[k]['PerDetail'] == 'Edit'){
									countEdit++;
									if (countEdit == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}

								if (sysPermissionList[k]['PerDetail'] == 'Delete'){
									countDelete++;
									if (countDelete == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}			
							}
						}
					}					
				}
				var rowguid = $("#Parent_MenuAct").val();

				formData = {
					'action': 'view',
					'child_action': 'load_contenttable',
					'rowguid': rowguid,
				};

				var dataOfTable = {};

				$.ajax({
					url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if (data.list.length > 0){
							dataOfTable = data.list;
							for (i = 0; i < data.list.length; i++){
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;
										case "MenuAct":
											val = '<input class="hiden-input" value="'+ rData['MenuAct']  +'">' + rData['MenuName'];
											break;
										default:
											val = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
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

			        	var countCheck;
			        	for (j = 0; j < dataOfTable.length; j++){
			        		countCheck = 0;
			        		for (i = 0; i < dataList.length; i++){
								if (dataList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
									dataList[i]['GroupID'] == $("#GroupID").val())
								{

									var row 	= j,
										col 	= _columns.indexOf(dataList[i]['PerDetail']),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();

									countCheck++;	
								}
								if (countCheck == 3){
									var row 	= j,
										col 	= _columns.indexOf('All'),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();
									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();
									break;
								}
							}
						}
			        },
					error: function(err){
						toastr['error'](err);
						console.log(err);

					},
			    });
			}
			else{
				var rowguid = $("#Parent_MenuAct").val();

				formData = {
					'action': 'view',
					'child_action': 'load_contenttable',
					'rowguid': rowguid,
				};

				var dataOfTable = {};

				$.ajax({
					url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if (data.list.length > 0){
							dataOfTable = data.list;
							for (i = 0; i < data.list.length; i++){
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;
										case "MenuAct":
											val = '<input class="hiden-input" value="'+ rData['MenuAct']  +'">' + rData['MenuName'];
											break;
										default:
											val = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
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

			        	var countCheck;
			        	for (j = 0; j < dataOfTable.length; j++){
			        		countCheck = 0;
			        		for (i = 0; i < sysPermissionList.length; i++){
								if (sysPermissionList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
									sysPermissionList[i]['GroupID'] == $("#GroupID").val() 			&&
									sysPermissionList[i]['UserID']  == $("#UserID").val())
								{

									var row 	= j,
										col 	= _columns.indexOf(sysPermissionList[i]['PerDetail']),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();

									countCheck++;	
								}
								if (countCheck == 3){
									var row 	= j,
										col 	= _columns.indexOf('All'),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();
									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();
									break;
								}
							}
						}
					},
					error: function(err){
						toastr['error'](err);
						console.log(err);

					},
				});
			}
		});

		$("#UserID").on('click', function(){
			if (!($("#GroupID").val())){
				toastr['info']("Vui lòng chọn Nhóm người dùng!");
				return;
			}
		});

		$("#UserID").on('change', function(){
			if ($("#Parent_MenuAct").val() != ''){
				var rowguid = $("#Parent_MenuAct").val();

				formData = {
					'action': 'view',
					'child_action': 'load_contenttable',
					'rowguid': rowguid,
				};

				var dataOfTable = {};

				$.ajax({
					url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if (data.list.length > 0){
							dataOfTable = data.list;
							for (i = 0; i < data.list.length; i++){
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;
										case "MenuAct":
											val = '<input class="hiden-input" value="'+ rData['MenuAct']  +'">' + rData['MenuName'];
											break;
										default:
											val = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
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

			        	var countCheck;
			        	for (j = 0; j < dataOfTable.length; j++){
			        		countCheck = 0;
			        		for (i = 0; i < sysPermissionList.length; i++){
								if (sysPermissionList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
									sysPermissionList[i]['GroupID'] == $("#GroupID").val() 			&&
									(sysPermissionList[i]['UserID']  == $("#UserID").val() || $("#UserID").val() == ''))
								{

									var row 	= j,
										col 	= _columns.indexOf(sysPermissionList[i]['PerDetail']),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();

									countCheck++;	
								}
								if (countCheck == 3){
									var row 	= j,
										col 	= _columns.indexOf('All'),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();
									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();
									break;
								}
							}
						}
					},
					error: function(err){
						toastr['error'](err);
						console.log(err);

					},
				});
			}
		});

		$("#Parent_MenuAct").on('change', function(){	
			if ($("#GroupID").val() == ''){
				toastr['error']("Vui lòng chọn Nhóm người dùng");
				$("#Parent_MenuAct").val('');
				return;
			}

			if ($("#UserID").val() == ''){
				var dataList = [], currentL = 0;

				for (i = 0; i < userList.length; i++){	
					if (userList[i]['GroupID'] == $("#GroupID").val()){
						currentL++;
					}
				}

				for (j = 0; j < menuActList.length; j++){
					var countInsert = 0,
						countEdit 	= 0,
						countDelete = 0;

					for (i = 0; i < userList.length; i++){			
						for (k = 0; k < sysPermissionList.length; k++){
							if (sysPermissionList[k]['UserID'] == userList[i]['UserID'] &&
								sysPermissionList[k]['MenuAct'] == menuActList[j]['MenuAct'])
							{
								if (sysPermissionList[k]['PerDetail'] == 'Insert'){
									countInsert++;
									if (countInsert == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}
								
								if (sysPermissionList[k]['PerDetail'] == 'Edit'){
									countEdit++;
									if (countEdit == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}

								if (sysPermissionList[k]['PerDetail'] == 'Delete'){
									countDelete++;
									if (countDelete == currentL){
										dataList.push(sysPermissionList[k]);
									}
								}			
							}
						}
					}					
				}
				var rowguid = this.value;

				formData = {
					'action': 'view',
					'child_action': 'load_contenttable',
					'rowguid': rowguid,
				};

				var dataOfTable = {};

				$.ajax({
					url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if (data.list.length > 0){
							dataOfTable = data.list;
							for (i = 0; i < data.list.length; i++){
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;
										case "MenuAct":
											val = '<input class="hiden-input" value="'+ rData['MenuAct']  +'">' + rData['MenuName'];
											break;
										default:
											val = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
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

			        	var countCheck;
			        	for (j = 0; j < dataOfTable.length; j++){
			        		countCheck = 0;
			        		for (i = 0; i < dataList.length; i++){
								if (dataList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
									dataList[i]['GroupID'] == $("#GroupID").val())
								{

									var row 	= j,
										col 	= _columns.indexOf(dataList[i]['PerDetail']),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();

									countCheck++;	
								}
								if (countCheck == 3){
									var row 	= j,
										col 	= _columns.indexOf('All'),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();
									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();
									break;
								}
							}
						}
			        },
					error: function(err){
						toastr['error'](err);
						console.log(err);

					},
			    });
			}
			else{
				var rowguid = this.value;

				formData = {
					'action': 'view',
					'child_action': 'load_contenttable',
					'rowguid': rowguid,
				};

				var dataOfTable = {};

				$.ajax({
					url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						var rows = [];
						if (data.list.length > 0){
							dataOfTable = data.list;
							for (i = 0; i < data.list.length; i++){
								var rData = data.list[i], r = [];
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;
										case "MenuAct":
											val = '<input class="hiden-input" value="'+ rData['MenuAct']  +'">' + rData['MenuName'];
											break;
										default:
											val = '<label class="checkbox checkbox-success"><input id="isActiveChb" type="checkbox" value="0"><span class="input-span"></span></label>';
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

			        	var countCheck;
			        	for (j = 0; j < dataOfTable.length; j++){
			        		countCheck = 0;
			        		for (i = 0; i < sysPermissionList.length; i++){
								if (sysPermissionList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
									sysPermissionList[i]['GroupID'] == $("#GroupID").val() 			&&
									sysPermissionList[i]['UserID']  == $("#UserID").val())
								{

									var row 	= j,
										col 	= _columns.indexOf(sysPermissionList[i]['PerDetail']),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();

									countCheck++;	
								}
								if (countCheck == 3){
									var row 	= j,
										col 	= _columns.indexOf('All'),
										cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();
									tbl.DataTable().cell(cell).data(
										'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
									).draw();
									break;
								}
							}
						}
					},
					error: function(err){
						toastr['error'](err);
						console.log(err);

					},
				});
			}
		});

		/*
		sysUsersModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});
		
		$(document).on("dblclick", "#tblSysUsers tbody tr",  function(){
			var	userID 	= $(this).find("td:eq("+_sysUsesColumns.indexOf("UserID")+")").text();
			$("#UserID").val(userID);

			// Uncheck all checkbox
			$('input:checkbox').removeAttr('checked');

			var dataOfTable = tbl.getDataByColumns(_columns);
			for (i = 0; i < sysPermissionList.length; i++){
				for (j = 0; j < dataOfTable.length; j++){
					if (sysPermissionList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
						sysPermissionList[i]['GroupID'] == $("#GroupID").val() 			&&
						sysPermissionList[i]['UserID']  == userID)
					{
						var row 	= j,
							col 	= _columns.indexOf(sysPermissionList[i]['PerDetail']),
							cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

						tbl.DataTable().cell(cell).data(
							'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
						).draw(false);
					}
				} 
			}

			sysUsersModal.modal("hide");
		});
		
		$("#apply-sys-users").on("click", function(){	// Click Accept
			var	userID 	= tblSysUsers.getSelectedRows().data().toArray()[0][_sysUsesColumns.indexOf("UserID")];
			$("#UserID").val(userID);

			var dataOfTable = tbl.getDataByColumns(_columns);
			for (i = 0; i < sysPermissionList.length; i++){
				for (j = 0; j < dataOfTable.length; j++){
					if (sysPermissionList[i]['MenuAct'] == dataOfTable[j]['MenuAct'] 	&&
						sysPermissionList[i]['GroupID'] == $("#GroupID").val() 			&&
						sysPermissionList[i]['UserID']  == userID)
					{
						var row 	= j,
							col 	= _columns.indexOf(sysPermissionList[i]['PerDetail']),
							cell 	= tbl.find("tbody tr:eq("+ row +") td:eq("+ col + ")").first();

						tbl.DataTable().cell(cell).data(
							'<label class="checkbox checkbox-success"><input type="checkbox" checked><span class="input-span"></span></label>'
						).draw(false);
					}
				} 
			}
		});
		*/

		$("#save").on('click', function(){
			if ($("#GroupID").val() == ''){
				toastr['error']("Vui lòng chọn Nhóm người dùng!");
				return;
			}

			if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }
            else{         	
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

        function saveData(){        
			var editData 	= tbl.getEditData(),
				UserID 		= $("#UserID").val(),
				GroupID 	= $("#GroupID").val();

			currentUser = 0;
			uList = [];
			for (i = 0; i < userList.length; i++){
				if (userList[i]['GroupID'] == GroupID){
					currentUser++;
					uList.push(userList[i]['UserID']);
				}
			}
			
			var rData = [], deleteData = [];
			if(editData.length > 0){
				for (i = 0; i < editData.length; i++){
					/* Insert */
					if (editData[i]['Insert'] == 1){
						for (k = 0; k < uList.length; k++){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Insert',
								'UserID': uList[k],
							}
							rData.push(temp);
						}	
					}
					else{
						if (UserID != ''){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Insert',
							}
							deleteData.push(temp);
						}
						else{
							var countInsert = 0;
							for (j = 0; j < sysPermissionList.length; j++){
								if (sysPermissionList[j]['GroupID'] == GroupID && 
									sysPermissionList[j]['PerDetail'] == "Insert" &&
									sysPermissionList[j]['MenuAct'] == editData[i]['MenuAct'])
								{	
									countInsert++;
								}
							}
							if (countInsert == currentUser){
								var temp  = {
									'MenuAct': editData[i]['MenuAct'],
									'PerDetail': 'Insert',
								}
								deleteData.push(temp);
							}
						}
						
					}	

					/* Edit */
					if (editData[i]['Edit'] == 1){
						for (k = 0; k < uList.length; k++){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Edit',
								'UserID': uList[k],
							}
							rData.push(temp);
						}	
					}
					else{
						if (UserID != ''){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Edit',
							}
							deleteData.push(temp);
						}
						else{
							var countEdit = 0;
							for (j = 0; j < sysPermissionList.length; j++){
								if (sysPermissionList[j]['GroupID'] == GroupID && 
									sysPermissionList[j]['PerDetail'] == "Edit" &&
									sysPermissionList[j]['MenuAct'] == editData[i]['MenuAct'])
								{	
									countEdit++;
								}
							}
							
							if (countEdit == currentUser){
								var temp  = {
									'MenuAct': editData[i]['MenuAct'],
									'PerDetail': 'Edit',
								}
								deleteData.push(temp);
							}
						}
					}

					/* Delete */
					if (editData[i]['Delete'] == 1){
						for (k = 0; k < uList.length; k++){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Delete',
								'UserID': uList[k],
							}
							rData.push(temp);
						}	
					}
					else{
						if (UserID != ''){
							var temp  = {
								'MenuAct': editData[i]['MenuAct'],
								'PerDetail': 'Delete',
							}
							deleteData.push(temp);
						}
						else{
							var countDelete = 0;
							for (j = 0; j < sysPermissionList.length; j++){
								if (sysPermissionList[j]['GroupID'] == GroupID && 
									sysPermissionList[j]['PerDetail'] == "Delete" &&
									sysPermissionList[j]['MenuAct'] == editData[i]['MenuAct'])
								{	
									countDelete++;
								}
							}

							if (countDelete == currentUser){
								var temp  = {
									'MenuAct': editData[i]['MenuAct'],
									'PerDetail': 'Delete',
								}
								deleteData.push(temp);
							}
						}
						
					}
				}

				if (rData.length > 0){
					var fedit = {
						'action': 'edit',
						'GroupID': GroupID,
						'data': rData,
					};

					console.log(rData);
					postSave(fedit);
				}

				if (deleteData.length > 0){
					var fDel = {
						'action': 'delete',
						'GroupID': GroupID,
						'UserID': UserID,
						'data': deleteData,
					}
					postDel(fDel);
				}
			}
        }

        function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'edit'){
                    	toastr["success"]("Lưu thành công!");
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
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

		function postDel(formData){
			$.ajax({
                url: "<?=site_url(md5('Users_Management') . '/' . md5('umSysPermission'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
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
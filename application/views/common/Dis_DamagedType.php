
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	.hidden-filter{
		display: none;
	}
	.wrap-text{
		white-space: normal!important;
	}

	button[data-id="temp"] span.filter-option{
		padding-right: 15px;
	}

	#brand-modal .dataTables_filter
	{
		width: 200px;
	}
	#brand-modal .dataTables_filter input[type="search"]
	{
		width: 65%;
	}

	#brand-modal .dataTables_filter > label::after
	{
		right: 45px!important;
	}

	span.sub-text{
		font-size: 75%;
	    color: #bbb;
	    font-style: italic;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">LOẠI XE</div>
				<div class="button-bar-group">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" 
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th col-name="STT" style="width: 20px">STT</th>
								<th col-name="BrandID">Mã Hãng</th>
								<th col-name="CarTypeID">Mã Loại Xe</th>
								<th col-name="CarTypeName">Tên Loại Xe</th>
								<th col-name="EngineType">Loại Máy</th>
								<th col-name="CarYear">Năm sản xuất</th>
								<th col-name="CarColor">Màu Xe</th>
							</tr>
							</thead>
							<tbody>

							<?php if(count($carTypes) > 0) {$i = 1; ?>
								<?php foreach($carTypes as $item) {  ?>
									<tr>
										<td style="text-align: center"><?=$i;?></td>
										<td><?=$item['BrandID'];?></td>
										<td><?=$item['CarTypeID'];?></td>
										<td><?=$item['CarTypeName'];?></td>
										<td><?=$item['EngineType'];?></td>
										<td><?=$item['CarYear'];?></td>
										<td><?=$item['CarColor'];?></td>
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
</div>

<!--brand modal-->
<div class="modal fade" id="brand-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách hãng xe</h5>
			</div>
			<div class="modal-body">
				<table id="tblBrand" 	class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="BrandID">Mã Hãng</th>
							<th col-name="BrandName">Tên Hãng</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($brands) > 0) {$i = 1; ?>
						<?php foreach($brands as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['BrandID'];?></td>
								<td><?=$item['BrandName'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin:0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-brand" data-dismiss="modal">
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
		var _columns = ["STT", "BrandID", "CarTypeID", "CarTypeName"],
			_colBrand = ["STT", "BrandID", "BrandName"];

		var tbl = $('#contenttable'),
			tblBrand = $('#tblBrand'),
			brands = {},
			brandModal = $("#brand-modal");

		<?php if(isset($brands) && count($brands) > 0){ ?>
			brands = <?= json_encode(array_column($brands, "BrandID"));?>;
		<?php } ?>

		var dataTbl = tbl.DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") }
			],
			order: [[ _columns.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});

		var dataTblBrand = tblBrand.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "text-center", targets: _colBrand.indexOf("STT") }
			],
			order: [[ _colBrand.indexOf("STT"), 'asc' ]],
			paging: false,
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});

		//set autocomplete in car brand
		var tblHeader = tbl.parent().prev().find('table');
		tblHeader.find(' th:eq(' + _columns.indexOf( 'BrandID' ) + ') ').setSelectSource( brands );

		//set extension button choose car brand
		tbl.setExtendSelect( _columns.indexOf("BrandID"), function(rIdx, cIdx){
			$("#apply-brand").val(rIdx + "." + cIdx);
			brandModal.modal("show");
		});

		tbl.editableTableWidget();

//select car brand on table brand-table
		tblBrand.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-brand"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq("+_colBrand.indexOf("BrandID")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(cgType).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			brandModal.modal("hide");
		});

		$("#apply-brand").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				brandID = tblBrand.getSelectedRows().data().toArray()[0][_colBrand.indexOf("BrandID")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(brandID).draw();
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
//select car brand on table brand-table


		// adjust column in table when show modal
		$('#brand-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

        $('#addrow').on('click', function(){
            tbl.newRow();
        });

        $('#delete').on('click', function () {
        	if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(selectedData){
            		postDel(selectedData);
            	});
            }
        });

        $('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
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


        //save functions
        function saveData(){        	
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				var fedit = {
					'action': 'edit',
					'data': editData
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmCarType'));?>",
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

        function postDel(rows){
			$('.ibox.collapsible-box').blockUI();

			var delUnits = rows.map(p=>p[_columns.indexOf("CarTypeID")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': delUnits
			};
			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmCarType'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (data) {
					delBtn.button('reset');

	                if(data.error && data.error.length > 0){
	                	for (var i = 0; i < data.error.length; i++) {
	                		toastr["error"](data.error[i]);
	                	}
	                }

	                if(data.success && data.success.length > 0){
	                	for (var i = 0; i < data.success.length; i++) {
	                		var deletedBrandID = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "CarTypeID" ), deletedBrandID);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );
	                	}
	                }

					$('.ibox.collapsible-box').unblock();
				},
				error: function(err){
					delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();
					console.log(err);
				}
			});
		}
	});
</script>
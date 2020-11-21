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

	table.dataTable.tbl-services-style thead tr,
	table.dataTable.tbl-services-style td{
		background: none!important;
		border: 0 none !important;
		cursor: default!important;
	}

	table.dataTable.tbl-services-style thead tr th{
		border-bottom: 1px solid #fff!important;
	}
	table.dataTable.tbl-services-style tbody tr.selected{
		background-color: rgba(255,231,112,0.4)!important;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">CẤU HÌNH DỊCH VỤ ĐÍNH KÈM</div>
				<div class="button-bar-group mr-3">
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
				</div>
			</div>
			
			<div class="ibox-footer border-top-0 mt-3">
				<div class="row">
					<div class="col-sm-6">
						<div class="row form-group" style="margin-bottom: .45rem!important">
							<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Loại lệnh</label>
							<div class="col-md-9 col-sm-9 col-xs-9 input-group input-group-sm">
								<select id="service-type" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Danh sách lệnh">
									<option value="" selected>-- [Tất cả] --</option>
									<option value="isLoLo" >Nâng hạ</option>
									<option value="ischkCFS" >Đóng rút</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-services" class="table table-striped display nowrap tbl-services-style" cellspacing="0" style="width: 99.9%">
									<thead>
									<tr>
										<th class="editor-cancel" style="max-width: 30px">STT</th>
										<th class="editor-cancel" style="max-width: 150px">Mã</th>
										<th class="editor-cancel">Diễn giải</th>
									</tr>
									</thead>

									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
								<table id="tbl-attach-service" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
									<thead>
									<tr>
										<th class="editor-cancel data-type-checkbox" style="max-width: 30px">Chọn</th>
										<th class="editor-cancel" style="max-width: 150px">Mã dịch vụ</th>
										<th class="editor-status">Tên dịch vụ</th>
										<th class="editor-cancel data-type-checkbox">In</th>
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
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columnsServices = ["STT", "CJMode_CD", "CJModeName"];
		var _columnsAttach = ["Select", "CjMode_CD", "CJModeName", "chkPrint"];
		var _list = {};
		<?php if(isset($services) && count($services) > 0) {?>
			_list = <?=json_encode($services) ?>;
		<?php } ?>

		var _attachServices = {};
		<?php if(isset($attach_services) && count($attach_services) > 0) {?>
			_attachServices = <?=json_encode($attach_services) ?>;
		<?php } ?>

		var tblServices = $('#tbl-services'),
			tblAttach = $('#tbl-attach-service');

		var dataTblService = tblServices.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columnsServices.indexOf('STT') }
			],
			order: [[ _columnsServices.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:false,
            info:false,
            searching:false,
            autoFill: {
                focus: 'focus'
            },
            buttons:[],
            rowReorder: false,
            arrColumns: _columnsServices
		});

		var dataTblAttach = tblAttach.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ className:"text-center", targets: _columnsAttach.getIndexs(['Select', 'chkPrint']) }
			],
			order: [],
			paging: false,
            keys:true,
            info:false,
            autoFill: {
                focus: 'focus'
            },
            rowReorder: false,
            arrColumns: _columnsAttach
		});

		loadServicesData();

        $('#service-type').on('change', function(){
        	var colname = $(this).val();
        	loadServicesData(colname);
        });

        $('#save').on('click', function(){
        	var dt = tblAttach.DataTable().rows( '.editing' )
        								  .data()
        								  .toArray()
        								  // .filter(p=>$(p[0]).find("input").first().val() == "1")
        								  .map(function(x){
        								  	return {
        								  				"IsChecked": $(x[_columnsAttach.indexOf("Select")]).find("input").first().val()
	        								  			,"ORD_TYPE": tblServices.getSelectedData()[0][_columnsServices.indexOf("CJMode_CD")]
	        								  			,"CjMode_CD": x[_columnsAttach.indexOf("CjMode_CD")]
	        								  			,"chkPrint": $(x[_columnsAttach.indexOf("chkPrint")]).find("input").first().val() == "1" ? "Y" : "N"
        								  			}
        								  });

            if(dt.length == 0){
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
		                        saveData(dt);
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

        tblAttach.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val(1);
        	}else{
        		inp.removeAttr("checked");
        		inp.val("");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tblAttach.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	eTable.row(crRow).nodes().to$().addClass("editing");
        });

        tblServices.on('click', 'tr', function(e){
        	var tbl = $(this).closest('table').DataTable();
        	var dtRow = tbl.row($(this)).nodes().to$();
        	if(dtRow.hasClass("selected")){
        		return;
        	}

        	tbl.rows( '.selected' ).nodes().to$().removeClass( 'selected' );
        	dtRow.addClass("selected");
        	loadAttachData();
        });

        function saveData(data){
        	var formData = {
        		"action": "edit",
        		"data": data
        	};

			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox-footer').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServiceAddonConfig'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    toastr["success"]("Cập nhật thành công!");
                    tblAttach.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");

                    saveBtn.button('reset');
        			$('.ibox-footer').unblock();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox-footer').unblock();
                	console.log(err);
                }
            });
		}

        function loadServicesData(colname){
        	if (typeof colname === "undefined" || colname === null) {
				colname = '';
			}

        	var i = 0;
        	var data = colname == '' ? _list.filter(p=>p["isLoLo"] == 1 || p["ischkCFS"] == 1) : _list.filter(p=>p[colname] == 1);
        	var n = data.map(function(x){
        		i++;
        		return [i, x.CJMode_CD, x.CJModeName];
        	});
        	tblServices.dataTable().fnClearTable();
        	tblServices.dataTable().fnAddData(n);
        }

        function loadAttachData(){
        	var i = 0;
        	var jobmodeSelected = tblServices.getSelectedData();
        	if(!jobmodeSelected || jobmodeSelected.length == 0) return;
        	var	jmode = jobmodeSelected[0][_columnsServices.indexOf("CJMode_CD")],
        		checkedFilter = _attachServices.filter(p=>p["ORD_TYPE"] == jmode),
        		checkedDatas = checkedFilter.length > 0 ? checkedFilter.map(x=>x.CjMode_CD) : [];
        	
        	var data = _list.filter(p=>p["isYardSRV"] == 1);
        	var n = data.map(function(x){
        		i++;
        		var isCheck = checkedDatas.indexOf(x.CJMode_CD) != -1 ? "checked" : "";
        		var isPrint = "";
        		if(isCheck == "checked"){
        			var temp = checkedFilter.filter(n=>n["CjMode_CD"] == x.CJMode_CD);
        			if(temp.length > 0){
        				isPrint = temp[0]["chkPrint"] == "Y" ? "checked" : "";
        			}
        		}

        		return [ 
	        				(isCheck == "checked" ? 1 : 0)
	        				,'<label class="checkbox checkbox-primary"><input type="checkbox" '+isCheck+' value="'+(isCheck=="checked"?1:0)+'"><span class="input-span"></span></label>'
	        				, x.CJMode_CD
	        				, x.CJModeName
	        				, '<label class="checkbox checkbox-primary"><input type="checkbox" '+isPrint+' value="'+(isPrint=="checked"?1:0)+'"><span class="input-span"></span></label>'
	        			];
        	})
        	.sort(Comparator)
        	.map(function(y){
        		return y.slice(1);
        	});

        	tblAttach.dataTable().fnClearTable();
        	tblAttach.dataTable().fnAddData(n);
        }

        function Comparator(a, b) {
		   if (a[1] < b[1]) return 1;
		   if (a[1] > b[1]) return -1;
		   return 0;
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
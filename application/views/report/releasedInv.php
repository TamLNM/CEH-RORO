<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/jquery-ui-month-year-picker/MonthPicker.css');?>" rel="stylesheet" />
<style>
	table.dataTable thead tr th{
		color: #000060!important;
		background: rgb(222,239,255)!important; /* Old browsers */
		background: -moz-linear-gradient(top, rgba(222,239,255,1) 0%, rgba(152,190,222,1) 100%)!important; /* FF3.6-15 */
		background: -webkit-linear-gradient(top, rgba(222,239,255,1) 0%,rgba(152,190,222,1) 100%)!important; /* Chrome10-25,Safari5.1-6 */
		background: linear-gradient(to bottom, rgba(222,239,255,1) 0%,rgba(152,190,222,1) 100%)!important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#deefff', endColorstr='#98bede',GradientType=0 )!important; /* IE6-9 */
		/*background-color: #bddcef;*/
	}
	table.dataTable thead tr{
		color: inherit!important;
		background: inherit!important;
		filter:inherit!important;
		/*background-color: #bddcef;*/
	}
	.ui-icon{
		margin-top: -0.9em!important;
		margin-left: -8px!important;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BÁO CÁO PHÁT HÀNH HÓA ĐƠN</div>
			</div>
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<form id="frmdata_export" method="post" action="<?=site_url(md5('Report') .'/'. md5('export_releaseInv'));?>">
					<div class="row border-e bg-white pb-1">
						<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
							<div class="form-group" id="divDistance">
								<label class="radio radio-outline-primary" style="padding-right: 20px">
									<input name="distance" type="radio" value="1" checked>
									<span class="input-span"></span>
									Tháng
								</label>
								<label class="radio radio-outline-primary" style="padding-right: 20px">
									<input name="distance" type="radio" value="2">
									<span class="input-span"></span>
									Quý
								</label>
								<label class="radio radio-outline-primary">
									<input name="distance" type="radio" value="3">
									<span class="input-span"></span>
									Năm
								</label>
							</div>
							<div class="form-group">
								<input id="onlyMonth" name="onlyMonth" class="form-control form-control-sm" type="text">
							</div>
							<div class="form-group hiden-input">
								<div class="input-group">
									<select id="cb-period-month" class="selectpicker" data-style="btn-default bg-white btn-sm" data-width="40%">
										<option value="1" selected>1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
									</select>
									<select id="cb-period-year" class="selectpicker ml-1" data-style="btn-default bg-white btn-sm" data-width="60%">
										<option value="2015" >2015</option>
										<option value="2016" >2016</option>
										<option value="2017" >2017</option>
										<option value="2018" selected>2018</option>
										<option value="2019" >2019</option>
										<option value="2020" >2020</option>
										<option value="2021" >2021</option>
										<option value="2022" >2022</option>
										<option value="2023" >2023</option>
										<option value="2024" >2024</option>
										<option value="2025" >2025</option>
									</select>
								</div>
							</div>
							<div class="form-group hiden-input">
								<select id="only-year" class="selectpicker" data-style="btn-default bg-white btn-sm" data-width="100%">
									<option value="2015" >2015</option>
									<option value="2016" >2016</option>
									<option value="2017" >2017</option>
									<option value="2018" selected>2018</option>
									<option value="2019" >2019</option>
									<option value="2020" >2020</option>
									<option value="2021" >2021</option>
									<option value="2022" >2022</option>
									<option value="2023" >2023</option>
									<option value="2024" >2024</option>
									<option value="2025" >2025</option>
								</select>
							</div>
						</div>
						<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
							<div class="form-group">
								<label class="mb-0">Loại tác nghiệp</label>
							</div>
							<div class="form-group">
								<select id="jmode" name="jmode" class="selectpicker" data-style="btn-default btn-sm bg-white" data-width="100%">
									<option value="" selected>-Không chọn-</option>
									<option value="*">* (Tất cả)</option>
									<option value="LAYN">Lấy nguyên</option>
									<option value="HBAI">Hạ bãi</option>
									<option value="CAPR">Cấp rỗng</option>
									<option value="TRAR">Trả rỗng</option>
								</select>
							</div>
						</div>
						<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
							<div class="form-group">
								<label class="mb-0">Hệ thống</label>
							</div>
							<div class="form-group col-form-label">
								<label class="checkbox checkbox-inline checkbox-primary">
									<input type="checkbox" name="sysname" value="TOS">
									<span class="input-span"></span>
									TOS
								</label>
								<label class="checkbox checkbox-inline checkbox-primary">
									<input type="checkbox" name="sysname" value="EB" checked>
									<span class="input-span"></span>
									EBL
								</label>
							</div>
						</div>
						<div class="col-xs-3 col-md-3 col-lg-3 col-xl-3 mt-3">
							<div class="form-group">
								<button id="search" class="btn btn-gradient-blue btn-fix btn-sm" type="button">
									<span class="btn-icon"><i class="ti-search"></i>Tìm kiếm</span>
								</button>
							</div>
							<div class="form-group">
								<button class="btn btn-gradient-peach btn-fix btn-sm" type="submit">
									<span class="btn-icon"><i class="la la-file-excel-o"></i>Xuất Excel</span>
								</button>
							</div>
						</div>
					</div>
					<input id="exportdata" name="exportdata" type="text" style="display: none">
					<input id="fromdate" name="fromdate" type="text" style="display: none">
					<input id="todate" name="todate" type="text" style="display: none">
				</form>
			</div>
			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.9%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Số PTC</th>
								<th>Ngày PTC</th>
								<th>Quyển HĐ</th>
								<th>Số HĐ</th>
								<th>Ngày HĐ</th>
								<th>Thành Tiền</th>
								<th>Thuế VAT</th>
								<th>Tổng Tiền</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", targets: 0 }
			],
			order: [[ 0, 'asc' ]],
			paging: false});

		$('#onlyMonth').MonthPicker({
			Button: function() {
				return $(this).next('.button');
			}
		});
		var crrentmonth = (new Date()).getMonth() + 1;
		$('#onlyMonth').val((crrentmonth<10?"0"+crrentmonth:crrentmonth) + "/" + (new Date()).getFullYear());

		$('#divDistance input[type="radio"]').on('change', function () {
			var checkval = $("#divDistance input[type='radio']:checked").attr('value');
			$('#divDistance').parent().find('div.form-group:not(:first-child)').addClass('hiden-input');
			$('#divDistance').parent().find('div.form-group:eq('+checkval+')').first().removeClass('hiden-input');
		});

		$('#search').on('click', function () {
			$("#contenttable").waitingLoad();
			var sysname = [];
			$('input[name="sysname"]:checked').each(function (index, item) {
				sysname.push(item.value);
			});
			var jmode = $('#jmode').val();

			var jdate = getFilterDate();

			var formData = {
				'action': 'view',
				'fromdate':jdate[0],
				'todate':jdate[1],
				'sysname': sysname,
				'jmode': jmode
			};

			$.ajax({
				url: "<?=site_url(md5('Report') . '/' . md5('rptReleasedInv'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.results.length > 0) {
						for (i = 0; i < data.results.length; i++) {
							rows.push([
								(i+1)
								, data.results[i].DRAFT_INV_NO
								, getDateTime(data.results[i].DRAFT_INV_DATE)
								, data.results[i].INV_PREFIX
								, data.results[i].INV_NO
								, getDateTime(data.results[i].INV_DATE)
								, data.results[i].AMOUNT
								, data.results[i].VAT
								, data.results[i].TAMOUNT
							]);
						}
					}

					if(rows.length > 0){
						rows.push([
							rows.length + 10
							, ''
							, ''
							, ''
							, ''
							, ''
							, data.results.map(p=> p.AMOUNT).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0)
							, data.results.map(p=> p.VAT).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0)
							, data.results.map(p=> p.TAMOUNT).reduce(function(a, b) {return parseFloat(a)+parseFloat(b);}, 0)
					]);
					}

					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
							{ className: "text-center", targets: [0,2,3,5] },
							{ className: "text-right", targets: [6,7,8], render: $.fn.dataTable.render.number( ',', '.', 0) }
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 9,
							boundaryScale: 0.95
						},
						createdRow: function(row, data, dataIndex){
							if(dataIndex == rows.length - 1){
								$(row).addClass('row-total');

								$('td:eq(0)', row).css('color', $(row).css('background-color'));
								$('td:eq(1)', row).attr('colspan', 5);
								$('td:eq(1)', row).addClass('text-center');

								for(var i = 2; i <= 5; i++ ){
									$('td:eq('+i+')', row).css('display', 'none');
								}

								this.api().cell($('td:eq(1)', row)).data('TỔNG CỘNG');
							}
						}
//						fnDrawCallback: function(){
//							return true;
//						}
					} );
				},
				error: function(err){console.log(err);}
			});
		});

		function getFilterDate(){
			var result = [];
			var td, frdate;
			var selected = $('#divDistance input[type="radio"]:checked').val();
			if(selected == 1){
				if(!$('#onlyMonth').val()){
					frdate = td = "";
				}else{
					frdate = "01/" + $('#onlyMonth').val();
					var daysinmonth1 = daysInMonth(parseInt($('#onlyMonth').val().split('/')[0]), parseInt($('#onlyMonth').val().split('/')[1]));
					td = (daysinmonth1 < 10 ? "0"+daysinmonth1 : daysinmonth1) + "/" +$('#onlyMonth').val();
				}
			}
			if(selected == 2){
				var frmonth = $('#cb-period-month').val() != 4 ? "0"+($('#cb-period-month').val()*3-2) : $('#cb-period-month').val()*3-2 ;
				frdate = "01/" + frmonth + "/" + $('#cb-period-year').val();
				var daysinmonth2 = daysInMonth(parseInt($('#cb-period-month').val()*3), parseInt($('#cb-period-year').val()));
				td = (daysinmonth2 < 10 ? "0"+daysinmonth2 : daysinmonth2) + "/" + ($('#cb-period-month').val() != 4 ? "0"+($('#cb-period-month').val()*3) : $('#cb-period-month').val()*3) + "/" + $('#cb-period-year').val();
			}
			if(selected == 3){
				frdate = "01/01/"+ $('#only-year').val();
				td = "31/12/"+ $('#only-year').val();
			}
			result.push(frdate);
			result.push(td);
			return result;
		}
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/jquery-ui-month-year-picker/MonthPicker.js');?>"></script>
<!--format number-->
<script src="<?=base_url('assets/js/jshashtable-2.1.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.numberformatter-1.2.3.min.js');?>"></script>
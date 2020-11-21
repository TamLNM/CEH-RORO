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
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
	#contenttable tbody tr.total_r{
		background: #fff0db !important;
	}
	#contenttable tr td{
		text-align: center;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BÁO CÁO XE</div>
				<div class="button-bar-group mr-3">			
					

					<button id="Export" class="btn btn-outline-dark btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Export" title="Export">
						<span class="btn-icon"><i class="ti-export"></i>Export</span>
					</button>

					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu" title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e py-2">
				<div class="row ibox mb-0 border-e pb-1 pt-1">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
										<div class="row form-group">
											<label class="col-sm-5 col-form-label text-left">Thời gian bắt đầu</label>
											<div class="col-lg-7 col-sm-7 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="TIMEIN" type="text" autocomplete="off" placeholder="Thời gian bắt đầu" value="<?=date('d/m/Y H:i:s',strtotime('-7 day'));?>">
												</div>
											</div>
										</div>
										
									</div>								
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
										<div class="row form-group">
											<label class="col-sm-5 col-form-label text-right">Thời gian kết thúc</label>
											<div class="col-lg-7 col-sm-7 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="TIMEOUT" autocomplete="off" type="text" placeholder="Thời gian kết thúc" value="<?=date('d/m/Y H:i:s');?>">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="row form-group">
											<div class="ml-3 mt-1">
												<label class="mt-1 radio radio-info">
					                                <input type="radio" name="ClassID" class="css-checkbox" value="0" checked>
					                                <span class="input-span"></span>Tất cả
					                            </label>
												<label class="mt-1 ml-3 radio radio-info">
					                                <input type="radio" name="ClassID" class="css-checkbox" value="1">
					                                <span class="input-span"></span>Nhập tàu
					                            </label>
												<label class="mt-1 ml-3 radio radio-info">
					                                <input type="radio" name="ClassID" class="css-checkbox" value="2">
					                             	<span class="input-span"></span>Xuất tàu
					                            </label>
					                        </div>
					                    </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>
								<th col-name="EirNo">Số Lệnh</th>
								<th col-name="BillOfLading_BookingNo">Số vận đơn/ Booking</th>
								<th col-name="Sequence">Sequence</th>
								<th col-name="TruckNumber">Số Xe</th>								
								<th col-name="TruckWeight">Trọng Lượng Xe</th>
								<th col-name="CargoWeight">Trọng Lượng Hàng</th>	
								<th col-name="StartDate">Thời Gian Vào</th>							
								<th col-name="FinishDate">Thời Gian Ra</th>					
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

<script type="text/javascript">
	$(document).ready(function () {
		var tbl 				= $("#contenttable"),
			_columns 			= ["STT", "VesselName", "InboundVoyage", "OutboundVoyage", "BillOfLading_BookingNo", "ClassID", "JobModeOutID", "DateOut", "Sequence", "CargoWeightGetOut", "UnitID"],
			parentMenuList 		= {};


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
				{ className: "text-center"},
				//{ className: "hiden-input", targets: _columns.getIndexs(["VoyageKey", "BookingNo", "BillOfLading"])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			"ordering": false,
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

		$("input[type=radio][name=ClassID]").on('change', function(){
			$("#search").trigger('click');
		});

		$('#TIMEIN, #TIMEOUT').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true,
			onSelect: function () {
				/* Do nothing */
			}	
		});


		function number_fm(amount, decimalCount = 2, decimal = ".", thousands = ",") {
		  	try {
			    decimalCount = Math.abs(decimalCount);
			    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

			    const negativeSign = amount < 0 ? "-" : "";

			    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
			    let j = (i.length > 3) ? i.length % 3 : 0;

			    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "").replace(/\.00$/, '');
			  	} catch (e) {
			    console.log(e)
		  	}
		};

		function find_v(){
			tbl.waitingLoad();
			var TIMEIN = $("#TIMEIN").val(),
				TIMEOUT = $("#TIMEOUT").val(),
				ClassID = $("input[name='ClassID']:checked").val();

			$.ajax({
                url: "<?=site_url(md5('Report') . '/' . md5('get_BaoCao_xe'));?>",
                dataType: 'json',
                data: {"TIMEIN":TIMEIN,"TIMEOUT":TIMEOUT},
                type: 'POST',
                success: function (data) {
                	$("#contenttable").DataTable().clear().draw();
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    var index = 1;
                    $("#contenttable").DataTable().clear().draw();
                    if(data.length>0){
                    	$(data).each(function(i,item){
                    		if (ClassID == 0){
	                    		var row=[];
	                    		row[0]=index++;
	                    		row[1]=item['EirNo'];
	                    		row[2]=(item['BillOfLading']||"")+(item['BookingNo']||"");
	                    		row[3]=item['Sequence'];
	                    		row[4]=item['TruckNumber'];
	                    		row[5]=item['TruckWeight'];
	                    		row[6]=item['CargoWeight'];
	                    		row[7]=getDateTime(item['StartDate']);
	                    		row[8]=getDateTime(item['FinishDate']);
	                    		$("#contenttable").DataTable().row.add(row).draw();
	                    	}
	                    	else if (item['ClassID'] == ClassID){
	                    		var row=[];
	                    		row[0]=index++;
	                    		row[1]=item['EirNo'];
	                    		row[2]=(item['BillOfLading']||"")+(item['BookingNo']||"");
	                    		row[3]=item['Sequence'];
	                    		row[4]=item['TruckNumber'];
	                    		row[5]=item['TruckWeight'];
	                    		row[6]=item['CargoWeight'];
	                    		row[7]=getDateTime(item['StartDate']);
	                    		row[8]=getDateTime(item['FinishDate']);
	                    		$("#contenttable").DataTable().row.add(row).draw();
	                    	}
                    	});
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		find_v();
		$("#search").on("click",  function(){
       		find_v();
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

	//in excel
	function fnExcelReport()
	{
	    var tab_text="<table border='2px'>";
	    var textRange; var j=0;
	    tab = document.getElementById('contenttable'); // id of table
	    //alert($(tab).find("thead tr").html());
	    var theader="";
	    $(tab).find("thead tr th").each(function(){
	    	theader+="<td width=200><b>"+$(this).html()+"</b></td>";
	    });
	    tab_text+="<tr bgcolor='#FFFFFF'>"+theader+"</tr>";
	    for(j = 0 ; j < tab.rows.length ; j++) 
	    {     
	        tab_text+="<tr>"+tab.rows[j].innerHTML+"</tr>";
	        //tab_text=tab_text+"</tr>";
	    }

	    tab_text=tab_text+"</table>";
	    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
	    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
	    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

	    var ua = window.navigator.userAgent;
	    var msie = ua.indexOf("MSIE "); 

	    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
	    {
	        txtArea1.document.open("txt/html","replace");
	        txtArea1.document.write(tab_text);
	        txtArea1.document.close();
	        txtArea1.focus(); 
	        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
	    }  
	    else                 //other browser not tested on IE 11
	        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

	    return (sa);
	}

	$(document).on("click","#Export",function(){
		fnExcelReport();
	});
});
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
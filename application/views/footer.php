<?php
defined('BASEPATH') OR exit('');
?>
        </div>
			<!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">2018 © <b>C.E.H</b> - Certified Ethical Hacker</div>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
    <input style="display: none" id="editor-input" />
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    
	<!-- CORE SCRIPTS-->
    <script src="<?=base_url('assets/js/app.min.js');?>"></script>

<script>
    var resizefunc = [];

    $.extend( true, $.fn.dataTable.defaults, {
        language: {
            info: "Số dòng: _TOTAL_",
            emptyTable: "------------ Không có dữ liệu hiển thị ------------",
            infoFiltered: "(trên _MAX_ dòng)",
            infoEmpty: "Số dòng: 0",
            search: '<span>Tìm:</span> _INPUT_',
            zeroRecords:    "------------ Không có dữ liệu được tìm thấy ------------",
            sThousands: ",",
            sDecimal: ".",
            select: {
                rows: {
                    _: "Đã chọn %d dòng",
                    0: ""
                }
            }
        },
        search: {
            regex: true
        },
        info: true,
        orderClasses: false,
        paging: false,
        scrollY: 419,
        scrollX: true,
        lengthChange: false,
        scrollCollapse: false,
        deferRender: true,
        processing: true,
        autoWidth: true,
        dom: '<"datatable-header"fl<"datatable-info-right"Bip>><"datatable-scroll-wrap">',
        buttons: [
            {extend: 'selectAll', text: 'Chọn tất cả', className: 'btn btn-xs btn-default'},
            {extend: 'selectNone', text: 'Bỏ chọn', className: 'btn btn-xs btn-default'}
        ],
        destroy: true
    });
</script>
<script>
    $(document).ready(function () {
//        $('body').addClass('drawer-sidebar');

        $('#sidebar-collapse').slimScroll({height:"100%",railOpacity:"0.9"});
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "swing",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        $('a.nav-link.sidebar-toggler.js-sidebar-toggler').on('click', function () {
            setTimeout(function () {
                $('.dataTable tbody').closest('table').each(function (k, v) {
                    $(v).realign();
                });
            }, 250);
        });

        //remove class error when change value
        $(document).on('input', '.error input', function () {
            $(this).parent().removeClass('error');
        });

        $('[data-action="reloadUI"]').on('click', function (e) {
            var block = $(this).attr('data-reload-target');
            $(block).block({ 
                message: '<i class="la la-spinner spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait',
                    'box-shadow': '0 0 0 1px #ddd'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'none'
                }
            });
        });

        // $(window).on("resize",function(){
        //     $('.dataTable tbody').closest('table').each(function (k, v) {
        //         $(v).realign();
        //     });
        // });
    });

    // $(function () {
    //     var ctrlIsPressed = false;
    //     $(document).keydown(function(event){
    //         if(event.which=="17")
    //             ctrlIsPressed = true;
    //     });

    //     $(document).keyup(function(){
    //         ctrlIsPressed = false;
    //     });

    //     var isMouseDown = false;
    //     var rIdx = -1;
    //     $('table').on('mousedown','tbody td',function (e) {
    //         if($(this).closest('table').hasClass('single-row-select') && e.which == 3){
    //             e.preventDefault();
    //             return;
    //         }
    //         if(e.which == 3) {
    //             isMouseDown = true;
    //             var a = $(this).parent().find("input[class='is-row-select'][type='checkbox']").first();
    //             if(a.length > 0){
    //                 a.trigger('click');
    //                 a.is(':checked') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }else{
    //                 if(!ctrlIsPressed && rIdx != $(this).parent().index()){
    //                     $(this).closest('table').find('tr').removeClass('m-row-selected');
    //                 }
    //                 !$(this).parent().hasClass('m-row-selected') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //                 rIdx = $(this).parent().index();
    //             }
    //         }
    //     }).on('mouseover','tbody td',function (e) {
    //         if($(this).closest('table').hasClass('single-row-select')){
    //             e.preventDefault();
    //             return;
    //         }
    //         if(isMouseDown) {
    //             var a = $(this).parent().find("input[class='is-row-select'][type='checkbox']").first();
    //             if(a.length > 0){
    //                 a.trigger('click');
    //                 a.is(':checked') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }else{
    //                 !$(this).parent().hasClass('m-row-selected') ? $(this).parent().addClass('m-row-selected') : $(this).parent().removeClass('m-row-selected');
    //             }
    //         }
    //     });

    //     $(document).mouseup(function () {
    //         isMouseDown = false;
    //     });

    //     $("table").on('contextmenu', function (e) {
    //         e.preventDefault();
    //     });
    // });
</script>
</body>
</html>
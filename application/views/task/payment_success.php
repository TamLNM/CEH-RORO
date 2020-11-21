<?php
defined('BASEPATH') OR exit('');
?>
<style>
    body {
        background-repeat: no-repeat;
        background-size: cover;
    }

    .cover {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(117, 54, 230, .1);
    }

    .notify-content {
        max-width: 800px;
        margin: auto;
        height: 700px;
        vertical-align: middle;
        padding-top: 60px!important;
    }

    .success-head-icon {
        position: relative;
        height: 100px;
        width: 100px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 55px;
        background-color: #fff;
        color: green;
        border-radius: 50%;
        transform: translateY(-25%);
        z-index: 2;
        border: solid 10px green;
    }
</style>

<div class="cover"></div>
<div class="ibox ibox-fullheight">
    <div class="ibox-body notify-content">
        <h1 class="text-center font-bold mb-5">COMPLETE !</h1>
        <div class="text-center">
            <span class="success-head-icon"><i class="fa fa-check"></i></span>
        </div>
        <h5 class="text-center mb-5">Giao dịch đã được thược hiện thành công!</h5>
        <h5 class="text-center">Mã giao dịch: <?=$invInfo["fkey"];?></h5>
        <h5 class="text-center mb-5">Số hóa đơn: <?=$invInfo["serial"].substr("0000000".$invInfo['invno'], -7);?></h5>
        <div class="ibox-footer row">
            <div class="col-sm-6">
                <a class="btn btn-dark btn-rounded btn-block text-white" onclick="goBack()">Làm lệnh mới</a>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-blue btn-rounded btn-block" target="_blank" href="<?=site_url(md5("InvoiceManagement") . '/' . md5("downloadInvPDF")."?fkey=".$invInfo["fkey"]);?>">Xem hóa đơn</a>
            </div>
        </div>
    </div>
</div>
<script>
    function goBack() {
        window.location.replace(document.referrer);
    }
</script>
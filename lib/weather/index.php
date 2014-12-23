<?php
error_reporting(0);
$col = $w = $g = $r = '';
$data = @file_get_contents('http://vnexpress.net/block/crawler?arrKeys%5B%5D=thoi_tiet&arrKeys%5B%5D=gia_vang&arrKeys%5B%5D=ty_gia');
$data = json_decode($data, true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Lấy tỷ giá , giá vàng , thời tiết từ vnexpress</title>
        <script language="javascript" src="js/ajax.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script language="javascript" type="text/javascript" src="js/jquery-1.7.1.js"></script>
        <script language="javascript" src="js/jquery.lionbars.0.3.js"></script>
        <script>
            var $ = jQuery;
            $(function ($)
            {
                $('.demo').lionbars();
            });
            jQuery.noConflict();
        </script>
        <style>
            .bg_tb
            {
                background:url('images/bg.png') #fff;
                background-repeat: repeat-x;        
            }
            .demo { background: white; float: left;  width: 230px; padding-right:px; height: 80px; color: #222; font: 12px/18px helvetica, tahoma, sans-serif; overflow: auto; }
        </style>
    </head>

    <body>
        <table width="230px" cellspacing="0" cellpadding="0" border="0" class="bg_tb">
            <!-- Weather -->
            <tr>
                <td  valign="top" style="padding:5px">
                    <table width="120px" border="0" cellspacing="0" cellpadding="0">
                        <tr><td><img src="images/cloud.png" border="0"  width="25px" style="vertical-align:middle" /> <b>Thời tiết</b></td>
                        </tr>

                        <tr>
                            <td id="content_Weather">

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Gold price -->
            <tr>
                <td style="padding:5px">
                    <table border="0" cellpadding="0" cellspacing="0" width="95%">
                        <tr><td colspan="2">
                            <img border="0" src="images/money.png" style="vertical-align:middle" width="25px" alt="Giá vàng" />
                            <b>Giá vàng</b>
                        </td></tr>
                        <tr><td>
                            <table class="bor_ctd" border="0"  cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
                                <tr><td class="ctd" align="center"  bgcolor="#ffffff">Loại</td>
                                    <td class="ctd"  align="center"  bgcolor="#ffffff">Mua vào</td>
                                    <td class="ctd"  align="center"  bgcolor="#ffffff">Bán ra</td>
                                </tr>
                                <?php
                                    foreach ($data['gia_vang'] as $giavang) {
                                ?>
                                <tr><td class="ctd"  bgcolor="#ffffff" align="center"><?php echo $giavang['name']; ?></td>
                                    <td class="ctd" align="center"  bgcolor="#ffffff"><?php echo $giavang['buy']; ?></td>
                                    <td align="center" class="ctd"  bgcolor="#ffffff"><?php echo $giavang['sell']; ?></td></tr>
                                <?php } ?>
                            </table>
                        </td></tr>
                    </table>
                </td>
            </tr>
            <!-- exchange -->
            <tr>
                <td style="padding:5px">

                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td colspan="2">
                                <img src="images/circle-chart.png" style="vertical-align:middle" border="0" alt="Tỷ giá" />
                                <b>Tỷ giá</b>                              </td>
                        </tr>
                        <tr>
                            <td colspan="2" width="95%">
                                <div id="AdTyGiaLoc">
                                    <div class="demo"><table class="bor_ctd" border="0"  cellpadding="0" cellspacing="0" width="95%" bgcolor="#ffffff">
                                    <?php
                                    foreach ($data['ty_gia']['data'] as $tygia) {
                                        ?>
                                        <tr>
                                            <td class="ctd" bgcolor="#ffffff">&nbsp;&nbsp;<?php echo $tygia['typename']; ?></td>
                                            <td class="ctd" bgcolor="#ffffff">&nbsp;<?php echo $tygia['buytm']; ?></td>
                                            <td class="ctd" bgcolor="#ffffff">&nbsp;<?php echo $tygia['buyck']; ?></td>
                                            <td class="ctd" bgcolor="#ffffff">&nbsp;<?php echo $tygia['sell']; ?></td>
                                        </tr>
                                    <?php } ?>
<?php

$rate = new Rate();
$rate->source = 'http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx';
$rate->show();
?>                                             
                                        </table></div>
                                </div>
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>   

            </table>        
        
       
    </body>       
</html>

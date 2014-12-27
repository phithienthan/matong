<?php
require 'weather.php';
weather::update_weather(weather::get_url('id'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="author" content="nova" />
<title>Lấy thông tin thời tiết từ yahoo</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/we.js" type="text/javascript"></script>
</head>
<body>
<div class="we-content">
    <div class="clrfix">
        <select name="we_zone" id="we_zone" onchange="getWeather(this.value);">
        	<option value="0">Hà Nội</option>
        	<option value="1">TP HCM</option>
        	<option value="2">Hải Phòng</option>
        	<option value="3">Vinh</option>
        	<option value="4">Đà Nẵng</option>
        	<option value="5">Nha Trang</option>
        	<option value="6">Bắc Giang</option>
        </select>
        <span id="we_loading"></span>
    </div>
    <div class="we-info">
		<?php if(isset(weather::$weather) and weather::$weather){ ?>
    	<div class="clrfix">
            <div class="we-image"><img src="<?php echo weather::$weather['image'];?>" align="left" alt="Hiện tại" /></div>
            <div class="we-chill"><span class="chill"><?php echo weather::$weather['chill'];?></span><span class="unit">&deg;C</span></div>
            <div class="we-hl"><span>H<?php echo weather::$weather['high'];?>&deg;</span><span>L<?php echo weather::$weather['low'];?>&deg;</span></div>
        </div>
        <div><?php echo weather::$weather['condition'];?></div>
        <div>Độ ẩm: <?php echo weather::$weather['humidity'];?>%</div>
        <div>Gió: <?php echo weather::$weather['direction'].', '.weather::$weather['wind_speed'].' '.weather::$weather['wind_speed_unit'];?></div>
        <div>Mặt trời mọc: <?php echo weather::$weather['sunrise'];?></div>
        <div>Mặt trời lặn: <?php echo weather::$weather['sunset'];?></div>
        <?php }?>
    </div>
    <div class="source">Nguồn: yahoo.com</div>
</div>
</body>
</html>
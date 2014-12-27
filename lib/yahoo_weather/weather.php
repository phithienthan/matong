<?php
class weather
{
	static $weather=array();
	function update_weather($id)
	{
		// Tạo cache dự phòng khi không lấy được thông tin
		$Link = array();
		$weather_dir='cache/';
		if(!is_dir($weather_dir)) mkdir($weather_dir,0755,true);
		$Link[] = $weather_dir.'Hanoi.xml';
		$Link[] = $weather_dir.'HCM.xml';
		$Link[] = $weather_dir.'Haiphong.xml';
		$Link[] = $weather_dir.'Vinh.xml';
		$Link[] = $weather_dir.'Danang.xml';
		$Link[] = $weather_dir.'Nhatrang.xml';
		$Link[] = $weather_dir.'Bacgiang.xml';
		
		// Lấy thông tin xml từ yahoo
		$Link2 = array();
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=12800712&u=c';	// Hà Nội
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1252431&u=c';	// TP HCM
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1236690&u=c';	// Hải Phòng
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1252662&u=c';	// Vinh
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1252376&u=c';	// Đà Nẵng
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1252522&u=c';	// Nha Trang
		$Link2[] = 'http://weather.yahooapis.com/forecastrss?w=1229284&u=c';	// Bắc Giang
		
		// Lấy nội dung file xml chứa thông tin thời tiết từ yahoo
		$content = @file_get_contents($Link2[$id]);
		if($content==''){
			$content = @file_get_contents($Link[$id]); // Nếu không lấy được thông tin từ yahoo thì lấy thông tin từ file cache
		}else{
			copy($Link2[$id],$Link[$id]); // Nếu lấy được thông tin từ yahoo thì ghi vào file cache
		}
		
		// Phân tích và đưa thông tin file xml vào mảng $xml
		$p = xml_parser_create();
		xml_parse_into_struct($p, $content, $xml);
		
		// Đưa các thông tin cần lấy trong mảng $xml vào mảng $weather
		$weather['wind_speed_unit']=$xml[16]['attributes']['SPEED'];								// đơn vị tốc độ gió
		$weather['chill']=$xml[18]['attributes']['CHILL'];											// nhiệt độ
		$weather['direction']=weather::wind_direction($xml[18]['attributes']['DIRECTION']);			// hướng gió
		$weather['wind_speed']=$xml[18]['attributes']['SPEED'];										// tốc độ gió
		$weather['humidity']=$xml[20]['attributes']['HUMIDITY'];									// độ ẩm
		$weather['sunrise']=$xml[22]['attributes']['SUNRISE'];										// mặt trời mọc
		$weather['sunset']=$xml[22]['attributes']['SUNSET'];										// mặt trời lặn
		$weather['condition']=$xml[48]['attributes']['TEXT'];										// tình trạng hiện tại
		$weather['image']=weather::get_we_image($xml[50]['value']);									// ảnh thời tiết
		$weather['high']=$xml[52]['attributes']['HIGH'];											// nhiệt độ cao nhất trong ngày
		$weather['low']=$xml[52]['attributes']['LOW'];												// nhiệt độ thấp nhất trong ngày
		weather::$weather=$weather;
		
		// ajax getWeather
		if(weather::get_url('cmd')=='we_change'){
			$we='<div class="clrfix"><div class="we-image"><img src="'.$weather['image'].'" align="left" /></div><div class="we-chill"><span class="chill">'.$weather['chill'].'</span><span class="unit">&deg;C</span></div><div class="we-hl"><span>H'.$weather['high'].'&deg;</span><span>L'.$weather['low'].'&deg;</span></div></div><div>'.$weather['condition'].'</div><div>Độ ẩm: '.$weather['humidity'].'%</div><div>Gió: '.$weather['direction'].', '.$weather['wind_speed'].' '.$weather['wind_speed_unit'].'</div><div>Mặt trời mọc: '.$weather['sunrise'].'</div><div>Mặt trời lặn: '.$weather['sunset'].'</div>';
			echo "var weather='".$we."';"; exit();
		}
	}
	/* Chuyển đổi hướng gió từ số thành chữ
	** $w là một số từ 0 tới 359
	*/
	function wind_direction($w){
		$content='';
		if($w==0){
			$content='không xác định';
		}elseif(($w>=355 and $w<360) or ($w>0 and $w<=5)){
			$content='bắc';
		}elseif($w>5 and $w<=40){
			$content='bắc đông bắc';
		}elseif($w>40 and $w<=50){
			$content='đông bắc';
		}elseif($w>50 and $w<=85){
			$content='đông đông bắc';
		}elseif($w>85 and $w<=95){
			$content='đông';
		}elseif($w>95 and $w<=130){
			$content='đông đông nam';
		}elseif($w>130 and $w<=140){
			$content='đông nam';
		}elseif($w>140 and $w<=175){
			$content='nam đông nam';
		}elseif($w>175 and $w<=185){
			$content='nam';
		}elseif($w>185 and $w<=220){
			$content='nam tây nam';
		}elseif($w>220 and $w<=230){
			$content='tây nam';
		}elseif($w>230 and $w<=265){
			$content='tây tây nam';
		}elseif($w>265 and $w<=275){
			$content='tây';
		}elseif($w>275 and $w<=310){
			$content='tây tây bắc';
		}elseif($w>310 and $w<=320){
			$content='tây bắc';
		}elseif($w>320 and $w<355){
			$content='bắc tây bắc';
		}
		return $content;
	}
	/* Lấy đường dẫn ảnh thời tiết hiện tại
	*/
	function get_we_image($content){
		$pos=strpos($content,'"/>');
		$content=substr($content,11,$pos-11);
		return $content;
	}
	/* Lấy thông tin từ url
	*/
	function get_url($url){
		if(isset($_REQUEST[$url]) and $_REQUEST[$url]){
			return $_REQUEST[$url];
		}
		return false;
	}
}
?>
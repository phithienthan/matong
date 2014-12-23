<?php

/**
 * @author quyetnd
 */
class Rate{
var $source;
var $mydate;
function getXML(){return file_get_contents($this->source);}
function getRate(){
$xmlData = NULL;
$p = xml_parser_create();
xml_parse_into_struct($p,$this->getXML() , $xmlData);
xml_parser_free($p);
$this->mydate = $xmlData['1']['value'];
$data = array();
if($xmlData){
foreach($xmlData as $v)
if(isset($v['attributes']))
{$data[] = $v['attributes'];}
return $data;
}
return false;
}
function show(){$data = $this->getRate();
print '<tr class="td"><td>Mã ngoại tệ</td><td>Tên ngoại tệ</td><td>Mua tiền mặt</td><td>Chuyển khoản</td><td>Bán</td></tr>';
foreach($data as $k=>$v){print '<tr><td>'.$v['CURRENCYCODE'].' </td><td>'.$v['CURRENCYNAME'].' </td><td class="r"> '.$v['BUY'].' </td><td class="r"> '.$v['TRANSFER'].'</td><td class="r">'.$v['SELL'].'</td></tr>';}
}}
?>
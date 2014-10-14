<?php

/** Module Prettypegs orders export
  *file createCSV.php
  * @author Vinum Master, Linus Karlsson
  * @version 1.0
  */

include('../../config/config.inc.php');


$fieldnames=array(
	1=>'Code',
	2=>'quantity',
	3=>'SetA',
	4=>'SetB',
	5=>'SetC',
	6=>'SetD',
	7=>'SetE',
	8=>'SetF',
	9=>'SetG',
	10=>'SetH',
	11=>'PrettypegsOrderID',
	12=>'OrderNumber',
	13=>'FirstName',
	14=>'LastName',
	15=>'Company',
	16=>'AddressLine1',
	17=>'AddressLine2',
	18=>'PostalCode',
	19=>'City',
	20=>'Country',
	21=>'CountryCodeISO',
	22=>'telephone',
	23=>'mail',
	24=>'payment',
	25=>'GiftBox',
	26=>'OrderDate'
	);

$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));

$directory = dirname(_PS_MODULE_DIR_).'/modules/prettypegsorderexport/';
$filename = $directory.'export.csv';
$filename_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/prettypegsorderexport/export.csv';
$adminDirectory= dirname(__FILE__).'/';

require_once(dirname(_PS_MODULE_DIR_).'/modules/prettypegsorderexport/classes/DBQueryHelper.php');

@unlink($filename);
$fp = fopen($filename, 'wb');
fclose($fp);


$orders=Tools::getValue('ordersID');
$fields=Tools::getValue('fields');


$orders = explode(',',$orders);
$fields= explode(',',$fields);

foreach($fields AS $fieldno)
{
	$fields[]=$fieldnames[$fieldno];
	echo $fieldnames[$fieldno];
}


addToFeed('Code;');
addToFeed('quantity;');
addToFeed('SetA;');
addToFeed('SetB;');
addToFeed('SetC;');
addToFeed('SetD;');
addToFeed('SetE;');
addToFeed('SetF;');
addToFeed('SetG;');
addToFeed('SetH;');
addToFeed('PrettypegsOrderID;');
addToFeed('OrderNumber;');
addToFeed('FirstName;');
addToFeed('LastName;');
addToFeed('Company;');
addToFeed('AddressLine1;');
addToFeed('AddressLine2;');
addToFeed('PostalCode;');
addToFeed('City;');
addToFeed('Country;');
addToFeed('CountryCodeISO;');
addToFeed('telephone;');
addToFeed('mail;');
addToFeed('payment;');
addToFeed('GiftBox;');
addToFeed('OrderDate;');


addToFeed("\r\n");

foreach($orders as $order)
{
	$order_details = DBQueryHelper::getOrderDetails($order);

	foreach ($order_details as $order_detail) {

		printRowToFile($order_detail);
	}
}

function printRowToFile($order_detail){

		$country = New Country($order_detail['id_country']);
		$reformatDate = date(" Y-m-d H:i:s", strtotime( $order_detail['invoice_date'] ));

		addToFeed('"'.parseProductNameToProductCode($order_detail['name_on_product'], $order_detail['product_attribute_id']).'";');
		addToFeed('"'.$order_detail['product_quantity'].'";');
		addToFeed('"'.$order_detail['seta'].'";');
		addToFeed('"'.$order_detail['setb'].'";');
		addToFeed('"'.$order_detail['setc'].'";');
		addToFeed('"'.$order_detail['setd'].'";');
		addToFeed('"'.$order_detail['sete'].'";');
		addToFeed('"'.$order_detail['setf'].'";');
		addToFeed('"'.$order_detail['setg'].'";');
		addToFeed('"'.$order_detail['seth'].'";');
		addToFeed('"'.$order_detail['id_order'].'";');
		addToFeed('"'.''.'";'); //orderNumber left empty
		addToFeed('"'.$order_detail['firstname'].'";');
		addToFeed('"'.$order_detail['lastname'].'";');
		addToFeed('"'.$order_detail['company'].'";');
		addToFeed('"'.$order_detail['address1'].'";');
		addToFeed('"'.$order_detail['address2'].'";');
		addToFeed('"'.$order_detail['postcode'].'";');
		addToFeed('"'.$order_detail['city'].'";');
																		// 1 is the id_lang
		addToFeed('"'.Country::getNameById(1,$order_detail['id_country'] ).'";');
		addToFeed('"'.$country->iso_code.'";');
		addToFeed('"'.($order_detail['phone_mobile'] != '' ? $order_detail['phone_mobile'] : $order_detail['phone'] ).'";');
		addToFeed('"'.$order_detail['email'].'";');
		addToFeed('"'.''.'";'); // payment left empty
		addToFeed('"'.'NO'.'";');
		addToFeed('"'.$reformatDate.'";');
		addToFeed('"'.$order_detail['product_name'].'";');

		addToFeed("\r\n");

}

function parseProductNameToProductCode($productName, $productAttributeId){

	$size = '';
	$color = '';
	$attributes = DBQueryHelper::getOrderDetailAttributeLang($productAttributeId);

	foreach ($attributes as $attribute){

		if ($attribute['attribute_name'] == 'Large')
		{
			$size = ' B';
		}
		if ($attribute['attribute_name'] == 'Regular')
		{
			$size = ' A';
		}
		if(strpos($productName,'Table'))
		{
			$size = ' T';
		}

		if (
			$attribute['attribute_name'] != 'Large' &&
			$attribute['attribute_name'] != 'Regular' &&
			$attribute['attribute_name'] != 'M8' &&
			$attribute['attribute_name'] != 'Universal Fitting Plate' &&
			$attribute['attribute_name'] != 'One size' &&
			$attribute['attribute_name'] != 'Fork Plate' ){

			$color = $attribute['attribute_name'];

		}
	}

	$color = str_replace ('style', '', $color);
	$color = str_replace ('natural', '', $color);
	$color = str_replace (' ', '', $color);

	$productName = str_replace ( ' Table' , '' , $productName);
	$size = str_replace ( 'Onesize' , '' , $size);
	$color = str_replace ( 'Onesize' , '' , $color);

	return strtoupper($productName) . $size . ' '. $color;

}

function addToFeed($str)
{
	Global $filename;
	if(file_exists($filename))
	{
		$fp = fopen($filename, 'ab');
		fwrite($fp,$str, strlen($str));

		fclose($fp);
	}
}

?>

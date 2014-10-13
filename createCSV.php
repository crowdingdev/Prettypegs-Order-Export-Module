<?php




/** Module presta2csvorders compatible PS > 1.5 and 1.6
  *file createCSV.php
  * @author Vinum Master
  * @copyright Vinum Master
  * @version 1.40
  *
  */
include('../../config/config.inc.php');
$fieldnames=array(
	1=>'id_order',
	2=>'reference',
	3=>'id_shop_group',
	4=>'id_shop',
	5=>'id_carrier',
	6=>'id_lang',
	7=>'id_customer',
	8=>'id_cart',
	9=>'id_currency',
	10=>'id_address_delivery',
	11=>'id_address_invoice',
	12=>'current_state',
	13=>'secure_key',
	14=>'payment',
	15=>'conversion_rate',
	16=>'module',
	17=>'recyclable',
	18=>'gift',
	19=>'gift_message',
	20=>'shipping_number',
	21=>'total_discounts',
	22=>'total_discounts_tax_incl',
	23=>'total_discounts_tax_excl',
	24=>'total_paid',
	25=>'total_paid_tax_incl',
	26=>'total_paid_tax_excl',
	27=>'total_paid_real',
	28=>'total_products',
	29=>'total_product_wt',
	30=>'total_shipping',
	31=>'total_shipping_tax_incl',
	32=>'total_shipping_tax_excl',
	33=>'carrier_tax_rate',
	34=>'total_wrapping',
	35=>'total_wrapping_tax_incl',
	36=>'total_wrapping_tax_excl',
	37=>'invoice_number',
	38=>'delivery_number',
	39=>'invoice_date',
	40=>'delivery_date',
	41=>'valid',
	42=>'date_add',
	43=>'date_upd',
	44=>'customer_infos',
	45=>'delivery_address',
	46=>'invoice_address',
	47=>'products'
	);



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

//addToFeed('ORDER;');


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
		
		//$order_detail = utf8_encode_deep($order_detail);

		$country = New Country($order_detail['id_country']);

		$reformatDate = date(" Y-m-d H:i:s", strtotime( $order_detail['invoice_date'] ));

		addToFeed('"'.iconv(mb_detect_encoding ($order_detail['product_name']),"UTF-8",$order_detail['product_name']).'";');
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
		addToFeed('"'.Country::getNameById(1,$order_detail['id_country'] ).'";');
		addToFeed('"'.$country->iso_code.'";');
		addToFeed('"'. ($order_detail['mobile_phone'] != '' ? $order_detail['mobile_phone'] : $order_detail['phone'] ).'";');
		addToFeed('"'.$order_detail['email'].'";');
		addToFeed('"'.''.'";'); // payment left empty
		addToFeed('"'.'NO'.'";');
		addToFeed('"'.$reformatDate.'";');

		addToFeed("\r\n");
	}



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

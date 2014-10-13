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
		addToFeed('"'. ($order_detail['phone_mobile'] != '' ? $order_detail['phone_mobile'] : $order_detail['phone'] ).'";');
		addToFeed('"'.$order_detail['email'].'";');
		addToFeed('"'.''.'";'); // payment left empty
		addToFeed('"'.'NO'.'";');
		addToFeed('"'.$reformatDate.'";');

		addToFeed("\r\n");

}


// Astrid - Color : Yellow, Furniture & fittings : Universal Fitting Plate
// Carl - Color : White, Furniture & fittings : M8, Size : Regular
// Albin - FÃ¤rgval : Black, MÃ¶beltyp & beslag : M8
// Albin - Farbe : Schwarz, MÃ¶bel & BeschlÃ¤ge : M8
// Alfred Tischbein - Farbe : Schwarz, GrÃ¶ÃŸe : M
// Albin - Farbe : Schwarz, MÃ¶bel & BeschlÃ¤ge : M8
// Albin - FÃ¤rgval : Black, MÃ¶beltyp & beslag : M8
// Hillevi - FÃ¤rgval : Ash natural, MÃ¶beltyp & beslag : M8
// Estelle - FÃ¤rgval : Mint, MÃ¶beltyp & beslag : M8, Storlek : M
// Svea - FÃ¤rgval : Ash / Mint, MÃ¶beltyp & beslag : M8
// Carl bord - Färgval : Black, Storlek : M
// Carl - Färgval : Teak style / blue, Möbeltyp & beslag : Universal Fitting Plate, Storlek : L



function parseProductNameToProductCode($productName, $productAttributeId){
	
	$size = 'A';
	$color = '';
	$attributes = DBQueryHelper::getOrderDetailAttributeLang($productAttributeId);

	foreach ($attributes as $attribute){

		if ($attribute['attribute_name'] == 'Large' )
		{
			$size = 'B';
		}
		if(strpos($productName,'Table')){
			$size = 'T';
		}

		$all.= $attribute['attribute_name']. ', ';

		if (
			$attribute['attribute_name'] != 'Large' &&
			$attribute['attribute_name'] != 'Regular' &&
			$attribute['attribute_name'] != 'M8' &&
			$attribute['attribute_name'] != 'Universal Fitting Plate' &&
			$attribute['attribute_name'] != 'Fork Plate' ){

			$color = $attribute['attribute_name'];

		}
	}

	$productName = str_replace ( ' Table' , '' , $productName);
	return strtoupper($productName) . ' ' . $size . ' '. $color;

	// $name = strtoupper (explode('-',$productName)[0]);
	// $color = strtoupper (explode(':',$productName)[0]);
	// preg_match('/:(.*?),/',$productName, $color);
	// $color = str_replace(' ', '', $color[1]);
	// $size = '';
	// if (strpos($productName . ' ',' : M ' )){
	// 	$size = 'A ';
	// }
	// if (strpos($productName . ' ',' : L ' )){
	// 	$size = 'B ';
	// }
	// if (strpos( $productName,'table' ) || strpos($productName,'bord') || strpos($productName,'Tischbein')){
	// 	$size = 'T ';
	// }
	// $name = str_replace ( 'BORD' , '' , $name);
	// $name = str_replace ( 'TABLE' , '' , $name);
	// $name = str_replace ( 'TISCHBEIN' , '' , $name);
	// return rtrim ( $name) . ' ' . $size . $color   ;
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

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
	
$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));

$directory = dirname(_PS_MODULE_DIR_).'/modules/presta2csvorders/';
$filename = $directory.'export.csv';
$filename_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/presta2csvorders/export.csv';
$adminDirectory= dirname(__FILE__).'/';

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

							addToFeed('ORDER;');
							if(in_array("id_order",$fields)) addToFeed('id_order;');
                        	if(in_array("reference",$fields)) addToFeed('reference;');
                      		if(in_array("id_shop_group",$fields)) addToFeed('id_shop_group;');
                      		if(in_array("id_shop",$fields)) addToFeed('id_shop;');
                      		if(in_array("id_carrier",$fields)) addToFeed('id_carrier;');
                      		if(in_array("id_lang",$fields)) addToFeed('id_lang;');
                      		if(in_array("id_customer",$fields)) addToFeed('id_customer;');
                    		if(in_array("id_cart",$fields)) addToFeed('id_cart;');
                     		if(in_array("id_currency",$fields)) addToFeed('id_currency;');
                    		if(in_array("id_address_delivery",$fields)) addToFeed('id_address_delivery;');
                    		if(in_array("id_address_invoice",$fields)) addToFeed('id_address_invoice;');
                    		if(in_array("current_state",$fields)) addToFeed('current_state;');
                    		if(in_array("secure_key",$fields)) addToFeed('secure_key;');
                 			if(in_array("payment",$fields)) addToFeed('payment;');
							if(in_array("conversion_rate",$fields)) addToFeed('conversion_rate;');
							if(in_array("module",$fields)) addToFeed('module;');
							if(in_array("recyclable",$fields)) addToFeed('recyclable;');
							if(in_array("gift",$fields)) addToFeed('gift;');
							if(in_array("gift_message",$fields)) addToFeed('gift_message;');
							if(in_array("shipping_number",$fields)) addToFeed('shipping_number;');
							if(in_array("total_discounts",$fields)) addToFeed('total_discounts;');
                       		if(in_array("total_discounts_tax_incl",$fields)) addToFeed('total_discounts_tax_incl;');
                       		if(in_array("total_discounts_tax_excl",$fields)) addToFeed('total_discounts_tax_excl;');
       
							if(in_array("total_paid",$fields)) addToFeed('total_paid;');
                           	if(in_array("total_paid_tax_incl",$fields)) addToFeed('total_paid_tax_incl;');
                        	if(in_array("total_paid_tax_excl",$fields)) addToFeed('total_paid_tax_excl;');
                  			if(in_array("total_paid_real",$fields)) addToFeed('total_paid_real;');
							if(in_array("total_products",$fields)) addToFeed('total_products;');
							if(in_array("total_product_wt",$fields)) addToFeed('total_product_wt;');
							if(in_array("total_shipping",$fields)) addToFeed('total_shipping;');
                           	if(in_array("total_shipping_tax_incl",$fields)) addToFeed('total_shipping_tax_incl;');
                        	if(in_array("total_shipping_tax_excl",$fields)) addToFeed('total_shipping_tax_excl;');
                      		if(in_array("carrier_tax_rate",$fields)) addToFeed('carrier_tax_rate;');
							if(in_array("total_wrapping",$fields)) addToFeed('total_wrapping;');
                         	if(in_array("total_wrapping_tax_incl",$fields)) addToFeed('total_wrapping_tax_incl;');
                        	if(in_array("total_wrapping_tax_excl",$fields)) addToFeed('total_wrapping_tax_excl;');
                  			if(in_array("invoice_number",$fields)) addToFeed('invoice_number;');
                          	if(in_array("delivery_number",$fields)) addToFeed('delivery_number;');
                           	if(in_array("invoice_date",$fields)) addToFeed('invoice_date;');
                   			if(in_array("delivery_date",$fields)) addToFeed('delivery_date;');
							if(in_array("valid",$fields)) addToFeed('valid;');
							if(in_array("date_add",$fields)) addToFeed('date_add;');
							if(in_array("date_upd",$fields)) addToFeed('date_upd;');
							if(in_array("customer_infos",$fields)) 
							{
							addToFeed('gender;');
							addToFeed('default_group_name;');
							addToFeed('firstname;');
							addToFeed('lastname;');
							addToFeed('email;');
                          	addToFeed('website;');
                          	addToFeed('company;');
                          	addToFeed('siret;');
                          	addToFeed('ape;');
            				addToFeed('birthday;');
							addToFeed('newsletter;');
							addToFeed('optin;');
							addToFeed('note;');
							addToFeed('active;');
							addToFeed('is_guest;');
							addToFeed('deleted;');
							addToFeed('date_add;');
							addToFeed('date_upd;');
							}
							if(in_array("delivery_address",$fields))
							{
							addToFeed('alias;');
							addToFeed('company;');
							addToFeed('lastname;');
							addToFeed('firstname;');
							addToFeed('address1;');
							addToFeed('address2;');
							addToFeed('postcode;');
							addToFeed('city;');
							addToFeed('country;');
							addToFeed('state;');
							addToFeed('other;');
							addToFeed('phone;');
							addToFeed('phone_mobile;');
							addToFeed('vat_number;');
							addToFeed('dni;');
							addToFeed('date_add;');
							addToFeed('date_upd;');
							addToFeed('active;');
							addToFeed('deleted;');
							
							}
							if(in_array("invoice_address",$fields))
							{
							addToFeed('alias;');
							addToFeed('company;');
							addToFeed('lastname;');
							addToFeed('firstname;');
							addToFeed('address1;');
							addToFeed('address2;');
							addToFeed('postcode;');
							addToFeed('city;');
							addToFeed('country;');
							addToFeed('state;');
							addToFeed('other;');
							addToFeed('phone;');
							addToFeed('phone_mobile;');
							addToFeed('vat_number;');
							addToFeed('dni;');
							addToFeed('date_add;');
							addToFeed('date_upd;');
							addToFeed('active;');
							addToFeed('deleted');
							}
							if(in_array("products",$fields))
							{
							addToFeed("\r\n");
							addToFeed('PRODUCT;');
							addToFeed('id_order;');
							addToFeed('product_id;');
							addToFeed('product_attribute_id;');
							addToFeed('product_name;');
							addToFeed('product_quantity;');
							addToFeed('product_price;');
							addToFeed('reduction_percent;');
							addToFeed('reduction_amount;');
                            addToFeed('reduction_amount_tax_incl;');
                            addToFeed('reduction_amount_tax_excl;');
                            addToFeed('group_reduction;');
                     		addToFeed('product_quantity_discount;');
							addToFeed('product_ean13;');
							addToFeed('product_upc;');
							addToFeed('product_reference;');
							addToFeed('product_supplier_reference;');
							addToFeed('product_weight;');
							addToFeed('tax_name;');
							addToFeed('tax_rate;');
							addToFeed('ecotax;');
							addToFeed('ecotax_tax_rate;');
							addToFeed('discount_quantity_applied;');
							addToFeed('download_hash;');
							addToFeed('download_nb;');
							addToFeed('download_deadline;');
                            addToFeed('total_price_tax_incl;');
                            addToFeed('total_price_tax_excl;');
                            addToFeed('total_shipping_price_tax_incl;');
                            addToFeed('total_shipping_price_tax_excl;');
                            addToFeed('unit_price_tax_excl;');
                            addToFeed('unit_price_tax_excl');
                                
                            
							}
							addToFeed("\r\n");
	
	foreach($orders as $order) 
	{
						
							$orderInfos=New Order($order);
							$products=$orderInfos->getProductsDetail();
							$TotalWeight=Tools::ps_round($orderInfos->getTotalWeight(),2);
							$addressDelivery = new Address($orderInfos->id_address_delivery, (int)($id_lang));
							$countryDel=New Country($addressDelivery->id_country);
							$stateDel=	New State($addressDelivery->id_state);	
							$addressInvoice = new Address($orderInfos->id_address_invoice, (int)($id_lang));
							$countryInv=New Country($addressInvoice->id_country);
							$stateInv=	New State($addressInvoice->id_state);
							$customer=	New Customer($orderInfos->id_customer);	
							$group= New Group($customer->id_default_group);	
							$gender=$customer->id_gender;
						/*	switch ($idgender)
							{
								case 1:
								$gender=$this->l('M');
								break;
								case 2:
								$gender=$this->l('F');
								break;
								case 9:
								$gender=$this->l('?');
								break;
								default:
								$gender=$this->l('?');
								break;
							} */
							
						if($order!="")
						{	
						
							addToFeed('"ORDER";');
							if(in_array("id_order",$fields)) addToFeed('"'.$order.'";');
                         	if(in_array("reference",$fields)) addToFeed('"'.$orderInfos->reference.'";');
                         	if(in_array("id_shop_group",$fields)) addToFeed('"'.$orderInfos->id_shop_group.'";');
                         	if(in_array("id_shop",$fields)) addToFeed('"'.$orderInfos->id_shop.'";');
                         	if(in_array("id_carrier",$fields)) addToFeed('"'.$orderInfos->id_carrier.'";');
                         	if(in_array("id_lang",$fields)) addToFeed('"'.$orderInfos->id_lang.'";');
                         	if(in_array("id_customer",$fields)) addToFeed('"'.$orderInfos->id_customer.'";');
        					if(in_array("id_cart",$fields)) addToFeed('"'.$orderInfos->id_cart.'";');
                          	if(in_array("id_currency",$fields)) addToFeed('"'.$orderInfos->id_currency.'";');
                         	if(in_array("id_address_delivery",$fields)) addToFeed('"'.$orderInfos->id_address_delivery.'";');
                         	if(in_array("id_address_invoice",$fields)) addToFeed('"'.$orderInfos->id_address_invoice.'";');
                         	if(in_array("current_state",$fields)) addToFeed('"'.$orderInfos->current_state.'";');
                         	if(in_array("secure_key",$fields)) addToFeed('"'.$orderInfos->secure_key.'";');
                   			if(in_array("payment",$fields)) addToFeed('"'.$orderInfos->payment.'";');
							if(in_array("conversion_rate",$fields)) addToFeed('"'.$orderInfos->conversin_rate.'";');
							if(in_array("module",$fields)) addToFeed('"'.$orderInfos->module.'";');
							if(in_array("recyclable",$fields)) addToFeed('"'.$orderInfos->recyclable.'";');
							if(in_array("gift",$fields)) addToFeed('"'.$orderInfos->gift.'";');
							if(in_array("gift_message",$fields)) addToFeed('"'.$orderInfos->gift_message.'";');
							if(in_array("shipping_number",$fields)) addToFeed('"'.$orderInfos->shipping_number.'";');
							if(in_array("total_discounts",$fields)) addToFeed('"'.$orderInfos->total_discounts.'";');
                       		if(in_array("total_discounts_tax_incl",$fields)) addToFeed('"'.$orderInfos->total_discounts_tax_incl.'";');
                       		if(in_array("total_discounts_tax_excl",$fields)) addToFeed('"'.$orderInfos->total_discounts_tax_excl.'";');
            				if(in_array("total_paid",$fields)) addToFeed('"'.$orderInfos->total_paid.'";');
                        	if(in_array("total_paid_tax_incl",$fields)) addToFeed('"'.$orderInfos->total_paid_tax_incl.'";');
                        	if(in_array("total_paid_tax_excl",$fields)) addToFeed('"'.$orderInfos->total_paid_tax_excl.'";');
       						if(in_array("total_paid_real",$fields)) addToFeed('"'.$orderInfos->total_paid_real.'";');
							if(in_array("total_products",$fields)) addToFeed('"'.$orderInfos->total_products.'";');
							if(in_array("total_product_wt",$fields)) addToFeed('"'.$orderInfos->total_products_wt.'";');
							if(in_array("total_shipping",$fields)) addToFeed('"'.$orderInfos->total_shipping.'";');
                        	if(in_array("total_shipping_tax_incl",$fields)) addToFeed('"'.$orderInfos->total_shipping_tax_incl.'";');
                       		if(in_array("total_shipping_tax_excl",$fields)) addToFeed('"'.$orderInfos->total_shipping_tax_excl.'";');
       						if(in_array("carrier_tax_rate",$fields)) addToFeed('"'.$orderInfos->carrier_tax_rate.'";');
							if(in_array("total_wrapping",$fields)) addToFeed('"'.$orderInfos->total_wrapping.'";');
                     		if(in_array("total_wrapping_tax_incl",$fields)) addToFeed('"'.$orderInfos->total_wrapping_tax_incl.'";');
                    		if(in_array("total_wrapping_tax_excl",$fields)) addToFeed('"'.$orderInfos->total_wrapping_tax_excl.'";');
           
							if(in_array("invoice_number",$fields)) addToFeed('"'.$orderInfos->invoice_number.'";');
                        	if(in_array("delivery_number",$fields)) addToFeed('"'.$orderInfos->delivery_number.'";');
                         	if(in_array("invoice_date",$fields)) addToFeed('"'.$orderInfos->invoice_date.'";');
                          
                       		if(in_array("delivery_date",$fields)) addToFeed('"'.$orderInfos->delivery_date.'";');
							if(in_array("valid",$fields)) addToFeed('"'.$orderInfos->valid.'";');
							if(in_array("date_add",$fields)) addToFeed('"'.$orderInfos->date_add.'";');
							if(in_array("date_upd",$fields)) addToFeed('"'.$orderInfos->date_upd.'";');
							if(in_array("customer_infos",$fields))
							{
							addToFeed('"'.$gender.'";');
							addToFeed('"'.$group->name[$id_lang].'";');
							addToFeed('"'.$customer->firstname.'";');
							addToFeed('"'.$customer->lastname.'";');
							addToFeed('"'.$customer->email.'";');
                          	addToFeed('"'.$customer->website.'";');
                          	addToFeed('"'.$customer->company.'";');
                          	addToFeed('"'.$customer->siret.'";');
                            addToFeed('"'.$customer->ape.'";');
                       		addToFeed('"'.$customer->birthday.'";');
							addToFeed('"'.$customer->newsletter.'";');
							addToFeed('"'.$customer->optin.'";');
							addToFeed('"'.$customer->note.'";');
							addToFeed('"'.$customer->active.'";');
							addToFeed('"'.$customer->is_guest.'";');
							addToFeed('"'.$customer->deleted.'";');
							addToFeed('"'.$customer->date_add.'";');
							addToFeed('"'.$customer->date_upd.'";');
							
							}
							if(in_array("delivery_address",$fields))
							{
							addToFeed('"'.$addressDelivery->alias.'";');
							addToFeed('"'.$addressDelivery->company.'";');
							addToFeed('"'.$addressDelivery->lastname.'";');
							addToFeed('"'.$addressDelivery->firstname.'";');
							addToFeed('"'.$addressDelivery->address1.'";');
							addToFeed('"'.$addressDelivery->address2.'";');
							addToFeed('"'.$addressDelivery->postcode.'";');
							addToFeed('"'.$addressDelivery->city.'";');
							addToFeed('"'.$countryDel->name[$id_lang].'";');
							addToFeed('"'.$stateDel->iso_code.'";');
							addToFeed('"'.$addressDelivery->other.'";');
							addToFeed('"'.$addressDelivery->phone.'";');
							addToFeed('"'.$addressDelivery->phone_mobile.'";');
							addToFeed('"'.$addressDelivery->vat_number.'";');
							addToFeed('"'.$addressDelivery->dni.'";');
							addToFeed('"'.$addressDelivery->date_add.'";');
							addToFeed('"'.$addressDelivery->date_upd.'";');
							addToFeed('"'.$addressDelivery->active.'";');
							addToFeed('"'.$addressDelivery->deleted.'";');
							
							
							}
							
							if(in_array("invoice_address",$fields))
							{
							addToFeed('"'.$addressInvoice->alias.'";');
							addToFeed('"'.$addressInvoice->company.'";');
							addToFeed('"'.$addressInvoice->lastname.'";');
							addToFeed('"'.$addressInvoice->firstname.'";');
							addToFeed('"'.$addressInvoice->address1.'";');
							addToFeed('"'.$addressInvoice->address2.'";');
							addToFeed('"'.$addressInvoice->postcode.'";');
							addToFeed('"'.$addressInvoice->city.'";');
							addToFeed('"'.$countryInv->name[$id_lang].'";');
							addToFeed('"'.$stateInv->iso_code.'";');
							addToFeed('"'.$addressInvoice->other.'";');
							addToFeed('"'.$addressInvoice->phone.'";');
							addToFeed('"'.$addressInvoice->phone_mobile.'";');
							addToFeed('"'.$addressInvoice->vat_number.'";');
							addToFeed('"'.$addressInvoice->dni.'";');
							addToFeed('"'.$addressInvoice->date_add.'";');
							addToFeed('"'.$addressInvoice->date_upd.'";');
							addToFeed('"'.$addressInvoice->active.'";');
							addToFeed('"'.$addressInvoice->deleted.'"');
							}
							addToFeed("\r\n");
							if(in_array("products",$fields))
							{
								foreach($products as $product)
								{
									addToFeed('"PRODUCT";');
									addToFeed('"'.$order.'";');
									addToFeed('"'.$product['product_id'].'";');
									addToFeed('"'.$product['product_attribute_id'].'";');
									addToFeed('"'.$product['product_name'].'";');
									addToFeed('"'.$product['product_quantity'].'";');
									addToFeed('"'.$product['product_price'].'";');
									addToFeed('"'.$product['reduction_percent'].'";');
									addToFeed('"'.$product['reduction_amount'].'";');
                                	addToFeed('"'.$product['reduction_amount_tax_incl'].'";');
                                	addToFeed('"'.$product['reduction_amount_tax_excl'].'";');
                                   	addToFeed('"'.$product['group_reduction'].'";');
                            		addToFeed('"'.$product['product_quantity_discount'].'";');
									addToFeed('"'.$product['product_ean13'].'";');
									addToFeed('"'.$product['product_upc'].'";');
									addToFeed('"'.$product['product_reference'].'";');
									addToFeed('"'.$product['product_supplier_reference'].'";');
									addToFeed('"'.$product['product_weight'].'";');
									addToFeed('"'.$product['tax_name'].'";');
									addToFeed('"'.$product['tax_rate'].'";');
									addToFeed('"'.$product['ecotax'].'";');
									addToFeed('"'.$product['ecotax_tax_rate'].'";');
									addToFeed('"'.$product['discount_quantity_applied'].'";');
									addToFeed('"'.$product['download_hash'].'";');
									addToFeed('"'.$product['download_nb'].'";');
									addToFeed('"'.$product['download_deadline'].'";');
                                 	addToFeed('"'.$product['total_price_tax_incl'].'";');
                                 	addToFeed('"'.$product['total_price_tax_excl'].'";');
                                 	addToFeed('"'.$product['total_shipping_price_tax_incl'].'";');
                                 	addToFeed('"'.$product['total_shipping_price_tax_excl'].'";');
                                 	addToFeed('"'.$product['unit_price_tax_excl'].'";');
                                 	addToFeed('"'.$product['unit_price_tax_excl'].'"');
                                    
                                    
								
									addToFeed("\r\n");
								}
							}
							
						}	
					
	}
						
function addToFeed($str)
{
Global $filename;
	if(file_exists($filename))
	{
		$fp = fopen($filename, 'ab');
		fwrite($fp, $str, strlen($str));
		fclose($fp);
	}
}

?>
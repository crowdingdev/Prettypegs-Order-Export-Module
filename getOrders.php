<?php
/** Module presta2csvorders compatible PS > 1.5
  * file getOrders.php
  * @author Vinum Master
  * @copyright Vinum Master
  * @version 1.40
  *
  */
include('../../config/config.inc.php');
$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));
$iso=strtolower(Language::getIsoById($id_lang));
include('languages/'.$iso.'.php');


$state=Tools::getValue('state');
$from=Tools::getValue('from');
$to=Tools::getValue('to');
if($from=="")
{
$from=date('Y-m-01');
}
if($to=="")
{
$to=date('Y-m-t');
}

$date= '\''.$from.' 00:00:00\' AND \''.$to.' 23:59:59\' ';
if($state!="0")
{
$sqllist='SELECT * FROM '._DB_PREFIX_.'orders o
								WHERE '.$state.' = (
											SELECT id_order_state
											FROM '._DB_PREFIX_.'order_history oh
											WHERE oh.id_order = o .id_order
											ORDER BY date_add DESC, id_order_history DESC
											LIMIT 1)
								AND o.date_add BETWEEN '.$date.'';
}
else
{
$sqllist='SELECT * FROM '._DB_PREFIX_.'orders o WHERE o.date_add BETWEEN '.$date.'';
}

				$result=Db::getInstance()->executeS($sqllist);


echo "<center><table cellspacing='0' cellpadding='0' class='table' style='width: 29.5em;' name='mytab'>
<tr>
<th style='background-color:#AFF4F7'><input type='checkbox' name='checkme' class='noborder' onclick='mycheckDelBoxes(orderBox);'</th>
<th style='background-color:#AFF4F7'>ID</th>
<th style='background-color:#AFF4F7'>".CUSTOMER."</th>
<th style='background-color:#AFF4F7'>Date</th>
<th style='background-color:#AFF4F7'>".PRICE."</th>
<th style='background-color:#AFF4F7'>".PAYMENT."</th>
</tr>";

if(!is_bool($result))
{
$irow=0;
foreach($result as $order)
  {

  $orderInfo=new Order($order['id_order']);
  $addressDelivery = new Address($orderInfo->id_address_delivery, (int)($id_lang));
  if (version_compare(_PS_VERSION_, '1.6', '>='))
  echo '<tr class="'.($irow++ % 2 ? 'odd' : '').'">';
  else
  echo "<tr class=".($irow++ % 2 ? 'alt_row' : '').">";
  echo "<td><input type='checkbox' name='orderBox'  id='orderBox_".$order['id_order']."' value=".$order['id_order']." checked/></td>";
  echo "<td>".$order['id_order']."</td>";
  echo "<td>".$addressDelivery->firstname." ".$addressDelivery->lastname."</td>";
  echo "<td>".$order['date_add']."</td>";
  echo "<td>".$order['total_paid']."</td>";
  echo "<td>".$order['module']."</td>";
  echo "</tr>";
  }
  }
echo "</table></center><br>";




?>
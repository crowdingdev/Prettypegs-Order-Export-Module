<?php

class DBQueryHelper extends ObjectModel
{

	/**
	* All attributes with name as of language with id = 1
	* @author Linus Karlsson
	*/
	public static function getOrderDetails($id_order)
	{

		$sqlStr = '
			SELECT  *, c.firstname, c.lastname, c.email, a.postcode, a.city, a.id_country, a.phone, a.phone_mobile, a.address1, a.address1, a.company  FROM '._DB_PREFIX_.'order_detail od'.
			' INNER JOIN '._DB_PREFIX_.'orders o ON od.id_order = o.id_order '.
			' INNER JOIN '._DB_PREFIX_.'customer c ON o.id_customer = c.id_customer '.
			' INNER JOIN '._DB_PREFIX_.'address a ON c.id_customer = a.id_customer '.
			' WHERE od.id_order = '. (int)$id_order .
			' GROUP BY od.id_order_detail';

		$result = Db::getInstance()->ExecuteS($sqlStr);

		//return $sqlStr;
		return $result;
	}
}


?>
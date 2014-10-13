<?php

/** Module presta2csvorders compatible PS > 1.5
  *Orders Export tab for admin panel, AdminOrdersExport.php
  * @author Vinum Master
  * @copyright Vinum Master
  * @version 1.30
  *
  */

include_once(PS_ADMIN_DIR.'/../classes/AdminTab.php');
class AdminOrdersExport extends AdminTab
{
	public $fieldnames=array(
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
	

	public function __construct()
	{
		
	 	$this->table = 'ordersexport';
		$this->optionTitle = 'Export Orders';
      	$this->context = Context::getContext();
        $this->lang = true;

	
		$this->_directory = dirname(_PS_MODULE_DIR_).'/modules/presta2csvorders/';
		$this->_filename = $this->_directory.'export.csv';
		$this->_filename_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/presta2csvorders/export.csv';
		$this ->_filenameExport_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/presta2csvorders/export.csv';
		$this->_adminDirectory= dirname(__FILE__).'/';
		$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));
	
    	parent::__construct();
		
	}
	private function _addToFeed($str)
	{
		if(file_exists($this->_filename))
		{
			$fp = fopen($this->_filename, 'ab');
			fwrite($fp, $str, strlen($str));
			fclose($fp);
		}
	}
	private function _postValidation()
	{
	
		@unlink($this->_filename);
		$fp = fopen($this->_filename, 'wb');
		fclose($fp);
		if (!file_exists($this->_filename))
		{
		echo '<div class="warning confirm">
  				<img src="../img/admin/warning.gif" alt="" title="" />
  				Impossible d\'écrire '.realpath($this->_filename).'
  			</div>';
		}
	}
	public function postProcess()
	{
		
		$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));
		$importURL = Configuration::get('VINUM_EXPINET_IMPORTURL');
		$exportURL= Configuration::get('VINUM_EXPINET_EXPORTURL');
		$carriersString= Configuration::get('VINUM_EXPINET_CARRIERS');
		$stateExport = Configuration::get('VINUM_EXPINET_STATE_EXPORT');
        
      // 	$context = Context::getContext();
		$this->context->controller->addJqueryUI('ui.datepicker');
	
	

		if (!empty($_POST))
		{
			   	$this->_postValidation();
		}
			
		if (Tools::isSubmit('export'))
		{
		
		}
		
		else
			parent::postProcess();
	
	}
	
	public function renderList()
	{
		$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));
	    $filename_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/presta2csvexport/export.csv';
 		
	$html = '<fieldset style="background-color: #94B4C0;"><legend>'.$this->l('How to export orders in CSV file ?').'</legend>'.
			'<ul>'.'
				<li>'.$this->l('You can choose the date from and to, to export orders').'<br />'.'</li>
				<li>'.$this->l('The dates can to be selected with predefined buttons or with your own choices').'</li>
				<li>'.$this->l('After you can choose what order state to export').'</li>
				<li>'.$this->l('The orders will be automatically displayed in a datagrid').'</li>
				<li>'.$this->l('And finally you can to choose what fields to export').'</li>
				<li>'.$this->l('Click on "Create CSV" button to create the csv file').'</li>
				<li>'.$this->l('To differentiate the ORDER lines to PRODUCT lines, the first field is automatically named ORDER for orders and PRODUCT for products.').'</li>
			</ul>
		</fieldset><br />
	  
	
		<fieldset style="background-color: #f9e3bd;"><legend>'.$this->l('Export Orders settings').'</legend>
		
		<script language="JavaScript">
    <!--
	function getXMLHttpRequest()
					{
						var xhr = null;
	
						if (window.XMLHttpRequest || window.ActiveXObject)
						{
							if (window.ActiveXObject) 
							{
								try
								{
									xhr = new ActiveXObject("Msxml2.XMLHTTP");
								} catch(e)
								{
									xhr = new ActiveXObject("Microsoft.XMLHTTP");
								}
							} else 
							{
								xhr = new XMLHttpRequest(); 
							}
						} 
						else
						{
							alert("Votre navigateur ne supporte pas l\'objet XMLHTTPRequest...");
							return null;
						}
	
						return xhr;
					}
		
    function showOrders(str)
	{
			
		from="";
		to="";
        state="";
		with(document.Export) 
		{
			from=sp_from.value;
			to=sp_to.value;
           	state=stateExport.value;
		}	
		
       
			
		var xhr = getXMLHttpRequest();
	
	
		xhr.onreadystatechange = function() {
		
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
		
			
			document.getElementById("ordersHint").innerHTML=xhr.responseText;
			document.getElementById("loader").style.display = "none";
		}
		else if (xhr.readyState < 4)
		{
		
			document.getElementById("loader").style.display = "inline";

		}
	};
			
	xhr.open("GET","../modules/presta2csvorders/getOrders.php?state="+state+"&from="+from+"&to="+to,true);
	xhr.send(null);
	

}
function createCSV()
{
	
	var xhr = getXMLHttpRequest();
	
	
		xhr.onreadystatechange = function()
		{
		
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				document.getElementById("loader2").style.display = "none";
				document.getElementById("fileLink").style.display= "block";
	
			}
			else if (xhr.readyState < 4)
			{
				document.getElementById("loader2").style.display = "inline";
			}
		};
	
	var orderlist = "";
	var fieldlist="";
	with(document.Export) 
	{
	
		for(var i = 0; i < orderBox.length; i++)
		{
			if(orderBox[i].checked)
			{
			orderlist += orderBox[i].value + ",";
			}
		}
		if(orderBox.length==undefined)
		{
		
			orderlist=orderBox.value+ ",";
			
		
		}		
		
		for(var i = 0; i < whatfields.length; i++)
		{
		
			if(whatfields[i].checked)
			{
			
			fieldlist += whatfields[i].value + ",";
			}
		}
		
		
	}	
		
	orderlist=orderlist.substr(0,orderlist.length-1);
	fieldlist=fieldlist.substr(0,fieldlist.length-1);
	xhr.open("GET","../modules/presta2csvorders/createCSV.php?ordersID="+orderlist+"&fields="+fieldlist ,true);
	xhr.send(null);
}

function getDay()
{
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
if(month<10)
month="0"+month;
var day = currentTime.getDate();
if(day<10)
day="0"+day;
var year = currentTime.getFullYear();
from=year+"-"+month+"-"+day;
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=from;
	state=stateExport.value;
}	
showOrders(state);
}
function getDay1()
{
currentTime = new Date();
yesterday = new Date(currentTime.getFullYear(),currentTime.getMonth(), currentTime.getDate() - 1);
var month = yesterday.getMonth() + 1;
if(month<10)
month="0"+month;
var day = yesterday.getDate();
if(day<10)
day="0"+day;
var year = yesterday.getFullYear();
from=year+"-"+month+"-"+day;
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=from;
	state=stateExport.value;
}
showOrders(state);	
}
function getMonth()
{
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
if(month<10)
month="0"+month;
var year = currentTime.getFullYear();
dayMonth= new Date(year, month+1, -1).getDate()+1;
from=year+"-"+month+"-01";
to=year+"-"+month+"-"+dayMonth;
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=to;
	state=stateExport.value;
}	
showOrders(state);
}
function getMonth1()
{
currentTime = new Date();
lastMonth = new Date(currentTime.getFullYear(),currentTime.getMonth()-1, currentTime.getDate());
var month = lastMonth.getMonth() + 1;
if(month<10)
month="0"+month;
var year = lastMonth.getFullYear();
dayMonth= new Date(year, month+1, -1).getDate()+1;
from=year+"-"+month+"-01";
to=year+"-"+month+"-"+dayMonth;
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=to;
	state=stateExport.value;
}	
showOrders(state);
}
function getYear()
{
var currentTime = new Date();
var year = currentTime.getFullYear();
from=year+"-01-01";
to=year+"-12-31";
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=to;
	state=stateExport.value;
}	
showOrders(state);
}
function getYear1()
{
var currentTime = new Date();
lastYear = new Date(currentTime.getFullYear()-1,currentTime.getMonth(), currentTime.getDate());
var year = lastYear.getFullYear();
from=year+"-01-01";
to=year+"-12-31";
state="";
with(document.Export) 
{
	sp_from.value=from;
	sp_to.value=to;
	state=stateExport.value;
}	
showOrders(state);
}
function mycheckDelBoxes(whatobj)
{

with(document.Export) 
{

for(var ic = 0; ic < whatobj.length; ic++)
		{
			if(whatobj[ic].checked)
			{
			whatobj[ic].checked=false;
			}
			else
			whatobj[ic].checked=true;
		}
if(whatobj.length==undefined)
{
whatobj[0]=whatobj;
if(whatobj[0].checked)
			{
			whatobj[0].checked=false;
			}
			else
			whatobj[0].checked=true;
}		
}
}
	
    -->
    </script>
		
				<form name="Export" >';
                $html.='
				<script type="text/javascript">
					$(document).ready(function() {
						if ($(".datepicker").length > 0)
							$(".datepicker").datepicker({
								prevText: "",
								nextText: "",
								dateFormat: "yy-mm-dd"
							});
					});
				</script>';
				
				 $html .= '<label>'.$this->l('Available from:').'</label>
			<div >
			<div class="margin-form" >
			<input type="button" name="submitDateDay" id="submitDateDay" class="button" value="'.$this->l('Day').'" onclick="getDay();">
					<input type="button" name="submitDateMonth" class="button" value="'.$this->l('Month').'" onclick="getMonth();">
					<input type="button" name="submitDateYear" class="button" value="'.$this->l('Year').'" onclick="getYear();"><br />
					<input type="button" name="submitDateDayPrev" class="button" value="'.$this->l('Day-1').'" style="margin-top:2px" onclick="getDay1();">
					<input type="button" name="submitDateMonthPrev" class="button" value="'.$this->l('Month-1').'" style="margin-top:2px" onclick="getMonth1();">
					<input type="button" name="submitDateYearPrev" class="button" value="'.$this->l('Year-1').'" style="margin-top:2px" onclick="getYear1();"><br>
				<input type="text" class="datepicker" name="sp_from" value="" style="text-align: center" id="sp_from" onchange="showOrders();" /><span style="font-weight:bold; color:#000000; font-size:12px"> Au:</span>
				<input type="text" class="datepicker" name="sp_to" value="" style="text-align: center" id="sp_to" onchange="showOrders();" />
			</div>';
			
			$states=OrderState::getOrderStates($id_lang);
			
			$html .= '<label>'.$this->l('Export State :').'</label>
					<div class="margin-form" style="margin-top:10px">
					<select id="stateExport" name="stateExport" onchange="showOrders(this.value);">
					<option value="0" selected>'.$this->l('All').'</option>';
					foreach($states as $state)
					{
						$html .= '<option value="'.$state['id_order_state'].'">'.$state['name'].'</option>';
						
					}
						$html .= '</select>
						<p style="padding:0px; margin:10px 0px 10px 0px;">'.$this->l('(Select state for which you want to display orders you want to export)').'</p></div>';
	  $html .=  '</div><center>
			<span id="loader" style="display: none;"><img src="../modules/presta2csvorders/loader.gif" alt="loading" /></span></center>';		 
	
		$html .= '<div id="ordersHint"></div>';
		
		$defaultLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
	
		$html .= '</fieldset><br>
		<fieldset><legend><img src="'.'../modules/presta2csvorders/logo.gif" alt="" title="" />'.$this->l('Choose fields to export').'</legend>
		<center><span id="loader2" style="display: none;"><img src="../modules/presta2csvorders/loader.gif" alt="loading" /></span></center>	
<div id="fileLink" style="display:none;">
			    	<br>'.$this->l('Your csv file is online at the following url :').'<br /><br><a href="'.$this ->_filenameExport_http.'" target="_blanck"><b>'.$this ->_filenameExport_http.'</b></a></p>
					</div></center>
			
	
		      <center><input type="button" name="submitFields" value="'.$this->l('Create CSV').'" onClick="createCSV();"/><br><br>
		      <input type="button" onclick="mycheckDelBoxes(whatfields);" value="'.$this->l('Select All').'" />
					<input type="button" onclick="mycheckDelBoxes(whatfields);" value="'.$this->l('Unselect All').'" /><br></center>';
		$html .= '<br><table style="text-align: left; width: 850px;" ><tr><td><br>
				<span style="font-weight: bold; color: rgb(153, 0, 0);">'.$this->l('Choose the fields you want to export :').'<br><br></span></td><tr>
				<td>';
     
    $compte=0;      		
		foreach($this->fieldnames as $key=>$name)
    {
			/*$selected='';
			if(isset($_POST['whatfields'])){
				if(in_array($key, $_POST['whatfields'])){
					$selected=' checked';
				}
			}*/
	
			if($compte<18)
			{
			
      $html .= '	
			<span style="font-weight: bold;">'.$this->l($name).'</span>&nbsp<input type="checkbox" name="whatfields" id="field'.$key.'" value="'.$key.'" />
			<small><small style="color: rgb(130, 130, 130);">'.$this->l($key).'</small></small>
			<br><br>	';
			$compte++;
			}
			else
			{
      $html .= '</td><td><span style="font-weight: bold;">'.$this->l($name).'</span>&nbsp<input type="checkbox" name="whatfields" id="field'.$key.'" value="'.$key.'" />
	 <small><small style="color: rgb(130, 130, 130);">'.$this->l($key).'</small></small>
		
			<br><br>';
			$compte=1;
      }
		}
		
		$html .= '</td></tr></table><br><br><center>
		 <input type="button" onclick="mycheckDelBoxes(whatfields);" value="'.$this->l('Select All').'" />
					<input type="button" onclick="mycheckDelBoxes(whatfields);" value="'.$this->l('Unselect All').'" /><br>
	  			<br><input type="button" name="submitFields" value="'.$this->l('Create CSV').'" onclick="createCSV();" /></center>';
	
		$html .= '</form></fieldset></div>';
		
		
	
	
     $this->content= $html;
        
        
    	
		return parent::renderList();	
			
	}
	
	

		public function displayForm($isMainTab = true)
	{
	
			return parent::displayForm();
		
			
	}

}

?>
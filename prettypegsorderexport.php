<?php
/** Module presta2csvorders compatible PS > 1.5 and 1.6
  * file presta2csvorders.php
  * @author Vinum Master
  * @copyright Vinum Master
  * @version 1.40
  *
  */
class PrettypegsOrderExport extends Module
{
	private $_postErrors = array();


	function __construct()
	{
	    if (version_compare(_PS_VERSION_, '1.6', '>='))
		$this->bootstrap = true;

		$this->name = 'prettypegsorderexport';
		$this->tab = 'export';
		$this->version = '1.0';
		$this->author = 'Linus Karlsson';
		$this->module_key= '706eaa94138178f175c1fab2b2f550c1';

		/* The parent construct is required for translations */
		parent::__construct();

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Prettypegs Order Export');
		$this->description = $this->l('Prettypegs special order export system.');

		$this->_directory = dirname(__FILE__).'/';
		$this->_filename = $this->_directory.'export.csv';
		$this->_filename_http = 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'modules/prettypegsorderexport/export.csv';


	}

	function install()
	{
		if (!parent::install())
			return false;

		$id_lang = intval(Configuration::get('PS_LANG_DEFAULT'));

		$tab=new tab();
		$tab->name[$id_lang]= 'Prettypegs Orders Export';
		$tab->class_name= 'PrettypegsAdminOrdersExport';
		$tab->id_parent=Tab::getIdFromClassName('AdminOrders');
        $tab->module = $this->name;
		$tab->add();
			return true;



	}

	  function uninstall()
    {
        if (!parent::uninstall())
		return false;
		$idtab=tab::getIdFromClassName('PrettypegsAdminOrdersExport');
		$tab=new tab($idtab);
		$tab->delete();
			return true;
    }






}
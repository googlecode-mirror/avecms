<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = 'Магазин';
	$modul['ModulPfad'] = 'shop';
	$modul['ModulVersion'] = '1.4';
	$modul['description'] = 'Модуль электронного магазина';
	$modul['Autor'] = "Bj&ouml;rn Wunderlich";
	$modul['MCopyright'] = "&copy; 2006 ";
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 0;
	$modul['ModulTemplate'] = 1;
	$modul['AdminEdit'] = 1;
	$modul['ModulFunktion'] = null;
	$modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=shop">index.php?module=shop</a>';
	$modul['CpEngineTag'] = null;
	$modul['CpPHPTag'] = null;
}

//if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'shop'  && UGROUP != '2') || (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'shop'))
if ((isset($_REQUEST['module']) && $_REQUEST['module'] == 'shop') || (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'shop'))
{
	global $AVE_Template;

	if (defined('SSLMODE') && SSLMODE == 1 && $_SERVER['SERVER_PORT'] == '80') header('Location:'.get_redirect_link());
	if (defined('SSLMODE') && SSLMODE != 1 && $_SERVER['SERVER_PORT'] == '443') header('Location:'.get_redirect_link());

	//=======================================================
	// Klasse einbinden
	//=======================================================
	if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
	{
		require_once(BASE_DIR . '/modules/shop/class.shop_admin.php');
	}
	else
	{
		require_once(BASE_DIR . '/modules/shop/class.shop.php');
	}
//	require_once(BASE_DIR . '/functions/func.modulglobals.php');
	require_once(BASE_DIR . '/modules/shop/funcs/func.parent_categ.php');
	require_once(BASE_DIR . '/modules/shop/funcs/func.rewrite.php');

	if (defined('THEME_FOLDER')) $AVE_Template->assign('shop_images', 'templates/' . THEME_FOLDER . '/modules/shop/');

	function cpShopNavi()
	{
		require_once(BASE_DIR . '/functions/func.modulglobals.php');
		set_modul_globals('shop');
		$shop = new Shop;
		$shop->fetchShopNavi();
	}

	if (defined('THEME_FOLDER')) $AVE_Template->assign('theme_folder', THEME_FOLDER);

	$_REQUEST['action'] = empty($_REQUEST['action']) ? 'shopstart' : $_REQUEST['action'];

	if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'shop')
	{
		require_once(BASE_DIR . '/functions/func.modulglobals.php');
		set_modul_globals('shop');
		$shop = new Shop;

		switch ($_REQUEST['action'])
		{
			case 'shopstart':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->displayShopStart();
				break;

			case 'product_detail':
				if (!isset($_REQUEST['product_id']) || !is_numeric($_REQUEST['product_id']))
				{
					header('Location:index.php?module=shop');
					exit;
				}
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->showDetails($_REQUEST['product_id']);
				break;

			case 'addtobasket':
				$shop->checkShop();
				$shop->addtoBasket($_REQUEST['product_id']);
				break;

			case 'addtowishlist':
				$shop->checkShop();
				$shop->addtoBasket($_REQUEST['product_id'], 0, 1);
				break;

			case 'delitem':
				$shop->delItem($_REQUEST['product_id']);
				break;

			case 'showbasket':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->showBasket();
				break;

			case 'checkout':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->checkOut();
				break;

			case 'checkoutinfo':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->checkOutInfo();
				break;

			case 'PaymentInfo':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->PaymentInfo($_REQUEST['theme_folder'], $_REQUEST['payid']);
				break;

			case 'myorders':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->myOrders();
				break;

			case 'mydownloads':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->myDownloads();
				break;

			case 'infopage':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->getInfoPage();
				break;

			case 'wishlist':
				$shop->checkShop();
				$shop->getTplSettings();
				$shop->myWishlist();
				break;
		}
	}

	//=======================================================
	// Admin - Aktionen
	//=======================================================
	if (defined('ACP') && !empty($_REQUEST['moduleaction']))
	{
		require_once(BASE_DIR . '/modules/shop/sql.php');

		$tpl_dir = BASE_DIR . '/modules/shop/templates_admin/';
		$tpl_dir_source = BASE_DIR . '/modules/shop/templates_admin';
		$lang_file = BASE_DIR . '/modules/shop/lang/' . $_SESSION['admin_language'] . '.txt';

		$AVE_Template->config_load($lang_file, 'admin');
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);
		$AVE_Template->assign('source', $tpl_dir_source);

		$shop = new Shop;

		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				$shop->shopStart($tpl_dir);
				break;

			case 'settings':
				$shop->Settings($tpl_dir);
				break;

			case 'email_settings':
				$shop->emailSettings($tpl_dir);
				break;

			case 'shipping':
				$shop->shopShipper($tpl_dir);
				break;


			case 'edit_comments':
				$shop->editComments($tpl_dir);
				break;

			case 'editshipper':
				$shop->editShipper($tpl_dir);
				break;

			case 'editshipper_cost':
				$shop->editshipperCost($tpl_dir);
				break;

			case 'paymentmethods':
				$shop->paymentMethods($tpl_dir);
				break;

			case 'editpaymentmethod':
				$shop->editPaymentMethod($tpl_dir, $_REQUEST['Id']);
				break;

			case 'deletemethod':
				$shop->deleteMethod($_REQUEST['MId']);
				break;

			case 'timeshipping':
				$shop->shipperTime($tpl_dir);
				break;

			case 'timeshippingnew':
				$shop->shipperTimeNew();
				break;

			case 'newmethod':
				$shop->newPaymentMethod();
				break;

			case 'variants_categories':
				$shop->variantsCategories($tpl_dir);
				break;

			case 'edit_variants_category':
				$shop->editVariantsCategory($tpl_dir, $_REQUEST['Id']);
				break;

			case 'new_variants_category':
				$shop->newVariantsCategories();
				break;

			case 'delete_variants_category':
				$shop->deleteVariantsCategory($_REQUEST['Id']);
				break;

			case 'products':
				$shop->displayProducts($tpl_dir);
				break;

			case 'product_new':
				$shop->newProduct($tpl_dir);
				break;

			case 'edit_product':
				$shop->editProduct($tpl_dir, $_REQUEST['Id']);
				break;

			case 'product_vars':
				$shop->prouctVars($tpl_dir, $_REQUEST['Id'], $_REQUEST['KatId']);
				break;

			case 'units':
				$shop->Units($tpl_dir);
				break;

			case 'units_new':
				$shop->UnitsNew();
				break;

			case 'manufacturer':
				$shop->Manufacturer($tpl_dir);
				break;

			case 'manufacturer_new':
				$shop->ManufacturerNew();
				break;

			case 'couponcodes':
				$shop->couponCodes($tpl_dir);
				break;

			case 'couponcodes_new':
				$shop->couponCodesNew();
				break;

			case 'product_categs':
				$shop->productCategs($tpl_dir);
				break;

			case 'delcateg':
				$shop->delCategCall($_REQUEST['Id']);
				break;

			case 'edit_categ':
				$shop->editCateg($tpl_dir, $_REQUEST['Id']);
				break;

			case 'new_categ':
				$shop->newCateg($tpl_dir);
				break;

			case 'showorder':
				$shop->showOrder($tpl_dir, $_REQUEST['Id']);
				break;

			case 'showorders':
				$shop->showOrders($tpl_dir);
				break;

			case 'mailpage':
				$shop->mailPage($tpl_dir, $_REQUEST['OrderId']);
				break;

			case 'mark_failed':
				$shop->markFailed($_REQUEST['Id']);
				break;

			case 'showmoney':
				$shop->showMoney($tpl_dir);
				break;

			case 'esd_downloads':
				$shop->esdDownloads($tpl_dir);
				break;

			case 'vatzones':
				$shop->vatZones($tpl_dir);
				break;

			case 'dataexport':
				$shop->dataExport($tpl_dir);
				break;

			case 'helppages' :
				$shop->helpPages($tpl_dir);
				break;

			case 'shopimport':
				$shop->shopImport($tpl_dir);
				break;

			case 'userimport':
				$shop->userImport($tpl_dir);
				break;

			case 'customerdiscounts':
				$shop->customerDiscounts($tpl_dir);
				break;

			case 'shop_downloads':
				$shop->shopDownloads($tpl_dir);
				break;

			case 'staffel_preise':
				$shop->staffelPreise($tpl_dir);
				break;

			case 'ximp':
				$shop->imp();
				break;

			case 'settingsyml':
				$shop->settingsYML($tpl_dir);
				break;
		}
	}
}

?>
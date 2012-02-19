<?php

/**
 * AVE.cms - Модуль Корзина
 *
 * @package AVE.cms
 * @subpackage module_Basket
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
	$modul['ModulName'] = 'Корзина';
	$modul['ModulPfad'] = 'basket';
	$modul['ModulVersion'] = '1.0';
	$modul['description'] = 'Модуль позволяет организовать торговлю любыми товарами с использованием корзины и формы оформления заказа. Разместите системный тег <strong>[mod_basket]</strong> в нужном месте вашего шаблона сайта или содержимом документа.';
	$modul['Autor'] = 'идея Repellent & BITMAP, реализация Yesvik';
	$modul['MCopyright'] = '&copy; 2010 Overdoze Team';
	$modul['Status'] = 1;
	$modul['IstFunktion'] = 1;
	$modul['AdminEdit'] = 0;
	$modul['ModulFunktion'] = 'mod_basket';
	$modul['CpEngineTagTpl'] = '[mod_basket]';
	$modul['CpEngineTag'] = '#\\\[mod_basket]#';
	$modul['CpPHPTag'] = "<?php mod_basket(); ?>";
}

/**
 * Обработка тега модуля
 *
 */
function mod_basket()
{
	global $AVE_Template;

	// Если выводится страница модуль Корзина - корзину не выводим
	if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'basket') return;

	require_once(BASE_DIR . '/modules/basket/class.basket.php');

	$oBasket = new ModulBasket;

	$AVE_Template->register_object('oBasket', $oBasket);

	$AVE_Template->config_load(BASE_DIR . '/modules/basket/lang/' . $_SESSION['user_language'] . '.txt');

	$AVE_Template->display(BASE_DIR . '/modules/basket/templates/basket_show.tpl');
}

if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'basket' && !empty($_REQUEST['action']))
{
	require_once(BASE_DIR . '/modules/basket/class.basket.php');

	$oBasket = new ModulBasket;

	$AVE_Template->register_object('oBasket', $oBasket);

	$AVE_Template->config_load(BASE_DIR . '/modules/basket/lang/' . $_SESSION['user_language'] . '.txt');

	switch ($_REQUEST['action'])
	{
		case 'add':
			$p_id     = (isset($_REQUEST['p_id']))     ? (int)$_REQUEST['p_id']     : 0;
			$p_name   = (isset($_REQUEST['p_name']))   ? (int)$_REQUEST['p_name']   : 0;
			$p_price  = (isset($_REQUEST['p_price']))  ? (int)$_REQUEST['p_price']  : 0;
			$quantity = (isset($_REQUEST['quantity'])) ? (int)$_REQUEST['quantity'] : 1;
			$oBasket->basketProductAdd($p_id, $p_name, $p_price, $quantity);
			if (empty($_POST['action']))
			{
				header("Location:" . get_referer_link());
			}
			else
			{   
				$AVE_Template->display(BASE_DIR . '/modules/basket/templates/basket_show.tpl');
			}
			exit;

		case 'delete':
			$id = (isset($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
			$oBasket->basketProductDelete($id);
			if (empty($_POST['action']))
			{
				header("Location:" . get_referer_link());
			}
			else
			{   
				$AVE_Template->display(BASE_DIR . '/modules/basket/templates/basket_show.tpl');
			}
			exit;

		case 'order':
			define('MODULE_SITE', $AVE_Template->get_config_vars('BASKET_TITLE'));
			define('MODULE_CONTENT', $AVE_Template->fetch(BASE_DIR . '/modules/basket/templates/order_show.tpl'));
			break;

		case 'update':
			$product_delete   = isset($_REQUEST['product_delete']) ? $_REQUEST['product_delete'] : null;
			$product_quantity = isset($_REQUEST['product_quantity']) ? $_REQUEST['product_quantity'] : null;
			$oBasket->basketOrderUpdate($product_quantity, $product_delete);
			if (empty($_POST['action']))
			{
				header("Location:" . get_referer_link());
			}
			else
			{   
				$AVE_Template->display(BASE_DIR . '/modules/basket/templates/order_show.tpl');
			}
			exit;

		case 'form':
			define('MODULE_SITE', $AVE_Template->get_config_vars('BASKET_TITLE'));
			define('MODULE_CONTENT', $AVE_Template->fetch(BASE_DIR . '/modules/basket/templates/order_form.tpl'));
			break;

		case 'send':
			$oBasket->basketOrderSend();
			define('MODULE_SITE', $AVE_Template->get_config_vars('BASKET_TITLE'));
			define('MODULE_CONTENT', $AVE_Template->fetch(BASE_DIR . '/modules/basket/templates/order_finish.tpl'));
			break;
	}
}

?>
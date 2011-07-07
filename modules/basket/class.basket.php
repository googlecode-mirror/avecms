<?php

/**
 * Класс работы с Корзиной
 *
 * @package AVE.cms
 * @subpackage module_Basket
 * @filesource
 */
class ModulBasket
{

/**
 *	СВОЙСТВА
 */

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Получить список товаров в корзине
	 *
	 */
	function getBasket()
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT
				b.basket_product_id AS id,
				f.field_value AS name,
				b.basket_product_quantity AS quantity,
				b.basket_product_amount AS amount
			FROM
				" . PREFIX . "_modul_basket AS b
			LEFT JOIN
				" . PREFIX . "_document_fields AS f
					ON f.Id = b.basket_product_name_id
			WHERE b.basket_session_id = '" . session_id() . "'
			ORDER BY b.id ASC
		");

		$total = 0;
		$products = array();
		while($row = $sql->FetchRow())
		{
			$total += $row->amount;
			$row->price = $row->amount / $row->quantity;
			array_push($products, $row);
		}

		return array('products' => $products, 'total' => $total);
	}

	/**
	 * Добавить товар в корзину
	 *
	 * @param int $product_id	идентификатор товара
	 * 							(идентификатор документа с атрибутами товара)
	 * @param int $name_id		идентификатор наименования товара
	 * 							(идентификатор поля рубрики для наименования)
	 * @param int $price_id		идентификатор цены товара
	 * 							(идентификатор поля рубрики для цены)
	 * @param int $quantity		количество добавляемых в корзину товаров
	 */
	function basketProductAdd($product_id = 0, $name_id = 0, $price_id = 0, $quantity = 1)
	{
		global $AVE_DB;

		$product_id	= (int)$product_id;
		$name_id	= (int)$name_id;
		$price_id	= (int)$price_id;
		$quantity	= (int)$quantity;

		if ($product_id === 0 || $name_id === 0 || $price_id === 0 || $quantity === 0) return;

		$session_id	= session_id();

		$sql = $AVE_DB->Query("
			SELECT
				Id,
				rubric_field_id,
				field_value
			FROM " . PREFIX . "_document_fields
			WHERE document_id = '" . $product_id . "'
			AND (rubric_field_id = '" . $name_id . "' OR rubric_field_id = '" . $price_id . "')
		");

		$product = array();
		while ($row = $sql->FetchRow())
		{
			$product[$row->rubric_field_id] = array('id'  => $row->Id,
													'val' => $row->field_value);
		}

		if (!empty($product))
		{
			$exists = $AVE_DB->Query("
				SELECT 1
				FROM " . PREFIX . "_modul_basket
				WHERE basket_product_id = '" . $product_id . "'
				AND basket_session_id   = '" . $session_id . "'
			")->GetCell();

			if ($exists)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_basket
					SET
						basket_product_quantity = basket_product_quantity + " . $quantity . ",
						basket_product_amount   = basket_product_amount + " . $quantity * $product[$price_id]['val'] . "
					WHERE basket_product_id = '" . $product_id . "'
					AND basket_session_id   = '" . $session_id . "'
				");
			}
			else
			{
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_basket
					SET
						basket_session_id       = '" . $session_id . "',
						basket_product_id       = '" . $product_id . "',
						basket_product_name_id  = '" . $product[$name_id]['id'] . "',
						basket_product_price_id = '" . $product[$price_id]['id'] . "',
						basket_product_quantity = '" . $quantity . "',
						basket_product_amount   = '" . $quantity * $product[$price_id]['val'] . "'
				");
			}
		}
	}

	/**
	 * Удалить товар из корзины
	 *
	 * @param int $product_id
	 */
	function basketProductDelete($product_id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_basket
			WHERE basket_product_id = '" . (int)$product_id . "'
			AND basket_session_id = '" . session_id() . "'
		");
	}

	/**
	 * Пересчет корзины
	 *
	 * @param array $quantity
	 * @param array $delete
	 */
	function basketOrderUpdate($quantity = array(), $delete = array())
	{
		global $AVE_DB;

		if (!(isset($delete) && is_array($delete))) $delete = array();

		$session_id = session_id();

		// Изменяем в корзине количества товаров
		if (isset($quantity) && is_array($quantity))
		{
			foreach ($quantity as $product_id => $product_quantity)
			{
				$product_id = (int)$product_id;
				if (!is_numeric($product_quantity)) continue;
				$product_quantity = (int)$product_quantity;
				// если количество равно 0 - удаляем товар из корзины
				if ($product_quantity === 0) $delete[$product_id] = 1;
				if (isset($delete[$product_id])) continue;

				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_basket
					SET
						basket_product_amount = basket_product_amount / basket_product_quantity * " . $product_quantity . ",
						basket_product_quantity = '" . $product_quantity . "'
					WHERE basket_product_id = '" . $product_id . "'
					AND basket_session_id   = '" . $session_id . "'
				");
			}
		}

		// Удаляем помеченные товары
		foreach ($delete as $product_id => $val)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_basket
				WHERE basket_product_id = '" . (int)$product_id . "'
				AND basket_session_id = '" . $session_id . "'
			");
		}
	}

	/**
	 * Отправка заказа
	 *
	 */
	function basketOrderSend()
	{
		global $AVE_DB, $AVE_Template;

		$customer = array();

		$customer['name'] = isset($_REQUEST['name']) ? trim(stripslashes($_REQUEST['name'])) : '';
		if ($customer['name'] !== '') $customer['name'] = preg_replace('/[^\x20-\xFF]|[><]/', '', $customer['name']);

		$customer['email'] = isset($_REQUEST['email']) ? trim(stripslashes($_REQUEST['email'])) : '';
		if ($customer['email'] !== '')
		{
			$regex_email = '/^[\w.-]+@[a-z0-9.-]+\.(?:[a-z]{2}|com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|museum)$/i';
			if (!preg_match($regex_email, $customer['email'])) $customer['email'] = '';
		}

		$customer['phone'] = isset($_REQUEST['phone']) ? trim(stripslashes($_REQUEST['phone'])) : '';
		if ($customer['phone'] !== '') $customer['phone'] = preg_replace('/[^\x20-\xFF]|[><]/', '', $customer['phone']);

		$customer['address'] = isset($_REQUEST['address']) ? trim(stripslashes($_REQUEST['address'])) : '';
		if ($customer['address'] !== '') $customer['address'] = preg_replace('/[^\x20-\xFF]|[><]/', '', $customer['address']);

		$customer['description'] = isset($_REQUEST['description']) ? trim(stripslashes($_REQUEST['description'])) : '';
		if ($customer['description'] !== '') $customer['description'] = preg_replace('/[^\x20-\xFF]|[><]/', '', $customer['description']);

		// Передаем в шаблон информацию о заказчике
		$AVE_Template->assign('customer', $customer);

		// Формируем тело письма
		$mail_body = $AVE_Template->fetch(BASE_DIR . '/modules/basket/templates/mail_text.tpl');

		// Если заказчик указал E-mail - отправляем письмо заказчику
		if ($customer['email'])
		{
			send_mail(
				$customer['email'],
				$mail_body,
				$AVE_Template->get_config_vars('BASKET_SHOP_NAME') . ' '
					. $AVE_Template->get_config_vars('BASKET_ORDER_TITLE'),
				get_settings('mail_from'),
				$AVE_Template->get_config_vars('BASKET_SHOP_NAME'),
				'html'
			);
		}

		// Письмо администратору
		send_mail(
			get_settings('mail_from'),
			$mail_body,
			$AVE_Template->get_config_vars('BASKET_SHOP_NAME') . ' '
				. $AVE_Template->get_config_vars('BASKET_ORDER_TITLE'),
			get_settings('mail_from'),
			$AVE_Template->get_config_vars('BASKET_SHOP_NAME'),
			'html'
		);

		// Удаляем заказ из корзины
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_basket
			WHERE basket_session_id = '" . session_id() . "'
		");
	}
}

?>
<?php

/**
 * Класс генерации YML (Yandex Market Language)
 * описание формата данных YML http://partner.market.yandex.ru/legal/tt/
 *
 * @package AVE.cms
 * @filesource
 */
class AVE_YML
{

/**
 *	СВОЙСТВА
 */

	var $from_charset = 'windows-1251';
	var $shop = array('name'=>'', 'company'=>'', 'url'=>'');
	var $currencies = array();
	var $categories = array();
	var $offers = array();

	/**
	 * Конструктор
	 *
	 * @param string $from_charset
	 */
	function AVE_YML($from_charset = 'windows-1251')
	{
		$this->from_charset = trim(strtolower($from_charset));
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Формирование массива для элемента shop описывающего магазин
	 *
	 * @param string $name - Короткое название магазина (название, которое выводится в списке
	 * 		найденных на Яндекс.Маркете товаров. Не должно содержать более 20 символов).
	 * 		Нельзя использовать слова, не имеющие отношения к наименованию магазина ("лучший", "дешевый"),
	 *		указывать номер телефона и т.п. Название магазина, должно совпадать с фактическим названием
	 * 		магазина, которое публикуется на сайте. При несоблюдении данного требования наименование
	 * 		может быть изменено Яндексом самостоятельно без уведомления Клиента.
	 * @param string $company - Полное наименование компании, владеющей магазином.
	 * 		Не публикуется, используется для внутренней идентификации.
	 * @param string $url - URL-адрес главной страницы магазина
	 */
	function set_shop($name, $company, $url)
	{
		$this->shop['name'] = substr($this->_prepare_field($name), 0, 20);
		$this->shop['company'] = $this->_prepare_field($company);
		$this->shop['url'] = $this->_prepare_field($url);
	}

	/**
	 * Добавление валюты
	 *
	 * @param string $id - код валюты (RUR, UAH, USD, EUR...)
	 * @param float|string $rate - курс этой валюты к валюте, взятой за единицу.
	 *	Параметр rate может иметь так же следующие значения:
	 *		CBRF - курс по Центральному банку РФ.
	 *		NBU - курс по Национальному банку Украины.
	 *		СВ - курс по банку той страны, к которой относится интернет-магазин
	 * 		по Своему региону, указанному в Партнерском интерфейсе Яндекс.Маркета.
	 * @param int $plus - используется только в случае rate = CBRF, NBU или СВ
	 *		и означает насколько увеличить курс в процентах от курса выбранного банка
	 * @return bool
	 */
	function add_currency($id, $rate = 'CBRF', $plus = 0)
	{
		$rate = strtoupper($rate);
		$allow_rate = array('CBRF', 'NBU', 'CB');
		if (in_array($rate, $allow_rate))
		{
			$plus = str_replace(',', '.', $plus);
			if ($plus > 0)
			{
				$this->currencies[] = array(
					'id'=>$this->_prepare_field(strtoupper($id)),
					'rate'=>$rate,
					'plus'=>(float)$plus
				);
			}
			else
			{
				$this->currencies[] = array(
					'id'=>$this->_prepare_field(strtoupper($id)),
					'rate'=>$rate
				);
			}
		}
		else
		{
			$rate = str_replace(',', '.', $rate);
			$this->currencies[] = array(
				'id'=>$this->_prepare_field(strtoupper($id)),
				'rate'=>(float)$rate
			);
		}

		return true;
	}

	/**
	 * Добавление категории товаров
	 *
	 * @param string $name - название рубрики
	 * @param int $id - id рубрики
	 * @param int $parent_id - id родительской рубрики, если нет, то -1
	 * @return bool
	 */
	function add_category($name, $id, $parent_id = -1)
	{
		if ((int)$id < 1 || trim($name) == '') return false;
		if ((int)$parent_id > 0)
		{
			$this->categories[] = array(
				'id'=>(int)$id,
				'parentId'=>(int)$parent_id,
				'name'=>$this->_prepare_field($name)
			);
		}
		else
		{
			$this->categories[] = array(
				'id'=>(int)$id,
				'name'=>$this->_prepare_field($name)
			);
		}

		return true;
	}

	/**
	 * Добавление товарного предложения
	 *
	 * @param int $id - id товара (товарного предложения)
	 * @param array $data - массив остальных параметров (звездочкой помечены обязательные)
	 *	*url - URL-адрес страницы товара.
	 *	*name - Наименование товарного предложения.
	 *	*description - Описание товарного предложения.
	 *	*price - Цена, по которой данный товар можно приобрести.
	 *		Цена товарного предложения округляеся и выводится в зависимости от настроек пользователя.
	 *	*currencyId - Идентификатор валюты товара (RUR, USD, UAH).
	 *		Для корректного отображения цены в национальной валюте, необходимо использовать
	 * 		идентификатор (например, UAH) с соответствующим значением цены.
	 *	*categoryId - Идентификатор категории товара (целое число не более 18 знаков).
	 *		Товарное предложение может принадлежать только одной категории.
	 *	*delivery - Элемент, обозначающий возможность доставить соответствующий товар.
	 *		"false" данный товар не может быть доставлен("самовывоз").
	 *		"true" товар доставляется на условиях, которые указываются в партнерском интерфейсе
	 * 			 http://partner.market.yandex.ru на странице "редактирование".
	 *	picture - Ссылка на картинку соответствующего товарного предложения.
	 * 		Недопустимо давать ссылку на "заглушку", т.е. на картинку где написано
	 * 		"картинка отсутствует" или на логотип магазина.
	 *	vendor - Производитель.
	 *	vendorCode - Код товара (указывается код производителя).
	 *	local_delivery_cost - Стоимость доставки данного товара в Своем регионе.
	 *	sales_notes - Элемент, предназначенный для того, чтобы показать пользователям,
	 * 		чем отличается данный товар от других, или для описания акций магазина (кроме скидок).
	 * 		Допустимая длина текста в элементе - 50 символов.
	 *	manufacturer_warranty - Элемент предназначен для отметки товаров,
	 * 		имеющих официальную гарантию производителя. {true|false}
	 *	country_of_origin - Элемент предназначен для указания страны производства товара.
	 *	downloadable - Элемент предназначен для обозначения товара, который можно скачать.
	 * @param bool $available - Статус доступности товара - в наличии/на заказ.
	 *	"true" - товарное предложение в наличии.
	 * 		Магазин готов сразу договариваться с покупателем о доставке товара
	 *	"false" - товарное предложение на заказ.
	 * 		Магазин готов осуществить поставку товара на указанных условиях в течение месяца
	 *		(срок может быть больше для товаров, которые всеми участниками рынка поставляются только на заказ)..
	 *		Те товарные предложения, на которые заказы не принимаются, не должны выгружаться в Яндекс.Маркет.
	 */
	function add_offer($id, $data, $available = true)
	{
		$allowed = array(
			'url',
			'price',
			'currencyId',
			'categoryId',
			'picture',
			'delivery',
			'local_delivery_cost',
			'name',
			'vendor',
			'vendorCode',
			'description',
			'sales_notes',
			'manufacturer_warranty',
			'country_of_origin',
			'downloadable'
		);

		foreach ($data as $k=>$v)
		{
			if (!in_array($k, $allowed)) unset($data[$k]);
			$data[$k] = strip_tags($this->_prepare_field($v));
		}
		$tmp = $data;
		$data = array();
		// Стандарт XML учитывает порядок следования элементов,
		// поэтому важно соблюдать его в соответствии с порядком описанным в DTD
		foreach ($allowed as $key)
		{
			if (isset($tmp[$key])) $data[$key] = $tmp[$key];
		}
		$this->offers[] = array(
			'id'=>(int)$id,
			'data'=>$data,
			'available'=>($available) ? 'true' : 'false'
		);
	}

	/**
	 * Получить весь ХML код
	 *
	 * @return string
	 */
	function get_xml()
	{
		$xml  = '<?xml version="1.0" encoding="windows-1251"?>' . "\r\n";
		$xml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . "\r\n";
		$xml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">' . "\r\n";
		$xml .= $this->_get_xml_shop();
		$xml .= '</yml_catalog>';

		return $xml;
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Преобразование массива в тег
	 *
	 * @param array $arr
	 * @return string
	 */
	function _convert_array_to_tag($arr)
	{
		$s = '';
		foreach ($arr as $tag=>$val)
		{
			$s .= '<' . $tag . '>' . $val . '</' . $tag . '>';
		}
		$s .= "\r\n";

		return $s;
	}

	/**
	 * Преобразование массива в атрибуты
	 *
	 * @param array $arr
	 * @param string $tagname
	 * @param string $tagvalue
	 * @return string
	 */
	function _convert_array_to_attr($arr, $tagname, $tagvalue = '')
	{
		$s = '<' . $tagname . ' ';
		foreach ($arr as $attrname=>$attrval)
		{
			$s .= $attrname . '="' . $attrval . '" ';
		}
		$s .= ($tagvalue != '') ? '>' . $tagvalue . '</' . $tagname . '>' : '/>';
		$s .= "\r\n";

		return $s;
	}

	/**
	 * Подготовка текстового поля в соответствии с требованиями Яндекса
	 * Запрещены любые html-тэги. Стандарт XML не допускает использования в текстовых данных
	 * непечатаемых символов с ASCII-кодами в диапазоне значений от 0 до 31 (за исключением
	 * символов с кодами 9, 10, 13 - табуляция, перевод строки, возврат каретки). Также этот
	 * стандарт требует обязательной замены некоторых символов на эквивалентные им символьные
	 * примитивы.
	 * @param string $s
	 * @return string
	 */
	function _prepare_field($s)
	{
		$s = htmlspecialchars_decode(trim($s));
		$s = strip_tags($s);
		$from = array('"', '&', '>', '<', '\'');
		$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
		$s = str_replace($from, $to, $s);
		if ($this->from_charset != 'windows-1251')
		{
			$s = iconv($this->from_charset, 'windows-1251//IGNORE//TRANSLIT', $s);
		}
		$s = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $s);

		return trim($s);
	}

	/**
	 * тело XML документа
	 *
	 * @return string
	 */
	function _get_xml_shop()
	{
		$s = '<shop>' . "\r\n";

		// информация о магазине
		$s .= $this->_convert_array_to_tag($this->shop);

		// валюты
		$s .= '<currencies>' . "\r\n";
		foreach ($this->currencies as $currency)
		{
			$s .= $this->_convert_array_to_attr($currency, 'currency');
		}
		$s .= '</currencies>' . "\r\n";

		// категории
		$s .= '<categories>' . "\r\n";
		foreach ($this->categories as $category)
		{
			$category_name = $category['name'];
			unset($category['name']);
			$s .= $this->_convert_array_to_attr($category, 'category', $category_name);
		}
		$s .= '</categories>' . "\r\n";

		// товарные позиции
		$s .= '<offers>' . "\r\n";
		foreach ($this->offers as $offer)
		{
			$data = $offer['data'];
			unset($offer['data']);
			$s .= $this->_convert_array_to_attr($offer, 'offer', $this->_convert_array_to_tag($data));
		}
		$s .= '</offers>' . "\r\n";

		$s .= '</shop>';

		return $s;
	}
}

?>
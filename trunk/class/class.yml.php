<?php

/**
 * Replace function htmlspecialchars_decode()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @license     LGPL - http://www.gnu.org/licenses/lgpl.html
 * @copyright   2004-2007 Aidan Lister <aidan@php.net>, Arpad Ray <arpad@php.net>
 * @link        http://php.net/function.htmlspecialchars_decode
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision: 1.6 $
 * @since       PHP 5.1.0
 * @require     PHP 4.0.0 (user_error)
 */
function php_compat_htmlspecialchars_decode($string, $quote_style = null)
{
    // Sanity check
    if (!is_scalar($string)) {
        user_error('htmlspecialchars_decode() expects parameter 1 to be string, ' .
            gettype($string) . ' given', E_USER_WARNING);
        return;
    }

    if (!is_int($quote_style) && $quote_style !== null) {
        user_error('htmlspecialchars_decode() expects parameter 2 to be integer, ' .
            gettype($quote_style) . ' given', E_USER_WARNING);
        return;
    }

    // The function does not behave as documented
    // This matches the actual behaviour of the function
    if ($quote_style & ENT_COMPAT || $quote_style & ENT_QUOTES) {
        $from = array('&quot;', '&#039;', '&lt;', '&gt;', '&amp;');
        $to   = array('"', "'", '<', '>', '&');
    } else {
        $from = array('&lt;', '&gt;', '&amp;');
        $to   = array('<', '>', '&');
    }

    return str_replace($from, $to, $string);
}

// Define
if (!function_exists('htmlspecialchars_decode')) {
    function htmlspecialchars_decode($string, $quote_style = null)
    {
        return php_compat_htmlspecialchars_decode($string, $quote_style);
    }
}

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ����� ��������� YML
 * YML (Yandex Market Language) - ��������, ������������� "��������"
 * ��� �������� � ���������� ���������� � ���� ������ ������.������
 * YML ������� �� ��������� XML (Extensible Markup Language)
 * �������� ������� ������ YML http://partner.market.yandex.ru/legal/tt/
 */
class AVE_YML
{

/**
 *	��������
 */

	/**
	 * ���������
	 *
	 * @var string
	 */
	var $from_charset = 'windows-1251';

	/**
	 * ������� �������� ��������
	 *
	 * @var string
	 */
	var $shop = array('name'=>'', 'company'=>'', 'url'=>'');

	/**
	 * ������� ������
	 *
	 * @var string
	 */
	var $currencies = array();

	/**
	 * ������� ���������
	 *
	 * @var string
	 */
	var $categories = array();

	/**
	 * ������� �����������
	 *
	 * @var string
	 */
	var $offers = array();

	/**
	 * �����������
	 *
	 * @param string $from_charset
	 */
	function AVE_YML($from_charset = 'windows-1251')
	{
		$this->from_charset = trim(strtolower($from_charset));
	}

/**
 *	���������� ������
 */

	/**
	 * �������������� ������� � ���
	 *
	 * @param array $tags
	 * @return string
	 */
	function _ymlArray2Tag($tags)
	{
		$tag = '';
		foreach ($tags as $tag_name => $tag_value)
		{
			$tag .= '<' . $tag_name . '>' . $tag_value . '</' . $tag_name . '>';
		}
		$tag .= "\r\n";

		return $tag;
	}

	/**
	 * �������������� ������� � ��������
	 *
	 * @param array $attributes
	 * @param string $tag_name
	 * @param string $tag_value
	 * @return string
	 */
	function _ymlArray2Attribute($attributes, $tag_name, $tag_value = '')
	{
		$attribute = '<' . $tag_name . ' ';
		foreach ($attributes as $attribute_name => $attribute_value)
		{
			$attribute .= $attribute_name . '="' . $attribute_value . '" ';
		}
		$attribute .= ($tag_value != '') ? '>' . $tag_value . '</' . $tag_name . '>' : '/>';
		$attribute .= "\r\n";

		return $attribute;
	}

	/**
	 * ���������� ���������� ���� � ������������ � ������������ �������
	 * ��������� ����� html-����. �������� XML �� ��������� ������������� � ��������� ������
	 * ������������ �������� � ASCII-������ � ��������� �������� �� 0 �� 31 (�� �����������
	 * �������� � ������ 9, 10, 13 - ���������, ������� ������, ������� �������). ����� ����
	 * �������� ������� ������������ ������ ��������� �������� �� ������������� �� ����������
	 * ���������.
	 * @param string $field
	 * @return string
	 */
	function _ymlFieldPrepare($field)
	{
		$field = htmlspecialchars_decode(trim($field));
		$field = strip_tags($field);
		$from = array('"', '&', '>', '<', '\'');
		$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
		$field = str_replace($from, $to, $field);
		if ($this->from_charset != 'windows-1251')
		{
			$field = iconv($this->from_charset, 'windows-1251//IGNORE//TRANSLIT', $field);
		}
		$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);

		return trim($field);
	}

	/**
	 * ������������ �������� catalog
	 *
	 * @return string
	 */
	function _ymlElementCatalogGet()
	{
		$eol = "\r\n";

		$catalog = '<shop>' . $eol;

		// ���������� � ��������
		$catalog .= $this->_ymlArray2Tag($this->shop);

		// ������
		$catalog .= '<currencies>' . $eol;
		foreach ($this->currencies as $currency)
		{
			$catalog .= $this->_ymlArray2Attribute($currency, 'currency');
		}
		$catalog .= '</currencies>' . $eol;

		// ���������
		$catalog .= '<categories>' . $eol;
		foreach ($this->categories as $category)
		{
			$category_name = $category['name'];
			unset($category['name']);
			$catalog .= $this->_ymlArray2Attribute($category, 'category', $category_name);
		}
		$catalog .= '</categories>' . $eol;

		// �������� �������
		$catalog .= '<offers>' . $eol;
		foreach ($this->offers as $offer)
		{
			$data = $offer['data'];
			unset($offer['data']);
			$catalog .= $this->_ymlArray2Attribute($offer, 'offer', $this->_ymlArray2Tag($data));
		}
		$catalog .= '</offers>' . $eol;

		$catalog .= '</shop>';

		return $catalog;
	}

/**
 *	������� ������
 */

	/**
	 * ������������ ������� ��� �������� shop ������������ �������
	 *
	 * @param string $name - �������� �������� �������� (��������, ������� ��������� � ������
	 * 		��������� �� ������.������� �������. �� ������ ��������� ����� 20 ��������).
	 * 		������ ������������ �����, �� ������� ��������� � ������������ �������� ("������", "�������"),
	 *		��������� ����� �������� � �.�. �������� ��������, ������ ��������� � ����������� ���������
	 * 		��������, ������� ����������� �� �����. ��� ������������ ������� ���������� ������������
	 * 		����� ���� �������� �������� �������������� ��� ����������� �������.
	 * @param string $company - ������ ������������ ��������, ��������� ���������.
	 * 		�� �����������, ������������ ��� ���������� �������������.
	 * @param string $url - URL-����� ������� �������� ��������
	 */
	function ymlElementShopSet($name, $company, $url)
	{
		$this->shop['name'] = substr($this->_ymlFieldPrepare($name), 0, 20);
		$this->shop['company'] = $this->_ymlFieldPrepare($company);
		$this->shop['url'] = $this->_ymlFieldPrepare($url);
	}

	/**
	 * ���������� ������
	 *
	 * @param string $id - ��� ������ (RUR, UAH, USD, EUR...)
	 * @param float|string $rate - ���� ���� ������ � ������, ������ �� �������.
	 *	�������� rate ����� ����� ��� �� ��������� ��������:
	 *		CBRF - ���� �� ������������ ����� ��.
	 *		NBU - ���� �� ������������� ����� �������.
	 *		�� - ���� �� ����� ��� ������, � ������� ��������� ��������-�������
	 * 		�� ������ �������, ���������� � ����������� ���������� ������.�������.
	 * @param int $plus - ������������ ������ � ������ rate = CBRF, NBU ��� ��
	 *		� �������� ��������� ��������� ���� � ��������� �� ����� ���������� �����
	 * @return bool
	 */
	function ymlElementCurrencySet($id, $rate = 'CBRF', $plus = 0)
	{
		$rate = strtoupper($rate);
		$allow_rate = array('CBRF', 'NBU', 'CB');
		if (in_array($rate, $allow_rate))
		{
			$plus = str_replace(',', '.', $plus);
			if ($plus > 0)
			{
				$this->currencies[] = array(
					'id'=>$this->_ymlFieldPrepare(strtoupper($id)),
					'rate'=>$rate,
					'plus'=>(float)$plus
				);
			}
			else
			{
				$this->currencies[] = array(
					'id'=>$this->_ymlFieldPrepare(strtoupper($id)),
					'rate'=>$rate
				);
			}
		}
		else
		{
			$rate = str_replace(',', '.', $rate);
			$this->currencies[] = array(
				'id'=>$this->_ymlFieldPrepare(strtoupper($id)),
				'rate'=>(float)$rate
			);
		}

		return true;
	}

	/**
	 * ���������� ��������� �������
	 *
	 * @param string $name - �������� �������
	 * @param int $id - id �������
	 * @param int $parent_id - id ������������ �������, ���� ���, �� -1
	 * @return bool
	 */
	function ymlElementCategorySet($name, $id, $parent_id = -1)
	{
		if ((int)$id < 1 || trim($name) == '') return false;
		if ((int)$parent_id > 0)
		{
			$this->categories[] = array(
				'id'=>(int)$id,
				'parentId'=>(int)$parent_id,
				'name'=>$this->_ymlFieldPrepare($name)
			);
		}
		else
		{
			$this->categories[] = array(
				'id'=>(int)$id,
				'name'=>$this->_ymlFieldPrepare($name)
			);
		}

		return true;
	}

	/**
	 * ���������� ��������� �����������
	 *
	 * @param int $id - id ������ (��������� �����������)
	 * @param array $data - ������ ��������� ���������� (���������� �������� ������������)
	 *	*url - URL-����� �������� ������.
	 *	*name - ������������ ��������� �����������.
	 *	*description - �������� ��������� �����������.
	 *	*price - ����, �� ������� ������ ����� ����� ����������.
	 *		���� ��������� ����������� ���������� � ��������� � ����������� �� �������� ������������.
	 *	*currencyId - ������������� ������ ������ (RUR, USD, UAH).
	 *		��� ����������� ����������� ���� � ������������ ������, ���������� ������������
	 * 		������������� (��������, UAH) � ��������������� ��������� ����.
	 *	*categoryId - ������������� ��������� ������ (����� ����� �� ����� 18 ������).
	 *		�������� ����������� ����� ������������ ������ ����� ���������.
	 *	*delivery - �������, ������������ ����������� ��������� ��������������� �����.
	 *		"false" ������ ����� �� ����� ���� ���������("���������").
	 *		"true" ����� ������������ �� ��������, ������� ����������� � ����������� ����������
	 * 			 http://partner.market.yandex.ru �� �������� "��������������".
	 *	picture - ������ �� �������� ���������������� ��������� �����������.
	 * 		����������� ������ ������ �� "��������", �.�. �� �������� ��� ��������
	 * 		"�������� �����������" ��� �� ������� ��������.
	 *	vendor - �������������.
	 *	vendorCode - ��� ������ (����������� ��� �������������).
	 *	local_delivery_cost - ��������� �������� ������� ������ � ����� �������.
	 *	sales_notes - �������, ��������������� ��� ����, ����� �������� �������������,
	 * 		��� ���������� ������ ����� �� ������, ��� ��� �������� ����� �������� (����� ������).
	 * 		���������� ����� ������ � �������� - 50 ��������.
	 *	manufacturer_warranty - ������� ������������ ��� ������� �������,
	 * 		������� ����������� �������� �������������. {true|false}
	 *	country_of_origin - ������� ������������ ��� �������� ������ ������������ ������.
	 *	downloadable - ������� ������������ ��� ����������� ������, ������� ����� �������.
	 * @param bool $available - ������ ����������� ������ - � �������/�� �����.
	 *	"true" - �������� ����������� � �������.
	 * 		������� ����� ����� �������������� � ����������� � �������� ������
	 *	"false" - �������� ����������� �� �����.
	 * 		������� ����� ����������� �������� ������ �� ��������� �������� � ������� ������
	 *		(���� ����� ���� ������ ��� �������, ������� ����� ����������� ����� ������������ ������ �� �����)..
	 *		�� �������� �����������, �� ������� ������ �� �����������, �� ������ ����������� � ������.������.
	 */
	function ymlElementOfferSet($id, $data, $available = true)
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

		foreach ($data as $k => $v)
		{
			if (!in_array($k, $allowed)) unset($data[$k]);
			$data[$k] = strip_tags($this->_ymlFieldPrepare($v));
		}
		$tmp = $data;
		$data = array();
		// �������� XML ��������� ������� ���������� ���������,
		// ������� ����� ��������� ��� � ������������ � �������� ��������� � DTD
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
	 * �������� ���� YML ����
	 *
	 * @return string
	 */
	function ymlGet()
	{
		$eol = "\r\n";

		$yml  = '<?xml version="1.0" encoding="windows-1251"?>' . $eol;
		$yml .= '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . $eol;
		$yml .= '<yml_catalog date="' . date('Y-m-d H:i') . '">' . $eol;
		$yml .= $this->_ymlElementCatalogGet();
		$yml .= '</yml_catalog>';

		return $yml;
	}
}

?>
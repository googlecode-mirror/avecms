<?php

/**
 * ����� ��������� YML (Yandex Market Language)
 * �������� ������� ������ YML http://partner.market.yandex.ru/legal/tt/
 *
 * @package AVE.cms
 * @filesource
 */
class AVE_YML
{

/**
 *	��������
 */

	var $from_charset = 'windows-1251';
	var $shop = array('name'=>'', 'company'=>'', 'url'=>'');
	var $currencies = array();
	var $categories = array();
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
	function set_shop($name, $company, $url)
	{
		$this->shop['name'] = substr($this->_prepare_field($name), 0, 20);
		$this->shop['company'] = $this->_prepare_field($company);
		$this->shop['url'] = $this->_prepare_field($url);
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
	 * ���������� ��������� �������
	 *
	 * @param string $name - �������� �������
	 * @param int $id - id �������
	 * @param int $parent_id - id ������������ �������, ���� ���, �� -1
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
	 * �������� ���� �ML ���
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
 *	���������� ������
 */

	/**
	 * �������������� ������� � ���
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
	 * �������������� ������� � ��������
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
	 * ���������� ���������� ���� � ������������ � ������������ �������
	 * ��������� ����� html-����. �������� XML �� ��������� ������������� � ��������� ������
	 * ������������ �������� � ASCII-������ � ��������� �������� �� 0 �� 31 (�� �����������
	 * �������� � ������ 9, 10, 13 - ���������, ������� ������, ������� �������). ����� ����
	 * �������� ������� ������������ ������ ��������� �������� �� ������������� �� ����������
	 * ���������.
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
	 * ���� XML ���������
	 *
	 * @return string
	 */
	function _get_xml_shop()
	{
		$s = '<shop>' . "\r\n";

		// ���������� � ��������
		$s .= $this->_convert_array_to_tag($this->shop);

		// ������
		$s .= '<currencies>' . "\r\n";
		foreach ($this->currencies as $currency)
		{
			$s .= $this->_convert_array_to_attr($currency, 'currency');
		}
		$s .= '</currencies>' . "\r\n";

		// ���������
		$s .= '<categories>' . "\r\n";
		foreach ($this->categories as $category)
		{
			$category_name = $category['name'];
			unset($category['name']);
			$s .= $this->_convert_array_to_attr($category, 'category', $category_name);
		}
		$s .= '</categories>' . "\r\n";

		// �������� �������
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
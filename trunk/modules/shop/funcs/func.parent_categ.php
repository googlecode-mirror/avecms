<?php

function getParentShopcateg($param = '')
{
	global $AVE_DB, $shop;

	$parent_id = (is_array($param)) ? $param['id'] : $param ;

	$id = 0;

	while($parent_id != 0)
	{
		if(isset($shop->_catParent[$parent_id]) && is_object($shop->_catParent[$parent_id]))
		{
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT
					Elter,
					Id
				FROM " . PREFIX . "_modul_shop_kategorie
			");
			while($row = $sql->FetchRow())
			{
				$shop->_catParent[$row->Id] = $row;
			}
		}
		$row = $shop->_catParent[$parent_id];

		@$parent_id = $row->Elter;
		@$id = $row->Id;
	}

	return($id);
}

?>
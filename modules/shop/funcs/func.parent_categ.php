<?php

function getParentShopcateg($param = '')
{
	global $AVE_DB, $shop;

	static $parents = array();

	$parent_id = (is_array($param)) ? $param['id'] : $param ;

	$id = 0;

	while($parent_id != 0)
	{
		if (! (isset($parents[$parent_id]) && is_object($parents[$parent_id])))
		{
			$sql = $AVE_DB->Query("
				SELECT
					Id,
					parent_id
				FROM " . PREFIX . "_modul_shop_kategorie
			");
			while($row = $sql->FetchRow())
			{
				$parents[$row->Id] = $row;
			}
		}
		$row = $parents[$parent_id];

		@$parent_id = $row->parent_id;
		@$id = $row->Id;
	}

	return($id);
}

?>
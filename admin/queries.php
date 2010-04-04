<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if(!defined("ACP")) {header("Location:index.php"); exit;}

include_once(BASE_DIR . "/class/class.queries.php");
include_once(BASE_DIR . "/class/class.docs.php");
include_once(BASE_DIR . "/class/class.rubs.php");

$AVE_Query = new AVE_Query;
$AVE_Rubric = new AVE_Rubric;
$AVE_Document = new AVE_Document;
$AVE_Document->rediRubs();

$AVE_Template->config_load(BASE_DIR . "/admin/lang/" . $_SESSION['admin_lang'] . "/query.txt", 'query');

include_once(BASE_DIR . "/admin/inc/pre.inc.php");

switch ($_REQUEST['action'])
{
	case '':
		if(permCheck('abfragen'))
		{
			$AVE_Query->showQueries();
		}
		break;

	case 'edit':
		if(permCheck('abfragen'))
		{
			$AVE_Rubric->showRubTpl(0, 1);
			$AVE_Query->editQuery($_REQUEST['Id']);
		}
		break;

	case 'copy':
		if(permCheck('abfragen'))
		{
			$AVE_Query->copyQuery($_REQUEST['Id']);
		}
		break;

	case 'new':
		if(permCheck('abfragen_neu'))
		{
			$AVE_Rubric->showRubTpl(0, 1);
			$AVE_Query->newQuery();
		}
		break;

	case 'delete_query':
		if(permCheck('abfragen_loesch'))
		{
			$AVE_Query->deleteQuery($_REQUEST['Id']);
		}
		break;

	case 'konditionen':
		if(permCheck('abfragen'))
		{
			$AVE_Rubric->showRubTpl(0, 1);
			$AVE_Query->editConditions($_REQUEST['Id']);
		}
		break;
}

?>
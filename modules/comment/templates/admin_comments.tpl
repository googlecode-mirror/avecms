<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#COMMENT_MODULE_NAME#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<div class="infobox">
	<strong>{#COMMENT_MODULE_COMENTS#}</strong> | <a href="index.php?do=modules&action=modedit&mod=comment&moduleaction=settings&cp={$sess}">{#COMMENT_MODULE_SETTINGS#}</a>
</div><br />

<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
    <col>
    <col width="110">
    <col>
    <col width="30">
    <col width="30">

	<tr class="tableheader">
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp={$sess}&page={$smarty.request.page|escape|default:1}&sort=comment{if $smarty.request.sort=='comment'}_desc{/if}">{#COMMENT_TEXT_COMMENT#}</a>
		</td>
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp={$sess}&page={$smarty.request.page|escape|default:1}&sort=created{if $smarty.request.sort=='created'}_desc{/if}">{#COMMENT_DATE_CREATE#}</a>
		</td>
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp={$sess}&page={$smarty.request.page|escape|default:1}&sort=document{if $smarty.request.sort=='document'}_desc{/if}">{#COMMENT_DOC_TITLE#}</a>
		</td>
		<td colspan="2">&nbsp;</td>
	</tr>

	{foreach from=$docs item=doc}
		<tr class="{cycle name='dd' values='first,second'}">
			<td><a title="{$doc.comment_text|escape|truncate:'1000'}" target="_blank" href="../index.php?id={$doc.document_id}&doc=impressum&subaction=showonly&comment_id={$doc.CId}#{$doc.CId}">{$doc.comment_text|escape|truncate:'100'}</a></td>
			<td class="time">{$doc.comment_published|date_format:$TIME_FORMAT|pretty_date}</td>
			<td>({$doc.Comments}) <a target="_blank" href="../index.php?id={$doc.document_id}">{$doc.document_title|escape}</a></td>
			<td><a title="{#COMMENT_EDIT#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=comment&moduleaction=admin_edit&pop=1&docid={$doc.document_id}&Id={$doc.CId}','700','550','1');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a></td>
			<td><a title="{#COMMENT_DELETE_LINK#}" href="javascript:void(0);" onclick="cp_pop('index.php?parent={$doc.CId}&docid={$doc.document_id}&module=comment&action=delete&pop=1&Id={$doc.CId}','10','10','1');"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a></td>
		</tr>
	{/foreach}
</table><br />

{$page_nav}
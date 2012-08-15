<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_docs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#DOC_SUB_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#DOC_TIPS#}</div>
</div><br />
<br />

{if check_permission('documents')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('DocName').value == '') {ldelim}
		alert("{#DOC_ENTER_NAME#}");
		document.getElementById('DocName').focus();
		return false;
	{rdelim}
	return true;
{rdelim}

$(document).ready( function() {ldelim}
	$("#selall").click(function(){ldelim}
		if ($("#selall").attr('checked')){ldelim}
			$(".checkbox:enabled").attr("checked", true);
		{rdelim}else{ldelim}
			$(".checkbox:enabled").attr("checked", false);
		{rdelim}
	{rdelim});
{rdelim});
</script>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tableborder">
	<col width="50%">
	<col width="50%">
	<tr>
		<td><h4>{#MAIN_ADD_IN_RUB#}</h4></td>
		<td><h4>{#MAIN_SORT_DOCUMENTS#}</h4></td>
	</tr>

	<tr>
		<td class="second" style="padding:8px;">
			<form action="index.php" method="get" onSubmit="return check_name();">
				<input type="hidden" name="cp" value="{$sess}" />
				<input type="hidden" name="do" value="docs" />
				<input type="hidden" name="action" value="new" />
				<strong>{#MAIN_ADD_IN#}</strong>&nbsp;
				<select style="width:45%" name="rubric_id" id="DocName">
					<option value=""></option>
					{foreach from=$rubrics item=rubric}
						{if $rubric->Show==1}
							<option value="{$rubric->Id}">{$rubric->rubric_title|escape}</option>
						{/if}
					{/foreach}
				</select>
				&nbsp;
				<input style="width:85px" type="submit" class="button" value="{#MAIN_BUTTON_ADD#}" />
			</form>
		</td>

		<td class="second" style="padding:8px;">
			<form action="index.php" method="get">
				<input type="hidden" name="cp" value="{$sess}" />
				<input type="hidden" name="do" value="docs" />
				<strong>{#MAIN_ADD_IN#}</strong>&nbsp;
				<select style="width:45%" name="rubric_id" id="RubrikSort">
					<option value="all">{#MAIN_ALL_RUBRUKS#}</option>
					{foreach from=$rubrics item=rubric}
						{if $rubric->Show==1}
							<option value="{$rubric->Id}"{if $smarty.request.rubric_id==$rubric->Id} selected{/if}>{$rubric->rubric_title|escape}</option>
						{/if}
					{/foreach}
				</select>
				&nbsp;
				<input style="width:85px" type="submit" class="button" value="{#MAIN_BUTTON_SORT#}" />
			</form>
		</td>
	</tr>
</table>
{/if}

{include file='documents/doc_search.tpl'}

<h4>{#MAIN_DOCUMENTS_ALL#}</h4>
<form method="post" action="index.php?do=docs&action=editstatus&cp={$sess}">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<col width="10" class="itcen">
	<col width="10" class="itcen">
	<col>
	<col width="150">
	<col width="120" class="time">
	<col width="120" class="time">
	<col width="100">
	<col width="100">
	<col width="100">
	<col width="20">
	<col width="20">
	<col width="20">
	<col width="20">
	<col width="20">
	<tr class="tableheader">
		<td><div align="center"><input type="checkbox" id="selall" value="1" /></div></td>
		<td><a class="header" href="{$link}&sort=id{if $smarty.request.sort=='id'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_ID#}</a></td>
		<td nowrap="nowrap">
			<a class="header" href="{$link}&sort=title{if $smarty.request.sort=='title'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_TITLE#}</a>
			&nbsp;|&nbsp;
			<a class="header" href="{$link}&sort=alias{if $smarty.request.sort=='alias'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_URL_RUB#}</a>
		</td>
		<td><a class="header" href="{$link}&sort=rubric{if $smarty.request.sort=='rubric'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_IN_RUBRIK#}</a></td>
		<td><a class="header" href="{$link}&sort=published{if $smarty.request.sort=='published'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_CREATED#}</a></td>
		<td><a class="header" href="{$link}&sort=changed{if $smarty.request.sort=='changed' || !$smarty.request.sort}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_EDIT#}</a></td>
		<td><a class="header" href="{$link}&sort=view{if $smarty.request.sort=='view'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_CLICKS#}</a></td>
		<td><a class="header" href="{$link}&sort=print{if $smarty.request.sort=='print'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_PRINTED#}</a></td>
		<td><a class="header" href="{$link}&sort=author{if $smarty.request.sort=='author'}_desc{/if}&page={$smarty.request.page|escape|default:'1'}&cp={$sess}">{#DOC_AUTHOR#}</a></td>
		<td colspan="5" align="center">{#DOC_ACTIONS#}</td>
	</tr>

	{foreach from=$docs item=item}
	    {if $item->cantRead==1}
		<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td><input class="checkbox" name="document[{$item->Id}]" type="checkbox" value="1" {if ($item->cantEdit!=1 || $item->canOpenClose!=1 || $item->canEndDel!=1) && ($item->Id == 1 || $item->Id == $PAGE_NOT_FOUND_ID || $item->canAlles !=1)}disabled{/if} /></td>
			<td nowrap="nowrap">{$item->Id}</td>

			<td>
				<strong>
					{if $item->cantEdit==1}
						<a title="{#DOC_EDIT_TITLE#}" href="index.php?do=docs&action=edit&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}">{$item->document_title}</a>
					{else}
						{$item->document_title}
					{/if}
				</strong><br />
				<a title="{#DOC_SHOW_TITLE#}" href="../index.php?id={$item->Id}&amp;cp={$sess}" target="_blank"><span class="url">{$item->document_alias}</span></a>
			</td>

			<td nowrap="nowrap">
				{if $item->cantEdit==1}
					<select style="width:100%;" {if $item->cantEdit==1}onchange="cp_pop('index.php?do=docs&action=change&Id={$item->Id}&rubric_id={$item->rubric_id}&NewRubr='+this.value+'&pop=1&cp={$sess}','550','550','1','docs');"{else}disabled="disabled"{/if}>
						{foreach from=$rubrics item=rubric}
							<option value="{$rubric->Id}"{if $item->rubric_id == $rubric->Id} selected="selected"{/if}>{$rubric->rubric_title|escape}</option>
						{/foreach}
					</select>
				{else}
					{foreach from=$rubrics item=rubric}
						{if $item->rubric_id == $rubric->Id}{$rubric->rubric_title|escape}{/if}
					{/foreach}
				{/if}
			</td>

			<td align="right">{$item->document_published|date_format:$TIME_FORMAT|pretty_date}<br /></td>

			<td align="right">{$item->document_changed|date_format:$TIME_FORMAT|pretty_date}<br /></td>

			<td align="center">{$item->document_count_view}</td>

			<td align="center">{$item->document_count_print}</td>

			<td align="center">{$item->document_author|escape}</td>

			<td align="center" nowrap="nowrap">
				{if check_permission("remarks")}
					{if $item->ist_remark=='0'}
						<a title="{#DOC_CREATE_NOTICE_TITLE#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=docs&action=remark&Id={$item->Id}&pop=1&cp={$sess}','800','700','1','docs');"><img src="{$tpl_dir}/images/icon_comment.gif" alt="" border="0" /></a>
					{else}
						<a title="{#DOC_REPLY_NOTICE_TITLE#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=docs&action=remark_reply&Id={$item->Id}&pop=1&cp={$sess}','800','700','1','docs');"><img src="{$tpl_dir}/images/icon_iscomment.gif" alt="" border="0" /></a>
					{/if}
				{else}
					<img src="{$tpl_dir}/images/icon_comment_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td align="center" nowrap="nowrap">
				{if $item->cantEdit==1}
					<a title="{#DOC_EDIT_TITLE#}" href="index.php?do=docs&action=edit&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_edit.gif" alt="{#DOC_EDIT_TITLE#}" border="0" /></a>
				{else}
					<img src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td align="center" nowrap="nowrap">
				{if $item->document_deleted==1}
					<img src="{$tpl_dir}/images/icon_blank.gif" alt="" border="0" />
				{else}
					{if $item->document_status==1}
						{if $item->canOpenClose==1 && $item->Id != 1 && $item->Id != $PAGE_NOT_FOUND_ID}
							<a title="{#DOC_DISABLE_TITLE#}" href="index.php?do=docs&action=close&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_unlock.gif" alt="" border="0" /></a>
						{else}
							{if $item->cantEdit==1 && $item->Id != 1 && $item->Id != $PAGE_NOT_FOUND_ID}
								<img src="{$tpl_dir}/images/icon_unlock_no.gif" alt="" border="0" />
							{else}
								<img src="{$tpl_dir}/images/icon_unlock_no.gif" alt="" border="0" />
							{/if}
						{/if}
					{else}
						{if $item->canOpenClose==1}
							<a title="{#DOC_ENABLE_TITLE#}" href="index.php?do=docs&action=open&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_lock.gif" alt="" border="0" /></a>
						{else}
							{if $item->cantEdit==1 && $item->Id != 1 && $item->Id != $PAGE_NOT_FOUND_ID}
								<img src="{$tpl_dir}/images/icon_lock.gif" alt="" border="0" />
							{else}
								<img src="{$tpl_dir}/images/icon_lock_no.gif" alt="" border="0" />
							{/if}
						{/if}
					{/if}
				{/if}
			</td>

			<td align="center" nowrap="nowrap">
				{if $item->document_deleted==1}
					<a title="{#DOC_RESTORE_DELETE#}" href="index.php?do=docs&action=redelete&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_active.gif" alt="" border="0" /></a>
				{else}
					{if $item->canDelete==1}
						<a title="{#DOC_TEMPORARY_DELETE#}" onclick="return confirm('{#DOC_TEMPORARY_CONFIRM#}')"  href="index.php?do=docs&action=delete&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_inactive.gif" alt="" border="0" /></a>
					{else}
						<img src="{$tpl_dir}/images/icon_active_no.gif" alt="" border="0" />
					{/if}
				{/if}
			</td>

			<td align="center" nowrap="nowrap">
				{if $item->canEndDel==1 && $item->Id != 1 && $item->Id != $PAGE_NOT_FOUND_ID}
					<a title="{#DOC_FINAL_DELETE#}" onclick="return confirm('{#DOC_FINAL_CONFIRM#}')" href="index.php?do=docs&action=enddelete&rubric_id={$item->rubric_id}&Id={$item->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
				{else}
					<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
				{/if}
			</td>
		</tr>
		{/if}
	{/foreach}
	
	<tr>
		<td colspan="4">

			<select name="moderation" class="action-in-moderation">
				<option value="none" selected="selected">{#DOC_ACTIONS_SELECTED#}</option>
				<option value="1">{#DOC_ACTIONS_ACTIVE#}</option>
				<option value="0">{#DOC_ACTIONS_INACTIVE#}</option>
				<option value="intrash">{#DOC_ACTIONS_TEMP_DELETE#}</option>
				<option value="outtrash">{#DOC_ACTIONS_RESTORE#}</option>
				<option value="trash">{#DOC_ACTIONS_DELETE#}</option>
			</select>

			<input type="submit" class="button" value="{#DOC_ACTIONS_BUTTON_EDIT#}" />
		</td>
	</tr>
</table>
</form>
<br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
{/if}
<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>
	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#DOC_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#DOC_LEGEND_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_look.gif" alt="" border="0" /> - {#DOC_LEGEND_SHOW#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_rubrik_change.gif" alt="" border="0" /> - {#DOC_EDIT_RUB#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_comment.gif" alt="" border="0" /> - {#DOC_CREATE_NOTICE_TITLE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_iscomment.gif" alt="" border="0" /> - {#DOC_REPLY_NOTICE_TITLE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_lock.gif" alt="" border="0" /> - {#DOC_LEGEND_ENABLE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_unlock.gif" alt="" border="0" /> - {#DOC_LEGEND_DISABLE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_inactive.gif" alt="" border="0" /> - {#DOC_LEGEND_TEMP_DELETE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_active.gif" alt="" border="0" /> - {#DOC_LEGEND_RESTORE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /> - {#DOC_LEGEND_FINAL_DELETE#}
	</div>
</div>
<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#RUBRIK_SUB_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#RUBRIK_TIP#}</div>
</div>

{if check_permission('rub_neu')}
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('RubrikName').value == '') {ldelim}
		alert("{#RUBRIK_ENTER_NAME#}");
		document.getElementById('RubrikName').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<h4>{#RUBRIK_NEW#}</h4>
<form method="post" action="index.php?do=rubs&amp;action=new&amp;cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="second">{#RUBRIK_NAME2#} <input type="text" id="RubrikName" name="RubrikName" value="" style="width:250px;" />&nbsp;<input type="submit" class="button" value="{#RUBRIK_BUTTON_NEW#}" />
		</tr>
	</table>
</form>
{/if}

<h4>{#RUBRIK_ALL#}</h4>
{if check_permission('rub_edit')}
	<form method="post" action="index.php?do=rubs&amp;cp={$sess}&amp;sub=quicksave{if $smarty.request.page!=''}&amp;page={$smarty.request.page}{/if}">
{/if}

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<col width="20">
	<col>
	<col width="200">
	<col width="200">
	<col width="100">
	<col width="20">
	<col width="20">
	<col width="20">
	<col width="20">
	<tr class="tableheader">
		<td>{#RUBRIK_ID#}</td>
		<td>{#RUBRIK_NAME#}</td>
		<td>{#RUBRIK_URL_PREFIX#}</td>
		<td>{#RUBRIK_TEMPLATE_OUT#}</td>
		<td align="center">{#RUBRIK_COUNT_DOCS#}</td>
		<td align="center" colspan="4">{#RUBRIK_ACTION#}</td>
	</tr>

	{foreach from=$rubrics item=rubric}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td class="itcen">{$rubric->Id}</td>
			<td>
				{if check_permission('rub_edit')}
					<input style="width:100%" type="text" name="RubrikName[{$rubric->Id}]" value="{$rubric->RubrikName|escape}" />
				{else}
					<strong>{$rubric->RubrikName|escape}</strong>
				{/if}
			</td>

			<td>
				{if check_permission('rub_edit')}
					<input style="width:100%" type="text" name="UrlPrefix[{$rubric->Id}]" value="{$rubric->UrlPrefix|escape}" />
				{else}
					<strong>{$rubric->UrlPrefix|escape}</strong>
				{/if}
			</td>

			<td>
				{if check_permission('rub_edit')}
					<select name="Vorlage[{$rubric->Id}]" style="width:100%">
						{foreach from=$templates item=template}
							<option value="{$template->Id}" {if $template->Id==$rubric->Vorlage}selected="selected" {/if}/>{$template->TplName|escape}</option>
						{/foreach}
					</select>
				{else}
					{foreach from=$templates item=template}
						{if $template->Id==$rubric->Vorlage}{$template->TplName|escape}{/if}
					{/foreach}
				{/if}
			</td>

			<td align="center"><strong>{$rubric->doc_count}</strong></td>

			<td align="center">
				{if check_permission('rub_edit')}
					<a title="{#RUBRIK_EDIT#}" href="index.php?do=rubs&action=edit&Id={$rubric->Id}&cp={$sess}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" />
					</a>
				{else}
					<img title="{#RUBRIK_NO_CHANGE1#}" src="{$tpl_dir}/images/icon_edit_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td align="center">
				{if check_permission('rub_edit')}
					<a title="{#RUBRIK_EDIT_TEMPLATE#}" href="index.php?do=rubs&action=template&Id={$rubric->Id}&cp={$sess}">
						<img src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" />
					</a>
				{else}
					<img title="{#RUBRIK_NO_CHANGE2#}" src="{$tpl_dir}/images/icon_template_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td align="center">
				{if check_permission('rub_multi')}
					<a title="{#RUBRIK_MULTIPLY#}" href="javascript:void(0);" onclick="window.open('?do=rubs&action=multi&Id={$rubric->Id}&pop=1&cp={$sess}','pop','top=0,left=0,width=550,height=300')">
						<img src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" />
					</a>
				{else}
					<img title="{#RUBRIK_NO_MULTIPLY#}" src="{$tpl_dir}/images/icon_copy_no.gif" alt="" border="0" />
				{/if}
			</td>

			<td align="center">
				{if $rubric->Id != 1}
					{if $rubric->doc_count==0}
						{if check_permission('rub_loesch')}
							<a title="{#RUBRIK_DELETE#}" onclick="return (confirm('{#RUBRIK_DELETE_CONFIRM#}'))" href="index.php?do=rubs&amp;action=delete&amp;Id={$rubric->Id}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></a>
						{else}
							<img title="{#RUBRIK_NO_PERMISSION#}" src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
						{/if}
					{else}
						<img title="{#RUBRIK_USE_DOCUMENTS#}" src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" />
					{/if}
				{else}
					<img src="{$tpl_dir}/images/icon_delete_no.gif" alt="" border="0" />
				{/if}
			</td>
		</tr>
	{/foreach}
</table><br />

{if check_permission('rub_edit')}
	<input class="button" type="submit" value="{#RUBRIK_BUTTON_SAVE#}" /><br />
{/if}

{if $page_nav}
	<div class="infobox">{$page_nav} </div>
{/if}

{if check_permission('rub_edit')}
	</form>
{/if}

<br />

<div class="iconHelpSegmentBox">
	<div class="segmentBoxHeader">
		<div class="segmentBoxTitle">&nbsp;</div>
	</div>
	<div class="segmentBoxContent">
		<img class="absmiddle" src="{$tpl_dir}/images/arrow.gif" alt="" border="0" /> <strong>{#RUBRIK_LEGEND#}</strong><br />
		<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /> - {#RUBRIK_EDIT#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" /> - {#RUBRIK_EDIT_TEMPLATE#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_copy.gif" alt="" border="0" /> - {#RUBRIK_MULTIPLY#}<br />
		<img class="absmiddle" src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /> - {#RUBRIK_DELETE_LEGEND#}
	</div>
</div>
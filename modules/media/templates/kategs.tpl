
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('Name').value == '') {ldelim}
		alert("{#BANNER_ENTER_NAME#}");
		document.getElementById('Name').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#BANNER_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#MODULE_WELCOME_CAT#}</div>
</div><br />

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=1&cp={$sess}">{#BANNER_SHOW_ALL#}</a> |
	<a href="javascript:void(0);" onclick="window.location.href='index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=1&cp={$sess}';cp_pop('index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=newbanner&cp={$sess}&pop=1','860','700','1','modbannenews');">{#BANNER_NEW_LINK#}</a> |
	<strong>{#BANNER_CATEG_LINK#}</strong>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=category&cp={$sess}&sub=save" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="1%" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></td>
			<td width="100">{#BANNER_CATEGORY_TAG#}</td>
			<td>{#BANNER_CATEGORY_NAME#}</td>
		</tr>
		{foreach from=$categories item=category}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%">
					<input title="{#BANNER_MARK_DELETE#}" name="del[{$category->Id}]" type="checkbox" id="del[{$category->Id}]" value="1" />
				</td>

				<td width="100">
					<input name="textfield" type="text" value="[mod_banner:{$category->Id}]" readonly/>
				</td>

				<td>
					<input name="banner_category_name[{$category->Id}]" type="text" id="banner_category_name[{$category->Id}]" value="{$category->banner_category_name|escape:html|stripslashes}" size="60">
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#BANNER_BUTTON_SAVE#}" />
</form>

<h4>{#BANNER_CATEGORY_NEW#}</h4>

<form action="index.php?do=modules&action=modedit&mod={$mod_path}&moduleaction=category&cp={$sess}&sub=new" method="post" onSubmit="return check_name();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td class="tableheader">{#BANNER_CATEGORY#}</td>
		</tr>

		<tr>
			<td class="second">
				<input name="banner_category_name" type="text" id="Name" size="60">&nbsp;
				<input name="submit" type="submit" class="button" value="{#BANNER_BUTTON_ADD#}" />
			</td>
		</tr>
	</table>
</form>
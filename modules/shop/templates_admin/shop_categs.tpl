<div class="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}
<br />

{if $ProductCategs == ''}
	<h4>{#EmptyCategs#}</h4>

{else}
	<h4>{#ProductCategs#}</h4>

	<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=product_categs&cp={$sess}&sub=save" method="post">
		<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
			<tr>
				<td width="10%" nowrap="nowrap" class="tableheader">{#ProductCategsName#}</td>
				<td class="tableheader" align="center" width="1%">{#Position#}</td>
				<td class="tableheader" width="1%" colspan="3">{#Actions#}</td>
				<td class="tableheader" align="center"></td>
			</tr>

			{foreach from=$ProductCategs item=ss}
				<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td width="10%" nowrap="nowrap">
						{if $ss->Elter != 0}{$ss->expander}&raquo;{/if}
						<input style="width:200px;{if $ss->Elter == 0}font-weight:bold;background:#ffffcc;{/if}" name="KatName[{$ss->Id}]" type="text" value="{$ss->KatName|escape:html|stripslashes}" />
					</td>

					<td width="50" align="center">
						<input name="Rang[{$ss->Id}]" type="text" style="width:40px;{if $ss->Elter == 0}font-weight:bold;background:#ffffcc;{/if}" value="{$ss->Rang}" />
					</td>

					<td>
						<a title="{#ProductCategEEdit#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_categ&cp={$sess}&pop=1&Id={$ss->Id}','980','740','1','edit_categ');"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					</td>

					<td>
						<a title="{#ProductCategChild#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=new_categ&cp={$sess}&pop=1&Id={$ss->Id}','980','740','1','new_categ');"><img src="{$tpl_dir}/images/icon_7.gif" alt="" border="0" /></a>
					</td>

					<td>
						<a onclick="return confirm('{#ProductCategEDelCategC#}');" title="{#ProductCategEDelCateg#}" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=delcateg&Id={$ss->Id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
					</td>

					<td>&nbsp;</td>
				</tr>
			{/foreach}
		</table><br />

		<input type="submit" class="button" value="{#ButtonSave#}">
	</form><br />

	{if $page_nav}
		<br />
		{$page_nav}<br />
	{/if}
{/if}
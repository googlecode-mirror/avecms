<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#Modulname#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div>
<br>
<div class="infobox"><strong>{#Config_Fields#}</strong> | <a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=tpl&cp={$sess}">{#Template#}</a>  | <a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=update&cp={$sess}">{#Update#}</a></div>

<h4>{#ModulSetting#}</h4>
<form method="post" action="{$formaction}">

	{include file="$tpl_dir/admin_settings.tpl"}

	<h4>{#ModulListField#}</h4>

	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td align="center">
			<img src="{$tpl_dir}/images/icon_del.gif" alt="" />	</td>
			<td>{#Title#}</td>
			<td>{#Object#}</td>
			<td>{#Std#}</td>
			<td>{#Active#}</td>
		</tr>
		{foreach from=$items item=item}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%">
					<input title="{#MarkDel#}" name="del[{$item->Id}]" type="checkbox" id="del[{$item->Id}]" value="1" />
				</td>
				<td width="200">
					<input style="width:180px" name="titel[{$item->Id}]" type="text" id="title[{$item->Id}]" value="{$item->title}" />
				</td>
				<td width="160">
					<select name="type[{$item->Id}]" id="type[{$item->Id}]" style="width:150px;">
						<option value="text" {if $item->type=='text'}selected{/if}>{#Textfield#}</option>
						<option value="textfield" {if $item->type=='textfield'}selected{/if}>{#Text#}</option>
						<option value="dropdown" {if $item->type=='dropdown'}selected{/if}>{#Dropdown#}</option>
						<option value="multi" {if $item->type=='multi'}selected{/if}>{#Dropdown_multi#}</option>
					</select>
				</td>
				<td width="200">
					<input style="width:180px" name="wert[{$item->Id}]" type="text" id="wert[{$item->Id}]" value="{$item->value}" />
				</td>
				<td>
					<input type="radio" name="aktiv[{$item->Id}]" value="1" {if $item->active==1}checked{/if} />{#Yes#}
					<input type="radio" name="aktiv[{$item->Id}]" value="0" {if $item->active!=1}checked{/if} />{#No#}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}" />
</form>

<h4>{#ModulAddField#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=userpage&moduleaction=save_new&cp={$sess}" name="new">

	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#Title#}</td>
			<td>{#Object#}</td>
			<td>{#Std#}</td>
			<td>{#Active#}</td>
		</tr>
		<tr class="first">
			<td width="200">
				<input style="width:180px" name="titel" type="text" id="titel" value="" />
			</td>
			<td width="160">
				<select name="type" id="type" style="width:150px;">
					<option value="text">{#Textfield#}</option>
					<option value="textfield">{#Text#}</option>
					<option value="dropdown">{#Dropdown#}</option>
					<option value="multi">{#Dropdown_multi#}</option>
				</select>
			</td>
			<td width="200">
				<input style="width:180px" name="wert" type="text" id="wert" value="" />
			</td>
			<td>
				<input name="aktiv" type="radio" value="1" checked="checked" /> {#Yes#}
				<input name="aktiv" type="radio" value="0" /> {#No#}
			</td>
		</tr>
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}" />
</form>
<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_settings">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SETTINGS_CASE_TITLE#}</h2></div>
	<div class="HeaderText">{if $smarty.request.saved==1}{#SETTINGS_SAVED#}{else}{#SETTINGS_SAVE_INFO#}{/if}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<h4>{#SETTINGS_INFO#}</h4>

<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="index.php?do=settings&amp;sub=countries&amp;cp={$sess}">
					<div class="taskTitle">{#MAIN_COUNTRY_EDIT#}</div>
				</a>
			</div>
		</td>
		<td class="second">
			<div id="otherLinks">
				<a href="index.php?do=settings&amp;cp={$sess}">
					<div class="taskTitle">{#SETTINGS_MAIN_SETTINGS#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>
							
<h4>{#SETTINGS_CASE_TITLE#}</h4>						
<form method="post" onSubmit="return confirm('{#SETTINGS_SAVE_CONFIRM#}')" action="index.php?do=settings&cp={$sess}&sub=save&dop=case">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<th class="tableheader" width=30%>{#SETTINGS_NAME#}</th>
			<th class="tableheader">{#SETTINGS_VALUE#}</th>
		</tr>
	
	<tbody>		
		{foreach from=$CMS_CONFIG item=def key=_var}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td>{$def.DESCR} <br>{$_var}</td>
			{if $def.TYPE=="dropdown"}
				<td><select name="GLOB[{$_var}]"/>
					{foreach from=$def.VARIANT item=elem}
						<option value="{$elem}" 
							{php}
								echo (constant($this->_tpl_vars['_var'])==$this->_tpl_vars['elem'] ? 'selected' :'' );
							{/php}>{$elem}</option>
					{/foreach}
				</select></td>
			{/if}
			{if $def.TYPE=="string"}
				<td><input name="GLOB[{$_var}]" type="text" id="{$_var}" style="width:550px" value="{php} echo(constant  ($this->_tpl_vars['_var']));{/php}" size="100" /></td>
			{/if}
			{if $def.TYPE=="integer"}
				<td><input name="GLOB[{$_var}]" type="text" id="{$_var}" style="width:550px" value="{php} echo(constant  ($this->_tpl_vars['_var']));{/php}" size="100" /></td>
			{/if}
			{if $def.TYPE=="bool"}
				<td>
				<input type="radio" name="GLOB[{$_var}]" value="1" {php} echo(constant($this->_tpl_vars['_var']) ? 'checked' : "");{/php} />{#SETTINGS_YES#}&nbsp;
				<input type="radio" name="GLOB[{$_var}]" value="0" {php} echo(constant($this->_tpl_vars['_var']) ? '' : "checked");{/php} />{#SETTINGS_NO#}
				</td>
			{/if}
		</tr>
		{/foreach}
		
		</tbody>
	</table><br />
	<input type="submit" class="button" value="{#SETTINGS_BUTTON_SAVE#}" />
</form>
<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#FORUMS_HEADER_MODS#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
{if $mods}
	<tr>
		<td colspan="2" class="tableheader">{#FORUMS_HEADER_MODS#}</td>
	</tr>
{/if}	
{foreach from=$mods item=mod}
	<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=mods&cp={$sess}&pop=1&del=1" method="post">
		<input type="hidden" name="user_id" value="{$mod->uid}" />
		<input type="hidden" name="id" value="{$smarty.get.id|escape}" />
	<tr>
		<td width="20%" class="first"><strong>{$mod->uname|escape}</strong></td>
		<td class="second">
			<input class="button" type="submit" value="{#FORUMS_DEL_MODS#}" />
			</td>
	</tr>
	</form>
{/foreach}
</table><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td colspan="2" class="tableheader">{#FORUMS_ADD_MODS#}</td>
	</tr>
	<tr>
		<td width="20%" class="first">{#FORUMS_NAME_MODS#}</td>
		<td class="second">
			<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=mods&cp={$sess}&pop=1" method="post">
				<input type="hidden" name="id" value="{$smarty.get.id|escape}" />
				<input type="text" name="user_name" size="50" maxlength="100" />&nbsp;
				<input type="submit" class="button" value="{#FORUMS_ADD_MODS#}" />
			</form>
		</td>
	</tr>
</table>
<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td colspan="2" class="tableheader">{#ModsPage#}</td>
	</tr>
	{if $smarty.get.error == 1}
	<tr class="first">
 		<td colspan="2">-</td>
	</tr>
	{/if}
{foreach from=$mods item=mod}
	<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=mods&cp{$sess}&pop=1&del=1" method="post">
		<input type="hidden" name="user_id" value="{$mod->BenutzerId}" />
		<input type="hidden" name="id" value="{$smarty.get.id}" />
		<tr>
			<td width="20%" class="first">{$mod->BenutzerName}</td>
			<td class="second">
				<input class="button" type="submit" value="{#Renove#}" />
		  </td>
		</tr>
	</form>
{/foreach}
</table>
<br />
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
<tr>
<td class="second">
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=mods&cp{$sess}&pop=1" method="post">
	<input type="hidden" name="id" value="{$smarty.get.id}" />
	<input type="text" name="user_name" size="50" maxlength="100" /> <input type="submit" class="button" value="{#AddNewMod#}" />
</form>
</td>
</tr>
</table>
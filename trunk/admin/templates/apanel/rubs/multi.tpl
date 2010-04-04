{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#RUBRIK_MULTIPLY2#}</h2></div>
</div>
<div class="upPage">&nbsp;</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td class="tableheader">{#RUBRIK_MULTIPLY_TIP#}</td>
	</tr>

	<tr class="{cycle name='ta' values='first,second'}">
		<td>
			{foreach from=$errors item=e}
				{assign var=message value=$e}
				<ul>
					<li>{$message}</li>
				</ul>
			{/foreach}

			<form name="m" method="post" action="?do=rubs&amp;action=multi&amp;pop=1&amp;sub=save&amp;Id={$smarty.request.Id}">
				<input type="text" name="RubrikName" value="{$smarty.request.RubrikName|escape:html|default:"Название"}" style="width: 200px;">
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_COPY#}" />
				<input name="oId" type="hidden" id="oId" value="{$smarty.request.Id}" />
			</form>
		</td>
	</tr>
</table>

{/strip}
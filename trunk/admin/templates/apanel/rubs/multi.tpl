<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#RUBRIK_MULTIPLY2#}</h2></div>
</div>
<div class="upPage">{#RUBRIK_MULTIPLY_TIP#}</div><br />

{if $errors}
	<ul>{foreach from=$errors item=error}<li>{$error}</li>{/foreach}</ul>
{/if}

<form name="m" method="post" action="?do=rubs&amp;action=multi&amp;pop=1&amp;sub=save&amp;Id={$smarty.request.Id}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col>
		<col width="200">

		<tr class="tableheader">
			<td>{#RUBRIK_NAME#}</td>
			<td>{#RUBRIK_URL_PREFIX#}</td>
		</tr>

		<tr class="first">
			<td><input type="text" name="RubrikName" value="{$smarty.request.RubrikName|escape}" style="width:100%"></td>
			<td><input type="text" name="UrlPrefix" value="{$smarty.request.UrlPrefix|escape}" style="width:100%"></td>
		</tr>

		<tr>
			<td colspan="2">
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_COPY#}" />
			</td>
		</tr>
	</table>
</form>
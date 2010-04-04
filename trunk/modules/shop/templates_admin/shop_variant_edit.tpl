{strip}

<h4>{#EditDescr#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_variants_category&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post">
	{$Edi}<br />
	<input class="button" type="submit" value="{#ButtonSave#}">
</form>

{/strip}
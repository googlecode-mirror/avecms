<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SNL_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#SNL_SHOW_TEXT#}</div>
</div><br />
<br />

{if $Editor}
	{$Editor}
{else}
	<textarea style="width:98%; height:400px" name="textfield">{$row->newsletter_message|escape}</textarea>
{/if}

<p align="center">
	<input type="button" class="button" onclick="window.close();" value="{#SNL_BUTTON_CLOSE#}" />
</p>
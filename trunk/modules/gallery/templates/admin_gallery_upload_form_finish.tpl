<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#UploadProg#}</h2>
	</div>
	<div class="HeaderText">&nbsp;</div>
</div>
<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#GalView#}</a>
</div><br />

<h4>{#UploadProgT#}</h4>

<div style="width:99%;padding:10px;height:200px;overflow:auto;border:1px solid #ccc">
	{foreach from=$arr item=t}{$t|escape}{/foreach}
</div>
{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#WelcomeText#}</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<a href="javascript:history.go(-1);">&laquo; {#QuickStartBack#}</a><br />
<br />

<h4 class="navi">{#QuickStartRez#}</h4><br />

{#QuickStartRezInf#}<strong>100</strong><br />
<br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	{foreach from=$Rez item=r}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			{assign var="num" value=$num+1}
			<td>
				<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_comments&cp={$sess}&pop=1&Id={$r->ArtNr}','980','740','1','edit_comments');">{$r->Artname}</a>
			</td>
		</tr>
	{/foreach}
</table>

{/strip}
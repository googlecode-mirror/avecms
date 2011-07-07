<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#WelcomeText#}</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="49%" valign="top">
			<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
				<tr>
					<td>
						<h4 class="navi">{#QuickStartTopseller#}</h4><br />
						{#QuickStartTopSellerInf#}
					</td>
				</tr>

				<tr>
					<td style="padding:5px">
						<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
							<tr>
								<td>&nbsp;</td>
								<td><strong>{#CatName#}</strong></td>
								<td><strong>{#ProductBought#}</strong></td>
							</tr>

							{foreach from=$TopSeller item=ts}
								<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows"> {assign var="num" value=$num+1}
									<td width="25"> {if $num<10}0{/if}{$num}.</td>
									<td> <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$ts->Id}','980','740','1','edit_product');">{$ts->ArtName|truncate:55}</a></td>
									<td>{$ts->Bestellungen}</td>
								</tr>
							{/foreach}
						</table><br />

						<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
							<tr>
								<td class="first" align="right">
									<a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=1&cp={$sess}&sub=topseller">&raquo; {#QuickStartShowHundret#}</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>

		<td valign="top">&nbsp;</td>

		<td width="49%" valign="top">
			<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
				<tr>
					<td>
						<h4 class="navi">{#QuickStartFlopseller#}</h4><br />
						{#QuickStartFlopSellerInf#}
					</td>
				</tr>

				<tr>
					<td style="padding:5px">
						<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
							<tr>
								<td>&nbsp;</td>
								<td><strong>{#CatName#}</strong></td>
								<td><strong>{#ProductBought#}</strong></td>
							</tr>

							{assign var="num" value="0"}
							{foreach from=$FlopSeller item=ts}
								<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows"> {assign var="num" value=$num+1}
									<td width="25"> {if $num<10}0{/if}{$num}.</td>
									<td> <a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_product&cp={$sess}&pop=1&Id={$ts->Id}','980','740','1','edit_product');">{$ts->ArtName|truncate:55}</a></td>
									<td>{$ts->Bestellungen}</td>
								</tr>
							{/foreach}
						</table><br />

						<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
							<tr>
								<td class="first" align="right">
									<a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=1&cp={$sess}&sub=flopseller">&raquo; {#QuickStartShowHundret#}</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td><h4 class="navi">{#QuickStartRez#}</h4><br>{#QuickStartRezInf#}10</td>
	</tr>

	<tr>
		<td style="padding:1px">
			<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
				{foreach from=$Rez item=r}
					<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows"> {assign var="num" value=$num+1}
						<td>
							<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_comments&cp={$sess}&pop=1&Id={$r->ArtNr}','980','740','1','edit_comments');">{$r->Artname}</a>
						</td>
					</tr>
				{/foreach}
			</table><br />

			<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
				<tr>
					<td class="first" align="right">
						<a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=1&cp={$sess}&sub=rez">&raquo; {#QuickStartShowHundret#}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
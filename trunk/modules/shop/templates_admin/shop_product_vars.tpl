<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductVarsEdit#}</h2></div>
	<div class="HeaderText">{#ProductVarsEditInf#}</div>
</div><br />

{if $Vars}
	<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=product_vars&cp={$sess}&sub=save&pop=1&Id={$smarty.request.Id}&KatId={$smarty.request.KatId}" method="post">
		<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
			{foreach from=$Vars item=var}
				<tr class="second">
					<td width="1%" class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
					<td width="150" nowrap class="tableheader">{$var->Name|stripslashes}</td>
					<td width="50" class="tableheader"><div align="center">{#ProductVarOp#}</div></td>
					<td width="50" class="tableheader">{#ProductArtVarW#}</td>
					<td width="50" class="tableheader">{#Position#}</td>
					<td class="tableheader">&nbsp;</td>
				</tr>

				{foreach from=$var->SubVars item=sv}
					<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
						<td width="1%" align="center">
							<input title="{#Delete#}" name="Del[{$sv->Id}]" type="checkbox" value="1" />
						</td>

						<td width="150" nowrap>
							<input style="width:160px" type="text" name="Name[{$sv->Id}]" value="{$sv->Name|stripslashes}" />
						</td>

						<td width="50">
							<div align="center">
								<select style="width:50px" name="Operant[{$sv->Id}]">
									<option value="+" {if $sv->Operant=='+'}selected{/if}>+</option>
									<option value="-" {if $sv->Operant=='-'}selected{/if}>-</option>
								</select>
							</div>
						</td>

						<td width="50">
							<input style="width:80px" name="Wert[{$sv->Id}]" type="text" value="{$sv->Wert}" />
						</td>

						<td width="50" align="center">
							<input style="width:40px" name="Position[{$sv->Id}]" type="text" value="{$sv->Position}" />
						</td>

						<td>&nbsp;</td>
					</tr>
				{/foreach}

				<tr>
					<td width="1%">&nbsp;</td>

					<td width="150">
						<input style="width:160px; background:#FFFFCC" type="text" name="NameNew[{$var->Id}]" />
					</td>

					<td width="50">
						<div align="center">
							<select style="width:50px; background:#FFFFCC" name="OperantNew[{$var->Id}]">
								<option value="+">+</option>
								<option value="-">-</option>
							</select>
						</div>
					</td>

					<td width="50">
						<input style="width:80px; background:#FFFFCC" name="WertNew[{$var->Id}]" type="text" />
					</td>

					<td width="50" align="center">
						<input name="PositionNew[{$var->Id}]" type="text" style="width:40px; background:#FFFFCC" />
					</td>

					<td>{#ProductArtVarAdd#}</td>
				</tr>
			{/foreach}
		</table><br />

		<input type="submit" class="button" value="{#ButtonSave#}" />
	</form>
{else}
	<div class="infobox">{#ProductNoVarsP#}</div>
{/if}
<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductCategChild#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=new_categ&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="200" valign="top" class="first">
		<col class="second">
		<tr>
			<td>{#SShipperName#}</td>
			<td>
				<input style="width:100%" type="text" name="KatName" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductCategsParent#}</td>
			<td>
				<select style="width:250px" name="Elter">
					<option value="0">{#ProductCategsNoParent#}</option>
					{foreach from=$ProductCategs item=pc}
						<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$smarty.request.Id}selected="selected"{/if}>{$pc->visible_title}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductCategEDescr#}</td>
			<td>
{*				<textarea style="width:100%; height:120px" name="KatBeschreibung"></textarea>
*}				{$KatBeschreibung}
			</td>
		</tr>

		<tr>
			<td>{#Position#}</td>
			<td>
				<input name="Rang" type="text" value="1" size="10" maxlength="4" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductNewImage#}</td>
			<td>
				<input name="Bild" size="68" type="file" id="Bild" />
			</td>
		</tr>

		<tr>
			<td>bid</td>
			<td>
				<input name="bid" type="text" value="0" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td>cbid</td>
			<td>
				<input name="cbid" type="text" value="0" size="10" maxlength="5" />
			</td>
		</tr>
	</table><br />

	<input class="button" type="submit" value="{#ButtonSave#}" />
</form>
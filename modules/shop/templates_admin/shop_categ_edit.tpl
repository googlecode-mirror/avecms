<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductCategEEdit#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=edit_categ&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="200" valign="top" class="first">
		<col class="second">
		<tr>
			<td>{#SShipperName#}</td>
			<td>
				<input style="width:100%" type="text" name="KatName" value="{$row->KatName|escape:html|stripslashes}" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ProductCategEDescr#}</td>
			<td>
{*				<textarea style="width:100%; height:120px" name="KatBeschreibung">{$row->KatBeschreibung|stripslashes|escape:html}</textarea>
*}				{$row->KatBeschreibung}
			</td>
		</tr>

		<tr>
			<td>{#Position#}</td>
			<td>
				<input name="position" type="text" value="{$row->position}" size="10" maxlength="4" />
			</td>
		</tr>

		{if $row->Bild != ''}
			<tr>
				<td>{#ProductCategEImage#}</td>
				<td>
					<img src="../modules/shop/uploads/{$row->Bild}">
					<input name="Old" type="hidden" id="Old" value="{$row->Bild}" />
					<input name="ImgDel" type="checkbox" id="ImgDel" value="1" />
					{#ProductCategEImageDel#}
				</td>
			</tr>
		{/if}

		<tr>
			<td class="first">{#ProductNewImage#}</td>
			<td>
				<input name="Bild" size="68" type="file" id="Bild" />
			</td>
		</tr>

		<tr>
			<td>bid</td>
			<td>
				<input name="bid" type="text" value="{$row->bid}" size="10" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td>cbid</td>
			<td>
				<input name="cbid" type="text" value="{$row->cbid}" size="10" maxlength="5" />
			</td>
		</tr>
	</table><br />

	<input class="button" type="submit" value="{#ButtonSave#}" />
</form>
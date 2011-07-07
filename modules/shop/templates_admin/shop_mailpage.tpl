<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductOrdersMailCustomer#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=mailpage&OrderId={$smarty.request.OrderId}&cp={$sess}&pop=1&sub=save" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="150" class="first">
		<col class="second">
		<tr>
			<td>{#ProductOrdersMailSubject#}</td>
			<td>
				<input name="Subject" type="text" style="width:97%" value="{#ProductOrdersSubjectOrder#} {$row.Datum|date_format:#DateFormat#}" size="35" />
			</td>
		</tr>

		<tr>
			<td>{#ProductOrdersMessage#}</td>
			<td>
				<textarea name="Message" style="width:97%;height:300px" id="Message">{$row.ProductOrdersMailPreBody}{$row.RechnungText|escape}</textarea>
			</td>
		</tr>

		{if $no_uploads != 1}
			<tr>
				<td>
					{#ProductOrdersUpload#}<br />
					<small>{#ProductOrdersUploadMessage#} {$UploadSize}</small>
				</td>

				<td>
					<input name="upfile[]" type="file"><br />
					<input name="upfile[]" type="file"><br />
					<input name="upfile[]" type="file"><br />
					<input name="upfile[]" type="file"><br />
					<input name="upfile[]" type="file">
				</td>
			</tr>
		{/if}

		<tr>
			<td>&nbsp;</td>
			<td>
				<input name="mto" type="hidden" id="mto" value="{$row.Bestell_Email}" />
				<input type="submit" class="button" value="{#ProductOrdersMailSend#}" />
			</td>
		</tr>
	</table>
</form>
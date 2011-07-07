<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ProductEsds#}</h2></div>
	<div class="HeaderText">{#FileInf#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=esd_downloads&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
			<td width="150" class="tableheader">{#ProductEsdFileDownload#}</td>
			<td width="110" class="tableheader">{#ProductEsdFileType#}</td>
			<td class="tableheader">{#EsdName#}</td>
			<td class="tableheader">{#ProductEsdDescr#}</td>
			<td class="tableheader">{#ProductEsdPos#}</td>
		</tr>

		<tr>
			<td colspan="6" class="tableheader"><strong>{#EsdFull#}</strong></td>
		</tr>

		{foreach from=$downloads_full item=dl}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" align="center"><input title="{#Delete#}" type="checkbox" name="Del[{$dl->Id}]" value="1"></td>
				<td width="130">
					<select style="width:210px" name="Datei[{$dl->Id}]">
						{foreach from=$esds item=dlf}
							<option value="{$dlf}" {if $dl->Datei==$dlf}selected="selected"{/if}>{$dlf}</option>
						{/foreach}
					</select>
				</td>

				<td width="110">
					<select style="width:110px" name="DateiTyp[{$dl->Id}]">
						<option value="full" {if $dl->DateiTyp=='full'}selected="selected"{/if}>{#ProductEsdFull#}</option>
						<option value="update" {if $dl->DateiTyp=='update'}selected="selected"{/if}>{#ProductEsdUpdate#}</option>
						<option value="bugfix" {if $dl->DateiTyp=='bugfix'}selected="selected"{/if}>{#ProductEsdBugfix#}</option>
						<option value="other" {if $dl->DateiTyp=='other'}selected="selected"{/if}>{#ProductEsdOther#}</option>
					</select>
				</td>

				<td>
					<input style="width:210px" name="title[{$dl->Id}]" type="text" value="{$dl->title|escape:html|stripslashes}" />
				</td>

				<td>
					<textarea wrap="off" title="{#ProductEsdOtherDlTimeClick#}" style="width:280px;height:50px" onclick="this.style.height='200px'" onmouseout="this.style.height='50px'" name="description[{$dl->Id}]">{$dl->description|escape:html|stripslashes}</textarea>
				</td>

				<td>
					<input name="Position[{$dl->Id}]" type="text" size="2" maxlength="3" value="{$dl->Position}" />
				</td>
			</tr>
		{/foreach}

		<tr>
			<td colspan="6" class="tableheader"><strong>{#ProductEsdUpdate#}</strong></td>
		</tr>

		{foreach from=$downloads_updates item=dl}
			<tr class="{cycle name='esd' values='first,second'}">
				<td width="1%" align="center"><input title="{#Delete#}" type="checkbox" name="Del[{$dl->Id}]" value="1"></td>
				<td width="130">
					<select style="width:210px" name="Datei[{$dl->Id}]">
						{foreach from=$esds item=dlf}
							<option value="{$dlf}" {if $dl->Datei==$dlf}selected="selected"{/if}>{$dlf}</option>
						{/foreach}
					</select>
				</td>

				<td width="110">
					<select style="width:110px" name="DateiTyp[{$dl->Id}]">
						<option value="full" {if $dl->DateiTyp=='full'}selected="selected"{/if}>{#ProductEsdFull#}</option>
						<option value="update" {if $dl->DateiTyp=='update'}selected="selected"{/if}>{#ProductEsdUpdate#}</option>
						<option value="bugfix" {if $dl->DateiTyp=='bugfix'}selected="selected"{/if}>{#ProductEsdBugfix#}</option>
						<option value="other" {if $dl->DateiTyp=='other'}selected="selected"{/if}>{#ProductEsdOther#}</option>
					</select>
				</td>

				<td>
					<input style="width:210px" name="title[{$dl->Id}]" type="text" value="{$dl->title|escape:html|stripslashes}" >
				</td>

				<td>
					<textarea wrap="off" title="{#ProductEsdOtherDlTimeClick#}" style="width:280px;height:50px" onclick="this.style.height='200px'" onmouseout="this.style.height='50px'" name="description[{$dl->Id}]">{$dl->description|escape:html|stripslashes}</textarea>
				</td>

				<td>
					<input name="Position[{$dl->Id}]" type="text" size="2" maxlength="3" value="{$dl->Position}">
				</td>
			</tr>
		{/foreach}

		<tr>
			<td colspan="6" class="tableheader"><strong>{#ProductEsdBugfix#}</strong></td>
		</tr>

		{foreach from=$downloads_bugfixes item=dl}
			<tr class="{cycle name='esd' values='first,second'}">
				<td width="1%" align="center"><input title="{#Delete#}" type="checkbox" name="Del[{$dl->Id}]" value="1"></td>
				<td width="130">
					<select style="width:210px" name="Datei[{$dl->Id}]">
						{foreach from=$esds item=dlf}
							<option value="{$dlf}" {if $dl->Datei==$dlf}selected="selected"{/if}>{$dlf}</option>
						{/foreach}
					</select>
				</td>

				<td width="110">
					<select style="width:110px" name="DateiTyp[{$dl->Id}]">
						<option value="full" {if $dl->DateiTyp=='full'}selected="selected"{/if}>{#ProductEsdFull#}</option>
						<option value="update" {if $dl->DateiTyp=='update'}selected="selected"{/if}>{#ProductEsdUpdate#}</option>
						<option value="bugfix" {if $dl->DateiTyp=='bugfix'}selected="selected"{/if}>{#ProductEsdBugfix#}</option>
						<option value="other" {if $dl->DateiTyp=='other'}selected="selected"{/if}>{#ProductEsdOther#}</option>
					</select>
				</td>

				<td>
					<input style="width:210px" name="title[{$dl->Id}]" type="text" value="{$dl->title|escape:html|stripslashes}">
				</td>

				<td>
					<textarea wrap="off" title="{#ProductEsdOtherDlTimeClick#}" style="width:280px;height:50px" onclick="this.style.height='200px'" onmouseout="this.style.height='50px'" name="description[{$dl->Id}]">{$dl->description|escape:html|stripslashes}</textarea>
				</td>

				<td>
					<input name="Position[{$dl->Id}]" type="text" size="2" maxlength="3" value="{$dl->Position}">
				</td>
			</tr>
		{/foreach}

		<tr>
			<td colspan="6" class="tableheader"><strong>{#ProductEsdOther#}</strong></td>
		</tr>

		{foreach from=$downloads_other item=dl}
			<tr class="{cycle name='esd' values='first,second'}">
				<td width="1%" align="center"><input title="{#Delete#}" type="checkbox" name="Del[{$dl->Id}]" value="1"></td>
				<td width="130">
					<select style="width:210px" name="Datei[{$dl->Id}]">
						{foreach from=$esds item=dlf}
							<option value="{$dlf}" {if $dl->Datei==$dlf}selected="selected"{/if}>{$dlf}</option>
						{/foreach}
					</select>
				</td>

				<td width="110">
					<select style="width:110px" name="DateiTyp[{$dl->Id}]">
						<option value="full" {if $dl->DateiTyp=='full'}selected="selected"{/if}>{#ProductEsdFull#}</option>
						<option value="update" {if $dl->DateiTyp=='update'}selected="selected"{/if}>{#ProductEsdUpdate#}</option>
						<option value="bugfix" {if $dl->DateiTyp=='bugfix'}selected="selected"{/if}>{#ProductEsdBugfix#}</option>
						<option value="other" {if $dl->DateiTyp=='other'}selected="selected"{/if}>{#ProductEsdOther#}</option>
					</select>
				</td>

				<td>
					<input style="width:210px" name="title[{$dl->Id}]" type="text" value="{$dl->title|escape:html|stripslashes}">
				</td>

				<td>
					<textarea wrap="off" title="{#ProductEsdOtherDlTimeClick#}" style="width:280px;height:50px" onclick="this.style.height='200px'" onmouseout="this.style.height='50px'" name="description[{$dl->Id}]">{$dl->description|escape:html|stripslashes}</textarea>
				</td>

				<td>
					<input name="Position[{$dl->Id}]" type="text" size="2" maxlength="3" value="{$dl->Position}">
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

<h4>{#ProductEsdsNew#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=esd_downloads&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=new">

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td width="150" class="tableheader">{#ProductEsdFileDownload#}</td>
		<td width="110" class="tableheader">{#ProductEsdFileType#}</td>
		<td class="tableheader">{#EsdName#}</td>
		<td class="tableheader">{#ProductEsdDescr#}</td>
		<td class="tableheader">{#ProductEsdPos#}</td>
	</tr>

	<tr class="first">
		<td width="130">
			<select style="width:250px" name="Datei">
				{foreach from=$esds item=dlf}
					<option value="{$dlf}">{$dlf}</option>
				{/foreach}
			</select>
		</td>

		<td width="110">
			<select style="width:110px" name="DateiTyp">
				<option value="full">{#ProductEsdFull#}</option>
				<option value="update">{#ProductEsdUpdate#}</option>
				<option value="bugfix">{#ProductEsdBugfix#}</option>
				<option value="other">{#ProductEsdOther#}</option>
			</select>
		</td>

		<td>
			<input style="width:180px" name="title" type="text" value="Name" />
		</td>

		<td>
			<textarea wrap="off" title="{#ProductEsdOtherDlTimeClick#}" style="width:280px;height:50px" onclick="this.style.height='200px'" onmouseout="this.style.height='50px'" name="description"></textarea>
		</td>

		<td>
			<input name="Position" type="text" size="2" maxlength="3" value="1" />
		</td>
	</tr>
</table>

<input type="submit" class="button" value="{#ButtonSave#}">

</form>

<p>&nbsp;</p>

<hr noshade="noshade" size="1">

<p align="center">
	<input type="button" onclick="window.close();" class="button" value="{#WindowClose#}">
</p>
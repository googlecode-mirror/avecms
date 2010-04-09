<!-- myprofile.tpl -->
{strip}

<h2 id="page-heading">{#LOGIN_CHANGE_DETAILS#}</h2>

<div id="module_content">
	<p><em>{#LOGIN_DETAILS_INFO#}</em>{$row.land}</p>

	{if $errors}
		<div class="infobox">
			<h2 class="error">{#LOGIN_ERRORS#}</h2>
			<ul>
				{foreach from=$errors item=error}
					<li class="regerror">{$error}</li>
				{/foreach}
			</ul>
		</div><br />
	{/if}

	{if $changed==1}
		<p>&nbsp;</p>
		<p><h2>{#LOGIN_CHANGED_OK#}</h2></p>
		<p>&nbsp;</p>
	{/if}

	<form method="post" action="index.php?module=login&action=profile&sub=update">
		<div class="formleft"><label for="l_reg_Firma">{#LOGIN_YOUR_COMPANY#}</label></div>
		<div class="formright">
			<input name="Firma" type="text" id="l_reg_Firma" style="width:200px" value="{$smarty.request.Firma|default:$row.Firma|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_firstname">{#LOGIN_YOUR_FIRSTNAME#}</label></div>
		<div class="formright">
			<input name="Vorname" type="text" id="l_reg_firstname" style="width:200px" value="{$smarty.request.Vorname|default:$row.Vorname|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_lastname">{#LOGIN_YOUR_LASTNAME#}</label></div>
		<div class="formright">
			<input name="Nachname" type="text" id="l_reg_lastname" style="width:200px" value="{$smarty.request.Nachname|default:$row.Nachname|escape}" size="50" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_street">{#LOGIN_YOUR_STREET#}</label> / <label for="l_nr">{#LOGIN_YOUR_HOUSE#}</label></div>
		<div class="formright">
			<input name="Strasse" type="text" id="l_street" style="width:150px" value="{$smarty.request.Strasse|default:$row.Strasse|escape}" size="50" maxlength="50" />&nbsp;
			<input name="HausNr" type="text" id="l_nr" style="width:40px" value="{$smarty.request.HausNr|default:$row.HausNr|escape}" size="50" maxlength="10" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_zip">{#LOGIN_YOUR_ZIP#}</label> / <label for="l_town">{#LOGIN_YOUR_TOWN#}</label></div>
		<div class="formright">
			<input name="Postleitzahl" type="text" id="l_zip" style="width:40px" value="{$smarty.request.Postleitzahl|default:$row.Postleitzahl|escape}" size="50" maxlength="15" />&nbsp;
			<input name="city" type="text" id="l_town" style="width:150px" value="{$smarty.request.city|default:$row.city|escape}" size="50" maxlength="50" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_email">{#LOGIN_YOUR_MAIL#}</label></div>
		<div class="formright">
			<input name="Email" type="text" id="l_email" style="width:200px" value="{$smarty.request.Email|default:$row.Email|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_phone">{#LOGIN_YOUR_PHONE#}</label></div>
		<div class="formright">
			<input name="Telefon" type="text" id="l_phone" style="width:200px" value="{$smarty.request.Telefon|default:$row.Telefon|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_fax">{#LOGIN_YOUR_FAX#}</label></div>
		<div class="formright">
			<input name="Telefax" type="text" id="l_fax" style="width:200px" value="{$smarty.request.Telefax|default:$row.Telefax|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_geb">{#LOGIN_YOUR_BIRTHDAY#}</label></div>
		<div class="formright">
			<input name="GebTag" type="text" id="l_geb" style="width:100px" value="{$smarty.request.GebTag|default:$row.GebTag|escape}" size="80" maxlength="10" />&nbsp;
			{#LOGIN_DATE_FORMAT#}
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_land">{#LOGIN_YOUR_COUNTRY#}</label></div>
		<div class="formright">
			<select name="Land" id="l_land">
				{foreach from=$available_countries item=land}
					<option value="{$land->LandCode}"{if $land->LandCode == $row.land|default:$DEF_COUNTRY} selected{/if}>{$land->LandName}</option>
				{/foreach}
			</select>
		</div>
		<div class="clear"></div>

		<div class="formleft">&nbsp;</div>
		<div class="formright">
			<input class="button" type="submit" value="{#LOGIN_BUTTON_CHANGE#}" />
		</div>
		<div class="clear"></div>
	</form>
</div>

{/strip}
<!-- /myprofile.tpl -->

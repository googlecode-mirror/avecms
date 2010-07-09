<div class="box">
	<h2>
		<a href="#" id="toggle-forms">{#LOGIN_CHANGE_DETAILS#}</a>
	</h2>
	<div class="block" id="forms">
		<p>{#LOGIN_DETAILS_INFO#}</p>

		{if $errors}
			<div class="infobox">
				<p>{#LOGIN_ERRORS#}</p>
				<ul>
					{foreach from=$errors item=error}
						<li>{$error}</li>
					{/foreach}
				</ul>
			</div><br />
		{/if}

		{if $password_changed==1}
			<p>{#LOGIN_CHANGED_OK#}</p>
		{/if}

		<form method="post" action="index.php?module=login&action=profile&sub=update">
			<fieldset>
				<p>
					<label>{#LOGIN_YOUR_FIRSTNAME#}</label>
					<input name="firstname" type="text" value="{$smarty.request.firstname|default:$row.firstname|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_LASTNAME#}</label>
					<input name="lastname" type="text" value="{$smarty.request.lastname|default:$row.lastname|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_BIRTHDAY#} {#LOGIN_DATE_FORMAT#}</label>
					<input name="birthday" type="text" value="{$smarty.request.birthday|default:$row.birthday|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_MAIL#}</label>
					<input name="email" type="text" value="{$smarty.request.email|default:$row.email|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_COUNTRY#}</label>
					<select name="country">
						{assign var=uc value=$row->country|default:$smarty.session.user_language|lower}
						{foreach from=$available_countries item=land}
							<option value="{$land->country_code}"{if $land->country_code == $smarty.request.country|default:$row.country|default:$smarty.session.user_language|lower} selected{/if}>{$land->country_name}</option>
						{/foreach}
					</select>
				</p>
				<p>
					<label>{#LOGIN_YOUR_TOWN#}</label>
					<input name="city" type="text" value="{$smarty.request.city|default:$row.city|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_ZIP#}</label>
					<input name="zipcode" type="text" value="{$smarty.request.zipcode|default:$row.zipcode|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_STREET#}</label>
					<input name="street" type="text" value="{$smarty.request.street|default:$row.street|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_HOUSE#}</label>
					<input name="street_nr" type="text" value="{$smarty.request.street_nr|default:$row.street_nr|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_PHONE#}</label>
					<input name="phone" type="text" value="{$smarty.request.phone|default:$row.phone|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_FAX#}</label>
					<input name="telefax" type="text" value="{$smarty.request.telefax|default:$row.telefax|escape|stripslashes}" />
				</p>
				<p>
					<label>{#LOGIN_YOUR_COMPANY#}</label>
					<input name="company" type="text" value="{$smarty.request.company|default:$row.company|escape|stripslashes}" />
				</p>
				<input class="confirm button" value="{#LOGIN_BUTTON_CHANGE#}" type="submit">
			</fieldset>
		</form>
	</div>
</div>
{*
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

	{if $password_changed==1}
		<p>&nbsp;</p>
		<p><h2>{#LOGIN_CHANGED_OK#}</h2></p>
		<p>&nbsp;</p>
	{/if}

	<form method="post" action="index.php?module=login&action=profile&sub=update">
		<div class="formleft"><label for="l_reg_Firma">{#LOGIN_YOUR_COMPANY#}</label></div>
		<div class="formright">
			<input name="company" type="text" id="l_reg_Firma" style="width:200px" value="{$smarty.request.company|default:$row.company|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_firstname">{#LOGIN_YOUR_FIRSTNAME#}</label></div>
		<div class="formright">
			<input name="firstname" type="text" id="l_reg_firstname" style="width:200px" value="{$smarty.request.firstname|default:$row.firstname|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_reg_lastname">{#LOGIN_YOUR_LASTNAME#}</label></div>
		<div class="formright">
			<input name="lastname" type="text" id="l_reg_lastname" style="width:200px" value="{$smarty.request.lastname|default:$row.lastname|escape}" size="50" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_street">{#LOGIN_YOUR_STREET#}</label> / <label for="l_nr">{#LOGIN_YOUR_HOUSE#}</label></div>
		<div class="formright">
			<input name="street" type="text" id="l_street" style="width:150px" value="{$smarty.request.street|default:$row.street|escape}" size="50" maxlength="50" />&nbsp;
			<input name="street_nr" type="text" id="l_nr" style="width:40px" value="{$smarty.request.street_nr|default:$row.street_nr|escape}" size="50" maxlength="10" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_zip">{#LOGIN_YOUR_ZIP#}</label> / <label for="l_town">{#LOGIN_YOUR_TOWN#}</label></div>
		<div class="formright">
			<input name="zipcode" type="text" id="l_zip" style="width:40px" value="{$smarty.request.zipcode|default:$row.zipcode|escape}" size="50" maxlength="15" />&nbsp;
			<input name="city" type="text" id="l_town" style="width:150px" value="{$smarty.request.city|default:$row.city|escape}" size="50" maxlength="50" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_email">{#LOGIN_YOUR_MAIL#}</label></div>
		<div class="formright">
			<input name="email" type="text" id="l_email" style="width:200px" value="{$smarty.request.email|default:$row.email|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_phone">{#LOGIN_YOUR_PHONE#}</label></div>
		<div class="formright">
			<input name="phone" type="text" id="l_phone" style="width:200px" value="{$smarty.request.phone|default:$row.phone|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_fax">{#LOGIN_YOUR_FAX#}</label></div>
		<div class="formright">
			<input name="telefax" type="text" id="l_fax" style="width:200px" value="{$smarty.request.telefax|default:$row.telefax|escape}" size="80" />
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_geb">{#LOGIN_YOUR_BIRTHDAY#}</label></div>
		<div class="formright">
			<input name="birthday" type="text" id="l_geb" style="width:100px" value="{$smarty.request.birthday|default:$row.birthday|escape}" size="80" maxlength="10" />&nbsp;
			{#LOGIN_DATE_FORMAT#}
		</div>
		<div class="clear"></div>

		<div class="formleft"><label for="l_land">{#LOGIN_YOUR_COUNTRY#}</label></div>
		<div class="formright">
			<select name="country" id="l_land">
				{foreach from=$available_countries item=land}
					<option value="{$land->country_code}"{if $land->country_code == $row.land|default} selected{/if}>{$land->country_name}</option>
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
*}
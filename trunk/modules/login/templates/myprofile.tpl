
<h2 id="page-heading">{#LOGIN_CHANGE_DETAILS#}</h2>

<div class="block" id="forms">
	<p>{#LOGIN_DETAILS_INFO#}</p>

	{if $errors}
		<div class="infobox">
			<p>{#LOGIN_ERRORS#}</p>
			<ul>
				{foreach from=$errors item=error}
					<li class="regerror">{$error}</li>
				{/foreach}
			</ul>
		</div><br />
	{/if}

	{if $password_changed==1}
		<p class="regerror">{#LOGIN_CHANGED_OK#}</p>
	{/if}

	<form method="post" action="index.php?module=login&action=profile">
		<input type="hidden" name="sub" value="update" />
		<fieldset class="login">
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

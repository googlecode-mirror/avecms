{if $no_access}
	<p>{$contact_form_message_noaccess|default:#CONTACT_NO_ACCESS#|escape}</p>
{else}

<script language="javascript" type="text/javascript">
function checkForm(obj, elems) {ldelim}
	var element, pattern;
	for (var i = 0; i < obj.elements.length; i++) {ldelim}
		element = obj.elements[i];
		if (elems != undefined)
			if (elems.join().indexOf(element.type) < 0) continue;
		if (!element.getAttribute("check_message")) continue;
		if (pattern = element.getAttribute("check_pattern")) {ldelim}
			pattern = new RegExp(pattern, "g");
			if (!pattern.test(element.value)) {ldelim}
				alert(element.getAttribute("check_message"));
				element.focus();
				return false;
			{rdelim}
		{rdelim}
		else if (/^\s*$/.test(element.value)) {ldelim}
			alert(element.getAttribute("check_message"));
			element.focus();
			return false;
		{rdelim}
	{rdelim}
	return true;
{rdelim}
</script>

<div id="module_content">
	{#CONTACT_REQUIRED_INFO#}<br />
	<form method="post" enctype="multipart/form-data" onSubmit='return checkForm(this)'>
		{if $wrong_securecode}
			<body onload="location.href='#ws'">
			<a name="ws"></a>
			<h3>{#CONTACT_WRONG_CODE#}</h3>
		{/if}

		<div class="mod_contact_left"><label for="contact_form_in_email">{#CONTACT_FORM_EMAIL#} <span class="mod_contact_left_star">*</span></label></div>
		<div class="mod_contact_right"><input type="text" value="{$smarty.request.contact_form_in_email|default:$smarty.session.user_email|stripslashes|escape}" name="contact_form_in_email" id="contact_form_in_email" style="width:215px;" {literal}check_pattern="^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$"{/literal} check_message="{#CONTACT_CHECK_EMAIL#}" /></div>

		{if $recievers}
			<div class="mod_contact_left">{#CONTACT_FORM_RECIVER#}</div>
			<div class="mod_contact_right">
				{html_options name=reciever options=$recievers style="width:220px"}
			</div>
		{/if}

		{if $default_subject}
            <input type="hidden" value="{$default_subject}" id="contact_form_in_subject" name="contact_form_in_subject" />
        {else}
			<div class="mod_contact_left"><label for="contact_form_in_subject">{#CONTACT_FORM_SUBJECT#} <span class="mod_contact_left_star">*</span></label></div>
			<div class="mod_contact_right"><input type="text" value="{$smarty.request.contact_form_in_subject|stripslashes|escape}" name="contact_form_in_subject" id="contact_form_in_subject" style="width:95%;" check_message="{#CONTACT_CHECK_TITLE#}" /></div>
		{/if}

		{foreach from=$fields item=field}
			{if $field->contact_field_newline == 1}
				<div class="clear"></div>
			{/if}

			<div class="mod_contact_field" style="float:left; width:{$field->contact_field_size|default:'300'}px;">
				<div class="mod_contact_left">
					<label for="cp_{$field->Id}">{$field->contact_field_title|escape}: {if $field->contact_field_required == '1'}<span class="mod_contact_left_star">*</span>{/if}</label>
					{if $field->contact_field_type == 'fileupload' && $maxupload >= 1}
						<br /><small>{#CONTACT_FORM_MAX_FILE#} {$maxupload} {#CONTACT_FILE_KB#}</small>
					{/if}
				</div>

				<div class="mod_contact_right">
					{if $field->contact_field_type == 'textfield'}
						<textarea style="width:95%;height:100px;" name="{$field->contact_field_title|escape|replace:' ':'_'}" id="cp_{$field->Id}"{if !empty($field->field_pattern)} check_pattern="{$field->field_pattern}"{/if}{if !empty($field->field_pattern) || $field->contact_field_required == 1} check_message="{$field->contact_field_value|escape}"{/if}>{$field->value|escape}</textarea>
					{elseif $field->contact_field_type == 'text'}
						<input style="width:95%;" type="text" name="{$field->contact_field_title|escape|replace:' ':'_'}" id="cp_{$field->Id}" value="{$field->value|default:$field->contact_field_default|escape}"{if !empty($field->field_pattern)} check_pattern="{$field->field_pattern}"{/if}{if !empty($field->field_pattern) || $field->contact_field_required == 1} check_message="{$field->contact_field_value|escape}"{/if} />
					{elseif $field->contact_field_type == 'checkbox'}
						<input style="border:0px;background-color:transparent;" type="checkbox" name="{$field->contact_field_title|escape|replace:' ':'_'}" id="cp_{$field->Id}" value="{$field->contact_field_default|escape|default:'1'}"{if $field->contact_field_required == 1} check_message="{$field->contact_field_value|escape}"{/if} />
						&nbsp;{$field->contact_field_default|escape}
					{elseif $field->contact_field_type == 'fileupload'}
						<input name="upfile[]" type="file" size="20"{if $field->contact_field_required == 1} check_message="{$field->contact_field_value|escape}"{/if} />
					{elseif $field->contact_field_type == 'dropdown'}
						<select style="width:95%;" id="cp_{$field->Id}" name="{$field->contact_field_title|escape|replace:' ':'_'}"{if $field->contact_field_required == 1} check_message="{$field->contact_field_value|escape}"{/if}>
							<option></option>
							{foreach from=$field->contact_field_default item=v}
								<option value="{$v}"{if $v == $field->value} selected{/if}>{$v}</option>
							{/foreach}
						</select>
					{/if}
				</div>
			</div>
		{/foreach}

		<div class="clear"></div>

		{if $send_copy}
			<div class="mod_contact_left"><label for="input_sendcopy">{#CONTACT_SEND_COPY#}</label></div>
			<div class="mod_contact_right"><input style="border:0px; background-color:transparent" name="sendcopy" type="checkbox" id="input_sendcopy" value="1" /></div>
		{/if}

		{if $im}
            <div class="mod_contact_left"><label>{#CONTACT_FORM_CODE#}</label></div>
			<div class="mod_contact_right" id="captcha"><img src="{$ABS_PATH}inc/captcha.php" alt="" width="120" height="60" border="0" /></div>

			<div class="mod_contact_left"><label for="securecode">{#CONTACT_FORM_CODE_ENTER#}</label></div>
			<div class="mod_contact_right"><input name="securecode" type="text" id="securecode" style="width:120px" maxlength="10" check_message="{#CONTACT_CHECK_CODE#}" /></div>
		{/if}

		<p>
			<div class="mod_contact_left"></div>
			<div class="mod_contact_right">
{*				<input type="hidden" name="secure_image_id" value="{$im}" />
				<input type="hidden" name="contact_form_number" value="{$contact_form_number}" />
*}				<input type="hidden" name="contact_form_id" value="{$contact_form_id}" />
				<input type="hidden" name="contact_action" value="DoPost" />
				<input type="hidden" name="modules" value="contact" />
				<input type="submit" class="button" value="{#CONTACT_BUTTON_SEND#}" />&nbsp;
				<input type="reset" class="button" value="{#CONTACT_BUTTON_CLEAN#}" />
			</div>
		</p>
	</form>
</div>
{/if}
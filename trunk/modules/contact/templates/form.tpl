<!-- form.tpl -->
{strip}

{if $no_access}
	<p>{$TextKeinZugriff}</p>
{else}

{literal}
<script language="javascript" type="text/javascript">
function checkForm(obj, elems) {
	var element, pattern;
	for (var i = 0; i < obj.elements.length; i++) {
		element = obj.elements[i];
		if (elems != undefined)
		if (elems.join().indexOf(element.type) < 0) continue;
		if (!element.getAttribute("check_message")) continue;
		if (pattern = element.getAttribute("check_pattern")) {
			pattern = new RegExp(pattern, "g");
			if (!pattern.test(element.value)) {
				alert(element.getAttribute("check_message"));
				element.focus();
				return false;
			}
		}
		else if (/^\s*$/.test(element.value)) {
			alert(element.getAttribute("check_message"));
			element.focus();
			return false;
		}
	}
	return true;
}
</script>
{/literal}

<div id="module_content">
	{#CONTACT_REQUIRED_INFO#}<br />
	<form method="post" enctype="multipart/form-data" onSubmit='return checkForm(this)'>
		{if $wrong_securecode}
			<body onload="location.href='{$smarty.server.REQUEST_URI}#ws'">
			<a name="ws"></a>
			<h3>{#CONTACT_WRONG_CODE#}</h3>
		{/if}

		<div class="mod_contact_left"><label for="in_email">{#CONTACT_FORM_EMAIL#} <span class="mod_contact_left_star">*</span></label></div>
		<div class="mod_contact_right"><input type="text" value="{$smarty.request.in_email|default:$smarty.session.user_email|stripslashes|escape:html}" name="in_email" id="in_email" style="width:215px;" {literal}check_pattern="^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$"{/literal} check_message="{#CONTACT_CHECK_EMAIL#}" /></div>

		{if $receiver}
			<div class="mod_contact_left">{#CONTACT_FORM_RECIVER#}</div>
			<div class="mod_contact_right">
				<select style="width:220px" name="reciever">
					{section name=em loop=$receiver}
						{assign var=e_id value=$e_id+1}
						<option value="{$e_id}">{$receiver[em]}</option>
					{/section}
				</select>
			</div>
		{/if}

		{if $default_subject}
            <input type="hidden" value="{$default_subject}" id="in_subject" name="in_subject" />
        {else}
			<div class="mod_contact_left"><label for="in_subject">{#CONTACT_FORM_SUBJECT#} <span class="mod_contact_left_star">*</span></label></div>
			<div class="mod_contact_right"><input type="text" value="{$smarty.request.in_subject|stripslashes|escape:html}" name="in_subject" id="in_subject" style="width:95%;" check_message="{#CONTACT_CHECK_TITLE#}" /></div>
		{/if}

		{foreach from=$fields item=field}
			{if $field->field_newline == 1}
				<div class="clear"></div>
			{/if}

			<div class="mod_contact_field" style="float:left; width:{$field->field_size}px;">
				<div class="mod_contact_left">
					<label for="cp_{$field->Id}">{$field->field_title|stripslashes|escape:html}: {if $field->field_required == '1'}<span class="mod_contact_left_star">*</span>{/if}</label>
					{if $field->field_type == 'fileupload' && $maxupload >= 1}
						<br /><small>{#CONTACT_FORM_MAX_FILE#} {$maxupload} {#CONTACT_FILE_KB#}</small>
					{/if}
				</div>

				<div class="mod_contact_right">
					{if $field->field_type == 'textfield'}
						<textarea style="width:95%;height:100px;" name="{$field->field_title|replace:' ':'_'}" id="cp_{$field->Id}"{if !empty($field->field_pattern)} check_pattern="{$field->field_pattern}"{/if}{if !empty($field->field_pattern) || $field->field_required == 1} check_message="{$field->field_message|stripslashes|escape:html}"{/if}>{$field->value|stripslashes|escape:html}</textarea>
					{elseif $field->field_type == 'text'}
						<input style="width:95%;" type="text" name="{$field->field_title|replace:' ':'_'}" id="cp_{$field->Id}" value="{$field->value|default:$field->field_default|stripslashes|escape:html}"{if !empty($field->field_pattern)} check_pattern="{$field->field_pattern}"{/if}{if !empty($field->field_pattern) || $field->field_required == 1} check_message="{$field->field_message|stripslashes|escape:html}"{/if} />
					{elseif $field->field_type == 'checkbox'}
						<input style="border:0px;background-color:transparent;" type="checkbox" name="{$field->field_title|replace:' ':'_'}" id="cp_{$field->Id}" value="{$field->field_default|default:1}"{if $field->field_required == 1} check_message="{$field->field_message|stripslashes|escape:html}"{/if} />
						&nbsp;{$field->field_default}
					{elseif $field->field_type == 'fileupload'}
						<input name="upfile[]" type="file" size="20"{if $field->field_required == 1} check_message="{$field->field_message|stripslashes|escape:html}"{/if} />
					{elseif $field->field_type == 'dropdown'}
						<select style="width:95%;" id="cp_{$field->Id}" name="{$field->field_title|replace:' ':'_'}"{if $field->field_required == 1} check_message="{$field->field_message|stripslashes|escape:html}"{/if}>
							<option></option>
							{foreach from=$field->field_default item=v}
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
			<div class="mod_contact_right"><img src="inc/captcha.php" alt="" width="120" height="60" border="0" /></div>

			<div class="mod_contact_left"><label for="securecode">{#CONTACT_FORM_CODE_ENTER#}</label></div>
			<div class="mod_contact_right"><input name="securecode" type="text" id="securecode" style="width:120px" maxlength="10" check_message="{#CONTACT_CHECK_CODE#}" /></div>
		{/if}

		<p>
			<div class="mod_contact_left"></div>
			<div class="mod_contact_right">
{*				<input type="hidden" name="secure_image_id" value="{$im}" />
				<input type="hidden" name="form_num" value="{$form_num}" />
*}				<input type="hidden" name="form_id" value="{$form_id}" />
				<input type="hidden" name="contact_action" value="DoPost" />
				<input type="hidden" name="modules" value="contact" />
				<input type="submit" class="button" value="{#CONTACT_BUTTON_SEND#}" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</p>
	</form>
</div>
{/if}

{/strip}
<!-- /form.tpl -->
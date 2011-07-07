
<div class="block" id="login-forms">
	<fieldset class="login">
		<legend>{#LOGIN_WELCOME_TEXT#}, {$smarty.session.user_name|escape}!</legend>
		<ul>
			<li><a href="{$ABS_PATH}index.php?module=login&amp;action=profile">{#LOGIN_CHANGE_DETAILS#}</a></li>
			<li><a href="{$ABS_PATH}index.php?module=login&amp;action=delaccount">{#LOGIN_DELETE_LINK#}</a></li>
			<li><a href="{$ABS_PATH}index.php?module=login&amp;action=passwordchange">{#LOGIN_CHANGE_LINK#}</a></li>
			{if check_permission("adminpanel")}
				<li><a href="{$ABS_PATH}admin/index.php" target="_blank">{#LOGIN_ADMIN_LINK#}</a></li>
			{/if}
			{if check_permission('documents')}
				{if $smarty.session.user_adminmode==1}
					<li><a href="{$ABS_PATH}index.php?module=login&amp;action=wys&amp;sub=off">{#LOGIN_WYSIWYG_OFF#}</a></li>
				{else}
					<li><a href="{$ABS_PATH}index.php?module=login&amp;action=wys&amp;sub=on">{#LOGIN_WYSIWYG_ON#}</a></li>
				{/if}
			{/if}
			<li><a href="{$ABS_PATH}index.php?module=login&amp;action=logout">{#LOGIN_LOGOUT_LINK#}</a> </li>
		</ul>
	</fieldset>
</div>

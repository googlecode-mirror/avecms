<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#COMMENT_MODULE_NAME#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=comment&moduleaction=1&cp={$sess}">{#COMMENT_MODULE_COMENTS#}</a> | <strong>{#COMMENT_MODULE_SETTINGS#}</strong>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=comment&moduleaction=settings&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="240" class="first">{#COMMENT_ENABLE_COMMENT#}</td>
			<td class="second"><input name="active" type="checkbox" value="1" {if $active=='1'}checked{/if} /></td>
		</tr>

		<tr>
			<td width="240" class="first">{#COMMENT_CHECK_ADMIN#}</td>
			<td class="second">
				<input name="moderate" type="checkbox" value="1" {if $moderate=='1'}checked{/if} />
			</td>
		</tr>

		<tr>
			<td width="240" class="first">{#COMMENT_SPAMPROTECT#}</td>
			<td class="second">
				<input name="spamprotect" type="checkbox" value="1" {if $spamprotect=='1'}checked{/if} />
			</td>
		</tr>

		<tr>
			<td width="240" class="first">{#COMMENT_FOR_GROUPS#}</td>
			<td class="second">
				<select  name="user_groups[]"  multiple="multiple" size="5" style="width:200px">
					{foreach from=$groups item=g}
						{assign var='sel' value=''}
						{if $g->Benutzergruppe}
							{if (in_array($g->Benutzergruppe,$user_groups)) }
								{assign var='sel' value='selected'}
							{/if}
						{/if}
						<option value="{$g->Benutzergruppe}" {$sel}>{$g->Name|escape:html}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td width="240" class="first">{#COMMENT_MAX_CHARS#}</td>
			<td class="second"><input name="max_chars" type="text" id="max_chars" value="{$max_chars}" size="5" maxlength="5" /></td>
		</tr>
	</table><br />

	<input type="submit" value="{#COMMENT_BUTTON_SAVE#}" class="button" />
</form>
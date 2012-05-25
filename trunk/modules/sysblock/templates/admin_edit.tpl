<script src="{$ABS_PATH}admin/codemirror/js/codemirror.js" type="text/javascript"></script>

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
    <div class="HeaderTitle">
    	<h2>{#SYSBLOCK_INSERT_H#}</h2>
    </div>
    <div class="HeaderText">{#SYSBLOCK_INSERT#}</div>
</div><br />

<div class="infobox">
	» <a href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=1&cp={$sess}">{#SYSBLOCK_LIST_LINK#}</a>
</div><br />

<form action="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=saveedit&cp={$sess}" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#SYSBLOCK_NAME#}</td>
		</tr>

		<tr>
			<td class="second">
				<input name="sysblock_name" type="text" value="{$sysblock_name|escape}" size="80" />
			</td>
		</tr>

		<tr class="tableheader">
			<td>{#SYSBLOCK_INTEXT#}</td>
		</tr>

		<tr>
			<td class="second">			
				<div class="coder_in">
					<textarea  id="coder_sours" id="sysblock_text" name="sysblock_text" cols="120" rows="30">{$sysblock_text}</textarea>
				</div>
			</td>
		</tr>

		<tr>
			<td class="first">
				{if $smarty.request.id != ''}
					<input type="hidden" name="id" value="{$id}">
					<input name="submit" type="submit" class="button" value="{#SYSBLOCK_SAVEDIT#}" />
				{else}
					<input name="submit" type="submit" class="button" value="{#SYSBLOCK_SAVE#}" />
				{/if}
				
				или 
				
				{if $smarty.request.moduleaction=='edit'}
					<input type="submit" class="button button_lev2" name="next_edit" value="{#SYSBLOCK_SAVEDIT_NEXT#}" />
				{else}
					<input type="submit" class="button button_lev2" name="next_edit" value="{#SYSBLOCK_SAVE_NEXT#}" />
				{/if}
			</td>
		</tr>
	</table>
</form>
<script src="{$ABS_PATH}admin/codemirror/config.js" type="text/javascript"></script>
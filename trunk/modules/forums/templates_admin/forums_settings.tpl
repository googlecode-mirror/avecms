<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#NavSettings#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=settings&cp={$sess}&save=1" method="post">
    <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td width="220" class="first">{#S_SenderEmail#}</td>
			<td class="second"><label>
			<input name="sender_name" type="text" id="sender_name" value="{$r.sender_name}" size="40">
			</label></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_EmailEmail#} </td>
			<td class="second"><input name="sender_mail" type="text" id="sender_mail" value="{$r.sender_mail}" size="40"></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_Badwords#}</td>
		<td class="second"><input name="bad_words" type="text" id="bad_words" value="{$r.bad_words}" size="40" style="width:98%"></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_BadwordsReplace#} </td>
			<td class="second"><input name="bad_words_replace" type="text" id="bad_words_replace" value="{$r.bad_words_replace}" size="40"></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_PopUpHeader#}	<br /><small>{#HeaderInf#}</small></td>
			<td class="second">
			<textarea name="page_header" cols="40" rows="8" id="page_header" style="width:98%">{$r.page_header|escape:html}</textarea>
			</td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_ContWidth#}</td>
			<td class="second"><input name="box_width_comm" type="text" id="box_width_comm" value="{$r.box_width_comm}" size="10" maxlength="3" /></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_ContHeight#}</td>
			<td class="second"><input name="max_lines" type="text" id="max_lines" value="{$r.max_lines}" size="10" maxlength="3" /></td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_WordLength#}	<br /><small>{#WordWrapInf#} </small></td>
			<td class="second"><input name="max_length_word" type="text" id="max_length_word" value="{$r.max_length_word}" size="10" maxlength="3" /></td>
		</tr>
		<tr>
		    <td width="220" class="first">{#S_SysAvatars#}	<br /><small>{#AvatarInf#} </small></td>
			<td class="second">
			<input type="radio" name="sys_avatars" value="1" {if $r.sys_avatars==1}checked{/if} />{#Yes#}
			<input type="radio" name="sys_avatars" value="0" {if $r.sys_avatars==0}checked{/if} />{#No#}
			</td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_BBCode#} </td>
			<td class="second">
			<input type="radio" name="bbcode" value="1" {if $r.bbcode==1}checked{/if} />{#Yes#}
			<input type="radio" name="bbcode" value="0" {if $r.bbcode==0}checked{/if} />{#No#}
			</td>
		</tr>
		<tr>
			<td width="220" class="first">{#S_Smilies#}</td>
			<td class="second">
			<input type="radio" name="smilies" value="1" {if $r.smilies==1}checked{/if} />{#Yes#}
			<input type="radio" name="smilies" value="0" {if $r.smilies==0}checked{/if} />{#No#}
			</td>
		</tr>
		<tr>
			<td class="first">{#S_Posticons#}</td>
			<td class="second">
			<input type="radio" name="posticons" value="1" {if $r.posticons==1}checked{/if} />{#Yes#}
			<input type="radio" name="posticons" value="0" {if $r.posticons==0}checked{/if} />{#No#}
			</td>
		</tr>
		<tr>
			<td class="second" colspan="2"><input type="submit" class="button" value="{#Save#}" /></td>
		</tr>
	</table>
	<br />
</form>
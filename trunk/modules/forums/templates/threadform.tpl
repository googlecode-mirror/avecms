
<input type="hidden" name="p_id" value="{$smarty.request.p_id|default:$smarty.request.pid}" />
<input type="hidden" name="action" value="{$smarty.request.action}" />
<input type="hidden" name="num_pages" value="{$smarty.get.num_pages}" />
<input type="hidden" name="theme_folder" value="{$theme_folder}" />
<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
    {if $bbcodes}
    <tr>
        <td nowrap="nowrap" class="forum_post_first">{#Format#}<span class="td1"> </span></td>
        <td valign="top" class="forum_post_second">
		{include file="$inc_path/format.tpl"}
		</td>
    </tr>
    {/if}
    <tr>
        <td  class="forum_post_first" style="width: 20%">{#Subject#}</td>
        <td class="forum_post_second"><input class="inputfield"  type="text" name="subject" value="{$message->title|default:$smarty.post.subject}" maxlength="200" size="50" /></td>
    </tr>
    <tr>
        <td valign="top" nowrap="nowrap" class="forum_post_first">
            {if $smilie == 1}
			{#Smileys#}
            <div style=""><!-- width:160px; height:250px; overflow:auto -->
			{$smilies2}&nbsp;{$listemos}
			</div>

            {/if}
      </td>
        <td  class="forum_post_second"><textarea id="msgform" class="inputfield" style="width: 97%" name="text" rows="15" onfocus="getActiveText(this)" onclick="getActiveText(this)"  onchange="getActiveText(this)">{$message->message|default:$preview_text_form|escape:"html|stripslashes"}</textarea>
      </td>
    </tr>
	<tr>
        <td class="forum_post_first">{#PostOptions#}</td>
      <td class="forum_post_second">
            <p>
              <input class="noborder" style="background-color:transparent; border:0px" type="checkbox" name="parseurl" value="1" checked="checked">
              {#ConvertUrls#}
              </input>
              <br />
            {if $ugroup!=2}
			<input class="noborder" style="background-color:transparent; border:0px" type="checkbox" name="notification" value="1" {if ( $notification==1 ) || ($smarty.request.notification==1) }checked="checked"{/if}>
			{#Notification#}
			</input>
			<br />
           	{/if}
		    <input class="noborder" style="background-color:transparent; border:0px" type="checkbox" name="disablebb" value="1" {if $smarty.request.disablebb==1 }checked="checked"{/if}>
		    {#DisableBBCode#}
		    </input>
		    <br />
            <input class="noborder" style="background-color:transparent; border:0px" type="checkbox" name="disablesmileys" value="1" {if $smarty.request.disablesmileys==1 }checked="checked"{/if}>
            {#DisableSmilies#}
            </input>
            <br />
            {if $ugroup!=2}
			<input class="noborder" style="background-color:transparent; border:0px" type="checkbox" name="usesig" value="1" checked="checked">
			{#ShowSig#}
			</input>
			{/if}      </p>
        </td>
    </tr>
	{if $permissions.8 == 1}
	<tr>
		<td class="forum_post_first">{#AttachF#}</td>
		<td class="forum_post_second">
		{if ($smarty.request.action=='edit') || ($pre_error==1) || ($nooon != 1)}
		{if $h_attachments_only_show}
		{foreach name=attachments from=$h_attachments_only_show item=at}
		{assign var="counter" value=$counter+1}
		{$at}
		{/foreach}
		{/if}

		{/if}

			{assign var=fileCount value=$smarty.foreach.attachments.total}
			{* ---{$counter}--{$maxattachment}-- *}
			<input type="hidden" id="hidden_count" value="{$counter}" />
			<script language="javascript" type="text/javascript">
			<!--
			function attachment_window(att_count)
			{ldelim}
				var attcount = document.getElementById('hidden_count').value;
				var left = {$maxattachment} - attcount;
				if (attcount >= {$maxattachment}){ldelim}
					alert('{#AttachDelFirst#}');
				{rdelim} else {ldelim}
			{if $smarty.request.toid != ""}
				window.open('index.php?module=forums&show=attachfile&toid={$smarty.request.toid}&left='+ left +'&p_id={if $smarty.get.pid != ""}{$smarty.get.pid}{else}-1{/if}&pop=1&theme_folder={$theme_folder}', 'moo', 'toolbar=no,scrollbars=yes,resizable=yes,width=450,height=400');
				{else}
				window.open('index.php?module=forums&show=attachfile&fid={$smarty.request.fid}&left='+ left +'&p_id={if $smarty.get.pid != ""}{$smarty.get.pid}{else}-1{/if}&pop=1&theme_folder={$theme_folder}', 'moo', 'left=0,top=0,toolbar=no,scrollbars=yes,resizable=yes,width=450,height=400');
				{/if}
				{rdelim}
			{rdelim}
			//-->
			</script>
			<input type="hidden" id="fileCount" name="fileCount" value="{$fileCount}" />
			<div id="attachments"></div>
			<p>
				<input class="button" type="button" onclick="return attachment_window('{$fileCount}');" value="{#ButtonAttach#}" />
			</p>
		</td>
	</tr>
	{/if}
</table>
<!-- THREADFORM ENDE -->
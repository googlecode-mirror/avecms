
<form name="formular" enctype="multipart/form-data" action="index.php?module=forums&show=attachfile&amp;action=upload" method="post">
  <input id="count" type="hidden" name="count" value="{$maxattachment}" />
  <table width="100%" border="0" cellpadding="2" cellspacing="1" class="box_inner">
    <tr>
      <td class="forum_header">{#AttachF#}</td>
    </tr>
    {if $smarty.request.left_f == ""}
		{assign var=acount value=$smarty.request.left}
	{elseif $smarty.request.left_f != ""}
		{assign var=acount value=$smarty.request.left_f-1}
	{else}
		{assign var=acount value=$maxattachment}
	{/if}

	{if $file.forbidden}
		{assign var=acount value=$smarty.request.left}
	{/if}

	{section name="file" loop=$acount}
    <tr class="{cycle name="att" values="row_second,row_second"}">
      <td><input name="attachment[]" type="file" size="40" />
      </td>
    </tr>
    {/section}
    <tr>
      <td><input class="button" type="submit" value="{#AttachUpload#}" />
	    <input name="left_f" type="hidden" id="left_f" value="{if $file.forbidden}{$smarty.request.left_f}{else}{$smarty.request.left_f-1}{/if}" />
	    {if $smarty.request.toid != ""}
	  <input name="toid" type="hidden" id="toid" value="{$smarty.request.toid}" />
	  {else}
	  <input name="fid" type="hidden" id="fid" value="{$smarty.request.fid}" />
	  {/if}
	  <input name="pop" type="hidden" value="1" />
	  <input name="theme_folder" type="hidden" value="{$smarty.request.theme_folder}" />
	  <input name="left" type="hidden" value="{$smarty.request.left}" />
	  </td>
    </tr>
	<tr>
	<td class="row_first">
<div class="forum_header">{#AttachTypes#}</div>
<div class="row_second" style="height:150px; overflow:auto">
<ul>

{* {foreach from=$files item=file} *}
{if $file.forbidden}
<script>
 alert('{$file.reason} {$file.orig_name}');
//window.close();
</script>
{* <li>{$file.reason} {$file.orig_name}</li> *}
{/if}
{foreach from=$files item=file}
{if !$file.forbidden}
<script language="javascript" type="text/javascript">
		var hiddenField = document.createElement("input");
		hiddenField.type = "hidden";
		hiddenField.name = "attachment[]";
		hiddenField.value = "{$file.id}";

		var fileCount = opener.document.getElementById("hidden_count");

		if (fileCount.value < {$maxattachment}) {ldelim}
			fileCount.value++;
			// opener.document.getElementById("fileCount").value = opener.document.getElementById("fileCount").value + 1;
			opener.document.getElementById("attachments").innerHTML += "<input id='files' type='hidden' name='attach_hidden[]' value='{$file.id}' />" + "&bull; {$file.orig_name}<br />";
		{rdelim}
	</script>
	{if $smarty.request.action=="upload"}

{/if}
{/if}
{/foreach}
{if $smarty.request.action=="upload" && !$file.forbidden}
<script>window.close();</script>
{/if}
{foreach from=$allowed_files item=allowed_file}
<li>{findFileType t=$allowed_file->filetype}: {$allowed_file->filesize} Kb</li>
{/foreach}
</ul>
</div>
</td>
	</tr>
  </table>
</form>


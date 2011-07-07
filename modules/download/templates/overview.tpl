<div id="mod_download">
  <h1><em>{$NavTop|default:#PageName#}</em></h1>
<p>&nbsp;</p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
	{if $smarty.request.categ!=''}
	{$TheDownloads}
	{else}
	{$NewestDownloads}
	<br />
	{$TopDownloads}
	{/if}
    </td>
    <td valign="top">&nbsp;&nbsp;</td>
    <td width="45%" valign="top">
	{$SearchPanel}
	<br />
	{$Categs}
	</td>
  </tr>
</table>
<p>&nbsp;</p>
</div>
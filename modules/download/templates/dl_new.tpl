
<div class="mod_download_titlebar">{#NewestFiles#}</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td class="mod_download_topheader">&nbsp;</td>
      <td class="mod_download_topheader">{#FileName#}</td>
      <td class="mod_download_topheader">{#Date#}</td>
      <td class="mod_download_topheader" align="center">{#Downloads#}</td>
      <td class="mod_download_topheader" align="right">{#Categ#}</td>
    </tr>
	 {foreach from=$NewFiles item=nf}
  {assign var=n value=$n+1}
  <tr>
    <td class="{cycle name='nd1' values='dl_nt_first,dl_nt_second'}">{$n}. </td>
    <td class="{cycle name='nd2' values='dl_nt_first,dl_nt_second'}"><a href="{$nf->Link}"><strong>{$nf->Name}</strong></a></td>
    <td class="{cycle name='nd3' values='dl_nt_first,dl_nt_second'}">{$nf->Datum|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE}</td>
    <td class="{cycle name='nd4' values='dl_nt_first,dl_nt_second'}" align="center">{$nf->Downloads}</td>
    <td class="{cycle name='nd5' values='dl_nt_first,dl_nt_second'}" align="right"><a href="{$nf->KatLink}">{$nf->KatName}</a></td>
  </tr>
  {/foreach}
</table>

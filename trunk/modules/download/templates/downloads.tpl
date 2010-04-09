
<div class="mod_download_titlebar">{#FilesIn#}</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td class="mod_download_topheader">&nbsp;</td>
      <td class="mod_download_topheader"><a class="mod_download_sort" href="{$LinkNameSort}">{#FileName#}</a><a href="{$LinkNameSort}">{$nImg}</a></td>
      <td width="70" nowrap="nowrap" class="mod_download_topheader"><a class="mod_download_sort" href="{$LinkDateSort}">{#Date#}</a><a href="{$LinkDateSort}">{$dImg}</a></td>
      <td width="70" nowrap="nowrap" class="mod_download_topheader"><a class="mod_download_sort" href="{$LinkChangedSort}">{#Changed#}</a><a href="{$LinkChangedSort}">{$cImg}</a></td>
      <td width="60" nowrap="nowrap" align="right" class="mod_download_topheader"><a class="mod_download_sort" href="{$LinkDownloadSort}">{#Downloads#}</a><a href="{$LinkDownloadSort}">{$doImg}</a></td>
    </tr>
	 {foreach from=$Files item=nf}
  {assign var=n value=$n+1}
  <tr>
    <td width="10" class="{cycle name='nd1' values='dl_nt_first,dl_nt_second'}">{$n}. </td>
    <td class="{cycle name='nd2' values='dl_nt_first,dl_nt_second'}"><a href="{$nf->Link}"><strong>{$nf->Name}</strong></a></td>
    <td class="{cycle name='nd3' values='dl_nt_first,dl_nt_second'}">{$nf->Datum|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE}</td>
    <td class="{cycle name='nd4' values='dl_nt_first,dl_nt_second'}">{$nf->Geaendert|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE}</td>
    <td class="{cycle name='nd5' values='dl_nt_first,dl_nt_second'}" align="right">{$nf->Downloads}</td>
  </tr>
  {/foreach}
</table>
<p>
	{$pages}
</p>
{* $nf->KatLink *}
{*
<a href="javascript:void(0);" onClick="window.open('{$nf->Link}','NAME','width=600,height=210,top=0,left=0,location=no');"><strong>{$nf->Name}</strong></a>
*}
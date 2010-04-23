<div id="mod_download">
{if $NoPerm==1}
<h1>{#NoPerm#}</h1>
<p>{#NoPermDescr#}</p>
{else}
<script>
{literal}
window.onload=function(){
{/literal}
eval("{$wm_script}");
{literal}
}
{/literal}
</script>

    <h1><em>{$NavTop|default:$config_vars.PageName}</em></h1>

  <p>
  <h2>{$pname}</h2>
  </p>
 <p>&nbsp;</p>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top">

	  <table width="100%" border="0" cellspacing="0" cellpadding="1" class="mod_download_dlbox">
        <tr>
          <td width="40">

		  <a href="javascript:void(0);" onclick="window.open('{$DownloadLink}','DlPop','width=600,height=300,top=0,left=0,location=no,scrollbars=1');"><img class="absmiddle" src="{$dl_images}download.gif" alt="" border="0" /></a></td>
          <td>
		  <h2>
		  <a href="javascript:void(0);" onclick="window.open('{$DownloadLink}','DlPop','width=600,height=300,top=0,left=0,location=no,scrollbars=1');">{#DownloadNow#}</a>		  </h2>		  </td>
        </tr>
        <tr>
          <td width="40"><img class="absmiddle" src="{$dl_images}download_time.gif" alt="" border="0" /></td>
          <td><a class="tooltip" href="#" title="{$DlTime}">{#ShowTime#}</a></td>
        </tr>
		{if $Empfehlen==1}
        <tr>
          <td width="40"><img class="absmiddle" src="{$dl_images}recommend.gif" alt="" border="0" /></td>
          <td><a href="#recommend">{#Recommend#}</a></td>
        </tr>
		{/if}
		{if $ZeigeWertung==1}
        <tr>
          <td><img class="absmiddle" src="{$dl_images}vote.gif" alt="" border="0" /></td>
          <td><a href="#voting">{#VoteDownload#}</a> </td>
        </tr>
		{/if}
		{if $Kommentare==1}
        <tr>
          <td><img class="absmiddle" src="{$dl_images}recommend.gif" alt="" border="0" /></td>
          <td>
		  <a href="#comments">{#Comments#}</a>&nbsp;/&nbsp;<a href="#comment_new">{#CommentNew#}</a>

		  </td>
        </tr>
		{/if}

      </table>


	  <p>&nbsp;</p>
	  </td>
	  <td>&nbsp;&nbsp;

	  </td>
      <td width="50%" valign="top">
	  {$SearchPanel}	  </td>
    </tr>
  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="180" class="dl_nt_second"><strong>{#Price#}</strong>:</td>
          <td class="dl_nt_second">
          	{if $row->Pay != ''}
          		{$row->Pay}{if $row->Pay_val!=0} руб.{else} ${/if}
          	{else}
          		{#NoPrice#}
          	{/if} <a href="{$PayLink}"><font size="2">{#Pay#}</font></a></td>
          <td width="180" class="dl_nt_second">&nbsp;</td>
          <td class="dl_nt_second">&nbsp;</td>
        </tr>
        <tr>
          <td class="dl_nt_first"><strong>{#Version#}</strong>:</td>
          <td class="dl_nt_first">{$row->Version|default:'-'} {if $row->Screenshot!=''}(<a href="javascript:void(0);" onclick="document.getElementById('screenshot_open').style.display='';">{#Screenshot#}</a>){/if} </td>
          <td class="dl_nt_first"><strong>{#RedVoting#}</strong>:</td>
          <td class="dl_nt_first">
		  {if $row->Wertung != ''}
		  <img class="absmiddle" src="{$dl_images}{$row->Wertung}.gif" alt="" border="0" />
		  {else}
		  -
		  {/if}		  </td>
        </tr>
        <tr>
          <td class="dl_nt_second"><strong>{#Size#}</strong>:</td>
          <td class="dl_nt_second">{$filesize}</td>
          <td class="dl_nt_second"><strong>{#UserVote#}</strong>:</td>
          <td nowrap="nowrap" class="dl_nt_second">
		  {if $ZeigeWertung==1}
		  <img class="absmiddle" src="{$dl_images}up.gif" alt="" border="0" />{$row->WertungenTop}%
		  &nbsp;&nbsp;
		  <img class="absmiddle" src="{$dl_images}down.gif" alt="" border="0" />{$row->WertungenFlop}%
		  {else}
		  -
		  {/if}
		  </td>
        </tr>
        <tr>
          <td class="dl_nt_first"><strong>{#Downloads#}</strong>:</td>
          <td class="dl_nt_first"> {$downloads} / {$Downloads_Today}{#Today#}</td>
          <td class="dl_nt_first"><strong>{#License#}</strong>:</td>
          <td class="dl_nt_first">
		  {if $row->Lizenz}
		  {$row->Lizenz}
		  {else}
		  -
		  {/if}
		  </td>
        </tr>
        <tr>
          <td class="dl_nt_second"><strong>{#Traffic#}</strong>:</td>
          <td class="dl_nt_second">{$traffic} / {$traffic_today}{#Today#}</td>
          <td class="dl_nt_second"><strong>{#Author#}</strong>:</td>
          <td class="dl_nt_second">
		  {if $row->AutorUrl!=''}
		  <a target="_blank" href="{$row->AutorUrl}">{$row->Autor}</a>
		  {else}
		  {$row->Autor|default:'-'}
		  {/if}		  </td>
        </tr>
        <tr>
          <td class="dl_nt_first"><strong>{#System#}</strong>:</td>
          <td class="dl_nt_first">
		 {if $Os}
		  {foreach from=$Os item=os name=o}
		  {$os}{$sp}{if !$smarty.foreach.o.last}, {/if}
		  {/foreach}
		  {else}
		  -
		  {/if}		  </td>
          <td class="dl_nt_first"><strong>{#Time#}</strong>:</td>
          <td class="dl_nt_first">{$row->Datum|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE|default:'-'}</td>
        </tr>
        <tr>
          <td class="dl_nt_second"><strong>{#Lang#}</strong>:</td>
          <td class="dl_nt_second">
		  {if $Sprachen}
		  {foreach from=$Sprachen item=sp name=s}
		  {$sp}{if !$smarty.foreach.s.last}, {/if}
		  {/foreach}
		  {else}
		  -
		  {/if}		  </td>
          <td class="dl_nt_second"><strong>{#Update#}</strong>: </td>
          <td class="dl_nt_second">{$row->Geaendert|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE|default:'-'}</td>
        </tr>

      </table>

  {if $row->Screenshot != ''}
  <div align="center" id="screenshot_open" style="display:none">
  <img src="{$row->Screenshot}" alt="" />
  </div>
  {/if}
  <div class="mod_download_spacer"></div>



<strong>{#Descr#}</strong> <br />
{$Beschreibung}

{if $row->RegGebuehr != ''}
<br /><br />
<strong>{#LicenseAm#}</strong> <br />
{$row->RegGebuehr|stripslashes}
{/if}

{if $row->Limitierung != ''}
<br /><br />
<strong>{#Limits#}</strong> <br />
{$row->Limitierung|stripslashes}
{/if}

  <p>&nbsp;</p>




<div class="mod_download_spacer"></div>
{$Tellform}
{$UserVote}
{$UserComments}


{/if}
</div>


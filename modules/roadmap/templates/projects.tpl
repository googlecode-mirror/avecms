<h2>{#ROADMAP_SITE_TITLE#}</h2>
<br />
{foreach from=$items item=item}
<p>
<div class="mod_roadmap_titlebar">
  <table width = "100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong>{$item->project_name}</strong></td>
      <td align="right">{if !$item->date}{else}{#ROADMAP_LAST_CHANGE#}: {$item->date|date_format:$TIME_FORMAT|pretty_date}{/if}</td>
    </tr>
</table>
</div>
</p>

<table width="100%">
<tr>
  <td>
    <table class="progress" width="100%">
      <tr>
        <td class="closed" style="width: {$item->closed}%;"> </td>
        <td class="open" style="width: {$item->open}%;"> </td>
      </tr>
    </table>
  </td>

  <td><i>{$item->closed}%</i></td>
</tr>
</table>

<br />
<span style="color: #666"><i>{#ROADMAP_INACTIVE_TASK_2#}: <a href="index.php?module=roadmap&action=show_t&pid={$item->id}&closed=1" alt="link"><strong>{$item->num_closed}</strong></a> {#ROADMAP_ACTIVE_TASK_2#}: <a href="index.php?module=roadmap&action=show_t&pid={$item->id}&closed=0" alt="link"><strong>{$item->num_open}</strong></a></i></span>

<br /><br />
<small>{#ROADMAP_SHORT_DESC#}:<br />{$item->project_desc}</small>
<br /><br />
{/foreach}


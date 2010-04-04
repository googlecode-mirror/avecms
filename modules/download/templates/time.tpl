
<table width="100%" border="0" cellspacing="0" cellpadding="1">
{foreach from=$dltime item=dlt}
  <tr>
    <td>@ <strong>{$dlt.valsys} {*{$dlt.valspeed}*}</strong> kbit/s</td>
    <td>
    <div align="right">{$dlt.time}</div></td>
  </tr>
  {/foreach}
</table>


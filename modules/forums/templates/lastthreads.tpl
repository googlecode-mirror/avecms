<table width="100%" border="0" cellpadding="3" cellspacing="1" class="box_inner">
<tr>
<td class="box_innerhead">{$lang.last_threads}</td>
</tr>
{foreach from=$last_thread_array item=lt}
<tr>
<td class="{cycle name=lastthread values='lastthreads_first,lastthreads_second'}">
<img src="{$img_folder}/rel.gif" alt="" class="absmiddle" /> {$lt.time} <a title="{$lt.title|escape:'html'|stripslashes}" href="index.php?p=showtopic&amp;toid={$lt.tid}">{$lt.title|escape:'html'|stripslashes|truncate:28}</a>

</td>
</tr>
{/foreach}
</table>

<br />

 
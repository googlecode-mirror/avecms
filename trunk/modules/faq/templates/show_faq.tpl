<h2>{$faq_name}</h2>
<p>{$desc}</p>
<ul>
{if $quest}
{foreach from=$quest item=item}
<li>
<div>
<div class="mod_faq_quest" onclick="show_hide_text(this)">{$item->quest|stripslashes}</div>
<div class ="mod_faq_ans" style="display:none">{$item->answer|stripslashes}</div>
</div>
</li>
{/foreach}
</ul>
{/if}


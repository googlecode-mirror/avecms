<h3>{$faq_title}</h3>
<p>{$faq_description}</p>
{if $faq_arr}
<dl>
{foreach from=$faq_arr item=item}
	<dt class="mod_faq_quest" onclick="$('#answer_{$item->id}').slideToggle();">{$item->faq_quest}</dt>
	<dd class="mod_faq_ans" id="answer_{$item->id}" style="display:none;">{$item->faq_answer}</dd>
{/foreach}
</dl>
{/if}
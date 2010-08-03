<h3>{$faq_title}</h3>
<p>{$faq_description}</p>
{if $faq_arr}
<dl class="mod_faq">
{foreach from=$faq_arr item=item}
	<dt>{$item->faq_quest}</dt>
	<dd>{$item->faq_answer}</dd>
{/foreach}
</dl>
{literal}
<script>
$(document).ready(function() {
	$(".mod_faq dd").hide();
	$(".mod_faq dt").click(function() {
		$(this).toggleClass("highlight").next("dd").slideToggle();
	});
});
</script>
{/literal}
{/if}

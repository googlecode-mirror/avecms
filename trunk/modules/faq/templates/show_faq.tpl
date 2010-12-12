<h3>{$faq_title}</h3>
<p>{$faq_description}</p>
{if $questions}
<dl class="mod_faq">
{foreach from=$questions item=question}
	<dt>{$question->faq_quest}</dt>
	<dd>{$question->faq_answer}</dd>
{/foreach}
</dl>
{literal}
<script>
$(document).ready(function() {
	$(".mod_faq dd").hide();
	$(".mod_faq dt").unbind('click');
	$(".mod_faq dt").click(function() {
		$(this).toggleClass("highlight").next("dd").slideToggle();
	});
});
</script>
{/literal}
{/if}

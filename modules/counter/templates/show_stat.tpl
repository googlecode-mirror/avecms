
<!-- show_stat.tpl -->
{strip}

<div class="mod_searchbox">
	<strong>{#COUNTER_SHOW_TITLE#}</strong><br />
	<br />
	<ul>
	    <li>{#COUNTER_SHOW_ALL#}:{$all}</li>
	    <li>{#COUNTER_SHOW_TODAY#}:{$today}</li>
	    <li>{#COUNTER_SHOW_YESTERDAY#}:{$yesterday}</li>
	    <li>{#COUNTER_SHOW_MONTH#}:{$prevmonth}</li>
	    <li>{#COUNTER_SHOW_YEAR#}:{$prevyear}</li>
	</ul>
</div>

{/strip}
<!-- /show_stat.tpl -->

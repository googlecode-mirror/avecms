
<!-- show_stat-1.tpl -->
{strip}

<strong>{#COUNTER_SHOW_TITLE#}</strong><br />
<br />
<ul>
    <li>{#COUNTER_SHOW_ALL#}:{$all}</li>
    <li>{#COUNTER_SHOW_TODAY#}:{$today}</li>
    <li>{#COUNTER_SHOW_YESTERDAY#}:{$yesterday}</li>
    <li>{#COUNTER_SHOW_MONTH#}:{$prevmonth}</li>
    <li>{#COUNTER_SHOW_YEAR#}:{$prevyear}</li>
</ul>

{/strip}
<!-- /show_stat-1.tpl -->

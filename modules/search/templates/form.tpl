<form class="search" method="get" action="/index.php">
<p>
	<input type="hidden" name="module" value="search" />
	<input class="search text" value="����� �� �����..." name="query" type="text" id="query" onfocus="if (this.value == '����� �� �����...') {ldelim}this.value = '';{rdelim}" onblur="if (this.value=='') {ldelim}this.value = '����� �� �����...';{rdelim}"/>
	<input type="submit" class="search button" value="�����" />
	<input id="ts_y" type="hidden" name="ts" value="1"{if $type_search==0} checked="checked"{/if} />
	<input id="ts_n" type="hidden" name="ts" value="0"{if $type_search==1} checked="checked"{/if} />
</p>
</form>

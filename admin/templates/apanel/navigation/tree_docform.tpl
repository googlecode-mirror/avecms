<select name="parent_id" id="parent_id">
	<option value="0">{$name_empty}</option>
	{foreach from=$navis item=navi}
		<optgroup label="({$navi->id}) {$navi->navi_titel|escape}"></optgroup>
		{foreach name=e from=$navi_items item=item_1}
			{if $navi->id == $item_1->navi_id}
				<option value="{$item_1->Id}____{$item_1->level+1}">&nbsp; {$item_1->title|escape}</option>
				{foreach from=$item_1->ebene_2 item=item_2}
					<option value="{$item_2->Id}____{$item_2->level+1}">&nbsp;&nbsp;&nbsp;&nbsp;- {$item_2->title|escape}</option>
					{foreach from=$item_2->ebene_3 item=item_3}
						<option value="{$item_3->Id}" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {$item_3->title|escape}</option>
					{/foreach}
				{/foreach}
			{/if}
		{/foreach}
	{/foreach}
</select>

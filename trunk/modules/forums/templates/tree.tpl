<div style="height: auto; padding: 5px;">

	{foreach from=$treeview item=leaf name=treeview}
		{if $smarty.foreach.treeview.iteration % 2 == 0 && $smarty.foreach.treeview.iteration != 0}

			{assign var=switch value=$smarty.foreach.treeview.iteration/2}
			<br />
			{section name=treespace loop=$smarty.foreach.treeview.iteration}
				{if $smarty.section.treespace.iteration == $switch}<img src="{$forum_images}forum/forum_vspacer.gif" alt="" />{/if}
				{if $smarty.section.treespace.iteration < $switch}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{/if}
				{if ($smarty.section.treespace.iteration - $switch) == 1}<img src="{$forum_images}forum/forum_hspacer.gif" alt="" />{/if}
			{/section}&nbsp;{$leaf|stripslashes}
		{else}
			{if $smarty.foreach.treeview.iteration != 1}
				{#FORUMS_FORUN_SEP#}
				{$leaf}
			{else}
				{$leaf}
			{/if}
		{/if}
	{/foreach}

</div>
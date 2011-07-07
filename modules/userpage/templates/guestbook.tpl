{if $item->can_comment == 1}

 <!-- *********** GÄSTEBUCH *********** -->

<div class="mod_userpage_border_guestbook">

<div class="mod_userpage_header">

<strong>{#Guestbook#}</strong>  {if $cc == 1}<span class="mod_userpage_right"><a href="javascript:void(0);" onclick="popup('{$formaction}','comment','600','500','1');">{#NewGuest#}</a></span>{/if}

</div>

<div class="mod_userpage_content">

{if $num == 0}

	{#NoGuests#}

{else}

			<table width="100%">

			{foreach from=$guests item=guest}

			<tr>

			<td><h1 class="mod_userpage_h1">{$guest->gid}</h1></td>

			<td><span class="mod_userpage_top"><a {if $guest->author == 0} href="#"{else} href="index.php?module=userpage&amp;action=show&amp;uid={$guest->author}" {/if}>{$guest->uname}</a>, <small>{$guest->ctime}</small></span>

			<p><b>{$guest->title}</b></p>

				<p>{$guest->message}</p>

				{if UGROUP==1}

					<span class="mod_userpage_del"><a href="index.php?module=userpage&amp;action=del&amp;gid={$guest->id}&amp;uid={$smarty.request.uid}&amp;page={$smarty.request.page}"><small>{#del#}</small></a></span>

					{/if}</td>

				</tr>

			{/foreach}

			</table>

		<br />



	{if $page_nav}

		<div class="infobox">

	{$page_nav}

		</div>

	{/if}

{/if}

	<br />

</div>

</div>

</div>

{/if}
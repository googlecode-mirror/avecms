<form action='index.php' method='get'>
	<input type='text' name='pattern' size='30' value='{$smarty.get.pattern|escape|stripslashes}' />
	<input class='button' type='submit' value='Найти' />
	<input type='hidden' name='module' value='forums' />
	<input type='hidden' name='show' value='search' />
	<input name='search_post' type='hidden' value='1' />
	<img class='absmiddle' src='{$forum_images}forum/arrow.gif' alt='' border='' />
	<a href='index.php?module=forums&amp;show=search_mask'>{#SearchExtended#}</a>
</form>
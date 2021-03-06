<?php

function PollRewrite($print_out)
{
	$print_out = preg_replace('/index.php([?])module=poll&amp;action=result&amp;pid=(\d+)/', ABS_PATH . 'poll-\\2.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=poll&amp;action=form&amp;pop=1&amp;pid=(\d+)/', ABS_PATH . 'pollcomment-\\2.html', $print_out);
	$print_out = preg_replace('/index.php([?])module=poll&amp;action=archive/', ABS_PATH . 'poll-archive.html', $print_out);
	$print_out = str_replace(".html&amp;print=1", "-print.html", $print_out);

	return $print_out;
}

?>
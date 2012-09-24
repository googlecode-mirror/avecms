<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("MYABOS")) exit;

global $AVE_DB, $AVE_Template, $mod;

if(UGROUP==2)
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}
if (defined("UGROUP") && is_numeric(UGROUP) && UGROUP != 2)
{

	$forum_id = (isset($_GET['forum_id']) && $_GET['forum_id'] != '' && is_numeric($_GET['forum_id'])) ? addslashes($_GET['forum_id']) : 't.forum_id';

	$query = "SELECT
			t.id,
			t.title,
			t.forum_id,
			t.views,
			t.type,
			t.posticon,
			r.rating,
			t.uid,
			f.title AS f_title,
			t.notification,
			t.replies,
			t.status,
			u.uname
		FROM
			" . PREFIX . "_modul_forum_topic AS t,
			" . PREFIX . "_modul_forum_forum AS f,
			" . PREFIX . "_modul_forum_userprofile AS u,
			" . PREFIX . "_modul_forum_rating AS r
		WHERE
			f.id = $forum_id AND
			t.forum_id = f.id AND
			r.topic_id = t.id AND
			u.uid = t.uid";

	$result = $AVE_DB->Query($query);
	$matches = array();

	while ($topic = $result->FetchAssocArray())
	{
		$notification = @explode(';', $topic['notification']);

		if (in_array(UID, $notification))
		{
			// forum zum thema
			$r_forum = $AVE_DB->Query("SELECT id, status FROM " . PREFIX . "_modul_forum_forum WHERE id = '".$topic['forum_id']."'");
			$rx = $r_forum->FetchRow();
			if ($topic['status'] == FORUM_STATUS_MOVED)
			{
				$topic['statusicon'] = $this->getIcon("thread_moved.gif", "moved");
			} else {
				if (UGROUP == 2 || ($topic['status'] == FORUM_STATUS_CLOSED) )
				{
					// nicht eingeloggt oder forum geschlossen
					$topic['statusicon'] = $this->getIcon("thread_lock.gif", "lock");
				} else {
					$this->setTopicIcon($topic, $rx);
				}
			}

			$topic['autorlink'] = "index.php?module=forums&amp;show=userprofile&amp;user_id=" . $topic['uid'];
			$topic['link'] = "index.php?module=forums&amp;show=showtopic&toid=".$topic['id']."&amp;fid=" . $topic['forum_id'];
			$topic['forumslink'] = "index.php?module=forums&amp;show=showforum&amp;fid=" . $topic['forum_id'];
			$topic['autor'] = $topic['uname'];
			$rating = explode(",", $topic['rating']);
			$topic['rating'] = (int) (array_sum($rating) / count($rating));


			$matches[] = $topic;
		}
	}

	$AVE_Template->assign("navigation", "<a class='forum_links_navi' href='index.php?module=forums'>"
		. $mod['config_vars']['PageNameForums'] . "</a>"
		. $mod['config_vars']['ForumSep']
		. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=search_mask'>"
		. $mod['config_vars']['ForumsSearch']
		. "</a>"
		. $mod['config_vars']['ForumSep']
		. $mod['config_vars']['ShowAbos']
		 );

	$AVE_Template->assign("matches", $matches);

	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'result.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $mod['config_vars']['ShowLast24']);
}
?>
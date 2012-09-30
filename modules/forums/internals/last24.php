<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("LAST24")) exit;

global $AVE_DB, $AVE_Template, $mod;

	$fid = (isset($_GET['fid']) && $_GET['fid'] != '' && is_numeric($_GET['fid'])) ? addslashes($_GET['fid']) : '';
	$forum_stat = ($fid != "") ? " AND t.forum_id = $fid" : "";
	$sort = (isset($_POST['sort']) && $_POST['sort'] != "") ? addslashes($_POST['sort']) : "DESC";

	$divisor = 60*60;
//	$where_time_stat = "((UNIX_TIMESTAMP(NOW()) / $divisor) - (UNIX_TIMESTAMP(p.datum) / $divisor)) <= 24";

	$q_last_active = "SELECT DISTINCT
			t.id,
			t.forum_id,
			t.title,
			t.status,
			t.type,
			t.datum,
			t.views,
			t.posticon,
			t.uid,
			t.replies,
			u.uid,
			u.uname,
			r.rating,
			f.group_id,
			f.title AS f_title
		FROM " . PREFIX . "_modul_forum_topic AS t
		JOIN " . PREFIX . "_modul_forum_userprofile AS u ON u.uid = t.uid
		JOIN " . PREFIX . "_modul_forum_rating AS r ON r.topic_id = t.id
		JOIN " . PREFIX . "_modul_forum_post AS p ON p.topic_id = t.id
		JOIN " . PREFIX . "_modul_forum_forum AS f ON  f.id = t.forum_id
		WHERE NOW() - INTERVAL 24 HOUR <= p.datum
		$forum_stat
		ORDER BY t.last_post $sort
	";
//	$q_last_active = "SELECT DISTINCT
//			t.id,
//			t.forum_id,
//			t.title,
//			t.status,
//			t.type,
//			t.datum,
//			t.views,
//			t.posticon,
//			t.uid,
//			t.replies,
//			u.uname,
//			r.rating,
//			f.group_id,
//			f.title AS f_title
//		FROM
//			" . PREFIX . "_modul_forum_topic AS t,
//			" . PREFIX . "_modul_forum_userprofile AS u,
//			" . PREFIX . "_modul_forum_rating AS r,
//			" . PREFIX . "_modul_forum_post AS p,
//			" . PREFIX . "_modul_forum_forum AS f
//		WHERE
//			$where_time_stat AND
//			u.uid = t.uid AND
//			r.topic_id = t.id AND
//			p.topic_id = t.id AND
//			f.id = t.forum_id
//			$forum_stat
//		ORDER BY
//			t.last_post
//			$sort
//	";

	$r_last_active = $AVE_DB->Query($q_last_active);
	$matches = array();

	// MISC ID FЬR DEN AKTUELLEN BENUTZER
	include_once(BASE_DIR . "/modules/forums/internals/misc_ids.php");
	$group_ids_misc = $group_ids;

	while ($topic = $r_last_active->FetchAssocArray())
	{

		// GRUPPEN ARRAY
		$group_ids = explode(",", $topic['group_id']);

		// DIESE ID BENЦTIGEN WIR UM DIE RECHTE ZU HOLEN
		$forum_id = $topic['forum_id'];

		if (array_intersect($group_ids_misc, $group_ids))
			{
                foreach($group_ids_misc as $gids_misc)
				{
					if(in_array($gids_misc, $group_ids))
					{
						$permissions = $this->getForumPermissions($forum_id, $gids_misc);

						if ($permissions[FORUM_PERMISSION_CAN_SEE] == 1)
						{
							// =================================================
							// BUGFIX 21.04.2006
							// HIER WERDEN NUR THEMEN ANGEZEIGT, DIE AUS EINEM FORUM STAMMEN, FЬR DAS DER BENUTZER
							// AUCH DIE RECHTE BESITZT
							// =================================================
							$topic['autorlink'] = "index.php?module=forums&amp;show=userprofile&amp;user_id=" . $topic['uid'];
							$topic['autor'] = $topic['uname'];
							$topic['link'] = "index.php?module=forums&amp;show=showtopic&toid=".$topic['id']."&amp;fid=$forum_id";
							$topic['forumslink'] = "index.php?module=forums&amp;show=showforum&amp;fid=$forum_id";

							$rating = @explode(",", $topic['rating']);
							$topic['rating'] = (int) (array_sum($rating) / count($rating));

							// =================================================
							// Anzahl der Postings ermitteln
							// Als limit fuer die maximale anzahl der postings auf
							// einer seite wird 15 als standardwert genommen
							// =================================================
							$limit = 15;

							$r_post = $AVE_DB->Query("SELECT COUNT(id) as count FROM " . PREFIX . "_modul_forum_post WHERE topic_id = ' " . $topic['id'] . "'");
							$post = $r_post->FetchArray();

							$count = (($post['count'] / $limit) > ((int) ($post['count'] / $limit))) ? ((int) ($post['count'] / $limit)) + 1 : ((int) ($post['count'] / $limit));

							$topic['navigation_count'] = ($count == 1) ? 0 : $count;

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

							array_push($matches, $topic);
							break;
						}
					}
				}
			}
	}

	$AVE_Template->assign("matches", $matches);
	$AVE_Template->assign("navigation", "<a class='forum_links_navi' href='index.php?module=forums'>"
		. $mod['config_vars']['PageNameForums'] . "</a>"
		. $mod['config_vars']['ForumSep']
		. "<a class='forum_links_navi' href='index.php?module=forums&amp;show=search_mask'>"
		. $mod['config_vars']['ForumsSearch']
		. "</a>"
		. $mod['config_vars']['ForumSep']
		. $mod['config_vars']['ShowLast24']
		 );

	$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'last24.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $mod['config_vars']['ShowLast24']);
?>
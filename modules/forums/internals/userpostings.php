<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("USERPOSTINGS")) exit;

if (isset($_GET['user_id']) && is_numeric($_GET['user_id']) && $_GET['user_id'] >= 1)
{

	$limit = (isset($_REQUEST['pp']) && $_REQUEST['pp'] != '' && is_numeric($_REQUEST['pp']) && $_REQUEST['pp'] >= 1) ? $_REQUEST['pp'] : 15;

	// der beitragverfasser
	$q_user = "SELECT
			u.Avatar,
			us.Benutzergruppe,
			u.AvatarStandard,
			u.BenutzerName,
			u.Email,
			u.Webseite,
			u.Registriert,
			u.Signatur,
			u.Unsichtbar,
			u.BenutzerId,
			us.Vorname,
			us.Benutzergruppe,
			us.Nachname,
			ug.Name
		FROM
			" . PREFIX . "_modul_forum_userprofile AS u,
			" . PREFIX . "_users AS us,
			" . PREFIX . "_user_groups AS ug
		WHERE
			u.BenutzerId = " . intval($_GET['user_id']) . " AND
			us.Id = u.BenutzerId AND
			ug.Benutzergruppe = us.Benutzergruppe
	";
	$r_user = $GLOBALS['AVE_DB']->Query($q_user);
	$poster = $r_user->FetchRow();

	$poster->Poster = $this->fetchusername(addslashes($_GET['user_id']));

	$query = "SELECT COUNT(id) AS count FROM " . PREFIX . "_modul_forum_post WHERE uid = '" . $poster->BenutzerId . "'";
	$result = $GLOBALS['AVE_DB']->Query($query);
	$postings = $result->FetchRow();

	$poster->user_posts = $postings->count;

	$query = "SELECT title, count FROM " . PREFIX . "_modul_forum_rank WHERE count < '" . $poster->user_posts . "' ORDER BY count DESC LIMIT 1";
	$result = $GLOBALS['AVE_DB']->Query($query);
	$rank = $result->FetchRow();

	$poster->avatar = $this->getAvatar($poster->Benutzergruppe,$poster->Avatar,$poster->AvatarStandard);
	$poster->regdate = $poster->Registriert;
	$poster->user_sig = $this->kcodes($poster->Signatur);
	$poster->rank = @$rank->title;

	if(SMILIES==1) $poster->user_sig = $this->replaceWithSmileys($poster->Signatur);

	$GLOBALS['AVE_Template']->assign("poster", $poster);

	$query = "SELECT
			p.id,
			p.title,
			p.topic_id,
			p.datum,
			p.use_bbcode,
			p.use_smilies,
			p.use_sig,
			p.message,
			p.attachment,
			f.id AS forum_id,
			f.title AS forum_title,
			t.title AS topic_title,
			t.views AS topic_views,
			t.replies AS topic_replies,
			u.BenutzerName
		FROM
			" . PREFIX . "_modul_forum_post AS p,
			" . PREFIX . "_modul_forum_topic AS t,
			" . PREFIX . "_modul_forum_forum AS f,
			" . PREFIX . "_modul_forum_userprofile AS u
		WHERE
			p.uid = " . intval($_GET['user_id']) . " AND
			u.BenutzerId = p.uid AND
			t.id = p.topic_id AND
			t.forum_id = f.id AND
			f.active = 1
		ORDER BY datum DESC
	";

	$result = $GLOBALS['AVE_DB']->Query($query);
	$num = $result->NumRows();

	$seiten = ceil($num / $limit);
	$a = prepage() * $limit - $limit;

	$query2 = "SELECT
			p.id,
			p.title,
			p.topic_id,
			p.datum,
			p.use_bbcode,
			p.use_smilies,
			p.use_sig,
			p.message,
			p.attachment,
			f.id AS forum_id,
			f.title AS forum_title,
			t.title AS topic_title,
			t.views AS topic_views,
			t.replies AS topic_replies,
			t.forum_id AS AUA,
			u.BenutzerName,
			c.group_id AS GRUPPEN_IDS
		FROM
			" . PREFIX . "_modul_forum_post AS p,
			" . PREFIX . "_modul_forum_topic AS t,
			" . PREFIX . "_modul_forum_forum AS f,
			" . PREFIX . "_modul_forum_userprofile AS u,
			" . PREFIX . "_modul_forum_category AS c
		WHERE
			p.uid = " . intval($_GET['user_id']) . " AND
			u.BenutzerId = p.uid AND
			t.id = p.topic_id AND
			t.forum_id = f.id AND
			f.active = 1 AND
			c.id = f.category_id
		ORDER BY
			datum DESC
		LIMIT " . $a . "," . $limit . "
	";
	$result = $GLOBALS['AVE_DB']->Query($query2);
	$matches = array();

	// MISC-IDS...
	$my_group_id = array();

	if (!@is_numeric(UID) || UGROUP == 2)
	{
		$my_group_id[] = UGROUP;
	} else {
		$query_myids = "SELECT GroupIdMisc FROM " . PREFIX . "_modul_forum_userprofile WHERE BenutzerId = '" . UID . "'";
		$result_myids = $GLOBALS['AVE_DB']->Query($query_myids);
		$user = $result->FetchRow();

		if($user->GroupIdMisc != ""){
			$my_group_id_ = UGROUP . ";" . $user->GroupIdMisc;
			$my_group_id = @explode(";", $my_group_id_);

		} else {
			$my_group_id[] = UGROUP;
		}
	}

	while ($post = $result->FetchRow())
	{

		$post->datum = $this->datumtomytime($post->datum);

		// $permissions = $this->getForumPermissionsByUser($post->forum_id, UID);
		// $Reader_User[] = UGROUP;
		$post->group_ids = @explode(",", $post->GRUPPEN_IDS);

		if (array_intersect($post->group_ids,$my_group_id))
		{
			// soll bbcode verwendet werden
			if ($post->use_bbcode == 1)
			{
				$post->message = $this->kcodes($post->message);
			} else {
				$post->message = nl2br($post->message);
			}
		} else {
			$post->message = $GLOBALS['mod']['config_vars']['DeniedText'];
			$post->flink = 'no';
		}

		$post->message = $post->message;
		$post->message = (!@$this->badwordreplace($post->message)) ? $post->message : $this->badwordreplace($post->message);
		$post->message = $this->high($post->message);
		$post->message = (SMILIES==1 && $post->use_smilies==1) ? $this->replaceWithSmileys($post->message) : $post->message;
		$matches[] = $post;

	}


	if ($limit < $num)
	{
		$id = (!is_numeric($_REQUEST['id'])) ? 1 : $_REQUEST['id'];
		$GLOBALS['AVE_Template']->assign('pages', pagenav($seiten, 'page',
			" <a class=\"page_navigation\" href=\"index.php?module=forums&amp;show=userpostings&amp;user_id="
			.$_GET['user_id']."&amp;page={s}&amp;pp=$limit\">{t}</a> "));
	}
	$GLOBALS['AVE_Template']->assign("matches", $matches);
	$GLOBALS['AVE_Template']->assign("post_count", $num);

	$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'showpost.tpl');
	define("MODULE_CONTENT", $tpl_out);
	define("MODULE_SITE", $GLOBALS['mod']['config_vars']['UserPostings']);

} else {
	header("Location:index.php?module=forums");
	exit;
}

?>
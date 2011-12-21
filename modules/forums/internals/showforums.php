<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("SHOWFORUMS")) exit;
		//=======================================================
		// Aktionen?
		//=======================================================
		if(isset($_REQUEST['action']) && $_REQUEST['action'] != '')
		{
			switch($_REQUEST['action'])
			{
				//=======================================================
				// Foren als gelesen markieren
				//=======================================================
				case 'markread':
					if(isset($_REQUEST['what']) && $_REQUEST['what'] != '')
					{
						switch ($_GET['what'])
						{
							case 'forum':
							if ($_GET['id'] != "")
							{
								$this->setForumAsRead(escs($_GET['id']));
								header("Location:index.php?module=forums&show=showforum&fid=" . $_GET['id']);
							} else {
								$this->setForumAsRead();
								header("Location:index.php?module=forums");
							}
							break;
						}
					}
				break;


			}
		}

		//=======================================================
		// Navigation erzeugen
		// $GLOBALS['mod']['config_vars']['ForumSep']
		//=======================================================
		if (@$_GET['cid'] == "" )
		{
			$navigation = $this->getNavigation(0, "category", null);
			$cat_query = "SELECT id, title, position, comment, parent_id, group_id FROM " . PREFIX . "_modul_forum_category WHERE parent_id = 0 ORDER BY position";
		} else {
			$navigation = $this->getNavigation((int)$_GET['cid'], "category", null);
			$cat_query = "SELECT id, title, position, comment, parent_id, group_id FROM " . PREFIX . "_modul_forum_category WHERE id = '" . (int)$_GET['cid'] . "'";
		}
		$categories = $GLOBALS['AVE_DB']->Query($cat_query);

		//=======================================================
		// Enthдlt zur jeder kategorie ein array der dazugehoerigen foren
		//=======================================================
		$forums_array = array();
		$category_array = array();

		//=======================================================
		// Alle Kategorien durchgehen
		//=======================================================
		while ($category = $categories->FetchAssocArray())
		{
			$group_ids = array();
			$q_tcount_extra = "";
			include( BASE_DIR . "/modules/forums/internals/misc_ids.php");

			//=======================================================
			// Gruppen, die zugriff auf die kategorie haben
			//=======================================================
			$groups = @explode(",", $category['group_id']);

			if (array_intersect($group_ids, $groups))
			{
				//=======================================================
				// wenn eine spezielle kategorie angezeigt wird
				// soll der navigationspfad um diese erweitert werden
				//=======================================================
				if (isset($_GET["cid"]) && $_GET["cid"] != "") $navigation .= $GLOBALS['mod']['config_vars']['ForumSep'] . $category["title"];

				//=======================================================
				// den status der anzeige aus dem cookie holen
				//=======================================================
				$position = strpos(@$_COOKIE["categories"], "id" . $category["id"]);
				if ( is_numeric($position) )
				{
					$category["display"] = "none";
					$category["image"] = "plus.gif";
				}

				$category["link"] = "index.php?module=forums&amp;show=showforums&amp;cid=" . $category["id"];
				$category["newforumlink"] = "index.php?module=forums&amp;show=newforum&amp;cid=" . $category["id"];
				$category["moveuplink"] = "index.php?module=forums&amp;show=movecat&amp;param=up&amp;cid=" . $category["id"] . "&amp;pid=0";
				$category["movedownlink"] = "index.php?module=forums&amp;show=movecat&amp;param=down&amp;cid=" . $category["id"] . "&amp;pid=0";
				$category["movelink"] = "index.php?module=forums&amp;show=move&amp;item=c&amp;cid=" . $category["id"];
				$category["delcategorylink"] = "index.php?module=forums&amp;show=delcategory&amp;cid=" . $category["id"] . "&amp;pid=0";

				array_push($category_array, $category);

				$forum_query = "SELECT
						f.id,
						f.title,
						f.comment,
						f.status,
						f.position
					FROM
						" . PREFIX . "_modul_forum_forum AS f
					WHERE
						f.category_id = '" . $category["id"] . "' AND
						f.active = 1
					ORDER BY
						f.position
				";

				//=======================================================
				// alle foren der jeweiligen kategorie
				//=======================================================
				$foren = $GLOBALS['AVE_DB']->Query($forum_query);

				//=======================================================
				// alle foren zur kategorie holen
				//=======================================================
				$forums_array[$category["title"]] = array();

				while ($forum = $foren->FetchAssocArray())
				{
					//=======================================================
					// rechte fuer das forum
					//=======================================================
					$permissions = $this->getForumPermissionsByUser($forum['id'], UID);
					 if (@$permissions[FORUM_PERMISSION_CAN_SEE] == 1)
					 {
						//=======================================================
						// Anzahl der Themen und Beitrдge ermitteln
						//=======================================================
						$pcount = 0;

						//=======================================================
						// kann die topics anderer sehen?
						//=======================================================
						$show_only_own_topics = "";
						if ($permissions[FORUM_PERMISSION_CAN_SEE_TOPIC] == 0)
						{
							$show_only_own_topics = " AND uid = " . UID;
						}

						//=======================================================
						// wenn user nicht mod dieses forum ist und kein admin ist,
						// nicht freigeschaltete themen verbergen
						//=======================================================
						if(!is_mod($forum['id']))
						{
							$q_tcount_extra .= " AND opened = 1 ";
						}

//						$r_tcount        = $this->getNumberOfThreadsQuery($forum["id"]);

//						$forumIds = $this->getForumIds($forumId);

						$r_tcount = $GLOBALS['AVE_DB']->Query("
							SELECT id
							FROM " . PREFIX . "_modul_forum_topic
							WHERE (forum_id = '" . implode("' OR forum_id = '", $this->getForumIds($forum["id"])) . "')
							" . $q_tcount_extra . "
							" . $show_only_own_topics . "
						");

						$forum['tcount'] = $r_tcount->NumRows();
						$forum['tcount'] = $this->num_format($forum['tcount']);

//						$ids        = "";
						$Topic_IDs  = array();

						while ($tid = $r_tcount->FetchRow())
						{
							$Topic_IDs[] = $tid->id;
//							if ($ids == "") {
//								$ids .= $tid->id;
//							} else {
//								$ids .= " OR topic_id = " . $tid->id;
//							}
						}

//						$SQL_IN_TopicIds = ' IN('.implode(',', $Topic_IDs).') ';
						$last_post = "";

//						if (!empty($ids))
						if (!empty($Topic_IDs))
						{
							$pcount = $GLOBALS['AVE_DB']->Query("
								SELECT COUNT(*)
								FROM " . PREFIX . "_modul_forum_post
								WHERE topic_id IN(" . implode(',', $Topic_IDs) . ")
							")->GetCell();
							$pcount = $this->num_format($pcount);

							//=======================================================
							// letzter beitrag
							//=======================================================
							$last_post = $this->getLastForumPost($forum["id"]);
							if (!$last_post)
							{
								$last_post = $GLOBALS['AVE_DB']->Query("
									SELECT
										DISTINCT p.id,
										p.uid,
										p.topic_id,
										p.datum,
										t.title,
										u.reg_time

									FROM
										" . PREFIX . "_modul_forum_forum AS Forum
									INNER JOIN
										" . PREFIX . "_modul_forum_post AS p
											ON  Forum.last_post_id = p.id
											AND Forum.id = ".$forum['id']."
									INNER JOIN
										" . PREFIX . "_modul_forum_topic AS t
											ON  p.topic_id = t.id
									INNER JOIN
										" . PREFIX . "_modul_forum_userprofile AS u
											ON  u.BenutzerId = p.uid
									LIMIT 1
								")->FetchRow();
							}
							// Ende
							$last_post->LastPoster = $this->fetchusername($last_post->uid);

							$replies = $GLOBALS['AVE_DB']->Query("
								SELECT COUNT(*)
								FROM " . PREFIX . "_modul_forum_post
								WHERE topic_id = '" . $last_post->topic_id . "'
							")->GetCell();

							$last_post->page = $this->getPageNum($replies, 15);

							$forum['last_post'] = $last_post;
						}

						$forum['pcount'] = $pcount;
						//=======================================================
						// Anzahl der Themen und Beitrдge ermitteln
						//=======================================================
						$forum["link"] = "index.php?module=forums&amp;show=showforum&amp;fid=" . $forum["id"];

						//=======================================================
						// Forumicon
						//=======================================================

						if (!defined("UID")) {
							$forum["statusicon"] = $this->getIcon("forum_old_lock.gif", "forum");
						} else {
							$this->setForumIcon($forum);
						}

						//=======================================================
						// alle unterkategorien
						//=======================================================
						$subcategories = $GLOBALS['AVE_DB']->Query("/*1*/
							SELECT id
							FROM " . PREFIX . "_modul_forum_category
							WHERE parent_id = '" . $forum['id'] . "'
						");

						//=======================================================
						// array fuer die subforen
						//=======================================================
						$subforums_array = array();

						//=======================================================
						// alle unterkategorien durchgehen
						//=======================================================
						while ($subcategory = $subcategories->FetchRow())
						{
							//=======================================================
							// alle foren zu der unterkategorie
							// FIND_IN_SET('" . UGROUP . "', group_id) AS group_found,
							//=======================================================
							$subforums_result = $GLOBALS['AVE_DB']->Query("/*2*/
								SELECT
									group_id,
									id,
									title
								FROM " . PREFIX . "_modul_forum_forum
								WHERE category_id = '" . $subcategory->id . "'
								AND active = '1'
								ORDER BY position ASC
							");
							//=======================================================
							// alle foren in das subforum array schieben
							//=======================================================
							while ($subforum = $subforums_result->FetchAssocArray())
							{
								if (@$subforum['group_found'] != "no")
								{
									$subforum['link'] = "index.php?module=forums&amp;show=showforum&amp;fid=" . $subforum["id"];
									array_push($subforums_array, $subforum);
								}
							}
						}

						$forum["subforums"] = $subforums_array;

						array_push($forums_array[$category["title"]], $forum);
					}
				}
			}
		}


		$GLOBALS['AVE_Template']->register_function("get_status_icon", "getStatusIcon");
		$GLOBALS['AVE_Template']->assign("uid", UID);
		$GLOBALS['AVE_Template']->assign("navigation", $navigation);
		$GLOBALS['AVE_Template']->assign("f_id", 0);
		$GLOBALS['AVE_Template']->assign("categories", $category_array);
		$GLOBALS['AVE_Template']->assign("forums", $forums_array);
		$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . $this->_ShowForumsTpl);

		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE",  strip_tags($navigation));
?>
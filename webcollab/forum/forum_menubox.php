<?php
/*
  $Id$

  (c) 2004 - 2010 Andrew Simpson <andrew.simpson at paradise.net.nz>

  WebCollab
  ---------------------------------------

  This program is free software; you can redistribute it and/or modify it under the
  terms of the GNU General Public License as published by the Free Software Foundation;
  either version 2 of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful, but WITHOUT ANY
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  PARTICULAR PURPOSE. See the GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along with this
  program; if not, write to the Free Software Foundation, Inc., 675 Mass Ave,
  Cambridge, MA 02139, USA.

  Function:
  ---------

  Lists all the recent forum posts

*/

//security check
if(! defined('UID' ) ) {
  die('Direct file access not permitted' );
}

//includes
include_once(BASE.'includes/time.php' );

//initialise variables
$list   = '';
$posted = 0;
$count  = 1;
$shown  = array();

//set the usergroup permissions on queries (Admin can see all)
if(ADMIN ) {
  $tail = ' ';
}
else {
  $tail = ' AND ('.PRE.'tasks.globalaccess=\'f\' AND '.PRE.'tasks.usergroupid IN (SELECT usergroupid FROM '.PRE.'usergroups_users WHERE userid='.UID.')
           OR '.PRE.'tasks.globalaccess=\'t\'
           OR '.PRE.'tasks.usergroupid=0) ';
}

$q = db_query('SELECT '.PRE.'forum.taskid AS taskid,
                      '.PRE.'forum.edited AS last_edit,
                      '.PRE.'tasks.name AS taskname
                      FROM '.PRE.'forum
                      LEFT JOIN '.PRE.'tasks ON ('.PRE.'tasks.id='.PRE.'forum.taskid)
                      WHERE '.PRE.'forum.edited > ( now()-INTERVAL '.$delim.NEW_TIME.' DAY'.$delim.')
                      '.$tail.'
                      GROUP BY '.PRE.'forum.taskid, last_edit, taskname
                      ORDER BY last_edit DESC LIMIT 50' );

//iterate for posts
for( $i=0 ; $row = @db_fetch_array($q, $i ) ; ++$i ) {

  //show each task only once
  if(isset($shown[($row['taskid'])] ) ) {
    continue;
  }

  //date of latest post
  if(! $posted ) {
    $lastpost = $row['last_edit'];
    $posted = true;
  }

  //show it
  $list .= "<li><small><a href=\"tasks.php?x=".X."&amp;action=show&amp;taskid=".$row['taskid']."\">".box_shorten($row['taskname'], 25 )."</a></small></li>\n";

  //record taskid to ensure we only show it once
  $shown[($row['taskid'])] = 1;

  //only show 10 items
  if($count >= 10 ) {
    break;
  }
  ++$count;

}

db_free_result($q );

if($list != '') {
  $content = "<ul class=\"menu\">".
             $list.
             "</ul>\n".
             "<div style=\"margin-top: 15px\"><small>".sprintf($lang['last_post_sprt'], nicedate($lastpost) )."</small></div>\n";

  new_box($lang['recent_posts'], $content, 'boxdata-menu', 'head-menu', 'boxstyle-menu' );
}

?>

<?php
/*
  $Id$
  
  (c) 2002 - 2005 Andrew Simpson <andrew.simpson at paradise.net.nz>

  WebCollab
  ---------------------------------------
  
  Based on CoreAPM by Dennis Fleurbaaij 2001/2002
  
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

  Manage usergroups

*/

require_once("path.php" );
require_once(BASE."includes/security.php" );

//admins only
if( ! ADMIN )
  error("Unauthorised access", "This function is for admins only." );

//get the info
$q = db_query("SELECT * FROM ".PRE."usergroups ORDER BY name" );

//nothing here yet
if(db_numrows($q) == 0 ) {
  $content = "<p>".$lang['no_usergroups']."</p>\n".
             "<span class=\"textlink\"><a href=\"usergroups.php?x=$x&amp;action=add\">[".$lang['add']."]</a></span>\n";

  new_box($lang['usergroup_manage'], $content );
  return;
}

$content =
             "<table class=\"celldata\">\n".
               "<tr><th>".$lang['name']."</th><th>".$lang['description']."</th><th>".$lang['private_usergroup']."</th><th>".$lang['action']."</th></tr>\n";

//show all usergroups
for($i=0 ; $row = @db_fetch_array($q, $i ) ; $i++ ) {
  
  if($row['private'] )
    $private = $lang['yes'];
  else
    $private = $lang['no']; 
  
  $content .= "<tr><td>".$row['name']."</td><td>".$row['description']."</td><td>".$private."</td>".
              "<td><span class=\"textlink\"><a href=\"usergroups.php?x=$x&amp;action=submit_del&amp;usergroupid=".$row['id']."\" onclick=\"return confirm( '".$lang['confirm_del_javascript']."')\">[".$lang['del']."]</a></span>&nbsp;".
              "<span class=\"textlink\"><a href=\"usergroups.php?x=".$x."&amp;action=edit&amp;usergroupid=".$row['id']."\">[".$lang['edit']."]</a></span></td></tr>";

  //get users from that group
  $usersq = db_query("SELECT fullname,
                            ".PRE."users.id AS id
                            FROM ".PRE."users
                            LEFT JOIN ".PRE."usergroups_users ON (".PRE."usergroups_users.userid=".PRE."users.id)
                            WHERE usergroupid=".$row['id']."
                            AND ".PRE."users.deleted='f'
                            ORDER BY ".PRE."users.fullname" );

  for($j=0 ; $userrow = @db_fetch_array($usersq, $j ) ; $j++ ) {
    $content .= "<tr><td style=\"text-align:left\" colspan=\"4\"><small>(<a href=\"users.php?x=$x&amp;action=show&amp;userid=".$userrow['id']."\">".$userrow['fullname']."</a>)</small></td></tr>";
  }
  $content .=   "<tr><td style=\"text-align:left\" colspan=\"3\">&nbsp;</td></tr>";

}

$content .=   "</table>\n".
              "<p><span class=\"textlink\">[<a href=\"usergroups.php?x=".$x."&amp;action=add\">".$lang['add']."</a>]</span></p>\n";

new_box($lang['manage_usergroups'], $content, "boxdata2" );

?>

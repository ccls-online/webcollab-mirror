<?php
/*
  $Id$

  (c) 2002 - 2005 Andrew Simpson <andrew.simpson at paradise.net.nz>

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

  Show the tasks that are still to-do

*/

require_once("path.php" );
require_once( BASE."includes/security.php" );

//
// List tasks
//

function listTasks($projectid ) {
  global $task_uncompleted, $task_projectid;
  global $task_array, $parent_array, $shown_array, $shown_count, $task_count;
   
  $parent_array = "";
  $shown_array  = "";
  $shown_count  = 0;  //counter for $shown_array
  $parent_count = 0;  //counter for $parent_array
  $task_count   = 0;  //counter for $task_array

  //search for uncompleted tasks by projectid
  $task_key = array_keys((array)$task_projectid, $projectid );
  
  if(sizeof($task_key) < 1 )
    return;
  
  //cycle through relevant tasks
  foreach((array)$task_key as $key ) {  
       
    $task_array[$task_count]['id']     = $task_uncompleted[($key)]['id'];
    $task_array[$task_count]['parent'] = $task_uncompleted[($key)]['parent'];
    $task_array[$task_count]['task']   = $task_uncompleted[($key)]['task'];
           
    //if this is a subtask, store the parent id 
    if($task_array[$task_count]['parent'] != $projectid ) {
      $parent_array[$parent_count] = $task_array[$task_count]['parent'];
      ++$parent_count;
    }
    ++$task_count;
        
    //remove used key to shorten future searches
    unset($task_projectid[$key] );    
  }

  $content = "<ul>\n";  
  
  //iteration for main tasks
  for($i=0 ; $i < $task_count ; $i++ ){
  
    //ignore subtasks in this iteration
    if($task_array[$i]['parent'] != $projectid ){
      continue;
    }
    
    $content .= $task_array[$i]['task'];
    $shown_array[$shown_count] = $task_array[$i]['id'];
    $shown_count++;
    
    //if this task has children (subtasks), iterate recursively to find them 
    if(in_array($task_array[$i]['id'], (array)$parent_array ) ){
      $content .= find_children($task_array[$i]['id'] );
    }
    $content .= "</li>\n";
  }
  
  //look for any orphaned tasks, and show them too
  if($task_count != $shown_count ) {
    for($i=0 ; $i < $task_count ; $i++ ) {
      if( ! in_array($task_array[$i]['id'], (array)$shown_array ) ) 
        $content .= $task_array[$i]['task']."</li>\n";
    }
  }
  $content .= "</ul>\n";  
    
  unset($task_array);
  unset($shown_array);
  unset($parent_array);
   
  return $content;
}

//
// List subtasks (recursive function)
//
function find_children($parent ) {

  global $task_array, $parent_array, $shown_array, $task_count, $shown_count;

  $content = "<ul>\n";
       
  for($i=0 ; $i < $task_count ; $i++ ) {
    
    //ignore tasks not directly under this parent
    if($task_array[$i]['parent'] != $parent ){
      continue;
    }
    $content .= $task_array[$i]['task'];
    $shown_array[$shown_count] = $task_array[$i]['id'];
    $shown_count++;
    
    //if this task has children (subtasks), iterate recursively to find them
    if(in_array($task_array[$i]['id'], $parent_array ) ){
      $content .= find_children($task_array[$i]['id'] );
    }
    $content .= "</li>\n";    
  }
  $content .= "</ul>\n"; 
  return $content;
}      


//
//START OF MAIN PROGRAM
//

$flag = 0;
$content = "";
$usergroup[0] = 0;
$allowed[0] = 0; 
$tz_offset = (TZ * 3600) - date("Z");

//get list of common users in private usergroups that this user can view 
$q = db_query("SELECT ".PRE."usergroups_users.usergroupid AS usergroupid,
                      ".PRE."usergroups_users.userid AS userid 
                      FROM ".PRE."usergroups_users 
                      LEFT JOIN ".PRE."usergroups ON (".PRE."usergroups.id=".PRE."usergroups_users.usergroupid)
                      WHERE ".PRE."usergroups.private=1");

for( $i=0 ; $row = @db_fetch_num($q, $i ) ; $i++ ) {
  if(in_array($row[0], (array)$GID ) && ! in_array($row[1], (array)$allowed ) ) {
   $allowed[] = $row[1];
  }
}

//check validity of inputs
if(isset($_POST['selection']) && strlen($_POST['selection']) > 0 )
  $selection = ($_POST['selection']);
else
  $selection = "user";

if(isset($_POST['userid']) && is_numeric($_POST['userid']) ){
  $userid = intval($_POST['userid']);
}
else{
  
  if($GUEST == 0 )
    $userid = $UID;
  else
    $userid = 0;
}

if(isset($_POST['groupid']) && is_numeric($_POST['groupid']) )
  $groupid = intval($_POST['groupid']);
else
  $groupid = 0;

// check if there are projects
if(db_result(db_query("SELECT COUNT(*) FROM ".PRE."tasks WHERE parent=0" ), 0, 0 ) < 1 ) {
  $content = "<div style=\"text-align : center\"><a href=\"tasks.php?x=$x&amp;action=add\">".$lang['add']."</a></div>\n";
  new_box( $lang['no_projects'], $content );
  return;
}

//set selection & associated defaults for the text boxes
switch($selection ) {
  case "group":
    $userid = 0; $s1 = ""; $s2 = " selected=\"selected\""; $s3 = " checked=\"checked\""; $s4 = "";
    $tail = "AND usergroupid=$groupid";
    if($groupid == 0 )
      $s4 = " selected=\"selected\"";
    break;

  case "user":
  default:
    $groupid = 0; $s1 = " checked=\"checked\""; $s2 = ""; $s3 = ""; $s4 = " selected=\"selected\"";
    $tail = "AND owner=$userid";
    if($userid == 0 )
      $s2 = " selected=\"selected\"";
    break;
}

$content .= "<form method=\"post\" action=\"tasks.php\">\n".
            "<fieldset><input type=\"hidden\" name=\"x\" value=\"$x\" />\n ".
            "<input type=\"hidden\" name=\"action\" value=\"todo\" /></fieldset>\n ".
            "<table class=\"celldata\">\n".
            "<tr><td>".$lang['todo_list_for']."</td></tr>".
            "<tr><td><input type=\"radio\" value=\"user\" name=\"selection\" id=\"user\"$s1 /><label for=\"user\">".$lang['users']."</label></td><td>\n".
            "<label for=\"user\"><select name=\"userid\">\n".
            "<option value=\"0\"$s2>".$lang['nobody']."</option>\n";

//get all users for option box
$q = db_query("SELECT id, fullname, private FROM ".PRE."users WHERE deleted='f' AND guest=0 ORDER BY fullname");

//user input box fields
for( $i=0 ; $row = @db_fetch_array($q, $i ) ; $i++) {
      
  //user test for privacy
  if($row['private'] && ($row['id'] !=  $UID ) && ( ! $ADMIN ) && ( ! in_array($row['id'], (array)$allowed ) ) ){
    continue;
  }
    
  $content .= "<option value=\"".$row['id']."\"";

  //highlight current selection
  if( $row[ "id" ] == $userid )
    $content .= " selected=\"selected\"";

  $content .= ">".$row['fullname']."</option>\n";
}

$content .= "</select></label></td></tr>\n".
            "<tr><td><input type=\"radio\" value=\"group\" name=\"selection\" id=\"group\"$s3 /><label for=\"group\">".$lang['usergroups']."</label></td><td>\n".
            "<label for=\"group\"><select name=\"groupid\">\n".
            "<option value=\"0\"$s4>".$lang['no_group']."</option>\n";

//get all groups for option box
$q = db_query("SELECT id, name, private FROM ".PRE."usergroups ORDER BY name" );

//usergroup input box fields
for( $i=0 ; $row = @db_fetch_array($q, $i ) ; $i++) {
    
  //usergroup test for privacy
  if( (! $ADMIN ) && ($row['private'] ) && ( ! in_array($row['id'], (array)$GID ) ) ) {
    continue;
  }
    
  $content .= "<option value=\"".$row['id']."\"";

  //highlight current selection
  if( $row[ "id" ] == $groupid )
    $content .= " selected=\"selected\"";

  $content .= ">".$row['name']."</option>\n";
}

$content .= "</select></label><br /><br /></td></tr>\n".
            "<tr><td><input type=\"submit\" value=\"".$lang['update']."\" /></td></tr>\n".
            "</table>\n".
            "</form>\n";


// show all subtasks that are not complete
$q = db_query( "SELECT id, name, owner, deadline, parent, usergroupid, globalaccess, projectid,
                        $epoch deadline) AS task_due,
                        $epoch now() ) AS now
                        FROM ".PRE."tasks
                        WHERE parent<>0
                        AND (status='created' OR status='active')
                        $tail
                        ORDER BY name" );

for( $i=0 ; $row = @db_fetch_array($q, $i ) ; ++$i ) {

  //check for private usergroups
  if( (! $ADMIN ) && ($row['usergroupid'] != 0 ) && ($row['globalaccess'] != 't' ) ) {
    if( ! in_array( $row['usergroupid'], (array)$GID ) )
      continue;
  }
  
  //put values into array
  $task_uncompleted[$i]['id'] = $row['id'];
  $task_uncompleted[$i]['parent'] = $row['parent'];
  
  $this_task = "<li><a href=\"tasks.php?x=$x&amp;action=show&amp;taskid=".$row[ "id" ]."\">";
  
  //add highlighting if deadline is due
  $state = ceil( ($row['task_due'] + $tz_offset - $row['now'] )/86400 );
  
  if($state > 1) {
    $this_task .= $row['name']."</a>".sprintf($lang['due_in_sprt'], $state );
  }
  else if($state > 0) {
    $this_task .= $row['name']."</a>".$lang['due_tomorrow'];
  }
  else{
    $this_task .= "<span class=\"red\">".$row['name']."</span></a>";
  }
  
  $task_uncompleted[$i]['task'] = $this_task."\n";
  
  //record projectid
  $task_projectid[$i] = $row['projectid'];

}

//query to get the all the projects
$q = db_query("SELECT id, name, usergroupid, globalaccess FROM ".PRE."tasks WHERE parent=0 AND archive=0 ORDER BY name" );

// show all uncompleted tasks and projects belonging to this user or group
for( $i=0 ; $row = @db_fetch_array($q, $i ) ; $i++ ) {

   //check for private usergroups
   if( ($ADMIN != 1) && ($row['usergroupid'] != 0 ) && ($row['globalaccess'] == 'f' ) ) {

     if( ! in_array( $row['usergroupid'], (array)$GID ) )
       continue;
   }

  $new_content = listTasks($row['id'], $tail );

  //if no task, don't show project name either
  if($new_content != "" ) {
    $content .= "<p>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$row['name']."</b></p>\n".$new_content."\n";
    //set flag to show there is at least one uncompleted task
    $flag = 1;
  }
}

if( $flag != 1 )
  $content .= $lang['no_assigned']."\n";

new_box( $lang['todo_list'], $content );

?>

<?php
/*
  $Id$

  (c) 2002 - 2004 Andrew Simpson <andrew.simpson at paradise.net.nz>

  WebCollab
  ---------------------------------------
  Parts of this file originally written for Core APM by Dennis Fleurbaaij 2001/2002.
  
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

  Lists all tasks with a "0" parent (these are called projects)

*/

require_once("path.php" );
require_once( BASE."includes/security.php" );

include_once(BASE."tasks/task_common.php" );
include_once(BASE."includes/time.php" );

//
// List tasks
//

function listTasks($projectid ) {
  global $x, $epoch, $now ,$admin, $gid, $lang, $task_state, $tz_offset;
  global $task_array, $parent_array, $used_array;
   
  $content = "";
  //$used_array ="";
  $parent_array = "";
    
  $q = db_query("SELECT id,
                        name,
                        parent, 
                        status, 
                        globalaccess, 
                        usergroupid, 
                        ".$epoch." deadline )
                       FROM ".PRE."tasks WHERE projectid=$projectid 
                       AND parent<>0
                       AND status<>'done'
                       ORDER BY name" );
  
  if(db_numrows($q) < 1 )
    return;
  
  $content = "<ul>\n";  
    
  for( $i=0 ; $row = @db_fetch_num($q, $i ) ; $i++) {
  
    //check if user can view this task
    if( ($admin != 1 ) && ($row[4] != "t" ) && ($row[5] != 0 ) ) {
      if( ! in_array( $row[5], (array)$gid ) )
        continue;
    }

    //put values into array
    $task_array[$i]["id"] = $row[0];
    $task_array[$i]["name"] = $row[1];
    $task_array[$i]["parent"] = $row[2];
    
    //add suffix information
    switch( $row[3] ) {
      case "cantcomplete":
        $task_array[$i]["state"] = "<b><i>".$task_state["cantcomplete"]."</i></b>";
        break;

      case "notactive":
        $task_array[$i]["state"] = "<i>".$task_state["task_planned"]."</i>";
        break;

      default:
        //check if late
        if( ($now + $tz_offset - $row[6] ) >= 86400 ) {
          $task_array[$i]["state"] = "<span class=\"late\">".$lang["late_g"]."</span>";
        }
        break;
    }
        
    //if this is a subtask, store the parent id 
    if($row[2] != $projectid ) {
      $parent_array[] = $row[2];
    }
  }
  
  if(sizeof($parent_array) > 10 )
    $parent_array = array_unique($parent_array);
  $max = sizeof($task_array);
  
  //iteration for main tasks
  for($i=0 ; $i < $max ; $i++ ){
  
    //ignore subtasks in this iteration
    if($task_array[$i]["parent"] != $projectid ){
      continue;
    }
    $content .= "<li><a href=\"tasks.php?x=$x&amp;action=show&amp;taskid=".$task_array[$i]["id"]."\">".$task_array[$i]["name"]."</a> &nbsp;".$task_array[$i]["state"]."<br />\n";
    
    //if this task has children (subtasks), iterate recursively to find them 
    if(in_array($task_array[$i]["id"], (array)$parent_array ) ){
      $content .= find_children($task_array[$i]["id"] );
    }
    $content .= "</li>\n";
  }
  $content .= "</ul>\n";  
  return $content;   
}   

//
// List subtasks (recursive function)
//
function find_children($parent ) {

  global $task_array, $parent_array, $used_array, $x;

  $content = "<ul>\n";
  $max = sizeof($task_array);
       
  for($i=0 ; $i < $max ; $i++ ) {
    
    //ignore tasks not directly under this parent
    if($task_array[$i]["parent"] != $parent ){
      continue;
    }
    $content .= "<li><a href=\"tasks.php?x=$x&amp;action=show&amp;taskid=".$task_array[$i]["id"]."\">".$task_array[$i]["name"]."</a> &nbsp;".$task_array[$i]["state"]."<br />\n";
    
    //if this task has children (subtasks), iterate recursively to find them
    if(in_array($task_array[$i]["id"], $parent_array ) ){
      $content .= find_children($task_array[$i]["id"] );
    }
    $content .= "</li>\n";    
  }
  $content .= "</ul>\n"; 
  return $content;
}      

//
//START OF MAIN PROGRAM
//

//some inital values
$content = "";
$flag = 0;
$active_only = 0;
$tz_offset = ($TZ * 3600) - date("Z");

// query to get the projects
$q = db_query("SELECT id,
                      name,
                      deadline,
                      status,
                      ".$epoch." deadline) AS due,
                      ".$epoch." finished_time) AS finished_time,
                      ".$epoch." completion_time) AS completion_time,
                      ".$epoch." now()) AS now,
                      usergroupid,
                      globalaccess,
                      completed
                      FROM ".PRE."tasks
                      WHERE parent=0
                      ORDER BY name" );

//check if there are projects
if(db_numrows($q) < 1 ) {
  $content .= "<div style=\"text-align : center\"><a href=\"tasks.php?x=$x&amp;action=add\">".$lang["add_project"]."</a></div>\n";
  new_box($lang["no_projects"], $content );
  return;
}

if(isset($_GET["active"] ) )
  $active_only = $_GET["active"];

//text link for 'active' switch
$content .= "<table style=\"width : 98%\"><tr><td>\n".
            "<span class=\"textlink\">";
if($active_only )
  $content .= "[<a href=\"main.php?x=".$x."&amp;active=0\">".$lang["show_all_projects"]."</a>]";
else
  $content .= "[<a href=\"main.php?x=".$x."&amp;active=1\">".$lang["show_active_projects"]."</a>]";

//text link for 'printer friendly' page
if(isset($_GET["action"]) && $_GET["action"] == "project_print" )
  $content  .= "\n[<a href=\"main.php?x=".$x."&amp;active=".$active_only."\">".$lang["normal_version"]."</a>]";
else
  $content  .= "</span></td>\n<td style=\"text-align : right\"><span class=\"textlink\">[<a href=\"tasks.php?x=".$x."&amp;active=".$active_only."&amp;action=project_print\">".$lang["print_version"]."</a>]";
$content .= "</span></td></tr>\n</table>\n";

//setup main table
$content .= "<table cellpadding=\"20\">\n";

//show all projects
for( $i=0 ; $row = @db_fetch_array($q, $i ) ; $i++) {

  //check the user has rights to view this project
  if( ($admin != 1 ) && ($row["globalaccess"] != "t" ) && ( $row["usergroupid"] != 0 ) ) {
    if( ! in_array( $row["usergroupid"], (array)$gid ) )
      continue;
  }

  //set project status
  $project_status = $row["status"];
  
  //make adjustments
  switch( $project_status ) {

    case "cantcomplete":
    case "notactive":
    //for 'active_only' skip this project
      if($active_only )
        continue(2);
      break;

    case "active":
    case "nolimit":
    case "done":
    default:
      if($row["completed"] == 100 )  
        $project_status = "done";
        
      //for 'active_only' skip completed project
      if($active_only && $project_status == "done" )
        continue(2); 
      break;
  }
  
  //to indicate that there are viewable projects
  $flag = 1;

  //start list
  $content .= "<tr><td>";

  //show name and a link
  $content .= "<a href=\"tasks.php?x=$x&amp;action=show&amp;taskid=".$row["id"]."\"><b>".$row["name"]."</b></a>\n";

  // Show a nice %-of-tasks-completed bar
  $content .= show_percent($row["completed"] )."\n";

  //give some details of status
  switch($project_status ) {

    case "done":
      $content .= $task_state["completed"]." (".nicetime( $row["completion_time"] ).")\n";
      break;

    case "cantcomplete":
      $content .= "<i>".sprintf($lang["project_hold_sprt"], nicetime($row["finished_time"]) )."</i><br />\n";
      $content .= "<img src=\"images/clock.gif\" height=\"9\" width=\"9\" alt=\"clock\" /> &nbsp; ".nicedate( $row["deadline"] )."<br />\n";
      break;

    case "notactive":
      $content .= "<i>".$lang["project_planned"]."</i><br />\n";
      break;

    case "nolimit":
      $content .= sprintf($lang["percent_sprt"], $row["completed"])."<br />\n";
      $content .= "<i>".$lang["project_no_deadline"]."</i><br />\n";
      //show subtasks that are not complete
      $content .= listTasks($row["id"] );
      break;

    case "active":
    default:
      $content .= sprintf($lang["percent_sprt"], $row["completed"] )."<br />\n";
      $content .= "<img src=\"images/clock.gif\" height=\"9\" width=\"9\" alt=\"clock\" /> &nbsp; ".nicedate( $row["deadline"] )." ";
      $state = ($row["due"] + $tz_offset - $row["now"] )/86400 ;
      if($state > 1 ) {
        $content .=  "(".sprintf($lang["due_sprt"], ceil($state) ).")\n";
      }
      else if($state > 0 ) {
        $content .=  "(".$lang["tomorrow"].")\n";
      }
      else {
        switch( -ceil($state) ) {
          case "0":
            $content .=  "<span class=\"green\">(".$lang["due_today"].")</span><br />\n";
            break;

          case "1":
            $content .= "<span class=\"red\">(".$lang["overdue_1"].")</span><br />\n";
            break;

          default:
            $content .= "<span class=\"red\">(".sprintf($lang["overdue_sprt"], -ceil($state) ).")</span><br />\n";
            break;
        }
      }
      
      //set 'now' time
      $now = $row["now"];
      
      //show subtasks that are not complete
      $content .= listTasks($row["id"] );
      break;
    }
  //end list
  $content .= "</td>\n</tr>\n";
}

$content .= "</table>\n";

if($flag != 1 )
  $content .= "<div style=\"text-align : center\">".$lang["no_allowed_projects"]."</div>\n";

new_box($lang["projects"], $content );

?>
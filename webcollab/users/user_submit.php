<?php
/*
  $Id$

  (c) 2002 - 2004 Andrew Simpson <andrew.simpson at paradise.net.nz>  
  
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

  Easy user manager

*/

require_once("path.php" );
require_once(BASE."includes/security.php" );

include_once(BASE."includes/email.php" );
include_once(BASE."lang/lang_email.php" );
include_once(BASE."includes/time.php" );

$usergroup_names = "";
$ADMIN_state ="";

//update or insert ?
if(empty($_REQUEST['action']) )
  error("User submit", "No request given" );

//if user aborts, let the script carry onto the end
ignore_user_abort(TRUE);  

  switch($_REQUEST['action'] ) {

    //revive a user
    case "revive":

      //only for the admins
      if($ADMIN != 1 )
        error("Authorisation failed", "You have to be admin to do this" );

      if(empty($_GET['userid']) && ! is_numeric($_GET['userid']) )
        error("User submit", "No userid was specified." );

      $userid = intval($_GET['userid']);

      if(db_result(db_query("SELECT COUNT(*) FROM ".PRE."users WHERE deleted='t' AND id=$userid" ), 0, 0 ) ) {
        //undelete
        db_query("UPDATE ".PRE."users SET deleted='f' WHERE id=$userid" );

        //get the users' info
        $q = db_query("SELECT name, fullname, email FROM ".PRE."users where id=$userid" );
        $row = db_fetch_array($q, 0 );

        //mail the user the happy news :)
        $message = sprintf($email_revive, $row['name'], $row['fullname'] );
        email($row['email'], $title_revive, $message );
      }
      break;


    //add a user
    case "submit_insert":

      //only for the l33t
      if( $ADMIN != 1 )
        error("Authorisation failed", "You have to be admin to do this" );

      //check input has been provided
      $input_array = array("name", "fullname", "password", "email" );
      foreach( $input_array as $var ) {
        if(empty($_POST[$var])) {
          warning( $lang['value_missing'], sprintf( $lang['field_sprt'], $var ) );
        }
        ${$var} = safe_data($_POST[$var]);
      }

      //do basic check on email address
      if(! ereg("^.+@.+\..+$", $email ) )
        warning($lang['invalid_email'], sprintf( $lang['invalid_email_given_sprt'], $_POST['email']) );

      if( isset($_POST['private_user']) && ( $_POST['private_user'] == "on" ) )
        $private_user = 1;
      else
        $private_user = 0;
      
      if( isset($_POST['admin_rights']) && ( $_POST['admin_rights'] == "on" ) )
        $ADMIN_rights = "t";
      else
        $ADMIN_rights = "f";

      //prohibit 2 people from choosing the same username
      if(db_result(db_query("SELECT COUNT(*) FROM ".PRE."users WHERE name='$name'", 0 ), 0, 0 ) > 0 )
        warning($lang['duplicate_user'], sprintf($lang['duplicate_change_user_sprt'], $name ) );

      //begin transaction
      db_begin();
      //insert into the users table
      $q = db_query("INSERT INTO ".PRE."users(name, fullname, password, email, private, admin, deleted)
                     VALUES('$name', '$fullname', '".md5($password)."','$email','$private_user','$ADMIN_rights', 'f')" );

      //if the user is assigned to any groups execute the following code to add him/her
      if( isset($_POST['usergroup']) ) {

        //get the oid of the just-inserted user
        $last_oid = db_lastoid($q );

        //get the uid of the last user
        $user_id = db_result(db_query("SELECT id FROM ".PRE."users WHERE $last_insert=$last_oid" ), 0, 0 );

        //insert all selected usergroups in the usergroups_users table
        (array)$usergroup = $_POST['usergroup'];
        $max = sizeof($usergroup);
        for( $i=0 ; $i < $max ; $i++ ) {

          //check for security
          if(isset( $usergroup[$i] ) && is_numeric( $usergroup[$i] ) ) {
            db_query("INSERT INTO ".PRE."usergroups_users(userid, usergroupid) VALUES($user_id, ".$usergroup[$i].")" );
            //get the usergroup name for the email
            $q = db_query("SELECT name FROM ".PRE."usergroups WHERE id=".$usergroup[$i] );
            $usergroup_names .= db_result($q, 0, 0 )."\n";
          }
        }
      }
      //transaction complete
      db_commit();

      //email the user all data
      if($usergroup_names == "" )
        $usergroup_names = $lang['not_usergroup']."\n";
      if($ADMIN_rights == "t" )
        $ADMIN_state = $lang['admin_priv']."\n";
      $message = sprintf($email_welcome, $name, $password,$usergroup_names,
                  $fullname, $ADMIN_state );
      email($email, $title_welcome, $message );

      break;


   //edit a user
   case "submit_edit":

      //check input has been provided
      $input_array = array("name", "fullname", "email" );
      foreach($input_array as $var ) {
        if(empty($_POST[$var]) ) {
          warning($lang['value_missing'], sprintf($lang['field_sprt'], $var ) );
        }
        ${$var} = safe_data($_POST[$var]);
      }

      //check email address
      if(! ereg("^.+@.+\..+$", $email ) )
        warning($lang['invalid_email'], sprintf($lang['invalid_email_given_sprt'], safe_data($_POST['email']) ) );

      if( isset($_POST['private_user']) && ( $_POST['private_user'] == "on" ) )
        $private_user = 1;
      else
        $private_user = 0;
      
      if(isset($_POST['admin_rights']) && ( $_POST['admin_rights'] == "on" ) )
        $ADMIN_rights = "t";
      else
        $ADMIN_rights = "f";

      //an admin can edit all
      if( $ADMIN == 1 ) {

        //check for a userid
        if(empty($_POST['userid']) || ! is_numeric($_POST['userid']) )
          error("User submit", "No userid specified");

        $userid = intval($_POST['userid']);

        //prohibit 2 people from choosing the same username
        if(db_result(db_query("SELECT COUNT(*) FROM ".PRE."users WHERE name='$name' AND NOT id=$userid", 0 ), 0, 0 ) > 0 )
          warning($lang['duplicate_user'], sprintf($lang['duplicate_change_user_sprt'], $name ) );

        //begin transaction
        db_begin();
        //was a password provided or not ?
        if($password != "" ) {

          //update data and the password
          $q = db_query("UPDATE ".PRE."users
                                SET name='$name',
                                fullname='$fullname',
                                email='$email',
                                password='".md5($password)."',
                                private='$private_user',
                                admin='$ADMIN_rights'
                                WHERE id=$userid" );
        }
        else{
          //update data without password
          $q = db_query("UPDATE ".PRE."users
                                SET name='$name',
                                fullname='$fullname',
                                email='$email',
                                private='$private_user',
                                admin='$ADMIN_rights'
                                WHERE id=$userid" );
        }

        //delete the user from all groups
        db_query("DELETE FROM ".PRE."usergroups_users WHERE userid=$userid" );

        //if the user is assigned to any groups execute the following code to add him/her
        if(isset($_POST['usergroup']) ) {

          //insert all selected usergroups in the usergroups_users table
          (array)$usergroup = $_POST['usergroup'];
          for($i=0 ; $i < sizeof($usergroup) ; $i++ ) {

            //check for security
            if(is_numeric( $usergroup[$i] ) ) {
              db_query("INSERT INTO ".PRE."usergroups_users(userid, usergroupid) VALUES($userid, ".$usergroup[$i].")" );
              //get the usergroup name for the email
              $q = db_query("SELECT name FROM ".PRE."usergroups WHERE id=".$usergroup[$i] );
              $usergroup_names .= db_result( $q, 0, 0 )."\n";
            }
          }
        }
        //transaction complete
        db_commit();

        if($usergroup_names == "" )
          $usergroup_names = $lang['not_usergroup']."\n";
        if($password == "" )
          $password = $lang['no_password_change'];
        if($ADMIN_rights == "t" )
          $ADMIN_state = $lang['admin_priv']."\n";
        //email the changes to the user
        //$UID_EMAIL and $UID_NAME are in security.php
        $message = sprintf($email_user_change1, $UID_NAME, $UID_EMAIL, $name,
                $password, $usergroup_names, $fullname, $ADMIN_state );
        email($email, $title_user_change1, $message );

      }
      else{
        //this is secure option where the user cannot change important values

        //prohibit 2 people from choosing the same username
        if(db_result(db_query("SELECT COUNT(*) FROM ".PRE."users WHERE name='$name' AND NOT id=$UID", 0 ), 0, 0 ) > 0 )
          warning($lang['duplicate_user'], sprintf($lang['duplicate_change_user_sprt'], $name ) );

        //did the user change his/her password ?
        if($password != "" ) {

          db_query("UPDATE ".PRE."users
                            SET name='$name',
                            fullname='$fullname',
                            password='".md5($password)."',
                            email='$email'
                            WHERE id=$UID" );

          //email the changes to the user
          $message = sprintf($email_user_change2, $name, $password, $fullname );
          email($email, $title_user_change2, $message );
        }
        else {

          db_query("UPDATE ".PRE."users
                            SET name='$name',
                            fullname='$fullname',
                            email='$email'
                            WHERE id=$UID" );

          //email the changes to the user
          $message = sprintf( $email_user_change3, $name, $fullname );
          email( $email, $title_user_change3, $message );
        }
      }
      break;


    //default error
    default:
      error("User submit", "Invalid request given");
      break;
  }

if ( $ADMIN == 1 ) {
        header("Location: ".BASE_URL."users.php?x=$x&action=manage" );
        die;
      }
      else {
        header( "location: ".BASE_URL."users.php?x=$x&action=show&userid=$UID" );
        die;
      }
      
?>

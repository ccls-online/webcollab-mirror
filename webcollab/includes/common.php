<?php
/*
  $Id$
  
  (c) 2002 - 2004 Andrew Simpson <andrew.simpson@paradise.net.nz>

  WebCollab
  ---------------------------------------
  Parts are based on original file written for CoreAPM by Dennis Fleurbaaij 2001/2002

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

  Serves some common things

*/

require_once("path.php" );

include_once(BASE."config/config.php" );
include_once(BASE."lang/lang.php" );

//
// Input validation (single line input)
//
function safe_data($body ) {
  
  //return null for nothing input
  if(! @strlen($body) )
    return "";
      
  $body = clean_up($body);
  
  //limit line length for single line entries
  if(strlen($body ) > 100 ) 
    $body = substr($body, 0, 100 );
  
return $body;
}


//
// Input validation (multiple line input)
//
function safe_data_long($body ) {

  //return null for nothing input
  if(! @strlen($body) )
    return "";
    
  $body = clean_up($body);
  
  //normalise line breaks from Windows & Mac to UNIX style
  $body = str_replace("\r\n", "\n", $body );
  $body = str_replace("\r", "\n", $body );
  //break up long non-wrap words
  $body = preg_replace("/[^\s\n\t]{100}/", "$0\n", $body );

return $body;
}

function clean_up($body ) {

  //protect against database query attack
  if(! get_magic_quotes_gpc() )
    $body = addslashes($body );
  
  //allow only normal written characters - other weird stuff is replaced with "*"
  $body = preg_replace('[^\009\010\013\032-\126\160-\255]', "*", $body );
  
  //use HTML encoding for characters that could be used for css <script> attacks or SQL injection
  $body = str_replace(array('&', '<', '>', ';', '|','(', ')', '+', '-' ), array('&amp;', '&lt;', '&gt;', '&#059', '&#124', '&#040', '&#041', '&#043', '&#045'), $body );
  
  return $body;
}

//
// Builds up an error screen
//
function error($box_title, $content ) {

  global $uid_name, $uid_email, $MANAGER_NAME, $EMAIL_ERROR, $EMAIL_FROM, $EMAIL_REPLY_TO, $DEBUG, $NO_ERROR, $WEBCOLLAB_VERSION, $db_error_message;

  include_once(BASE."includes/screen.php" );

  create_top("ERROR", 1 );

  if($NO_ERROR != "Y" )
    new_box( $box_title, "<div align=\"center\">".$content."</div>", "boxdata", "singlebox" );
    else
    new_box($lang["report"], $lang["warning"], "boxdata2", "singlebox" );


  //get the post vars
  ob_start();
  print_r($_REQUEST );
  $post = ob_get_contents();
  ob_end_clean();


  //email to the error-catcher
  $message = "Hello,\n This is the $MANAGER_NAME site and I have an error :/  \n".
            "\n\n".
            "User that created the error: $uid_name ( $uid_email )\n".
            "The erroneous component: $box_title\n".
            "The error message: $content\n".
            "Database message: $db_error_message\n".
            "Page that was called: ".$_SERVER["SCRIPT_NAME"]."\n".
            "Called URL: ".$_SERVER["REQUEST_URI"]."\n".
            "Browser: ".$_SERVER["HTTP_USER_AGENT"]."\n".
            "Time: ".date("F j, Y, H:i")."\n".
            "IP: ".$_SERVER["REMOTE_ADDR"]."\n".
            "WebCollab version: $WEBCOLLAB_VERSION\n".
            "POST vars: $post\n\n";

  mail($EMAIL_ERROR,
        "ERROR on $MANAGER_NAME" , $message,
        "From: ".$EMAIL_FROM."\nReply-To: ".$EMAIL_REPLY_TO."\nX-Mailer: PHP/" . phpversion() );

  if($DEBUG == "Y" )
    new_box("Error Debug", nl2br($message) );

  create_bottom();

  //do not return as that would be futile
  die;
}


//
// Builds up a warning screen
//
function warning($box_title, $message ) {

  global $lang;

  include_once(BASE."includes/screen.php" );

  create_top($lang["error"], 1 );

  $content = "<div align=\"center\">$message</div>\n";

  new_box($box_title, $content, "boxdata", "singlebox" );

  create_bottom();

  //do not return as that would be futile
  die;
}

?>
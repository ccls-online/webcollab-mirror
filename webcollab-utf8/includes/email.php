<?php
/*
  $Id$
  
  (c) 2003 - 2005 Andrew Simpson <andrew.simpson at paradise.net.nz> 

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

  Sends emails and preformatted emails

  ** Parts of this code inspired by phpmailer (Chris Ryan) and from contributed notes in PHP Manual under fsockopen.

  Refer to RFC 821 (RFC 2821), RFC 822 for basic SMTP.
  Refer to RFC 1652 for 8BITMIME
  Refer to RFC 1869 for extended hello (EHLO)
  Refer to RFC 2045 for mime types
  Refer to RFC 2047 for handling 8bit headers
  Refer to RFC 2076 for a useful summary of common headers

*/

require_once("path.php" );
require_once(BASE."includes/security.php" );

include_once(BASE."includes/admin_config.php" );

if( SMTP_AUTH == "Y" )
  include_once(BASE."includes/smtp_auth.php" );

//
// Email sending function
//

function email($to, $subject, $message ) {

  global $bit8, $connection;

  $email_encode = "";
  $message_charset = "";
  $body = "";

  if(USE_EMAIL == "N" ) {
    //email is turned off in config file
    return;
  }
  if(strlen($to) == 0  ) {
    //no email address specified - end function
    return;
  }

  //open an SMTP connection at the mail host
  $host = SMTP_HOST;
  $connection = @fsockopen($host, 25, $errno, $errstr, 10 );
  if (!$connection )
    debug("Unable to open TCP/IP connection to ".$host."<br /><br />Reported socket error: ".$errno." ".$errstr );

  //sometimes the SMTP server takes a little longer to respond
  // Windows does not have support for this timeout function before PHP ver 4.3.0
  if(function_exists('socket_set_timeout') )
    @socket_set_timeout($connection, 10, 0 );
  $res = response();
  if($res[1] != "220" )
    debug("Incorrect handshaking response from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );

  //do extended hello (EHLO)
  fputs($connection, "EHLO ".$_SERVER['SERVER_NAME']."\r\n" );
  //if EHLO not working, try the older HELO...
  $res = response();
  if($res[1] != "250" ) {
    fputs($connection, "HELO ".$_SERVER['SERVER_NAME']."\r\n" );
    $res = response();
    if($res[1] != "250" )
      debug("Incorrect HELO response from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );
  }
  //see if server is offering 8bit mime capability
  $bit8 = false;
  $cap = $res[0];
  if( ! strpos($cap, "8BITMIME" ) === false )
    $bit8 = true;

   //do SMTP_AUTH if required
   if(SMTP_AUTH == "Y" )
     smtp_auth($connection, $cap );

  //arrange message - and set email encoding
  //(we *must* do this before 'MAIL FROM:'  to get the email encoding correct)
  $message_lines =& message($message, $email_encode, $message_charset, $body );

  //envelope from
  fputs($connection, "MAIL FROM: <".EMAIL_FROM.">".$body."\r\n" );
  $res = response();
  if($res[1] != "250" )
    debug("Incorrect response to MAIL FROM command from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );

  //envelope to
  $address_list = explode(",", $to );
  foreach($address_list as $email_to ) {
    fputs($connection, "RCPT TO: <".trim(clean($email_to ) ).">\r\n" );
    $res = response();
    switch($res[1] ) {
      case "250":
      case "251":
        //acceptable responses
        break;

      case "450":
      case "550":
        //mail box error
        warning("Mailbox error for $email_to <br /><br />Response from SMTP server was ".$res[0] );
        break;

      default:
        //anything else is no good
        debug("Incorrect response to RCPT TO: ".$email_to." from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );
        break;
    }
  }

  //start data transmission
  fputs($connection, "DATA\r\n" );
  $res = response();
  if($res[1] != "354" )
    debug("Incorrect response to DATA command from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );

  //assemble the headers and message for transmission
  $message_lines = array_merge(headers($to, $subject, $email_encode, $message_charset ), $message_lines );
  //send message to server (with correct end-of-line \r\n)
  while(list(,$line_out) = @each($message_lines ) ) {
    fputs($connection, "$line_out\r\n" );
  }

  //ok all the message data has been sent - finish with a period on it's own line
  fputs($connection, ".\r\n" );
  $res = response();
  if($res[1] != "250" )
    debug("Error sending data<br /><br />Response from SMTP server  at ".$host." was ".$res[0] );

  //say bye bye
  fputs($connection, "QUIT\r\n" );
  $res = response();
  if($res[1] != "221" )
    debug("Incorrect response to QUIT request from SMTP server at ".$host." <br /><br />Response from SMTP server was ".$res[0] );

  fclose($connection );

  return;
}

/*
Function List
=============
clean		Reinstate encoded html back to original text.
message		Prepare message body, and if necessary, 'base64' encode for SMTP transmission.
subject		Check subject line and 'base64' encode if required for SMTP transmission.
headers		Assemble message headers to RFC 822.
response	Get response to client command from the connected SMTP server.
debug		Debug!
*/

//
//function to reinstate html in text and remove any dangerous html scripting tags
//

function & clean($encoded ) {

  //reinstate encoded html back to original text
  $text = @html_entity_decode($encoded, ENT_NOQUOTES, CHARACTER_SET );
  
  //reinstate decimal encoded html that html_entity_decode() can't handle...
  $text = preg_replace('/&#\d{2,5};/e', "utf8_entity_decode('$0')", $text );
  
  //characters previously escaped/encoded to avoid SQL injection/CSS attacks are reinstated. 
  $trans = array('\;'=>';', '\('=>'(', '\)'=>')', '\+'=>'+', '\-'=>'-', '\='=>'=' );  
  $text = strtr($text, $trans );
  
  //remove any dangerous tags that exist after decoding
  $text = preg_replace("/(<\/?\s*)(APPLET|SCRIPT|EMBED|FORM|\?|%)(\w*|\s*)([^>]*>)/i", "\\1****\\3\\4", $text );

  return $text;
}

//
//function to prepare and encode message body for transmission
//

function & message($message, & $email_encode, & $message_charset, & $body ) {

  global $bit8;

  //clean up message
  $message =& clean($message );
  //check if message contains multi-byte characters and set encoding to match mailer capabilities
  switch(preg_match('/([\177-\377])/', $message ) ) {
    case true:
      //we have special characters
      switch($bit8 ) {
        case true:
          //mail server has said it can do 8bit
          $email_encode = "8bit";
          $body = " BODY=8BITMIME";
          $message_charset = CHARACTER_SET;
          break;
        case false:
          //old mail server - can only do 7bit mail
          $email_encode = "base64";
          $body = "";
          $message_charset = CHARACTER_SET;
          break;
      }
      break;

    case false:
      //no special characters ==> use 7bit
      $email_encode = "7bit";
      $message_charset = "us-ascii";
      $body = "";
      break;
  }

  //normalise end-of-lines (\r\n, \r ) in message body to \n - and change back to \r\n later
  $message = str_replace("\r\n", "\n", $message );
  $message = str_replace("\r", "\n", $message );
  //make sure message ends in a new line \n
  $message = $message."\n";

  //encode message body
  switch(strtolower($email_encode ) ){
    case "7bit":
    case "8bit":
      //break up any lines longer than 998 bytes (RFC 821)
      $message = wordwrap($message, 998, "\n", 1 );
      break;

    case "base64":
    default:
      $message = base64_encode($message );
      //break into chunks of 76 characters per line (RFC 2045)
      $message = chunk_split($message, 76, "\n" );
      break;

  }

  //lines starting with "." get an additional "." added. (RFC 2821 - 4.5.2)
  $message = preg_replace("/^[\.]/m", "..", $message );
  //explode message body into separate lines
  $message_lines = explode("\n", $message );

return $message_lines;
}


//
//function to prepare and encode the 'subject' line for transmission
//

function &subject($subject ) {

  global $email_charset;

  //get rid of any line breaks (\r\n, \n, \r) in subject line
  $subject = str_replace(array("\r\n", "\r", "\n"), " ", $subject );
  //reinstate any HTML in subject back to text
  $subject =& clean($subject );

  //encode subject with 'printed-quotable' if multi-byte characters are present
  switch(preg_match('/([\177-\377])/', $subject ) ) {
    case false:
      //no encoding required
      $subject_lines[] = ("Subject: ".substr($subject, 0, 985 ) );
      break;

    case true:
      //base64 encoding
      $line = base64_encode($subject );
      //format follows RFC 2047
      $s = "Subject: ";
      //lines are no longer than 76 characters including '?' and '=' 
      //  76 - 10[=?UTF-8?B?] - 2[?=] = 64 encoded characters per line 
      //  any additional new lines start with <space>   
      while(strlen($line) > 64 ) {
        $subject_lines[] = $s."=?".CHARACTER_SET."?B?".substr($line, 0, 64 )."?="; 
        $line = substr($line, 64 );
        $s = " ";
      }
      //output any remaining line (will be less than 64 characters long)
      $subject_lines[] = $s."=?".CHARACTER_SET."?B?".$line."?=";
      break;
  }

return $subject_lines;
}

//
//function to assemble mail headers
//

function headers($to, $subject, $email_encode, $message_charset ) {

  //set the date - in RFC 822 format
  $headers = array("Date: ".date("r") );

  //now the prepare the 'to' header
  $line = "To: ".$to;
  //lines longer than 998 characters are broken up to separate lines (RFC 821)
  // (end long line with \r\n, and begin new line with \t)
  while(strlen($line ) > 998 ) {
    $pos = strrpos(substr($line, 0, 998 ), " " );
    $headers[] = substr($line, 0, $pos );
    $line = "\t".substr($line, $pos + 1 );
  }
  $headers[] = $line;
  //assemble remaining message headers (RFC 821 / RFC 2045)
  $headers[] = "From: WebCollab <".EMAIL_FROM.">";
  $headers[] = "Reply-To: ".EMAIL_REPLY_TO;

  $headers = array_merge($headers, subject($subject ) );

  $headers[] = "Message-Id: <".uniqid("")."@".$_SERVER['SERVER_NAME'].">";
  $headers[] = "X-Mailer: WebCollab (PHP/".phpversion().")";
  $headers[] = "X-Priority: 3";
  $headers[] = "X-Sender: ".EMAIL_REPLY_TO;
  $headers[] = "Return-Path: <".EMAIL_REPLY_TO.">";
  $headers[] = "Mime-Version: 1.0";
  $headers[] = "Content-Type: text/plain; charset=".$message_charset;
  $headers[] = "Content-Transfer-Encoding: ".$email_encode;
  $headers[] = "";

return $headers;
}

//
//function to get a response from a SMTP command to the server
//

function response() {

  global $connection;

  $res[0] = "";
  while($str = fgets($connection, 256 ) ) {
    $res[0] .= $str;
    //<space> after three digit code indicates this is last line of data ("-" for more lines)
    if(substr($str, 3, 1) == " " )
      break;
  }
  $res[1] = substr($res[0], 0, 3 );

  //$res[0] is full response string from SMTP server
  //$res[1] is the 3 digit numeric code from the SMTP server

  return $res;
}


 function debug($error ){

   global $connection;

   if(DEBUG == "Y" ) {
     $time_out = "";
     $meta = @socket_get_status($connection);
     if($meta['timed_out'] )
       $time_out = "<br /><br />Socket timeout has occurred";

     //we don't use error() because email may not work!
     warning("Email error debug", $error.$time_out );
   }
   else{
     warning("Internal email fault", "Not able to send your email.<br /><br />\n".
             "Please contact your administrator for more information.<br /><br />\n".
             "(Enable debugging in config.php for more detail)" );
   }
   return;
 }
?>

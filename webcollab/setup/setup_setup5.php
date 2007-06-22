<?php
/*
  $Id$

  (c) 2003 - 2007 Andrew Simpson <andrew.simpson at paradise.net.nz>

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

  Write setup to config

*/
require_once('path.php' );

require_once(BASE.'setup/security_setup.php' );

//security checks
if( ! isset($WEB_CONFIG ) || $WEB_CONFIG !== 'Y' ) {
  error_setup($lang_setup['no_config'] );
  die;
}

//essential values - must be present
$array = array('db_name', 'db_user', 'db_type', 'db_host', 'base_url', 'locale', 'timezone' );
foreach($array as $var ) {
  if(! isset($_POST[$var]) || $_POST[$var] == NULL ) {
    error_setup("Variable ".$var." is not set");
  }
  $data[$var] = (get_magic_quotes_gpc() ) ? stripslashes($_POST[$var] ) : $_POST[$var];
  $data[$var] = str_replace("'", "\'", $data[$var] );
}

//non-essential values
$array = array('manager_name', 'abbr_manager_name', 'db_password', 'file_base', 'file_maxsize', 'use_email', 'smtp_host', 'new_db', 'db_connect' );

foreach($array as $var ) {
  if(! isset($_POST[$var]) ) {
    $data[$var] = '';
  }
  else {
    $data[$var] = (get_magic_quotes_gpc() ) ? stripslashes($_POST[$var] ) : $_POST[$var];
    $data[$var] = str_replace("'", "\'", $data[$var] );
  }
}

//convert Windows backslash (\) to Unix forward slash (/)
$filebase = str_replace("\\", "/", $data["file_base"] );

//if user aborts, let the script carry onto the end
ignore_user_abort(TRUE);

//set up output string
$content = "<?php\n".
"/*\n".
"  ** WebCollab Configuration File **\n".
"     ============================\n\n".
"  This file was automatically generated by the setup program on ".date("D M j G:i:s T Y")."\n\n".
"*/\n\n".
"//-- Allowing Web-based Setup --\n\n".
"  //Allow web-based the setup program to alter this file (values are 'N', or 'Y')\n".
"  //Defaults to 'N' (not allowed) after a successful web based install\n".
"  //** Change this to 'Y' to allow web based configuration **\n".
'  $WEB_CONFIG = \'N\';'."\n\n".
"//-- Title and Location parameters --\n\n".
"  //You need to add the full webserver name and directory to WebCollab here. For example:\n".
"  //'http://www.your-url-here.com/backend/org/' (do not forget the tailing slash)\n".
"  define('BASE_URL', '".$data["base_url"]."' );\n\n".
"  //The name of the site\n".
"  define('MANAGER_NAME', '".$data["manager_name"]."' );\n\n".
"  //The abbreviated name for the site (for use in email subject lines)\n".
"  define('ABBR_MANAGER_NAME', '".$data["abbr_manager_name"]."' );\n\n".
"//-- Database parameters --\n\n".
"  define('DATABASE_NAME', '".$data["db_name"]."' );\n".
"  define('DATABASE_USER', '".$data["db_user"]."' );\n".
"  define('DATABASE_PASSWORD', '".$data["db_password"]."' );\n\n".
"  //Database type (valid options are 'mysql', 'postgresql', 'mysql_innodb' and 'mysqli')\n".
"  define('DATABASE_TYPE', '".$data["db_type"]."' );\n\n".
"  //Database host (usually 'localhost')\n".
"  define('DATABASE_HOST', '".$data["db_host"]."' );\n\n".
"    /*Note:\n".
"      For PostgreSQL DATABASE_HOST should not be changed from localhost.\n".
"      To use remote tcp/ip connections with PostgreSQL:\n".
"       - Edit pg_hba.conf (PostgreSQL config file) to allow tcp/ip connections\n".
"       - Start PostgreSQL postmaster with -i option\n".
"       - Change DATABASE_HOST as required\n".
"    */\n\n".
"//-- File upload parameters --\n\n".
"  //upload to what directory ?\n".
"  define('FILE_BASE', '".$filebase."' );\n\n".
"  //max file size in bytes\n".
"  define('FILE_MAXSIZE', '".$data["file_maxsize"]."' );\n\n".
"  //number of file upload boxes to show\n".
"  define('NUM_FILE_UPLOADS', 3 );\n\n".
"    /*Note:\n".
"      1. Make sure the file_base directory exists, and is writeable by the webserver, or you\n".
"         will not be able to upload any files.\n".
"      2. The filebase directory should be outside your webserver root directory to maintain file\n".
"         security.  This is important to prevent users navigating to the file directory with\n".
"         their web browsers, and viewing all the files.  (The default location given is NOT outside\n".
"         the webserver root, but it makes first-time setup easier).\n".
"    */\n\n".
"//-- Language --\n\n".
"    /* Available locales are\n".
"          'en'    (English)\n".
"          'bg'    (Bulgarian)\n".
"          'ca'    (Catalan)\n".
"          'cs'    (Czech)\n".
"          'da'    (Danish)\n".
"          'de'    (German)\n".
"          'eo'    (Esperanto)\n".
"          'es'    (Spanish)\n".
"          'fr'    (French)\n".
"          'gr'    (Greek)\n".
"          'hu'    (Hungarian)\n".
"          'it'    (Italian)\n".
"          'ja'    (Japanese)\n".
"          'ko'    (Korean)\n".
"          'no'    (Norwegian)\n".
"          'pt-br' (Brazilian Portuguese)\n".
"          'ru'    (Russian)\n".
"          'se'    (Swedish)\n".
"          'sk'    (Slovakian)\n".
"          'sl'    (Slovenian)\n".
"          'sr-la' (Serbian (Latin))      'sr-cy' (Serbian (cyrillic))\n".
"          'tr'    (Turkish)\n".
"          'zh-tw' (Traditional Chinese)  'zh-hk' (Simplified Chinese)\n".
"    */\n\n".
"  define('LOCALE', '".$data["locale"]."' );\n\n".
"//-- Timezone --\n\n".
"  //timezone offset from GMT/UTC (hours)\n".
"  define('TZ', '".$data["timezone"]."' );\n\n".
"//-- Email --\n\n".
"  //enable email to send messages? (Values are 'Y' or 'N')\n".
"  define('USE_EMAIL', '".$data["use_email"]."' );\n\n".
"    //location of SMTP server (IP address or FQDN)\n".
"    define('SMTP_HOST', '".$data["smtp_host"]."' );\n\n".
"    //mail transport (leave as SMTP for standard WebCollab)\n".
"    define('MAIL_TRANSPORT', '".SMTP_AUTH."' );\n".
"    //SMTP port (leave as 25 for ordinary mailservers)\n".
"    define('SMTP_PORT', ".SMTP_PORT." );\n\n".
"    //use smtp auth? ('Y' or 'N')\n".
"    define('SMTP_AUTH', '".SMTP_AUTH."' );\n".
"      //if using SMTP_AUTH give username & password\n".
"      define('MAIL_USER', '".MAIL_USER."' );\n".
"      define('MAIL_PASSWORD', '".MAIL_PASSWORD."' );\n".
"      //use TLS encryption? (requires PHP 5.1+)\n".
"      define('TLS', '".TLS."' );\n\n".
"//----------------------------------------------------------------------------------------------\n".
"// Less important items below this line\n\n".
"//-- MINOR CONFIG PARAMETERS --\n\n".
"//-- These items need to be edited directly from this file --\n\n".
"  //Style sheets (CSS) Note: Setup always uses 'default.css' stylesheet for CSS_MAIN. (Place your CSS into /css directory)\n".
"  define('CSS_MAIN', '".CSS_MAIN."' );\n".
"  define('CSS_CALENDAR', '".CSS_CALENDAR."' );\n".
"  define('CSS_PRINT', '".CSS_PRINT."' );\n\n".
"  //If an error occurs, who do you want the error to be mailed to ?\n".
"  define('EMAIL_ERROR', '".EMAIL_ERROR."' );\n\n".
"  //session timeout in hours\n".
"  define('SESSION_TIMEOUT', ".SESSION_TIMEOUT." );\n\n".
"  //number of days that new or updated tasks should be highlighted as 'New' or 'Updated'\n".
"  define('NEW_TIME', ".NEW_TIME." );\n\n".
"  //custom image to replace the webcollab banner on splash page (base directory is /images)\n".
"  define('SITE_IMG', '".SITE_IMG."' );\n\n".
"  //show full debugging messages on the screen when errors occur (values are 'N', or 'Y')\n".
"  define('DEBUG', '".DEBUG."' );\n\n".
"  //Do not show full error message on the screen - just a 'sorry, try again' message (values are 'N', or 'Y')\n".
"  define('NO_ERROR', '".NO_ERROR."' );\n\n".
"  //Use VEVENT for iCalendar instead of VTODO - works for Google Calendar and others (values are 'N', or 'Y')\n".
"  define('VEVENT', 'N');\n\n".
"  //Use external webserver authorisation to login (values are 'N', or 'Y')\n".
"  define('WEB_AUTH', '".WEB_AUTH."' );\n\n".
"  //Use to set a prefix to the database table names (Note: Table names in /db directory will need be manually changed to match)\n".
"  define('PRE', '".PRE."' );\n\n".
"  //WebCollab version string\n".
"  define('WEBCOLLAB_VERSION', '".SETUP_WEBCOLLAB_VERSION."');\n\n".
"  define('UNICODE_VERSION', '".SETUP_UNICODE_VERSION."' );\n\n".
"?>\n";

//open file for writing
if(! $handle = @fopen(BASE_CONFIG.'config.php', 'w' ) ) {
  error_setup("Cannot open ".BASE_CONFIG."config file for writing");
}

//write to file
 if (! fwrite($handle, $content ) ) {
   error_setup("Cannot write to file");
   exit;
 }

create_top_setup($lang_setup['setup5_banner1'] );

//do we have a new database?
if(isset($data['new_db'] ) && ($data['new_db'] == 'Y' ) ) {

  //generate variables to set new session key
  $ip = $_SERVER['REMOTE_ADDR'];
  $x  = md5(mt_rand().$ip );

  switch($data["db_type"]) {

    case 'mysql':
    case 'mysql_innodb':
      //make connection
      if( ! ($database_connection = @mysql_connect($data["db_host"], $data["db_user"], $data["db_password"] ) ) ) {
        abort();
      }

      //select database
      if( ! @mysql_select_db($data["db_name"], $database_connection ) ) {
        abort();
      }

      //set the new session key in the new database
      @mysql_query('INSERT INTO '.PRE.'logins( user_id, session_key, ip, lastaccess ) VALUES(\'1\', \''.$x.'\', \''.$ip.'\', now() )', $database_connection );
      break;

    case 'postgresql':
      //make connection
      if( ! ($database_connection = @pg_connect($data["db_host"].' user='.$data["db_user"].' dbname='.$data["db_user"].' password='. $data["db_password"]) ) ) {
        abort();
      }

      //set the new session key in the new database
      @pg_query($database_connection, 'INSERT INTO '.PRE.'logins( user_id, session_key, ip, lastaccess ) VALUES(\'1\', \''.$x.'\', \''.$ip.'\', now() )' );
      break;

    default:
      abort();
      break;
  }

  //next form with new session key in place
  $content =  "<form method=\"post\" action=\"setup_handler.php\">\n".
              "<input type=\"hidden\" name=\"x\" value=\"".$x."\" />\n".
              "<input type=\"hidden\" name=\"action\" value=\"setup6\" />\n".
              "<input type=\"hidden\" name=\"lang\" value=\"".$lang."\" />\n".
              "<div align=\"center\"><p>".$lang_setup['setup5_writing']."</p><br />\n".
              "<input type=\"submit\" value=\"".$lang_setup['setup5_continue']."\" /></div>\n".
              "</form>\n";

    new_box_setup($lang_setup['setup5_banner1'], $content, 'boxdata', 'singlebox' );
    create_bottom_setup();
    die;

}

//existing database has been reconfigured...
$content = "<div align='center'>\n".$lang_setup['setup5_complete']."\n";

$content .= "<p><form name='inputform' method='post' action='index.php'>\n".
            "<input type=\"hidden\" name=\"x\" value=\"".$x."\" />\n".
            "<input type='submit' value='".$lang_setup['finish']."' />\n".
            "</form></p>\n".
            "</div>\n";

new_box_setup($lang_setup['setup5_banner2'], $content, 'boxdata', 'singlebox' );
create_bottom_setup();

//
// New database - and not able to connect
//
//
function abort() {

  $content = "<div align='center'>\n".
              "<p>".$lang_setup['setup5_write']."</p>\n".
              "<p><b>".$lang_setup['setup5_no_db']."</p>\n";

  $content .= "<p><form name='inputform' method='post' action='index.php'>\n".
              "<input type='submit' value='".$lang_setup['finish']."' />\n".
              "</form></p>\n".
              "</div>\n";

  new_box_setup($lang_setup['setup5_banner3'], $content, 'boxdata', 'singlebox' );

  create_bottom_setup();
  die;
}

?>
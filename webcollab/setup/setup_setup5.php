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

  Write setup to config

*/
require_once("path.php" );

require_once(BASE."config/config.php" );
require_once(BASE."setup/security_setup.php" );
include_once(BASE."setup/screen_setup.php" );

//essential values - must be present
$array = array("db_name", "db_user", "db_type", "db_host", "base_url", "locale", "timezone" );
foreach($array as $var ) {
  if(! isset($_POST[$var]) || $_POST[$var] == NULL ) {
    error_setup("Variable ".$var." is not set");
  }
  $data[$var] = $_POST[$var];
}


//non-essential values
$array = array("manager_name", "abbr_manager_name", "db_password", "file_base", "file_maxsize", "use_email", "smtp_host", "new_db" );

foreach($array as $var ) {
  if(! isset($_POST[$var]) )
    $data[$var] = "";
  else
    $data[$var] = $_POST[$var];
}

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
"  //Database type (usual valid options are 'mysql' and 'postgresql')\n".
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
"  define('FILE_BASE', '".$data["file_base"]."' );\n\n".
"  //max file size in bytes\n".
"  define('FILE_MAXSIZE', '".$data["file_maxsize"]."' );\n\n".
"    /*Note:\n".
"      1. Make sure the file_base directory exists, and is writeable by the webserver, or you\n".
"         will not be able to upload any files.\n".
"      2. The filebase directory should be outside your webserver root directory to maintain file\n".
"         security.  This is important to prevent users navigating to the file directory with\n".
"         their web browsers, and viewing all the files.  (The default location given is NOT outside\n".
"         the webserver root, but it makes first-time setup easier).\n".
"    */\n\n".
"//----------------------------------------------------------------------------------------------\n".
"// Less important items below this line\n\n".
"//-- Language --\n\n".
"  // available locales are 'en' (English), 'es' (Spanish), 'fr' (French), 'ca' (Catalan)\n".
"  //                       'de' (German), 'it' (Italian), 'bg' (Bulgarian), 'da' (Danish)\n".
"  //                       'ko' (Korean), 'pt-br' (Brazilian Portuguese), 'hu' (Hungarian)\n".
"  //                       'ru' (Russian), 'ja' (Japanese),  'se' (Swedish)\n".
"  define('LOCALE', '".$data["locale"]."' );\n\n".
"//-- Timezone --\n\n".
"  //timezone offset from GMT/UTC (hours)\n".
"  define('TZ', '".$data["timezone"]."' );\n\n".
"//-- Email --\n\n".
"  //If an error occurs, who do you want the error to be mailed to ?\n".
"  define('EMAIL_ERROR', '' );\n\n".
"  //enable email to send messages? (Values are 'Y' or 'N')\n".
"  define('USE_EMAIL', '".$data["use_email"]."' );\n\n".
"    //location of SMTP server (IP address or FQDN)\n".
"    define('SMTP_HOST', '".$data["smtp_host"]."' );\n\n".
"    //use smtp auth? ('Y' or 'N')\n".
"    define('SMTP_AUTH', 'N' );\n".
"      //if using SMTP_AUTH give username & password\n".
"      define('MAIL_USER', '' );\n".
"      define('MAIL_PASSWORD', '' );\n\n".
"//-- Splash image --\n\n".
"  //custom image to replace the webcollab banner on login page (relative base directory is /images)\n".
"    //(place your image into /images directory)\n".
"  define('SITE_IMG', '' );\n\n".
"//-- MINOR CONFIG PARAMETERS --\n\n".
"//-- These items need to be edited directly from this file --\n\n".
"  //session timeout in hours\n".
"  define('SESSION_TIMEOUT', 1 );\n".
"  //number of days that new or updated tasks should be highlighted as 'New' or 'Updated'\n".
"  define('NEW_TIME', 14 );\n".
"  //show full debugging messages on the screen when errors occur (values are 'N', or 'Y')\n".
"  define('DEBUG', 'N' );\n".
"  //Do not show full error message on the screen - just a 'sorry, try again' message (values are 'N', or 'Y')\n".
"  define('NO_ERROR', 'N' );\n".
"  //Use external webserver authorisation to login (values are 'N', or 'Y')\n".
"  define('WEB_AUTH', 'N' );\n".
"  //Use to set a prefix to the database table names (Note: Table names in /db directory will need be manually changed to match)\n".  
"  define('PRE', '' );\n".
"  //WebCollab version string\n".
"  define('WEBCOLLAB_VERSION', '1.70');\n".
"?>\n";

//open file for writing
if(! $handle = @fopen('config/config.php', 'w' ) ) {
  error_setup("Cannot open config file for writing");
}

//write to file
 if (! fwrite($handle, $content ) ) {
   error_setup("Cannot write to file");
   exit;
 }

//show success message
create_top_setup("Setup Screen" );

$content = "<div align='center'>\n".
            "<p>Setup is complete!</p>\n".
            "<p>The configuration information has been saved to '[webcollab]/config/config.php'. ".
            "This file can edited with a text editor to make further changes to configuration.</p>\n".
            "<p>For best security on *nix operating systems, remember to remove the world writeable permissions from
'config.php'.</p>\n".
            "<p>Please press the button to finish configuration, and login to WebCollab...</p>\n";

if($data["new_db"] == "Y" )
  $content .= "<p><b>You have a new database. Your default login and password are 'admin' and 'admin123'</b></p>\n";

$content .=  "<p><form name='inputform' method='post' action='index.php'>\n".
             "<input type='submit' value='Finish' />\n".
             "</form></p>\n".
             "</div>\n";

new_box_setup("Setup - Stage 5 of 5", $content, "boxdata", "singlebox" );

create_bottom_setup();
?>
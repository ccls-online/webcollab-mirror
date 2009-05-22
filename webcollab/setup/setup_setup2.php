<?php
/*
  $Id$

  (c) 2003 - 2009 Andrew Simpson <andrew.simpson at paradise.net.nz>

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

  Database creation

*/

//set language
if(isset($_REQUEST['lang'] ) ) {
  $locale_setup = $_REQUEST['lang'];
}

//get includes
require_once('path.php' );
require_once(BASE.'path_config.php' );
require_once(BASE_CONFIG.'config.php' );
require_once(BASE.'setup/setup_config.php' );
include_once(BASE.'lang/lang_setup1.php' );
require_once(BASE.'setup/security_setup.php' );

//security checks
if( ! isset($WEB_CONFIG ) || $WEB_CONFIG !== 'Y' ) {
  error_setup($lang_setup['no_config'] );
  die;
}

create_top_setup($lang_setup['setup2_banner'], 1 );

$content =  "<p><b>".$lang_setup['setup2_banner']."</b></p>\n";

$content .= "<table style=\"width : 98%\"><tr><td>\n".
            "<span class=\"textlink\">[<a href=\"help/help_setup.php?type=setup2&amp;lang=".$locale_setup."\" onclick=\"window.open('help/help_setup.php?type=setup2&amp;lang=".$locale_setup."'); return false\"><i>".$lang_setup['help']."</i></a>]</span>\n".
            "</td></tr>\n</table>\n";

$content .= "<form method=\"post\" action=\"setup_handler.php\" ".
            "onsubmit=\"return fieldCheck('host', 'pass', 'user', 'name')\">\n".
            "<fieldset><input type=\"hidden\" name=\"x\" value=\"".X."\" />\n".
            "<input type=\"hidden\" name=\"action\" value=\"build\" />\n".
            "<input type=\"hidden\" name=\"lang\" value=\"".$locale_setup."\" />\n".
            "<input type=\"hidden\" id=\"alert_field\" name=\"alert\" value=\"".$lang['setup_js_alert_field']."\" /></fieldset>\n";

$content .= "<p>".$lang_setup['setup2_db_details1']."</p>\n".
            "<table class=\"celldata\">\n".
            "<tr><td></td><td class=\"boxdata2\">".$lang_setup['setup2_db_details2']."</td></tr>\n".
            "<tr><th>".$lang_setup['setup2_db_name']."</th>".
            "<td><input id=\"name\" type=\"text\" name=\"database_name\" size=\"30\" /></td></tr>\n".
            "<tr><th class=\"boxdata2\">".$lang_setup['db_user']."</th>".
            "<td><input id=\"user\" type=\"text\" name=\"database_user\" size=\"30\" /></td></tr>\n".
            "<tr><th>".$lang_setup['db_password']."</th>".
            "<td><input id=\"pass\" type=\"text\" name=\"database_password\" size=\"30\" /></td></tr>\n".
            "<tr><th class=\"boxdata3\">".$lang_setup['db_host']."</th>".
            "<td class=\"boxdata3\">".
            "<input id=\"host\" type=\"text\" name=\"database_host\" value=\"localhost\" size=\"15\" /></td></tr>\n";

$content .= "<tr><th>".$lang_setup['db_type']."</th> <td>\n".
            "<select name=\"database_type\">\n".
            "<option value=\"mysql\" selected=\"selected\" >mysql</option>\n".
            "<option value=\"mysql_innodb\">mysql with innodb</option>\n".
            "<option value=\"postgresql\">postgresql</option>\n";

if(extension_loaded('mysqli' ) ) {
  $content .= "<option value=\"mysqli\">mysqli (innodb)</option>\n";
}

$content .= "</select></td></tr>\n".
            "<tr><td></td><td class=\"boxdata3\"><input type=\"submit\" value=\"".$lang_setup['submit']."\" /></td></tr>\n".
            "</table>\n".
            "</form>\n";

new_box_setup( $lang_setup['setup2_banner'], $content, 'boxdata', 'tablebox' );

create_bottom_setup();
?>
<?php
/*
  $Id$

  This is the main config page.
  Items marked **!! need to be filled in - the others don't matter.

*/

//------------------------------------------------------------------------------------------
// Important parameters are between these dotted lines

//BASE DIRECTORY

  //You need to add the full webservername and dir to WebCollab here. Example"
  // "http://www.your-url-here.com/backend/org/" (don't forget the tailing slash)
  //**!!
  $BASE_URL="";

  //The name of the site
  $MANAGER_NAME="WebCollab Project Management";

  //The abbreviated name for the site (for use in email subject lines)
  $ABBR_MANAGER_NAME="WebCollab";

//DATABASE OPTIONS
  //**!!
  $DATABASE_NAME="";
  $DATABASE_USER="";
  $DATABASE_PASSWORD="";

//Database type (usual valid options are "mysql" and "postgresql")
  //**!!
  $DATABASE_TYPE="mysql";

//Database host (usually "localhost")
  //**!!
  $DATABASE_HOST="localhost";

  /*Note:
    For PostgreSQL $DATABASE_HOST should not be changed from localhost.
    To use remote tcp/ip connections with PostgreSQL:
     - Edit pg_hba.conf (PostgreSQL config file) to allow tcp/ip connections
     - Start PostgreSQL postmaster with -i option
     - Change $DATABASE_HOST as required
  */

//FILE UPLOADS

  //upload to what directory ?
  $FILE_BASE = "/var/www/html/webcollab/files/filebase";

  //max file size in bytes ( 2 mb default)
  $FILE_MAXSIZE = 2000000;

  /*Note:
    1. Make sure the file_base directory exists, and is writeable by the webserver, or you
       won't be able to upload any files.
    2. The filebase directory should be outside your webserver root directory to maintain file
       security.  This is important to prevent users navigating to the file directory with
       their web browsers, and viewing all the files.  (The default location given is NOT outside
       the webserver root, but it makes first-time setup easier).

  */
//----------------------------------------------------------------------------------------------
// Less important items below this line

//LANGUAGE FILES

  // available locales are "en" (English), "es" (Spanish), "fr" (French).
  $LOCALE = "en";

//EMAIL ADDRESS

  //If an error occurs, who do you want the error to be mailed to ?
  $EMAIL_ERROR="";


//EMAIL CONFIGURATION

  //enable email to send messages? (Values are "Y" or "N").
  //  default is "Y".
  $USE_EMAIL = "Y";

  //mail transport agent. Values are "mail" (local sockets and/or sendmail) or "SMTP" (network mail server).
  // default is "mail".
  $MAIL_METHOD = "mail";

    //These two variables are only required if "SMTP" is chosen above
      //location of SMTP server (ip address or FQDN)
      $SMTP_HOST = "localhost";

	  //use smtp auth? ('Y' or 'N')
      $SMTP_AUTH = "N";
        //if using $SMTP_AUTH give username & password
        $MAIL_USER = "";
        $MAIL_PASSWORD = "";

  /*Note:
     Use $MAIL_METHOD = "mail", which uses local sockets and is faster.  If "mail" does not work (it is not reliable
     on all operating systems), change to "SMTP", which uses an SMTP connection over tcp/ip.
  */

//MINOR CONFIG PARAMETERS

  //number of days that new or updated tasks should be highlighted as 'New' or 'Updated'
  $NEW_TIME = 14;

  //custom image to replace the webcollab banner on splash page (base directory is /images)
  $SITE_IMG = "";

  //show full debugging messages on the screen when errors occur (values are "N", or "Y")
  $DEBUG = "N";

  //Don't show full error message on the screen - just a 'sorry, try again' message (values are "N", or "Y")
  $NO_ERROR = "N";

  //Use external webserver authorisation to login (values are "N", or "Y")
  $WEB_AUTH = "N";


?>

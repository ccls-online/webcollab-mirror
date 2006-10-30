<?php
/*
  $Id$

  WebCollab
  ---------------------------------------
  Thi file created 2003 by Andrew Simpson

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

  Email text language files for 'no' (Norwegian)

  Maintainer: 

  Translation by Kenneth Aar

  NOTE: This file is written in ISO-8859-1 character set


*/

// Get current date/time for emails in a preferred format eg: 01 Apr 2004 9:18 am NZDT  
$email_date = date("d" )." ".$month_array[(date("n" ) )]." ".date('Y \a\t g:i a T' );

$title_file_post        = ABBR_MANAGER_NAME.": Ny fil er lagt inn: %s";

$email_file_post        = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som informerer om at en ny fil er lagt inn ".$email_date." af %1\$s.\n\n".
                          "Fil:        %2\$s\n".
                          "Beskrivelse: %3\$s\n\n".
                          "Prosjekt:   %4\$s\n".
                          "Oppgave:    %5\$s\n\n".
                          "G� til hjemmesiden for mer informasjon.\n\n".
                          BASE_URL."%6\$s\n";

$title_forum_post        = ABBR_MANAGER_NAME.": Ny post I forum: %s";
$email_forum_post        = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som informerer om at det er kommet et nytt innlegg i forumet".$email_date." af %1\$s:\n\n".
                           "----\n\n".
                           "%2\$s".
                           "----\n\n".
                           "G� til hjemmesiden for mer informasjon.\n\n".
                           BASE_URL."%3\$s\n";

$email_forum_reply       = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som informerer om at det er kommet et nytt innlegg i forumet".$email_date." af %1\$s.\n\n".
                           "dette innlegget er et svar p� et tidligere innlegg %2\$s.\n\n".
                           "Opprinnelig innlegg:\n %3\$s\n\n".
                            "----\n\n".
                           "Svar:\n%4\$s\n".
                            "----\n\n".
                           "G� til hjemmesiden for mer informasjon.\n\n".
                           BASE_URL."%5\$s\n";


$email_list =  "Prosjekt:  %1\$s\n".
               "Oppgave:     %2\$s\n".
               "Status:   %3\$s\n".
               "Eier:    %4\$s ( %5\$s )\n".
               "Tekst:\n%6\$s\n\n".
               "G� til hjemmesiden for mer informasjon.\n\n".BASE_URL."%7\$s\n";


$title_takeover_project  = ABBR_MANAGER_NAME.": Ditt prosjekt er overtatt";
$title_takeover_task     = ABBR_MANAGER_NAME.": Din oppgave er overtatt";

$email_takeover_task     = "Hei,\n\nDette er en automatisk varsling fra".MANAGER_NAME." som vil si i fra om at din oppgave er overtatt av en administrator ".$email_date.".\n\n";
$email_takeover_project  = "Hei,\n\nDette er en automatisk varsling fra".MANAGER_NAME." soom vil si i fra om at ditt prosjekt er overtatt av en administrator ".$email_date.".\n\n";


$title_new_owner_project = ABBR_MANAGER_NAME.": Nytt prosjekt til deg";
$title_new_owner_task     = ABBR_MANAGER_NAME.": Ny oppgave til deg";

$email_new_owner_project = "Hei,\n\nDette er en automatisk varsling fra".MANAGER_NAME." som vil si i fra om at det er opprettet et prosjekt p� ".$email_date.", og at du er eier av dette prosjektet.\n\nHer er detaljene:\n\n";
$email_new_owner_task    = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som vil si i fra om at det er opprettet en oppgave p� ".$email_date.", og at du er eier av denne oppgaven.\n\nHer er detaljene:\n\n";


$title_new_group_project = ABBR_MANAGER_NAME.": Nytt projekt: %s";
$title_new_group_task    = ABBR_MANAGER_NAME.": Ny oppgave: %s";

$email_new_group_project = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som vil si i fra om at det er opprettet et prosjekt p� ".$email_date."\n\nHer er detaljene:\n\n";
$email_new_group_task    = "Hei,\n\nDette er automatisk varsling fra ".MANAGER_NAME." som vil si i fra om at det er opprettet en oppgave p� ".$email_date."\n\nHer er detaljene:\n\n";


$title_edit_owner_project = ABBR_MANAGER_NAME.": Ditt prosjekt er oppdatert";
$title_edit_owner_task   = ABBR_MANAGER_NAME.": Din oppgave er oppdatert";

$email_edit_owner_project = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som vil si i fra om at prosjektet som du eier er blitt endret p� ".$email_date."\n\nHer er detaljene:\n\n";
$email_edit_owner_task   = "Hei,\n\nDette er the ".MANAGER_NAME." som vil si i fra om at en oppgave som du eier er blitt endret p� ".$email_date."\n\nHer er detaljene:\n\n";


$title_edit_group_project = ABBR_MANAGER_NAME.": Prosjekt er oppdatert";
$title_edit_group_task    = ABBR_MANAGER_NAME.": Opgave er oppdatert";

$email_edit_group_project = "Hei,\n\nDette er en automatisk varsling fra ".MANAGER_NAME." som vil si i fra om at prosjektet %1\$s har endret eier".$email_date.".\n\nHer er detaljene:\n\n";
$email_edit_group_task   = "Hei,\n\nDette er en automatisk varsling fra".MANAGER_NAME." som vil si i fra om at  oppgaven %1\$s eier er endret ".$email_date.".\n\nHer er detaljene:\n\n";


$title_delete_project    = ABBR_MANAGER_NAME.": Prosjekt er slettet";
$title_delete_task       = ABBR_MANAGER_NAME.": Oppgave er slettet";

$email_delete_project    = "Hei,\n\n".
                           "Dette er en automatisk varsling fra ".MANAGER_NAME." som informerer om at et prosjekt som du eide er slettet ".$email_date."\n\n".
                           "Takk for din innsats mens projektet varte.\n\n";
$email_delete_task       = "Hei,\n\n".
                           "Dette er en automatisk varsling fra ".MANAGER_NAME." som informerer deg om, at en oppgave som du eide har blitt slettet ".$email_date."\n\n".
                           "Takk for din innsats mens oppgaven varte.\n\n";
$delete_list = "Prosjekt: %s\n".
                "Oppgave:   %s\n".
                "Status: %s\n\n".
                "Tekst:\n%s\n\n";

$title_welcome      = "Velkommen til ".ABBR_MANAGER_NAME;
$email_welcome      = "Hei,\n\nDette er ".MANAGER_NAME." som �nsker deg velkommen. ".$email_date.".\n\n".
			"Siden du er ny, vil jeg forklare et par ting, slik at du  raskt kan komme i gang\n\n".
			"For det f�rste, dette er et prosjektstyringsverkt�y, hovedsiden viser deg de prosjekter som det jobbes med for �yeblikket. ".
			"Dersom du klikker p� et av navnene, vil du finne deg selv i oppgave-delen. Det er her alt arbeidet vil foreg�.\n\n".
			"Hvert emne du sender eller opgave du redigerer vil bli vist til andre brukere som 'ny' eller 'oppdatert'. Det virker ogs� omvendt".
			"det hjelper deg til raskt � finne ut hva som skjer.\n\n".
			"Du kan ogs� ta eller f� eierskap til oppgaver, og du vil finne deg selv i stand til � redigere de, samt alle poster i forumet, som tilh�rer opgaven. ".
			"N�r du jobber med med noe, husk � rediger dine oppgave tekster og status, slik at andre kan se hva du jobber med og hvordan prosjektet g�r fremover.  ".
			"\n\nSend en epost til: ".EMAIL_ADMIN." dersom du sitter fast\n\n --Lykke til!\n\n".
			"Logg inn:      %1\$s\n".
			"Passord:   %2\$s\n\n".
			"Brukergrupper: %3\$s".
			"Navn:       %4\$s\n".
			"Hjemmeside:    ".BASE_URL."\n\n".
			"%5\$s";

$title_user_change1 = ABBR_MANAGER_NAME.": Rediger din konto hos en Admin";
$email_user_change1 = "Hei,\n\nDette er ".MANAGER_NAME." som vil informerer om at din konto er blitt endret p�. ".$email_date." af %1\$s ( %2\$s ) \n\n".
			"Logg inn:      %3\$s\n".
			"Passord:   %4\$s\n\n".
			"Brukergrupper: %5\$s".
			"Navn:       %6\$s\n\n".
			"%7\$s";

$title_user_change2 = ABBR_MANAGER_NAME.": Rediger din konto";
$email_user_change2 = "Hei,\n\nDette er ".MANAGER_NAME." som bekrefter, at du har klart � endre p� din konto".$email_date."\n\n".
			"Logg inn:    %1\$s\n".
			"Passord: %2\$s\n\n".
			"Navn:     %3\$s\n";

$title_user_change3 = ABBR_MANAGER_NAME.": Rediger din konto";
$email_user_change3 = "Hei,\n\nDette er ".MANAGER_NAME." som bekrefter, at du har klart � endre p� din konto ".$email_date."\n\n".
			"Logg inn: %1\$s\n".
			"Ditt n�v�rende passord er ikke endret.\n\n".
			"Navn:  %2\$s\n";


$title_revive       = ABBR_MANAGER_NAME.": Konto gjenopprettet";
$email_revive       = "Hei,\n\nDette er ".MANAGER_NAME." som bekrefter at din konto er blittt gjennopprettet p� ".$email_date.".\n\n".
			"Innloggings navn: %1\$s\n".
			"Brukernavn:  %2\$s\n\n".
			"Vi kan ikke sende deg ditt passord fordi det er kryptert. \n\n".
			"Dersom du har glemt ditt passord, sen epost til ".EMAIL_ADMIN." for � f� et nytt passord.";



$title_delete_user  = ABBR_MANAGER_NAME.": Konto deaktivert.";
$email_delete_user  = "Hei,\n\nDette er ".MANAGER_NAME." som varsler om at din konto er deaktivert".$email_date."\n\n".
			"Takk for samarbeidet!\n\n".
			"Dersom det er noen som er glemt gi beskjed snarest til  ".EMAIL_ADMIN."\$s.";

?>
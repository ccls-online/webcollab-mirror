<?php
/*
  $Id$

  WebCollab
  ---------------------------------------
  This file created 2003 by Andrew Simpson

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

  Email text language files for 'es' (Spanish)

  Translation: Daniel Lujan

  Maintainer:

*/
$email_date = date("d" )." ".$month_array[(date("n" ) )]." ".date('Y g:i' );

$title_file_post        = ABBR_MANAGER_NAME.": New file upload: %s";
$email_file_post        = "Hello,\n\nThis is the ".MANAGER_NAME." site informing you that a new file has been uploaded on ".$email_date." by %1\$s.\n\n".
                          "File:        %2\$s\n".
                          "Description: %3\$s";


$title_forum_post        = ABBR_MANAGER_NAME.": New forum post: %s";
$email_forum_post        = "Hello,\n\nThis is the ".MANAGER_NAME." site informing you that a new forum post has been made on ".$email_date." by %1\$s:\n\n%2\$s"; 
$email_forum_reply       = "Hello,\n\nThis is the ".MANAGER_NAME." site informing you that a new forum post has been made on ".$email_date." by %1\$s.\n\n".
                           "This post is in reply to an earlier post by %2\$s.\n\n".
                           "Original post:\n %3\$s\n\n".
                           "New reply:\n%4\$s\n";


$email_list = "Proyecto: %1\$s\n".
              "Tarea:    %2\$s\n".
              "Estado:   %3\$s\n".
              "A cargo:  %4\$s ( %5\$s )\n".
              "Texto:\n%6\$s\n\n".
              "Dirigirse al sitio web para mas detalles.\n\n".BASE_URL."\n";


$title_takeover_project   = ABBR_MANAGER_NAME.": Su item ha sido reasignado";
$title_takeover_task      = ABBR_MANAGER_NAME.": Su item ha sido reasignado";
$email_takeover_project   = "Hola,\n\nEste es ".MANAGER_NAME." sitio informandole que un proyecto a su cargo a sido reasignada por el administrador el ".$email_date.".\n\n";
$email_takeover_task      = "Hola,\n\nEste es ".MANAGER_NAME." sitio informandole que un tarea a su cargo a sido reasignada por el administrador el ".$email_date.".\n\n";

$title_new_owner_project  = ABBR_MANAGER_NAME.": Nuevo proyecto para ud";
$title_new_owner_task     = ABBR_MANAGER_NAME.": Nuevo tarea para ud";
$email_new_owner_project  = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un proyecto suyo (ahora a su cargo) fue cambiado el ".$email_date.".\n\nAqui los detalles:\n\n";
$email_new_owner_task     = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un tarea suyo (ahora a su cargo) fue cambiado el ".$email_date.".\n\nAqui los detalles:\n\n";


$title_new_group_project  = ABBR_MANAGER_NAME.": Nuevo proyecto: %s";
$title_new_group_task     = ABBR_MANAGER_NAME.": Nuevo tarea: %s";
$email_new_group_project  = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un nuevo proyecto ha sido creado el ".$email_date."\n\nAqui los detalles:\n\n";
$email_new_group_task     = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un nuevo tarea ha sido creado el ".$email_date."\n\nAqui los detalles:\n\n";

$title_edit_owner_project = ABBR_MANAGER_NAME.": Su proyecto actualizada";
$title_edit_owner_task    = ABBR_MANAGER_NAME.": Su tarea actualizada";
$email_edit_owner_project ="Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un proyecto a su cargo cambio el ".$email_date.".\n\nAqui los detalles:\n\n";
$email_edit_owner_task    ="Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un tarea a su cargo cambio el ".$email_date.".\n\nAqui los detalles:\n\n";

$title_edit_group_project = ABBR_MANAGER_NAME.": Proyecto actualizada";
$title_edit_group_task    = ABBR_MANAGER_NAME.": Tarea actualizada";
$email_edit_group_project = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un proyecto a cargo de %s ha cambiado el ".$email_date.".\n\nAqui los detalles:\n\n";
$email_edit_group_task    = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un tarea a cargo de %s ha cambiado el ".$email_date.".\n\nAqui los detalles:\n\n";

$title_delete_project     = ABBR_MANAGER_NAME.": Proyecto eliminada";
$title_delete_task        = ABBR_MANAGER_NAME.": Tarea eliminada";
$email_delete_project     = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un proyecto a su cargo fue eliminado el ".$email_date."\n\n".
                            "Gracias por dirigir la proyecto en su momento.\n\n";
$email_delete_task        = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que un tarea a su cargo fue eliminado el ".$email_date."\n\n".
                            "Gracias por dirigir la tarea en su momento.\n\n";

$delete_list =  "Proyecto: %1\$s\n".
                "Tarea:    %2\$s\n".
                "Estado:   %3\$s\n\n".
                "Texto:\n%4\$s\n\n";

$title_welcome      = "Bievenido a ".ABBR_MANAGER_NAME;
$email_welcome      = "Hola,\n\nEste es el sitio ".MANAGER_NAME." dandole la bienvenida ;) el  ".$email_date.".\n\n".
			"Como ud es nuevo aqui le explicare un par de cosas para que rapidamente pueda comenzar u trabajo\n\n".
			"Primero de todo est&aacute; es una herramienta de manejo de proyectos, la pantalla principal le mostrara los proyectos actualmente disponibles.. ".
			"Si hace click en uno de los nombres se encontrara ud mismo en la paprte de tareas. Aqui es donde el trabajo comienza..\n\n".
			"Cada item que ud envia o tarea que edita sera mostrada los otros usuarios como 'nueva' o 'actualizada'. Esto tambien funciona en viceversa y ".
			"lo habilita para rapidamente enfocar donde est&aacute; la actividad.\n\n".
			"Ud puede tambien hacerse cargo o tomar propiedad de tareas y se encontrara habilitado de editar y todo los envio del foro seran recibidos. ".
			"Con el avance se su trabajo por favor edite el texto de sus tareas y el estado de tal manera que todos puedan mantener un seguimiento de su progreso. ".
			"\n\nSolo puedo desearle exitos y envie email a ".$EMAIL_ADMIN." si ud se encuentra en dificultad.\n\n --Buena suerte !\n\n".
			"Login:      %1\$s\n".
			"Password:   %2\$s\n\n".
			"Usergroups: %3\$s".
			"Nombre:     %4\$s\n".
			"Website:    ".BASE_URL."\n\n".
			"%5\$s";

$title_user_change1 = ABBR_MANAGER_NAME.": Edicion de su cuenta por un administrador";
$email_user_change1 = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que su cuenta ha sido modificada el ".$email_date." por %1\$s ( %2\$s ) \n\n".
			"Login:      %3\$s\n".
			"Password:   %4\$s\n\n".
			"Usergroups: %5\$s".
			"Nombre:     %6\$s\n\n".
			"%7\$s";

$title_user_change2 = ABBR_MANAGER_NAME.": Edicion de su cuenta";
$email_user_change2 = "Hola,\n\nEste es el ".MANAGER_NAME." sitio confirmando que ud ha modificado exitosamente su cuenta el ".$email_date."\n\n".
			"Login:    %1\$s\n".
			"Password: %2\$s\n\n".
			"Nombre:   %3\$s\n";

$title_user_change3 = ABBR_MANAGER_NAME.": Edicion de su cuenta";
$email_user_change3 = "Hola,\n\nEste es el ".MANAGER_NAME." sitio confirmandole que ha modificado exitosamente su cuenta el ".$email_date."\n\n".
			"Login:    %1\$s\n".
			"Su pasword NO ha sido modificada.\n\n".
			"Nombre:   %2\$s\n";


$title_revive       = ABBR_MANAGER_NAME.": Cuenta reactivada";
$email_revive       = "Hola,\n\nEste e el ".MANAGER_NAME." sitio informandole que su cuenta ha sido reactivada el  ".$email_date.".\n\n".
			"Loginname: %1\$s\n".
			"Username:  %2\$s\n\n".
			"No podemos enviarle su clave porque est&aacute; encriptada. \n\n".
			"Si olvido su password envie un email ".$EMAIL_ADMIN." para solicitar un nuevo password.";



$title_delete_user  = ABBR_MANAGER_NAME.": Cuenta desactivada.";
$email_delete_user  = "Hola,\n\nEste es el ".MANAGER_NAME." sitio informandole que su cuenta ha sido desactivada el ".$email_date.".\n\n".
			"Lamentamos su desactivacion y agrradecemos por su trabajo!\n\n".
			"Si desea objetar su desactivacion, o piensa que ha sido un error, envie un email a ".$EMAIL_ADMIN.".";

?>
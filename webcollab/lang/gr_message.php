<?php
/*
  $Id$

  WebCollab
  ---------------------------------------

  This program is free software; you can redistribute it and/or modify it under the
  terms of the GNU General Public License as published by the Free Software Foundation;
  either version 2 of the License; or (at your option) any later version.

  This program is distributed in the hope that it will be useful; but WITHOUT ANY
  WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  PARTICULAR PURPOSE. See the GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along with this
  program; if not; write to the Free Software Foundation; Inc.; 675 Mass Ave;
  Cambridge; MA 02139; USA.


  Function:
  ---------

  Language files for 'gr' (Greek)

  Maintainer: Nico Bel <t at designext.gr>

*/

//required language encodings
define('CHARACTER_SET', "ISO-8859-7" );

//this is the regex for input validation filter used in common.php 
$validation_regex = '/([^\x09\x0a\x0d\x20-\x7e\xa0-\xff])/s'; //ISO-8859-x 

//dates
$month_array = array (NULL, '���', '���', '���', '���', '���', '����', '����', '���', '���', '���', '���', '���' );
$week_array = array('���', '���', '���', '���', '���', '���', '���' );

//task states
 
 //priorities
    $task_state['dontdo']               = '�������';
    $task_state['low']                  = '������';
    $task_state['normal']               = '��������';
    $task_state['high']                 = '�����';
    $task_state['yesterday']            = '����!';
 //status
    $task_state['new']                  = '���';
    $task_state['planned']              = '����������� (��������)';
    $task_state['active']               = '�������������� (�� �����������)';
    $task_state['cantcomplete']         = '����������������';
    $task_state['completed']            = '������������';
    $task_state['done']                 = '��';
    $task_state['task_planned']         = ' �����������';
    $task_state['task_active']          = ' ������';
 //project states
    $task_state['planned_project']      = 'Project ����������� (��������)';
    $task_state['no_deadline_project']  = '��� ����������� ���������� ���������';
    $task_state['active_project']       = '������ project';
    
//common items
    $lang['description']                = '���������';
    $lang['name']                       = '�����';
    $lang['add']                        = '��������';
    $lang['update']                     = '��������';
    $lang['submit_changes']             = '���������� �������';
    $lang['continue']                   = '��������';
    $lang['reset']                      = '�������';
    $lang['manage']                     = '����������';
    $lang['edit']                       = '�����������';
    $lang['delete']                     = '�������';
    $lang['del']                        = '��������';
    $lang['confirm_del_javascript']     = ' ����������� ���������!';
    $lang['yes']                        = '���';
    $lang['no']                         = '���';
    $lang['action']                     = '��������';
    $lang['task']                       = '�������';
    $lang['tasks']                      = '��������';
    $lang['project']                    = 'Project';
    $lang['info']                       = '�����������';
    $lang['bytes']                      = ' bytes';
    $lang['select_instruct']            = '(��������������� �� ctrl ��� �� ��������� �����������; � ��� �� ��� ��������� ������)';
    $lang['member_groups']              = '� ������� ����� ����� ��� �� ������������ ������ (�� ��������)';
    $lang['login']                      = '�������';
    $lang['error']                      = '�����';
    $lang['no_login']                   = '�������� �������; ���������� username � �������';
    $lang['redirect_sprt']              = '�� ������������ �������� ��� ������ �������� ���� ��� %d ������������ ������������';
    $lang['login_now']                  = '�������� �������� ��� ��� �� ����������';   
    $lang['please_login']               = '�������� ����������';
    $lang['go']                         = '��������!';
    
//graphic items
    $lang['late_g']                     = '&nbsp;LATE&nbsp;';
    $lang['new_g']                      = '&nbsp;NEW&nbsp;';
    $lang['updated_g']                  = '&nbsp;UPDATED&nbsp;';

//admin config
    $lang['admin_config']               = '����������� �����������';
    $lang['email_settings']             = 'Email header settings';
    $lang['admin_email']                = 'Admin email';
    $lang['email_reply']                = 'Email \'reply to\'';
    $lang['email_from']                 = 'Email \'from\'';
    $lang['mailing_list']               = 'Mailing list';
    $lang['default_checkbox']           = 'Default checkbox settings for Project/Tasks';
    $lang['allow_globalaccess']         = 'Allow global access?';
    $lang['allow_group_edit']           = '�� ����������� �� ����� ���� ����� ������� �� �������������� �� project?';
    $lang['set_email_owner']            = '����� �� ������������ email ���� �������� �� ��� �������?';
    $lang['set_email_group']            = '����� �� ������������ email ���� ������ ������� �� ��� �������?';
    $lang['project_listing_order']      = '����� ��������� project';
    $lang['task_listing_order']         = '����� �������� ������ ��������'; 
    $lang['configuration']              = '����������';

//archive
    $lang['archived_projects']          = '������������� Projects';    

//contacts
    $lang['firstname']                  = '�����:';
    $lang['lastname']                   = '�������:';
    $lang['company']                    = '��������:';
    $lang['home_phone']                 = '�������� ������:';
    $lang['mobile']                     = 'Mobile:';
    $lang['fax']                        = 'Fax:';
    $lang['bus_phone']                  = '�������� ��������:';
    $lang['address']                    = '���������:';
    $lang['postal']                     = '��:';
    $lang['city']                       = '����:';
    $lang['email']                      = 'Email:';
    $lang['notes']                      = '����������:';
    $lang['add_contact']                = '�������� ������';
    $lang['del_contact']                = '�������� ������';
    $lang['contact_info']               = '���������� ������';
    $lang['contacts']                   = '������';
    $lang['contact_add_info']           = '�� ���������� �������� ����� ���� �� �������� ���� ���� ��� �� ����� ������.';
    $lang['show_contact']               = '�������� ������';
    $lang['edit_contact']               = '����������� ������';
    $lang['contact_submit']             = '���������� ������';
    $lang['contact_warn']               = '��� ����� ����������� ��� �� �����; ����������� ����������� ����������� �� ����� ��� �������';

 //files
    $lang['manage_files']               = '����������� �������';
    $lang['no_files']                   = '��� �������� ���������� ������ ���� �����������';
    $lang['no_file_uploads']            = '��� ���������� �� �������� ��� �������';
    $lang['file']                       = '������:';
    $lang['uploader']                   = 'Uploader:';
    $lang['files_assoc_project']        = '������ ������� �� ���� �� project';
    $lang['files_assoc_task']           = '������ ������� �� ���� ��� �������';
    $lang['file_admin']                 = '������������ �������';
    $lang['add_file']                   = '�������� �������';
    $lang['files']                      = '������';
    $lang['file_choose']                = '������ ��� ��������:';
    $lang['upload']                     = '��������';
    $lang['file_email_owner']           = '�������� ������������ email ��� �� ��� ������ ���� �������� ��� project?';
    $lang['file_email_usergroup']       = '�������� ������������ email ��� �� ��� ������ ��� ������� ������?';
    $lang['max_file_sprt']              = '�� ������ ���� �������� ������ �� ����� �������� ���%s kb.';
    $lang['file_submit']                = '�������� �������';
    $lang['no_upload']                  = '��� ������� ������ ������.  ������������ ����.';
    $lang['file_too_big_sprt']          = '�� ������� ������� ���� �������� ����� %s bytes.  �� �������� ��� ���� ���������� ��� �� ������������ ��� ��� ���� ���������.';
    $lang['del_file_javascript_sprt']   = '������� ������ �� ������� %s ?';


 //forum
    $lang['orig_message']               = '������ ������:';
    $lang['post']                       = '��������!';
    $lang['message']                    = '������:';
    $lang['post_reply_sprt']            = '�������� ��������� ��� ������ ���  \'%1$s\' ������� �� \'%2$s\'';
    $lang['post_message_sprt']          = '�������� ��������� ��: \'%s\'';
    $lang['forum_email_owner']          = '�������� ������������ Email ���� ������������� ��� ��� ���������� ��� forum ?';
    $lang['forum_email_usergroup']      = '�������� ������������ Email ���� ������� ������ ��� ��� ���������� ��� forum?';
    $lang['reply']                      = '��������';
    $lang['new_post']                   = '��� ��������';
    $lang['public_user_forum']          = '������� forum �������';
    $lang['private_forum_sprt']         = '�������� forum ��� \'%s\' ������';
    $lang['forum_submit']               = '���������� ��� Forum';
    $lang['no_message']                 = '��� ������� ������ ������������ ����';
    $lang['add_reply']                  = '��������� ��������';
    $lang['last_post_sprt']             = '��������� �������� %s'; //Note to translators: context is 'Last post 2004-Dec-22'
    $lang['recent_posts']               = '���������� ��������� ��� forum';      
    
 //includes
    $lang['report']                     = '�������';
    $lang['warning']                    = '<h1>�������!</h1><p>��� ��������� �� ����������� �� ������ ��� ���� �� ������. ����������� ����������� ��������.</p>';
    $lang['home_page']                  = '������ ������';
    $lang['summary_page']               = '������ ���������';
    $lang['todo_list']                  = '����� ��������';
    $lang['calendar']                   = '����������r';
    $lang['log_out']                    = '����������';
    $lang['main_menu']                  = '�������� �����';
    $lang['archive']                    = '������';   
    $lang['user_homepage_sprt']         = '%s\'s ������ ������';
    $lang['missing_field_javascript']   = '����������� ����� ��� ���� ��� ���� �����';
    $lang['invalid_date_javascript']    = '����������� �������� ��� ������ ����������';
    $lang['finish_date_javascript']     = '� ���������� ��� �������� ����� ���� �� ����� ��� project!';
    $lang['security_manager']           = '������������ ���������';
    $lang['session_timeout_sprt']       = '������������ � ��������; � ��������� �������� ���� %1$d ����� ���� ��� � ������ ����� ����� %2$d �����; �������� <a href="%3$sindex.php">���������������</a>';
    $lang['access_denied']              = '������������ � ��������';
    $lang['private_usergroup']          = '����������; ���� � ������� ����� ������ ��� ����� ����� ��� ����� �������� ���������.';
    $lang['invalid_date']               = '����� ����������';
    $lang['invalid_date_sprt']          = '� ����� ��� %s ��� ����� ������ ���������� (������ ��� ������ ������ ��� ����).<br />����������� ����� ��� ������ ����������.';


 //taskgroups
    $lang['taskgroup_name']             = '�������� ������ ��������:';
    $lang['taskgroup_description']      = '���� ��������� ������ ��������:';
    $lang['add_taskgroup']              = '��������� ������ ��������';
    $lang['add_new_taskgroup']          = '��������� ��� ��� ������ ��������';
    $lang['edit_taskgroup']             = '����������� ������ ��������';
    $lang['taskgroup_manage']           = '���������� ������ ��������';
    $lang['no_taskgroups']              = '��� ����� ������� ������ ��������';
    $lang['manage_taskgroups']          = '�������������� ������ ��������';
    $lang['taskgroups']                 = '������ ��������';
    $lang['taskgroup_dup_sprt']         = '������� ��� ��� ������ �������� \'%s\'.  ����������� �������� ���� �����.';
    $lang['info_taskgroup_manage']      = '����������� ��� �� ���������� ��� ������ ��������';

 //usergroups
    $lang['usergroup_name']             = '�������� ������ �������:';
    $lang['usergroup_description']      = '���� ��������� ��� ������ �������:';
    $lang['members']                    = '����:';
    $lang['private_usergroup']          = '�������� ����� �������';
    $lang['add_usergroup']              = '�������� ������ �������';
    $lang['add_new_usergroup']          = '��������� ��� ����� �������';
    $lang['edit_usergroup']             = '����������� ������ �������';
    $lang['usergroup_manage']           = '���������� ������ �������';
    $lang['no_usergroups']              = '��� ����� ������� ������ �������';
    $lang['manage_usergroups']          = '�������������� ��� ����� �������';
    $lang['usergroups']                 = '������ �������';
    $lang['usergroup_dup_sprt']         = '������� ��� ��� ����� ������� \'%s\'.  �������� �������� ���� �����.';
    $lang['info_usergroup_manage']      = '����������� ��� �� ���������� ��� ������ �������';

 //users
    $lang['login_name']                 = 'Login �����';
    $lang['full_name']                  = '�������������';
    $lang['password']                   = '�������';
    $lang['blank_for_current_password'] = '(������ ���� ��� �������� ����� �������)';
    $lang['email']                      = 'E-mail';
    $lang['admin']                      = '������������';
    $lang['private_user']               = '��������� �������';
    $lang['normal_user']                = '��������� �������'; 
    $lang['is_admin']                   = '����� ������������?';
    $lang['is_guest']                   = '����� ����������?';
    $lang['guest']                      = '����������';
    $lang['user_info']                  = '����������� ������';
    $lang['deleted_users']              = '�������� ������';
    $lang['no_deleted_users']           = '��� �������� ������� ���� ��������.';
    $lang['revive']                     = '��������������';
    $lang['permdel']                    = '�������� ��������';
    $lang['permdel_javascript_sprt']    = '���� �� ������ �������� ���� ��� ���������� ��� ��� �������� �������� ��� ����� %s. ������ �� ����������?';
    $lang['add_user']                   = '�������� ������';
    $lang['edit_user']                  = '����������� ������';
    $lang['no_users']                   = '��� �������� �������������� ��� �� ������� �������';
    $lang['users']                      = '�������';
    $lang['existing_users']             = '�������� �������';
    $lang['private_profile']            = '�� ������ ����� ��� ������ ����� ����������.';
    $lang['private_usergroup_profile']  = '(����� � ������� ����� ����� ���� ��������� ������ ������� ��� ����� ��� ����� ��������)';
    $lang['email_users']                = '�������� Email ����� �������';
    $lang['select_usergroup']           = '���������� ������ �������:';
    $lang['subject']                    = '����:';
    $lang['message_sent_maillist']      = '�� ���� ��������� �� ������ ����������� ���� mailing �����.';
    $lang['who_online']                 = '����� ����� online?';
    $lang['edit_details']               = '����������� ����������� ������';
    $lang['show_details']               = '�������� ����������� ������';
    $lang['user_deleted']               = '� ������� ����������!';
    $lang['no_usergroup']               = '����� � ������� ��� ����� ����� ������ ������ �������';
    $lang['not_usergroup']              = '(�� ����� ������� ������ �������)';
    $lang['no_password_change']         = '(� ������� ��� ��� ���� �������)';
    $lang['last_time_here']             = '��������� ��� ��������:';
    $lang['number_items_created']       = '������� ��������� ��� ��������������:';
    $lang['number_projects_owned']      = '������� project ��� ��� �������:';
    $lang['number_tasks_owned']         = '������� �������� ��� ��� �������:';
    $lang['number_tasks_completed']     = '������� �������� ��� �������������:';
    $lang['number_forum']               = '������� ��������� ��� forum:';
    $lang['number_files']               = '������� ����������� �������:';
    $lang['size_all_files']             = '�������� ������� ���� ��� ������� ��� ��� �������:';
    $lang['owned_tasks']                = '�������� ��� ��� �������';
    $lang['invalid_email']              = '����� ��������� email';
    $lang['invalid_email_given_sprt']   = '� ��������� email \'%s\' ����� �����.  �������� ������������ ����.';
    $lang['duplicate_user']             = '��������� ������';
    $lang['duplicate_change_user_sprt'] = '����� � ������� \'%s\' ������� ���.  �������� �������� ���� �����.';
    $lang['value_missing']              = '������ ������ ��������';
    $lang['field_sprt']                 = '�� �������� ��� \'%s\' �������. �������� ����������� ��.';
    $lang['admin_priv']                 = '����������: ��� ����� ����������� ���������� �����������.';
    $lang['manage_users']               = '���������� �������';
    $lang['users_online']               = '������� online';
    $lang['online']                     = '���������� ������� (Online ���� ��� 60 �����)';
    $lang['not_online']                 = '�� ���������';
    $lang['user_activity']              = '��������� ������';

  //tasks
    $lang['add_new_task']               = '��������� ��������� �������';
    $lang['priority']                   = '�������������';
    $lang['parent_task']                = '�������';
    $lang['creation_time']              = '��� �����������';
    $lang['by_sprt']                    = '%1$s by %2$s'; //Note to translators: context is 'Creation time: <date> by <user>'
    $lang['project_name']               = '�������� project';
    $lang['task_name']                  = '�������� ��������';
    $lang['deadline']                   = '����� ���������';
    $lang['taken_from_parent']          = '(������������� ��� ������)';
    $lang['status']                     = '������';
    $lang['task_owner']                 = '��������� ��������';
    $lang['project_owner']              = '��������� project';
    $lang['taskgroup']                  = '����� ��������';
    $lang['usergroup']                  = '����� �������';
    $lang['nobody']                     = '�������';
    $lang['none']                       = '������';
    $lang['no_group']                   = '��� ������� �����';
    $lang['all_groups']                 = '���� �� ������';
    $lang['all_users']                  = '���� �� �������';
    $lang['all_users_view']             = '���� �� ������� ������� �� ���� �� �������?';
    $lang['group_edit']                 = '���� ���� ����� ������� ������� �� �������������?';
    $lang['project_description']        = '��������� project';
    $lang['task_description']           = '��������� ��������';
    $lang['email_owner']                = '�������� email ���� �������� ��� ��� �������?';
    $lang['email_new_owner']            = '�������� email ���� (���) �������� �� ��� �������?';
    $lang['email_group']                = '�������� email ���� ����� ������� �� ��� �������?';
    $lang['add_new_project']            = '�������� ���� project';
    $lang['uncategorised']              = '�� �����������������';
    $lang['due_sprt']                   = '%d ������ ��� ������';
    $lang['tomorrow']                   = '�����';
    $lang['due_today']                  = '������';
    $lang['overdue_1']                  = '1 ����� �����������';
    $lang['overdue_sprt']               = '%d ������ �����������';
    $lang['edit_task']                  = '���������� ��������';
    $lang['edit_project']               = '����������� project';
    $lang['no_reparent']                = '������ (����� project)';
    $lang['del_javascript_project_sprt']= '���� �� ������ �� project %s. ����� ��������?';
    $lang['del_javascript_task_sprt']   = '���� �� ������ ��� ������� %s. ����� ��������?';
    $lang['add_task']                   = '�������� ��������';
    $lang['add_subtask']                = '�������� ���-��������';
    $lang['add_project']                = '�������� project';
    $lang['clone_project']              = '����������� project';
    $lang['clone_task']                 = '����������� ��������';
    $lang['quick_jump']                 = '������� ��������';
    $lang['no_edit']                    = '��� ��� ������ ���� �� ������� ��� ��� �������� �� �� ��������';
    $lang['uncategorised']              = '�� �����������������';
    $lang['admin']                      = '������������';
    $lang['global']                     = '������';
    $lang['delete_project']             = '�������� project';
    $lang['delete_task']                = '�������� ��������';
    $lang['project_options']            = '�������� project';
    $lang['task_options']               = '�������� ��������';
    $lang['javascript_archive_project'] = '���� �� ����� �� project ��� ������ %s.  ����� ��������?';
    $lang['archive_project']            = '����� �� project ��� ������';
    $lang['task_navigation']            = '������� ���� �������';
//**
    $lang['new_task']                   = '��� �������';    
    $lang['no_projects']                = '��� �������� projects ��� �� �����';
    $lang['show_all_projects']          = '�������� ���� ��� projects';
    $lang['show_active_projects']       = '�������� ���� ��� ������� projects';
    $lang['project_hold_sprt']          = 'Project �������� ��� %s';
    $lang['project_planned']            = '����������� Project';
    $lang['percent_sprt']               = '%d%% ��� ��� �������� ����� �����������';
    $lang['project_no_deadline']        = '��� ���� ������� ���������� ��������� ��� ���� �� project';
    $lang['no_allowed_projects']        = '��� �������� projects ��� �� ��� ����������� � ��������';
    $lang['projects']                   = 'Projects';
    $lang['percent_project_sprt']       = '���� �� project ����� %d%% ������������';
    $lang['owned_by']                   = '���������';
    $lang['created_on']                 = '������������� ���';
    $lang['completed_on']               = '������������ ����';
    $lang['modified_on']                = '����������� ����';
    $lang['project_on_hold']            = '�� Project ��������';
    $lang['project_accessible']         = '(���� �� project ����� ������� �� ����� ���� �������)';
    $lang['task_accessible']            = '(���� � ������� ����� ������� �� ����� ���� �������)';
    $lang['project_not_accessible']     = '(���� �� project ����� ������� ���� ��� �� ���� �� ������ �������)';
    $lang['task_not_accessible']        = '(���� � ������� ����� ������� ���� ��� �� ���� ��� ������ �������)';
    $lang['project_not_in_usergroup']   = '���� �� project ��� ������ �� ������ ����� ������� ��� ����� ������� ��� �����.';
    $lang['task_not_in_usergroup']      = '���� � ������� ��� ������ �� ������ ����� ������� ��� ����� ������� ��� �����.';
    $lang['usergroup_can_edit_project'] = '���� �� project ������ ������ �� ������������ ��� ���� ��� ������ �������.';
    $lang['usergroup_can_edit_task']    = '���� � ������� ������ �� ������������ ��� ���� ��� ������ �������.';
    $lang['i_take_it']                  = '�� ���������� :)';
    $lang['i_finished']                 = '�� ����������!';
    $lang['i_dont_want']                = '��� �� ���� ����';
    $lang['take_over_project']          = '������� project';
    $lang['take_over_task']             = '������� ��������';
    $lang['task_info']                  = '����������� ��������';
    $lang['project_details']            = '������������ Project';
    $lang['todo_list_for']              = '����� ��������: ';
    $lang['due_in_sprt']                = ' (����� �� %d ������)';
    $lang['due_tomorrow']               = ' (����� �����)';
    $lang['no_assigned']                = '��� �������� �� ������������� �������� ��� ����� ��� ���� �������� � �������.';
    $lang['todo_list']                  = '����� ��������';
    $lang['summary_list']               = '����� ���������';
    $lang['task_submit']                = '���������� ��������';
    $lang['not_owner']                  = '������������ � �������. ��� ����� �������� ���������';
    $lang['missing_values']             = '��� ������������ ��� �� �����; �������� ����������� ����';
    $lang['future']                     = '����������';
    $lang['flags']                      = '�������';
    $lang['owner']                      = '���������';
    $lang['group']                      = '�����';
    $lang['by_usergroup']               = ' (���� ������ �������)';
    $lang['by_taskgroup']               = ' (���� ����� ��������)';
    $lang['by_deadline']                = ' (���� ���������� ���������)';
    $lang['by_status']                  = ' (���� �������)';
    $lang['by_owner']                   = ' (���� ���������)';
    $lang['project_cloned']             = '�� project ������������� :';
    $lang['task_cloned']                = '������� ���� �����������:';
    $lang['note_clone']                 = '����������: � ������� �� ���������� �� ��� project';

//bits 'n' pieces
    $lang['calendar']                   = '����������';
    $lang['normal_version']             = '�������� ������';
    $lang['print_version']              = '������ ���������';
    $lang['condensed_view']             = '��������� �������';
    $lang['full_view']                  = '������������ �������';

?>
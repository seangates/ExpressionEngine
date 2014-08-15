<?php

namespace EllisLab\ExpressionEngine\Controllers\Settings;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use CP_Controller;
use EllisLab\ExpressionEngine\Library\CP;

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2003 - 2014, EllisLab, Inc.
 * @license		http://ellislab.com/expressionengine/user-guide/license.html
 * @link		http://ellislab.com
 * @since		Version 3.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ExpressionEngine CP Settings Class
 *
 * @package		ExpressionEngine
 * @subpackage	Control Panel
 * @category	Control Panel
 * @author		EllisLab Dev Team
 * @link		http://ellislab.com
 */
class Settings extends CP_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();

		if ( ! $this->cp->allowed_group('can_access_admin', 'can_access_sys_prefs'))
		{
			show_error(lang('unauthorized_access'));
		}

		ee()->lang->loadfile('settings');

		// Register our menu
		ee()->menu->register_left_nav(array(
			'general_settings' => cp_url('settings/general'),
			array(
				'license_and_reg' => cp_url('settings/license'),
				'url_path_settings' => cp_url('settings/urls'),
				'outgoing_email' => cp_url('settings/email'),
				'debugging_output' => cp_url('settings/debug-output')
			),
			'content_and_design' => cp_url('settings/content-design'),
			array(
				'comment_settings' => cp_url('settings/comments'),
				'template_settings' => cp_url('settings/template'),
				'upload_directories' => cp_url('settings/uploads'),
				'word_censoring' => cp_url('settings/word-censor')
			),
			'members' => cp_url('settings/members'),
			array(
				'messages' => cp_url('settings/messages'),
				'avatars' => cp_url('settings/avatars')
			),
			'security_privacy' => cp_url('settings/security-privacy'),
			array(
				'access_throttling' => cp_url('settings/throttling'),
				'captcha' => cp_url('settings/captcha')
			),
		));
	}

	// --------------------------------------------------------------------

	/**
	 * Index
	 */
	public function index()
	{
		ee()->functions->redirect(cp_url('settings/general'));
	}

	// --------------------------------------------------------------------

	/**
	 * General Settings
	 */
	public function general()
	{
		ee()->load->model('language_model');
		ee()->load->model('admin_model');
		
		$vars['sections'] = array(
			array(
				array(
					'title' => 'site_name',
					'desc' => 'site_name_desc',
					'fields' => array(
						'site_name' => array('type' => 'text')
					)
				),
				array(
					'title' => 'site_online',
					'desc' => 'site_online_desc',
					'fields' => array(
						'is_system_on' => array(
							'type' => 'inline_radio',
							'choices' => array(
								'y' => 'online',
								'n' => 'offline'
							)
						)
					)
				),
				array(
					'title' => 'version_autocheck',
					'desc' => 'version_autocheck_desc',
					'fields' => array(
						'new_version_check' => array(
							'type' => 'inline_radio',
							'choices' => array(
								'y' => 'auto',
								'n' => 'manual'
							)
						)
					),
					'action_button' => array(
						'text' => 'check_now',
						'link' => '#',
						'class' => 'version-check'
					)
				),
			),
			'defaults' => array(
				array(
					'title' => 'cp_theme',
					'desc' => '',
					'fields' => array(
						'cp_theme' => array(
							'type' => 'dropdown',
							'choices' => ee()->admin_model->get_cp_theme_list()
						)
					)
				),
				array(
					'title' => 'language',
					'desc' => 'language_desc',
					'fields' => array(
						'language' => array(
							'type' => 'dropdown',
							'choices' => ee()->language_model->language_pack_names(),
							'value' => ee()->config->item('deft_lang') ?: 'english'
						)
					)
				)
			),
			'date_time_settings' => array(
				array(
					'title' => 'timezone',
					'desc' => 'timezone_desc',
					'fields' => array(
						'default_site_timezone' => array(
							'type' => 'html',
							'content' => ee()->localize->timezone_menu(ee()->config->item('default_site_timezone'))
						)
					)
				),
				array(
					'title' => 'date_time_fmt',
					'desc' => 'date_time_fmt_desc',
					'fields' => array(
						'date_format' => array(
							'type' => 'dropdown',
							'choices' => array(
								'%n/%j/%y' => 'mm/dd/yy',
								'%j-%n-%y' => 'dd-mm-yy',
								'%Y-%m-%d' => 'yyyy-mm-dd'
							)
						),
						'time_format' => array(
							'type' => 'dropdown',
							'choices' => array(
								'24' => lang('24_hour'),
								'12' => lang('12_hour')
							)
						)
					)
				)
			)
		);

		$base_url = cp_url('settings/general');

		// TODO: Probably abstract this out
		if (count($_POST))
		{
			$fields = array();

			// Make sure we're getting only the fields we asked for
			foreach ($vars['sections'] as $settings)
			{
				foreach ($settings as $setting)
				{
					foreach ($setting['fields'] as $field_name => $field)
					{
						$fields[$field_name] = ee()->input->post($field_name);
					}
				}
			}

			$config_update = ee()->config->update_site_prefs($fields);

			if ( ! empty($config_update))
			{
				ee()->view->set_message('issue', lang('cp_message_issue'), implode('<br>', $config_update), TRUE);
			}
			else
			{
				ee()->view->set_message('success', lang('preferences_updated'), lang('preferences_updated_desc'), TRUE);
			}

			ee()->functions->redirect($base_url);
		}

		ee()->view->base_url = $base_url;
		ee()->view->cp_page_title = lang('general_settings');
		ee()->view->save_btn_text = 'btn_save_settings';
		ee()->view->save_btn_text_working = 'btn_save_settings_working';
		ee()->cp->render('_shared/form', $vars);
	}
}
// END CLASS

/* End of file Utilities.php */
/* Location: ./system/expressionengine/controllers/cp/Utilities/Utilities.php */
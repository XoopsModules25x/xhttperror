<?php
/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( https://xoops.org )
 * ****************************************************************************
 *  XHTTPERROR - MODULE FOR XOOPS
 *  Copyright (c) 2007 - 2012
 *  Rota Lucio ( http://luciorota.altervista.org/xoops/ )
 *
 *  You may not change or alter any portion of this comment or credits
 *  of supporting developers from this source code or any supporting
 *  source code which is considered copyrighted (c) material of the
 *  original comment or credit authors.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  ---------------------------------------------------------------------------
 *
 * @copyright  Rota Lucio ( http://luciorota.altervista.org/xoops/ )
 * @license    GNU General Public License v3.0
 * @package    xhttperror
 * @author     Rota Lucio ( lucio.rota@gmail.com )
 *
 *  $Rev$:     Revision of last commit
 *  $Author$:  Author of last commit
 *  $Date$:    Date of last commit
 * ****************************************************************************
 */

require_once __DIR__ . '/preloads/autoloader.php';

$moduleDirName = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

require_once XOOPS_ROOT_PATH . "/modules/{$moduleDirName}/include/functions.php";
xoops_load('XoopsLists');

$modversion['version']             = '1.11.0';
$modversion['module_status']       = 'Beta 1'; //"Stable";
$modversion['release_date']        = '2020/05/14'; // 'Y/m/d'
$modversion['name']                = _MI_XHTTPERR_NAME;
$modversion['description']         = _MI_XHTTPERR_DESC;
$modversion['author']              = 'Rota Lucio';
$modversion['author_mail']         = 'lucio.rota@gmail.com';
$modversion['author_website_url']  = 'http://luciorota.altervista.org';
$modversion['author_website_name'] = 'http://luciorota.altervista.org';
$modversion['credits']             = 'Andrew Mills <a href"=emailto:ajmills@sirium.net">ajmillsATsiriumDOTnet</a>';
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU General Public License v3.0';
$modversion['license_url']         = 'https://www.gnu.org/licenses/gpl-3.0.txt';
$modversion['dirname']             = $moduleDirName;
$modversion['release_info']        = 'in progress';
$modversion['release_file']        = XOOPS_URL . '/modules/' . $modversion['dirname'] . '/docs/changelog.txt';
$modversion['min_php']             = '7.2';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['official']            = 0; //1 indicates supported by Xoops CORE Dev Team, 0 means 3rd party supported

//$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['modicons16'] = "assets/images/icons/16x16";
$modversion['modicons32'] = "assets/images/icons/32x32";

// About
$modversion['demo_site_url']       = '';
$modversion['demo_site_name']      = '';
$modversion['forum_site_url']      = '';
$modversion['forum_site_name']     = '';
$modversion['module_website_url']  = '';
$modversion['module_website_name'] = '';
$modversion['support_site_url']    = '';
$modversion['support_site_name']   = '';
$modversion['release']             = 'release';

// Admin things
$modversion['hasAdmin'] = true;
// Admin system menu
$modversion['system_menu'] = true;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Mysql file
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'xhttperror_errors';
$modversion['tables'][1] = 'xhttperror_reports';

// Scripts to run upon installation or update
$modversion['onInstall'] = 'include/install_function.php';
//$modversion['onUpdate'] = 'include/update_function.php';
//$modversion['onUninstall'] = 'include/uninstall_function.php';

// Main menu
$modversion['hasMain'] = false;

// ------------------- Blocks ------------------- //

// Search
$modversion['hasSearch'] = false;

// Comments
$modversion['hasComments'] = false;

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_XHTTPERR_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_XHTTPERR_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_XHTTPERR_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_XHTTPERR_SUPPORT, 'link' => 'page=support'],
];

// ------------------- Templates ------------------- //
$i = 0;
++$i;
$modversion['templates'][$i]['file']        = 'xhttperror_index.tpl';
$modversion['templates'][$i]['description'] = '';
// Admin templates
++$i;
$modversion['templates'][$i]['file']        = 'xhttperror_admin_errors_list.tpl';
$modversion['templates'][$i]['description'] = '';
//$modversion['templates'][$i]['type'] = 'admin';
++$i;
$modversion['templates'][$i]['file']        = 'xhttperror_admin_reports_list.tpl';
$modversion['templates'][$i]['description'] = '';
//$modversion['templates'][$i]['type'] = 'admin';

// Preferences/Config
$modversion['config'][] = [
    'name'        => 'text_editor',
    'title'       => '_MI_XHTTPERR_FORM_EDITOR',
    'description' => '_MI_XHTTPERR_FORM_EDITOR_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => \XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor'),
    'category'    => 'global',
];

// Ignore error reports for admins
$modversion['config'][] = [
    'name'        => 'ignore_admin',
    'title'       => '_MI_XHTTPERR_IGNOREADMIN',
    'description' => '_MI_XHTTPERR_IGNOREADMIN_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => true,
];

// Option to turn off error reporting
$modversion['config'][] = [
    'name'        => 'error_reporting',
    'title'       => '_MI_XHTTPERR_REPORTING',
    'description' => '_MI_XHTTPERR_REPORTING_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => false,
];

// Show title in page title
$modversion['config'][] = [
    'name'        => 'title_as_page_title',
    'title'       => '_MI_XHTTPERR_PAGETTL',
    'description' => '_MI_XHTTPERR_PAGETTL_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => '1',
    'options'     => ['_MI_XHTTPERR_PAGETTL1' => '0', '_MI_XHTTPERR_PAGETTL2' => '1', '_MI_XHTTPERR_PAGETTL3' => '2',],
];

// Reports per page
$modversion['config'][] = [
    'name'        => 'reports_per_page',
    'title'       => '_MI_XHTTPERR_NUMREPS',
    'description' => '_MI_XHTTPERR_NUMREPS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '50',
];
// Notifications
$modversion['hasNotification'] = false;

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

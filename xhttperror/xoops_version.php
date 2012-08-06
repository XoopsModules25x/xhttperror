<?php
/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( http://www.xoops.org )
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
 *  @copyright  Rota Lucio ( http://luciorota.altervista.org/xoops/ )
 *  @license    GNU General Public License v3.0 
 *  @package    xhttperror
 *  @author     Rota Lucio ( lucio.rota@gmail.com )
 *
 *  $Rev$:     Revision of last commit
 *  $Author$:  Author of last commit
 *  $Date$:    Date of last commit
 * ****************************************************************************
 */

if (!defined('XOOPS_ROOT_PATH')){ exit(); }
$dirname = basename( dirname( __FILE__ ) ) ;
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/include/functions.php";
xoops_load('XoopsLists');

$modversion['name'] = _MI_XHTTPERR_NAME;
$modversion['version'] = '1.00';
$modversion['description'] = _MI_XHTTPERR_DESC;
$modversion['author'] = 'Rota Lucio';
$modversion['author_mail'] = 'lucio.rota@gmail.com';
$modversion['author_website_url'] = 'http://luciorota.altervista.org';
$modversion['author_website_name'] = 'http://luciorota.altervista.org';
$modversion['credits'] = 'Andrew Mills <a href"=emailto:ajmills@sirium.net">ajmillsATsiriumDOTnet</a>';
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU General Public License v3.0';
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-3.0.txt';

$modversion['release_info'] = 'in progress';
$modversion['release_file'] = XOOPS_URL . "/modules/{$dirname}/docs/RC";
$modversion['release_date'] = '2012/08/06'; // 'Y/m/d'

$modversion['min_php'] = '5.2';
$modversion['min_xoops'] = '2.5.5';
$modversion['min_admin']= '1.1';
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');
$modversion['image'] = 'images/xhttperror_slogo.png';
$modversion['dirname'] = "{$dirname}";
$modversion['official'] = false;

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = "modules/{$dirname}/images/icons/16x16";
$modversion['icons32'] = "modules/{$dirname}/images/icons/32x32";

// About
$modversion['demo_site_url'] = '';
$modversion['demo_site_name'] = '';
$modversion['forum_site_url'] = '';
$modversion['forum_site_name'] = '';
$modversion['module_website_url'] = '';
$modversion['module_website_name'] = '';
$modversion['support_site_url']	= '';
$modversion['support_site_name'] = '';
$modversion['release'] = "release";
$modversion['module_status'] = 'beta'; //"Stable";



// Admin things
$modversion['hasAdmin'] = true;
// Admin system menu
$modversion['system_menu'] = true;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";



// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "xhttperror_errors";
$modversion['tables'][1] = "xhttperror_reports";



// Scripts to run upon installation or update
$modversion['onInstall'] = 'include/install_function.php';
//$modversion['onUpdate'] = 'include/update_function.php';
//$modversion['onUninstall'] = 'include/uninstall_function.php';



// Main menu
$modversion['hasMain'] = false;



// Blocks



// Search
$modversion['hasSearch'] = false;



// Comments
$modversion['hasComments'] = false;



// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'xhttperror_index.html';
$modversion['templates'][$i]['description'] = '';
// Admin templates
$i++;
$modversion['templates'][$i]['file'] = 'xhttperror_admin_errors_list.html';
$modversion['templates'][$i]['description'] = '';
//$modversion['templates'][$i]['type'] = 'admin';
$i++;
$modversion['templates'][$i]['file'] = 'xhttperror_admin_reports_list.html';
$modversion['templates'][$i]['description'] = '';
//$modversion['templates'][$i]['type'] = 'admin';

// Preferences/Config
$i = 0;
$i++;
$modversion['config'][$i]['name']           = 'text_editor';
$modversion['config'][$i]['title']          = '_MI_XHTTPERR_FORM_EDITOR';
$modversion['config'][$i]['description']    = '_MI_XHTTPERR_FORM_EDITOR_DESC';
$modversion['config'][$i]['formtype']       = 'select';
$modversion['config'][$i]['valuetype']      = 'text';
$modversion['config'][$i]['default']        = 'dhtmltextarea';
$modversion['config'][$i]['options']        = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor');
$modversion['config'][$i]['category']       = 'global';
// Ignore error reports for admins
$i++;
$modversion['config'][$i]['name']           = 'ignore_admin';
$modversion['config'][$i]['title']          = '_MI_XHTTPERR_IGNOREADMIN';
$modversion['config'][$i]['description']    = '_MI_XHTTPERR_IGNOREADMIN_DESC';
$modversion['config'][$i]['formtype']       = 'yesno';
$modversion['config'][$i]['valuetype']      = 'int';
$modversion['config'][$i]['default']        = true;
// Option to turn off error reporting
$i++;
$modversion['config'][$i]['name']           = 'error_reporting';
$modversion['config'][$i]['title']          = '_MI_XHTTPERR_REPORTING';
$modversion['config'][$i]['description']    = '_MI_XHTTPERR_REPORTING_DESC';
$modversion['config'][$i]['formtype']       = 'yesno';
$modversion['config'][$i]['valuetype']      = 'int';
$modversion['config'][$i]['default']        = false;
$i++;
// Show title in page title
$modversion['config'][$i]['name']           = 'title_as_page_title';
$modversion['config'][$i]['title']          = '_MI_XHTTPERR_PAGETTL';
$modversion['config'][$i]['description']    = '_MI_XHTTPERR_PAGETTL_DESC';
$modversion['config'][$i]['formtype']       = 'select';
$modversion['config'][$i]['valuetype']      = 'int';
$modversion['config'][$i]['default']        = '1';
$modversion['config'][$i]['options']        = array('_MI_XHTTPERR_PAGETTL1' => '0', '_MI_XHTTPERR_PAGETTL2' => '1', '_MI_XHTTPERR_PAGETTL3' => '2');
// Reports per page
$i++;
$modversion['config'][$i]['name']           = 'reports_per_page';
$modversion['config'][$i]['title']          = '_MI_XHTTPERR_NUMREPS';
$modversion['config'][$i]['description']    = '_MI_XHTTPERR_NUMREPS_DESC';
$modversion['config'][$i]['formtype']       = 'textbox';
$modversion['config'][$i]['valuetype']      = 'int';
$modversion['config'][$i]['default']        = '50';



// Notifications
$modversion['hasNotification'] = false;

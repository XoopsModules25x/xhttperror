<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * xhttperror module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package          xhttperror
 * @since           1.00
 * @author          Xoops Development Team
 * @version         svn:$id$
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname(basename(dirname(dirname(__FILE__))));
$pathIcon32 = '../../' . $module->getInfo('icons32');

$adminmenu = array();
$i=0;
//$adminmenu[$i]['name'] = 'Index';
$adminmenu[$i]['title'] = _MI_XHTTPERROR_ADMENU_INDEX;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]['icon'] = $pathIcon32 . '/house.png';
//$adminmenu[$i]['desc'] = _MI_XHTTPERROR_ADMENU_INDEX_DESC;
++$i;
//$adminmenu[$i]['name'] = 'Errors';
$adminmenu[$i]['title'] = _MI_XHTTPERROR_ADMENU_ERRORS;
$adminmenu[$i]['link'] = "admin/error.php";
$adminmenu[$i]['icon'] = $pathIcon32 . '/error.png';
//$adminmenu[$i]['desc'] = _MI_XHTTPERROR_ADMENU_ERRORS_DESC;
++$i;
//$adminmenu[$i]['name'] = 'Reports';
$adminmenu[$i]['title'] = _MI_XHTTPERROR_ADMENU_REPORTS;
$adminmenu[$i]['link'] = "admin/report.php";
$adminmenu[$i]['icon'] = $pathIcon32 . '/report_error.png';
//$adminmenu[$i]['desc'] = _MI_XHTTPERROR_ADMENU_REPORTS_DESC;
++$i;
//$adminmenu[$i]['name'] = 'About';
$adminmenu[$i]['title'] = _MI_XHTTPERROR_ADMENU_ABOUT;
$adminmenu[$i]['link'] = "admin/about.php";
$adminmenu[$i]['icon'] = $pathIcon32 . '/information.png';
//$adminmenu[$i]['desc'] = _MI_XHTTPERROR_ADMENU_ABOUT_DESC;

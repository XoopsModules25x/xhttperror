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

$dirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$module_handler =& xoops_gethandler("module");
$xoopsModule =& XoopsModule::getByDirname($dirname);
$moduleInfo =& $module_handler->get($xoopsModule->getVar("mid"));
$pathImageAdmin = $moduleInfo->getInfo("icons32");	
	
$adminmenu = array();
$i = 1;
$i++;
$adminmenu[$i]['name'] = 'Index';
$adminmenu[$i]['title'] = _MI_XHTTPERR_ADMENU_INDEX;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]['desc'] = _MI_XHTTPERR_ADMENU_INDEX_DESC;
$adminmenu[$i]['icon'] = "../../{$pathImageAdmin}/house.png";
$i++;
$adminmenu[$i]['name'] = 'Errors';
$adminmenu[$i]['title'] = _MI_XHTTPERR_ADMENU_ERRORS;
$adminmenu[$i]['link'] = "admin/errors.php";
$adminmenu[$i]['desc'] = _MI_XHTTPERR_ADMENU_ERRORS_DESC;
$adminmenu[$i]['icon'] = "../../{$pathImageAdmin}/error.png";
$i++;
$adminmenu[$i]['name'] = 'Reports';
$adminmenu[$i]['title'] = _MI_XHTTPERR_ADMENU_REPORTS;
$adminmenu[$i]['link'] = "admin/reports.php";
$adminmenu[$i]['desc'] = _MI_XHTTPERR_ADMENU_REPORTS_DESC;
$adminmenu[$i]['icon'] = "../../{$pathImageAdmin}/report_error.png";
$i++;
$adminmenu[$i]['name'] = 'About';
$adminmenu[$i]['title'] = _MI_XHTTPERR_ADMENU_ABOUT;
$adminmenu[$i]['link'] = "admin/about.php";
$adminmenu[$i]['desc'] = _MI_XHTTPERR_ADMENU_ABOUT_DESC;
$adminmenu[$i]['icon'] = "../../{$pathImageAdmin}/information.png";
unset( $i );

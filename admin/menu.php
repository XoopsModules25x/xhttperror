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

use XoopsModules\Xhttperror;

// require_once  dirname(__DIR__) . '/class/Helper.php';
//require_once  dirname(__DIR__) . '/include/common.php';
$helper = Xhttperror\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'name'  => 'Index',
    'title' => _MI_XHTTPERR_ADMENU_INDEX,
    'link'  => 'admin/index.php',
    'desc'  => _MI_XHTTPERR_ADMENU_INDEX_DESC,
    'icon'  => "../../{$pathModIcon32}/house.png",
];

$adminmenu[] = [
    'name'  => 'Errors',
    'title' => _MI_XHTTPERR_ADMENU_ERRORS,
    'link'  => 'admin/errors.php',
    'desc'  => _MI_XHTTPERR_ADMENU_ERRORS_DESC,
    'icon'  => "../../{$pathModIcon32}/error.png",
];

$adminmenu[] = [
    'name'  => 'Reports',
    'title' => _MI_XHTTPERR_ADMENU_REPORTS,
    'link'  => 'admin/reports.php',
    'desc'  => _MI_XHTTPERR_ADMENU_REPORTS_DESC,
    'icon'  => "../../{$pathModIcon32}/report_error.png",
];

$adminmenu[] = [
    'name'  => 'About',
    'title' => _MI_XHTTPERR_ADMENU_ABOUT,
    'link'  => 'admin/about.php',
    'desc'  => _MI_XHTTPERR_ADMENU_ABOUT_DESC,
    'icon'  => "../../{$pathModIcon32}/information.png",
];

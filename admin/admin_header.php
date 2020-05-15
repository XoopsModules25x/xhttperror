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

include dirname(__DIR__) . '/preloads/autoloader.php';

require  dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
//require $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require  dirname(__DIR__) . '/include/common.php';

require_once XOOPS_ROOT_PATH . '/class/tree.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
xoops_load('XoopsUserUtility');
// require_once  dirname(__DIR__) . '/class/Utility.php';
//require_once  dirname(__DIR__) . '/include/common.php';

require_once dirname(__DIR__) . '/include/functions.php';

$moduleDirName = basename(dirname(__DIR__));
/** @var Xhttperror\Helper $helper */
$helper      = Xhttperror\Helper::getInstance();
$adminObject = \Xmf\Module\Admin::getInstance();

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}

///** @var \XoopsModuleHandler $moduleHandler */
//$moduleHandler   = xoops_getHandler('module');
//$xoopsModule     = $moduleHandler->getByDirname($dirname);
$moduleInfo      = $helper->getModule()->mid();
$pathIcon16      = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32      = \Xmf\Module\Admin::iconUrl('', 32);
$pathImageModule = $helper->url('assets/images');

// Get user groups
$groupPermHandler = xoops_getHandler('groupperm');
if ($xoopsUser) {
    $grouppermHandler = xoops_getHandler('groupperm');
    if (!$grouppermHandler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

$xoopsTpl->assign('pathImageIcon', $pathIcon16);
$xoopsTpl->assign('pathImageAdmin', $pathImageModule);
//xoops_cp_header();

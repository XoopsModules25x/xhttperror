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

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

define('_RED', '#FF0000'); // Red
define('_GREEN', '#00AA00'); // Green

// load classes
$errorHandler  = xoops_getModuleHandler('error', 'xhttperror');
$reportHandler = xoops_getModuleHandler('report', 'xhttperror');

// count errors
$countErrors = $errorHandler->getCount();
// count msgs
$countReports = $reportHandler->getCount();

if (xhttperror_checkModuleAdmin()) {
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->addInfoBox(_AM_XHTTPERR_INTRO);
    $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_INFO), '');
    if (file_exists(XOOPS_ROOT_PATH . '/.htaccess')) {
        $htaccessCheck = _AM_XHTTPERR_FILECHK . XOOPS_ROOT_PATH . '/.htaccess ' . '<br>' . _AM_XHTTPERR_FILEEXISTS;
    } else {
        $htaccessCheck = _AM_XHTTPERR_FILECHK . XOOPS_ROOT_PATH . '/.htaccess ' . '<br>' . _AM_XHTTPERR_FILENOEXIST;
    }
    $adminObject->addInfoBoxLine(sprintf($htaccessCheck), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_ADDCODE), '');
    if ($countErrors == 0) {
        $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_NOCODE), '');
    } else {
        // get errors
        $criteria = new CriteriaCompo();
        $errors   = $errorHandler->getObjects($criteria);
        foreach ($errors as $error) {
            $msg_id           = $error->getVar('error_id');
            $error_statuscode = $error->getVar('error_statuscode');
            $hmtl             = 'ErrorDocument ' . $error_statuscode . ' ' . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/index.php?error=' . $error_statuscode . '';
            $adminObject->addInfoBoxLine(sprintf($hmtl), '');
        }
    }
    $adminObject->displayNavigation(basename(__FILE__));
    $adminObject->displayIndex();
}
require_once __DIR__ . '/admin_footer.php';

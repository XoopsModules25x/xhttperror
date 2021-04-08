<?php declare(strict_types=1);

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

use Xmf\Request;
use Xmf\Module\Admin;
use XoopsModules\Xhttperror\{
    Common\TestdataButtons,
    Helper,
    Utility
};

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();

define('_RED', '#FF0000'); // Red
define('_GREEN', '#00AA00'); // Green

// load classes
$errorHandler  = $helper->getHandler('Error');
$reportHandler = $helper->getHandler('Report');

// count errors
$countErrors = $errorHandler->getCount();
// count msgs
$countReports = $reportHandler->getCount();

if (xhttperror_checkModuleAdmin()) {
    $adminObject = Admin::getInstance();
    $adminObject->addInfoBox(_AM_XHTTPERR_INTRO);
    $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_INFO), '');
    if (file_exists(XOOPS_ROOT_PATH . '/.htaccess')) {
        $htaccessCheck = _AM_XHTTPERR_FILECHK . XOOPS_ROOT_PATH . '/.htaccess ' . '<br>' . _AM_XHTTPERR_FILEEXISTS;
    } else {
        $htaccessCheck = _AM_XHTTPERR_FILECHK . XOOPS_ROOT_PATH . '/.htaccess ' . '<br>' . _AM_XHTTPERR_FILENOEXIST;
    }
    $adminObject->addInfoBoxLine(sprintf($htaccessCheck), '');
    $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_ADDCODE), '');
    if (0 == $countErrors) {
        $adminObject->addInfoBoxLine(sprintf(_AM_XHTTPERR_NOCODE), '');
    } else {
        // get errors
        $errorCriteria = new \CriteriaCompo();
        $errorObjs   = $errorHandler->getObjects($errorCriteria);
        foreach ($errorObjs as $errorObj) {
            $msg_id           = $errorObj->getVar('error_id');
            $error_statuscode = $errorObj->getVar('error_statuscode');
            $html             = "ErrorDocument {$error_statuscode} " . XOOPS_URL . "/modules/{$GLOBALS['xoopsModule']->getVar('dirname')}/index.php?error={$error_statuscode}&REMOTE_ADDR=%%{REMOTE_ADDR}&REQUEST_URI=%%{REQUEST_URI}&HTTP_REFERER=%%{HTTP_REFERER}";
            $adminObject->addInfoBoxLine($html, '');
        }
    }
    $adminObject->displayNavigation(basename(__FILE__));

    //------------- Test Data Buttons ----------------------------
    if ($helper->getConfig('displaySampleButton')) {
        TestdataButtons::loadButtonConfig($adminObject);
        $adminObject->displayButton('left', '');
    }
    $op = Request::getString('op', 0, 'GET');
    switch ($op) {
        case 'hide_buttons':
            TestdataButtons::hideButtons();
            break;
        case 'show_buttons':
            TestdataButtons::showButtons();
            break;
    }
    //------------- End Test Data Buttons ----------------------------

    $adminObject->displayIndex();
}
require_once __DIR__ . '/admin_footer.php';

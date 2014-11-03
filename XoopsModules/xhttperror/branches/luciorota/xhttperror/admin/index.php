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
 * @package         xhttperror
 * @since           1.00
 * @author          Xoops Development Team
 * @version         svn:$id$
 */

$currentFile = basename(__FILE__);
include_once __DIR__ . '/admin_header.php';

define('_RED', '#FF0000'); // Red
define('_GREEN', '#00AA00'); // Green

xoops_cp_header();
$indexAdmin = new ModuleAdmin();

//--------------------------
$errorCount = $xhttperror->getHandler('error')->getCount();
$reportCount = $xhttperror->getHandler('report')->getCount();

$indexAdmin->addInfoBox(_AM_XHTTPERROR_INTRO);
$indexAdmin->addInfoBoxLine(_AM_XHTTPERROR_INTRO, _AM_XHTTPERROR_INFO);
    if( file_exists(XOOPS_ROOT_PATH . "/.htaccess")) {
    $htaccessCheck = _AM_XHTTPERROR_FILECHK . XOOPS_ROOT_PATH . "/.htaccess " . "<br />" . _AM_XHTTPERROR_FILEEXISTS;
} else {
    $htaccessCheck = _AM_XHTTPERROR_FILECHK . XOOPS_ROOT_PATH . "/.htaccess " . "<br />" . _AM_XHTTPERROR_FILENOEXIST;
}
$indexAdmin->addInfoBoxLine(_AM_XHTTPERROR_INTRO, $htaccessCheck);
$indexAdmin->addInfoBoxLine(_AM_XHTTPERROR_INTRO, _AM_XHTTPERROR_ADDCODE);
if ($errorCount == 0) {
    $indexAdmin->addInfoBoxLine(_AM_XHTTPERROR_INTRO, _AM_XHTTPERROR_NOCODE);
} else {
    // get errors
    $criteria = new CriteriaCompo();
    $errorObjs = $xhttperror->getHandler('error')->getObjects($criteria);
    foreach ($errorObjs as $errorObj) {
        $error_id = $errorObj->getVar('error_id');
        $error_statuscode = $errorObj->getVar('error_statuscode');
        $hmtl = "ErrorDocument " . $error_statuscode . " " . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/index.php?error=" . $error_statuscode . "";
        $indexAdmin->addInfoBoxLine(_AM_XHTTPERROR_INTRO, $hmtl);
    }
}
echo $indexAdmin->addNavigation($currentFile);
echo $indexAdmin->renderIndex();

include __DIR__ . '/admin_footer.php';

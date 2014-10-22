<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/common.php';

// Include xoops admin header
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';

$pathIcon16 = XOOPS_URL . '/' . $xhttperror->getModule()->getInfo('icons16');
$pathIcon32 = XOOPS_URL . '/' . $xhttperror->getModule()->getInfo('icons32');
$pathModuleAdmin = XOOPS_ROOT_PATH . '/' . $xhttperror->getModule()->getInfo('dirmoduleadmin');
require_once $pathModuleAdmin . '/moduleadmin/moduleadmin.php';

// Load language files
xoops_loadLanguage('admin', $xhttperror->getModule()->dirname());
xoops_loadLanguage('modinfo', $xhttperror->getModule()->dirname());
xoops_loadLanguage('main', $xhttperror->getModule()->dirname());

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once(XOOPS_ROOT_PATH . '/class/template.php');
    $xoopsTpl = new XoopsTpl();
}
/*












// Include xoops admin header
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/tree.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
xoops_load ('XoopsUserUtility');

$module_handler =& xoops_gethandler('module');
$xoopsModule = & $module_handler->getByDirname($dirname); 
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');
$pathImageModule = XOOPS_URL . '/modules/'. $GLOBALS['xoopsModule']->getVar('dirname') .'/images';

// Include module functions
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/include/config.php";
include_once XOOPS_ROOT_PATH . "/modules/{$dirname}/include/functions.php";



// Check and load moduleadmin classes
$pathDir = $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin');
$globalLanguage = $GLOBALS['xoopsConfig']['language'];
if ( file_exists($pathDir . '/language/' . $globalLanguage . '/main.php')){
	include_once $pathDir . '/language/' . $globalLanguage . '/main.php';        
} else {
	include_once $pathDir . '/language/english/main.php';        
}
if ( file_exists($pathDir . '/moduleadmin.php')){
	include_once $pathDir . '/moduleadmin.php';
	//return true;
} else {
	xoops_cp_header();
	echo xoops_error(_AM_XADDRESSES_NOFRAMEWORKS);
	xoops_cp_footer();
	//return false;
}

$myts =& MyTextSanitizer::getInstance();

// Get user groups
$groupPermHandler =& xoops_gethandler('groupperm');
if ($xoopsUser) {
    $moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
    exit();
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}

$xoopsTpl->assign('pathImageIcon', $pathImageIcon);
$xoopsTpl->assign('pathImageAdmin', $pathImageAdmin);
//xoops_cp_header();

//Load module languages
xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));
*/
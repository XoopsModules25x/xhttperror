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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

// common Xoops stuff
xoops_load('XoopsRequest');
xoops_load('XoopsUserUtility');
xoops_load('XoopsLocal');

// MyTextSanitizer object
$myts = MyTextSanitizer::getInstance();

// Load Xoops handlers
$module_handler = xoops_gethandler('module');
$member_handler = xoops_gethandler('member');
$notification_handler = xoops_gethandler('notification');
$groupperm_handler = xoops_gethandler('groupperm');

// This must contain the name of the folder in which reside Xhttperror
define("XHTTPERROR_DIRNAME", basename(dirname(dirname(__FILE__))));
define("XHTTPERROR_URL", XOOPS_URL . '/modules/' . XHTTPERROR_DIRNAME);
define("XHTTPERROR_IMAGES_URL", XHTTPERROR_URL . '/assets/images');
define("XHTTPERROR_JS_URL", XHTTPERROR_URL . "/assets/js");
define("XHTTPERROR_CSS_URL", XHTTPERROR_URL . "/assets/css");
define("XHTTPERROR_ADMIN_URL", XHTTPERROR_URL . '/admin');
define("XHTTPERROR_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . XHTTPERROR_DIRNAME);

xoops_loadLanguage('common', XHTTPERROR_DIRNAME);

include_once XHTTPERROR_ROOT_PATH . '/include/functions.php';
include_once XHTTPERROR_ROOT_PATH . '/include/constants.php';

include_once XHTTPERROR_ROOT_PATH . '/class/xhttperror.php'; // XhttperrorXhttperror class
include_once XHTTPERROR_ROOT_PATH . '/class/common/session.php'; // XhttperrorSession class

$debug = false;
$xhttperror = XhttperrorXhttperror::getInstance($debug);

//This is needed or it will not work in blocks.
global $xhttperror_isAdmin;

// Load only if module is installed
if (is_object($xhttperror->getModule())) {
    // Find if the user is admin of the module
    $xhttperror_isAdmin = xhttperror_userIsAdmin();
}

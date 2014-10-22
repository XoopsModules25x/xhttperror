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
 * Xhttperror module
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package         module_skeleton
 * @since           1.01
 * @author          Xoops Development Team
 * @version         svn:$id$
 */
function xhttperror_checkModuleAdmin() {
    if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        return true;
    } else {
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        return false;
    }
}



/**
 * Checks if a user is admin of Module_skeleton
 *
 * @return boolean
 */
function xhttperror_userIsAdmin()
{
    global $xoopsUser;
    $xhttperror = XhttperrorXhttperror::getInstance();

    static $xhttperror_isAdmin;
    if (isset($xhttperror_isAdmin)) {
        return $xhttperror_isAdmin;
    }

    $xhttperror_isAdmin = (!is_object($xoopsUser)) ? false : $xoopsUser->isAdmin($xhttperror->getModule()->getVar('mid'));
    return $xhttperror_isAdmin;
}


/*
function xhttperror_CleanVars(&$global, $key, $default = '', $type = 'int') {
    switch ($type) {
        case 'array':
            $ret = (isset($global[$key]) && is_array($global[$key])) ? $global[$key] : $default;
            break;
        case 'date':
            $ret = (isset($global[$key])) ? strtotime($global[$key]) : $default;
            break;
        case 'string':
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int': default:
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if ($ret === false) {
        return $default;
    }
    return $ret;
}
*/

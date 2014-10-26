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

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_pre_uninstall_xhttperror(&$xoopsModule) {
    // NOP
    return true;
}

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_uninstall_xhttperror(&$xoopsModule) {
    include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/include/functions.php';
	// NOP
	return true;
}

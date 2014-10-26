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
function xoops_module_pre_install_xhttperror(&$xoopsModule) {
    // NOP
    return true;
}

/**
 * @param object            $xoopsModule
 * @return bool             FALSE if failed
 */
function xoops_module_install_xhttperror(&$xoopsModule) {
    xoops_loadLanguage('modinfo', $xoopsModule->getVar('dirname'));
    include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/include/functions.php';
    //
    $ret = true;
    $msg = '';
    // load classes
    $errorHandler = xoops_getModuleHandler('error', $xoopsModule->getVar('dirname'));
    $errorObj = $errorHandler->create();
    $errorObj->setVar('error_title', 'Error 404 - Document Not Found');
    $errorObj->setVar('error_statuscode', '404');
    $errorObj->setVar('error_text', '<p style="font-weight: bold; text-align: center">The page you requested could not be found.</p><p>You may not be able to find the requested page because:</p><ul><li>The page no longer exists.</li><li>The address/page name was mis-typed.</li><li>You followed an incorrect, or out of date link on another site.</li><li>You followed an out of date search engine listing, or personal bookmark/favourite.</li></ul><p>Please try visiting the <a href="/">home page</a>, or use the search function below to find the page you were after.</p>');
    $errorObj->setVar('error_showme', true);
    $errorObj->setVar('error_redirect', false);
    $errorObj->setVar('error_redirect_time', 3);
    $errorObj->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($errorObj))
        $msg = $msg . $errorObj->getHtmlErrors();
    unset($errorObj);
    //
    $errorObj = $errorHandler->create();
    $errorObj->setVar('error_title', 'Error 500 - Server error');
    $errorObj->setVar('error_statuscode', '500');
    $errorObj->setVar('error_text', '<p style="font-weight: bold; text-align: center;">The server encountered an internal error and was unable to complete your request.</p>');
    $errorObj->setVar('error_showme', true);
    $errorObj->setVar('error_redirect', false);
    $errorObj->setVar('error_redirect_time', 3);
    $errorObj->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($errorObj))
        $msg = $msg . $errorObj->getHtmlErrors();
    unset($errorObj);
    //
    $errorObj = $errorHandler->create();
    $errorObj->setVar('error_title', 'Error 403 - Forbidden');
    $errorObj->setVar('error_statuscode', '403');
    $errorObj->setVar('error_text', '<p style="font-weight: bold; text-align: center;">You do not have permission to access the requested directory/file.</p>');
    $errorObj->setVar('error_showme', true);
    $errorObj->setVar('error_redirect', false);
    $errorObj->setVar('error_redirect_time', 3);
    $errorObj->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($errorObj))
        $msg = $msg . $errorObj->getHtmlErrors();
    unset($errorObj);
    //
    if (empty($msg))
        return $ret;
    else
        return $msg;
}

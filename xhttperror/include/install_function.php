<?php
/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( http://www.xoops.org )
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
 *  @copyright  Rota Lucio ( http://luciorota.altervista.org/xoops/ )
 *  @license    GNU General Public License v3.0 
 *  @package    xhttperror
 *  @author     Rota Lucio ( lucio.rota@gmail.com )
 *
 *  $Rev$:     Revision of last commit
 *  $Author$:  Author of last commit
 *  $Date$:    Date of last commit
 * ****************************************************************************
 */

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

function xoops_module_pre_install_xhttperror(&$xoopsModule) {
    // Check if this XOOPS version is supported
    $minSupportedVersion = explode('.', '2.5.5');
    $currentVersion = explode('.', substr(XOOPS_VERSION,6));
    if($currentVersion[0] > $minSupportedVersion[0]) {
        return true;
    } elseif($currentVersion[0] == $minSupportedVersion[0]) {
        if($currentVersion[1] > $minSupportedVersion[1]) {
            return true;
        } elseif($currentVersion[1] == $minSupportedVersion[1]) {
            if($currentVersion[2] > $minSupportedVersion[2]) {
                return true;
            } elseif ($currentVersion[2] == $minSupportedVersion[2]) {
                return true;
            }
        }
    }
    return false;
}

function xoops_module_install_xhttperror(&$xoopsModule) {
    xoops_loadLanguage('modinfo', $xoopsModule->getVar('dirname'));
    include_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/include/functions.php';

    $ret = true;
    $msg = '';
    // load classes
    $errorHandler =& xoops_getModuleHandler('error', 'xhttperror');
    $error = $errorHandler->create();
    $error->setVar('error_title', 'Error 404 - Document Not Found');
    $error->setVar('error_statuscode', '404');
    $error->setVar('error_text', '<p style="font-weight: bold; text-align: center">The page you requested could not be found.</p><p>You may not be able to find the requested page because:</p><ul><li>The page no longer exists.</li><li>The address/page name was mis-typed.</li><li>You followed an incorrect, or out of date link on another site.</li><li>You followed an out of date search engine listing, or personal bookmark/favourite.</li></ul><p>Please try visiting the <a href="/">home page</a>, or use the search function below to find the page you were after.</p>');
    $error->setVar('error_showme', true);
    $error->setVar('error_redirect', false);
    $error->setVar('error_redirect_time', 3);
    $error->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($error))
        $msg = $msg . $error->getHtmlErrors();
    unset($error);
    $error = $errorHandler->create();
    $error->setVar('error_title', 'Error 500 - Server error');
    $error->setVar('error_statuscode', '500');
    $error->setVar('error_text', '<p style="font-weight: bold; text-align: center;">The server encountered an internal error and was unable to complete your request.</p>');
    $error->setVar('error_showme', true);
    $error->setVar('error_redirect', false);
    $error->setVar('error_redirect_time', 3);
    $error->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($error))
        $msg = $msg . $error->getHtmlErrors();
    unset($error);
    $error = $errorHandler->create();
    $error->setVar('error_title', 'Error 403 - Forbidden');
    $error->setVar('error_statuscode', '403');
    $error->setVar('error_text', '<p style="font-weight: bold; text-align: center;">You do not have permission to access the requested directory/file.</p>');
    $error->setVar('error_showme', true);
    $error->setVar('error_redirect', false);
    $error->setVar('error_redirect_time', 3);
    $error->setVar('error_redirect_uri', XOOPS_URL);
    if(!$errorHandler->insert($error))
        $msg = $msg . $error->getHtmlErrors();
    unset($error);
    if (empty($msg))
        return $ret;
    else
        return $msg;
}

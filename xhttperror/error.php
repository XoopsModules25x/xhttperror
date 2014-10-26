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
 * @package         xhttperror
 * @since           1.00
 * @author          Xoops Development Team
 * @version         svn:$id$
 */

$currentFile = basename(__FILE__);
include __DIR__ . '/header.php';

$myts = MyTextSanitizer::getInstance();

$xoopsOption['template_main'] = "{$xhttperror->getModule()->dirname()}_error.tpl";
include_once XOOPS_ROOT_PATH . '/header.php';

$uid = (is_object($xoopsUser) && isset($xoopsUser)) ? $xoopsUser->uid() : 0;
$groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : array(0 => XOOPS_GROUP_ANONYMOUS);

if (!isset($_GET['error'])) {
    $xoopsTpl->assign('message', "No error defined.");
} else {
    // Save error info to database
    // We may want to turn this off on busy sites.
    if ($xhttperror->getConfig('error_reporting') == false) {
        if (!(is_object($xoopsUser) && isset($xoopsUser)) || ($xoopsUser->isAdmin($xhttperror->getModule()->mid()) && $xhttperror->getConfig('ignore_admin') != true)) {
            // create report
            $serverVars = array();
            $serverVars['HTTP_REFERER'] = xoops_getenv('HTTP_REFERER');
            $serverVars['REMOTE_ADDR'] = xoops_getenv('REMOTE_ADDR');
            //$serverVars[''] =
            $referer = xoops_getenv('HTTP_REFERER');
            $userAgent = xoops_getenv('HTTP_USER_AGENT');
            $remoteAddr	= xoops_getenv('REMOTE_ADDR');
            $requestedUri = '';
            if (isset($_SERVER['REDIRECT_URL'])) {
                $requestedUri .= $_SERVER['REDIRECT_URL'];
            }
            if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
                $requestedUri .= '?' . $_SERVER['REDIRECT_QUERY_STRING'];
            }
            // create error object
            $reportObj = $xhttperror->getHandler('report')->create();
            //
            $reportObj->setVar('report_uid', $uid);
            $reportObj->setVar('report_statuscode', $_GET['error']);
            $reportObj->setVar('report_date', time());
            $reportObj->setVar('report_referer', $referer);
            $reportObj->setVar('report_useragent', $userAgent);
            $reportObj->setVar('report_remoteaddr', $remoteAddr);
            $reportObj->setVar('report_requesteduri', $requestedUri);
            // store error object
            if($xhttperror->getHandler('report')->insert($reportObj)) {
                // NOP
            } else {
                // ERROR
                xoops_cp_header();
                echo $reportObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        }
    }
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('error_statuscode', $_GET['error']));
    $criteria->add(new Criteria('error_showme', true));
    if ($errorObjs = $xhttperror->getHandler('error')->getObjects($criteria)) {
        $errorObj = $errorObjs[0];
        $id = $errorObj->getVar('error_id');
        $title = $myts->displayTarea($errorObj->getVar('error_title'));
        //$text = $errorObj->getVar('error_text', 'n');
        // displayTarea ($text, $html=0, $smiley=1, $xcode=1, $image=1, $br=1)
        $text = $myts->displayTarea($errorObj->getVar('error_text', 'n'), $errorObj->getVar('error_text_html'), $errorObj->getVar('error_text_smiley'), 1, 1, $errorObj->getVar('error_text_breaks'));
        
        // Add custom title to page title - "<{$xoops_pagetitle}>" - titleaspagetitle
        if ($xhttperror->getConfig('title_as_page_title') == 1) {
            $xoopsTpl->assign('xoops_pagetitle', $xhttperror->getModule()->getVar('name').' - '. $title); // module name - article title
        }
        if ($xhttperror->getConfig('title_as_page_title') == 2) {
            $xoopsTpl->assign('xoops_pagetitle', $title.' - '. $xhttperror->getModule()->getVar('name')); // article title -  module name
        }
        $xoopsTpl->assign('title', $title);
        $xoopsTpl->assign('text', $text);
        $xoopsTpl->assign('showsearch', true); // IN PROGRESS: True if show search form in error page
        $xoopsTpl->assign('redirect', $errorObj->getVar('error_redirect'));
        $xoopsTpl->assign('redirect_time', (int) $errorObj->getVar('error_redirect_time') * 1000);
        $xoopsTpl->assign('redirect_uri', $errorObj->getVar('error_redirect_uri'));
    }
}
include XOOPS_ROOT_PATH . '/footer.php';

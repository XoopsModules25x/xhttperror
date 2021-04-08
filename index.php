<?php declare(strict_types=1);

use XoopsModules\Xhttperror\{
    Helper
};
/** @var Helper $helper */

// inludes and stuff
require_once __DIR__ . '/header.php';

$GLOBALS['xoopsOption']['template_main'] = 'xhttperror_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$helper = Helper::getInstance();

//require 'include/functions.php';
$myts = \MyTextSanitizer::getInstance();

// load classes
$errorHandler  = $helper->getHandler('Error');
$reportHandler = $helper->getHandler('Report');

if (!isset($_GET['error'])) {
    $xoopsTpl->assign('message', 'No error defined.');
} else {
    // Save error info to database
    // We may want to turn this off on busy sites.
    if (false == $helper->getConfig('error_reporting')) {
        if (!$xoopsUser || ($xoopsUser->isAdmin($GLOBALS['xoopsModule']->mid()) && true != $helper->getConfig('ignore_admin'))) {
            // create report
            $serverVars                 = [];
            $serverVars['HTTP_REFERER'] = xoops_getenv('HTTP_REFERER');
            $serverVars['REMOTE_ADDR']  = xoops_getenv('REMOTE_ADDR');
            //$serverVars[''] =
            $referer      = $_GET['HTTP_REFERER'] ?? xoops_getenv('HTTP_REFERER');
            $useragent    = xoops_getenv('HTTP_USER_AGENT');
            $remoteaddr   = $_GET['REMOTE_ADDR'] ?? xoops_getenv('REMOTE_ADDR');
            $requesteduri = $_GET['REQUEST_URI'] ?? xoops_getenv('REQUEST_URI');

            if (empty($xoopsUser)) {
                $uid = 0; // anonymous
            } else {
                $uid = $xoopsUser->getVar('uid');
            }
            $reportObj = $reportHandler->create();
            $reportObj->setVar('report_uid', $uid);
            $reportObj->setVar('report_statuscode', $_GET['error']);
            $reportObj->setVar('report_date', time());
            $reportObj->setVar('report_referer', $referer);
            $reportObj->setVar('report_useragent', $useragent);
            $reportObj->setVar('report_remoteaddr', $remoteaddr);
            $reportObj->setVar('report_requesteduri', $requesteduri);
            if ($reportHandler->insert($reportObj)) {
                // NOP
            }
            // NOP
        }
    }

    $errorCriteria = new \CriteriaCompo();
    $errorCriteria->add(new \Criteria('error_statuscode', $_GET['error']));
    $errorCriteria->add(new \Criteria('error_showme', true));
    $errorObjs = $errorHandler->getObjects($errorCriteria);
    if ($errorObjs) {
        $errorObj = $errorObjs[0];
        $id    = $errorObj->getVar('error_id');
        $title = $myts->displayTarea($errorObj->getVar('error_title'));
        //$text = $errorObj->getVar('error_text', 'n');
        // displayTarea ($text, $html=0, $smiley=1, $xcode=1, $image=1, $br=1)
        $text = $myts->displayTarea($errorObj->getVar('error_text', 'n'), $errorObj->getVar('error_text_html'), $errorObj->getVar('error_text_smiley'), 1, 1, $errorObj->getVar('error_text_breaks'));

        // Add custom title to page title - "<{$xoops_pagetitle}>" - titleaspagetitle
        if (1 == $helper->getConfig('title_as_page_title')) {
            $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $GLOBALS['xoopsModule']->getVar('name') . ' - ' . $title); // module name - article title
        }
        if (2 == $helper->getConfig('title_as_page_title')) {
            $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $title . ' - ' . $GLOBALS['xoopsModule']->getVar('name')); // article title -  module name
        }

        $GLOBALS['xoopsTpl']->assign('title', $title);
        $GLOBALS['xoopsTpl']->assign('text', $text);
        $GLOBALS['xoopsTpl']->assign('showsearch', true); // IN PROGRESS: True if show search form in error page
        $GLOBALS['xoopsTpl']->assign('redirect', $errorObj->getVar('error_redirect'));
        $GLOBALS['xoopsTpl']->assign('redirect_time', (int)$errorObj->getVar('error_redirect_time') * 1000);
        $GLOBALS['xoopsTpl']->assign('redirect_uri', $errorObj->getVar('error_redirect_uri'));
    }
}
require_once XOOPS_ROOT_PATH . '/footer.php';

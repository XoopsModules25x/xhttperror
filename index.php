<?php

use XoopsModules\Xhttperror;

// inludes and stuff
require_once __DIR__ . '/header.php';
require_once XOOPS_ROOT_PATH . '/header.php';

/** @var Xhttperror\Helper $helper */
$helper = Xhttperror\Helper::getInstance();

//require 'include/functions.php';
$myts = \MyTextSanitizer::getInstance();

// load classes
$errorHandler  = $helper->getHandler('Error');
$reportHandler = $helper->getHandler('Report');

$GLOBALS['xoopsOption']['template_main'] = 'xhttperror_index.tpl';

if (!isset($_GET['error'])) {
    $xoopsTpl->assign('message', 'No error defined.');
} else {
    // Save error info to database
    // We may want to turn this off on busy sites.
    if (false == $helper->getConfig('error_reporting')) {
        if (!$xoopsUser || ($xoopsUser->isAdmin($xoopsModule->mid()) && true != $helper->getConfig('ignore_admin'))) {
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
            $report = $reportHandler->create();
            $report->setVar('report_uid', $uid);
            $report->setVar('report_statuscode', $_GET['error']);
            $report->setVar('report_date', time());
            $report->setVar('report_referer', $referer);
            $report->setVar('report_useragent', $useragent);
            $report->setVar('report_remoteaddr', $remoteaddr);
            $report->setVar('report_requesteduri', $requesteduri);
            if ($reportHandler->insert($report)) {
                // NOP
            }
            // NOP
        }
    }

    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('error_statuscode', $_GET['error']));
    $criteria->add(new \Criteria('error_showme', true));
    $errors = $errorHandler->getObjects($criteria);
    if ($errors) {
        $error = $errors[0];
        $id    = $error->getVar('error_id');
        $title = $myts->displayTarea($error->getVar('error_title'));
        //$text = $error->getVar('error_text', 'n');
        // displayTarea ($text, $html=0, $smiley=1, $xcode=1, $image=1, $br=1)
        $text = $myts->displayTarea($error->getVar('error_text', 'n'), $error->getVar('error_text_html'), $error->getVar('error_text_smiley'), 1, 1, $error->getVar('error_text_breaks'));

        // Add custom title to page title - "<{$xoops_pagetitle}>" - titleaspagetitle
        if (1 == $helper->getConfig('title_as_page_title')) {
            $xoopsTpl->assign('xoops_pagetitle', $xoopsModule->getVar('name') . ' - ' . $title); // module name - article title
        }
        if (2 == $helper->getConfig('title_as_page_title')) {
            $xoopsTpl->assign('xoops_pagetitle', $title . ' - ' . $xoopsModule->getVar('name')); // article title -  module name
        }

        $xoopsTpl->assign('title', $title);
        $xoopsTpl->assign('text', $text);
        $xoopsTpl->assign('showsearch', true); // IN PROGRESS: True if show search form in error page
        $xoopsTpl->assign('redirect', $error->getVar('error_redirect'));
        $xoopsTpl->assign('redirect_time', (int)$error->getVar('error_redirect_time') * 1000);
        $xoopsTpl->assign('redirect_uri', $error->getVar('error_redirect_uri'));
    }
}
require_once XOOPS_ROOT_PATH . '/footer.php';

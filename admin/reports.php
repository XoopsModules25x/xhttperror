<?php

/**
 * ****************************************************************************
 *  - A Project by Developers TEAM For Xoops - ( https://xoops.org )
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
 * @copyright  Rota Lucio ( http://luciorota.altervista.org/xoops/ )
 * @license    GNU General Public License v3.0
 * @package    xhttperror
 * @author     Rota Lucio ( lucio.rota@gmail.com )
 *
 *  $Rev$:     Revision of last commit
 *  $Author$:  Author of last commit
 *  $Date$:    Date of last commit
 * ****************************************************************************
 */
$currentFile = basename(__FILE__);
require_once __DIR__ . '/admin_header.php';
$op = $_REQUEST['op'] ?? 'list_reports';

// load classes
$reportHandler = $helper->getHandler('Report');

// count reports
$countReports = $reportHandler->getCount();

switch ($op) {
    /*
     * list reports
     */
    default:
    case 'list_reports':
        // render start here
        xoops_cp_header();
        // render submenu
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        if ($countReports > 0) {
            $reportCriteria = new \CriteriaCompo();
            $reportCriteria->setSort('report_date');
            $reportCriteria->setOrder('ASC');
            $reportCriteria->setLimit($GLOBALS['xoopsModuleConfig']['reports_per_page']);
            $reports = $reportHandler->getObjects($reportCriteria, true, false); // as array
            foreach ($reports as $key => $report) {
                $reports[$key]['report_user'] = \XoopsUserUtility::getUnameFromId($report['report_uid'], false, true);
                $reports[$key]['report_date'] = formatTimestamp($report['report_date'], _DATESTRING);
            }

            $GLOBALS['xoopsTpl']->assign('reports', $reports);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
            $GLOBALS['xoopsTpl']->display('db:xhttperror_admin_reports_list.tpl');
        } else {
            echo _AM_XHTTPERR_REPORT_NOREPORTS;
        }
        require_once __DIR__ . '/admin_footer.php';
        break;

    /*
     * delete report
     */
    case 'delete_report':
        /** @var int $report_id */
        $report_id = \Xmf\Request::getInt('report_id', 0);
        $reportObj = $reportHandler->get($report_id);
        // check: confirm
        if (true === \Xmf\Request::getBool('ok', false, 'POST')) {
            // check: token
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // db: delete report
            if ($reportHandler->delete($reportObj)) {
                redirect_header($currentFile, 3, _AM_XHTTPERR_DELETEDSUCCESS);
            } else {
                echo $reportObj->getHtmlErrors();
            }
        } else {
            $hiddens = [];
            $hiddens['ok'] = true;
            $hiddens['op'] = $op;
            $hiddens['report_id'] = $report_id;
            // render start here
            xoops_cp_header();
            xoops_confirm(
                ['ok' => 1, 'report_id' => $_REQUEST['report_id'], 'op' => 'delete_report'], 
                $_SERVER['REQUEST_URI'], 
                sprintf(_AM_XHTTPERR_REPORT_RUSUREDEL, $report->getVar('report_id'))
            );
            xoops_cp_footer();
        }
        break;
        
    /*
     * delete reports
     */
    case 'delete_reports':
        /** @var array $report_ids */
        $report_ids = \Xmf\Request::getArray('report_ids', array());
        // check: confirm
        if (true === \Xmf\Request::getBool('ok', false, 'POST')) {
            // check: token
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // db: delete reports
            $reportCriteria = new CriteriaCompo();
            $reportCriteria->add(new Criteria('report_id', '(' . implode(',', $report_ids) . ')', 'IN'));
            if ($reportHandler->deleteAll($reportCriteria, true)) {
                redirect_header($currentFile, 3, _AM_XHTTPERR_DELETEDSUCCESS);
            } else {
                // ERROR
                exit();
            }
        } else {
            $hiddens = [];
            $hiddens['ok'] = true;
            $hiddens['op'] = $op;
            foreach ($report_ids as $report_id => $value) {
                $hiddens["report_ids['{$report_id}']"] = "{$report_id}";
            }
            // render start here
            xoops_cp_header();
            xoops_confirm(
                $hiddens,
                $_SERVER['REQUEST_URI'],
                sprintf(_AM_XHTTPERR_REPORT_RUSUREDEL, implode(',', $report_ids)),
                _DELETE
            );
            xoops_cp_footer();
        }
        break;
}

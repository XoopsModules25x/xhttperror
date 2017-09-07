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
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list_reports';

// load classes
$reportHandler = xoops_getModuleHandler('report', 'xhttperror');

// count reports
$countReports = $reportHandler->getCount();

switch ($op) {
    default:
    case 'list_reports':
        // render start here
        xoops_cp_header();
        // render submenu
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));

        if ($countReports > 0) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('report_date');
            $criteria->setOrder('ASC');
            $criteria->setLimit($GLOBALS['xoopsModuleConfig']['reports_per_page']);
            $reports = $reportHandler->getObjects($criteria, true, false);
            foreach ($reports as $key => $report) {
                $reports[$key]['report_user'] = XoopsUserUtility::getUnameFromId($report['report_uid'], false, true);
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

    case 'delete_report':
        $report =& $reportHandler->get($_REQUEST['report_id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($reportHandler->delete($report)) {
                redirect_header($currentFile, 3, _AM_XHTTPERR_DELETEDSUCCESS);
            } else {
                echo $report->getHtmlErrors();
            }
        } else {
            // render start here
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'report_id' => $_REQUEST['report_id'], 'op' => 'delete_report'], $_SERVER['REQUEST_URI'], sprintf(_AM_XHTTPERR_REPORT_RUSUREDEL, $report->getVar('report_id')));
            xoops_cp_footer();
        }
        break;
}

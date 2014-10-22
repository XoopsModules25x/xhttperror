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

$currentFile = basename(__FILE__);
include 'admin_header.php';

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'list_reports';
switch($op ) {
    default:
    case 'list_reports' :
        // render start here
        xoops_cp_header();
        // render submenu
        $modcreate_admin = new ModuleAdmin();
        echo $modcreate_admin->addNavigation('reports.php');

        $reportCount = $xhttperror->getHandler('report')->getCount();
        if($reportCount > 0) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('report_date');
            $criteria->setOrder('ASC');
            $criteria->setLimit($xhttperror->getConfig('reports_perpage'));
            $reportObjs = $xhttperror->getHandler('report')->getObjects($criteria, true, false);
            foreach ($reportObjs as $key => $reportObj) {
                $reportObjs[$key]['report_user'] = XoopsUserUtility::getUnameFromId($reportObj['report_uid'], false, true);
                $reportObjs[$key]['report_date'] = formatTimeStamp($reportObj['report_date'], _DATESTRING);
            }
            $GLOBALS['xoopsTpl']->assign('reports', $reportObjs);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML() );
            $GLOBALS['xoopsTpl']->display("db:{$xhttperror->getModule()->dirname()}_admin_reports_list.html");
        } else {
            echo _AM_XHTTPERROR_REPORT_NOREPORTS;
        }
        include "admin_footer.php";
        break;
    case 'delete_report' :
        $reportObj = $xhttperror->getHandler('report')->get($_REQUEST['report_id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ( !$GLOBALS['xoopsSecurity']->check()  ) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ( $xhttperror->getHandler('report')->delete($reportObj)) {
                redirect_header($currentFile, 3, _AM_XHTTPERROR_DELETEDSUCCESS );
            } else {
                echo $reportObj->getHtmlErrors();
            }
        } else {
            // render start here
            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'report_id' => $_REQUEST['report_id'], 'op' => 'delete_report'), $_SERVER['REQUEST_URI'], sprintf(_AM_XHTTPERROR_REPORT_RUSUREDEL, $reportObj->getVar('report_id')));
            xoops_cp_footer();
        }
        break;
}

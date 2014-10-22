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

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : (isset($_REQUEST['error_id']) ? "edit_error" : 'list_errors');
switch($op ) {
    default:
    case 'list_errors' :
        // render start here
        xoops_cp_header();
        // render submenu
        $modcreate_admin = new ModuleAdmin();
        echo $modcreate_admin->addNavigation('errors.php');
        $modcreate_admin->addItemButton(_AM_XHTTPERROR_ERROR_ADD, '' . $currentFile . '?op=edit_error', 'add');
        echo $modcreate_admin->renderButton();

        $errorCount = $xhttperror->getHandler('error')->getCount();
        if($errorCount > 0) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('error_statuscode');
            $criteria->setOrder('ASC');
            $errorObjs = $xhttperror->getHandler('error')->getObjects($criteria, true, false);

            $GLOBALS['xoopsTpl']->assign('errors', $errorObjs);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML() );
            $GLOBALS['xoopsTpl']->display("db:{$xhttperror->getModule()->dirname()}_admin_errors_list.tpl");
        } else {
            echo _AM_XHTTPERROR_ERROR_NOERRORS;
        }
        
        include "admin_footer.php";
        break;

    case 'edit_error' :
    case 'new_error' :
        // render start here
        xoops_cp_header();
        // render submenu
        $modcreate_admin = new ModuleAdmin();
        echo $modcreate_admin->addNavigation('errors.php');
        $modcreate_admin->addItemButton(_AM_XHTTPERROR_ERROR_LIST, '' . $currentFile . '?op=list_errors', 'list');
        echo $modcreate_admin->renderButton();

        if (isset($_REQUEST['error_id'])) {
            $errorObj = $xhttperror->getHandler('error')->get($_REQUEST['error_id']);
        } else {
            $errorObj = $xhttperror->getHandler('error')->create();
        
        }
        $form = $errorObj->getForm();
        $form->display();
        
        include "admin_footer.php";
        break;

    case 'save_error' :
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ( isset($_REQUEST['error_id'])  ) {
            $errorObj = $xhttperror->getHandler('error')->get($_REQUEST['error_id']);
        } else {
            $errorObj = $xhttperror->getHandler('error')->create();
        }
        // Check statuscode
        if ( isset($_REQUEST['error_statuscode'])  ) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('error_statuscode', $_REQUEST['error_statuscode']));
            if ($xhttperror->getHandler('error')->getCount($criteria) > 0) {
                redirect_header($currentFile, 3, _AM_XHTTPERROR_STATUSCODE_EXISTS );
            } else {
                $errorObj->setVar('error_statuscode', $_REQUEST['error_statuscode']);
            }
        }
        $errorObj->setVar('error_title', $_REQUEST['error_title']);
        $errorObj->setVar('error_text', $_REQUEST['error_text']);
        $errorObj->setVar('error_text_html', $_REQUEST['error_text_html']);
        $errorObj->setVar('error_text_smiley', $_REQUEST['error_text_smiley']);
        $errorObj->setVar('error_text_breaks', $_REQUEST['error_text_breaks']);
        $errorObj->setVar('error_showme', $_REQUEST['error_showme']);
        $errorObj->setVar('error_redirect', $_REQUEST['error_redirect']);
        $errorObj->setVar('error_redirect_time', (int)$_REQUEST['error_redirect_time']);
        /* IN PROGRESS
        $errorObj->setVar('error_redirect_message', (int)$_REQUEST['error_redirect_message']);
        */
        $errorObj->setVar('error_redirect_uri', $_REQUEST['error_redirect_uri']);

        if ( $xhttperror->getHandler('error')->insert($errorObj)  ) {
            redirect_header($currentFile, 3, _AM_XHTTPERROR_SAVEDSUCCESS );
        } else {
            redirect_header($currentFile, 3, _AM_XHTTPERROR_NOTSAVED );
        }
        break;

    case 'delete_error' :
        $errorObj = $xhttperror->getHandler('error')->get($_REQUEST['error_id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($xhttperror->getHandler('error')->delete($errorObj)) {
                redirect_header($currentFile, 3, _AM_XHTTPERROR_DELETEDSUCCESS);
            } else {
                echo $errorObj->getHtmlErrors();
            }
        } else {
            // render start here
            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'error_id' => $_REQUEST['error_id'], 'op' => 'delete_error'), $_SERVER['REQUEST_URI'], sprintf(_AM_XHTTPERROR_ERROR_RUSUREDEL, $errorObj->getVar('error_title')));
            xoops_cp_footer();
        }
        break;
}

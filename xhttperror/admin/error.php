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

$currentFile = basename(__FILE__);
include_once __DIR__ . '/admin_header.php';

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : (isset($_REQUEST['error_id']) ? 'edit_error' : 'list_errors');
switch($op ) {
    default:
    case 'list_errors':
        // render start here
        xoops_cp_header();
        // render submenu
        $modcreate_admin = new ModuleAdmin();
        echo $modcreate_admin->addNavigation($currentFile);
        $modcreate_admin->addItemButton(_CO_XHTTPERROR_BUTTON_ERROR_ADD, '' . $currentFile . '?op=edit_error', 'add');
        echo $modcreate_admin->renderButton();
        //
        $errorCount = $xhttperror->getHandler('error')->getCount();
        if($errorCount > 0) {
            $criteria = new CriteriaCompo();
            $criteria->setSort('error_statuscode');
            $criteria->setOrder('ASC');
            $errors = $xhttperror->getHandler('error')->getObjects($criteria, true, false); // as array
            $GLOBALS['xoopsTpl']->assign('errors', $errors);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML() );
            $GLOBALS['xoopsTpl']->display("db:{$xhttperror->getModule()->dirname()}_admin_errors_list.tpl");
        } else {
            echo _CO_XHTTPERROR_WARNING_NOERRORS;
        }
        include __DIR__ . '/admin_footer.php';
        break;

    case 'edit_error':
    case 'new_error':
        // render start here
        xoops_cp_header();
        // render submenu
        $modcreate_admin = new ModuleAdmin();
        echo $modcreate_admin->addNavigation($currentFile);
        $modcreate_admin->addItemButton(_CO_XHTTPERROR_BUTTON_ERRORS_LIST, '' . $currentFile . '?op=list_errors', 'list');
        echo $modcreate_admin->renderButton();
        //
        $error_id = XhttperrorRequest::getInt('error_id', 0);
        $errorObj = $xhttperror->getHandler('error')->get($error_id);
        if (!$errorObj) {
            // ERROR
            redirect_header($currentFile, 3, _CO_XHTTPERROR_ERROR_NOERROR);
            exit();
        }
        $form = $errorObj->getForm();
        $form->display();
        //
        include __DIR__ . '/admin_footer.php';
        break;

    case 'save_error':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $error_id = XhttperrorRequest::getInt('error_id', 0, 'POST');
        $isNewError = ($error_id == 0) ? true : false;
        $errorObj = $module_skeleton->getHandler('error')->get($error_id);
        // Check statuscode
        if (isset($_REQUEST['error_statuscode'])) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('error_statuscode', $_REQUEST['error_statuscode']));
            if ($xhttperror->getHandler('error')->getCount($criteria) > 0) {
                redirect_header($currentFile, 3, _AM_XHTTPERROR_STATUSCODE_EXISTS); // IN PROGRESS
            } else {
                $errorObj->setVar('error_statuscode', $_REQUEST['error_statuscode']);
            }
        }
        $error_title = XhttperrorRequest::getString('error_title', '', 'POST');
        $error_text = XhttperrorRequest::getString('error_text', '', 'POST');
        $error_text_html = XhttperrorRequest::getString('error_text_html', '', 'POST');
        //
        $errorObj->setVar('error_title', $error_title);
        $errorObj->setVar('error_text', $error_text);
        $errorObj->setVar('error_text_html', $error_text_html);
        $errorObj->setVar('error_text_smiley', $_REQUEST['error_text_smiley']);
        $errorObj->setVar('error_text_breaks', $_REQUEST['error_text_breaks']);
        $errorObj->setVar('error_showme', $_REQUEST['error_showme']);
        $errorObj->setVar('error_redirect', $_REQUEST['error_redirect']);
        $errorObj->setVar('error_redirect_time', (int) $_REQUEST['error_redirect_time']);
        /* IN PROGRESS
        $errorObj->setVar('error_redirect_message', (int)$_REQUEST['error_redirect_message']);
        */
        $errorObj->setVar('error_redirect_uri', $_REQUEST['error_redirect_uri']);
        if ($xhttperror->getHandler('error')->insert($errorObj)) {
            redirect_header($currentFile, 3, _CO_XHTTPERROR_ERROR_STORED);
        } else {
            // ERROR
            xoops_cp_header();
            echo $errorObj->getHtmlErrors();
            xoops_cp_footer();
            exit();
        }
        break;

    case 'delete_error':
        $error_id = XhttperrorRequest::getInt('error_id', 0);
        $errorObj = $xhttperror->getHandler('error')->get($error_id);
        if (!$errorObj) {
            // ERROR
            redirect_header($currentFile, 3, _CO_XHTTPERROR_ERROR_NOERROR);
            exit();
        }
        if (XhttperrorRequest::getBool('ok', false, 'POST') == true) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($xhttperror->getHandler('error')->delete($errorObj)) {
                redirect_header($currentFile, 3, _CO_XHTTPERROR_ERROR_DELETED);
            } else {
                // ERROR
                xoops_cp_header();
                echo $errorObj->getHtmlErrors();
                xoops_cp_footer();
                exit();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(
                array('ok' => true, 'op' => 'delete_error', 'error_id' => $error_id),
                $_SERVER['REQUEST_URI'],
                _CO_XHTTPERROR_ERROR_DELETE_AREUSURE,
                _DELETE
            );
            xoops_cp_footer();
        }
        break;
}

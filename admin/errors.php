<?php declare(strict_types=1);

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
$op = $_REQUEST['op'] ?? (isset($_REQUEST['error_id']) ? 'edit_error' : 'list_errors');

// load classes
$errorHandler = $helper->getHandler('Error');
$reportHandler = $helper->getHandler('Report');

// count errors
$countErrors = $errorHandler->getCount();

switch ($op) {
    default:
    case 'list_errors':
        // render start here
        xoops_cp_header();
        // render submenu
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_XHTTPERR_ERROR_ADD, '' . $currentFile . '?op=edit_error', 'add');
        $adminObject->displayButton('left');

        if ($countErrors > 0) {
            $criteria = new \CriteriaCompo();
            $criteria->setSort('error_statuscode');
            $criteria->setOrder('ASC');
            $errors = $errorHandler->getObjects($criteria, true, false);

            $GLOBALS['xoopsTpl']->assign('errors', $errors);
            $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
            $GLOBALS['xoopsTpl']->display('db:xhttperror_admin_errors_list.tpl');
        } else {
            echo _AM_XHTTPERR_ERROR_NOERRORS;
        }

        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'edit_error':
    case 'new_error':
        // render start here
        xoops_cp_header();
        // render submenu
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_XHTTPERR_ERROR_LIST, '' . $currentFile . '?op=list_errors', 'list');
        $adminObject->displayButton('left');

        if (\Xmf\Request::hasVar('error_id', 'REQUEST')) {
            $error = $errorHandler->get($_REQUEST['error_id']);
        } else {
            $error = $errorHandler->create();
        }
        $form = $error->getForm();
        $form->display();

        require_once __DIR__ . '/admin_footer.php';
        break;
    case 'save_error':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (\Xmf\Request::hasVar('error_id', 'REQUEST')) {
            $error = $errorHandler->get($_REQUEST['error_id']);
        } else {
            $error = $errorHandler->create();
        }
        // Check statuscode
        if (\Xmf\Request::hasVar('error_statuscode', 'REQUEST')) {
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('error_statuscode', $_REQUEST['error_statuscode']));
            if ($errorHandler->getCount($criteria) > 0) {
                redirect_header($currentFile, 3, _AM_XHTTPERR_STATUSCODE_EXISTS);
            } else {
                $error->setVar('error_statuscode', $_REQUEST['error_statuscode']);
            }
        }
        $error->setVar('error_title', $_REQUEST['error_title']);
        $error->setVar('error_text', $_REQUEST['error_text']);
        $error->setVar('error_text_html', $_REQUEST['error_text_html']);
        $error->setVar('error_text_smiley', $_REQUEST['error_text_smiley']);
        $error->setVar('error_text_breaks', $_REQUEST['error_text_breaks']);
        $error->setVar('error_showme', $_REQUEST['error_showme']);
        $error->setVar('error_redirect', $_REQUEST['error_redirect']);
        $error->setVar('error_redirect_time', \Xmf\Request::getInt('error_redirect_time', 0, 'REQUEST'));
        /* IN PROGRESS
        $error->setVar('error_redirect_message', (int) $_REQUEST['error_redirect_message']);
        */
        $error->setVar('error_redirect_uri', $_REQUEST['error_redirect_uri']);

        if ($errorHandler->insert($error)) {
            redirect_header($currentFile, 3, _AM_XHTTPERR_SAVEDSUCCESS);
        } else {
            redirect_header($currentFile, 3, _AM_XHTTPERR_NOTSAVED);
        }
        break;
    case 'delete_error':
        $error = $errorHandler->get($_REQUEST['error_id']);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header($currentFile, 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($errorHandler->delete($error)) {
                redirect_header($currentFile, 3, _AM_XHTTPERR_DELETEDSUCCESS);
            } else {
                echo $error->getHtmlErrors();
            }
        } else {
            // render start here
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'error_id' => $_REQUEST['error_id'], 'op' => 'delete_error'], $_SERVER['REQUEST_URI'], sprintf(_AM_XHTTPERR_ERROR_RUSUREDEL, $error->getVar('error_title')));
            xoops_cp_footer();
        }
        break;
}

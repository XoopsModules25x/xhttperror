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

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

define('XHTTPERR_REDIRECT_NO', 0);
define('XHTTPERR_REDIRECT_URI', 1);
define('XHTTPERR_REDIRECT_PREVIOUS', 2);

class XhttperrorError extends XoopsObject
{
    // constructor
    public function __construct()
    {
        parent::__construct();
        $this->initVar('error_id', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('error_title', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('error_statuscode', XOBJ_DTYPE_TXTBOX, '000', true);
        $this->initVar('error_text', XOBJ_DTYPE_TXTAREA, null, false, '');
        $this->initVar('error_text_html', XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar('error_text_smiley', XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar('error_text_breaks', XOBJ_DTYPE_INT, false, false); // default: false
        $this->initVar('error_showme', XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar('error_redirect', XOBJ_DTYPE_INT, XHTTPERR_REDIRECT_NO, false); // default: XHTTPERR_REDIRECT_NO
        $this->initVar('error_redirect_time', XOBJ_DTYPE_INT, 3, false); // default: 3 seconds
        $this->initVar('error_redirect_message', XOBJ_DTYPE_TXTBOX, '', false); // IN PROGRESS
        $this->initVar('error_redirect_uri', XOBJ_DTYPE_URL, XOOPS_URL, false); // default XOOPS_URL
    }

    public function getForm($action = false)
    {
        global $xoopsDB, $xoopsModule, $xoopsModuleConfig;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $title = $this->isNew() ? sprintf(_AM_XHTTPERR_ERROR_ADD) : sprintf(_AM_XHTTPERR_ERROR_EDIT);

        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        $form = new XoopsThemeForm($title, 'form_error', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        // Title
        $errorTitle = new XoopsFormText(_AM_XHTTPERR_ERROR_TITLE, 'error_title', 40, 255, $this->getVar('error_title'));
        $errorTitle->setDescription(_AM_XHTTPERR_ERROR_TITLE_DESC);
        $form->addElement($errorTitle, true);
        unset($errorTitle);
        // Error number
        if ($this->isNew()) {
            $errorStatuscode = new XoopsFormText(_AM_XHTTPERR_ERROR_STATUSCODE, 'error_statuscode', 3, 3, $this->getVar('error_statuscode'));
        } else {
            $errorStatuscode = new XoopsFormLabel(_AM_XHTTPERR_ERROR_STATUSCODE, $this->getVar('error_statuscode'));
        }
        $form->addElement($errorStatuscode, true);
        unset($errorStatuscode);
        // Text
        $editor_configs           = [];
        $editor_configs['name']   = 'error_text';
        $editor_configs['value']  = $this->getVar('error_text', 'e');
        $editor_configs['rows']   = 10;
        $editor_configs['cols']   = 50;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '100px';
        $editor_configs['editor'] = $GLOBALS['xoopsModuleConfig']['text_editor'];
        $errorText                = new XoopsFormEditor(_AM_XHTTPERR_ERROR_TEXT, 'error_text', $editor_configs);
        $errorText->setDescription(_AM_XHTTPERR_ERROR_TEXT_DESC);
        $form->addElement($errorText);
        // Text options
        $errorTextOptions = new XoopsFormElementTray(_AM_XHTTPERR_ERROR_TEXT_OPTIONS, '|', '');
        $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERR_ERROR_TEXT_HTML, 'error_text_html', $this->getVar('error_text_html'), _YES, _NO));
        $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERR_ERROR_TEXT_SMILEY, 'error_text_smiley', $this->getVar('error_text_smiley'), _YES, _NO));
        $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERR_ERROR_TEXT_BREAKS, 'error_text_breaks', $this->getVar('error_text_breaks'), _YES, _NO));
        $errorTextOptions->setDescription(_AM_XHTTPERR_ERROR_TEXT_OPTIONS_DESC);
        $form->addElement($errorTextOptions);
        unset($errorTextOptions);
        // Showme
        $errorShowme = new XoopsFormRadioYN(_AM_XHTTPERR_ERROR_STATUS, 'error_showme', $this->getVar('error_showme'), _YES, _NO);
        $errorShowme->setDescription(_AM_XHTTPERR_ERROR_STATUS_DESC);
        $form->addElement($errorShowme);
        unset($errorShowme);

        $form->addElement(new XoopsFormLabel(_AM_XHTTPERR_ERROR_REDIRECT_OPTIONS, '', ''));
        // Redirect
        $errorRedirect = new XoopsFormSelect(_AM_XHTTPERR_ERROR_REDIRECT, 'error_redirect', $this->getVar('error_redirect'), 1, false);
        $errorRedirect->addOption(XHTTPERR_REDIRECT_NO, _AM_XHTTPERR_ERROR_REDIRECT_OPTION_NO);
        $errorRedirect->addOption(XHTTPERR_REDIRECT_URI, _AM_XHTTPERR_ERROR_REDIRECT_OPTION_URI);
        $errorRedirect->addOption(XHTTPERR_REDIRECT_PREVIOUS, _AM_XHTTPERR_ERROR_REDIRECT_OPTION_PREVIOUS);
        //$errorRedirect = new XoopsFormRadioYN(, _YES, _NO);
        $errorRedirect->setDescription(_AM_XHTTPERR_ERROR_REDIRECT_DESC);
        $form->addElement($errorRedirect);
        unset($errorRedirect);
        // Redirect time
        $errorRedirectTime = new XoopsFormText(_AM_XHTTPERR_ERROR_REDIRECT_TIME, 'error_redirect_time', 2, 2, $this->getVar('error_redirect_time'));
        $errorRedirectTime->setDescription(_AM_XHTTPERR_ERROR_REDIRECT_TIME_DESC);
        $form->addElement($errorRedirectTime);
        unset($errorRedirectTime);
        /* IN PROGRESS
        // Redirect message
            $errorRedirectMessage = new XoopsFormText(_AM_XHTTPERR_ERROR_REDIRECT_MESSAGE, 'error_redirect_message', 40, 255, $this->getVar('error_redirect_message'));
            $errorRedirectMessage->setDescription(_AM_XHTTPERR_ERROR_REDIRECT_MESSAGE_DESC);
        $form->addElement($errorRedirectMessage, true);
        unset($errorRedirectMessage);
        */
        // Redirect uri
        $errorRedirectUri = new XoopsFormText(_AM_XHTTPERR_ERROR_REDIRECT_URI, 'error_redirect_uri', 40, 255, $this->getVar('error_redirect_uri'));
        $errorRedirectUri->setDescription(_AM_XHTTPERR_ERROR_REDIRECT_URI_DESC);
        $form->addElement($errorRedirectUri);
        unset($errorRedirectUri);

        // Captcha
        xoops_load('xoopscaptcha');
        $form->addElement(new XoopsFormCaptcha(), true);
        // Hidden Fields
        $form->addElement(new XoopsFormHidden('op', 'save_error'));
        if ($this->isNew()) {
            // NOP
        } else {
            $form->addElement(new XoopsFormHidden('error_id', $this->getVar('error_id')));
        }
        // Submit button
        $button_tray = new XoopsFormElementTray(_AM_XHTTPERR_ACTION, '', '');
        $button_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $button_tray->addElement(new XoopsFormButton('', 'reset', _RESET, 'reset'));
        $cancel_button = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
        $cancel_button->setExtra("onclick='javascript:history.back();'");
        $button_tray->addElement($cancel_button);
        $form->addElement($button_tray);

        return $form;
    }
}

class XhttperrorErrorHandler extends XoopsPersistableObjectHandler
{
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'xhttperror_errors', 'xhttperrorerror', 'error_id', 'error_title');
    }
}

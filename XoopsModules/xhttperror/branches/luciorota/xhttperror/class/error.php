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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');
include_once dirname(__DIR__) . '/include/common.php';

define('XHTTPERROR_REDIRECT_NO', 0);
define('XHTTPERROR_REDIRECT_URI', 1);
define('XHTTPERROR_REDIRECT_PREVIOUS', 2);

/**
 * Class XhttperrorError
 */
class XhttperrorError extends XoopsObject
{ 
    /**
     * @var XhttperrorXhttperror
     * @access private
     */
    private $xhttperror = null;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->xhttperror = XhttperrorXhttperror::getInstance();
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->XoopsObject();
        //
        $this->initVar("error_id", XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar("error_title", XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar("error_statuscode", XOBJ_DTYPE_TXTBOX, '000', true);
        $this->initVar("error_text", XOBJ_DTYPE_TXTAREA, null, false, '');
        $this->initVar('error_text_html', XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar('error_text_smiley', XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar('error_text_breaks', XOBJ_DTYPE_INT, false, false); // default: false
        $this->initVar("error_showme", XOBJ_DTYPE_INT, true, false); // default: true
        $this->initVar("error_redirect", XOBJ_DTYPE_INT, XHTTPERROR_REDIRECT_NO, false); // default: XHTTPERROR_REDIRECT_NO
        $this->initVar("error_redirect_time", XOBJ_DTYPE_INT, 3, false); // default: 3 seconds
        $this->initVar("error_redirect_message", XOBJ_DTYPE_TXTBOX, '', false); // IN PROGRESS
        $this->initVar("error_redirect_uri", XOBJ_DTYPE_URL, XOOPS_URL, false); // default XOOPS_URL
    }

    function getForm($action = false)
    {
        include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
        //
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $title = $this->isNew() ? _CO_XHTTPERROR_BUTTON_ERROR_ADD : _CO_XHTTPERROR_BUTTON_ERROR_EDIT;
        //
        $form = new XoopsThemeForm($title, 'form_error', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // error: error_title
            $errorTitle = new XoopsFormText(_AM_XHTTPERROR_ERROR_TITLE, 'error_title', 40, 255, $this->getVar('error_title'));
            $errorTitle->setDescription(_AM_XHTTPERROR_ERROR_TITLE_DESC);
        $form->addElement($errorTitle, true);
        unset($errorTitle);
        // error: error_statuscode
        if ($this->isNew()) {
            $errorStatuscode = new XoopsFormText(_AM_XHTTPERROR_ERROR_STATUSCODE, 'error_statuscode', 3, 3, $this->getVar('error_statuscode'));
        } else {
            $errorStatuscode = new XoopsFormLabel (_AM_XHTTPERROR_ERROR_STATUSCODE, $this->getVar('error_statuscode'));
        }
        $form->addElement($errorStatuscode, true);
        unset($errorStatuscode);
        // error: error_text
        $editor_configs = array();
        $editor_configs["name"] = "error_text";
        $editor_configs["value"] = $this->getVar('error_text', 'e');
        $editor_configs["rows"] = 10;
        $editor_configs["cols"] = 50;
        $editor_configs["width"] = "100%";
        $editor_configs["height"] = "100px";
        $editor_configs["editor"] = $this->xhttperror->getConfig('text_editor');
        $errorText = new XoopsFormEditor(_AM_XHTTPERROR_ERROR_TEXT, "error_text", $editor_configs);
        $errorText->setDescription(_AM_XHTTPERROR_ERROR_TEXT_DESC);
        $form->addElement($errorText);
        // Text options
            $errorTextOptions = new XoopsFormElementTray (_AM_XHTTPERROR_ERROR_TEXT_OPTIONS, '|', '');
            $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERROR_ERROR_TEXT_HTML, 'error_text_html', $this->getVar('error_text_html'), _YES, _NO));
            $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERROR_ERROR_TEXT_SMILEY, 'error_text_smiley', $this->getVar('error_text_smiley'), _YES, _NO));
            $errorTextOptions->addElement(new XoopsFormRadioYN(_AM_XHTTPERROR_ERROR_TEXT_BREAKS, 'error_text_breaks', $this->getVar('error_text_breaks'), _YES, _NO));
            $errorTextOptions->setDescription(_AM_XHTTPERROR_ERROR_TEXT_OPTIONS_DESC);
        $form->addElement($errorTextOptions);
        unset($errorTextOptions);
        // error: error_showme
            $errorShowme = new XoopsFormRadioYN(_AM_XHTTPERROR_ERROR_STATUS, 'error_showme', $this->getVar('error_showme'), _YES, _NO);
            $errorShowme->setDescription(_AM_XHTTPERROR_ERROR_STATUS_DESC);
        $form->addElement($errorShowme);
        unset($errorShowme);
        //
        $form->addElement(new XoopsFormLabel(_AM_XHTTPERROR_ERROR_REDIRECT_OPTIONS, '', ''));
        // error: error_reditrect
            $errorRedirect = new XoopsFormSelect (_AM_XHTTPERROR_ERROR_REDIRECT, 'error_redirect', $this->getVar('error_redirect'), 1, false);
            $errorRedirect->addOption (XHTTPERROR_REDIRECT_NO, _AM_XHTTPERROR_ERROR_REDIRECT_OPTION_NO);
            $errorRedirect->addOption (XHTTPERROR_REDIRECT_URI, _AM_XHTTPERROR_ERROR_REDIRECT_OPTION_URI);
            $errorRedirect->addOption (XHTTPERROR_REDIRECT_PREVIOUS, _AM_XHTTPERROR_ERROR_REDIRECT_OPTION_PREVIOUS);
            //$errorRedirect = new XoopsFormRadioYN(, _YES, _NO);
            $errorRedirect->setDescription(_AM_XHTTPERROR_ERROR_REDIRECT_DESC);
        $form->addElement($errorRedirect);
        unset($errorRedirect);
        // error_redirect_time
            $errorRedirectTime = new XoopsFormText(_AM_XHTTPERROR_ERROR_REDIRECT_TIME, 'error_redirect_time', 2, 2, $this->getVar('error_redirect_time'));
            $errorRedirectTime->setDescription(_AM_XHTTPERROR_ERROR_REDIRECT_TIME_DESC);
        $form->addElement($errorRedirectTime);
        unset($errorRedirectTime);
        /* IN PROGRESS
        // Redirect message
            $errorRedirectMessage = new XoopsFormText(_AM_XHTTPERROR_ERROR_REDIRECT_MESSAGE, 'error_redirect_message', 40, 255, $this->getVar('error_redirect_message'));
            $errorRedirectMessage->setDescription(_AM_XHTTPERROR_ERROR_REDIRECT_MESSAGE_DESC);
        $form->addElement($errorRedirectMessage, true);
        unset($errorRedirectMessage);
        */
        // error: error_redirect_uri
            $errorRedirectUri = new XoopsFormText(_AM_XHTTPERROR_ERROR_REDIRECT_URI, 'error_redirect_uri', 40, 255, $this->getVar('error_redirect_uri'));
            $errorRedirectUri->setDescription(_AM_XHTTPERROR_ERROR_REDIRECT_URI_DESC);
        $form->addElement($errorRedirectUri);
        unset($errorRedirectUri);
        // form: captcha
        xoops_load('xoopscaptcha');
        $form->addElement(new XoopsFormCaptcha(), true);
        // form: hidden fields
        $form->addElement(new XoopsFormHidden('op', 'save_error'));
        if ($this->isNew()) {
            // NOP
        } else {
            $form->addElement(new XoopsFormHidden('error_id', $this->getVar('error_id')));
        }
        // form: button tray
            $button_tray = new XoopsFormElementTray(_CO_XHTTPERROR_ACTIONS, '' ,'');
            $button_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
            $button_tray->addElement(new XoopsFormButton('', 'reset', _RESET, 'reset'));
                $cancel_button = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
                $cancel_button->setExtra("onclick='javascript:history.back();'");
            $button_tray->addElement($cancel_button);
        $form->addElement($button_tray);
        return $form;
    }
}

/**
 * Class XhttperrorErrorHandler
 */
class XhttperrorErrorHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var XhttperrorXhttperror
     * @access private
     */
    private $xhttperror = null;

    /**
     * constructor
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xhttperror_errors', 'xhttperrorerror', 'error_id', 'error_title');
        $this->xhttperror = XhttperrorXhttperror::getInstance();
    }
}

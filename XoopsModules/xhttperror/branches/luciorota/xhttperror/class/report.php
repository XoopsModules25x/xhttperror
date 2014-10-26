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

/**
 * Class XhttperrorReport
 */
class XhttperrorReport extends XoopsObject
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
        $this->initVar('report_id', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('report_uid', XOBJ_DTYPE_INT, null, true); // user id
        $this->initVar('report_statuscode', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('report_date', XOBJ_DTYPE_INT, time(), false);
        $this->initVar('report_referer', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('report_useragent', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('report_remoteaddr', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('report_requesteduri', XOBJ_DTYPE_TXTBOX, null, false);
    }
}

/**
 * Class XhttperrorReportHandler
 */
class XhttperrorReportHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($db, 'xhttperror_reports', 'xhttperrorreport', 'report_id', 'report_date');
        $this->xhttperror = XhttperrorXhttperror::getInstance();
    }
}

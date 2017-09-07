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

class XhttperrorReport extends XoopsObject
{
    // constructor
    public function __construct()
    {
        parent::__construct();
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

class XhttperrorReportHandler extends XoopsPersistableObjectHandler
{
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'xhttperror_reports', 'xhttperrorreport', 'report_id', 'report_date');
    }
}

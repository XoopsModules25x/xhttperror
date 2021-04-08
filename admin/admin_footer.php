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

$pathIcon32 = Xmf\Module\Admin::iconUrl('', 32);

echo "<div class='adminfooter'>\n" . "  <div style='text-align: center;'>\n" . "    <a href='https://xoops.org' rel='external'><img src='{$pathIcon32}/xoopsmicrobutton.gif' alt='XOOPS' title='XOOPS'></a>\n" . "  </div>\n" . '  ' . _AM_MODULEADMIN_ADMIN_FOOTER . "\n" . '</div>';

xoops_cp_footer();


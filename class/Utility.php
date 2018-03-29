<?php namespace XoopsModules\Xhttperror;

use Xmf\Request;
use XoopsModules\Xhttperror;
use XoopsModules\Xhttperror\Common;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------
}

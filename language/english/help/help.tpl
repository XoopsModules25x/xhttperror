<div id="help-template" class="outer">
    <{include file=$smarty.const._MI_XHTTPERR_HELP_HEADER}>

    <h4 class="odd">DESCRIPTION</h4>
    <p class="even">The xHttpError module is for managing server Status Codes.</p>
    <h4 class="odd">INSTALL/UNINSTALL</h4>
    <p>Follow the standard installation copy the /xhttperror folder into the ../modules directory. Install the module
        through Admin -> System Module -> Modules.</p>
    <p>This module requires that the server supports <b>.htaccess</b> files (and that .htaccess files are allowed for
        your account), or some way for you to add custom error message redirects.</p>
    <p>You will need to manually add the following lines to the <b>.htaccess</b> file in your XOOPS root directory for
        the error codes to work.</p>
    <div class="xoopsCode">
        ErrorDocument 404 [xoops_url]/modules/xhttperror/index.php?error=404
        <br>
        ErrorDocument 500 [xoops_url]/modules/xhttperror/index.php?error=500
        <br>
        ErrorDocument 403 [xoops_url]/modules/xhttperror/index.php?error=403
        <br>
        ErrorDocument 403 [xoops_url]/modules/xhttperror/index.php?error=[status code]
    </div>
    <p>Where [status_code] is the status code for server errors and [xoops_url] is the URL to your main XOOPS directory
        WITHOUT trailing slash (<{$xoops_url}>)</p>
    <br>
    <p>Detailed instructions on installing modules are available in the <a
                href="https://xoops.gitbook.io/xoops-operations-guide/" target="_blank"
                title="XOOPS Operations Manual">XOOPS
            Operations Manual</a></p>
    <br>
    <p>Follow this link for more informationd about status codes</p>
    <ul>
        <li><a href="http://www.iana.org/assignments/http-status-codes/http-status-codes.xml">IANA: Hypertext Transfer
                Protocol (HTTP) Status Code Registry</a></li>
        <li><a href="http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html">Hypertext Transfer Protocol -- HTTP/1.1,
                Status Code Definitions</a></li>
    </ul>
    <h4 class="odd">OPERATING INSTRUCTIONS</h4>
    <p class="even">To set up this module you need to:</p>
    <ul>
        <li>configure your preferences for the module;</li>
        <li>edit existing Errors codes or add new ones and update the <b>.htaccess</b> file.</li>
    </ul>
    <h4 class="odd">TUTORIAL</h4>
    <p class="even">Tutorial coming soon.</p>
    <!-- -----Help Content ---------- -->
</div>

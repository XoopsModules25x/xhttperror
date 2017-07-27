<{*
SMARTY VARS
$title          text        Error title
$text           text/html   Error description
$showsearch     boolean     True if show search form in error page
$redirect       int         $smarty.const.XHTTPERR_REDIRECT_no: no redirect;
                            $smarty.const.XHTTPERR_REDIRECT_URI: redirect tu url...;
                            $smarty.const.XHTTPERR_REDIRECT_PREVIOUS: redirect to previous page;
$redirect_time  int         Milliseconds to redirect
$redirect_uri   text        Redirect to
*}>
<{if ($redirect == $smarty.const.XHTTPERR_REDIRECT_URI)}>
    <script type="text/JavaScript">
        <!--
        setTimeout("location.href = '<{$redirect_uri}>';", <{$redirect_time}>);
        -->
    </script>
<{/if}>
<{if ($redirect == $smarty.const.XHTTPERR_REDIRECT_PREVIOUS)}>
    <script type="text/JavaScript">
        <!--
        setTimeout("history.go(-1);", <{$redirect_time}>);
        -->
    </script>
<{/if}>

<h1 style="text-align: center;"><{$title}></h1>

<{$text}>

<{if ($showsearch)}>
    <!-- search -->
    <br>
    <br>
    <br>
    <div align="center">
        <form method="get" action="/search.php">
            <div style="width: 50%;">
                <{$smarty.const._MD_XHTTPERR_SEARCH}>
                <input type="text" name="query" size="30">
                <input type="hidden" name="action" value="results">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>
<{/if}>

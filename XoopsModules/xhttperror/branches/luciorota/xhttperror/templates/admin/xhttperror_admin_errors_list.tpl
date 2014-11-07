<form action="error.php" method="post" id="errorform">
<table>
    <tr>
        <th colspan="5"><{$smarty.const._CO_XHTTPERROR_ERRORS_LIST}></th>
    </tr>
    <tr>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_ID}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_TITLE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_STATUSCODE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_STATUS}></th>
        <th><{$smarty.const._CO_XHTTPERROR_ACTIONS}></th>
    </tr>
<{foreach from=$errors item='error'}>
    <tr class="<{cycle values='odd, even'}>">
        <td><{$error.error_id}></td>
        <td><{$error.error_title}></td>
        <td><{$error.error_statuscode}></td>
        <td>
        <{if ($error.error_showme)}>
            <{$smarty.const._AM_XHTTPERROR_ERROR_STATUS_SHOW}>
        <{else}>
            <{$smarty.const._AM_XHTTPERROR_ERROR_STATUS_HIDE}>
        <{/if}>
        </td>
        <td>
            <a href="error.php?op=edit_error&amp;error_id=<{$error.error_id}>" title="<{$smarty.const._EDIT}>"><{$smarty.const._EDIT}></a>
            &nbsp;
            <a href="error.php?op=delete_error&amp;error_id=<{$error.error_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>
            &nbsp;
            <a href="../index.php?error=<{$error.error_statuscode}>" title="<{$smarty.const._CO_XHTTPERROR_BUTTON_TEST}>"><{$smarty.const._CO_XHTTPERROR_BUTTON_TEST}></a>
        </td>
    </tr>
<{/foreach}>
</table>
</form>

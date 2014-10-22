<form action="errors.php" method="post" id="errorform">
<table>
    <tr>
        <th colspan="5"><{$smarty.const._AM_XHTTPERROR_ERRORS}></th>
    </tr>
    <tr>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_ID}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_TITLE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_STATUSCODE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ERROR_STATUS}></th>
        <th><{$smarty.const._AM_XHTTPERROR_ACTION}></th>
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
            <a href="errors.php?op=edit_error&amp;error_id=<{$error.error_id}>" title="<{$smarty.const._EDIT}>"><{$smarty.const._EDIT}></a>
            &nbsp;
            <a href="errors.php?op=delete_error&amp;error_id=<{$error.error_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>
            &nbsp;
            <a href="../index.php?error=<{$error.error_statuscode}>" title="<{$smarty.const._AM_XHTTPERROR_ACTION_TEST}>"><{$smarty.const._AM_XHTTPERROR_ACTION_TEST}></a>
        </td>
    </tr>
<{/foreach}>
</table>
</form>
<script language='JavaScript'>
    function toggle(source){
        checkboxes = document.getElementsByName('report_ids[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
        togglers = document.getElementsByName('togglers[]');
        for (var i = 0, n = togglers.length; i < n; i++) {
            togglers[i].checked = source.checked;
        }
    }
</script>
<script language='JavaScript'>
    function check(source){
        checkboxes = document.getElementsByName('report_ids[]');
        for (var i = 0,  n= checkboxes.length; i < n; i++) {
            if (checkboxes[i].checked) return true;
        }
        return false;
    }
</script>

<form action="report.php" method="post" id="reportform">
<table>
    <tr>
        <th colspan="10"><{$smarty.const._CO_XHTTPERROR_REPORTS_LIST}></th>
    </tr>
    <tr>
        <th class='center'><input type='checkbox' name='togglers[]' title='<{$smarty.const._ALL}>' onClick='toggle(this);'></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_ID}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_USER}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_STATUSCODE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_DATE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REFERER}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_USERAGENT}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REMOTEADDR}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REQUESTEDURI}></th>
        <th><{$smarty.const._CO_XHTTPERROR_ACTIONS}></th>
    </tr>
<{foreach from=$reports item='report'}>
    <tr class="<{cycle values='odd, even'}>">
        <td class='center'><input type='checkbox' name='report_ids[]' value='<{$report.report_id}>'></td>
        <td><{$report.report_id}></td>
        <td><{$report.report_owner_uname}></td>
        <td><{$report.report_statuscode}></td>
        <td><{$report.report_date_formatted}></td>
        <td><{$report.report_referer}></td>
        <td><{$report.report_useragent}></td>
        <td><{$report.report_remoteaddr}></td>
        <td><{$report.report_requesteduri}></td>
        <td>
            <a href="report.php?op=delete_report&amp;report_id=<{$report.report_id}>" title="<{$smarty.const._DELETE}>"><{$smarty.const._DELETE}></a>
        </td>
    </tr>
<{/foreach}>
    <tr>
        <th class='center'><input type='checkbox' name='togglers[]' title='<{$smarty.const._ALL}>' onClick='toggle(this);'></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_ID}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_USER}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_STATUSCODE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_DATE}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REFERER}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_USERAGENT}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REMOTEADDR}></th>
        <th><{$smarty.const._AM_XHTTPERROR_REPORT_REQUESTEDURI}></th>
        <th><{$smarty.const._CO_XHTTPERROR_ACTIONS}></th>
    </tr>
    <tr>
        <td colspan='10'>
        <input id='actions_action' type='hidden' value='delete_reports' name='actions_action'>
        <input id='actions_submit' class='formButton' type='submit' title='<{$smarty.const._CO_XHTTPERROR_BUTTON_DELETE_SELECTED}>' value='<{$smarty.const._CO_XHTTPERROR_BUTTON_DELETE_SELECTED}>' name='actions_submit'>
    </td>
</tr>
<input id='actions_op' type='hidden' value='apply_actions' name='op'>
</table>
<{$reports_pagenav}>
</form>

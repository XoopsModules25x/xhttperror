<form action="report.php" method="post" id="reportform">
<table>
    <tr>
        <th colspan="9"><{$smarty.const._CO_XHTTPERROR_REPORTS_LIST}></th>
    </tr>
    <tr>
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
</table>
<{$reports_pagenav}>
</form>

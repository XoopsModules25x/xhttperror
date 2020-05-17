<script language="JavaScript">
    function toggleColumn(source) {
        var column = $(source).attr('column');
        var checkboxes = $('input[column=' + column + ']');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = $(source).prop('checked');
        }
        return true;
    }
    function toggleRow(source) {
        var row = $(source).attr('row');
        var checkboxes = $('input[row=' + row + ']');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = $(source).prop('checked');
        }
        return true;
    }
</script>

<form action="reports.php" method="post" id="reportform">
    <table>
        <tr>
            <th colspan="10"><{$smarty.const._AM_XHTTPERR_REPORTS}></th>
        </tr>
        <tr>
            <th>
                <input type="checkbox" column="1" title="<{$smarty.const._SELECT}>" onClick="toggleColumn(this);">
            </th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_ID}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_USER}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_STATUSCODE}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_DATE}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_REFERER}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_USERAGENT}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_REMOTEADDR}></th>
            <th><{$smarty.const._AM_XHTTPERR_REPORT_REQUESTEDURI}></th>
            <th><{$smarty.const._AM_XHTTPERR_ACTION}></th>
        </tr>
    <{foreach from=$reports item='report'}>
        <tr class="<{cycle values='odd, even'}>">
            <td>
                
                <input type="checkbox" row="<{$row}>" column="1" name="report_ids[<{$report.report_id}>]" value="<{$report.report_id}>">
            </td>
            <td><{$report.report_id}></td>
            <td><{$report.report_user}></td>
            <td><{$report.report_statuscode}></td>
            <td><{$report.report_date}></td>
            <td><{$report.report_referer}></td>
            <td><{$report.report_useragent}></td>
            <td><{$report.report_remoteaddr}></td>
            <td><{$report.report_requesteduri}></td>
            <td class="txtcenter">
                <a href="reports.php?op=delete_report&amp;report_id=<{$report.report_id}>"
                   title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}>"></a>
            </td>
        </tr>
    <{/foreach}>
        <tr class="foot">
            <td colspan="1">
                <input type="checkbox" column="1" title="<{$smarty.const._SELECT}>" onClick="toggleColumn(this);">
            </td>
            <td colspan="9">
                <input type="hidden" name="op" value="delete_reports">
                <input class="floatleft formButton" type="submit" value="<{$smarty.const._DELETE}>" />
            </td>
        </tr>
    </table>
</form>

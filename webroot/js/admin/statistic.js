var statisticTimerVar;
function getStatistic() {
    $.ajax({
        url: '/statistic',
        type: 'POST',
        contentType: 'application/json',
        dataType : 'json',
        success: function (data) {
            if(data.importStatus == true) {
                $('#statistic').show();
                $('#uploadDiv').hide();
                $('#deleteOnDate').hide();
                $('#stopImport').show();
                $('#statsBar').attr('max', data.count);
                $('#statsBar').attr('value', data.position);
                $('#statsInfo').html('Added: ' + data.added + '<br>Changed: ' + data.changed);
                $('#statsProgress').html(data.position + '/' + data.count);
            }
            else {
                $('#statistic').hide();
                $('#uploadDiv').show();
                $('#deleteOnDate').show();
                clearInterval(statisticTimerVar);
            }
        }
    });
}

function stopImport() {
    $.ajax({
        url: '/admin/stop',
        type: 'get',
        success: function (data) {
        }
    });
}

function statisticTimer() {
    statisticTimerVar = setInterval(getStatistic, 1000);
}
$( document ).ready(function() {
    statisticTimer();
});
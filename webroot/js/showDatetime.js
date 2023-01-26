var wd = ['日', '月', '火', '水', '木', '金', '土'];

function set2fig(num) {
    // 桁数が1桁だったら先頭に0を加えて2桁に調整する
    var ret;
    if( num < 10 ) { ret = "0" + num; }
    else { ret = num; }
    return ret;
}
function showDatetime() {
    var now = new Date();
    var y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var w = now.getDay();

    var h = set2fig(now.getHours());
    var mi = set2fig(now.getMinutes());
    var s = set2fig(now.getSeconds());

    target = document.getElementById('showDatetime');
    target.innerHTML = y + '年' + m + '月' + d + '日' + '(' + wd[w] + ')　' + h + ':' + mi + ':' + s;
}
setInterval('showDatetime()',1000);

function showDatetime2() {
    var now = new Date();
    var y = now.getFullYear();
    var m = now.getMonth() + 1;
    var d = now.getDate();
    var w = now.getDay();

    var h = set2fig(now.getHours());
    var mi = set2fig(now.getMinutes());
    var s = set2fig(now.getSeconds());

    target2 = document.getElementById('dtView');
    target2.innerHTML = '<p id="topDate">' + y + '年' + m + '月' + d + '日' + '(' + wd[w] + ')</p>' + '<p id="topTime">' + h + ':' + mi + '</p>';
}
setInterval('showDatetime2()',1000);
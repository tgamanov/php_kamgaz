<style>
    #drop{
        border:2px dashed #bbb;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        padding:25px;
        text-align:center;
        font:20pt bold,"Vollkorn";color:#bbb
    }
    #b64data{
        width:100%;
    }

    .excel-column {
        display: inline-block;
        width: 11%;
    }
    .btn-file {
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;

    }
    .btn {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    #loading {
        margin-bottom: 15px;
    }
</style>
<h2>Імпортувати дані</h2>
<div id="file_place" style="display: block;">
<div id="drop">Перетягніть XLS файл</div>

    <span class="btn btn-primary btn-file">
        ...або натисніть тут<input type="file" name="xlfile" id="xlf" class="btn btn-primary" />
    </span>
</div>
<div id="loading" style="display: none;"><img src="/img/loading.gif" width="40px"> Виконується скрипт. Не покидайте сторінку. Сторінка може перестати відповідати (нічого страшного)</div>
<div id="status_bar" style="display: none;">

        <div class="progress">
            <div id="status_bar_position"
                 class="progress-bar progress-bar-striped active"
                 role="progressbar" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="100"
                 style="width:0%">
                0
            </div>
        </div>

</div>


<div id="control_panel" style="display: none;">
    <button onclick="javascript:render_table()" class="btn btn-info">Показти дані в таблиці</button><br>
    <button onclick="javascript:send_to_server()" class="btn btn-success" >Відправити дані на сервер</button><br>
    Виберіть дату даних: <input type="date" id="on_date" value="<?=date("Y-m-d")?>">
</div>

<div id="result" style="overflow-y: scroll; max-height:400px; display: none;">

</div>

<div style="display: none;">
<select name="format">
    <option value="json" selected> JSON</option>
</select><br />
Use Web Workers: (when available) <input type="checkbox" name="useworker" checked><br />
Use Transferrables: (when available) <input type="checkbox" name="xferable" checked><br />
Use readAsBinaryString: (when available) <input type="checkbox" name="userabs" checked><br />
<pre id="out"></pre>
</div>

<br />
<script src="/js/excel/shim.js"></script>
<script src="/js/excel/xls.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script>


var is_continue;
var position = 0;
var max = 0;
var obj = null;

function send_to_server() {

    max = obj['SelectBase'].length;
    if (position < max) {
        var i = position;

    if (file_result != undefined) {
        document.getElementById("loading").style.display = 'block';
        document.getElementById("status_bar").style.display = 'block';
        document.getElementById("control_panel").style.display = 'none';
        document.getElementById("file_place").style.display = 'none';



//        for (var i = 0; i < obj['SelectBase'].length; i++) {
            var acc_number = obj['SelectBase'][i]['Лиц'] == undefined ? 0 : obj['SelectBase'][i]['Лиц'];
            var str = obj['SelectBase'][i]['ФИО'] == undefined ? "" : obj['SelectBase'][i]['ФИО'] + " ";
            var soname = str.substring(0, str.indexOf(" "));
            soname = soname.charAt(0).toUpperCase() + soname.substring(1).toLowerCase();
            str = str.substring(str.indexOf(" ") + 1);
            var name = str.substring(0, str.indexOf(" "));
            name = name.charAt(0).toUpperCase() + name.substring(1).toLowerCase();
            str = str.substring(str.indexOf(" ") + 1);
            if (str == " ") str = "";
            var middle_name = str;
            middle_name = middle_name.charAt(0).toUpperCase() + middle_name.substring(1).toLowerCase();
            var street = obj['SelectBase'][i]['Вулиця'] == undefined ? "" : obj['SelectBase'][i]['Вулиця'];
            var house = obj['SelectBase'][i]['Буд.'] == undefined ? "" : obj['SelectBase'][i]['Буд.'];
            var flat = obj['SelectBase'][i]['Кв'] == undefined ? "" : obj['SelectBase'][i]['Кв'];
            var acc_index = obj['SelectBase'][i]['ПоказРозрахн'] == undefined ? 0 : obj['SelectBase'][i]['ПоказРозрахн'];
            var balance = obj['SelectBase'][i]['БоргКінМіс'] == undefined ? 0 : obj['SelectBase'][i]['БоргКінМіс'];
//            is_continue = false;
            position++;
            var percent = Math.round((position/max)*100);
            document.getElementById("status_bar_position").innerHTML = percent + "% (" + position + "/" + max + ")";
            document.getElementById("status_bar_position").setAttribute('aria-valuenow',percent);
            document.getElementById("status_bar_position").setAttribute('style', "width:"+percent+"%");
            ajax_send_data(acc_number,soname,name,middle_name,street,house,flat,acc_index,balance);
//            ajax_send_data(acc_number,soname,name,middle_name,street,house,flat,acc_index,balance);
//            while(!is_continue) {}
//        }
    }
//        document.getElementById("loading").style.display = 'none';
//        document.getElementById("control_panel").style.display = 'none';
    } else {
        document.getElementById("loading").style.display = 'none';
        document.getElementById("status_bar").style.display = 'none';
        document.getElementById("file_place").style.display = 'block';
    }
}

function ajax_send_data(acc_number, soname, name, middle_name, streer, house, flat, acc_index, balance) {
    var on_date = document.getElementById("on_date").value;
    $.ajax({
        url: '/admin/personal/save',
        type: 'post',
        data: {
            'acc_number' : acc_number,
            'soname' : soname,
            'name' : name,
            'middle_name' : middle_name,
            'street' : streer,
            'house' : house,
            'flat' : flat,
            'acc_index' : acc_index,
            'balance' : balance,
            'on_date' : on_date
        },
        success: function(data) {
            if (data == "ok") {}
                send_to_server();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError);
//            send_to_server();
            alert("Error on position " + position);
        }
    })
}


var file_result = undefined;

var X = XLS;
var XW = {
    /* worker message */
    msg: 'xls',
    /* worker scripts */
    rABS: '/js/excel/xlsworker2.js',
    norABS: '/js/excel/xlsworker1.js',
    noxfer: '/js/excel/xlsworker.js'
};

var rABS = typeof FileReader !== "undefined" && typeof FileReader.prototype !== "undefined" && typeof FileReader.prototype.readAsBinaryString !== "undefined";
if(!rABS) {
    document.getElementsByName("userabs")[0].disabled = true;
    document.getElementsByName("userabs")[0].checked = false;
}

var use_worker = typeof Worker !== 'undefined';
if(!use_worker) {
    document.getElementsByName("useworker")[0].disabled = true;
    document.getElementsByName("useworker")[0].checked = false;
}

var transferable = use_worker;
if(!transferable) {
    document.getElementsByName("xferable")[0].disabled = true;
    document.getElementsByName("xferable")[0].checked = false;
}

var wtf_mode = false;

function fixdata(data) {
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
    return o;
}

function ab2str(data) {
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint16Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint16Array(data.slice(l*w)));
    return o;
}

function s2ab(s) {
    var b = new ArrayBuffer(s.length*2), v = new Uint16Array(b);
    for (var i=0; i != s.length; ++i) v[i] = s.charCodeAt(i);
    return [v, b];
}

function xw_noxfer(data, cb) {
    var worker = new Worker(XW.noxfer);
    worker.onmessage = function(e) {
        switch(e.data.t) {
            case 'ready': break;
            case 'e': console.error(e.data.d); break;
            case XW.msg: cb(JSON.parse(e.data.d)); break;
        }
    };
    var arr = rABS ? data : btoa(fixdata(data));
    worker.postMessage({d:arr,b:rABS});
}

function xw_xfer(data, cb) {
    var worker = new Worker(rABS ? XW.rABS : XW.norABS);
    worker.onmessage = function(e) {
        switch(e.data.t) {
            case 'ready': break;
            case 'e': console.error(e.data.d); break;
            default: xx=ab2str(e.data).replace(/\n/g,"\\n").replace(/\r/g,"\\r"); console.log("done"); cb(JSON.parse(xx)); break;
        }
    };
    if(rABS) {
        var val = s2ab(data);
        worker.postMessage(val[1], [val[1]]);
    } else {
        worker.postMessage(data, [data]);
    }
}

function xw(data, cb) {
    transferable = document.getElementsByName("xferable")[0].checked;
    if(transferable) xw_xfer(data, cb);
    else xw_noxfer(data, cb);
}

function get_radio_value( radioName ) {
    var radios = document.getElementsByName( radioName );
    for( var i = 0; i < radios.length; i++ ) {
        if( radios[i].checked || radios.length === 1 ) {
            return radios[i].value;
        }
    }
}

function to_json(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
        var roa = X.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
        if(roa.length > 0){
            result[sheetName] = roa;
        }
    });
    return result;
}

function to_csv(workbook) {
    var result = [];
    workbook.SheetNames.forEach(function(sheetName) {
        var csv = X.utils.sheet_to_csv(workbook.Sheets[sheetName]);
        if(csv.length > 0){
            result.push("SHEET: " + sheetName);
            result.push("");
            result.push(csv);
        }
    });
    return result.join("\n");
}

function to_formulae(workbook) {
    var result = [];
    workbook.SheetNames.forEach(function(sheetName) {
        var formulae = X.utils.get_formulae(workbook.Sheets[sheetName]);
        if(formulae.length > 0){
            result.push("SHEET: " + sheetName);
            result.push("");
            result.push(formulae.join("\n"));
        }
    });
    return result.join("\n");
}

var tarea = document.getElementById('b64data');
function b64it() {
    if(typeof console !== 'undefined') console.log("onload", new Date());
    var wb = X.read(tarea.value, {type: 'base64',WTF:wtf_mode});
    process_wb(wb);
}

function process_wb(wb) {
    if(use_worker) XLS.SSF.load_table(wb.SSF);
    var output = "";
    switch(get_radio_value("format")) {
        case "json":
            output = JSON.stringify(to_json(wb), 2, 2);
            break;
        case "form":
            output = to_formulae(wb);
            break;
        default:
            output = to_csv(wb);
    }
    if(out.innerText === undefined) out.textContent = output;
    else {
        file_result = output;
        obj = JSON.parse(file_result);
        document.getElementById("control_panel").style.display = 'block';
    }
    document.getElementById("loading").style.display = 'none';
    if(typeof console !== 'undefined') console.log("output", new Date());
}

function render_table() {
    if (file_result != undefined) {
    document.getElementById("result").style.display = 'block';
    var obj = JSON.parse(file_result);
    //    alert(obj['SelectBase'][1]['Лиц']);
        var excel_table_div = document.getElementById("result").innerHTML = "";
        var table = document.createElement("div");
        table.className = "excel-table";
        var row = document.createElement("div");
            row.className = "excel-row";
                var column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "Рахунок";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "Прізвище";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "Імя";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "По-батькові";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "вулиця";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "буд";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "кв";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "Показник";
            row.appendChild(column);
                column = document.createElement("div");
                column.className = "excel-column";
                column.innerHTML = "борг";
            row.appendChild(column);
        table.appendChild(row);
        for (var i = 0; i < obj['SelectBase'].length; i++) {
    //        var row = document.createElement("div");
    //        row.className = "excel-row";
    //        var column = document.createElement("div");
    //        column.className = "excel-column";
    //        column.innerHTML = obj['SelectBase'][i]['Лиц'];
    //        row.appendChild(column);
    //        table.appendChild(row);
            row = document.createElement("div");
            row.className = "excel-row";
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['Лиц'];
            row.appendChild(column);
    //        var str = obj['SelectBase'][i]['ФИО'] + " ";
            var str = obj['SelectBase'][i]['ФИО'] == "undefined" ? "" : obj['SelectBase'][i]['ФИО'] + " ";
            var soname = str.substring(0, str.indexOf(" "));
            soname = soname.charAt(0).toUpperCase() + soname.substring(1).toLowerCase();
            str = str.substring(str.indexOf(" ") + 1);
            var name = str.substring(0, str.indexOf(" "));
            name = name.charAt(0).toUpperCase() + name.substring(1).toLowerCase();
            str = str.substring(str.indexOf(" ") + 1);
            if (str == " ") str = "";
            var middle_name = str;
            middle_name = middle_name.charAt(0).toUpperCase() + middle_name.substring(1).toLowerCase();
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = soname;
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = name;
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = middle_name;
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['Вулиця'] == undefined ? "" : obj['SelectBase'][i]['Вулиця'];
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['Буд.'] == undefined ? "" : obj['SelectBase'][i]['Буд.'];
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['Кв'] == undefined ? "" : obj['SelectBase'][i]['Кв'];
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['ПоказРозрахн'] == undefined ? "" : obj['SelectBase'][i]['ПоказРозрахн'];
            row.appendChild(column);
            column = document.createElement("div");
            column.className = "excel-column";
            column.innerHTML = obj['SelectBase'][i]['БоргКінМіс'] == undefined ? "" : obj['SelectBase'][i]['БоргКінМіс'];
            row.appendChild(column);
            table.appendChild(row);
        }
        document.getElementById("result").appendChild(table);
    }
}

var drop = document.getElementById('drop');
function handleDrop(e) {
    e.stopPropagation();
    e.preventDefault();
    document.getElementById("loading").style.display = 'block';
    rABS = document.getElementsByName("userabs")[0].checked;
    use_worker = document.getElementsByName("useworker")[0].checked;
    var files = e.dataTransfer.files;
    var f = files[0];
    {
        var reader = new FileReader();
        var name = f.name;
        reader.onload = function(e) {
            if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
            var data = e.target.result;
            if(use_worker) {
                xw(data, process_wb);
            } else {
                var wb;
                if(rABS) {
                    wb = X.read(data, {type: 'binary'});
                } else {
                    var arr = fixdata(data);
                    wb = X.read(btoa(arr), {type: 'base64'});
                }
                process_wb(wb);
            }
        };
        if(rABS) reader.readAsBinaryString(f);
        else reader.readAsArrayBuffer(f);
    }
}

function handleDragover(e) {
    e.stopPropagation();
    e.preventDefault();
    e.dataTransfer.dropEffect = 'copy';
}

if(drop.addEventListener) {
    drop.addEventListener('dragenter', handleDragover, false);
    drop.addEventListener('dragover', handleDragover, false);
    drop.addEventListener('drop', handleDrop, false);
}


var xlf = document.getElementById('xlf');
function handleFile(e) {

    document.getElementById("loading").style.display = 'block';
    rABS = document.getElementsByName("userabs")[0].checked;
    use_worker = document.getElementsByName("useworker")[0].checked;
    var files = e.target.files;
    var f = files[0];
    {
        var reader = new FileReader();
        var name = f.name;
        reader.onloadstart = function(data) {

        }
        reader.onprogress = function(event) {

        }
        reader.onloadend = function(event) {
//            document.getElementById("loading").style.display = 'none';

        }
        reader.onload = function(e) {
            if(typeof console !== 'undefined') console.log("onload", new Date(), rABS, use_worker);
            var data = e.target.result;
            if(use_worker) {
                xw(data, process_wb);
            } else {
                var wb;
                if(rABS) {
                    wb = X.read(data, {type: 'binary'});
                } else {
                    var arr = fixdata(data);
                    wb = X.read(btoa(arr), {type: 'base64'});
                }
                process_wb(wb);
            }

        };
        if(rABS) reader.readAsBinaryString(f);
        else reader.readAsArrayBuffer(f);

    }
}

if(xlf.addEventListener) xlf.addEventListener('change', handleFile, false);
</script>


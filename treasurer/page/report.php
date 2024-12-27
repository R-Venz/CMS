<style>
    table {
        width: 98%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    th, td {
        padding: 10px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
/*        background-color: #007BFF;*/
        color: #000;
        border-bottom: 2px solid #0056b3;
    }

    tr:hover {
        background-color: #f1f1f1;
    }
</style>
<div class="container-fluid">
    <div class="row font-1">
        <div class="col-lg-3">
            <select name="type" id="type" class="form-control" onchange="view_report()">
                <option value="1">Contribution</option>
                <option value="2">Released</option>
                <option value="3">Both Contribution & Released</option>
            </select>
        </div>
        <div class="col-lg-3">
            <input type="date" name="dt1" id="dt1" class="form-control" onchange="view_report()" value="<?=date('Y-m-d')?>">
        </div>
        <div class="col-lg-3">
            <input type="date" name="dt2" id="dt2" class="form-control" onchange="view_report()" value="<?=date('Y-m-d')?>">
        </div>
    </div>
    <hr>
    <div class="row font-1">
        <div class="col-lg-12">
            <table width="100%" id="table_report">
                <thead>
                    <th>Name</th>
                    <th>Date of Death</th>
                    <th>Cause of Death</th>
                    <th>Declerant</th>
                    <th>Collected</th>
                    <th>Release</th>
                    <th>Balance</th>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    view_report();
    function getContributionReport() {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        var Data = {"dt1":$('#dt1').val(),"dt2":$('#dt2').val()}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/report/getContributionReport.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                $('#table_report').html(this.responseText);
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    function getReleasedReport() {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        var Data = {"dt1":$('#dt1').val(),"dt2":$('#dt2').val()}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/report/getReleasedReport.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                $('#table_report').html(this.responseText);
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    function getAllReport() {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        var Data = {"dt1":$('#dt1').val(),"dt2":$('#dt2').val()}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/report/getAllReport.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                $('#table_report').html(this.responseText);
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    function view_report() {
        if ($('#type').val() == '1') {
            getContributionReport();
        }else if ($('#type').val() == '2') {
            getReleasedReport();
        }else if ($('#type').val() == '3') {
            getAllReport();
        }
    }
</script>
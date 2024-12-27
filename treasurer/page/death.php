<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="form-group mb-0">
                        <label class="control-label mr-1">Search: </label>
                        <input type="text" class="form-control" id="txtsearch" onkeyup="view();" placeholder="Enter data to search">
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
                <div class="col-lg-4">
                    <!-- <button class="btn btn-primary" style="float: right;" data-target="#modal_user" data-toggle="modal" onclick="clearUser();">New</button> -->
                </div>  
            </div>
        </div>
        <div class="table-responsive">

            <table class="table m-0" id="user_list" width="100%">
                <thead>
                    <tr class="bg-fade">
                        <th>NAME</th>
                        <th>DATE OF DEATH</th>
                        <th>CAUSE OF DEATH</th>
                        <th>DECLERANT</th>
                        <th>AGE</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <!-- <div class="modal-dialog" role="document" style="max-width: 80%;"> -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Declare Death</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="death_form">
        <div class="modal-body">
            <div class="form-group">
                <label for="mid">Deceased Name</label>
                <br>
                <select disabled type="text" class="form-control select-2" id="mid" name="mid" required onchange="getFamilyMember();" style="width: 100%;">
                    <?php  
                        $m = new Member();
                        $res = $m->view(" AND mstatus='Active'"," GROUP BY m.id ORDER BY CONCAT(lname,fname,mname)");
                        foreach ($res as $rs) {
                            echo '<option value="'.$rs->mid.'" data-mpid="'.$rs->mpid.'">'.strtoupper($rs->name).'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="dod">Date of Death</label>
                <input disabled type="date" class="form-control" id="dod" name="dod" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="cod">Cause of Death</label>
                <input disabled type="text" class="form-control" id="cod" name="cod" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="dec">Declarant</label>
                <select disabled type="text" class="form-control select-2" id="dec" name="dec" required style="width: 100%;">

                </select>
            </div>
        </div>
        <div class="modal-footer">
            <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
  </div>
</div>
<!-- Modals -->
<div class="modal fade" id="modal_manage_transaction" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <div class="modal-dialog" role="document" style="max-width: 800px;">
  <!-- <div class="modal-dialog" role="document"> -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel"><strong id="modal-title"></strong><strong id="balance_data"></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-header">
        <button class="btn btn-primary" id="btnNew" onclick="openModalEditTransaction()">New</button>
        <button class="btn btn-info" id="btnNew" onclick="printSOA()">Print</button>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Receiver</th>
                                </tr>
                            </thead>
                            <tbody id="table_disburse"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btnrelease">Release</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Modals -->
<div class="modal fade" id="edit_transaction" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <div class="modal-dialog" role="document" style="max-width: 800px;">
  <!-- <div class="modal-dialog" role="document"> -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="transaction_form">
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="purpose">Purpose</label>
                        <input type="text" class="form-control" id="purpose" name="purpose" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="receiver">Receiver</label>
                        <input type="text" class="form-control" id="receiver" name="receiver" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
  </div>
</div>
<script>
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
    var thisID = "";
    var tID = "";
    $(function(){
        view();
        $('.select-2').select2({
            theme: 'bootstrap',
            placeholder: 'Select an option',
            dropdownParent: $("#modal_user")
        });
        getFamilyMember();
    });
    function view() {
        $('#user_list').DataTable().destroy();
        var empDataTable = $('#user_list').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'<?php echo web_root; ?>php/death/view.php?t=treasurer&sr='+$('#txtsearch').val(),
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Error: '+errorThrown)
                        Swal.fire('',errorThrown,'error')
                    }
              },
              pageLength: 100,
              'lengthChange': false,
              scrollY: "300px",
              scrollX: true,
              searching: false,
              'columns': [
                  { data: 'name' },
                  { data: 'dod' },
                  { data: 'cod' },
                  { data: 'declerant' },
                  { data: 'age' },
                  { data: 'status'},
                  { data: 'action'},
              ]
        });
    }
    function clearUser() {
        $('#death_form')[0].reset();
        thisID=''
    }
    function details_death(id,mid,did,dod,cod) {
        clearUser();
        thisID = id;
        $("#mid").val(decodestr(mid)).select2();
        getFamilyMember();
        $("#dec").val(decodestr(did)).select2();
        $('#dod').val(decodestr(dod));
        $('#cod').val(decodestr(cod));
        $('#modal_user').modal('toggle');
    }
    $('#death_form').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        postData.append('id', decodestr(thisID));
        $.ajax({  
            url:"<?=web_root?>php/death/save.php",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    Swal.fire("Data saved!", "", "success");
                    $('#modal_user').modal('toggle');
                    view();
                    clearUser();
                }else{
                    Swal.fire("" , data,'warning');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire("Error:" , textStatus + ", " + errorThrown, 'error');
            }  
        }) 
    })
    function getFamilyMember() {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        var id = document.getElementById('mid').value;
        var e = document.getElementById("mid"),
            option= e.options[e.selectedIndex],
            mpid = option.getAttribute("data-mpid");
        var Data = {"mid":id,"mpid":mpid}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/member/getFamilyMembers.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                // alert(this.responseText)
                document.getElementById('dec').innerHTML = this.responseText;
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    function mngTransaction(id,name,status,totalCollection,totalRelease,balance) {
        thisID=decodestr(id);
        getBalance(thisID);
        /*if (decodestr(status)=='Posted') {
            document.querySelector('#modal_manage_transaction #btnNew').style.display='block';
            document.querySelector('#modal_manage_transaction #btnNew').onclick = function () {
                openEditTransactionModal();
            };
        }else{
            document.querySelector('#modal_manage_transaction #btnNew').style.display='none';
            document.querySelector('#modal_manage_transaction #btnNew').onclick = function () {
                alert('I think you are lost. ')
            };
        }*/
        $('#modal_manage_transaction').modal('toggle');
        $('#modal_manage_transaction #modal-title').html(decodestr(name) + ' &mdash; ');
        view_transactions();
    }
    function getBalance(id) {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        var Data = {"id":id}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/release/getBalance.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                var DataRecieved = this.responseText;
                if(Ajax.isJsonFormat(DataRecieved)==true){
                    var DT=JSON.parse(DataRecieved);
                    document.getElementById('balance_data').innerHTML = decodestr(DT.totalCollection) + ' (<strong style="color:red;">-'+decodestr(DT.totalRelease)+'</strong>) = ₱' + decodestr(DT.balance);
                    if (DT.ispaid) {
                        document.getElementById('btnrelease').style.display = 'none';
                        document.getElementById('btnrelease').onclick = function(){ alert('INVALID ACTION') } ;
                    }else{
                        document.getElementById('btnrelease').style.display = 'block';
                        document.getElementById('btnrelease').onclick = function(){ releaseMoney(decodestr(DT.balance)) } ;
                    }
                }else{
                    Swal.fire('There is a problem while fetching the data',this.responseText,'error');
                }
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    function openModalEditTransaction() {
        cleartransaction()
        $('#edit_transaction').modal('toggle');
    }
    function cleartransaction() {
        $('#transaction_form')[0].reset();
    }
    function view_transactions() {
        var xmlHttp= Ajax.httpRequest();
        if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
        
        var Data = {"id":thisID}
        Data = JSON.stringify(Data);
        var url='<?php echo web_root; ?>php/release/view.php';
        xmlHttp.onreadystatechange=function() { 
            if (xmlHttp.readyState==4){
                // alert(this.responseText)
                document.getElementById('table_disburse').innerHTML = this.responseText;
            } 
        }
        xmlHttp.open("POST",url,false);  
        xmlHttp.send(Data);
    }
    $('#transaction_form').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        postData.append('id', tID);
        postData.append('did', thisID);
        $.ajax({  
            url:"<?=web_root?>php/release/save.php",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    Swal.fire("Data saved!", "", "success");
                    $('#edit_transaction').modal('toggle');
                    cleartransaction();
                    view_transactions();
                    getBalance(thisID)
                }else{
                    Swal.fire("" , data,'warning');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire("Error:" , textStatus + ", " + errorThrown, 'error');
            }  
        }) 
    })
    function printSOA() {
        $('#PopupWall').modal('toggle');
        Show_PDFViewer('<?php echo web_root; ?>php/report/soa.php?id='+thisID, "");
    }     
    function releaseMoney(amount) {
        Swal.fire({
            title: 'Are you sure you want to release the money?',
            html: "Amount: <input type='number' class='form-control' placeholder='Input amount' id='txtamt' value='"+amount+"' max='"+amount+"' min=1>Received by: <input type='text' class='form-control' placeholder='Input name' id='txtreceiver'>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#197920',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(res) {
            if (res.isDismissed) {
                document.getElementById('st'+id).checked = c;
            }else{
                var x = $('#txtamt').val();
                if (parseFloat(x) > parseFloat(amount)) {
                    Swal.fire('Amount should not exceed the maximum balance.','','warning');
                    return;
                }
                if ($('#txtreceiver').val()=='') {
                    Swal.fire('Receiver name must not be empty.','','warning');
                    return;
                }
                var xmlHttp= Ajax.httpRequest();
                if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
                var Data = {"id":thisID,"amt":$('#txtamt').val(),"receiver":$('#txtreceiver').val()}
                Data = JSON.stringify(Data);
                var url='<?php echo web_root; ?>php/release/release.php';
                xmlHttp.onreadystatechange=function() { 
                    if (xmlHttp.readyState==4){
                        if (this.responseText == 1) {
                            view_transactions();
                            getBalance(thisID);
                            Swal.fire('','','success');
                        }else{
                            Swal.fire('There is a problem while releasing the money.',this.responseText,'error');
                            // document.getElementById('st'+id).checked = c;
                        }
                    } 
                }
                xmlHttp.open("POST",url,false);  
                xmlHttp.send(Data);
            }
        });
    }
</script>
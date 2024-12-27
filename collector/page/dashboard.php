
<div class="container-fluid">
    <div class="row font-1">
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people</i> Active Member</h5>
                <div class="text-primary ml-auto"><?=$totalmembers?></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center" onclick="open_member();" style="cursor:pointer;">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">attach_money</i> Collectible</h5>
                <div class="text-primary ml-auto"><?=$unpaid?></div>
            </div>
        </div>
        <div class="col-lg-3" onclick="window.location.href='index.php?p=3'" style="cursor:pointer;">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">content_paste</i> No. of Deceased</h5>
                <div class="text-primary ml-auto">
                    <math>
                        <msup>
                            <mn><?=$totalDeceased?></mn>
                        </msup>
                    </math>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modals -->
<div class="modal fade" id="modal_member" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <div class="modal-dialog" role="document" style="max-width: 80%;">
  <!-- <div class="modal-dialog" role="document"> -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Collectible Bills</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <table class="table m-0" id="member_list" width="100%">
                    <thead>
                        <tr class="bg-fade">
                            <th>MEMBER</th>
                            <th>AMOUNT</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_history" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <div class="modal-dialog" role="document" style="max-width: 700px;">
  <!-- <div class="modal-dialog" role="document"> -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-header">
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">
                <!-- <button class="btn btn-primary" style="float: right;" data-target="#modal_member_data" data-toggle="modal" onclick="clear_member();">New</button> -->
            </div>  
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form id="submit_payment" method="POST" action="../php/bill/save.php" class="table-responsive">
                    <!-- <input type="submit" name="" class="btn-primary btn btn-outine btn-sm"> -->
                    <table class="table m-0" id="bill_history" width="100%">
                        <thead>
                            <tr class="bg-fade">
                                <th>MEMBER</th>
                                <th>AMOUNT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<script>
    var thisID = "";
    function open_member() {
        view_member()
        $('#modal_member').modal('toggle');
    }
    function view_member() {
        $('#member_list').DataTable().destroy();
        var DataTable = $('#member_list').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                  'url':'<?php echo web_root; ?>php/bill/view_members_bill.php?iscollector',
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR)
                        Swal.fire('',errorThrown,'error')
                    }
                },
                pageLength: 100,
                'lengthChange': false,
                scrollY: "300px",
                scrollX: true,
                searching: false,
                "paging": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                'columns': [
                    { data: 'name' },
                    { data: 'totalamount' },
                    { data: 'action' },
                ]
        });
        autoSizeDatatableInModal('modal_member');
    }
    function bill_details(id,name) {
        thisID = id;
        $('#modal_history .modal-title').html(decodestr(name));
        view_bill();
        $('#modal_history').modal('toggle');
    }
    function view_bill() {
        $('#bill_history').DataTable().destroy();
        var DataTable = $('#bill_history').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                  'url':'<?php echo web_root; ?>php/bill/view.php?id='+thisID+'&t',
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR)
                        Swal.fire('',errorThrown,'error')
                    }
                },
                pageLength: 100,
                'lengthChange': false,
                scrollY: "300px",
                scrollX: true,
                searching: false,
                "paging": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                'columns': [
                    { data: 'name' },
                    { data: 'amt' },
                    { data: 'status' },
                ]
        });
        autoSizeDatatableInModal('modal_history');
    }
    $('#submit_payment').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        Swal.fire({
            title: 'You are about to pay the bill(s) of the selected member.',
            html: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#197920',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then(function(res) {
            if (res.isDismissed) {

            }else{
                postData.append('id', decodestr(thisID));
                $.ajax({  
                    url:"<?=web_root?>php/bill/save.php",  
                    method:"POST",  
                    data:postData,  
                    contentType:false,  
                    //cache:false,  
                    processData:false,  
                    success:function(data){
                        if (data==1) {
                            view_bill();
                        }else{
                            Swal.fire("" , data,'warning');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Swal.fire("Error:" , textStatus + ", " + errorThrown, 'error');
                    }  
                }) 
            }
        });
    })
    function remove(id,name) {
        Swal.fire({
            title: 'Are you sure you want to remove '+decodestr(name)+'?',
            html: "It is subject for approval from the Administrator.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#197920',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(res) {
            if (res.isDismissed) {
            }else{
                var xmlHttp= Ajax.httpRequest();
                if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
                var Data = {"id":id}
                Data = JSON.stringify(Data);
                var url='<?php echo web_root; ?>php/membership/save_da.php';
                xmlHttp.onreadystatechange=function() { 
                    if (xmlHttp.readyState==4){
                        if (this.responseText == 1) {
                            Swal.fire('','','success');
                        }else{
                            Swal.fire('There is a problem while saving the data',this.responseText,'error');
                        }
                    } 
                }
                xmlHttp.open("POST",url,false);  
                xmlHttp.send(Data);
            }
        });
    }
</script>
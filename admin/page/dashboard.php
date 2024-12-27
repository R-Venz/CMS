
<div class="container-fluid">
    <div class="row font-1">
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people</i> Active Member</h5>
                <div class="text-primary ml-auto"><?=$totalmembers?></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people_outline</i> Pending</h5>
                <div class="text-primary ml-auto"><?=$pending?></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people_outline</i> Inactive</h5>
                <div class="text-primary ml-auto"><?=$inActive?></div>
            </div>
        </div>
        <div class="col-lg-3" onclick="window.location.href='index.php?p=4'" style="cursor:pointer;">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">content_paste</i> No. of Deceased</h5>
                <div class="text-primary ml-auto">
                    <math>
                        <msup>
                            <mn><?=$totalDeceased?></mn>
                            <mn><?=(!empty($totalDeceased)? '<b style="color:red;">'.($totalDeceasedPending==0 ? '' : '('.$totalDeceasedPending.')' ).'</b>':'')?></mn>
                        </msup>
                    </math>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center" onclick="open_member();" style="cursor:pointer;">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people_outline</i> For Deactivation</h5>
                <div class="text-primary ml-auto"><?=$totalForDeactivation?></div>
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
                  'url':'<?php echo web_root; ?>php/bill/view_members_bill.php?t',
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
                  'url':'<?php echo web_root; ?>php/bill/view.php?id='+thisID+'&t=1',
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
    function remove(id,name) {
        Swal.fire({
            title: 'Do you want to deactivate the account of '+decodestr(name)+'?',
            html: "",
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: '#197920',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            denyButtonText: "Cancel"
        }).then(function(res) {
            var st = 'Approved';
            if (res.isDismissed || res.isConfirmed) {
                if (res.isDismissed) {
                    st = 'Rejected';
                }
                var xmlHttp= Ajax.httpRequest();
                if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
                var Data = {"id":id,"st":st}
                Data = JSON.stringify(Data);
                var url='<?php echo web_root; ?>php/membership/updateda.php';
                xmlHttp.onreadystatechange=function() { 
                    if (xmlHttp.readyState==4){
                        if (this.responseText == 1) {
                            view_member();
                            Swal.fire('','','success');
                        }else{
                            Swal.fire('There is a problem while updating the data',this.responseText,'error');
                        }
                    } 
                }
                xmlHttp.open("POST",url,false);  
                xmlHttp.send(Data);
            }
        });
    }
</script>
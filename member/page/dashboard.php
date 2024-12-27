
<div class="container-fluid">
    <?php  
        if (isset($_SESSION['CMS_member_status'])) {
            if ($_SESSION['CMS_member_status'] == 'Inactive') {
    ?>
                <hr>
                <div class="row">
                    <div class="col-lg-12" style="text-align: center; background-color: red;color:white;">
                        <h1>YOU WERE REMOVED FROM THE MEMBERSHIP.</h1>
                        <h5>You can contact the Kapunungan President for more details.</h5>
                    </div>
                </div>
                <hr>

    <?php   }
        }
    ?>
    <div class="row font-1">
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">people</i> Family Member</h5>
                <div class="text-primary ml-auto"><?=$totalmembers?></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">account_balance_wallet</i> Balance</h5>
                <div class="text-primary ml-auto"><?=$balance?></div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">account_balance_wallet</i> Unpaid</h5>
                <div class="text-primary ml-auto"><?=$unpaid?></div>
            </div>
        </div>
        <div class="col-lg-3" onclick="bill_details('<?=$_SESSION['CMS_member_id']?>');" style="cursor: pointer;">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">content_paste</i> Payment History</h5>
                <div class="text-primary ml-auto"></div>
            </div>
        </div>
        <div class="col-lg-3" onclick="window.location.href='index.php?p=4'" style="cursor:pointer;">
            <div class="card card-body flex-row align-items-center">
                <h5 class="m-0"><i class="material-icons align-middle text-muted md-18">content_paste</i> No. of Deceased</h5>
                <div class="text-primary ml-auto">
                    <math>
                        <msup>
                            <mn><?=(!empty($totalDeceasedPosted)? '<b style="color:red;">'.($totalDeceasedPosted==0 ? '' : '('.$totalDeceasedPosted.')' ).'</b>':'')?></mn>
                        </msup>
                    </math>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <h1>ANNOUNCEMENT</h1>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">

                <table class="table m-0" id="user_list" width="100%">
                    <thead>
                        <tr class="bg-fade">
                            <th>NAME</th>
                            <th>DATE OF DEATH</th>
                            <th>CAUSE OF DEATH</th>
                            <th>DECLERANT</th>
                            <th>AGE</th>
                            <th>DEADLINE</th>
                            <!-- <th>ACTION</th> -->
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
                <!-- <button class="btn btn-primary" style="float: right;" data-target="#modal_member_data" data-toggle="modal" onclick="clear_member();">New</button> -->
            </div>  
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form id="submit_payment" method="POST" action="../php/bill/save.php" class="table-responsive">
                    <table class="table m-0" id="bill_history" width="100%">
                        <thead>
                            <tr class="bg-fade">
                                <th><!-- MEMBER --></th>
                                <th><!-- AMOUNT --></th>
                                <th><!-- STATUS --></th>
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
    view_death();
    function open_member() {
        view_member();
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
    function bill_details(id) {
        thisID = id;
        view_bill();
        $('#modal_history').modal('toggle');
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
    function view_bill() {
        $('#bill_history').DataTable().destroy();
        var DataTable = $('#bill_history').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                  'url':'<?php echo web_root; ?>php/bill/view.php?id='+thisID+'&ismember',
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
    function view_death() {
        $('#user_list').DataTable().destroy();
        var empDataTable = $('#user_list').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'<?php echo web_root; ?>php/death/view.php?ismemberdashboard',
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
                  { data: 'deadline'},
                  // { data: 'action'},
              ]
        });
    }
</script>
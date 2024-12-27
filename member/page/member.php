<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <div class="form-group mb-0">
                        <label class="control-label mr-1">Search: </label>
                        <input type="text" class="form-control" id="txtsearch" onkeyup="view_member();" placeholder="Enter data to search">
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
                <div class="col-lg-4">
                </div>  
            </div>
        </div>
        <div class="table-responsive">
            <table class="table m-0" id="member_list" width="100%">
                <thead>
                    <tr class="bg-fade">
                        <th>NAME</th>
                        <th>DATE OF BIRTH</th>
                        <th>EMAIL</th>
                        <th>CONTACT NUMBER</th>
                        <th>ROLE</th>
                        <th>RELATIONSHIP</th>
                        <!-- <th>ACTION</th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <!-- <table class="table m-0" id="user_list" width="100%">
                <thead>
                    <tr class="bg-fade">
                        <th>NAME</th>
                        <th width="180px">CONTACT NUMBER</th>
                        <th width="20px">MEMBER</th>
                        <th>ADDRESS</th>
                        <th width="20px">STATUS</th>
                        <th width="20px">ACTION</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table> -->
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <!-- <div class="modal-dialog" role="document" style="max-width: 80%;"> -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Membership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="user_form">
        <div class="modal-body">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter given name" required>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name</label>
                <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter middle name" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="cnum">Contact Number</label>
                <input type="text" class="form-control" id="cnum" name="cnum" placeholder="Enter mobile number" required>
            </div>
            <div class="form-group">
                <label for="addr">Address</label>
                <input type="text" class="form-control" id="addr" name="addr" placeholder="Enter address" required>
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

<div class="modal fade" id="modal_user_update" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <!-- <div class="modal-dialog" role="document" style="max-width: 80%;"> -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Membership</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="user_form_update">
        <div class="modal-body">
            <div class="form-group">
                <label for="addr2">Address</label>
                <input type="text" class="form-control" id="addr2" name="addr2" placeholder="Enter address" required>
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

<div class="modal fade" id="modal_members" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <div class="modal-dialog" role="document" style="max-width: 80%;">
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
                <button class="btn btn-primary" style="float: right;" data-target="#modal_member_data" data-toggle="modal" onclick="clear_member();">New</button>
            </div>  
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="table-responsive">
                    <table class="table m-0" id="member_list" width="100%">
                        <thead>
                            <tr class="bg-fade">
                                <th>NAME</th>
                                <th>DATE OF BIRTH</th>
                                <th>EMAIL</th>
                                <th>CONTACT NUMBER</th>
                                <th>ROLE</th>
                                <th>RELATIONSHIP</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
<!-- Modals -->
<div class="modal fade" id="modal_member_data" tabindex="-1" role="dialog" aria-labelledby="modal_userLabel" aria-hidden="true" style="z-index: 999999!important;">
  <!-- <div class="modal-dialog" role="document" style="max-width: 80%;"> -->
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_userLabel">Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" id="member_form">
        <div class="modal-body">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname2" name="fname" placeholder="Enter given name" required>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name</label>
                <input type="text" class="form-control" id="mname2" name="mname" placeholder="Enter middle name" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname2" name="lname" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob2" name="dob" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email2" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="cnum">Contact Number</label>
                <input type="text" class="form-control" id="cnum2" name="cnum" placeholder="Enter mobile number" required>
            </div>
            <div class="form-group">
                <label for="role2">Role</label>
                <select type="text" class="form-control" id="role2" name="role" required>
                    <option>Member</option>
                    <option>Head</option>
                </select>
            </div>
            <div class="form-group">
                <label for="relationship">Relationship</label>
                <select type="text" class="form-control" id="relationship2" name="relationship">
                    <option value="">N/A</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Daughter">Daughter</option>
                    <option value="Son">Son</option>
                    <option value="Mother">Mother</option>
                    <option value="Father">Father</option>
                    <option value="Granddaughter">Granddaughter</option>
                    <option value="Grandson">Grandson</option>
                    <option value="Grandfather">Grandfather</option>
                    <option value="Grandmother">Grandmother</option>
                    <option value="Others">Others</option>
                </select>
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
    var thisID = "<?=$_SESSION['CMS_member_id']?>";
    var mID='';
    var mmID='';
    $("input[name='bootstrap-switch']").bootstrapSwitch();
    $(function(){
        $('.bootstrap-switch-handle-off').html('');
        $('.bootstrap-switch-handle-on').html('');
        view_member();
    });
    function view() {
        $('#user_list').DataTable().destroy();
        var empDataTable = $('#user_list').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'<?php echo web_root; ?>php/membership/view.php?sr='+$('#txtsearch').val(),
                    error: function (jqXHR, textStatus, errorThrown) {
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
                  { data: 'cnum' },
                  { data: 'member' },
                  { data: 'addr' },
                  { data: 'status' },
                  { data: 'action'},
              ]
        });
        
    }
    function clearUser() {
        $('#user_form')[0].reset();
        thisID='';
    }
    function details(id,addr) {
        clearUser();
        thisID = id;
        $('#addr2').val(decodestr(addr));
        $('#modal_user_update').modal('toggle');
    }
    $('#user_form').on('submit', function(e){
        e.preventDefault();
        
        var postData = new FormData(this);
        postData.append('id', decodestr(thisID));
        $.ajax({  
            url:"<?=web_root?>php/membership/save.php",  
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
    $('#user_form_update').on('submit', function(e){
        e.preventDefault();
        
        var postData = new FormData(this);
        postData.append('id', decodestr(thisID));
        $.ajax({  
            url:"<?=web_root?>php/membership/save.php?t=1",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    Swal.fire("Data saved!", "", "success");
                    $('#modal_user_update').modal('toggle');
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
    function updatestatus(id) {
        var s = 'Deactivate';
        var st = 'Inactive';
        var c = 'false';
        if (document.getElementById('st'+id).checked==true) {
            st = 'Active';
            s = 'Activate';
            c = 'true';
        }
        Swal.fire({
            title: 'Are you sure you want to '+s+' this member?',
            html: "<input type='text' placeholder='Type `CONFIRM`' id='txtConfirm'>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#197920',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then(function(res) {
            if (res.isDismissed) {
                document.getElementById('st'+id).checked = c;
            }else{
                if ($('#txtConfirm').val() !== 'CONFIRM') {
                    Swal.fire('You must type the word `CONFIRM` to continue.','','warning');
                    document.getElementById('st'+id).checked = c;
                    return;
                }
                var xmlHttp= Ajax.httpRequest();
                if(xmlHttp==null){Swal.fire("Ajax not supported by your browser!!! \nPlease update your browser.","","warning"); return;}
                var Data = {"id":id,"st":st}
                Data = JSON.stringify(Data);
                var url='<?php echo web_root; ?>php/membership/updatestatus.php';
                xmlHttp.onreadystatechange=function() { 
                    if (xmlHttp.readyState==4){
                        if (this.responseText == 1) {
                            Swal.fire('','','success');
                        }else{
                            Swal.fire('There is a problem while fetching the data',this.responseText,'error');
                            document.getElementById('st'+id).checked = c;
                        }
                    } 
                }
                xmlHttp.open("POST",url,false);  
                xmlHttp.send(Data);
            }
        });
    }
    function open_member(id) {
        clear_member();
        thisID = id;
        view_member()
        $('#modal_members').modal('toggle');
    }
    function view_member() {
        $('#member_list').DataTable().destroy();
        var DataTable = $('#member_list').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'<?php echo web_root; ?>php/member/view.php?sr='+$('#txtsearch').val()+'&mpid='+thisID,
                    error: function (jqXHR, textStatus, errorThrown) {
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
                  { data: 'dob' },
                  { data: 'email' },
                  { data: 'cnum' },
                  { data: 'role' },
                  { data: 'relationship' },
                  // { data: 'action'},
              ]
        });
    }
    function details_member(id,fname,mname,lname,dob,email,cnum,role,relationship,mmid) {
        clear_member();
        mID = id;
        mmID = mmid;
        $('#fname2').val(decodestr(fname));
        $('#mname2').val(decodestr(mname));
        $('#lname2').val(decodestr(lname));
        $('#dob2').val(decodestr(dob));
        $('#email2').val(decodestr(email));
        $('#cnum2').val(decodestr(cnum));
        $('#role2').val(decodestr(role));
        $('#relationship2').val(decodestr(relationship));
        $('#modal_member_data').modal('toggle');
    }
    function clear_member() {
        $('#member_form')[0].reset();
        mmID='';
    }
    $('#member_form').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        postData.append('mpid', decodestr(thisID));
        postData.append('id', decodestr(mID));
        postData.append('mmid', decodestr(mmID));
        $.ajax({  
            url:"<?=web_root?>php/member/save.php",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    Swal.fire("Data saved!", "", "success");
                    $('#modal_member_data').modal('toggle');
                    view_member();
                    view();
                    clear_member();
                }else{
                    Swal.fire("" , data,'warning');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire("Error:" , textStatus + ", " + errorThrown, 'error');
            }  
        }) 
    })
</script>
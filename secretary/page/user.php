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
                    <button class="btn btn-primary" style="float: right;" data-target="#modal_user" data-toggle="modal" onclick="clearUser();">New</button>
                </div>  
            </div>
        </div>
        <div class="table-responsive">

            <table class="table m-0" id="user_list" width="100%">
                <thead>
                    <tr class="bg-fade">
                        <th>NAME</th>
                        <th>ROLE</th>
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
        <h5 class="modal-title" id="modal_userLabel">User Details</h5>
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
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter last name" required>
            </div>
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" id="uname" name="uname" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label for="role">User Role</label>
                <select type="text" class="form-control" id="role" name="role" required>
                    <option>Collector</option>
                    <option>Treasurer</option>
                    <option>Secretary</option>
                    <option>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select type="text" class="form-control" id="status" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
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
    var thisID = "";
    $(function(){
        view();
    });
    function view() {
        $('#user_list').DataTable().destroy();
        var empDataTable = $('#user_list').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'<?php echo web_root; ?>php/user/view.php?sr='+$('#txtsearch').val(),
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
                  { data: 'role' },
                  { data: 'status' },
                  { data: 'action'},
              ]
        });
    }
    function clearUser() {
        $('#user_form')[0].reset();
        thisID=''
        document.getElementById('pass').required= true;
    }
    function details(id,fname,lname,uname,pass,role,status) {
        clearUser();
        document.getElementById('pass').required= false;
        thisID = id;
        $('#fname').val(decodestr(fname));
        $('#lname').val(decodestr(lname));
        $('#uname').val(decodestr(uname));
        // $('#pass').val(decodestr(pass));
        $('#role').val(decodestr(role));
        $('#status').val(decodestr(status));
        $('#modal_user').modal('toggle');
    }
    $('#user_form').on('submit', function(e){
        e.preventDefault();
        
        var postData = new FormData(this);
        postData.append('id', decodestr(thisID));
        $.ajax({  
            url:"<?=web_root?>php/user/save.php",  
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
</script>
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
                <select type="text" class="form-control select-2" id="mid" name="mid" required onchange="getFamilyMember();" style="width: 100%;">
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
                <input type="date" class="form-control" id="dod" name="dod" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="cod">Cause of Death</label>
                <input type="text" class="form-control" id="cod" name="cod" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="dec">Declarant</label>
                <select type="text" class="form-control select-2" id="dec" name="dec" required style="width: 100%;">

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
                  'url':'<?php echo web_root; ?>php/death/view.php?sr='+$('#txtsearch').val(),
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
</script>
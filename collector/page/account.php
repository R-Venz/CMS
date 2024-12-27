<!-- content -->                    <!-- main content -->
    <div class="py-4 mb-3 bg-white border-bottom">
        <div class="container-fluid container-account">
            <div class="row">
                <div class="col-lg-6">
                    <div class="media media-user-info align-items-center">
                        <img src="assets/images/avatars/person-3.jpg" class="img-fluid rounded-circle mr-2" width="60" alt="">
                        <div class="media-body lh-1">
                            <p class="h4 m-0"><?=strtoupper($_SESSION['CMS_collector_fname'] . ' ' .$_SESSION['CMS_collector_lname'])?> <small style="color:<?=($_SESSION['CMS_collector_status']=='Active') ? 'green':'red' ?>"><?=$_SESSION['CMS_collector_status']?></small></p>
                            <p class="text-muted mb-0"><?=strtoupper($_SESSION['CMS_collector_role'])?></p>
                            
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-6 d-md-flex align-items-center justify-content-end">
                    <p class="mb-0 mr-3">
                        <i class="material-icons md-18 align-middle text-primary">shopping_cart</i> Sales: <strong>$425</strong>
                    </p>
                    <p class="mb-0">
                        <i class="material-icons md-18 align-middle text-primary">monetization_on</i> Income: <strong>$28,325.98</strong>
                    </p>
                </div> -->
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <ul class="nav nav-pills mb-2" id="accountTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="overview">Account</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings">Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" role="tab" aria-controls="billing">Billing</a>
            </li> -->
        </ul>
        <div class="tab-content" id="accountTabsContent">
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card card-account">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label>First Name</label>
                                        <div class="input-group input-group--inline">
                                            <div class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </div>
                                            <input type="text" class="form-control" readonly value="<?=$_SESSION['CMS_collector_fname']?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Last Name</label>
                                        <div class="input-group input-group--inline">
                                            <div class="input-group-addon">
                                                <i class="material-icons">person</i>
                                            </div>
                                            <input type="text" class="form-control" readonly value="<?=$_SESSION['CMS_collector_lname']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="instant-messaging">Username</label>
                                    <div class="input-group input-group--inline">
                                        <div class="input-group-addon">
                                            <i class="material-icons">message</i>
                                        </div>
                                        <input type="text" class="form-control" readonly id="u" value="<?=$_SESSION['CMS_collector_uname']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group input-group--inline">
                                        <div class="input-group-addon">
                                            <i class="material-icons">message</i>
                                        </div>
                                        <input type="password" class="form-control" value="***********" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <div class="input-group input-group--inline">
                                        <div class="input-group-addon">
                                            <i class="material-icons">web</i>
                                        </div>
                                        <input type="text" class="form-control" readonly value="<?=$_SESSION['CMS_collector_role']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h4 class="card-title">Login Details</h4>
                            </div>
                            <ul class="list-group list-group-flush">

                                <form id="user_form">
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">message</i>
                                                </div>
                                                <input type="text" class="form-control" id="uname" name="uname" value="<?=$_SESSION['CMS_collector_uname']?>" placeholder="Enter username" required>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">message</i>
                                                </div>
                                                <input type="password" class="form-control" id="pass" name="pass" placeholder="Enter password" required>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                        <div class="form-group">
                                            <label>Re-type Password</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">message</i>
                                                </div>
                                                <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Re-type password" required>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between">
                                        <button class="btn btn-success">Save changes</button>
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <form id="settings_form">
                                    <div class="form-group">
                                        <label>Contribution</label>
                                        <input type="number" class="form-control" value="<?=$contribution?>" required min="1" name="contribution">
                                    </div>
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="billing-tab">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-account">
                            <div class="card-body">
                                <form>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label>First Name</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">person</i>
                                                </div>
                                                <input type="text" class="form-control" name="firstname" placeholder="John">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Last Name</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">person</i>
                                                </div>
                                                <input type="text" class="form-control" name="lastname" placeholder="Mix">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label>Address</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">streetview</i>
                                                </div>
                                                <input type="text" class="form-control" name="address" placeholder="Street Avenue, Nr. 24">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Apt. / Suite</label>
                                            <div class="input-group input-group--inline">
                                                <div class="input-group-addon">
                                                    <i class="material-icons">home</i>
                                                </div>
                                                <input type="text" class="form-control" name="suite" placeholder="G9, Apt. 28">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="input-group input-group--inline">
                                            <div class="input-group-addon">
                                                <i class="material-icons">phone</i>
                                            </div>
                                            <input type="text" class="form-control" name="phone" placeholder="1-541-754-3010">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Company</label>
                                        <div class="input-group input-group--inline">
                                            <div class="input-group-addon">
                                                <i class="material-icons">business</i>
                                            </div>
                                            <input type="text" class="form-control" name="company" placeholder="LTD">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Website</label>
                                        <div class="input-group input-group--inline">
                                            <div class="input-group-addon">
                                                <i class="material-icons">web</i>
                                            </div>
                                            <input type="text" class="form-control" name="website" placeholder="https://www.hero.com">
                                        </div>
                                    </div>
                                    <button class="btn btn-success">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Payment Methods
                                </h4>
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="#paymentMethod" class="list-group-item list-group-item-action" data-toggle="modal">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <h6>Credit card</h6>
                                            <p class="text-muted mb-0">
                                                XXXX-XXXX-XXXX-4120
                                            </p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#paymentMethod" class="list-group-item list-group-item-action" data-toggle="modal">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <h6>Credit card</h6>
                                            <p class="text-muted mb-0">
                                                XXXX-XXXX-XXXX-3981
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $('#user_form').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        postData.append('id', decodestr('<?=$_SESSION['CMS_collector_id']?>'));
        $.ajax({  
            url:"<?=web_root?>php/user/updateaccount.php",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    $('#u').val($('#uname').val());
                    Swal.fire("Account updated!", "", "success");
                }else{
                    Swal.fire("" , data,'warning');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire("Error:" , textStatus + ", " + errorThrown, 'error');
            }  
        }) 
    })
    $('#settings_form').on('submit', function(e){
        e.preventDefault();
        var postData = new FormData(this);
        postData.append('id', decodestr('<?=$_SESSION['CMS_collector_id']?>'));
        $.ajax({  
            url:"<?=web_root?>php/settings/save.php",  
            method:"POST",  
            data:postData,  
            contentType:false,  
            //cache:false,  
            processData:false,  
            success:function(data){
                if (data==1) {
                    Swal.fire("Settings updated", "", "success");
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
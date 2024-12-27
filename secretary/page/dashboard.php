
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
        <div class="col-lg-3" onclick="window.location.href='index.php?p=3'" style="cursor:pointer;">
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
    </div>
</div>
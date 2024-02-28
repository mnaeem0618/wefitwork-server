<?php if ($this->uri->segment(3) == 'manage'){ ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Add/Edit Member')); ?>
    <div class="row col-md-12 margin-bottom-10">
        <!-- <div class="col-md-12"> -->
            <div class="form-group">
                <div class="col-md-6">
                    <h2 class="no-margin"><i class="entypo-users"></i> Add/Edit <strong> Member</strong></h2>
                </div>
                <div class="col-md-6 text-right">
                    <a href="<?= base_url(ADMIN . '/members') ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
                </div>
            </div>
        <!-- </div> -->
    </div>
    <div>
    <div class="row col-md-12">
        <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            
            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Member Detail</h3>
                <hr class="hr-short">
                <div class="col-md-6">
                    <div style="margin:15px 0px" class="">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Profile Image
                                </div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <?php
                            get_site_image_src("members", $row->mem_image);
                        ?>
                        <div class="panel-body">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row->mem_image) ? get_site_image_src("members", $row->mem_image) : 'http://placehold.it/700x620' ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                <div>
                                <span class="btn btn-black btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="mem_image" accept="image/*" >
                                </span>
                                <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="control-label"> Status</label>
                            <select name="mem_status" id="mem_status" class="form-control">
                                <option value="1" <?php
                                    if (isset($row->mem_status) && '1' == $row->mem_status) {
                                    echo 'selected';
                                    }
                                ?>>Active</option>
                                <option value="0" <?php
                                    if (isset($row->mem_status) && '0' == $row->mem_status) {
                                    echo 'selected';
                                    }
                                ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label"> Verified</label>
                            <select name="mem_verified" id="mem_verified" class="form-control">
                                <option value="1" <?php
                                    if (isset($row->mem_verified) && '1' == $row->mem_verified) {
                                    echo 'selected';
                                    }
                                ?>>Yes</option>
                                <option value="0" <?php
                                    if (isset($row->mem_verified) && '0' == $row->mem_verified) {
                                    echo 'selected';
                                    }
                                ?>>No</option>
                            </select>
                        </div>
                       
                        
                    </div>
                </div>
                
                <div class="clearfix"></div>
              
                        <div class="col-md-12">
                            <label class="control-label"> Full Name <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_fname" value="<?php if (isset($row->mem_fname)) echo $row->mem_fname; ?>" class="form-control" autofocus required>
                        </div>
                       
                   
                        <div class="col-md-6">
                            <label class="control-label">Email <span class="symbol required" style="color: red">*</span></label>
                            <input type="text" name="mem_email" 
                            <?php if (isset($row->mem_email)) { echo 'readonly';} ?>  
                            value="<?php if (isset($row->mem_email)) echo $row->mem_email; ?>"  class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Phone No </label>
                            <input type="text" name="mem_phone" value="<?php if (isset($row->mem_phone)) echo $row->mem_phone; ?>"  class="form-control" >
                        </div>
                  
            <div class="clearfix"></div>
            <?php if($row->mem_type == 'professional'): ?>
<hr>
            <h3><i class="fa fa-bars"></i> Professioanl Profile Detail</h3>
                <hr class="hr-short">
                <table class="table table-bordered">
           
           <tbody>
               <tr>
                   <th>Service Title</th>
                   <td><?= get_service_title($pro_profile->service_id);?></td>
                   <th>Sub Services</th>
                   <td>
                   <?php
    $sub_servs = get_sub_services($pro_profile->id, $row->mem_id);
    $sub_service_titles = array();

    foreach ($sub_servs as $sub):
        $sub_service_titles[] = get_sub_service_title($sub->sub_service_id);
    endforeach;

    // Join the sub-service titles with commas and display
    echo implode(', ', $sub_service_titles);
    ?>
                   </td>
                 
               </tr>
               <tr>
                   <th>Business Name</th>
                   <td><b><?= $pro_profile->business_name ?></b></td>
                   <th>Business Phone</th>
                   <td><?=  $pro_profile->business_phone ?></td>
               </tr>
               
               <tr>
                   <th>Business Type</th>
                   <td><?= $pro_profile->business_type ?></td>
                   <th>Business Address</th>
                   <td><?= $pro_profile->business_address ?></td>
               </tr>
               <tr>
                   
                   <th>Date</th>
                   <td><?= format_date($pro_profile->created_date, 'M d, Y h:i:s a');?></td>
                   <th>Business Phone verification</th>
                   <td><?= get_member_verified_status($pro_profile->phone_verified) ?></td>
               </tr>

               
           </tbody>
       </table>
                      
                        <?php endif; ?>
                  
            <div class="clearfix"></div>

            <div class="col-md-12">
                <hr class="hr-short">
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
        <div class="clearfix"></div>
    </div>

    <?php }elseif ($this->uri->segment(3) == 'manage_subscription'){ ?>
<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Add/Update Member Subscription')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-users"></i> Add/Update <strong>Member Subscription</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/members'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
    </div>
</div>
<div>
    <hr>
    <div class="row col-md-12">
        
            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Active Subscription Detail</h3>
                <hr class="hr-short">
                <table class="table table-bordered">
           
           <tbody>
               <tr>

                    <th>Paystack Plan Code</th>
                   <td><b><?= $subscription->paystack_plan_code ?></b></td>
                   <th>Paystack Plan Name</th>
                   <td><b><?= $subscription->paystack_plan_name ?></b></td>
                                    
               </tr>
               <tr>
                   <th>Paystack Customer Code</th>
                   <td><b><?= $subscription->paystack_customer_code ?></b></td>
                   <th>Customer Name</th>
                   <td><b><?= get_mem_name($subscription->mem_id) ?></b></td>
               </tr>
               
               <tr>
                   <th>Paystack Subscription Code</th>
                   <td><b><?= $subscription->paystack_subscription_code ?></b></td>
                   <th>Subscription Status</th>
                   <td><b><?= get_subscription_status($subscription->subscription_status) ?></b></td>
               </tr>
               <tr>
                   
                   <th>Subscription Start Date</th>
                   <td><b><?= format_date($subscription->start_date, 'M d, Y h:i:s a');?></b></td>
                   <th>Subscription End Date</th>
                   <td><b><?= format_date($subscription->end_date, 'M d, Y h:i:s a');?></b></td>
                  
               </tr>
               <tr>
                   
                   <th>Amount Charged</th>
                   <td><b><?= format_amount($subscription->amount, 2);?></b></td>
                   
                  
               </tr>

               
           </tbody>
       </table>

                
            </div>

            <div class="col-md-12">
                <h3><i class="fa fa-bars"></i> Previous Subscriptions Detail</h3>
                <hr class="hr-short">
                <table class="table table-bordered">
           
                <thead>
            <tr>
            <th width="5%" class="text-center">Sr#</th>
                <th>Plan Code</th>
                <th>Subscription Code</th>
                <th>Customer Code</th>
                <th>Amount</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Subscription Status</th>
            </tr>
        </thead>
        <tbody>
            <?php  if (countlength($mem_subscriptions) > 0): $sub_count = 0; ?>
                <?php foreach ($mem_subscriptions as $sub):  ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?php echo ++$sub_count; ?></td>
                        <td><b><?= $sub->paystack_plan_code ?></b></td>
                        <td><b><?= $sub->paystack_subscription_code ?></b></td>
                        <td><b><?= $sub->paystack_customer_code ?></b></td>
                        <td><b><?= format_amount($sub->amount) ?></b></td>
                        <td><b><?= format_date($sub->start_date, 'M d, Y h:i:s a') ?></b></td>
                        <td><b><?= format_date($sub->end_date, 'M d, Y h:i:s a') ?></b></td>
                        <td><b><?= get_subscription_status($sub->subscription_status) ?></b></td>


                    </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
       </table>

                
            </div>
      
        <div class="clearfix"></div>
    </div>

<?php }else{ ?>
    <?php echo showMsg(); ?>
    <?php echo getBredcrum(ADMIN, array('#' => 'Manage Members')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-users"></i> Manage <strong>Members</strong></h2>
        </div>
        <div class="col-md-6 text-right">
        </div>
    </div>
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
            <th width="5%" class="text-center">Sr#</th>
                <th width="10%">Photo</th>
                <th width="20%">Name</th>
                <th width="8%" class="text-center">Member Type</th>
                <th>Email</th>
                <th>Phone</th>
                <th width="8%" class="text-center">Verified Status</th>
                <th width="8%" class="text-center">Status</th>
                <th width="8%" class="text-center">Registered On</th>
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php  if (countlength($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row):  ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?php echo ++$count; ?></td>
                        <td class="text-center">
                            <img src = "<?= get_site_image_src("members", $row->mem_image)?>" height="40">
                        </td>
                        <td><?= get_mem_name($row->mem_id); ?></td>
                        <td><?= get_member_type($row->mem_type); ?></td>
                        <td><?= $row->mem_email; ?></td>
                        <td><?= $row->mem_phone; ?></td>
                        <td><?= get_member_verified_status($row->mem_verified); ?></td>          
                        <td class="text-center"><?= get_member_active_status($row->mem_status); ?></td>
                       <td><?=format_date($row->mem_date, 'M, d Y H:i A') ?></td>


                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <?php if ($row->mem_status == '0'): ?>
                                        <li><a href="<?= base_url(ADMIN); ?>/members/active/<?= $row->mem_id; ?>">Active</a></li>
                                    <?php else: ?>
                                        <li><a href="<?= base_url(ADMIN); ?>/members/inactive/<?= $row->mem_id; ?>">Inactive</a></li>
                                    <?php endif; ?> 

                                    <?php if($row->mem_type == 'professional'):  ?>
                                        <li><a href="<?= base_url(ADMIN); ?>/members/manage_subscription/<?= $row->mem_id; ?>">Manage Subscription</a></li>

                                    <?php endif;  ?>

                                    
                                    <li><a href="<?= base_url(ADMIN); ?>/members/manage/<?= $row->mem_id; ?>">View Member</a></li>
                                   
                                    <li class="divider"></li>
                                    <li><a href="<?= base_url(ADMIN); ?>/members/delete/<?= $row->mem_id;?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>  
                        </td>
                    </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>
<?php } ?>
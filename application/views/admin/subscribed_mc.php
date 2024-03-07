<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Subscribed Maintenance Cover')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Update <strong>Subscribed Maintenance Cover</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/subscribed_mc'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
               <?php $mem = get_mem_row($row->mem_id) ?>
            <h3><i class="fa fa-bars"></i> Details:</h3>
                <hr class="hr-short">
                <table class="table table-bordered">
           
           <tbody>
               <tr>
                   <th><b>Maintenance Cover</b></th>
                   <td><?= get_maintenance_cover_service_title($row->maintenance_cover_id);?></td>
                   <th><b>Address</b></th>
                   <td><?= $row->address; ?></td>
                 
               </tr>

               <tr>
                   <th><b>Member</b></th>
                   <td><?= get_mem_name($row->mem_id);?></td>
                   <th><b>Paystack Customer Code</b></th>
                   <td><?= $mem->mem_paystack_customer_code ?></td>
                   
                 
               </tr>

               <tr>
                   <th><b>Transaction Refrenece</b></th>
                   <td><b><?= $row->trxn_reference ?></b></td>
                   <th><b>Status</b></th>
                   <td><b><?= get_active_status($row->status) ?></b></td>
               </tr>

               <tr>
                   
                   <th><b>Created Date</b></th>
                   <td><?= format_date($row->created_date, 'D, d M Y'); ?></td>
               </tr>
               

               
           </tbody>
       </table>


                                  
                
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Subscribed Maintenance Covers')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Subscribed Maintenance Covers</strong></h2>
        </div>
        <!-- <div class="col-md-6 text-right">
           
            <a href="<?= site_url(ADMIN . '/subscribed_mc/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div> -->
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Maintenance Cover</th>
                <th>Member Name</th>
                <th>Address</th>
                <th>Status</th>
                <th>Created Date</th>


                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td class="text-center"><?= get_maintenance_cover_service_title($row->maintenance_cover_id); ?></td>
                        <td class="text-center"><?= get_mem_name($row->mem_id); ?></td>
                        <td ><?= $row->address; ?></td>
                        <td class="text-center"><?= get_active_status($row->status); ?></td>
                        <td class="text-center"><?= format_date($row->created_date, 'D, d M Y'); ?></td>

                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN.'/subscribed_mc/manage/'.$row->id); ?>">View</a></li>
                                    <!-- <li><a href="<?= site_url(ADMIN.'/subscribed_mc/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li> -->
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php endif; ?> 
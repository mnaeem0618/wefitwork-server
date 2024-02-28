<?php if ($this->uri->segment(3) == 'manage'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Update Maintenance Cover Request')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Update <strong>Maintenance Cover Request</strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/mc_requests'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">                   
                                        
                    <div class="col-md-6">
                        <label class="control-label" for="status"> Status <span class="symbol required">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">---- Set Request Status ------</option>
                            <option value="pending" <?php
                            if (isset($row->status) && 'pending' == $row->status) {
                                echo 'selected';
                            }
                            ?>>Pending</option>

                            <option value="in_progress" <?php
                            if (isset($row->status) && 'in_progress' == $row->status) {
                                echo 'selected';
                            }
                            ?>>In Progress</option>

                            <option value="completed" <?php
                            if (isset($row->status) && 'completed' == $row->status) {
                                echo 'selected';
                            }
                            ?>>Completed</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>      
                    
                    <div class="col-md-6">                
                    <hr class="hr-short">
                    <div class="form-group text-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-md col-md-2 pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
                    
                </div>

                <hr>
            <h3><i class="fa fa-bars"></i> Maintenance Request Details:</h3>
                <hr class="hr-short">
                <table class="table table-bordered">
           
           <tbody>
               <tr>
                   <th><b>MC Service Title</b></th>
                   <td><?= get_maintenance_cover_service_title($row->maintenance_cover_id);?></td>
                   <th><b>MC Sub Service</b></th>
                   <td><?= get_mc_sub_service_title($row->sub_cat_id); ?></td>
                   <th><b>Status</b></th>
                   <td><?= get_mc_request_status($row->status); ?></td>
                 
               </tr>

               <tr>
                   <th><b>Address</b></th>
                   <td colspan="2"><?= $row->address;?></td>
                   <th><b>Created Date</b></th>
                   <td colspan="2"><?= format_date($row->created_date, 'D, d M Y'); ?></td>
                 
               </tr>

               <tr>
                   <th><b>Request Title</b></th>
                   <td colspan="5"><b><?= $row->request_title ?></b></td>
                   
               </tr>

               <tr>
                   <th><b>Request Detail</b></th>
                   <td colspan="5"><b><?= $row->detail ?></b></td>
                   
               </tr>
               

               
           </tbody>
       </table>

       <hr>
            <div class="row col-md-12">

                
                    <h3><i class="fa fa-image"></i> Request Images</h3>
                    <hr class="hr-short">

                    <?php if (!empty($request_images)) :
                        foreach ($request_images as $img):?>
    
                            <div class="col-md-2">
                                <button type="button" data-toggle="modal" data-target="#ImageModal<?= $img->id ?>">
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                    
                                                    
                                                        <img width="100%" src="<?= get_site_image_src('members/mc_request_images', $img->image, '', false) ?>" alt="--">
                                                 
                                        </div>
                                        
                                    </div>
                            

                            </div>

                            <!-- Modal -->
                            <div id="ImageModal<?= $img->id ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog ">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        
                                        <div class="modal-body">
                                            
                                                <img width="100%" src="<?= get_site_image_src('members/mc_request_images', $img->image, '', false) ?>" alt="--">
                                          
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <?php endforeach;

                    else : ?>

                        <div class="alert alert-danger text-center">No Request Image Uploaded</div>
                    <?php
                    endif;
                    ?>







       



                <div class="clearfix"></div>
            </div>

                                  
                
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Manage Maintenance Cover Requests')); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Manage <strong>Maintenance Cover Requests</strong></h2>
        </div>
        <!-- <div class="col-md-6 text-right">
           
            <a href="<?= site_url(ADMIN . '/mc_requests/manage'); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
        </div> -->
    </div>

    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Request Title</th>
                <th>MC Service</th>
                <th>MC Sub Service</th>
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
                        <td><b><?= $row->request_title ?></b></td>
                        <td class="text-center"><?= get_maintenance_cover_service_title($row->maintenance_cover_id); ?></td>
                        <td class="text-center"><?= get_mc_sub_service_title($row->sub_cat_id); ?></td>
                        <td ><?= $row->address; ?></td>
                        
                        <td class="text-center"><?= get_mc_request_status($row->status); ?></td>
                        <td class="text-center"><?= format_date($row->created_date, 'D, d M Y'); ?></td>

                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN.'/mc_requests/manage/'.$row->id); ?>">View</a></li>
                                    <li><a href="<?= site_url(ADMIN.'/mc_requests/delete/'.$row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

<?php endif; ?> 
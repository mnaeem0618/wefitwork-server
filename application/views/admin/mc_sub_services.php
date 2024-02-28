<?php if ($this->uri->segment(3) == 'manage_sub_services'): ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Update Sub Service : Maintenance Cover : '.$maintenance_cover->service_title)); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Update <strong>Sub Service : Maintenance Cover : <?= $maintenance_cover->service_title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?= site_url(ADMIN . '/maintenance_covers/add_sub_services/'.$this->uri->segment(4)); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>
    </div>
    <div>
        <hr>
        <div class="row col-md-12">
            <form action="" name="frmTestimonial" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label" for="title"> Title <span class="symbol required">*</span></label>
                        <input type="text" name="title" id="title" value="<?php if (isset($row->title)) echo $row->title; ?>" class="form-control" autofocus required>
                    </div>

                    <div class="clearfix"></div>
                    
                </div>
                  
                <div class="col-md-12">                
                    <hr class="hr-short">
                    <div class="form-group text-right">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
<?php else: ?>
    <?= showMsg(); ?>
    <?= getBredcrum(ADMIN, array('#' => 'Add/Manage Sub Services for: Maintenance Cover : '.$maintenance_cover->service_title )); ?>
    <div class="row margin-bottom-10">
        <div class="col-md-6">
            <h2 class="no-margin"><i class="entypo-list"></i> Add/Manage <strong>Sub Services for: Maintenance Cover : <?= $maintenance_cover->service_title ?></strong></h2>
        </div>
        <div class="col-md-6 text-right">

        <a href="<?= site_url(ADMIN . '/maintenance_covers'); ?>" class="btn btn-lg btn-info"><i class="fa fa-arrow-circle-left "></i> Maintenance Covers</a>


        <a href="<?= site_url(ADMIN . '/maintenance_covers/manage_sub_services/'.$this->uri->segment(4).'/'.$this->uri->segment(5)); ?>" class="btn btn-lg btn-primary"><i class="fa fa-plus-circle"></i> Add New</a>
            
        </div>
    </div>
<!-- <form name="updateFormOrder" id="updateFormOrder" action="<?php echo base_url('admin/services/orderAll'); ?>" method="post"> -->
    <table class="table table-bordered datatable" id="table-1">
        <thead>
            <tr>
                <th width="5%" class="text-center">Sr#</th>
                <th>Title</th>
                <th>Maintenance Cover</th>
                
                <th width="12%" class="text-center">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php if (countlength($rows) > 0): $count = 0; ?>
                <?php foreach ($rows as $row): ?>
                    <tr class="odd gradeX">
                        <td class="text-center"><?= ++$count; ?></td>
                        <td><b><?= $row->title ?></b></td>
                        <td><b><?= get_maintenance_cover_service_title($row->maintenance_cover_id); ?></b></td>
                       
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Action <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-primary" role="menu">
                                    <li><a href="<?= site_url(ADMIN.'/maintenance_covers/manage_sub_services/'.$row->maintenance_cover_id.'/'.$row->id); ?>">Edit</a></li>
                                    <li><a href="<?= site_url(ADMIN.'/maintenance_covers/delete_sub_services/'.$row->maintenance_cover_id.'/'.$row->id); ?>" onclick="return confirm('Are you sure?');">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<!-- </form> -->
<?php endif; ?> 
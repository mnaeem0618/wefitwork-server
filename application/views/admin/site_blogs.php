<?php echo getBredcrum(ADMIN, array('#' => 'Contact Us')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Contact Us</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
    <form role="form" method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
            

            <h3>Category Section </h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="cat_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="cat_heading" value="<?= $row['cat_heading'] ?>" class="form-control" required>
                        </div>

                                                <div class="clearfix"></div>

                            </div>
                </div>
            </div>

            <h3>Top Post Section</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="top_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="top_heading" value="<?= $row['top_heading'] ?>" class="form-control" required>
                        </div>

                        <div class="clearfix"></div>
                       

                    </div>
                </div>
            </div>

            <h3>Blogs Section</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="btn_txt" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="btn_txt" value="<?= $row['btn_txt'] ?>" class="form-control" required>
                        </div>

                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label "></label>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
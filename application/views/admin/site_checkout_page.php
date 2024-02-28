<?php echo getBredcrum(ADMIN, array('#' => 'Checkout Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Checkout Page</strong></h2>
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
        <h3>Section</h3>
            <div class="form-group">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="sec1_heading" class="control-label">Main Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_heading" value="<?= $row['sec1_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec1_detail" class="control-label"> Terms & Conditions <span class="symbol required">*</span></label>
                            <textarea name="sec1_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec1_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec1_checkbox_text" class="control-label"> checkbox text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_checkbox_text" value="<?= $row['sec1_checkbox_text'] ?>" class="form-control" required>
                        </div>


                        <div class="clearfix"></div>
                        

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
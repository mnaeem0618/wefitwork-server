<?php echo getBredcrum(ADMIN, array('#' => 'Email Verification')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Email Verification</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <!--        <a href="<?php echo base_url('admin/services'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Cancel</a>-->
    </div>
</div>
<div>
    <hr>
    <div class="clearfix"></div>
    <div class="panel-body">
        <form role="form"  method="post" class="form-horizontal form-groups-bordered validate" novalidate="novalidate" enctype="multipart/form-data">
        <h3>Left Section</h3>
            <div class="form-group">
                <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                   Background Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image1']) ? get_site_image_src("images/", $row['image1']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image1" accept="image/*" <?php if (empty($row['image1'])) {
                                                                                                    echo 'required=""';
                                                                                                } ?>>
                                        </span>
                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="sec1_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_heading" value="<?= $row['sec1_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec1_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec1_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec1_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec1_button1_text" class="control-label"> Link 1 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button1_text" value="<?= $row['sec1_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button1_link" class="control-label"> Link 1 Link <span class="symbol required">*</span></label>
                            
                            <select name="sec1_button1_link" id="sec1_button1_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec1_button1_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec1_button2_text" class="control-label"> Link 2 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button2_text" value="<?= $row['sec1_button2_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button2_link" class="control-label"> Link 2 Link <span class="symbol required">*</span></label>
                            
                            <select name="sec1_button2_link" id="sec1_button2_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec1_button2_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec1_button3_text" class="control-label"> Link 3 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button3_text" value="<?= $row['sec1_button3_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button3_link" class="control-label"> Link 3 Link <span class="symbol required">*</span></label>
                            
                            <select name="sec1_button3_link" id="sec1_button3_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec1_button3_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            
                        </div>

                        <div class="clearfix"></div>
                        

                    </div>
                </div>
            </div>

        <h3>Right Section</h3>
        <div class="form-group">
            <div class="col-md-12">
                <div class="form-group">
               

                        <div class="col-md-6">
                            <label for="right_sec_heading" class="control-label">Right Section Heading <span class="symbol required">*</span></label>
                            <input type="text" name="right_sec_heading" value="<?= $row['right_sec_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="right_sec_tagline" class="control-label">Right Section Tagline <span class="symbol required">*</span></label>
                            <input type="text" name="right_sec_tagline" value="<?= $row['right_sec_tagline'] ?>" class="form-control" required>
                        </div>
                    <div class="clearfix"></div>
                                     
                    <div class="col-md-6">
                        <label for="submit_text" class="control-label">Button Text<span class="symbol required">*</span></label>
                        <input type="text" name="submit_text" value="<?= $row['submit_text'] ?>" class="form-control" required>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="left_tagline_link_text" class="control-label">Resend Button  Text<span class="symbol required">*</span></label>
                        <input type="text" name="left_tagline_link_text" value="<?= $row['left_tagline_link_text'] ?>" class="form-control" required>
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
<?php echo getBredcrum(ADMIN, array('#' => 'About Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>About Page</strong></h2>
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
        <h3>Section 1</h3>
            <div class="form-group">
                <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Image
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
                            <label for="sec1_button1_text" class="control-label"> Button 1 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button1_text" value="<?= $row['sec1_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button1_link" class="control-label"> Button 1 Link <span class="symbol required">*</span></label>
                            
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
                            <label for="sec1_button2_text" class="control-label"> Button 2 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button2_text" value="<?= $row['sec1_button2_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button2_link" class="control-label"> Button 2 Link <span class="symbol required">*</span></label>
                            
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
                        

                    </div>
                </div>
            </div>


            <h3>Section 2</h3>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="sec2_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_heading" value="<?= $row['sec2_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <label for="sec2_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec2_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec2_detail'] ?></textarea>
                        </div>
                        <div class="clearfix"></div>

<br>
                        <div class="col-md-12">
                        <h4> Info Cards</h4>

                        </div>
                            <?php $sec2_cards = 0;
                            for ($i = 2; $i <= 4; $i++) : ++$sec2_cards; ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="panel panel-primary" data-collapsed="0">
                                                <div class="panel-heading">
                                                    <div class="panel-title">
                                                        Icon <?= $sec2_cards ?>
                                                    </div>
                                                    <div class="panel-options">
                                                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                    </div>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;background:#ddd" data-trigger="fileinput">
                                                            <img src="<?= get_site_image_src("images/", $row['image' . $i]) ?>" alt="--">
                                                        </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                                        <div>
                                                            <span class="btn btn-white btn-file">
                                                                <span class="fileinput-new">Select image</span>
                                                                <span class="fileinput-exists">Change</span>
                                                                <input type="file" name="image<?= $i ?>" accept="image/*" <?php if (empty($row['image' . $i])) {
                                                                                                                                echo 'required=""';
                                                                                                                            } ?>>
                                                            </span>
                                                            <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-md-12">
                                            <label for="sec2_img_card_heading<?= $i ?>" class="control-label"> Heading <?= $sec2_cards ?><span class="symbol required">*</span></label>
                                            <input type="text" name="sec2_img_card_heading<?= $i ?>" class="form-control" value="<?= $row['sec2_img_card_heading' . $i] ?>" />
                                        </div>

                                        <div class="col-md-12">
                                            <label for="sec2_img_card_tagline<?= $i ?>" class="control-label"> Tagline <?= $sec2_cards ?><span class="symbol required">*</span></label>
                                            <textarea name="sec2_img_card_tagline<?= $i ?>" class="form-control" rows="3" ><?= $row['sec2_img_card_tagline' . $i] ?></textarea>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php endfor ?>
                        
                        <div class="clearfix"></div>


                    </div>
                </div>
            </div>

            <h3>Section 3</h3>
            <div class="form-group">
                <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image5']) ? get_site_image_src("images/", $row['image5']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image5" accept="image/*" <?php if (empty($row['image5'])) {
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
                            <label for="sec3_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_heading" value="<?= $row['sec3_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec3_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec3_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec3_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec3_button1_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec3_button1_text" value="<?= $row['sec3_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec3_button1_link" class="control-label"> Button Link <span class="symbol required">*</span></label>
                            
                            <select name="sec3_button1_link" id="sec3_button1_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec3_button1_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            

                        </div>


                        <div class="clearfix"></div>
                        

                    </div>
                </div>
            </div>
            

            <h3>Section 4</h3>
            <div class="form-group">

                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="sec4_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec4_heading" value="<?= $row['sec4_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec4_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec4_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec4_detail'] ?></textarea>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec4_button1_text" class="control-label"> Button 1 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec4_button1_text" value="<?= $row['sec4_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec4_button1_link" class="control-label"> Button 1 Link <span class="symbol required">*</span></label>
                            
                            <select name="sec4_button1_link" id="sec4_button1_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec4_button1_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            

                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec4_button2_text" class="control-label"> Button 2 Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec4_button2_text" value="<?= $row['sec4_button2_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec4_button2_link" class="control-label"> Button 2 Link <span class="symbol required">*</span></label>
                            
                            <select name="sec4_button2_link" id="sec4_button2_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec4_button2_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            

                        </div>

                    </div>
                </div>
            </div>

            
            <h3>Section 5</h3>
            <div class="form-group">

                <div class="col-md-12">
                    <div class="form-group">

                        <div class="col-md-12">
                            <label for="sec5_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec5_heading" value="<?= $row['sec5_heading'] ?>" class="form-control" required>
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
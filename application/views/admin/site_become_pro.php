<?php echo getBredcrum(ADMIN, array('#' => 'Become A Professional Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Become A Professional Page</strong></h2>
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
        <h3>Banner Section</h3>
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


                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Main Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image2']) ? get_site_image_src("images/", $row['image2']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image2" accept="image/*" <?php if (empty($row['image2'])) {
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
                            <label for="sec1_button1_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec1_button1_text" value="<?= $row['sec1_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec1_button1_link" class="control-label"> Button Link <span class="symbol required">*</span></label>
                            
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
                        

                    </div>
                </div>
            </div>

            <h3>Ribbon Image</h3>
            <div class="form-group">
            <div class="col-md-2">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                   Ribbon Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image4']) ? get_site_image_src("images/", $row['image4']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image4" accept="image/*" <?php if (empty($row['image4'])) {
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

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="ribbon_button1_link" class="control-label"> Ribbon Link <span class="symbol required">*</span></label>
                            
                            <select name="ribbon_button1_link" id="ribbon_button1_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['ribbon_button1_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
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

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec2_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec2_heading" value="<?= $row['sec2_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <label for="sec2_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec2_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec2_detail'] ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="sec2_key_features" class="control-label">Key features Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec2_key_features" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec2_key_features'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                    </div>
                </div>
            </div>

            <h3>Section 3</h3>
            <div class="form-group">
                
                <div class="col-md-12">
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
                        <br>

                        <div class="col-md-12">
                <table class="table table-bordered newTable" id="newTable">
                                    <tr style="background-color: #eee">
                                        <th width="10%">Image</th>
                                        <th>Title</th>
                                        <th>Text</th>

                                        <th width="10%">Order#</th>
                                        <th width="4%" class="text-center"><a href="javascript:void(0)" id="addNewRowTbl" class="addNewRowTbl"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                    </tr>
                                    <?php $sec3s = getMultiText('about-sec3'); ?>
                                    <?php if (countlength($sec3s) > 0) { $sec3s_count = 1; ?>
                                    <?php foreach ($sec3s as $sec3) { ?>
                                        <tr>
                                            <td>
                                                <div id="imgDiv">
                                                    <input type="file" name="sec3_image[]" accept="image/*" id="newImgInput" style="display: none;" />
                                                    <img src="<?php echo getImageSrc('./uploads/images/',$sec3->image); ?>" style="width: 75%; cursor: pointer;background:#ddd" id="newImg"> 
                                                    <input type="hidden" name="sec3_pics[]" value="<?= $sec3->image; ?>"> 
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="sec3_title[]" id="sec3_title" value="<?= $sec3->title; ?>" class="form-control" placeholder="Text">
                                            </td>
                                            
                                            <td>
                                            <textarea name="sec3_txt1[]" id="sec_txt1" class="form-control" rows="3"><?= $sec3->txt1; ?></textarea>
                                        </td>
                                            
                                            <td>
                                                <input type="number" name="sec3_order_no[]" id="sec3_order_no" value="<?= $sec3->order_no; ?>" class="form-control" placeholder="Order#">
                                            </td>
                                            <td class="text-center">
                                                <?php if ($sec3s_count > 1) { ?>
                                                    <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php $sec3s_count++; ?>
                                    <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td>
                                                <div id="imgDiv">
                                                    <input type="file" name="sec3_image[]" accept="image/*" id="newImgInput" style="display: none;" />
                                                    <img src="<?php echo getImageSrc('./uploads/images/',''); ?>" style="width: 75%; cursor: pointer;background:#ddd" id="newImg">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="sec3_title[]" id="sec3_title" value="" class="form-control" placeholder="Text">
                                            </td>

                                            <td>
                                            <textarea name="sec3_txt1[]" id="sec_txt1" class="form-control" rows="3"></textarea>
                                        </td>
                                            
                                            <td>
                                                <input type="number" name="sec3_order_no[]" id="sec3_order_no" value="" class="form-control" placeholder="Order#">
                                            </td>
                                            <td class="text-center">
                                            </td>
                                        </tr>  
                                    <?php } ?>                  
                                </table>
                </div>


                        <div class="clearfix"></div>
                        

                    </div>
                </div>
            </div>
            

            <h3>Section 4</h3>
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
                                        <img src="<?= !empty($row['image3']) ? get_site_image_src("images/", $row['image3']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image3" accept="image/*" <?php if (empty($row['image3'])) {
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
                            <label for="sec4_button1_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec4_button1_text" value="<?= $row['sec4_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec4_button1_link" class="control-label"> Button Link <span class="symbol required">*</span></label>
                            
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

                        <div class="col-md-12">
                            <label for="sec5_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec5_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec5_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label for="sec5_button1_text" class="control-label"> Button Text <span class="symbol required">*</span></label>
                            <input type="text" name="sec5_button1_text" value="<?= $row['sec5_button1_text'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sec5_button1_link" class="control-label"> Button Link <span class="symbol required">*</span></label>
                            
                            <select name="sec5_button1_link" id="sec5_button1_link" class="form-control" required>
                                <option value=''>-- Select --</option>
                                <?php $pages = get_pages();
                                foreach ($pages as $index => $page) { ?>
                                    <option value="<?= $index ?>" <?= ($row['sec5_button1_link'] == $index) ? 'selected' : '' ?>> <?= $page ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec5_tagline" class="control-label">Tagline <span class="symbol required">*</span></label>
                            <input type="text" name="sec5_tagline" value="<?= $row['sec5_tagline'] ?>" class="form-control" required>
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
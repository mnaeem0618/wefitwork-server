<?php echo getBredcrum(ADMIN, array('#' => 'Maintenance Cover Page')); ?>
<?php echo showMsg(); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Maintenance Cover Page</strong></h2>
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
                                            <textarea name="sec2_img_card_tagline<?= $i ?>" rows="3" class="form-control"><?= $row['sec2_img_card_tagline' . $i] ?></textarea>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php endfor ?>
                        
                        <div class="clearfix"></div>
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
                                    <?php $sec4s = getMultiText('maintenance-cover-sec4'); ?>
                                    <?php if (countlength($sec4s) > 0) { $sec4s_count = 1; ?>
                                    <?php foreach ($sec4s as $sec4) { ?>
                                        <tr>
                                            <td>
                                                <div id="imgDiv">
                                                    <input type="file" name="sec4_image[]" accept="image/*" id="newImgInput" style="display: none;" />
                                                    <img src="<?php echo getImageSrc('./uploads/images/',$sec4->image); ?>" style="width: 75%; cursor: pointer;background:#ddd" id="newImg"> 
                                                    <input type="hidden" name="sec4_pics[]" value="<?= $sec4->image; ?>"> 
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="sec4_title[]" id="sec4_title" value="<?= $sec4->title; ?>" class="form-control" placeholder="Text">
                                            </td>
                                            
                                            <td>
                                            <textarea name="sec4_txt1[]" id="sec_txt1" class="form-control" rows="3"><?= $sec4->txt1; ?></textarea>
                                        </td>
                                            
                                            <td>
                                                <input type="number" name="sec4_order_no[]" id="sec4_order_no" value="<?= $sec4->order_no; ?>" class="form-control" placeholder="Order#">
                                            </td>
                                            <td class="text-center">
                                                <?php if ($sec4s_count > 1) { ?>
                                                    <a href="javascript:void(0)" id="delNewRowTbl" class="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php $sec4s_count++; ?>
                                    <?php } ?>
                                    <?php }else{ ?>
                                        <tr>
                                            <td>
                                                <div id="imgDiv">
                                                    <input type="file" name="sec4_image[]" accept="image/*" id="newImgInput" style="display: none;" />
                                                    <img src="<?php echo getImageSrc('./uploads/images/',''); ?>" style="width: 75%; cursor: pointer;background:#ddd" id="newImg">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="sec4_title[]" id="sec4_title" value="" class="form-control" placeholder="Text">
                                            </td>

                                            <td>
                                            <textarea name="sec4_txt1[]" id="sec_txt1" class="form-control" rows="3"></textarea>
                                        </td>
                                            
                                            <td>
                                                <input type="number" name="sec4_order_no[]" id="sec4_order_no" value="" class="form-control" placeholder="Order#">
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

            <h3>Section 5</h3>
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
                            <label for="sec5_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec5_heading" value="<?= $row['sec5_heading'] ?>" class="form-control" required>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12">
                            <label for="sec5_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>
                            <textarea name="sec5_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['sec5_detail'] ?></textarea>
                        </div>

                        <div class="clearfix"></div>
                        

                    </div>
                </div>
            </div>

            
            <h3>Section 6</h3>
            <div class="form-group">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="sec6_heading" class="control-label"> Heading <span class="symbol required">*</span></label>
                            <input type="text" name="sec6_heading" value="<?= $row['sec6_heading'] ?>" class="form-control" required>
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
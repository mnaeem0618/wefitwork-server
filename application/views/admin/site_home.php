<?php echo getBredcrum(ADMIN, array('#' => 'Home Page')); ?>

<?php echo showMsg(); ?>

<div class="row margin-bottom-10">

    <div class="col-md-6">

        <h2 class="no-margin"><i class="entypo-window"></i> Update <strong>Home Page</strong></h2>

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

            <h3> Main Banner</h3>

            <div class="form-group">

                <div class="col-md-6">

                    <div class="form-group">

                        <div class="col-md-12">

                            <label for="banner_heading" class="control-label">Heading <span class="symbol required">*</span></label>

                            <input type="text" name="banner_heading_1" value="<?= $row['banner_heading_1'] ?>" class="form-control" required>

                        </div>

                        <div class="col-md-12">

                            <label for="banner_detail" class="control-label"> Text Block <span class="symbol required">*</span></label>

                            <textarea name="banner_detail" rows="3" class="form-control ckeditor" id="editor"><?= $row['banner_detail'] ?></textarea>

                        </div>



                        <div class="col-md-12">

                            <label for="banner_tagline" class="control-label">Tagline <span class="symbol required">*</span></label>

                            <input type="text" name="banner_tagline" value="<?= $row['banner_tagline'] ?>" class="form-control" required>

                        </div>





                    </div>

                </div>

                <div class="col-md-6">

                    <label for="image1" class="control-label">Banner Images <span class="symbol required">*</span></label>
                    <div class="clearfix"></div>

                    <div class="col-md-3">
                    <div class="form-group">

                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title">
                                   Mobile Banner Image
                                </div>
                                <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">
                                        <img src="<?= !empty($row['image7']) ? get_site_image_src("images/", $row['image7']) : base_url('assets/images/no-image.svg') ?>" alt="--">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>
                                    <div>
                                        <span class="btn btn-white btn-file">
                                            <span class="fileinput-new">Select image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="image7" accept="image/*" <?php if (empty($row['image7'])) {
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

                    <div class="clearfix"></div>



                    <div id="repeater_card">

                        <div class="clearfix"></div>



                        <!-- <div class="col-md-12"> -->

                        <button class="btn btn-info pull-right card-repeater-add-btn" style="margin-left:20px" type="button">

                            <i class="fa fa-plus"></i> Add New Banner Image

                        </button>

                        <div class="clearfix"></div>

                        <!-- </div> -->

                        <br>

                        <?php

                        $banners = getBannerImages('home-banner');

                        if (countlength($banners) > 0) {

                            $banners_count = 1;

                            foreach ($banners as $key => $banner) { ?>



                                <div class="card_item">



                                    <div class="col-md-4">

                                        <div class="panel panel-primary" data-collapsed="0">

                                            <div class="panel-heading">

                                                <div class="panel-title">

                                                    Banner Image <?= $key + 1 ?>

                                                </div>

                                                <div class="panel-options">

                                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>

                                                </div>

                                            </div>

                                            <div class="panel-body">

                                                <div class="fileinput fileinput-new" data-provides="fileinput">

                                                    <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">

                                                        <img src="<?php echo getImageSrc('./uploads/images/', $banner->image); ?>" alt="--">



                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>

                                                    <div>

                                                        <span class="btn btn-white btn-file">

                                                            <span class="fileinput-new">Select image</span>

                                                            <span class="fileinput-exists">Change</span>

                                                            <input type="file" name="banner_image[]" accept="image/*">

                                                            <input type="hidden" name="banner_pics[]" value="<?= $banner->image; ?>">

                                                        </span>

                                                        <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>

                                                    </div>

                                                </div>



                                                <div class="card_repeater-remove-btn" style="margin-top:20px; margin-left:120px">



                                                    <?php

                                                    if ($banners_count > 1) {

                                                    ?>

                                                        <button id="remove-btn" class="btn btn-danger" type="button">

                                                            Remove

                                                        </button>

                                                    <?php

                                                    }

                                                    ?>



                                                </div>

                                            </div>







                                        </div>







                                    </div>



                                    





                                </div>



                            <?php

                                $banners_count++;

                            }

                        } else { ?>





                            <div class="card_item">



                                <div class="col-md-4">

                                    <div class="panel panel-primary" data-collapsed="0">

                                        <div class="panel-heading">

                                            <div class="panel-title">

                                                Banner Image 1

                                            </div>

                                            <div class="panel-options">

                                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>

                                            </div>

                                        </div>

                                        <div class="panel-body">

                                            <div class="fileinput fileinput-new" data-provides="fileinput">

                                                <div class="fileinput-new thumbnail" style="max-width: 310px; height: 110px;" data-trigger="fileinput">

                                                    <img src="<?php echo getImageSrc('./uploads/images/', ''); ?>" alt="--">

                                                </div>

                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 320px; max-height: 160px; line-height: 6px;"></div>

                                                <div>

                                                    <span class="btn btn-white btn-file">

                                                        <span class="fileinput-new">Select image</span>

                                                        <span class="fileinput-exists">Change</span>

                                                        <input type="file" name="banner_image[]" accept="image/*">

                                                    </span>

                                                    <a href="#" class="btn btn-orange fileinput-exists" data-dismiss="fileinput">Remove</a>

                                                </div>

                                            </div>



                                            <div class="card_repeater-remove-btn" style="margin-top:20px; margin-left:120px">







                                            </div>

                                        </div>







                                    </div>







                                </div>

                               







                            </div>

                        <?php } ?>



                    </div>



                    <div class="clearfix"></div>







                </div>

                <div class="clearfix"></div>



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

<br>

                        <div class="col-md-12">

                        <h4> Info Cards</h4>



                        </div>

                            <?php $sec2_cards = 0;

                            for ($i = 1; $i <= 3; $i++) : ++$sec2_cards; ?>

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

                                            <input type="text" name="sec2_img_card_tagline<?= $i ?>" class="form-control" value="<?= $row['sec2_img_card_tagline' . $i] ?>" />

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

                        <h4> Cards</h4>



                        </div>

                            <?php $sec3_cards = 0;

                            for ($i = 4; $i <= 6; $i++) : ++$sec3_cards; ?>

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <div class="col-md-12">

                                            <div class="panel panel-primary" data-collapsed="0">

                                                <div class="panel-heading">

                                                    <div class="panel-title">

                                                        Image <?= $sec3_cards ?>

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

                                            <label for="sec3_card_heading<?= $i ?>" class="control-label"> Heading <?= $sec3_cards ?><span class="symbol required">*</span></label>

                                            <input type="text" name="sec3_card_heading<?= $i ?>" class="form-control" value="<?= $row['sec3_card_heading' . $i] ?>" />

                                        </div>



                                        <div class="col-md-12">

                                            <label for="sec3_card_tagline<?= $i ?>" class="control-label"> Tagline <?= $sec3_cards ?><span class="symbol required">*</span></label>

                                            <input type="text" name="sec3_card_tagline<?= $i ?>" class="form-control" value="<?= $row['sec3_card_tagline' . $i] ?>" />

                                        </div>





                                        <div class="col-md-12">

                                            <label for="sec3_card_btn_text<?= $i ?>" class="control-label"> Button text <?= $sec3_cards ?><span class="symbol required">*</span></label>

                                            <input type="text" name="sec3_card_btn_text<?= $i ?>" class="form-control" value="<?= $row['sec3_card_btn_text' . $i] ?>" />

                                        </div>



                                        <div class="col-md-12">

                                            <label for="sec3_card_btn_link<?= $i ?>" class="control-label"> Button Link <?= $sec3_cards ?><span class="symbol required">*</span></label>

                                            <input type="text" name="sec3_card_btn_link<?= $i ?>" class="form-control" value="<?= $row['sec3_card_btn_link' . $i] ?>" />

                                        </div>



                                        <div class="clearfix"></div>

                                    </div>

                                </div>

                            <?php endfor ?>



                        <div class="clearfix"></div>



                    </div>

                </div>

            </div>



            <h3>Section 4</h3>

            <div class="form-group">



                <div class="col-md-12">

                    <div class="form-group">



                        <div class="col-md-6">

                            <label for="sec4_heading" class="control-label"> Heading <span class="symbol required">*</span></label>

                            <input type="text" name="sec4_heading" value="<?= $row['sec4_heading'] ?>" class="form-control" required>

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
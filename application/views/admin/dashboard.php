<?php echo showMsg(); ?>
<div class="row">
    
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/members') ?>">
            <div class="tile-stats tile-blue">
                <div class="icon"><i class="entypo-basket"></i></div>
                <div class="num" data-start="0" data-end="<?= $members?>" data-postfix="" data-duration="1500" data-delay="0"><?=$members?></div>
                <h3>Total Members</h3>
                <p>Total Members in our website </p>
            </div>
        </a>
    </div>
    
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/contact') ?>">
            <div class="tile-stats tile-black">
                <div class="icon"><i class="fa fa-cogs"></i></div>
                <div class="num" data-start="0" data-end="<?= $contact?>" data-postfix="" data-duration="1500" data-delay="0"><?=$contact?></div>
                <h3>Unread Contact Message</h3>
                <p>Total unread contact message in our website.</p>
            </div>
        </a>		
    </div>
    
   
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a href="<?= site_url(ADMIN.'/settings') ?>">
            <div class="tile-stats tile-black">
                <div class="icon"><i class="fa fa-cogs"></i></div>
                <div class="num" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="1800"> Settings</div>
                <h3>Change Settings</h3>
                <p>on our site right now.</p>
            </div>
        </a>		
    </div>
</div>



<div class="sidebar-menu fixed">

    <div class="sidebar-menu-inner ps-container ps-active-y">

        <header class="logo-env">

            <div class="logo">

                <a href="<?= site_url(ADMIN . '/dashboard') ?>">

                    <img src="<?= base_url() . SITE_IMAGES . 'images/' . $adminsite_setting->site_logo ?>" width="120" alt="">

                </a>

            </div>

            <div class="sidebar-collapse">

                <a href="#" class="sidebar-collapse-icon">

                    <i class="entypo-menu"></i>

                </a>

            </div>

            <div class="sidebar-mobile-menu visible-xs">

                <a href="#" class="with-animation">

                    <i class="entypo-menu"></i>

                </a>

            </div>

        </header>

        <ul id="main-menu" class="main-menu">

            <li class="opened <?= ($this->uri->segment(2) == 'dashboard') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/dashboard') ?>">

                    <i class="entypo-gauge"></i>

                    <span class="title">Dashboard</span>

                </a>

            </li>



            <li class="opened <?= ($this->uri->segment('2') == 'meta-info') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/meta-info') ?>">

                    <i class="fa fa-tags" aria-hidden="true"></i>

                    <span class="title">Site Meta</span>

                </a>

            </li>





            <li class=" <?= ($this->uri->segment(2) == 'sitecontent' || $this->uri->segment(2) == 'partner_companies' || $this->uri->segment(2) == 'job_profile' || $this->uri->segment(2) == 'preferences') ? ' opened  active' : '' ?>">

                <a href="javascript:void(0)">

                    <i class="entypo-doc-text"></i>

                    <span class="title">Manage Pages</span>

                </a>

                <ul>

                    <li class="opened <?= ($this->uri->segment(3) == 'home') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/home') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Home</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'about') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/about') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">About Us</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'contact_us') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/contact_us') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Contact Us</span>

                        </a>

                    </li>




                    <li class="opened <?= ($this->uri->segment(3) == 'become_pro') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/become_pro') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Become A Professional</span>

                        </a>

                    </li>

                    <li class="opened <?= ($this->uri->segment(3) == 'maintenance_cover') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/maintenance_cover') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Maintenance Cover</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'help') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/help') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Help</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'signup') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/signup') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Sign Up</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'pro_signup') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/pro_signup') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Professional Signup</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'login') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/login') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Login</span>

                        </a>

                    </li>



                    



                    <li class="opened <?= ($this->uri->segment(3) == 'forgot_password') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/forgot_password') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Forgot Password</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'change_password') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/change_password') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Reset Password</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'email_verify') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/email_verify') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Email Verification</span>

                        </a>

                    </li>

                    <li class="opened <?= ($this->uri->segment(3) == 'blogs') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/blogs') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Blogs</span>

                        </a>

                    </li>
                    

                    <li class="opened <?= ($this->uri->segment(3) == 'checkout_page') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/checkout_page') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Checkout</span>

                        </a>

                    </li>

                                   

                    <li class="opened <?= ($this->uri->segment(3) == 'terms_and_conditions') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/terms_and_conditions') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Terms And Conditions</span>

                        </a>

                    </li>



                    <li class="opened <?= ($this->uri->segment(3) == 'privacy_policy') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sitecontent/privacy_policy') ?>">

                            <i class="entypo-doc-text  "></i>

                            <span class="title">Privacy Policy</span>

                        </a>

                    </li>

                    

                </ul>

            </li>



            <li class="opened <?= ($this->uri->segment('2') == 'help' || $this->uri->segment('2') == 'help_topics') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/help') ?>">

                    <i class="fa fa-info-circle" aria-hidden="true"></i>

                    <span class="title">Manage Helps</span>

                </a>

            </li>

                   

            <li class=" <?= ($this->uri->segment(2) == 'services' || $this->uri->segment(2) == 'sub_services') ? ' opened  active' : '' ?>">

                <a href="javascript:void(0)">

                    <i class="fa fa-wrench"></i>

                    <span class="title">Manage Services</span>

                </a>

                <ul>

                    <li class="opened <?= ($this->uri->segment(2) == 'services') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/services') ?>">

                            <i class="fa fa-wrench"></i>

                            <span class="title">Services</span>

                        </a>

                    </li>

                    <li class="opened <?= ($this->uri->segment(2) == 'sub_services') ? ' active' : '' ?>">

                        <a href="<?= site_url(ADMIN . '/sub_services') ?>">

                            <i class="fa fa-wrench"></i>

                            <span class="title">Sub Services</span>

                        </a>

                    </li>

                </ul>

            </li>

            <li class="opened<?= $this->uri->segment('2') == 'plans' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/plans') ?>">

                    <i class="fa fa-tags"></i>

                    <span class="title">Manage Subscription Plan</span>

                </a>

            </li>

            <li class="opened<?= $this->uri->segment('2') == 'maintenance_covers' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/maintenance_covers') ?>">

                    <i class="fa fa-briefcase"></i>

                    <span class="title">Manage Maintenance Covers</span>

                </a>

            </li>


            <li class="opened<?= $this->uri->segment('2') == 'members' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/members') ?>">

                    <i class="fa fa-users"></i>

                    <span class="title">Manage Members</span>

                </a>

            </li>


            <li class="opened<?= $this->uri->segment('2') == 'team' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/team') ?>">

                    <i class="fa fa-user"></i>

                    <span class="title">Our Team</span>

                </a>

            </li>




            <li class="opened<?= $this->uri->segment('2') == 'testimonials' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/testimonials') ?>">

                    <i class="fa fa-quote-left"></i>

                    <span class="title">Manage Testimonials</span>

                </a>

            </li>



            <li class="opened<?= $this->uri->segment('2') == 'faq' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/faq') ?>">

                <i class="fa fa-question"></i>

                    <span class="title">Manage FAQ's</span>

                </a>

            </li>   

            <li class=" <?= ($this->uri->segment(2) == 'blog_categories' || $this->uri->segment(2) == 'blogs') ? ' opened  active' : '' ?>">
                <a href="javascript:void(0)">
                    <i class="fa fa-bold"></i>
                    <span class="title">Manage Blogs</span>
                </a>
                <ul>
                    <li class="opened <?= ($this->uri->segment(2) == 'blog_categories') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN . '/blog_categories') ?>">
                            <i class="fa fa-list  "></i>
                            <span class="title">Blogs Categories</span>
                        </a>
                    </li>
                    <li class="opened <?= ($this->uri->segment(2) == 'blogs') ? ' active' : '' ?>">
                        <a href="<?= site_url(ADMIN . '/blogs') ?>">
                            <i class="fa fa-bold  "></i>
                            <span class="title">Blogs</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="opened <?= ($this->uri->segment(2) == 'subscribed_mc') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/subscribed_mc') ?>">

                <i class="fa fa-dollar" aria-hidden="true"></i>

                    <span class="title">Subscribed Maintenance Requests</span><span class="badge badge-danger"></span>

                </a>

            </li>

            <li class="opened <?= ($this->uri->segment(2) == 'mc_requests') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/mc_requests') ?>">

                <i class="fa fa-envelope-open" aria-hidden="true"></i>

                    <span class="title">Maintenance Requests</span><span class="badge badge-danger"><?= new_mc_requests() ?></span>

                </a>

            </li>


            <li class="opened <?= ($this->uri->segment(2) == 'contact') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/contact') ?>">

                <i class="fa fa-envelope" aria-hidden="true"></i>

                    <span class="title">Manage Contact Messages</span><span class="badge badge-danger"><?= new_messages() ?></span>

                </a>

            </li>



            <li class="opened<?= $this->uri->segment('2') == 'newsletter' ? ' active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/newsletter') ?>">

                <i class="fa fa-bell" aria-hidden="true"></i>

                    <span class="title">Manage Newsletter Subscriptions</span> <span class="badge badge-danger"><?= new_subscribers() ?></span>

                </a>

            </li>



            



            <li class="opened <?= ($this->uri->segment(2) == 'settings' && $this->uri->segment(3) == '') ? 'active' : '' ?>">

                <a href="<?= site_url(ADMIN . '/settings') ?>">

                    <i class="fa fa-cogs"></i>

                    <span class="title">Site Settings</span>

                </a>

            </li>



            <li class="opened">

                <a href="<?= site_url(ADMIN . '/settings/change') ?>">

                    <i class="fa fa-lock"></i>

                    <span class="title">Change Password</span>

                </a>

            </li>

            

        </ul>

    </div>

</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('template/template_main_head'); ?>
    <title>INSPINIA | Main view</title>
</head>

<body>
    <div id="wrapper">
        <!-- begin navigation -->
        <?php $this->load->view('template/template_nav'); ?>
        <!-- end navigation -->
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <!-- begin header -->
                <?php $this->load->view('template/template_header'); ?>
                <!-- end header -->
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- begin content -->
                        <?php $this->load->view('home/home_content'); ?>
                        <!-- end content -->
                    </div>
                </div>
            </div>
            <!-- begin footer -->
            <?php $this->load->view('template/template_footer'); ?>
            <!-- end footer -->
        </div>
    </div>
    <!-- begin script -->
    <?php $this->load->view('template/template_main_script'); ?>
    <!-- end script -->
</body>

</html>

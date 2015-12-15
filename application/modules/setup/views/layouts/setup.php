<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/modules/setup/css/setupmod.css">
        <script type="text/javascript" async="" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
        <title>Test</title>
    </head>

    <body>

        <div id="setup-page">
            <div id="logo" style="font-family: 'Times New Roman'; font-size: 2.5em; font-weight: bold">
                <span style="font-style: italic; color: #4F5B93">PHP</span><span style="color: #B52E31">Angular</span>
            </div>
            <div id="setup-header">
                Setup Blog Application
            </div><!-- header -->

            <div id='content'>
                <?php echo $ViewContentHTML; ?>
            </div>

            <div class="clear"></div>

            <div id="setup-footer">
                Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
                All Rights Reserved.<br/>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
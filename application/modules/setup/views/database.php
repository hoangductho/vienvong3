<?php
$show = array('hostname', 'username', 'password', 'database', 'dbdriver');
?>

<div id="setup-content"> 
    <form action="" method="POST">
        <?php
        if (!empty($errmsg)) {
            echo '<div class="setup-form-section errmsg">' . $errmsg . '</div>';
        }
        foreach ($db['default'] as $key => $value) {
            if (is_string($value)) {
                ?>
                <div class="setup-form-section <?php echo (!in_array($key, $show) ? 'hide' : null); ?>" <?php echo (!in_array($key, $show) ? 'hidden' : null); ?>>
                    <div class='setup-section-label'><?php echo $key ?></div>
                    <div class="setup-section-data"><input type="text" name="default[<?php echo $key ?>]" value="<?php echo $value ?>"/></div>
                </div>
                <?php
            }

            if (is_bool($value)) {
                ?>
                <div class="setup-form-section <?php echo (!in_array($key, $show) ? 'hide' : null); ?>" <?php echo (!in_array($key, $show) ? 'hidden' : null); ?>>
                    <div class="setup-section-label"><?php echo $key ?></div>
                    <div class="form-radiobox">
                        <input type="radio" name="default[<?php echo $key ?>]" value="boolean_true" <?php echo ($value ? 'checked' : null) ?>/> True
                        <input type="radio" name="default[<?php echo $key ?>]" value="boolean_false" <?php echo (!$value ? 'checked' : null) ?>/> False
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <div class="setup-form-section toogle"><a href="javascript:void(0);" onclick="MoreSetup()">More setup...</a></div>
        <div class="setup-form-section hide" hidden=""><a href="javascript:void(0);" onclick="HideSetup()">Hidden setup...</a></div>

        <div class="setup-form-section"><button class="right" type="submit">Next</button></div>
    </form>

    <script type="text/javascript">
        function HideSetup() {
            $('.hide').hide();
            $('.toogle').show();
        }

        function MoreSetup() {
            $('.setup-form-section').show();
            $('.toogle').hide();
        }
    </script>
</div>

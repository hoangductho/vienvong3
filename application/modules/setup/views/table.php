
<div id="setup-content">
    <form action="" method="post">
        <label>Tables Will Be Created</label>
        <div class="setup-form-section">
            <ol>
                <?php
                foreach ($tables as $name) {
                    echo '<li>' . $name . '</li>';
                }
                ?>
            </ol>
        </div>
        <div class="setup-form-section">
            <input type="hidden" name="create" value="1">
            <button class="right" type="submit">
                <?php echo (!empty($error)?'Try Again':'Create');?>
            </button>
        </div>
    </form>
</div>

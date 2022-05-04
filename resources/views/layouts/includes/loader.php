<!-- Loader :: BEGIN -->
<?php
$style = 'style1';
// OR
// $style = 'style2';

if ( $style == 'style1'  ) {
    $file  = 'logo_traffort.svg';
} else {
    $file  = 'logo_innLogist_BG.svg';
}
?>
<div class="app-loader <?php echo $style; ?>">
    <div class="app-loader__box">
        <div class="app-loader__logo">
            <img src="<?php
            echo '/main_layout/tmp/logo/' . $file;
            ?>">
            <div class="app-loader__logo-img">
                <img src="<?php
                echo '/main_layout/tmp/logo/' . str_replace( '_BG.', '.', $file );
                ?>">
            </div>
        </div>
    </div>
</div>
<!-- Loader :: END -->
<?php if( ! $is_logged_in):?>
    <?php if(isset($messages) && ! empty($messages)):?>
        <?php require(__DIR__.'./../common/messages.php');?>
    <?php endif;?>
<div class="row justify-content-center">
    <?php if(isset($forms)&&array_key_exists('form_register',$forms)):?>
        <div class="col-md-5 form-wrapper">
                <?=$forms['form_register'];?>
        </div>
    <?php endif;?>
    <?php if(isset($forms)&&array_key_exists('form_login',$forms)):?>
        <div class="col-md-5 form-wrapper">
            <?=$forms['form_login'];?>
        </div>
    <?php endif;?>
</div>
<?php elseif(isset($news_list)):?>
    <?=$news_list;?>
<?php endif;?>

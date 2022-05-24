<?php if( isset($forms) && array_key_exists('form_filter',$forms) ):?>
    <?=$forms['form_filter'];?>
<?php endif;?>

<hr class="divider">
<?php //var_dump($resource_list);die();
if( isset($resource_list) && ! empty($resource_list) ):
    foreach($resource_list as $index=>$resourceItem):
?>
    <div class="col-12 p-3 mb-2 list-item">
        <div class="row">
            <div class="col">
                <h2><?=$resourceItem['title'];?></h2>
            </div>
            <?php if(isset($is_admin)&&$is_admin):?>
            <div class="col-2">
                <?php require("news-delete-button.php");?>
            </div>
            <?php endif;?>
        </div>
        <p class="small"><?=$resourceItem['description'];?></p>
        <p><?=$resourceItem['status'];?></p>
    </div>
<?php
    endforeach;
endif;
?>


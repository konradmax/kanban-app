<?php if(isset($forms)&&array_key_exists('form_filter',$forms)):?>
    <?=$forms['form_filter'];?>
<?php endif;?>
<hr class="divider">
<div class="list-news">
<?php
foreach($news_list as $index=>$newsItem):
?>
    <div class="col-12 p-3 mb-2 list-item">
        <div class="row">
            <div class="col">
                <h2><?=$newsItem['title'];?></h2>
            </div>
            <?php if(isset($is_admin)&&$is_admin):?>
            <div class="col-2">
                    <?php require("news-delete-button.php");?>
            </div>
            <?php endif;?>
        </div>
        <p class="small"><?=$newsItem['description'];?></p>
        <p><?=$newsItem['content'];?></p>
    </div>
<?php endforeach;?>
</div>

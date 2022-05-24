<?php if( isset($messages) && ! empty($messages)):?>
    <?php foreach($messages as $messageType=>$messagesByGroup):?>
        <?php foreach($messagesByGroup as $message):?>
        <div class="alert alert-<?=$messageType;?>" role="alert">
            <?=$message;?>
        </div>
        <?php endforeach;?>
    <?php endforeach;?>
<?php endif;?>

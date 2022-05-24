<?php if( isset($forms) && array_key_exists('form_filter',$forms) ):?>
    <?=$forms['form_filter'];?>
<?php endif;?>

<hr class="divider">
<section class="tasks-swimlanes">
    <form action="/tasks/update" name="form_tasks_update" method="POST">
        <div class="row flex-row py-3">
            <div class="col background-white">
                <input type="submit" name="form_submit" value="Update" class="btn btn-primary my-3"/>
            </div>
        </div>
        <div class="row flex-row py-3">
            <?php
            if( isset($swimlanes_list) && ! empty($swimlanes_list) ):
                // for every active state (swimlane):
                foreach($swimlanes_list as $index=>$swimlaneItem):
            ?>
                <?php require("tasks-swimlanes-card.php");?>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </form>
</section>
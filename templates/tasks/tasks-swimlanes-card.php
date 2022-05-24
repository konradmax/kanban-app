<div class="col">
    <div id="swimlane-<?=$swimlaneItem['value'];?>" class="card bg-light card-swimlane" data-status-value="<?=$swimlaneItem['value'];?>">
        <div class="card-body">
            <h6 class="card-title text-uppercase text-truncate py-2"><?=$swimlaneItem['name'];?></h6>
            <div class="items border border-light">
                <?php
                if(isset($resource_list_by_swimlane) && ! empty($resource_list_by_swimlane)):
                    foreach($resource_list_by_swimlane[$swimlaneItem['value']] as $taskTodo):
                        include("tasks-swimlanes-card-item.php");
                    endforeach;
                endif;
                ?>
                <div class="dropzone rounded" ondrop="drop(event);updateInputStatusDrop(this);iterateSwimlanes();" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>
            </div>
        </div>
    </div>
</div>
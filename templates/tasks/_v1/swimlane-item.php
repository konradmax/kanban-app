<div class="card card-item card-item draggable shadow-sm"
     id="cd<?=$taskTodo->id;?>"
     data-id="<?=$taskTodo->id;?>"
     draggable="true"
     ondragstart="drag(event);updateInputStatusDrag(this);">
    <div class="card-body p-2">
        <div class="card-title">
            <img src="//upload.wikimedia.org/wikipedia/commons/thumb/6/6d/Windows_Settings_app_icon.png/30px-Windows_Settings_app_icon.png" class="rounded-circle float-right">
            <a href="?page=edit&id=<?=$taskTodo->id;?>" target="_self" class="lead font-weight-light"><?=$taskTodo->title;?></a>
        </div>
        <p>
            <a> <?=$taskTodo->description;?></a>
        </p>
    </div>
    <div class="hidden">
        <input type="hidden" class="card-item-status" name="tasks[<?=$taskTodo->id;?>]" value="<?=$taskTodo->status;?>" />
    </div>
</div>
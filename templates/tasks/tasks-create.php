<h1>Create Task</h1>
<form action="/tasks/create" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" class="form-control" id="title" placeholder="title">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="user_id">User</label>
        <select name="user_id" class="form-control" id="user_id">
            <?php foreach($users_list as $userIndex=>$userData):?>
                <option value="<?=$userData['id'];?>"><?=$userData['username'];?> (<?=$userData['status'];?>)</option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="state">State</label>
        <select name="state" class="form-control" id="state">
            <?php foreach($states_list as $statesIndex=>$statesData):?>
                <option value="<?=$statesData['id'];?>"><?=$statesData['name'];?> (<?=$statesData['value'];?>)</option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="tags">Tags</label>
        <select name="tag[]" class="form-control" id="tags">
            <?php foreach($tags_list as $tagIndex=>$tagData):?>
                <option value="<?=$tagData['id'];?>"><?=$tagData['title'];?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>

    <div class="hidden">
        <input type="hidden" name="form_name" value="form_tasks_create" />
    </div>
</form>

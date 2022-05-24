<h1>Create News</h1>
<form action="/news/create" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input id="title" name="title" type="text" class="form-control" id="title" placeholder="title">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="content" class="form-control" rows="6"></textarea>
    </div>
    <div class="form-group">
        <label for="tags">Tags</label>
        <select class="form-control" id="exampleFormControlSelect1">
            <?php foreach($tags_list as $tagIndex=>$tagData):?>
                <option value="<?=$tagData['id'];?>"><?=$tagData['title'];?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </div>

    <div class="hidden">
        <input type="hidden" name="form_name" value="form_news_create" />
    </div>
</form>

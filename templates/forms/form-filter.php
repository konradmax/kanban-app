<div id="form-filter" class="p-3">
    <form action="/news/filter" method="POST">
        <div class="row">
            <!-- TAGS: -->
            <div class="col-auto px-0">
                <label for="inputPassword6" class="col-form-label-sm px-2">Tags:</label>
            </div>
            <div class="col-auto px-0">
                <select class="form-control form-control-sm" id="tags" name="tags">
                    <option value="0">All</option>
                    <?php foreach($tags_list as $tagIndex=>$tagData):?>
                        <option value="<?=$tagData['id'];?>" <?php if(isset($tags_selected)&& intval($tags_selected)==intval($tagData['id'])){ echo " selected='selected'";}?>><?=$tagData['title'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <!-- Date FROM: -->
            <div class="col-auto px-0">
                <label for="dateStart" class="col-form-label-sm px-2">Date From:</label>
            </div>
            <div class="col-auto px-0">
                <input name="date[start]" type="date" class="form-control form-control-sm" id="dateStart" value="<?=($date_start)??null;?>">
            </div>
            <!-- Date TO: -->
            <div class="col-auto px-0">
                <label for="dateEnd" class="col-form-label-sm px-2">Date To:</label>
            </div>
            <div class="col-auto px-0">
                <input name="date[end]" type="date" class="form-control form-control-sm" id="dateEnd" value="<?=($date_end)??null;?>">
            </div>
            <!-- BUTTON: -->
            <div class="col-auto px-0">
                <button class="btn text-white btn btn-sm btn-success h-100 d-block mx-2"><span>Search News </span></button>
            </div>
        </div>
        <input type="hidden" name="form_name" value="news_filter" />
    </form>
</div>
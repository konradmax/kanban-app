<div clas="col">
    <form action="/news/delete/<?=$newsItem['id'];?>" method="POST">
        <div class="hidden">
            <input type="hidden" name="form_name" value="form_news_delete">
            <input type="hidden" name="news_id" value="<?=$newsItem['id'];?>">
        </div>
        <!-- SUBMIT: -->
        <button class="btn btn-sm btn-danger float-end" type="submit">Delete</button>
    </form>
</div>
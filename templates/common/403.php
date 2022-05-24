<div class="container pt-5">
    <?php if(isset($messages_template) && ! empty($messages_template)):?>
        <?=$messages_template;?>
    <?php endif;?>
    <div class="p-3 mb-3 background-white">
        <h1>ACCESS ERROR 403: Forbidden</h1>
        <hr class="divider" />
        <p>To see this content user must be have permission.</p>
    </div>
</div>
<?php

$article = get_item($_GET['article']);


if (!empty($article)) {

    ?>

    <div class="content_header">
        <h1><?= $article->title; ?></h1>
    </div>
    <div class="single_article"><img src="<?= STORAGE . $article->image; ?>" alt="Article Image">
        <div class="article">
            <?= $article->body; ?>
        </div>
    </div>

    <?php

}
?>
<?php

$nom_section = $_GET["section"] ?? 'gaming-tips';

$section = 'moira-' . $nom_section;

$obj = getSection($section, 'en', 'articles');

$articles = $obj[0];
$title = $obj[1];

?>
<div class="content_header">
    <h1>News</h1>
    <p>Your hub for the latest in streaming, gaming, apps, and learning</p>
</div>
<div class="main_content articles_content">
    <div class="articles">
        <?php
        foreach ($articles as $item) {
            ?>
            <a class="articles_card_link" href="index.php?page=single-article&article=<?= $item->id ?>"
                data-discover="true">
                <div class="articles_card">
                    <div class="img-frame"><img src="<?= STORAGE . $item->image ?>" alt="<?= $item->title ?>"
                            class="articles_card_image"></div>
                    <div class="articles_card_info">
                        <h2 class="articles_card_title"><?= $item->title ?></h2>
                        <p class="articles_card_description"><?= $item->meta_description ?></p>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>
</div>
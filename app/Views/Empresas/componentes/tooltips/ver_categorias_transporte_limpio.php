<?php

    use App\Models\Administration\CategoriesModel;

    $categories_model = new CategoriesModel();

    $categorias = $categories_model->findAll();
?>

<ul>
    <?php foreach ($categorias as $key => $value): ?>
        <li><?= $value['name'] ?></li>
    <?php endforeach ?>
</ul>
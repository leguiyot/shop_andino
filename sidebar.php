<?php
/**
 * Plan Andino Shop - Sidebar Template
 * 
 * @package PlanAndinoShop
 */

// Verificar si el sidebar está activo
if (!is_active_sidebar('primary-sidebar') && !is_active_sidebar('shop-sidebar')) {
    return;
}
?>

<aside class="sidebar">
    <?php 
    // Mostrar sidebar específico según la página
    if (is_shop() || is_product_category() || is_product_tag() || is_product()) {
        if (is_active_sidebar('shop-sidebar')) {
            dynamic_sidebar('shop-sidebar');
        }
    } else {
        if (is_active_sidebar('primary-sidebar')) {
            dynamic_sidebar('primary-sidebar');
        }
    }
    ?>
</aside>
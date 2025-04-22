<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$terms = get_terms([
  'taxonomy' => 'product_cat',
  'hide_empty' => true,
]);

echo '<form method="GET" class="woo-filter-form" style="display:flex;gap:10px;align-items:center">';
echo '<select name="product_cat_filter">';
echo '<option value="">' . esc_html__( 'Filtrar por categoría', 'mi-bloque' ) . '</option>';
foreach ( $terms as $term ) {
  $selected = isset($_GET['product_cat_filter']) && $_GET['product_cat_filter'] === $term->slug ? 'selected' : '';
  echo '<option value="' . esc_attr( $term->slug ) . '" ' . $selected . '>' . esc_html( $term->name ) . '</option>';
}
echo '</select>';
echo '<button type="submit">' . esc_html__( 'Aplicar', 'mi-bloque' ) . '</button>';
echo '</form>';
?>

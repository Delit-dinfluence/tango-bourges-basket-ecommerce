<?php
/* Smarty version 3.1.39, created on 2021-12-03 19:03:54
  from '/home/zdrjisj/www/boutique/themes/childtheme/templates/checkout/_partials/cart-summary-totals.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61aa5c0a734688_09965218',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '948fe6637d930f0351dd590eae896ab72cac6adf' => 
    array (
      0 => '/home/zdrjisj/www/boutique/themes/childtheme/templates/checkout/_partials/cart-summary-totals.tpl',
      1 => 1634566452,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61aa5c0a734688_09965218 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<div class="card-block cart-summary-totals">

  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_84623634561aa5c0a72c537_29959170', 'cart_summary_total');
?>


  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_80423051561aa5c0a731e60_41872888', 'cart_summary_tax');
?>


</div>
<?php }
/* {block 'cart_summary_total'} */
class Block_84623634561aa5c0a72c537_29959170 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'cart_summary_total' => 
  array (
    0 => 'Block_84623634561aa5c0a72c537_29959170',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if (!$_smarty_tpl->tpl_vars['configuration']->value['display_prices_tax_incl'] && $_smarty_tpl->tpl_vars['configuration']->value['taxes_enabled']) {?>
      <div class="cart-summary-line">
        <span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['label'], ENT_QUOTES, 'UTF-8');?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['labels']['tax_short'], ENT_QUOTES, 'UTF-8');?>
</span>
        <span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
      </div>
      <div class="cart-summary-line cart-total">
        <span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total_including_tax']['label'], ENT_QUOTES, 'UTF-8');?>
</span>
        <span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total_including_tax']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
      </div>
    <?php } else { ?>
      <div class="cart-summary-line cart-total">
        <span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['label'], ENT_QUOTES, 'UTF-8');?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['configuration']->value['taxes_enabled']) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['labels']['tax_short'], ENT_QUOTES, 'UTF-8');
}?></span>
        <span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
      </div>
    <?php }?>
  <?php
}
}
/* {/block 'cart_summary_total'} */
/* {block 'cart_summary_tax'} */
class Block_80423051561aa5c0a731e60_41872888 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'cart_summary_tax' => 
  array (
    0 => 'Block_80423051561aa5c0a731e60_41872888',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php if ($_smarty_tpl->tpl_vars['cart']->value['subtotals']['tax']) {?>
      <div class="cart-summary-line">
        <span class="label sub"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'%label%:','sprintf'=>array('%label%'=>$_smarty_tpl->tpl_vars['cart']->value['subtotals']['tax']['label']),'d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
</span>
        <span class="value sub"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['subtotals']['tax']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
      </div>
    <?php }?>
  <?php
}
}
/* {/block 'cart_summary_tax'} */
}

<?php
/* Smarty version 3.1.39, created on 2021-12-03 18:55:41
  from '/home/zdrjisj/www/boutique/themes/childtheme/templates/catalog/_partials/category-header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61aa5a1d427869_74210267',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ca17d258bd63e2051a1676178ca8df70a6aabd47' => 
    array (
      0 => '/home/zdrjisj/www/boutique/themes/childtheme/templates/catalog/_partials/category-header.tpl',
      1 => 1634566451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61aa5a1d427869_74210267 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="js-product-list-header">
    <?php if ($_smarty_tpl->tpl_vars['listing']->value['pagination']['items_shown_from'] == 1) {?>
        <div class="block-category card card-block">
            <h1 class="h1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value['name'], ENT_QUOTES, 'UTF-8');?>
</h1>
            <div class="block-category-inner">
                <?php if ($_smarty_tpl->tpl_vars['category']->value['description']) {?>
                    <div id="category-description" class="text-muted"><?php echo $_smarty_tpl->tpl_vars['category']->value['description'];?>
</div>
                <?php }?>
                <!--<?php if ($_smarty_tpl->tpl_vars['category']->value['image']['large']['url']) {?>
                    <div class="category-cover">
                        <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value['image']['large']['url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['category']->value['image']['legend'])) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value['image']['legend'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value['name'], ENT_QUOTES, 'UTF-8');
}?>">
                    </div>
                <?php }?>-->
            </div>
        </div>
    <?php }?>
</div>
<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>"displayCategoryTop"),$_smarty_tpl ) );?>

<?php }
}

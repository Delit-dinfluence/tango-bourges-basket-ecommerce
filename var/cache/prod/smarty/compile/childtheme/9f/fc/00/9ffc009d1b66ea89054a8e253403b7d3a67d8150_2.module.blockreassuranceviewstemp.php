<?php
/* Smarty version 3.1.39, created on 2021-12-03 18:58:12
  from 'module:blockreassuranceviewstemp' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61aa5ab48501a3_97858518',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9ffc009d1b66ea89054a8e253403b7d3a67d8150' => 
    array (
      0 => 'module:blockreassuranceviewstemp',
      1 => 1634567050,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61aa5ab48501a3_97858518 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['elements']->value) {?>

  <div id="block-reassurance" class="container">
    <ul class="flex">
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['elements']->value, 'element');
$_smarty_tpl->tpl_vars['element']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['element']->value) {
$_smarty_tpl->tpl_vars['element']->do_else = false;
?>
        <li>
          <div class="block-reassurance-item">
            <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['element']->value['image'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['element']->value['text'], ENT_QUOTES, 'UTF-8');?>
">
            <span class="h6 text-reassurance"><?php echo htmlspecialchars(nl2br($_smarty_tpl->tpl_vars['element']->value['text']), ENT_QUOTES, 'UTF-8');?>
</span>
          </div>
        </li>
      <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    </ul>
  </div>
<?php }
}
}

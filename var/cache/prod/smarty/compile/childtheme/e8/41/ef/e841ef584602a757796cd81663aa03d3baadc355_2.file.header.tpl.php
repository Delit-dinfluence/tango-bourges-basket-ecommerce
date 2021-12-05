<?php
/* Smarty version 3.1.39, created on 2021-12-03 18:58:12
  from '/home/zdrjisj/www/boutique/modules/ybc_nivoslider/views/templates/hook/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61aa5ab476d2c8_07899899',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e841ef584602a757796cd81663aa03d3baadc355' => 
    array (
      0 => '/home/zdrjisj/www/boutique/modules/ybc_nivoslider/views/templates/hook/header.tpl',
      1 => 1634566304,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61aa5ab476d2c8_07899899 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['ybcnivostyle']->value))) {
echo $_smarty_tpl->tpl_vars['ybcnivostyle']->value;
}
if ((isset($_smarty_tpl->tpl_vars['ybcnivo']->value))) {
echo '<script'; ?>
 type="text/javascript">
     var YBCNIVO_WIDTH='<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_WIDTH'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
     var YBCNIVO_HEIGHT='<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_HEIGHT'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
     var YBCNIVO_SPEED=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SPEED']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_PAUSE=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_LOOP=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_LOOP']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_START_SLIDE=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_START_SLIDE']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_PAUSE_ON_HOVER=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_PAUSE_ON_HOVER']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_SHOW_CONTROL=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_CONTROL']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_SHOW_PREV_NEXT=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_SHOW_PREV_NEXT']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_CAPTION_SPEED=<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_CAPTION_SPEED']), ENT_QUOTES, 'UTF-8');?>
;
     var YBCNIVO_FRAME_WIDTH='<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['ybcnivo']->value['YBCNIVO_FRAME_WIDTH'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
<?php echo '</script'; ?>
>
<?php }
}
}

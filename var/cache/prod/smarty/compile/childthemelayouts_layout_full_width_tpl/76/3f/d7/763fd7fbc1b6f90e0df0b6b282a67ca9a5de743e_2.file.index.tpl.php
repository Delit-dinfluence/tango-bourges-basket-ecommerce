<?php
/* Smarty version 3.1.39, created on 2021-12-03 18:58:12
  from '/home/zdrjisj/www/boutique/themes/childtheme/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_61aa5ab486f9f3_17548892',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '763fd7fbc1b6f90e0df0b6b282a67ca9a5de743e' => 
    array (
      0 => '/home/zdrjisj/www/boutique/themes/childtheme/templates/index.tpl',
      1 => 1634565779,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61aa5ab486f9f3_17548892 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_197107064661aa5ab486d623_95935932', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_35590317061aa5ab486dc75_19614252 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_61180325361aa5ab486e809_32851087 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_133054516361aa5ab486e3c9_14628407 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_61180325361aa5ab486e809_32851087', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_197107064661aa5ab486d623_95935932 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_197107064661aa5ab486d623_95935932',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_35590317061aa5ab486dc75_19614252',
  ),
  'page_content' => 
  array (
    0 => 'Block_133054516361aa5ab486e3c9_14628407',
  ),
  'hook_home' => 
  array (
    0 => 'Block_61180325361aa5ab486e809_32851087',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_35590317061aa5ab486dc75_19614252', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_133054516361aa5ab486e3c9_14628407', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}

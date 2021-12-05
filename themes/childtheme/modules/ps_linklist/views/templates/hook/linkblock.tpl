{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
<div class="col-md-6 links">
  <div class="row">
  {foreach $linkBlocks as $linkBlock}
    <div class="col-md-6 wrapper">
      <!-- debug id -->
      {if $linkBlock.id == "1"}
        <p class="h3 hidden-sm-down">{$linkBlock.title}</p>
        {assign var=_expand_id value=10|mt_rand:100000}
        <div class="title clearfix hidden-md-up" data-target="#footer_sub_menu_{$_expand_id}" data-toggle="collapse">
          <span class="h3">{$linkBlock.title}</span>
          <span class="float-xs-right">
            <span class="navbar-toggler collapse-icons">
              <i class="material-icons add">&#xE313;</i>
              <i class="material-icons remove">&#xE316;</i>
            </span>
          </span>
        </div>
        <ul id="footer_sub_menu_{$_expand_id}" class="collapse">
          {foreach $linkBlock.links as $link}
            <li>
              <a
                  id="{$link.id}-{$linkBlock.id}"
                  class="{$link.class}"
                  href="{$link.url}"
                  title="{$link.description}"
                  {if !empty($link.target)} target="{$link.target}" {/if}
              >
                {$link.title}
              </a>
            </li>
        {/foreach}
      </ul>
    </div>
    {else}
      <p class="h3 hidden-sm-down"><a 
      href="{$linkBlock.links[0].url}"
              id="{$linkBlock.links[0].id}"
              class="{$linkBlock.links[0].class}"
              title="{$linkBlock.links[0].description}"
              {if !empty($linkBlock.links[0].target)} target="{$linkBlock.links[0].target}" {/if}>
              {$linkBlock.title}
              </a>
        </p>
        {assign var=_expand_id value=10|mt_rand:100000}
        <div class="title clearfix hidden-md-up" data-target="#footer_sub_menu_{$_expand_id}" data-toggle="collapse">
          <span class="h3">
            <a 
              href="{$linkBlock.links[0].url}"
              id="{$linkBlock.links[0].id}"
              class="{$linkBlock.links[0].class}"
              title="{$linkBlock.links[0].description}"
              {if !empty($linkBlock.links[0].target)} target="{$linkBlock.links[0].target}" {/if}
              >
              {$linkBlock.title}
            </a>
          </span>
          <span class="float-xs-right">
            <span class="navbar-toggler collapse-icons">
              <i class="material-icons add">&#xE313;</i>
              <i class="material-icons remove">&#xE316;</i>
            </span>
          </span>
        </div>
        
    </div>
    {/if}
  {/foreach}
  </div>
</div>
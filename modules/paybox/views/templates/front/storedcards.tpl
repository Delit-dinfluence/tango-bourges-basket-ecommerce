{*
* 2021 Crédit Agricole
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License 3.0 (AFL-3.0).
* It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
*
* @author    PrestaShop / PrestaShop partner
* @copyright 2020-2021 Crédit Agricole
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

{extends file='page.tpl'}

{block name='page_title'}
  {l s='My stored cards' mod='paybox'}
{/block}

{block name='page_content_container'}
  {if $stored_cards}
    <div id="stored-cards">
      {foreach $stored_cards as $stored_card}
        <div class="stored-card">
          <div class="card-content">
            <div>{$stored_card->card_type}</div>
            <img alt="Chip" src="{$img_path}card-chip.png">
            <div class="card-details">
              <span>{$stored_card->bin6|substr:0:4} #### #### ##{$stored_card->pan}</span>
              <span>{$stored_card->datevalTxt}</span>
            </div>
          </div>
          <div class="card-action">
            <a href="{$link->getModuleLink('paybox', 'storedcards', ['delete' => 1, 'token' => $token, 'id_stored_card' => $stored_card->id])}">
              <span class="material-icons">delete</span>
              {l s='Delete' mod='paybox'}
            </a>
          </div>
        </div>
      {/foreach}
    </div>
  {else}
    <div class="alert alert-warning">
      {l s='You don\'t have any stored cards' mod='paybox'}
    </div>
  {/if}
{/block}

{block name='page_footer'}
  {include file='customer/_partials/my-account-links.tpl'}
{/block}

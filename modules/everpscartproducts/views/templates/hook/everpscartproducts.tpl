{*
* Project : everpscartproducts
* @author Team EVER
* @copyright Team EVER
* @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
* @link https://www.team-ever.com
*}
<section id="products">
  <h2 class="text-center">{l s='Vous serez peut-être intéressés par...' d='Modules.everpscartproducts.Shop'}</h2>
  <div class="products row">
    {foreach from=$evercart_products item="product"}
      {include file="catalog/_partials/miniatures/product.tpl" product=$product}
    {/foreach}
  </div>
</section>

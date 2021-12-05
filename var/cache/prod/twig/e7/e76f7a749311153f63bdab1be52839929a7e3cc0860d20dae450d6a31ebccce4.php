<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__8167c74e276ffb43c7ca35cb3ae4728f2d7f0e601ff441f8c8c5784166acd73b */
class __TwigTemplate_d4905d37f717c466dada47e61eb17b10eb542e7695c062ea8aed17df0b9b6814 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'extra_stylesheets' => [$this, 'block_extra_stylesheets'],
            'content_header' => [$this, 'block_content_header'],
            'content' => [$this, 'block_content'],
            'content_footer' => [$this, 'block_content_footer'],
            'sidebar_right' => [$this, 'block_sidebar_right'],
            'javascripts' => [$this, 'block_javascripts'],
            'extra_javascripts' => [$this, 'block_extra_javascripts'],
            'translate_javascripts' => [$this, 'block_translate_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>SEO & URL • Tango Bourges Basket</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminMeta';
    var iso_user = 'fr';
    var lang_is_rtl = '0';
    var full_language_code = 'fr';
    var full_cldr_language_code = 'fr-FR';
    var country_iso_code = 'FR';
    var _PS_VERSION_ = '1.7.7.8';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'Une nouvelle commande a été passée sur votre boutique.';
    var order_number_msg = 'Numéro de commande : ';
    var total_msg = 'Total : ';
    var from_msg = 'Du ';
    var see_order_msg = 'Afficher cette commande';
    var new_customer_msg = 'Un nouveau client s\\'est inscrit sur votre boutique';
    var customer_name_msg = 'Nom du client : ';
    var new_msg = 'Un nouveau message a été posté sur votre boutique.';
    var see_msg = 'Lire le message';
    var token = '664abde518cc36fe8495333e46e7ce87';
    var token_admin_orders = '365baf9e213760d9672363113df781ff';
    var token_admin_customers = '3150696b380f31919c315b57175179db';
    var token_admin_customer_threads = '7249128bd0ab0b9c5b43df19fc4438fe';
    var currentIndex = 'index.php?controller=AdminMeta';
    var employee_token = 'da967c4a496bd8ae42f3eddcd810cf4b';
    var choose_language_translate = 'Choisissez la langue :';
    var default_language = '1';
    var admin_modules_link = '/admin288qu5xza/index.php/improve/modules/catalog/recommended?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk';
    var admin_notification_get_link = '/admin288qu5xza/index.php/common/notifications?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk';
    var admin_notification_push_link = '/admin288qu5xza/index.php/common/notifications/ack?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk';
    var tab_modules_list = '';
    var update_success_msg = 'Mise à jour réussie';
    var errorLogin = 'PrestaShop n\\'a pas pu se connecter à Addons. Veuillez vérifier vos identifiants et votre connexion Internet.';
    var search_product_msg = 'Rechercher un produit';
  </script>

      <link href=\"/admin288qu5xza/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/admin288qu5xza/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/gamification/views/css/gamification.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_mbo/views/css/recommended-modules.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/everblock/views/css/ever.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/ps_facebook/views/css/admin/menu.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/admin288qu5xza\\/\";
var baseDir = \"\\/\";
var changeFormLanguageUrl = \"\\/admin288qu5xza\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":null};
var currency_specifications = {\"symbol\":[\",\",\"\\u202f\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"EUR\",\"currencySymbol\":\"\\u20ac\",\"numberSymbols\":[\",\",\"\\u202f\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.00\\u00a0\\u00a4\",\"negativePattern\":\"-#,##0.00\\u00a0\\u00a4\",\"maxFractionDigits\":2,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var host_mode = false;
var number_specifications = {\"symbol\":[\",\",\"\\u202f\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"numberSymbols\":[\",\",\"\\u202f\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var prestashop = {\"debug\":false};
var show_new_customers = \"1\";
var show_new_messages = false;
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/admin288qu5xza/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/js/admin.js?v=1.7.7.8\"></script>
<script type=\"text/javascript\" src=\"/admin288qu5xza/themes/new-theme/public/cldr.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/tools.js?v=1.7.7.8\"></script>
<script type=\"text/javascript\" src=\"/admin288qu5xza/public/bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin288qu5xza/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_mbo/views/js/recommended-modules.js?v=2.0.1\"></script>
<script type=\"text/javascript\" src=\"/admin288qu5xza/themes/default/js/bundle/module/module_card.js?v=1.7.7.8\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconnotificationbo/views/js/favico.js\"></script>
<script type=\"text/javascript\" src=\"/modules/ps_faviconnotificationbo/views/js/ps_faviconnotificationbo.js\"></script>

  <script>
  if (undefined !== ps_faviconnotificationbo) {
    ps_faviconnotificationbo.initialize({
      backgroundColor: '#DF0067',
      textColor: '#FFFFFF',
      notificationGetUrl: '/admin288qu5xza/index.php/common/notifications?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk',
      CHECKBOX_ORDER: 1,
      CHECKBOX_CUSTOMER: 1,
      CHECKBOX_MESSAGE: 1,
      timer: 120000, // Refresh every 2 minutes
    });
  }
</script>
<script>
            var admin_gamification_ajax_url = \"http:\\/\\/tango-ecommerce.com-clients.fr\\/admin288qu5xza\\/index.php?controller=AdminGamification&token=34f513a745022870b4a72d3a9d3e77e9\";
            var current_id_tab = 97;
        </script>

";
        // line 105
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>

<body
  class=\"lang-fr adminmeta\"
  data-base-url=\"/admin288qu5xza/index.php\"  data-token=\"h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\">

  <header id=\"header\" class=\"d-print-none\">

    <nav id=\"header_infos\" class=\"main-header\">
      <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

            <i class=\"material-icons js-mobile-menu\">menu</i>
      <a id=\"header_logo\" class=\"logo float-left\" href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminDashboard&amp;token=b6d5aa2acde4a30821ccf7d6234d1d09\"></a>
      <span id=\"shop_version\">1.7.7.8</span>

      <div class=\"component\" id=\"quick-access-container\">
        <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Accès rapide
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminOrders&amp;token=365baf9e213760d9672363113df781ff\"
                 data-item=\"Commandes\"
      >Commandes</a>
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=ede4905b1bfa751fa11b4466b3308d20\"
                 data-item=\"Évaluation du catalogue\"
      >Évaluation du catalogue</a>
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php/improve/modules/manage?token=6dc2634a68ceb2db6680138536af30b6\"
                 data-item=\"Modules installés\"
      >Modules installés</a>
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=5237ecefca1ff81f61100c68dc97ca40\"
                 data-item=\"Nouveau bon de réduction\"
      >Nouveau bon de réduction</a>
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php/sell/catalog/products/new?token=6dc2634a68ceb2db6680138536af30b6\"
                 data-item=\"Nouveau produit\"
      >Nouveau produit</a>
          <a class=\"dropdown-item\"
         href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php/sell/catalog/categories/new?token=6dc2634a68ceb2db6680138536af30b6\"
                 data-item=\"Nouvelle catégorie\"
      >Nouvelle catégorie</a>
        <div class=\"dropdown-divider\"></div>
          <a
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"108\"
        data-icon=\"icon-AdminParentMeta\"
        data-method=\"add\"
        data-url=\"index.php/configure/shop/seo-urls/?-lrk\"
        data-post-link=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminQuickAccesses&token=a503cce8211b95b2b48ef90ee9d47f1f\"
        data-prompt-text=\"Veuillez nommer ce raccourci :\"
        data-link=\"SEO &amp; URL - Liste\"
      >
        <i class=\"material-icons\">add_circle</i>
        Ajouter la page actuelle à l'accès rapide
      </a>
        <a class=\"dropdown-item\" href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminQuickAccesses&token=a503cce8211b95b2b48ef90ee9d47f1f\">
      <i class=\"material-icons\">settings</i>
      Gérez vos accès rapides
    </a>
  </div>
</div>
      </div>
      <div class=\"component\" id=\"header-search-container\">
        <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/admin288qu5xza/index.php?controller=AdminSearch&amp;token=7ffd7e08c0680ae96371b59f74662c6d\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Rechercher (ex. : référence produit, nom du client, etc.) d='Admin.Navigation.Header'\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Partout
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Partout\" href=\"#\" data-value=\"0\" data-placeholder=\"Que souhaitez-vous trouver ?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Partout</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalogue\" href=\"#\" data-value=\"1\" data-placeholder=\"Nom du produit, référence, etc.\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalogue</a>
        <a class=\"dropdown-item\" data-item=\"Clients par nom\" href=\"#\" data-value=\"2\" data-placeholder=\"Nom\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Clients par nom</a>
        <a class=\"dropdown-item\" data-item=\"Clients par adresse IP\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Clients par adresse IP</a>
        <a class=\"dropdown-item\" data-item=\"Commandes\" href=\"#\" data-value=\"3\" data-placeholder=\"ID commande\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Commandes</a>
        <a class=\"dropdown-item\" data-item=\"Factures\" href=\"#\" data-value=\"4\" data-placeholder=\"Numéro de facture\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i> Factures</a>
        <a class=\"dropdown-item\" data-item=\"Paniers\" href=\"#\" data-value=\"5\" data-placeholder=\"ID panier\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Paniers</a>
        <a class=\"dropdown-item\" data-item=\"Modules\" href=\"#\" data-value=\"7\" data-placeholder=\"Nom du module\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Modules</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">RECHERCHE</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

      
      
      <div class=\"component\" id=\"header-shop-list-container\">
          <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"http://tango-ecommerce.com-clients.fr/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      Voir ma boutique
    </a>
  </div>
      </div>

              <div class=\"component header-right-component\" id=\"header-notifications-container\">
          <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Commandes<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Clients<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
              href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messages<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Pas de nouvelle commande pour le moment :(<br>
              Avez-vous consulté vos <strong><a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCarts&action=filterOnlyAbandonedCarts&token=3fb2e82e67ce9e5f197ef889d65817bd\">paniers abandonnés</a></strong> ?<br> Votre prochaine commande s'y trouve peut-être !
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Aucun nouveau client pour l'instant :(<br>
              Êtes-vous actifs sur les réseaux sociaux en ce moment ?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Pas de nouveau message pour l'instant.<br>
              Pas de nouvelle, bonne nouvelle, n'est-ce pas ?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a class=\"notif\" href='order_url'>
      #_id_order_ -
      de <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - enregistré le <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
        </div>
      
      <div class=\"component\" id=\"header-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">
      
      <span class=\"employee_avatar\"><img class=\"avatar rounded-circle\" src=\"http://profile.prestashop.com/florian%40delit.fr.jpg\" /></span>
      <span class=\"employee_profile\">Ravi de vous revoir Florian</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/admin288qu5xza/index.php/configure/advanced/employees/1/edit?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\">
      <i class=\"material-icons\">settings</i>
      Votre profil
    </a>
    </div>
    
    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/fr/ressources/documentation?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-fr&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">book</i> Documentation</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/fr/formation?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-fr&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">school</i> Formation</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/fr/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-fr&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">person_pin_circle</i> Trouver un expert</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com/fr/?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-fr&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">extension</i> Place de marché de PrestaShop</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/fr/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-fr&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">help</i> Centre d'assistance</a>
    <p class=\"divider\"></p>
    <a class=\"dropdown-item employee-link text-center\" id=\"header_logout\" href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminLogin&amp;logout=1&amp;token=6c90f3bfde59d1869c3ce6d63cdd0147\">
      <i class=\"material-icons d-lg-none\">power_settings_new</i>
      <span>Déconnexion</span>
    </a>
  </div>
</div>
      </div>
          </nav>
  </header>

  <nav class=\"nav-bar d-none d-print-none d-md-block\">
  <span class=\"menu-collapse\" data-toggle-url=\"/admin288qu5xza/index.php/configure/advanced/employees/toggle-navigation?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <div class=\"nav-bar-overflow\">
    <ul class=\"main-menu\">
              
                    
                    
          
            <li class=\"link-levelone \" data-submenu=\"1\" id=\"tab-AdminDashboard\">
              <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminDashboard&amp;token=b6d5aa2acde4a30821ccf7d6234d1d09\" class=\"link\" >
                <i class=\"material-icons\">trending_up</i> <span>Tableau de bord</span>
              </a>
            </li>

          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"2\" id=\"tab-SELL\">
                <span class=\"title\">Vendre</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                    <a href=\"/admin288qu5xza/index.php/sell/orders/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                      <span>
                      Commandes
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                                <a href=\"/admin288qu5xza/index.php/sell/orders/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Commandes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                                <a href=\"/admin288qu5xza/index.php/sell/orders/invoices/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Factures
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                                <a href=\"/admin288qu5xza/index.php/sell/orders/credit-slips/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Avoirs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                                <a href=\"/admin288qu5xza/index.php/sell/orders/delivery-slips/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Bons de livraison
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCarts&amp;token=3fb2e82e67ce9e5f197ef889d65817bd\" class=\"link\"> Paniers
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                    <a href=\"/admin288qu5xza/index.php/sell/catalog/products?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-store\">store</i>
                      <span>
                      Catalogue
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                                <a href=\"/admin288qu5xza/index.php/sell/catalog/products?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Produits
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                                <a href=\"/admin288qu5xza/index.php/sell/catalog/categories?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Catégories
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                                <a href=\"/admin288qu5xza/index.php/sell/catalog/monitoring/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Suivi
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminAttributesGroups&amp;token=c40833a5f4d90650d2739edf0b2e05d7\" class=\"link\"> Attributs &amp; caractéristiques
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                                <a href=\"/admin288qu5xza/index.php/sell/catalog/brands/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Marques et fournisseurs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                                <a href=\"/admin288qu5xza/index.php/sell/attachments/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Fichiers
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCartRules&amp;token=5237ecefca1ff81f61100c68dc97ca40\" class=\"link\"> Réductions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                                <a href=\"/admin288qu5xza/index.php/sell/stocks/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Stocks
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                    <a href=\"/admin288qu5xza/index.php/sell/customers/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-account_circle\">account_circle</i>
                      <span>
                      Clients
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-24\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"25\" id=\"subtab-AdminCustomers\">
                                <a href=\"/admin288qu5xza/index.php/sell/customers/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Clients
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"26\" id=\"subtab-AdminAddresses\">
                                <a href=\"/admin288qu5xza/index.php/sell/addresses/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Adresses
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"28\" id=\"subtab-AdminParentCustomerThreads\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCustomerThreads&amp;token=7249128bd0ab0b9c5b43df19fc4438fe\" class=\"link\">
                      <i class=\"material-icons mi-chat\">chat</i>
                      <span>
                      SAV
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-28\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCustomerThreads&amp;token=7249128bd0ab0b9c5b43df19fc4438fe\" class=\"link\"> SAV
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                                <a href=\"/admin288qu5xza/index.php/sell/customer-service/order-messages/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Messages prédéfinis
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminReturn&amp;token=b62a13952321a2a768d69dde71ad8161\" class=\"link\"> Retours produits
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminMetricsStats&amp;token=110cf30ce6b4f47571b79e55afb937d7\" class=\"link\">
                      <i class=\"material-icons mi-assessment\">assessment</i>
                      <span>
                      Statistiques
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-32\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"144\" id=\"subtab-AdminMetricsStats\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminMetricsStats&amp;token=110cf30ce6b4f47571b79e55afb937d7\" class=\"link\"> PrestaShop Metrics
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"145\" id=\"subtab-AdminLegacyStatsMetrics\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminLegacyStatsMetrics&amp;token=1b6f9d82499fda236aaa4fe6f8f53b18\" class=\"link\"> Statistiques
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title \" data-submenu=\"42\" id=\"tab-IMPROVE\">
                <span class=\"title\">Personnaliser</span>
            </li>

                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                    <a href=\"/admin288qu5xza/index.php/improve/modules/manage?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-extension\">extension</i>
                      <span>
                      Modules
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                                <a href=\"/admin288qu5xza/index.php/improve/modules/manage?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Gestionnaire de modules 
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"48\" id=\"subtab-AdminParentModulesCatalog\">
                                <a href=\"/admin288qu5xza/index.php/modules/addons/modules/catalog?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Catalogue de modules
                                </a>
                              </li>

                                                                                                                                    </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"52\" id=\"subtab-AdminParentThemes\">
                    <a href=\"/admin288qu5xza/index.php/improve/design/themes/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                      <span>
                      Apparence
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-52\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"126\" id=\"subtab-AdminThemesParent\">
                                <a href=\"/admin288qu5xza/index.php/improve/design/themes/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Thème et logo
                                </a>
                              </li>

                                                                                                                                        
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"136\" id=\"subtab-AdminPsMboTheme\">
                                <a href=\"/admin288qu5xza/index.php/modules/addons/themes/catalog?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Catalogue de thèmes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"55\" id=\"subtab-AdminParentMailTheme\">
                                <a href=\"/admin288qu5xza/index.php/improve/design/mail_theme/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Thème d&#039;email
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"57\" id=\"subtab-AdminCmsContent\">
                                <a href=\"/admin288qu5xza/index.php/improve/design/cms-pages/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Pages
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"58\" id=\"subtab-AdminModulesPositions\">
                                <a href=\"/admin288qu5xza/index.php/improve/design/modules/positions/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Positions
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"59\" id=\"subtab-AdminImages\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminImages&amp;token=721c47d1df5511c14a4bfcebd4ce799f\" class=\"link\"> Images
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"125\" id=\"subtab-AdminLinkWidget\">
                                <a href=\"/admin288qu5xza/index.php/modules/link-widget/list?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Liste de liens
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"60\" id=\"subtab-AdminParentShipping\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCarriers&amp;token=44f0256ca158a8d7d72ea7615e1c364b\" class=\"link\">
                      <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                      <span>
                      Livraison
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-60\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"61\" id=\"subtab-AdminCarriers\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminCarriers&amp;token=44f0256ca158a8d7d72ea7615e1c364b\" class=\"link\"> Transporteurs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"62\" id=\"subtab-AdminShipping\">
                                <a href=\"/admin288qu5xza/index.php/improve/shipping/preferences?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Préférences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"63\" id=\"subtab-AdminParentPayment\">
                    <a href=\"/admin288qu5xza/index.php/improve/payment/payment_methods?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-payment\">payment</i>
                      <span>
                      Paiement
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-63\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"64\" id=\"subtab-AdminPayment\">
                                <a href=\"/admin288qu5xza/index.php/improve/payment/payment_methods?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Modes de paiement
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"65\" id=\"subtab-AdminPaymentPreferences\">
                                <a href=\"/admin288qu5xza/index.php/improve/payment/preferences?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Préférences
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"66\" id=\"subtab-AdminInternational\">
                    <a href=\"/admin288qu5xza/index.php/improve/international/localization/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-language\">language</i>
                      <span>
                      International
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-66\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"67\" id=\"subtab-AdminParentLocalization\">
                                <a href=\"/admin288qu5xza/index.php/improve/international/localization/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Localisation
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"72\" id=\"subtab-AdminParentCountries\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminZones&amp;token=74478b0cd50655d73dfd69d40484d8b4\" class=\"link\"> Zones géographiques
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"76\" id=\"subtab-AdminParentTaxes\">
                                <a href=\"/admin288qu5xza/index.php/improve/international/taxes/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Taxes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"79\" id=\"subtab-AdminTranslations\">
                                <a href=\"/admin288qu5xza/index.php/improve/international/translations/settings?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Traductions
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"148\" id=\"subtab-Marketing\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminPsfacebookModule&amp;token=c855bd1e6b1b2ce988e96b4dc7302654\" class=\"link\">
                      <i class=\"material-icons mi-campaign\">campaign</i>
                      <span>
                      Marketing
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-148\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"149\" id=\"subtab-AdminPsfacebookModule\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminPsfacebookModule&amp;token=c855bd1e6b1b2ce988e96b4dc7302654\" class=\"link\"> Facebook
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone\" data-submenu=\"152\" id=\"subtab-AdminEverBlock\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminEverBlock&amp;token=6436e1748750b7a1ee6cffa45f63fffe\" class=\"link\">
                      <i class=\"material-icons mi-icon-team-ever\">icon-team-ever</i>
                      <span>
                      Blocs HTML
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                        </li>
                              
          
                      
                                          
                    
          
            <li class=\"category-title -active\" data-submenu=\"80\" id=\"tab-CONFIGURE\">
                <span class=\"title\">Configurer</span>
            </li>

                              
                  
                                                      
                                                          
                  <li class=\"link-levelone has_submenu -active open ul-open\" data-submenu=\"81\" id=\"subtab-ShopParameters\">
                    <a href=\"/admin288qu5xza/index.php/configure/shop/preferences/preferences?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-settings\">settings</i>
                      <span>
                      Paramètres de la boutique
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_up
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-81\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"82\" id=\"subtab-AdminParentPreferences\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/preferences/preferences?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Paramètres généraux
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"85\" id=\"subtab-AdminParentOrderPreferences\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/order-preferences/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Commandes
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"88\" id=\"subtab-AdminPPreferences\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/product-preferences/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Produits
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"89\" id=\"subtab-AdminParentCustomerPreferences\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/customer-preferences/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Clients
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"93\" id=\"subtab-AdminParentStores\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/contacts/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Contact
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo -active\" data-submenu=\"96\" id=\"subtab-AdminParentMeta\">
                                <a href=\"/admin288qu5xza/index.php/configure/shop/seo-urls/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Trafic et SEO
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"100\" id=\"subtab-AdminParentSearchConf\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminSearchConf&amp;token=13369fc174023edf0574b862ab7f06e1\" class=\"link\"> Rechercher
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"130\" id=\"subtab-AdminGamification\">
                                <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminGamification&amp;token=34f513a745022870b4a72d3a9d3e77e9\" class=\"link\"> Merchant Expertise
                                </a>
                              </li>

                                                                              </ul>
                                        </li>
                                              
                  
                                                      
                  
                  <li class=\"link-levelone has_submenu\" data-submenu=\"103\" id=\"subtab-AdminAdvancedParameters\">
                    <a href=\"/admin288qu5xza/index.php/configure/advanced/system-information/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\">
                      <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                      <span>
                      Paramètres avancés
                      </span>
                                                    <i class=\"material-icons sub-tabs-arrow\">
                                                                    keyboard_arrow_down
                                                            </i>
                                            </a>
                                              <ul id=\"collapse-103\" class=\"submenu panel-collapse\">
                                                      
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"104\" id=\"subtab-AdminInformation\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/system-information/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Informations
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"105\" id=\"subtab-AdminPerformance\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/performance/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Performances
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"106\" id=\"subtab-AdminAdminPreferences\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/administration/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Administration
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"107\" id=\"subtab-AdminEmails\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/emails/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> E-mail
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"108\" id=\"subtab-AdminImport\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/import/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Importer
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"109\" id=\"subtab-AdminParentEmployees\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/employees/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Équipe
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"113\" id=\"subtab-AdminParentRequestSql\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/sql-requests/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Base de données
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"116\" id=\"subtab-AdminLogs\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/logs/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Logs
                                </a>
                              </li>

                                                                                  
                              
                                                            
                              <li class=\"link-leveltwo \" data-submenu=\"117\" id=\"subtab-AdminWebservice\">
                                <a href=\"/admin288qu5xza/index.php/configure/advanced/webservice-keys/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" class=\"link\"> Webservice
                                </a>
                              </li>

                                                                                                                                                                                          </ul>
                                        </li>
                              
          
                  </ul>
  </div>
  
</nav>

<div id=\"main-div\">
          
<div class=\"header-toolbar d-print-none\">
  <div class=\"container-fluid\">

    
      <nav aria-label=\"Breadcrumb\">
        <ol class=\"breadcrumb\">
                      <li class=\"breadcrumb-item\">Trafic et SEO</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/admin288qu5xza/index.php/configure/shop/seo-urls/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" aria-current=\"page\">SEO &amp; URL</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            SEO &amp; URL          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                          <a
                  class=\"btn btn-primary  pointer\"                  id=\"page-header-desc-configuration-add\"
                  href=\"/admin288qu5xza/index.php/configure/shop/seo-urls/new?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\"                  title=\"Ajouter une page\"                >
                  <i class=\"material-icons\">add_circle_outline</i>                  Ajouter une page
                </a>
                                      
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Aide\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/admin288qu5xza/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Ffr%252Fdoc%252FAdminMeta%253Fversion%253D1.7.7.8%2526country%253Dfr/Aide?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\"
                   id=\"product_form_open_help\"
                >
                  Aide
                </a>
                                    </div>
        </div>
      
    </div>
  </div>

  
      <div class=\"page-head-tabs\" id=\"head_tabs\">
      <ul class=\"nav nav-pills\">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <li class=\"nav-item\">
                    <a href=\"/admin288qu5xza/index.php/configure/shop/seo-urls/?_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk\" id=\"subtab-AdminMeta\" class=\"nav-link tab active current\" data-submenu=\"97\">
                      SEO & URL
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminSearchEngines&token=887748680df0eac7a53fb84a933bd9b1\" id=\"subtab-AdminSearchEngines\" class=\"nav-link tab \" data-submenu=\"98\">
                      Moteurs de recherche
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                <li class=\"nav-item\">
                    <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminReferrers&token=99c41472581cb1fde65ae5678a3266dc\" id=\"subtab-AdminReferrers\" class=\"nav-link tab \" data-submenu=\"99\">
                      Affiliés
                      <span class=\"notification-container\">
                        <span class=\"notification-counter\"></span>
                      </span>
                    </a>
                  </li>
                                                                                                                                                                                                                                                                                                                                                                                        </ul>
    </div>
    <script>
  if (undefined !== mbo) {
    mbo.initialize({
      translations: {
        'Recommended Modules and Services': 'Modules et services recommandés',
        'Close': 'Fermer',
      },
      recommendedModulesUrl: '/admin288qu5xza/index.php/modules/addons/modules/recommended?tabClassName=AdminMeta&_token=h0Xu7KJ6yiVwQzLXFu8AOKE5Y3zYjcb4ydAap3N-lrk',
      shouldAttachRecommendedModulesAfterContent: 0,
      shouldAttachRecommendedModulesButton: 1,
      shouldUseLegacyTheme: 0,
    });
  }
</script>

</div>
      
      <div class=\"content-div  with-tabs\">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1188
        $this->displayBlock('content_header', $context, $blocks);
        // line 1189
        echo "                 ";
        $this->displayBlock('content', $context, $blocks);
        // line 1190
        echo "                 ";
        $this->displayBlock('content_footer', $context, $blocks);
        // line 1191
        echo "                 ";
        $this->displayBlock('sidebar_right', $context, $blocks);
        // line 1192
        echo "
            
          </div>
        </div>

      </div>
    </div>

  <div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh non !</h1>
  <p class=\"mt-3\">
    La version mobile de cette page n'est pas encore disponible.
  </p>
  <p class=\"mt-2\">
    En attendant que cette page soit adaptée au mobile, vous êtes invité à la consulter sur ordinateur.
  </p>
  <p class=\"mt-2\">
    Merci.
  </p>
  <a href=\"http://tango-ecommerce.com-clients.fr/admin288qu5xza/index.php?controller=AdminDashboard&amp;token=b6d5aa2acde4a30821ccf7d6234d1d09\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Précédent
  </a>
</div>
  <div class=\"mobile-layer\"></div>

      <div id=\"footer\" class=\"bootstrap\">
    
</div>
  

      <div class=\"bootstrap\">
      <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-FR&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/fr/login?email=florian%40delit.fr&amp;firstname=Florian&amp;lastname=D%C3%A9lit&amp;website=http%3A%2F%2Ftango-ecommerce.com-clients.fr%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-FR&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/admin288qu5xza/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Connectez-vous à la place de marché de PrestaShop afin d'importer automatiquement tous vos achats.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Vous n'avez pas de compte ?</h4>
\t\t\t\t\t\t<p class='text-justify'>Les clés pour réussir votre boutique sont sur PrestaShop Addons ! Découvrez sur la place de marché officielle de PrestaShop plus de 3 500 modules et thèmes pour augmenter votre trafic, optimiser vos conversions, fidéliser vos clients et vous faciliter l’e-commerce.</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Connectez-vous à PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/fr/forgot-your-password\">Mot de passe oublié</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/fr/login?email=florian%40delit.fr&amp;firstname=Florian&amp;lastname=D%C3%A9lit&amp;website=http%3A%2F%2Ftango-ecommerce.com-clients.fr%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-FR&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCréer un compte
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Connexion
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

    </div>
  
";
        // line 1299
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>
</html>";
    }

    // line 105
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
    }

    // line 1188
    public function block_content_header($context, array $blocks = [])
    {
    }

    // line 1189
    public function block_content($context, array $blocks = [])
    {
    }

    // line 1190
    public function block_content_footer($context, array $blocks = [])
    {
    }

    // line 1191
    public function block_sidebar_right($context, array $blocks = [])
    {
    }

    // line 1299
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "__string_template__8167c74e276ffb43c7ca35cb3ae4728f2d7f0e601ff441f8c8c5784166acd73b";
    }

    public function getDebugInfo()
    {
        return array (  1389 => 1299,  1384 => 1191,  1379 => 1190,  1374 => 1189,  1369 => 1188,  1360 => 105,  1352 => 1299,  1243 => 1192,  1240 => 1191,  1237 => 1190,  1234 => 1189,  1232 => 1188,  145 => 105,  39 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__8167c74e276ffb43c7ca35cb3ae4728f2d7f0e601ff441f8c8c5784166acd73b", "");
    }
}

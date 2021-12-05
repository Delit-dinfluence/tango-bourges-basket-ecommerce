<?php
/**
 * Project : everpscartproducts
 * @author Team Ever
 * @copyright Team Ever
 * @license   Tous droits réservés / Le droit d'auteur s'applique (All rights reserved / French copyright law applies)
 * @link https://www.team-ever.com
 */

use PrestaShop\PrestaShop\Core\Module\WidgetInterface;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Everpscartproducts extends Module
{
    private $html;
    private $postErrors = array();
    private $postSuccess = array();

    public function __construct()
    {
        $this->name = 'everpscartproducts';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Team Ever';
        $this->need_instance = 0;
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Ever PS Cart Products');
        $this->description = $this->l('Show products of specific category on cart page');
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->templateFile = 'module:everpscartproducts/views/templates/hook/everpscartproducts.tpl';
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('EVERPSCARTPRODUCTS_NBR', 4);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayShoppingCartFooter');
    }

    public function uninstall()
    {
        Configuration::deleteByName('EVERPSCARTPRODUCTS_NBR');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        if (((bool)Tools::isSubmit('submitEverpscartproductsModule')) == true) {
            $this->postValidation();

            if (!count($this->postErrors)) {
                $this->postProcess();
            }
        }
        $this->context->smarty->assign(array(
            'image_dir' => $this->_path.'views/img',
        ));

        $this->html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/header.tpl');
        $this->html .= $this->renderForm();
        $this->html .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/footer.tpl');

        return $this->html;
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitEverpscartproductsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        $category_tree = array(
            'selected_categories' => array((int)Configuration::get('EVERPSCARTPRODUCTS_CAT_ID')),
            'use_search' => true,
            'use_checkbox' => false,
            'id' => 'id_category_tree',
        );
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Number of products shown'),
                        'name' => 'EVERPSCARTPRODUCTS_NBR',
                        'desc' => $this->l('Row will show 4 products by default'),
                    ),
                    array(
                        'type' => 'categories',
                        'name' => 'EVERPSCARTPRODUCTS_CAT_ID',
                        'label' => $this->l('Category'),
                        'required' => true,
                        'hint' => 'Only products in selected categories will be shown',
                        'tree' => $category_tree,
                        'form_group_class' => 'mode_category',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'EVERPSCARTPRODUCTS_NBR' => Configuration::get(
                'EVERPSCARTPRODUCTS_NBR'
            ),
            'EVERPSCARTPRODUCTS_CAT_ID' => Configuration::get(
                'EVERPSCARTPRODUCTS_CAT_ID'
            ),
        );
    }

    public function postValidation()
    {
        if (((bool)Tools::isSubmit('submitEverpscartproductsModule')) == true) {
            if (!Tools::getValue('EVERPSCARTPRODUCTS_NBR')
                || !Validate::isInt(Tools::getValue('EVERPSCARTPRODUCTS_NBR'))
            ) {
                $this->posterrors[] = $this->l('error : [Number] is not valid');
            }
            if (!Tools::getValue('EVERPSCARTPRODUCTS_CAT_ID')
                || !Validate::isInt(Tools::getValue('EVERPSCARTPRODUCTS_CAT_ID'))
            ) {
                $this->posterrors[] = $this->l('error : [Category ID] is not valid');
            }
        }
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addCSS($this->_path.'views/css/ever.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        // $this->context->controller->addJS($this->_path.'/views/js/front.js');
        // $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayShoppingCartFooter()
    {
        $category = new Category(
            (int)Configuration::get('EVERPSCARTPRODUCTS_CAT_ID'),
            (int)Context::getContext()->language->id,
            (int)Context::getContext()->shop->id
        );
        $nbr = Configuration::get(
            'EVERPSCARTPRODUCTS_NBR'
        );
        $category_products = $category->getProducts(
            (int)Context::getContext()->language->id,
            1,
            (int)$nbr
        );

        if (!empty($category_products)) {
            $showPrice = true;
            $assembler = new ProductAssembler($this->context);
            $presenterFactory = new ProductPresenterFactory($this->context);
            $presentationSettings = $presenterFactory->getPresentationSettings();
            $presenter = new ProductListingPresenter(
                new ImageRetriever(
                    $this->context->link
                ),
                $this->context->link,
                new PriceFormatter(),
                new ProductColorsRetriever(),
                $this->context->getTranslator()
            );

            $productsForTemplate = array();

            $presentationSettings->showPrices = $showPrice;

            if (is_array($category_products)) {
                foreach ($category_products as $productId) {
                    $productsForTemplate[] = $presenter->present(
                        $presentationSettings,
                        $assembler->assembleProduct(array('id_product' => $productId['id_product'])),
                        $this->context->language
                    );
                }
            }
            $this->context->smarty->assign(array(
                'evercart_products' => $productsForTemplate,
            ));
            return $this->context->smarty->fetch(
                $this->local_path.'views/templates/hook/everpscartproducts.tpl'
            );
        }
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('session');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
    }

    public function index() {
        redirect('/');
    }

    //function for product list
    function ProductList($cat_id) {
        $categories = $this->Product_model->productListCategories($cat_id);
        $data["categorie_parent"] = $this->Product_model->getparent($cat_id);
        $data["categories"] = $categories;
        $data["category"] = $cat_id;
        $this->load->view('Product/productList', $data);
    }
    
    
    function ProductSearch(){
        $data['keyword'] = $_GET['keyword'];
        $this->load->view('Product/productSearch', $data);
    }

    //function for details
    function ProductDetails($product_id) {
        $prodct_details = $this->Product_model->productDetails($product_id);
        if ($prodct_details) {
            
             $data['buttonlist'] = $this->Product_model->productButtonsList($product_id);
            
            $prodct_details_attrs = $this->Product_model->productDetailsVariants($product_id);

            $data['product_attr_variant'] = $prodct_details_attrs;

            $pquery = "SELECT pa.attribute, cav.attribute_value FROM product_attribute as pa
      join category_attribute_value as cav on cav.id = pa.attribute_value_id
      where pa.product_id = $product_id";
            $attr_products = $this->Product_model->query_exe($pquery);
            $data["product_attr"] = $attr_products;
            $categorie_parent = $this->Product_model->getparent($prodct_details['category_id']);
            $data["categorie_parent"] = $categorie_parent;
            $data["product_details"] = $prodct_details;


            $pquery = "SELECT pa.* FROM product_related as pr 
      join products as pa on pa.id = pr.related_product_id
      where pr.product_id = $product_id";
            $product_related = $this->Product_model->query_exe($pquery);

            $data["product_related"] = $product_related;

            $this->config->load('seo_config');
            $this->config->set_item('seo_title', $prodct_details['title']);
            $this->config->set_item('seo_desc', $prodct_details['short_description']);
            $this->config->set_item('seo_keywords', $prodct_details['keywords']);
            $this->config->set_item('seo_imgurl', imageserver . $prodct_details['file_name']);

            $this->load->view('Product/productDetails', $data);
        } else {
            $this->load->view('errors/html/error_404');
        }
    }

    function test() {
//        $this->session->unset_userdata('session_cart');
        //$session_cart = $this->Product_model->cartOperation(214, 1);
        $session_cart = $this->Product_model->cartData();
        echo "<pre>";
        print_r($session_cart);
    }

    function unsetData() {
        $this->session->unset_userdata('session_cart');
    }

}

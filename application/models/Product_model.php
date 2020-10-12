<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    function edit_table_information($tableName, $id) {
        $this->User_model->tracking_data_insert($tableName, $id, 'update');
        $this->db->update($tableName, $id);
    }

    public function query_exe($query) {
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data; //format the array into json data
        } else {
            return array();
        }
    }

    function delete_table_information($tableName, $columnName, $id) {
        $this->db->where($columnName, $id);
        $this->db->delete($tableName);
    }

    function convert_num_word($number) {
        $no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
            } else
                $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
        return $result . "Rupees  " . $points . " Paise";
    }

    ///*******  Get data for deepth of the array  ********///
    //Categories string
    function stringCategories($category_id) {
        $this->db->where('parent_id', $category_id);
        $query = $this->db->get('category');
        $category = $query->result_array();
        $container = "";
        foreach ($category as $ckey => $cvalue) {
            $container .= $this->stringCategories($cvalue['id']);
            $container .=", " . $cvalue['id'];
        }
        return $container;
    }

    function singleProductAttrs($product_id) {
        $query = "SELECT pa.attribute, pa.product_id, pa.attribute_value_id, cav.attribute_value FROM product_attribute as pa 
join category_attribute_value as cav on cav.id = pa.attribute_value_id
where pa.product_id = $product_id group by attribute_value_id";
        $product_attr_value = $this->query_exe($query);
        $arrayattr = [];
        if (count($product_attr_value))
            foreach ($product_attr_value as $key => $value) {
                $attrk = $value['attribute'];
                $attrv = $value['attribute_value'];
                array_push($arrayattr, $attrk . '-' . $attrv);
            }
        return implode(", ", $arrayattr);
    }

    //product Details
    function productDetails($product_id) {
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        $product = $query->result_array();
        if (count($product)) {
            $productobj = $product[0];
            $productattr = $this->singleProductAttrs($productobj['id']);
            $productobj['attrs'] = $productattr;

            $this->db->where('id', $productobj['user_id']);
            $query = $this->db->get('admin_users');
            $userobj = $query->result_array();
             $productobj['vendor'] = "CAPS";
            if($userobj){
                $userobj = $userobj[0];
                $productobj['vendor'] = $userobj['first_name'] . " " . $userobj['last_name'];
            }

            
            return $productobj;
        } else {
            return FALSE;
        }
    }

    function getProductVeriants($product_id) {
        $this->db->select("id as product_id");
        $this->db->where('variant_product_of', $product_id);
        $query = $this->db->get('products');
        $product_veriant = $query->result_array();
        return $product_veriant;
    }

    //product veriants
    function productDetailsVariants($product_id) {
        $product_veriant = $this->getProductVeriants($product_id);
        $mproduct_id = $product_id;
        if (count($product_veriant)) {
            
        } else {
            $this->db->select("variant_product_of as product_id");
            $this->db->where('id', $product_id);
            $query = $this->db->get('products');
            $productvcs = $query->row();
            $mproduct_id = $productvcs->product_id;
            if ($mproduct_id) {
                $product_veriant = $this->getProductVeriants($mproduct_id);
            } else {
                $mproduct_id = $product_id;
                $product_veriant = [];
            }
        }

        $mproduct_id;
        $productvstr = [$mproduct_id];
        foreach ($product_veriant as $key => $value) {
            array_push($productvstr, $value['product_id']);
        }

        $productatrvalue = implode(", ", $productvstr);
        $query = "SELECT pa.attribute, pa.product_id, pa.attribute_value_id, cav.attribute_value FROM product_attribute as pa 
join category_attribute_value as cav on cav.id = pa.attribute_value_id
where pa.product_id in ($productatrvalue) group by attribute_value_id";
        $product_attr_value = $this->query_exe($query);


        $product_attrs = array();
        foreach ($product_attr_value as $key => $value) {
            $attrv = $value['attribute'];
            if (isset($product_attrs[$attrv])) {
                array_push($product_attrs[$attrv], $value);
            } else {
                $product_attrs[$attrv] = [$value];
            }
        }
        if (count($product_attrs)) {
            return $product_attrs;
        } else {
            return FALSE;
        }
    }

    /////Cart management 
    //get cart data
    function cartData($user_id = 0) {
        if ($user_id != 0) {
            $this->db->where('user_id', $user_id);
            $this->db->where('order_id', '0');
            $query = $this->db->get('cart');
            $product = $query->result_array();
            $productlist = array();
            $total_price = 0;
            $total_quantity = 0;
            $total_credit_limit = 0;
            foreach ($product as $key => $value) {
                $productlist[$value['product_id']] = $value;
                $total_price += $value['total_price'];
                $total_quantity += $value['quantity'];
                $total_credit_limit += ($value['credit_limit'] * $value['quantity']);
            }

            $cartdata = array('products' => $productlist,
                'total_quantity' => $total_quantity,
                'total_price' => $total_price,
                'total_credit_limit' => $total_credit_limit,
                'used_credit' => 0);
            return $cartdata;
        } else {
            $session_cart = $this->session->userdata('session_cart');
            if ($session_cart) {
                
            } else {
                $cartdata = array('products' => array(),
                    'total_quantity' => 0,
                    'total_credit_limit' => $total_credit_limit,
                    'total_price' => 0, 'used_credit' => 0);
                $this->session->set_userdata('session_cart', $cartdata);
                $session_cart = $this->session->userdata('session_cart');
            }
            $session_cart['total_quantity'] = 0;
            $session_cart['total_price'] = 0;
            foreach ($session_cart['products'] as $key => $value) {
                $session_cart['total_quantity'] += $value['quantity'];
                $session_cart['total_price'] += $value['total_price'];
            }
            return $session_cart;
        }
    }

    //get order details  
    public function getOrderDetails($key_id, $is_key = 0) {
        $order_data = array();
        if ($is_key === 'key') {
            $this->db->where('order_key', $key_id);
        } else {
            $this->db->where('id', $key_id);
        }
        $query = $this->db->get('user_order');
        $order_details = $query->row();

        if ($order_details) {

//            $this->db->order_by('id', 'desc');
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('user_order_status');
            $userorderstatus = $query->result();
            $order_data['order_status'] = $userorderstatus;

            $order_id = $order_details->id;
            $order_data['order_data'] = $order_details;
            $this->db->where('order_id', $order_details->id);
            $query = $this->db->get('cart');
            $cart_items = $query->result();

            foreach ($cart_items as $key => $value) {
                $vendor_id = $value->vendor_id;
//                $this->db->order_by('id', 'desc');
                $this->db->where('order_id', $order_id);
                $this->db->where('vendor_id', $vendor_id);
                $query = $this->db->get('vendor_order_status');
                $orderstatus = $query->result();
                $value->product_status = $orderstatus;
            }

            $order_data['cart_data'] = $cart_items;
            $order_data['amount_in_word'] = $this->convert_num_word($order_data['order_data']->total_price);
        }
        return $order_data;
    }

    //usr cart
    public function userCartOperationGet($user_id) {
        
    }

    //cart operation session 
    public function cartOperation($product_id, $quantity, $user_id = 0, $setSession = 0) {


        if ($user_id != 0) {
            $cartdata = $this->cartData($user_id);
            $product_details = $this->productDetails($product_id);
            $product_dict = array(
                'title' => $product_details['title'],
                'price' => $product_details['price'],
                'sku' => $product_details['sku'],
                'attrs' => $product_details['attrs'],
                'vendor_id' => $product_details['user_id'],
                'total_price' => $product_details['price'],
                'file_name' => imageserver . $product_details['file_name'],
                'quantity' => $quantity,
                'user_id' => $user_id,
                'credit_limit' => $product_details['credit_limit'] ? $product_details['credit_limit'] : 0,
                'product_id' => $product_id,
                'op_date_time' => date('Y-m-d H:i:s'),
            );
            if (isset($cartdata['products'][$product_id])) {
                if ($setSession) {
                    $total_price = $product_details['price'] * $quantity;
                    $total_quantity = $quantity;
                } else {
                    $total_price = $cartdata['products'][$product_id]['total_price'] + $product_details['price'];
                    $total_quantity = $cartdata['products'][$product_id]['quantity'] + $quantity;
                }
                $cid = $cartdata['products'][$product_id]['id'];
                $this->db->set('quantity', $total_quantity);
                $this->db->set('total_price', $total_price);
                $this->db->where('id', $cid); //set column_name and value in which row need to update
                $this->db->update('cart'); //
            } else {
                $this->db->insert('cart', $product_dict);
            }
        } else {
            $session_cart = $this->session->userdata('session_cart');
            if ($session_cart) {
                
            } else {
                $cartdata = array('products' => array(), 'total_quantity' => 0, 'total_price' => 0);
                $this->session->set_userdata('session_cart', $cartdata);
                $session_cart = $this->session->userdata('session_cart');
            }

            if (isset($session_cart['products'][$product_id])) {
                $product_dict = $session_cart['products'][$product_id];
                $qauntity = $product_dict['quantity'] + $quantity;
                $price = $product_dict['price'] * $qauntity;
                $session_cart['products'][$product_id]['quantity'] = $qauntity;
                $session_cart['products'][$product_id]['total_price'] = $price;
                $this->session->set_userdata('session_cart', $session_cart);
            } else {
                $product_details = $this->productDetails($product_id);
                $product_dict = array(
                    'title' => $product_details['title'],
                    'price' => $product_details['price'],
                    'sku' => $product_details['sku'],
                    'attrs' => $product_details['attrs'],
                    'vendor_id' => $product_details['user_id'],
                    'total_price' => $product_details['price'],
                    'file_name' => imageserver . $product_details['file_name'],
                    'quantity' => 1,
                    'product_id' => $product_id,
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                );
                $session_cart['products'][$product_id] = $product_dict;
                $this->session->set_userdata('session_cart', $session_cart);
            }
            $session_cart = $this->session->userdata('session_cart');
        }
    }

    //category list array
    function productListCategories($category_id) {
        $this->db->where('parent_id', $category_id);
        $query = $this->db->get('category');
        $category = $query->result_array();
        $container = [];
        foreach ($category as $ckey => $cvalue) {
            $cvalue['sub_category'] = $this->productListCategories($cvalue['id']);
            array_push($container, $cvalue);
        }
        return $container;
    }

    function get_children($id, $container) {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        $category = $query->result_array()[0];
        $this->db->where('parent_id', $id);
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            $childrens = $query->result_array();

            $category['children'] = $query->result_array();

            foreach ($query->result_array() as $row) {
                $pid = $row['id'];
                $this->get_children($pid, $container);
            }

            print_r($category);
            return $category;
        } else {
            
        }
    }

    function getparent($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        $texts = array();
        foreach ($query->result_array() as $row) {
            $texts = $this->getparent($row['parent_id']);
            array_push($texts, $row);
        }
        return $texts;
    }

    function parent_get($id) {
        $catarray = $this->getparent($id, []);
        array_reverse($catarray);
        $catarray = array_reverse($catarray, $preserve_keys = FALSE);
        $catcontain = array();
        foreach ($catarray as $key => $value) {
            array_push($catcontain, $value['category_name']);
        }
        $catstring = implode("->", $catcontain);
        return array('category_string' => $catstring, "category_array" => $catarray);
    }

    function child($id) {
        $this->db->where('parent_id', $id);
        $query = $this->db->get('category');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $cat[] = $row;
                $cat[$row['id']] = $this->child($row['id']);
                $cat[] = $row;
            }

            return $cat; //format the array into json data
        }
    }

    function product_home_slider_bottom() {
        $pquery = "SELECT pa.* FROM products as pa where home_slider = 'on' and variant_product_of<1";
        $product_home_slider = $this->query_exe($pquery);


        $pquery = "SELECT pa.* FROM products as pa where home_bottom = 'on'  and variant_product_of<1";
        $product_home_bottom = $this->query_exe($pquery);

        return array('home_bottom' => $product_home_bottom, 'home_slider' => $product_home_slider);
    }

    function product_attribute_list($product_id) {
        $this->db->where('product_id', $product_id);
        $this->db->group_by('attribute_value_id');
        $query = $this->db->get('product_attribute');
        $atterarray = array();
        if ($query->num_rows() > 0) {
            $attrs = $query->result_array();
            foreach ($attrs as $key => $value) {
                $atterarray[$value['attribute_id']] = $value;
            }
            return $atterarray;
        } else {
            return array();
        }
    }

    function category_attribute_list($id) {
        $this->db->where('attribute_id', $id);
        $this->db->group_by('attribute_value');
        $query = $this->db->get('category_attribute_value');
        if ($query->num_rows() > 0) {
            $attrs = $query->result_array();
            return $attrs;
        } else {
            return array();
        }
    }

    //menu controller
    function menuController() {
        return "hello";
    }

    function order_mail($order_id, $subject = "") {
        $order_details = $this->getOrderDetails($order_id, 0);

        if ($order_details) {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'noreplay2classapartstore@gmail.com',
                'smtp_pass' => 'vjdsxubpqhrhahrj',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('no_replay_classapartstore@gmail.com', 'Class Apart Store');
            $this->email->to($order_details['order_data']->email);
            $this->email->bcc('noreplay2classapartstore@gmail.com');

            if ($subject) {
                $this->email->subject($subject);
            } else {
                $this->email->subject('Class Apart Sore Order No:' . $order_details['order_data']->order_no . " has been confirmed.");
            }
            $this->email->message($this->load->view('Email/order_mail', $order_details, true));
            $this->email->print_debugger();
            echo $result = $this->email->send();
        }
    }

    function order_to_vendor($order_id) {
        $order_details = $this->getOrderDetails($order_id, 0);
        $cartdata = $order_details['cart_data'];
        $venderarray = array();
        foreach ($cartdata as $key => $value) {
            $query = "select au.id, au.email, au.first_name, au.last_name from products as c
                      left join admin_users as au on au.id = c.user_id
                      where c.id = '" . $value->product_id . "'";
            $query = $this->db->query($query);
            $vendor_details = $query->row();

            $vender_id = $vendor_details->id;
            if (isset($venderarray[$vender_id])) {
                $venderarray[$vender_id]['quantity'] += $value->quantity;
                $venderarray[$vender_id]['total_price'] += $value->total_price;
                array_push($venderarray[$vender_id]['cart_data'], $value);
            } else {
                $venderarray[$vender_id] = array(
                    'vendor' => $vendor_details,
                    'order_data' => $order_details['order_data'],
                    'cart_data' => array($value),
                    'total_price' => $value->total_price,
                    'quantity' => $value->quantity,
                );
            }
        }



        foreach ($venderarray as $key => $value) {
            if ($value) {
                $vendor_order = $value['order_data']->order_no . "/" . $value['vendor']->id;
                $vendor_order_dict = array(
                    'c_date' => date('Y-m-d'),
                    'c_time' => date('H:i:s'),
                    'order_id' => $value['order_data']->id,
                    'total_price' => $value['total_price'],
                    'total_quantity' => $value['quantity'],
                    'vendor_order_no' => $vendor_order,
                    'vendor_id' => $value['vendor']->id,
                    'vendor_email' => $value['vendor']->email,
                    'vendor_name' => $value['vendor']->first_name . " " . $value['vendor']->last_name,
                    'status' => "Order Generated",
                    'remark' => "Vendor Order Generated",
                );
                $value['vorder_no'] = $vendor_order;
                $this->db->insert('vendor_order', $vendor_order_dict);
                $last_id = $this->db->insert_id();

                //add vendor status
                $vendor_order_status_data = array(
                    'c_date' => date('Y-m-d'),
                    'c_time' => date('H:i:s'),
                    'vendor_order_id' => $last_id,
                    'order_id' => $value['order_data']->id,
                    'status' => "Payment Pending",
                    'vendor_id' => $value['vendor']->id,
                    'remark' => "Order Confirmed, Now Payment Pending From Client Side.",
                );
                $this->db->insert('vendor_order_status', $vendor_order_status_data);

//                $config = Array(
//                    'protocol' => 'smtp',
//                    'smtp_host' => 'ssl://smtp.googlemail.com',
//                    'smtp_port' => 465,
//                    'smtp_user' => 'noreplay2classapartstore@gmail.com',
//                    'smtp_pass' => 'vjdsxubpqhrhahrj',
//                    'mailtype' => 'html',
//                    'charset' => 'iso-8859-1'
//                );
//                $this->load->library('email', $config);
//                $this->email->set_newline("\r\n");
//                $this->email->from('no_replay_classapartstore@gmail.com', 'Class Apart Store');
//                $this->email->to($value['vendor']->email);
//                $this->email->bcc('noreplay2classapartstore@gmail.com');
//
//
//                $this->email->subject('Class Apart Sore Vendor Order No:' . $vendor_order . " Generated.");
//
//
//                echo $this->load->view('Email/vender_order_mail', $value, true);
//                $this->email->message($this->load->view('Email/vender_order_mail', $order_details, true));
//                $this->email->print_debugger();
//                try {
//                  //  echo $result = $this->email->send();
//                } catch (customException $e) {
//                    
//                }
            }
        }
    }

}

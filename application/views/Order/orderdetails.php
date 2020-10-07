<?php
$this->load->view('layout/header');
$paymentstatus = "";
?>


<style>
    .productStatusBlock{
        padding:10px;
        border: 1px solid #000;
        float: left;
        margin: 5px;
    }

    .payment_block{
        padding: 10px;
        padding-top: 30px;
        margin: 0px;
        margin-top: 30px;
        background: #ddd;
    border: 6px solid #ff3b3b;
    }
</style>

<div class="inner-page-banner-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcrumb-area">
                    <h1>Order Details</h1>
                    <ul>

                        <li>Order No. #<?php echo $order_data->order_no; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Content -->
<div id="content" ng-controller="OrderDetailsController"> 

    <!--======= PAGES INNER =========-->
    <section class="order-details-page-area">
        <div class="container">
            <div class="row  "> 
                <div class="pricing">
                    <div class="col-md-4">
                        <article class="order_box">
                            <li><i class="fa fa-user"></i> <?php echo $order_data->name; ?> </li>
                            <li><i class="fa fa-phone"></i> <?php echo $order_data->contact_no; ?></li> 
                            <li><i class="fa fa-envelope"></i> <?php echo $order_data->email; ?> </li>
                        </article>
                    </div>

                    <div class="col-md-4">
                        <article class="order_box">
                            <li><i class="fa fa-map"></i> Shipping Adddress </li>
                            <li>  <?php echo $order_data->address; ?><br/>
                                <?php echo $order_data->state; ?>  <?php echo $order_data->city; ?> <?php echo $order_data->pincode; ?></li>
                        </article>
                    </div>

                    <div class="col-md-4">
                        <article class="order_box">
                            <li> <i class=" fa fa-chevron-circle-right"></i> <?php echo $order_data->order_no; ?></li>
                            <li> <i class="fa fa-calendar"></i> <?php echo $order_data->order_date; ?> </li>
                            <li> <i class="fa fa-clock-o"></i>  <?php echo $order_data->order_time; ?> </li>
                            <li> 
                                <button class="btn btn-inverse btn-small" ng-click="sendOrderMail('<?php echo $order_data->order_no; ?>')">
                                    Request Order Copy On Mail
                                </button>
                            </li>
                        </article>
                    </div>

                    <div class="col-md-12">
                        <?php
//                        print_r($order_status);
                        foreach ($order_status as $key => $value) {
                            if ($value->status == 'Payment Pending') {
                                $paymentstatus = "yes";
                            } else {
                                $paymentstatus = "no";
                            }
                        }
                        if ($paymentstatus == 'yes') {
                            ?>
                            <div class="row payment_block " >
                                <form action="#" method="post" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="thumbnail">
                                                <img src="<?php
                                                echo imageservermain . 'barcodes/' . $paymentbarcode->file_name;
                                                ?>" alt="..." style="height:170px;">
                                                <div class="caption">
                                                    <h3 style="text-align: center"><?php echo $paymentbarcode->mobile_no; ?></h3>
                                                </div>
                                            </div>    
                                        </div>

                                        <div class="col-md-9">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="image1">Upload Payment Screen</label>
                                                    <input type="file" name="picture" />           
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group sliderbox-panel">
                                                    <label>Mobile No.</label>
                                                    <input type="text" class="form-control" name="mobile_no"  placeholder="" value="<?php echo ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group sliderbox-panel">
                                                    <label>Payment ID / Transaction ID</label>
                                                    <input type="text" class="form-control" name="payment_id"  placeholder="" value="<?php echo ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group sliderbox-panel">
                                                    <label>Payment Date</label>
                                                    <input type="text" class="form-control" name="payment_date"  placeholder="" value="<?php echo ''; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group sliderbox-panel">
                                                    <label>Description</label>
                                                    <textarea class="form-control" name="description"  placeholder=""><?php echo ''; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label></label>
                                                <button class="btn btn-success btn-lg" type="submit" name="submit" value="submit" style="margin-top: 32px;">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <?php
                        }
                        ?>
                    </div>

                    <div class="col-md-12" style=" margin-top: 10px;">
                        <article class="" style="padding: 10px;">
                            <table class="table table-bordered"  border-color= "#9E9E9E" align="center" border="1" cellpadding="0" cellspacing="0" width="600" style="background: #fff;padding:20px">
                                <tr style="font-weight: bold">
                                    <td style="width: 20px;text-align: center">S.No.</td>
                                    <td colspan="2"  style="text-align: center">Product</td>

                                    <td style="text-align: center;width: 100px"">Price<br/><span style="font-size: 10px">(In INR)</span></td>
                                    <td style="text-align: center;width: 60px"">Qnty.</td>
                                    <td style="text-align: center;width: 100px">Total<br/><span style="font-size: 10px">(In INR)</span></td>
                                </tr>
                                <!--cart details-->
                                <?php
                                foreach ($cart_data as $key => $product) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $key + 1; ?>
                                        </td>

                                        <td style="width: 80px">
                                    <center>   
                                        <img src=" <?php echo $product->file_name; ?>" style="height: 70px;"/>
                                    </center>
                                    </td>

                                    <td style="width: 200px;">
                                        <?php echo $product->title; ?>
                                        <br/>
                                        <small style="font-size: 12px;">(<?php echo $product->sku; ?>)</small>
                                    </td>

                                    <td style="text-align: right">
                                        <?php echo $product->price; ?>
                                    </td>

                                    <td style="text-align: right">
                                        <?php echo $product->quantity; ?>
                                    </td>

                                    <td style="text-align: right;">
                                        <?php echo $product->total_price; ?>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <?php
                                            $laststatus = "";
                                            $laststatus_cdate = "";
                                            $laststatus_ctime = "";
                                            $laststatusremark = ""; 
                                            foreach ($product->product_status as $key => $value) {
                                                $laststatus = $value->status;
                                                $laststatus_cdate = $value->c_date;
                                                $laststatus_ctime = $value->c_time;
                                                $laststatusremark = $value->remark;
                                            }
                                            ?>



                                            <button class="btn btn-button pull-right" type="button" data-toggle="collapse" data-target="#collapseProduct<?php echo $product->id; ?>" aria-expanded="false" aria-controls="collapseProduct<?php echo $product->id; ?>">
                                                Show More  <i class="fa fa-arrow-down"></i>
                                            </button>

                                            <div class="statusdiv">
                                               Current Status: <?php echo $laststatus; ?>
                                                <p style="font-size: 10px;    margin: 0;">
                                                    <i class="fa fa-calendar"></i> 
                                                    <?php echo $laststatus_cdate; ?>
                                                    <?php echo $laststatus_ctime; ?>
                                                </p>
                                                
                                                <p style="font-size: 12px;    margin: 0;">
                                                    <?php echo $laststatusremark; ?>
                                                </p>
                                            </div>






                                            <div class="collapse" id="collapseProduct<?php echo $product->id; ?>">
                                                <div class="">
                                                    <?php
                                                    foreach ($product->product_status as $key => $value) {
                                                        ?>
                                                        <div class="productStatusBlock">
                                                            <p style="font-size: 10px;margin: 0;"><i class="fa fa-calendar"></i> <?php echo $value->c_date ?> <?php echo $value->c_time ?></p>
                                                            <h3><?php echo $value->status; ?></h3>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>



                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <!--end of cart details-->

                                <tr>
                                    <td colspan="3"  rowspan="4" style="font-size: 12px">
                                        <b>Total Amount in Words:</b><br/>
                                        <span style="text-transform: capitalize"> <?php echo $order_data->amount_in_word; ?></span>
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right">Total</td>
                                    <td style="text-align: right;width: 60px"><?php echo $order_data->sub_total_price; ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right">Credit Used</td>
                                    <td style="text-align: right;width: 60px"><?php echo $order_data->credit_price; ?> </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right">Toal Amount</td>
                                    <td style="text-align: right;width: 60px"><?php echo $order_data->total_price; ?> </td>
                                </tr>




                            </table>
                        </article>
                    </div>

                </div>

            </div>
        </div>
    </section>





</div>


<script>

    ClassApartStore.controller('OrderDetailsController', function ($scope, $http, $timeout, $interval) {
        var url = baseurl + "Api/order_mail/" + <?php echo $order_data->id; ?> + "/" + '<?php echo $order_data->order_no; ?>';
        console.log(url);
        $scope.sendOrderMail = function (order_no) {
            swal({
                title: 'Sending Mail...',
                onOpen: function () {
                    swal.showLoading()
                }
            })
            $http.get(url).then(function (rdata) {
                swal({
                    title: 'Mail Sent!',
                    type: 'success', })
            }, function () {
                swal({
                    title: 'Unable To Send Mail!',
                    type: 'error', })
            })
        }

    })


</script>


<?php
$this->load->view('layout/footer');
?>
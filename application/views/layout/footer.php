<!-- Footer Area Start Here -->
<footer>
    <div class="footer-area">
        <div class="footer-area-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-box">
                            <h3>Information</h3>
                            <ul class="info-list">
                                <li><a href="#">About us</a></li>

                                <li><a href="#">Privacy policy</a></li>
                                <li><a href="#">Terms & condition</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-box">
                            <h3>My Account</h3>
                            <ul class="info-list">
                                <li><a href="<?php echo site_url("Account/login"); ?>">Login</a></li>
                                <li><a href="<?php echo site_url("Account/profile"); ?>">My Account</a></li>
                                <li><a href="<?php echo site_url("Account/orderList"); ?>">Order History</a></li>
                                <li><a href="<?php echo site_url("Cart/details"); ?>">View Cart</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-box">
                            <h3>Categories</h3>
                            <ul class="tag-list">

                                <li ng-repeat="catv in categoriesMenu">
                                    <a href="<?php echo site_url("Product/ProductList/"); ?>{{catv.id}}" >
                                        <i class="flaticon-left-arrow"></i>{{catv.category_name}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="footer-box">
                            <h3>Stay With Us!</h3>
                            <p>Connect with us via social media.</p>
                            <ul class="footer-social">
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-area-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <p>Class Apart Store. All Rights Reserved. </p>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Area End Here -->
<!-- Modal Dialog Box Start Here-->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-body">
            <button type="button" class="close myclose" data-dismiss="modal">&times;</button>
            <div class="product-details1-area">
                <div class="product-details-info-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="inner-product-details-left">
                                <div class="tab-content">
                                    <div id="metro-related1" class="tab-pane fade active in" ng-if="projectDetailsModel.productobj.file_name">
                                        <a href="#">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name}});width:275px;height: 275px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name}}" alt="single">-->
                                        </a>
                                    </div>
                                    <div id="metro-related2" class="tab-pane fade" ng-if="projectDetailsModel.productobj.file_name1">
                                        <a href="#">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name1}});width:275px;height: 275px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name1}}" alt="single">-->
                                        </a>
                                    </div>
                                    <div id="metro-related3" class="tab-pane fade" ng-if="projectDetailsModel.productobj.file_name2">
                                        <a href="#">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name2}});width:275px;height: 275px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name2}}" alt="single">-->
                                        </a>
                                    </div>
                                </div>
                                <ul>
                                    <li class="active" ng-if="projectDetailsModel.productobj.file_name">
                                        <a aria-expanded="false" data-toggle="tab" href="#metro-related1">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name}});width:75px;height: 75px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name}}" alt="related1">-->
                                        </a>
                                    </li>
                                    <li ng-if="projectDetailsModel.productobj.file_name1">
                                        <a aria-expanded="false" data-toggle="tab" href="#metro-related2">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name1}});width:75px;height: 75px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name1}}" alt="related2">-->
                                        </a>
                                    </li>
                                    <li ng-if="projectDetailsModel.productobj.file_name2">
                                        <a aria-expanded="false" data-toggle="tab" href="#metro-related3">
                                            <div class="product_image_back" style="background: url(<?php echo imageserver; ?>{{projectDetailsModel.productobj.file_name2}});width:75px;height: 75px"></div>
                                            <!--<img class="img-responsive" src="<?php echo imageserver; ?>/{{projectDetailsModel.productobj.file_name2}}" alt="related3">-->
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="inner-product-details-right">
                                <h3>{{projectDetailsModel.productobj.title}}</h3>
                                <ul>
                                    <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                    <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                    <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                    <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                    <li><i aria-hidden="true" class="fa fa-star"></i></li>
                                </ul>
                                <p class="price">{{projectDetailsModel.productobj.price|currency:"<?php echo globle_currency; ?> "}}</p>
                                <p>{{projectDetailsModel.productobj.short_description}}</p>
                                <div class="product-details-content">
                                    <p><span>SKU:</span> {{projectDetailsModel.productobj.sku}}</p>
                                    <p><span>Availability:</span> {{projectDetailsModel.productobj.stock_status}}</p>
                                    <!--<p><span>Category:</span>  {{projectDetailsModel.productobj.stock_status}}</p>-->
                                </div>
                                <!--                                <ul class="product-details-social">
                                                                    <li>Share: {{projectDetailsModel.quantity}}</li>
                                                                    <li><a href="#"><i aria-hidden="true" class="fa fa-facebook"></i></a></li>
                                                                    <li><a href="#"><i aria-hidden="true" class="fa fa-twitter"></i></a></li>
                                                                    <li><a href="#"><i aria-hidden="true" class="fa fa-linkedin"></i></a></li>
                                                                    <li><a href="#"><i aria-hidden="true" class="fa fa-pinterest"></i></a></li>
                                                                </ul>-->
                                <ul class="inner-product-details-cart">
                                    <li><a href="#" ng-click="addToCart(projectDetailsModel.productobj.product_id, projectDetailsModel.quantity)">Add To Cart</a></li>

  <!--<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="modal-footer">
                    <a href="#" class="btn-services-shop-now" data-dismiss="modal">Close</a>
                </div>-->
    </div>
</div>
</div>

<!-- Modal Dialog Box End Here-->
<!-- Preloader Start Here -->
<div id="preloader"></div>
<!-- Preloader End Here -->


<!-- jquery-->
<script src="<?php echo base_url(); ?>assets/theme2/js/vendor/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>




<!-- Bootstrap js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Owl Cauosel JS -->
<script src="<?php echo base_url(); ?>assets/theme2/js/owl.carousel.min.js" type="text/javascript"></script>
<!-- Nivo slider js -->
<script src="<?php echo base_url(); ?>assets/theme2/lib/custom-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/theme2/lib/custom-slider/home.js" type="text/javascript"></script>
<!-- Meanmenu Js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/jquery.meanmenu.min.js" type="text/javascript"></script>
<!-- WOW JS -->
<script src="<?php echo base_url(); ?>assets/theme2/js/wow.min.js" type="text/javascript"></script>
<!-- Plugins js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/plugins.js" type="text/javascript"></script>
<!-- Countdown js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/jquery.countdown.min.js" type="text/javascript"></script>
<!-- Srollup js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/jquery.scrollUp.min.js" type="text/javascript"></script>
<!-- Isotope js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/isotope.pkgd.min.js" type="text/javascript"></script>
<!-- Select2 Js -->
<script src="<?php echo base_url(); ?>assets/theme2/js/select2.min.js" type="text/javascript"></script>
<!-- Custom Js -->

<!--wnum-->
<script src="<?php echo base_url(); ?>assets/theme2/js/wNumb.js" type="text/javascript"></script>

<!--no slider-->
<script src="<?php echo base_url(); ?>assets/theme2/js/vendor/nouislider.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/theme2/js/main.js" type="text/javascript"></script>

<!-- type ahead-->
<script src="<?php echo base_url(); ?>assets/handlebars.js" type="text/javascript"></script>

<!-- type ahead-->
<script src="<?php echo base_url(); ?>assets/typeahead.bundle.js" type="text/javascript"></script>


<!--angular controllers-->
<script src="<?php echo base_url(); ?>assets/theme/angular/shopController.js"></script>




<script>
                                        $('nav#dropdown').meanmenu({siteLogo: "<a href='/' class='logo-mobile-menu'><img src='<?php echo base_url() . 'assets/images/logo73.png'; ?>' style='    height: 35px;' /></a>"});

                                        $(document).ready(function () {
                                            setTimeout(function () {
                                                // Page Preloader
                                                $('#preloader').fadeOut('slow', function () {
                                                    $(this).remove();
                                                });
                                            }, 1500)

                                        });
</script>


</body>

</html>
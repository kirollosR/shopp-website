<?php
@require_once 'C:\xampp\htdocs\estore\Controllers\AuthController.php';
@require_once 'C:\xampp\htdocs\estore\Controllers\ProductController.php';
@require_once 'C:\xampp\htdocs\estore\Models\product.php';

//check authentication and authorization
//if I am not an admin and trying to access the page, it will go to login page
$auth = new AuthController;
session_start();
if(!$auth->isAuthenticated(1)){
    header('Location: ../Auth/login.php');
}

$productController = new ProductController;
$products = $productController->getAllProducts();

$deleteMsg = false;

if(isset($_POST["delete"])){
    if(!empty($_POST["productId"])){
        if($productController->deleteProduct($_POST["productId"])){
            $deleteMsg = true;
            $products = $productController->getAllProducts();
        }
    }
}


?>

<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Products</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../../projTest/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../../projTest/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../../projTest/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../../projTest/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../../projTest/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../../projTest/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../../projTest/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../../projTest/assets/js/config.js"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <?php @include_once 'adminMenu.php'?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <?php @include_once '../Auth/navbar.php'?>
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products Store</span></h4>

                    <!-- Basic Bootstrap Table -->
                    <div class="card">
                        <h5 class="card-header">Products
                            <a href="add-product.php" class=" col-md-3 btn btn-primary float-end">
                                <span class="tf-icons bx bx-add-to-queue"></span> Add New Product
                            </a>
                        </h5>
                        <?php //TODO: if no available products
                            if(count($products) == 0){
                        ?>
                                <div class="alert alert-info" role="alert">No available Products</div>
                        <?php
                            }else{
                        ?>
                                <div class="table-responsive text-nowrap">
                                <table class="table">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                        <?php
                                foreach($products as $product){
                        ?>
                                            <tr>
                                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $product["name"];?></strong></td>
                                                <td><?php echo $product["price"];?></td>
                                                <td><?php echo $product["quantity"];?></td>
                                                <?php
                                                if($product["categoryId"] == 1){
                                                ?>
                                                    <td><span class="badge bg-label-success me-1"><?php echo $product["category"];?></span></td>
                                                <?php
                                                }else{
                                                ?>
                                                    <td><span class="badge bg-label-primary me-1"><?php echo $product["category"];?></span></td>
                                                <?php
                                                }

                                                ?>
<!--                                                <td><span class="badge bg-label-primary me-1">Active</span></td>-->
                                                <td>
                                                    <div class="dropdown">
                                                        <form action="index.php" method="post">
                                                            <input type="hidden" name="productId" value="<?php echo $product["id"]; ?>">
                                                            <button type="submit" name="delete" class="btn btn-outline-danger">
                                                                <span class="tf-icons bx bx-trash"></span>
                                                            </button>
                                                        </form>
<!--                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">-->
<!--                                                            <i class="bx bx-dots-vertical-rounded"></i>-->
<!--                                                        </button>-->
<!--                                                        <div class="dropdown-menu">-->
<!--                                                            <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                                            ><i class="bx bx-edit-alt me-1"></i> Edit</a-->
<!--                                                            >-->
<!--                                                            <a class="dropdown-item" href="javascript:void(0);"-->
<!--                                                            ><i class="bx bx-trash me-1"></i> Delete</a-->
<!--                                                            >-->
<!--                                                        </div>-->
                                                    </div>
                                                </td>
                                            </tr>
                        <?php
                                }
                        ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php
                            }
                        ?>

                    </div>
                    <!--/ Basic Bootstrap Table -->

                    <?php
                        if($deleteMsg){
                    ?>
                            <div data-delay="2000" class="bs-toast toast  fade toast-placement-ex top-0 start-50 translate-middle-x show bg-info" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <i class="bx bx-trash me-2"></i>
                                    <div class="me-auto fw-semibold">Deleted Succesfully</div>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
<!--                                <div class="toast-body">The "--><?php //echo $product["name"];?><!--" from --><?php //echo $product["category"];?><!-- category has been deleted successfully</div>-->
                            </div>
                    <?php
                        }
                    ?>


                    <hr class="my-5" />



                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                                <a
                                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                                    target="_blank"
                                    class="footer-link me-4"
                                >Documentation</a
                                >

                                <a
                                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                                    target="_blank"
                                    class="footer-link me-4"
                                >Support</a
                                >
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../../projTest/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../../projTest/assets/vendor/libs/popper/popper.js"></script>
    <script src="../../../projTest/assets/vendor/js/bootstrap.js"></script>
    <script src="../../../projTest/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../../projTest/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../../../projTest/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</div>
</body>
</html>

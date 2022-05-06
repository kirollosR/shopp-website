<?php
@require_once 'C:\xampp\htdocs\estore\Controllers\AuthController.php';
@require_once 'C:\xampp\htdocs\estore\Controllers\ProductController.php';
@require_once 'C:\xampp\htdocs\estore\Models\product.php';

//AUTHENTICATION CHECK
$auth = new AuthController;

session_start();
if(!$auth->isAuthenticated(1)){
    header('Location: ../Auth/login.php');
}

//GET ALL CATEGORIES IN ARRAY
$productController = new ProductController;
$categories = $productController->getCategories();

$errorMsg = "";

if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_FILES["image"])) {
    if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {
        $product = new product();

        $product->name = $_POST['name'];
        $product->description = $_POST['description'];
        $product->price = $_POST['price'];
        $product->quantity = $_POST['quantity'];
        $product->categoryId = $_POST['category'];

        //IMAGE
        $location = "../images/" . date("h-i-s") . $_FILES["image"]["name"]; //image path

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $location)) {
            $product->image = $location;

            if ($productController->addProduct($product)) {
                header("Location: index.php");
            } else {
                $errorMsg = "Something went wrong.. Please try again";
            }
        } else {
            $errorMsg = "Error in upload";
        }
    }else{
        $errorMsg = "Please fill all fields";
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

    <title>Add Product</title>

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

        <?php @include_once 'adminMenu.php' ?>
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
                    <h4 class="fw-bold py-3 mb-4">Add New Product</h4>

                    <!-- Basic Layout & Basic with Icons -->
                    <div class="row">

                        <!-- Basic with Icons -->
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Product Details</h5>
                                    <?php
                                    if($errorMsg != ""){
                                        ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <?php echo $errorMsg; ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="card-body">
                                    <form action="add-product.php" method="post" enctype='multipart/form-data'>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="basic-icon-default-fullname">Product Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bx-purchase-tag'></i></span>
                                                    <input type="text" class="form-control" id="basic-icon-default-fullname" name="name" placeholder="Like : Pepsi" aria-describedby="basic-icon-default-fullname2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="basic-icon-default-company">Product Description</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-message"></i></span>
                                                    <textarea id="basic-icon-default-message" class="form-control" placeholder="What about this product?" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label" for="basic-icon-default-email">Price</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                                                    <input type="text" id="basic-icon-default-email" class="form-control" name="price" placeholder="$5" aria-describedby="basic-icon-default-email2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 form-label" for="basic-icon-default-phone">Available Quantity</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-store-alt"></i></span>
                                                    <input type="text" id="basic-icon-default-phone" class="form-control phone-mask" name="quantity" placeholder="available in store" aria-describedby="basic-icon-default-phone2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 form-label" for="basic-icon-default-phone">Category</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">
                                                    <select id="largeSelect" class="form-select form-select-lg" name="category">

                                                            <?php
                                                            foreach ($categories as $category){
                                                            ?>
                                                                <option value="<?php echo $category["id"] ?>"><?php echo $category["name"] ?></option>
                                                            <?php
                                                            }
                                                            ?>




                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-3 form-label" for="basic-icon-default-message">Image</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-merge">

                                                    <input class="form-control" type="file" id="formFile" name="image" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                                <a href="index.php" class="btn btn-warning">back</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Content -->

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
</body>
</html>

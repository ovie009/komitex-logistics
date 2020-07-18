<?php
    session_start();
    include_once "includes/class-autoloader.inc.php";

    $fullname = $_SESSION['komitexLogisticsFullname'];
    $username = $_SESSION['komitexLogisticsUsername'];
    $email = $_SESSION['komitexLogisticsEmail'];
    $phone = $_SESSION['komitexLogisticsPhone'];
    $accountType = $_SESSION['komitexLogisticsAccountType'];
    $profilePhoto = $_SESSION['komitexLogisticsProfilePhoto'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="rgb(7, 66, 124)">
    <title>Komitex Logistics</title>
    <link rel="stylesheet" href="CSS/main.css">
    <link rel="stylesheet" href="CSS/waybill.css">
    <link rel="manifest" href="/manifest.json">
    <link rel="shortcut icon" type="image/png" href="icons/logistics/018-motorcycle.png">
    <script src="jquery/jquery-3.4.1.min.js"></script>
</head>
<body onload="checkUrl()">
    <?php
        require "header.php";
    ?>
    <div class="popup-background"></div>
    <main class="waybill-main">
        <section class="waybill-page-info">
            <?php
                if (isset($_SESSION['komitexLogisticsEmail'])) { 

                    if ($_SESSION['komitexLogisticsAccountType'] == NULL) {?>
                    
                        <form action="includes/accounttype.inc.php" class="select-accountType" method="POST">
                            <h2>Select account type</h2>
                            <input type="hidden" name="email" value="<?php echo $_SESSION['komitexLogisticsEmail'] ?>">
                            <div class="radio-wrapper">
                                <label for="select-affiliate">Affiliate</label>
                                <input type="radio" name="accountType" value="Affiliate" id="select-affiliate">
                            </div>
                            <div class="radio-wrapper">
                                <label for="select-agent">Agent</label>
                                <input type="radio" name="accountType" value="Agent" id="select-agent">
                            </div>
                            <div class="radio-wrapper">
                                <label for="select-logistics">Logistics</label>
                                <input type="radio" name="accountType" value="Logistics" id="select-logistics">
                            </div>
                            <div class="radio-wrapper">
                                <label for="select-merchant">Merchant</label>
                                <input type="radio" name="accountType" value="Merchant" id="select-merchant">
                            </div>
                            <div class="radio-wrapper">
                                <p>Note: once submitted, it cannot be edited</p>
                                <button type="submit" name="submitAccountType">OK</button>
                            </div>
                        </form>
                        <?php
                    }else{
                        $productObj = new View();
                        ?>
                        <!--<h1 id="page-heading">WAYBILL/PRODUCTS</h1>-->
                        <?php
                            $errors = $productObj->viewProducts($username);
                            if (!empty($errors)) {
                                foreach ($errors as $error) {
                                    # code...
                                    $productName = $error['ProductName'];
                                    $price = floatval($error['Price']);
                                    $price1 = floatval($error['FirstDiscountPrice']);
                                    $quantity1 = floatval($error['FirstDiscountQty']);
                                    $price2 = floatval($error['SecondDiscountPrice']);
                                    $quantity2 = floatval($error['SecondDiscountQty']);
                                    $price3 = floatval($error['ThirdDiscountPrice']);
                                    $quantity3 = floatval($error['ThirdDiscountQty']);

                                    if ($price1 == $price || $price2 == $price || $price3 == $price) {
                                        # code...
                                        ?><span class="error">Error: Discount Price for "<?php echo $productName; ?>" can't be equal to actual price!</span><?php
                                    }

                                    if (($price1 == $price2 && $price1 != NULL) || ($price1 == $price3 && $price1 != NULL) || ($price2 == $price3 && $price2 != NULL)) {
                                        # code...
                                        ?><span class="error">Error: "<?php echo $productName; ?>" can't have discount prices of same value!</span><?php
                                    }

                                    if ($quantity1 == 1 || $quantity2  == 1|| $quantity3 == 1) {
                                        # code...
                                        ?><span class="error">Error: Discount quantity for "<?php echo $productName; ?>" can't be equal to 1!</span><?php
                                    }

                                    if (($quantity1 == $quantity2 && $quantity1 != NULL) || ($quantity1 == $quantity3 && $quantity1 != NULL) || ($quantity2 == $quantity3 && $quantity2 != NULL)) {
                                        # code...
                                        ?><span class="error">Error: "<?php echo $productName; ?>" can't have discount quantity of same value!</span><?php
                                    }

                                    if (($quantity1 > $price1) || ($quantity2 > $price2) || ($quantity3 > $price3)) {
                                        # code...
                                        ?><span class="error">Error: "<?php echo $productName; ?>" is having discount quantity greater than discount price!</span><?php
                                    }
                                }
                            }
                        ?>
                        <div class="tab-container">
                            <div id="products-tab" onclick="switchTabs('products')">Products</div>
                            <div id="waybill-tab" onclick="switchTabs('waybill')">Waybill</div>
                        </div>
                        <div class="products-div">
                            <form class="add-new-form">
                                <button type="button" id="add-new-product">Add New Product</button>
                            </form>
                            <div>
                                <div class="display-wrapper">
                                    <div class="display-image" style="background-image: url(icons/others/bag1.png);">

                                    </div>
                                    <button type="button"  onclick="selectPhoto()">Select Picture</button>
                                    <!--<input type="image" src="icons/others/pencil.png" alt="edit icon" onclick="selectPhoto()">-->
                                </div>
                                <form class="upload-product" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>" enctype="multipart/form-data">

                                    <input type="hidden" name="username" value="<?php echo $username;?>">
                                    <input style="display:none" type="file" name="photo" id="selectPhoto" onchange="readURL(this)" accept="image/*">
                                    <div class="main-product-wrapper">
                                        <textarea name="productName" id="product-name" cols="60" rows="3" placeholder="Product Name" class="product-input" required></textarea>
                                        <input type="number" name="productPrice" id="product-price" placeholder="Price" class="product-input" min="0"  required>
                                    </div>
                                    <div class="button-wrapper">
                                        <button  id="more-prices" type="button">Add Discount</button>
                                        <button type="submit" id="submit-product" name="submitProduct">Submit</button>
                                    </div>
                                
                                </form>
                            </div>
                        
                            <?php
                                $products = $productObj->viewProducts($username);
                                //print_r($products[0]);
                                if (!empty($products)) {?>
                                    
                                    <div class="products-container">
                                        <?php
                                        $x = 1;
                                        foreach ($products as $product) {
                                            # code...
                                            $productName = $product['ProductName'];
                                            $price = $product['Price'];
                                            $price1 = $product['FirstDiscountPrice'];
                                            $quantity1 = $product['FirstDiscountQty'];
                                            $price2 = $product['SecondDiscountPrice'];
                                            $quantity2 = $product['SecondDiscountQty'];
                                            $price3 = $product['ThirdDiscountPrice'];
                                            $quantity3 = $product['ThirdDiscountQty'];
                                            $picture = $product['Picture'];
                                            $stock = $product['Stock'];
                                            ?>

                                            <div class="product-holder">
                                                <button type="button" id="send-waybill">Send <br> Waybill</button>
                                                <div class="product-main-details">
                                                    <div class="product-image" style="background-image: url(<?php echo $picture; ?>);" ondblclick="changePicture(<?php echo $x; ?>)" id="product-image-<?php echo $x; ?>">

                                                        <form class="product-image-overlay-<?php echo $x; ?>"  method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>" enctype="multipart/form-data">
                                                            <input type="hidden" name="username" value="<?php echo $username; ?>" required>
                                                            <input type="hidden" name="productName" value="<?php echo $productName; ?>" required>
                                                            <input style="display:none" type="file" name="productPhoto" id="selectPhoto-<?php echo $x; ?>" onchange="readUrl(this)" accept="image/*">
                                                            <button type="submit" name="changeProductPicture">Save</button>
                                                        </form>

                                                    </div>
                                                    <div class="product-details">
                                                        <p onclick="editPrice(<?php echo $x; ?>)"><?php echo $productName; ?><img src="icons/others/down-arrow(1).png" id="down-arrow-<?php echo $x; ?>"></p>
                                                        <p id="show-price-<?php echo $x; ?>"><s>N</s><?php echo $price; ?></p>
                                                        <div id="edit-price-<?php echo $x; ?>">
                                                            <form  method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                <input type="hidden" name="username" value="<?php echo $username; ?>" required>
                                                                <input type="hidden" name="productName" value="<?php echo $productName; ?>" required>
                                                                <input type="number" name="productPrice" placeholder="price" value="<?php echo $price; ?>" required>
                                                                <button type="submit" name="editPrice">OK</button>
                                                            </form>
                                                        </div>
                                                        <button type="button" id="show-discount" onclick="showDiscount(<?php echo $x; ?>)" class="show-discount-<?php echo $x; ?>">Show Discounts<img src="icons/others/down-arrow(1).png" alt="komitex products"></button>
                                                    </div>
                                                </div>
                                                <div class="dropdown-product" id="dropdown-<?php echo $x; ?>">
                                                    <?php
                                                        if (!empty($price1) && empty($price2) && empty($price3)) {
                                                            # code...?>
                                                            <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                <input type="hidden" name="username" value="<?php echo $username; ?>" required>
                                                                <input type="hidden" name="productName" value="<?php echo $productName; ?>" required>
                                                                <label for="prc1">Price</label>
                                                                <input type="number" name="price1" placeholder="Price" value="<?php echo $price1; ?>" class="prc" id="prc<?php echo $x; ?>-1" readonly required>
                                                                <label for="qty1">Qty</label>
                                                                <input type="number" name="quantity1" placeholder="Qty" value="<?php echo $quantity1; ?>" class="prc" id="qty<?php echo $x; ?>-1" min="2" readonly required>
                                                                <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 1)" class="edit-<?php echo $x; ?>-1">Edit</button>
                                                                <button type="submit" id="submit-discount-<?php echo $x; ?>-1" name="submitDiscount1">Submit</button>
                                                                <button type="submit" id="delete-discount" name="deleteDiscount1">Delete</button>
                                                            </form>
                                                            <div id="hiding-second-discount-<?php echo $x; ?>">
                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>" required>
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>" required>
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price2" class="hide-prc" id="prc" required>
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity2" class="hide-prc" id="qty" min="3" required>
                                                                    <button type="submit" id="hidden-submit" name="submitDiscount2">Submit</button>
                                                                    <button type="button" id="delete-discount" name="cancelDiscount"  onclick="cancelSecondDiscount(<?php echo $x; ?>)">Cancel</button>
                                                                </form>
                                                            </div>
                                                            <form class="discount-list" id="add-second-discount-<?php echo $x; ?>">
                                                                <button type="button" id="addmore-discount" onclick="addSecondDiscount(<?php echo $x; ?>)">Add More Discounts</button>
                                                            </form>        
                                                            <?php
                                                        } elseif (!empty($price1) && !empty($price2) && empty($price3)) {
                                                            # code...?>
                                                            <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                <input type="hidden" name="productName" value="<?php echo $productName; ?>"><label for="prc1">Price</label>
                                                                <input type="number" name="price1" placeholder="Price" value="<?php echo $price1; ?>" class="prc" id="prc<?php echo $x; ?>-1" readonly>
                                                                <label for="qty1">Qty</label>
                                                                <input type="number" name="quantity1" placeholder="Qty" value="<?php echo $quantity1; ?>" class="prc" id="qty<?php echo $x; ?>-1" min="2" readonly>
                                                                <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 1)" class="edit-<?php echo $x; ?>-1">Edit</button>
                                                                <button type="submit" id="submit-discount-<?php echo $x; ?>-1" name="submitDiscount1">Submit</button>
                                                            </form>
                                                            <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                <input type="hidden" name="productName" value="<?php echo $productName; ?>">                                                            <label for="prc1">Price</label>
                                                                <input type="number" name="price2" placeholder="Price" value="<?php echo $price2; ?>" class="prc" id="prc<?php echo $x; ?>-2" readonly>
                                                                <label for="qty1">Qty</label>
                                                                <input type="number" name="quantity2" placeholder="Qty" value="<?php echo $quantity2; ?>" class="prc" id="qty<?php echo $x; ?>-2" min="3" readonly>
                                                                <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 2)" class="edit-<?php echo $x; ?>-2">Edit</button>
                                                                <button type="submit" id="submit-discount-<?php echo $x; ?>-2" name="submitDiscount2">Submit</button>
                                                                <button type="submit" id="delete-discount" name="deleteDiscount2">Delete</button>
                                                            </form>
                                                            <div id="hiding-third-discount-<?php echo $x; ?>">
                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price3" class="hide-prc" id="prc">
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity3" class="hide-prc" id="qty" min="4">
                                                                    <button type="submit" id="hidden-submit" name="submitDiscount3">Submit</button>
                                                                    <button type="button" id="delete-discount" name="cancelDiscount"  onclick="cancelThirdDiscount(<?php echo $x; ?>)">Cancel</button>
                                                                </form>
                                                            </div>
                                                            <form class="discount-list" id="add-third-discount-<?php echo $x; ?>">
                                                                <button type="button" id="addmore-discount" onclick="addThirdDiscount(<?php echo $x; ?>)">Add More Discounts</button>
                                                            </form>        
                                                            <?php
                                                        } elseif (!empty($price1) && !empty($price2) && !empty($price3)) {
                                                            # code...?>
                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price1" placeholder="Price" value="<?php echo $price1; ?>" class="prc" id="prc<?php echo $x; ?>-1" readonly>
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity1" placeholder="Qty" value="<?php echo $quantity1; ?>" class="prc" id="qty<?php echo $x; ?>-1" min="2" readonly>
                                                                    <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 1)" class="edit-<?php echo $x; ?>-1">Edit</button>
                                                                    <button type="submit" id="submit-discount-<?php echo $x; ?>-1" name="submitDiscount1">Submit</button>
                                                                </form>
                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price2" placeholder="Price" value="<?php echo $price2; ?>" class="prc" id="prc<?php echo $x; ?>-2" readonly>
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity2" placeholder="Qty" value="<?php echo $quantity2; ?>" class="prc" id="qty<?php echo $x; ?>-2" min="3" readonly>
                                                                    <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 2)" class="edit-<?php echo $x; ?>-2">Edit</button>
                                                                    <button type="submit" id="submit-discount-<?php echo $x; ?>-2" name="submitDiscount2">Submit</button>
                                                                </form>      
                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price3" placeholder="Price" value="<?php echo $price3; ?>" class="prc" id="prc<?php echo $x; ?>-3" readonly>
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity3" placeholder="Qty" value="<?php echo $quantity3; ?>" class="prc" id="qty<?php echo $x; ?>-3" min="4" readonly>
                                                                    <button type="button" id="edit-discount" onclick="editDiscount(<?php echo $x; ?>, 3)" class="edit-<?php echo $x; ?>-3">Edit</button>
                                                                    <button type="submit" id="submit-discount-<?php echo $x; ?>-3" name="submitDiscount3">Submit</button>
                                                                    <button type="submit" id="delete-discount" name="deleteDiscount3">Delete</button>
                                                                </form>      
                                                            <?php
                                                        } elseif (empty($price1) && empty($price2) && empty($price3)) {
                                                            # code...?>
                                                            <div id="hiding-first-discount-<?php echo $x; ?>">

                                                                <form class="discount-list" method="POST" action="<?php echo htmlspecialchars('includes/products.inc.php');?>">
                                                                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                                                                    <input type="hidden" name="productName" value="<?php echo $productName; ?>">
                                                                    <label for="prc1">Price</label>
                                                                    <input type="number" name="price1" class="hide-prc" id="prc" required>
                                                                    <label for="qty1">Qty</label>
                                                                    <input type="number" name="quantity1" class="hide-prc" id="qty" min="2" required>
                                                                    <button type="submit" id="hidden-submit" name="submitDiscount1">Submit</button>
                                                                    <button type="button" id="delete-discount" name="cancelDiscount"  onclick="cancelFirstDiscount(<?php echo $x; ?>)">Cancel</button>
                                                                </form>

                                                            </div>

                                                            <form class="discount-list" id="add-first-discount-<?php echo $x; ?>">
                                                                <button type="button" id="addmore-discount" onclick="addFirstDiscount(<?php echo $x; ?>)">Add Discount</button>
                                                                <p class="no-discount-notice">N/A</p>
                                                            </form>        
                                                            <?php
                                                        }
                                                    ?>
                                                    <button type="button" id="hide-discount" onclick="hideDiscount(<?php echo $x; ?>)">Hide Discounts<img src="icons/others/down-arrow(1).png" alt="down arrow"></button>
                                                </div>
                                            </div>
                                            
                                            <?php
                                            $x++;
                                        }?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="waybill-div">

                        </div>
                        <?php
                    }
                }else {
                    header("location: index.php");
                }
            ?>
        </section>
    </main>
    <?php
        require "footer.php";
    ?>
    <script src="javascript/main.js"></script>
    <script src="javascript/waybill.js"></script>
</body>
</html>
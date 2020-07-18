<?php

    abstract class Model extends Dbh
    {
        protected function checkSignupEmail(string $email)
        {
            # code...
            $sql = "SELECT * FROM login WHERE komitexLogisticsEmail=?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$email]);

            $results = $stmt->fetchAll();
            $stmt = null;
            return $results;
        }
        
        protected function checkSignupUsername(string $username)
        {
            # code...
            $sql = "SELECT komitexLogisticsUsername FROM login WHERE komitexLogisticsUsername=?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username]);

            $results = $stmt->fetchAll();
            $stmt = null;
            return $results;
        }
        
        protected function insertSignup(string $fullname, string $username, string $email, string $phone, string $password)
        {
            # code...
            $sql = "INSERT INTO login(komitexLogisticsFullname, komitexLogisticsUsername, komitexLogisticsEmail, komitexLogisticsPhone, komitexLogisticsPassword) VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$fullname, $username, $email, $phone, $password]);
            
            $_SESSION['komitexLogisticsFullname'] = $fullname;
            $_SESSION['komitexLogisticsUsername'] = $username;
            $_SESSION['komitexLogisticsEmail'] = $email;
            $_SESSION['komitexLogisticsPhone'] = $phone;
            $_SESSION['komitexLogisticsAccountType'] = NULL;
            $_SESSION['komitexLogisticsProfilePhoto'] = 'icons/others/user.png';

            $stmt = null;
            echo 'success';
        }

        protected function checkLoginDetails(string $user)
        {
            # code...
            $sql = "SELECT * FROM login WHERE komitexLogisticsEmail=? OR komitexLogisticsUsername=?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$user, $user]);

            $results = $stmt->fetchAll();
            $stmt = null;
            return $results;
        }

        protected function saveLoginDetails(string $user, array $results, string $password)
        {
            
            if (empty($results)) {
                # code...
                header("location: ../index.php?nullEmail");

            } else {
                # code...
                //$passwordCheck = password_verify($password, $results[0]['komitexLogisticsPassword']);
    
                //if ($passwordCheck === false) {
                if ($password != $results[0]['komitexLogisticsPassword']) {
                    # code...
                    header("location: ../index.php?wrongPassword&user=".$user."");
                    
                } else {
                    
                    $_SESSION['komitexLogisticsFullname'] = $results[0]['komitexLogisticsFullname'];
                    $_SESSION['komitexLogisticsUsername'] = $results[0]['komitexLogisticsUsername'];
                    $_SESSION['komitexLogisticsEmail'] = $results[0]['komitexLogisticsEmail'];
                    $_SESSION['komitexLogisticsPhone'] = $results[0]['komitexLogisticsPhone'];
                    $_SESSION['komitexLogisticsAccountType'] = $results[0]['komitexLogisticsAccountType'];
                    $_SESSION['komitexLogisticsAccountType'] = $results[0]['komitexLogisticsAccountType'];
                    $_SESSION['komitexLogisticsProfilePhoto'] = $results[0]['komitexLogisticsProfilePhoto'];
                    header("location: ../index.php");
                    # code...
                }

            }
            
            
        }

        protected function updateAccountType(string $account, string $email)
        {
            # code...
            $sql = "UPDATE `login` SET `komitexLogisticsAccountType` = '$account' WHERE `login`.`komitexLogisticsEmail` = '$email';";
            try {
                //code...
                $this->connect()->query($sql);
                $_SESSION['komitexLogisticsAccountType'] = $account;
                header("location: ../accountinfo.php?Success");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
            }
        
        }

        protected function updateProfilePhoto(string $email, string $profilePhoto)
        {
            # code...
            $sql = "UPDATE `login` SET `komitexLogisticsProfilePhoto` = '$profilePhoto' WHERE `login`.`komitexLogisticsEmail` = '$email';";
            try {
                //code...
                $this->connect()->query($sql);
                $_SESSION['komitexLogisticsProfilePhoto'] = $profilePhoto;
                if ($profilePhoto != 'icons/others/user.png') {
                    # code...
                    header("location: ../accountinfo.php?uploadSuccess");
                }else{
                    header("location: ../accountinfo.php?deleteSuccess");
                }
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage();
                header("location: ../accountinfo.php?databaseError");
            }
        }

        protected function insertContacts(string $username01, string $username02, string $accountType01, string $accountType02)
        {
            # code...
            $sql = "INSERT INTO contacts($accountType01, $accountType02) VALUES (?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username01, $username02]);
            $stmt = null;
        }

        protected function approveContacts(string $username01, string $username02, string $accountType01, string $accountType02)
        {
            # code...
            $sql = "UPDATE `contacts` SET `Status` = 'Approved' WHERE `contacts`.`$accountType01` = '$username01' AND `contacts`.`$accountType02` = '$username02' ;";
            try {
                //code...
                $this->connect()->query($sql);
                header("location: ../accountinfo.php?added".$accountType02);     
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../accountinfo.php?databaseError");
            }
        
        }

        protected function checkMyContacts(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $sql = "SELECT * FROM `contacts` WHERE `contacts`.`$accountType01` = '$username01' AND `contacts`.`$accountType02` = '$username02';";
            //$sql = "SELECT * FROM `contacts` WHERE `contacts`.`?` = '?' AND `contacts`.`?` = '?';";
            $stmt = $this->connect()->query($sql);
            //$stmt = $this->connect()->prepare($sql);
            //$stmt->execute([$accountType01, $username01, $accountType02, $username02]);

            $results = $stmt->fetchAll();
            $stmt = null;
            return $results;
        }

        protected function getContacts(string $username, string $accountType)
        {
            # code...
            $sql = "SELECT * FROM contacts WHERE $accountType = '$username' ORDER BY id DESC;";
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll();
            $stmt = null;

            return $results;
        }

        protected function deleteContacts(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $sql = "DELETE FROM `contacts` WHERE `contacts`.`$accountType01` = '$username01' AND `contacts`.`$accountType02` = '$username02';";
            try {
                //code...
                $this->connect()->query($sql);
                if ($accountType02 == 'Agent') {
                    # code...
                    header("location: ../accountinfo.php?removeAgent");     
                }
                if ($accountType02 == 'Affiliate') {
                    # code...
                    header("location: ../accountinfo.php?removeAffiliate");     
                }
                return true;
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../accountinfo.php?databaseError");
            }
        }
        
        protected function declineContacts(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $sql = "UPDATE `contacts` SET `Status` = 'Declined' WHERE `contacts`.`$accountType01` = '$username01' AND `contacts`.`$accountType02` = '$username02' ;";
            try {
                //code...
                $this->connect()->query($sql);
                header("location: ../accountinfo.php?decline".$accountType02);     
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../accountinfo.php?databaseError");
            }
        
        }

        protected function notApprovedContacts(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $sql = "UPDATE `contacts` SET `Status` = 'Not Approved' WHERE `contacts`.`$accountType01` = '$username01' AND `contacts`.`$accountType02` = '$username02' ;";
            try {
                //code...
                $this->connect()->query($sql);
                header("location: ../accountinfo.php?decline".$accountType02);     
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../accountinfo.php?databaseError");
            }
        
        }

        protected function newLocation(string $username, string $location, string $price)
        {
            # code...
            $sql = "INSERT INTO `locations`(`username`, `location`, `price`) VALUES (?, ?, ?);";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $location, $price]);
            $stmt = null;       
            header("location: ../accountinfo.php?locationAdded");
        }

        protected function checkLocation(string $username, string $location)
        {
            # code...
            $sql = "SELECT * FROM locations WHERE username = '$username' AND location = '$location';";
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll();

            return $results;
        }

        protected function selectLocation(string $username)
        {
            # code...
            $sql = "SELECT * FROM locations WHERE username = '$username';";
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll();

            return $results;
        }

        protected function updateLocation(string $username, string $location, string $price)
        {
            # code...
            $sql = "UPDATE `locations` SET `price` = '$price' WHERE `locations`.`username` = '$username' AND `locations`.`location` = '$location';";
            try {
                //code...
                $this->connect()->query($sql);
                header("location: ../accountinfo.php?locationEdited");     
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../accountinfo.php?databaseError");
            }
        
        }

        protected function insertNoDiscountProduct(string $username, string $productName, string $productPrice, string $productPhoto, string $photoTmpName)
        {
            # code...
            $sql = "INSERT INTO `products`(`Merchant`, `ProductName`, `Price`, `Picture`) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $productName, $productPrice, $productPhoto]);

            if ($productPhoto != 'icons/others/bag1.png') {
                # code...
                $photoDestination = '../'.$productPhoto;

                if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                    # code...
                    header("location: ../waybill.php?moveFileError");
                } else {
                    # code...
                    header("location: ../waybill.php?productSuccess");
                }
            } else {
                header("location: ../waybill.php?productSuccess");
            }
            
            $stmt = null;
            
        }

        protected function insertOneDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $productPhoto, string $photoTmpName)
        {
            # code...
            $sql = "INSERT INTO `products`(`Merchant`, `ProductName`, `Price`, `FirstDiscountPrice`, `FirstDiscountQty`, `Picture`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $productName, $productPrice, $price1, $quantity1, $productPhoto]);
            
            if ($productPhoto != 'icons/others/bag1.png') {
                # code...
                $photoDestination = '../'.$productPhoto;

                if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                    # code...
                    header("location: ../waybill.php?moveFileError");
                } else {
                    # code...
                    header("location: ../waybill.php?productSuccess");
                }
            } else {
                header("location: ../waybill.php?productSuccess");
            }

            $stmt = null;
            
        }

        protected function insertTwoDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $price2, string $quantity2, string $productPhoto, string $photoTmpName)
        {
            # code...
            $sql = "INSERT INTO `products`(`Merchant`, `ProductName`, `Price`, `FirstDiscountPrice`, `FirstDiscountQty`, `SecondDiscountPrice`, `SecondDiscountQty`, `Picture`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $productName, $productPrice, $price1, $quantity1, $price2, $quantity2, $productPhoto]);
            
            if ($productPhoto != 'icons/others/bag1.png') {
                # code...
                $photoDestination = '../'.$productPhoto;

                if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                    # code...
                    header("location: ../waybill.php?moveFileError");
                } else {
                    # code...
                    header("location: ../waybill.php?productSuccess");
                }
            } else {
                header("location: ../waybill.php?productSuccess");
            }

            $stmt = null;
            
        }

        protected function insertThreeDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $price2, string $quantity2, string $price3, string $quantity3, string $productPhoto, string $photoTmpName)
        {
            # code...
            $sql = "INSERT INTO `products`(`Merchant`, `ProductName`, `Price`, `FirstDiscountPrice`, `FirstDiscountQty`, `SecondDiscountPrice`, `SecondDiscountQty`, `ThirdDiscountPrice`, `ThirdDiscountQty`, `Picture`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $productName, $productPrice, $price1, $quantity1, $price2, $quantity2, $price3, $quantity3, $productPhoto]);
            
            if ($productPhoto != 'icons/others/bag1.png') {
                # code...
                $photoDestination = '../'.$productPhoto;

                if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                    # code...
                    header("location: ../waybill.php?moveFileError");
                } else {
                    # code...
                    header("location: ../waybill.php?productSuccess");
                }
            } else {
                header("location: ../waybill.php?productSuccess");
            }
            
            $stmt = null;
            
        }

        protected function updateProductPrice(string $username, string $productName, string $price)
        {
            # code...
            $sql = "UPDATE `products` SET `Price`= ?, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$price, $username, $productName]);
                header("location: ../waybill.php?priceEdited");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateOneDiscount(string $username, string $productName, string $price1, string $quantity1)
        {
            # code...
            //"UPDATE `products` SET `id`=[value-1],`Merchant`=[value-2],`Affiliate`=[value-3],`ProductName`=[value-4],`Price`=[value-5],`FirstDiscountPrice`=[value-6],`FirstDiscountQty`=[value-7],`SecondDiscountPrice`=[value-8],`SecondDiscountQty`=[value-9],`ThirdDiscountPrice`=[value-10],`ThirdDiscountQty`=[value-11],`Picture`=[value-12],`Stock`=[value-13] WHERE 1"
            $sql = "UPDATE `products` SET `FirstDiscountPrice`= ?,`FirstDiscountQty`= ?, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$price1, $quantity1, $username, $productName]);
                header("location: ../waybill.php?discountAdded");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateSecondDiscount(string $username, string $productName, string $price2, string $quantity2)
        {
            # code...
            $sql = "UPDATE `products` SET `SecondDiscountPrice`= ?,`SecondDiscountQty`= ?, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$price2, $quantity2, $username, $productName]);
                header("location: ../waybill.php?discountAdded");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateThirdDiscount(string $username, string $productName, string $price3, string $quantity3)
        {
            # code...
            $sql = "UPDATE `products` SET `ThirdDiscountPrice`= ?,`ThirdDiscountQty`= ?, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$price3, $quantity3, $username, $productName]);
                header("location: ../waybill.php?discountAdded");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateOneDiscountNull(string $username, string $productName)
        {
            # code...
            //"UPDATE `products` SET `id`=[value-1],`Merchant`=[value-2],`Affiliate`=[value-3],`ProductName`=[value-4],`Price`=[value-5],`FirstDiscountPrice`=[value-6],`FirstDiscountQty`=[value-7],`SecondDiscountPrice`=[value-8],`SecondDiscountQty`=[value-9],`ThirdDiscountPrice`=[value-10],`ThirdDiscountQty`=[value-11],`Picture`=[value-12],`Stock`=[value-13] WHERE 1"
            $sql = "UPDATE `products` SET `FirstDiscountPrice`= NULL,`FirstDiscountQty`= NULL, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$username, $productName]);
                header("location: ../waybill.php?discountNull");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateSecondDiscountNull(string $username, string $productName)
        {
            # code...
            $sql = "UPDATE `products` SET `SecondDiscountPrice`= NULL,`SecondDiscountQty`= NULL, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$username, $productName]);
                header("location: ../waybill.php?discountNull");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateThirdDiscountNull(string $username, string $productName)
        {
            # code...
            $sql = "UPDATE `products` SET `ThirdDiscountPrice`= NULL,`ThirdDiscountQty`= NULL, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            try {
                //code...
                $stmt->execute([$username, $productName]);
                header("location: ../waybill.php?discountNull");
            } catch (\TypeError $e) {
                //throw $e;
                echo "Error: ".$e->getMessage(); 
                header("location: ../waybill.php?dbError");
            }
        }

        protected function updateProductPhoto(string $username, string $productName, string $productPhoto, string $photoTmpName)
        {
            # code...
            $sql = "UPDATE `products` SET `Picture`= ?, DateTime = CURRENT_TIMESTAMP WHERE `products`.`Merchant` = ? AND `products`.`ProductName` = ?;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$productPhoto, $username, $productName]);

            $photoDestination = '../'.$productPhoto;

            if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                # code...
                header("location: ../waybill.php?uploadError");
            } else {
                # code...
                header("location: ../waybill.php?pictureEdited");
            }
            
            $stmt = null;
            
        }

        protected function selectProduct(string $username)
        {
            # code...
            $sql = "SELECT * FROM products WHERE Merchant = '$username' ORDER BY DateTime DESC, id DESC;";
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll();

            return $results;
        }

        protected function checkProduct(string $username, string $productName)
        {
            # code...
            $sql = "SELECT * FROM products WHERE Merchant = '$username' AND ProductName = '$productName';";
            $stmt = $this->connect()->query($sql);
            $results = $stmt->fetchAll();

            return $results;
        }

    }
    
?>
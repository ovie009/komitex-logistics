<?php

    class Controller extends Model
    {

        public function signup(string $fullname, string $username, string $email, string $phone, string $password)
        {
            # code...
            $emailResults = $this->checkSignupEmail($email);
            
            if (empty($emailResults)) {
                # code...
                $usernameResults = $this->checkSignupUsername($username);
                
                if (empty($usernameResults)) {
                    # code...
                    $this->insertSignup($fullname, $username, $email, $phone, $password);
                } else {
                    # code...
                    echo 'userExist';
                }

            }else{
                echo 'emailExist';
            }

        }

        public function login(string $user, string $password)
        {
            # code...
            $results = $this->checkLoginDetails($user);

            $this->saveLoginDetails($user, $results, $password);
        }
        
        public function accountType(string $account, string $email)
        {
            # code...
            $this->updateAccountType($account, $email);
        }

        public function uploadProfilePhoto(string $email, string $username, array $photo)
        {
            # code...

            $email = $_POST['email'];
            $username = $_POST['username'];
    
            $photoName = $photo['name'];
            $photoTmpName = $photo['tmp_name'];
            $photoSize = $photo['size'];
            $photoError = $photo['error'];
    
            $photoExt = explode('.', $photoName);
            $photoActualExt = strtolower(end($photoExt));
    
            $allowed = array('jpg', 'jpeg', 'png');
    
            if(in_array($photoActualExt, $allowed)){
                if($photoError === 0){
                    if($photoSize <= 3000000){
                        
                        $photoNewName = $username.'.'.$photoActualExt;
    
                        $photoDestination = '../uploads/'.$photoNewName;

                        $profilePhoto = 'uploads/'.$photoNewName;

                        $results = $this->checkLoginDetails($username);

                        if ($results[0]['komitexLogisticsProfilePhoto'] != 'icons/others/user.png') {
                            # code...
                            $results[0]['komitexLogisticsProfilePhoto'] = '../'.$results[0]['komitexLogisticsProfilePhoto'];
                            
                            unlink($results[0]['komitexLogisticsProfilePhoto']);
                            
                        }
                        
                        if (!move_uploaded_file($photoTmpName, $photoDestination)) {
                            # code...
                            header("location: ../accountinfo.php?uploadError");
                        } else {
                            $this->updateProfilePhoto($email, $profilePhoto);
                            # code...
                        }

                    }else{
                        header("location: ../accountinfo.php?largePhoto");
                    }
                }else{
                    header("location: ../accountinfo.php?uploadError");
                }
            }else{
                header("location: ../accountinfo.php?unsupportedExtension");
            }
        }

        public function deleteProfilePhoto(string $email, string $defaultPhoto)
        {
            # code...

            $results = $this->checkLoginDetails($email);
            
            if ($results[0]['komitexLogisticsProfilePhoto'] != 'icons/others/user.png') {
                # code...
                $results[0]['komitexLogisticsProfilePhoto'] = '../'.$results[0]['komitexLogisticsProfilePhoto'];
                
                unlink($results[0]['komitexLogisticsProfilePhoto']);
            }

            $this->updateProfilePhoto($email, $defaultPhoto);

        }

        public function contacts(string $username01, string $username02, string $accountType01, string $confirmAccount)
        {
            # code...

            $results = $this->checkLoginDetails($username02);
            $accountType02 = $results[0]['komitexLogisticsAccountType'];

            if (empty($results)) {
                # code...
                header("location: ../accountinfo.php?invalidUser");     
                
            } else {
                # code...
                $existingResult01 = $this->checkMyContacts($username01, $accountType01, $username02, $accountType02);
                if (empty($existingResult01)) {
                    # code...
                    $existingResult02 = $this->getContacts($username02, $accountType02);

                    if ($confirmAccount == 'Affiliate') {
                        # code...
                        if (empty($existingResult02)) {
                            # code...
                            $this->insertContacts($username01, $username02, $accountType01, $accountType02);
                            $this->approveContacts($username01, $username02, $accountType01, $accountType02);
                            header("location: ../accountinfo.php?added".$confirmAccount."");     
                        } else {
                            # code...
                            header("location: ../accountinfo.php?existingResult".$confirmAccount."");     
                        }
                        
                    } else if ($confirmAccount == 'Agent'){
                        # code...
                        if (empty($existingResult02)) {
                            # code...
                            $this->insertContacts($username01, $username02, $accountType01, $accountType02);
                            $this->approveContacts($username01, $username02, $accountType01, $accountType02);
                            header("location: ../accountinfo.php?added".$confirmAccount."");     
                        } else {
                            # code...
                            header("location: ../accountinfo.php?existingResult".$confirmAccount."");     
                        }
                        
                    } else if ($confirmAccount == 'Logistics'){
                        # code...
                        $this->insertContacts($username01, $username02, $accountType01, $accountType02);
                        header("location: ../accountinfo.php?requestSent");     
                    }
    
                    
                } else {
                    # code...
                    header("location: ../accountinfo.php?my".$confirmAccount."Result");     

                }
            }
        }

        public function resendContacts(string $username01, string $accountType01, string $username02, string $accountType02, string $confirmAccount)
        {
            # code...
            $this->deleteContacts($username01, $accountType01, $username02, $accountType02);
            $this->contacts($username01, $username02, $accountType01, $confirmAccount);
        }

        public function removeContacts(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $this->deleteContacts($username01, $accountType01, $username02, $accountType02);
        }

        public function confirmContact(string $username01, string $username02, string $accountType01, string $accountType02)
        {
            # code...
            $this->approveContacts($username01, $username02, $accountType01, $accountType02);
        }

        public function declineContact(string $username01, string $accountType01, string $username02, string $accountType02)
        {
            # code...
            $this->declineContacts($username01, $accountType01, $username02, $accountType02);
        }

        public function addLocation(string $username, string $location, string $price)
        {
            # code...
            $results = $this->checkLocation($username, $location);
            if (empty($results)) {
                # code...
                $this->newLocation($username, $location, $price);
            }   else{
                header("location: ../accountinfo.php?locationExist");
            }
        }

        public function editLocation(string $username, string $location, string $price)
        {
            # code...
            $this->updateLocation($username, $location, $price);
        }

        public function submitNoDiscountProduct(string $username, string $productName, string $productPrice, string $productPhoto, string $photoTmpName)
        {
            # code...
            $results = $this->checkProduct($username, $productName);
            if (empty($results)) {
                # code...
                $this->insertNoDiscountProduct($username, $productName, $productPrice, $productPhoto, $photoTmpName);
            } else{
                header("location: ../waybill.php?productExist");
            }
        }
        
        public function submitOneDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $productPhoto, string $photoTmpName)
        {
            # code...
            $results = $this->checkProduct($username, $productName);
            if (empty($results)) {
                # code...
                $this->insertOneDiscountProduct($username, $productName, $productPrice, $price1, $quantity1, $productPhoto, $photoTmpName);
            } else{
                header("location: ../waybill.php?productExist");
            }
        }
        
        public function submitTwoDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $price2, string $quantity2, string $productPhoto, string $photoTmpName)
        {
            # code...
            $results = $this->checkProduct($username, $productName);
            if (empty($results)) {
                # code...
                $this->insertTwoDiscountProduct($username, $productName, $productPrice, $price1, $quantity1, $price2, $quantity2, $productPhoto, $photoTmpName);
            } else{
                header("location: ../waybill.php?productExist");
            }
        }
        
        public function submitThreeDiscountProduct(string $username, string $productName, string $productPrice, string $price1, string $quantity1, string $price2, string $quantity2, string $price3, string $quantity3, string $productPhoto, string $photoTmpName)
        {
            # code...
            $results = $this->checkProduct($username, $productName);
            if (empty($results)) {
                # code...
                $this->insertThreeDiscountProduct($username, $productName, $productPrice, $price1, $quantity1, $price2, $quantity2, $price3, $quantity3, $productPhoto, $photoTmpName);
            } else{
                header("location: ../waybill.php?productExist");
            }
        }
        
        public function submitDiscount(string $username, string $productName, string $price, string $quantity, string $action)
        {
            # code...
            if ($action == 'submitDiscount1') {
                # code...
                $this->updateOneDiscount($username, $productName, $price, $quantity);
            } elseif ($action == 'submitDiscount2') {
                # code...
                $this->updateSecondDiscount($username, $productName, $price, $quantity);
            } elseif ($action == 'submitDiscount3') {
                # code...
                $this->updateThirdDiscount($username, $productName, $price, $quantity);
            }
            
            
        }

        public function deleteDiscount(string $username, string $productName, string $action)
        {
            # code...
            if ($action == 'deleteDiscount1') {
                # code...
                $this->updateOneDiscountNull($username, $productName);
            } elseif ($action == 'deleteDiscount2') {
                # code...
                $this->updateSecondDiscountNull($username, $productName);
            } elseif ($action == 'deleteDiscount3') {
                # code...
                $this->updateThirdDiscountNull($username, $productName);
            }
            
            
        }

        public function changeProductPicture(string $username, string $productName, string $productPhoto, string $photoTmpName)
        {
            # code...
            $this->updateProductPhoto($username, $productName, $productPhoto, $photoTmpName);
        }

        public function editPrice(string $username, string $productName, string $price)
        {
            # code...
            $this->updateProductPrice($username, $productName, $price);
        }
    }

?>
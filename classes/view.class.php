<?php

    class View extends Model
    {
        public function viewContacts(string $username, string $accountType)
        {
            # code...
            $results = $this->getContacts($username, $accountType);
            return $results;
        }
        
        public function getContactDetails(string $username02)
        {
            # code...
            $results = $this->checkLoginDetails($username02);
            return $results;
        }

        public function viewLocation(string $username)
        {
            # code...
            $results = $this->selectLocation($username);
            return $results;
        }       
        
        public function viewProducts(string $username)
        {
            # code...
            $results = $this->selectProduct($username);
            return $results;
        }
    }
    
?>
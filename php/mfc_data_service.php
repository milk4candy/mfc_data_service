<?php

    class mfc_data_service {

        private $username = null;
        private $password = null;
        private $auth_str = null;
        private $http = null;
        private $url = null;
        private $response =null;

        public function __construct(){
            $this->set_http();
        }

        public function __destruct(){
            curl_close($this->get_http());
        }

        public function set_username($username){
            $this->username = $username;
        }

        public function set_password($password){
            $this->password = $password;
        }

        public function get_auth_str(){
            return base64_encode("$this->username:$this->password");
        }

        public function set_url($url){
            $this->url = $url;
        }

        public function get_url(){
            return $this->url;
        }

        public function set_http(){
            $this->http = curl_init();
        }

        public function get_http(){
            return $this->http;
        }

        public function fetch_data($format="xml"){

            $http = $this->get_http();
            $url = $this->get_url();
            $auth_str = $this->get_auth_str();

            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_HTTPHEADER, array("Authorization: Basic $auth_str"));
            curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
            $this->response = curl_exec($http);

            return $this->response;
            
        }

    }

?>

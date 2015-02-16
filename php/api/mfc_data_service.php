<?php

    class mfc_data_service {

        private $http = null;
        private $url = null;
        private $response =null;

        public function __construct(){
            $this->set_http();
        }

        public function __destruct(){
            curl_close($this->get_http());
        }

        public function set_http(){
            $this->http = curl_init();
        }

        public function get_http(){
            return $this->http;
        }

        public function set_url($url){
            $this->url = $url;
        }

        public function get_url(){
            return $this->url;
        }

        public function set_basic_authorization($username, $password){
            $auth_str = base64_encode("$username:$password");
            curl_setopt($this->get_http(), CURLOPT_HTTPHEADER, array("Authorization: Basic $auth_str"));
        }

        public function fetch_data($format="xml"){

            $http = $this->get_http();
            $url = $this->get_url();

            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
            $this->response = curl_exec($http);

            return $this->response;
            
        }

    }

?>

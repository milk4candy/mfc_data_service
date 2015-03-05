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

        public function fetch_file_list($format="xml"){

            $http = $this->get_http();
            $url = $this->get_url();

            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
            $this->response = curl_exec($http);

            return $this->response;
            
        }

        public function save_file($save_dir, $name_filter=false, $size_filter=false){

            $xml = simplexml_load_string($this->fetch_file_list());

            $save_dir = rtrim($save_dir, "/");

            $files_to_save = array();
            foreach($xml->file as $file){
                $filename = (string)$file->attributes()->name;
                $mtime = (string)$file->attributes()->mtime;
                $size = (int)$file->attributes()->size;

                if($name_filter){
                    if(!preg_match($name_filter, $filename)){
                        continue;
                    }
                }

                if($size_filter){
                    if($size_filter > 0){
                        if($size < $size_filter){
                            continue;
                        }
                    }elseif($size_filter < 0){
                        if($size > abs($size_filter)){
                            continue;
                        }
                    }else{
                        if($size != 0){
                            continue;
                        }
                    }
                }

                $files_to_save[$filename] = (string)$file->url;
            }

            if(count($files_to_save) > 0){
                echo "Start downloading files to $save_dir ...\n";
                foreach($files_to_save as $fn => $url){
                    $cmd = "wget -q -O $save_dir/$fn $url";
                    echo "  Downloading $fn ...";
                    exec($cmd, $output, $exec_code);
                    if($exec_code == 0){
                        echo "  success.\n";
                    }else{
                        echo "  fail.\n";
                    }
                }
                echo "Download finished.\n";
            }
            
        }

    }

?>

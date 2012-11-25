<?php
/********************************
* Cron Email Report Client File
* @Author: Jermaine Byfield
* @email: mrbyfield@gmail.com
*******************/
$message = '';
$error = 0;

        function setPARAM($param){
                
               
                $data = '';
                $i =0;
                $amp = '';
                foreach($param as $key=>$val){
                        if($i!=0){$amp='&';}
                        $data.= $amp.$key.'='.$val;
                        $i++;
                }
                return $data;
        }

        function getData($url,$param){
                                $tuCurl = curl_init();
                                $param = setPARAM($param);
                                curl_setopt($tuCurl, CURLOPT_URL, $url );
                                curl_setopt($tuCurl, CURLOPT_PORT , 80);
                                curl_setopt($tuCurl, CURLOPT_VERBOSE, 0);
                                curl_setopt($tuCurl, CURLOPT_HEADER, 0);
                                curl_setopt($tuCurl, CURLOPT_POST, 1);
                                curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($tuCurl, CURLOPT_POSTFIELDS, $param);
                                $tuData = curl_exec($tuCurl);
                if(!curl_errno($tuCurl)){
                                  $info = curl_getinfo($tuCurl);
                                 // echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
                                } else {
                                  echo 'Curl error: ' . curl_error($tuCurl);
                                }
                                curl_close($tuCurl);
                                return $tuData;
        }

$data['website'] =  "Example Inc.";
$data['cronname'] = "MLS GET";
$data['cronmessage'] =$message;
$data['cronpathfull'] =  $_SERVER['SCRIPT_FILENAME'];
$data['status']= ($error?0:1);
getData('demo.example.com/cronfolder/api.php',$data);
/********************************
* Cron Email Report Ends Here
*
*******************/




?>
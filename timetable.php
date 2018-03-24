<?php
require "vendor/autoload.php";
use PHPHtmlParser\Dom;
	/**
	* 
	*/
	// class timetable
	// {
	// 	function curl_request($url,$post='',$cookie='', $returnCookie=0){
	//         $curl = curl_init();
	//         curl_setopt($curl, CURLOPT_URL, $url);
	// 		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	// 	        "Connection: keep-alive",
	// 	        "Origin: http://wlkt.nuist.edu.cn",
	// 	        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
	// 	        "Upgrade-Insecure-Requests: 1",
	// 	        "DNT:1",
	// 	        "Accept-Language: zh-cn",
	// 	));
	//         curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_2 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Version/11.0 Mobile/15C202 Safari/604.1');
	//         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	//         curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	//         curl_setopt($curl, CURLOPT_REFERER, $url);
	//         curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
	//   #      curl_setopt($curl, CURLOPT_PROXY, "http://192.168.0.100:8888");
	//         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
 //    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	//         if($post) {
	//             curl_setopt($curl, CURLOPT_POST, 1);
	//             curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
	//         }
	//         if($cookie) {
	//             curl_setopt($curl, CURLOPT_COOKIE, $cookie);
	//         }
	//         curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
	//         curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	//         // curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
	        
	//         $data[0] = curl_exec($curl);
	//         $location = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);
	//         // print_r(curl_getinfo($curl));
	//         $data[1] = $location;
	//         if (curl_errno($curl)) {
	//             return curl_error($curl);
	//         }
	//         curl_close($curl);
	//         // print_r($data[0]);
	//         if($returnCookie){
	//             list($header, $body) = explode("\r\n\r\n", $data[0], 2);
	//              // print_r($header);
	//             if (preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches)) {
	//             	$info['cookie']  = substr($matches[1][0], 1);
	//             	$info['content'] = $body;
	//             	// print_r($header);
	//             	return $info;
	//             } else {
	//             	return null;
	//             }
	            
	//         }else{
	//             return $data;
	//         }
	// 	}
	// 	public function getView()
	// 	{
	// 	     $url = 'http://wlkt.nuist.edu.cn/Default.aspx';
	// 	     $result = $this->curl_request($url);
	// 	     $pattern = '/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*?)" \/>/is';
	// 	     preg_match_all($pattern, $result[0], $matches);
	// 	     $res[0] = $matches[1][0];
	// 	     $res[1] = $result[1];
	// 	   	 $codes = explode('/', $result[1]);
	// 	   	 $url = $codes[0].'//'.$codes[2].'/'.$codes[3].'/yzm.aspx';
	// 		 $code = $this->curl_request($url,'','',1);
	// 		 $res[2] = $code['cookie'];
	// 	     return $res;
	// 	}

		
	// }
	// $timetable = new timetable;
	// $result = $timetable->getView();
	// $__VIEWSTATE = $result[0];
	// $site = $result[1];
	// $site_determin = explode('/', $site);
	// $url = $site_determin[0].'//'.$site_determin[2].'/'.$site_determin[3].'/default.aspx';
	// //$code = explode('=', $result[2])[1];
 //    $post_data = [
 //    	'__VIEWSTATE' => $__VIEWSTATE,
 //    	'TextBox1' => '20151344002',
 //    	'TextBox2' => '19961110',
 //    	//'TxtYZM' => $code,
 //    	'js' => 'RadioButton3',
 //    	'Button1' => '登陆'
 //    ];
 //    $result = $timetable->curl_request($url,$post_data,$result[2],1);
 //    // print_r($result);die;
 //    $cookie = $result['cookie'];
 //    $new_url = $site_determin[0].'//'.$site_determin[2].'/'.$site_determin[3].'/public/kebiaoall.aspx';
 //    $result = $timetable->curl_request($new_url,'',$cookie);
 //    $file = fopen(txt.txt, 'w+');
 //    fwrite($file, $result[0]);
 //    fclose($file);
 //    print_r($result);die;
 	
 	$dom = new Dom;
 	$file = fopen('txttxt', 'r');
 	$result[0] = fread($file, filesize('txttxt'));
 	$result = explode('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">', $result[0]);
 	$dom->load($result[1]);
//  	$dom->load('<div class="all"><p>Hey bro, <a href="google.com" id="78">click here</a>
// <div class="all2"><p>Hey bro, <a href="google.com" id="78">click here</a></div><br />
//  		</div><br />');
 	// $dom->get
 	// $a = $dom->getElementsByClass('box');
 	$a = $dom->find('table')[1];
 	// echo $a;
 	$lessons = explode('<span class="STYLE1" style="color: #FFFFFF">星期日</span></td> </tr>', $a)[1];
 	$dom->load($lessons);
 	$a = $dom->find('tr');
 	$i = 0;
 	foreach ($a as $value) {
 		$dom->load($value);
 		$final = $dom->find('td');
 		// print_r($final->text);
 		// $final = $final->text;
 		foreach($final as $key => $v) {
 			if($key%8 == 0) {
 				$i++;
 			}
 			$data[$i][$key] = $v->text;
 			// echo "\n".$v->text."\n";
 		}
 	}
 	print_r($data);
	/*foreach ($a as $key) {
		echo "\n".$key."\n";
	}*/
    
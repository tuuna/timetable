<?php
	/**
	* 
	*/
	class timetable
	{
		function curl_request($url,$post='',$cookie='', $returnCookie=0){
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		        "Connection: keep-alive",
		        "Origin: http://wlkt.nuist.edu.cn",
		        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
		        "Upgrade-Insecure-Requests: 1",
		        "DNT:1",
		        "Accept-Language: zh-cn",
		));
	        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_2_2 like Mac OS X) AppleWebKit/604.4.7 (KHTML, like Gecko) Version/11.0 Mobile/15C202 Safari/604.1');
	        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	        curl_setopt($curl, CURLOPT_REFERER, $url);
	        curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
	        curl_setopt($curl, CURLOPT_PROXY, "http://192.168.0.100:8888");
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	        if($post) {
	            curl_setopt($curl, CURLOPT_POST, 1);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
	        }
	        if($cookie) {
	            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
	        }
	        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
	        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        // curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
	        
	        $data[0] = curl_exec($curl);
	        $location = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);
	        // print_r(curl_getinfo($curl));
	        $data[1] = $location;
	        if (curl_errno($curl)) {
	            return curl_error($curl);
	        }
	        curl_close($curl);
	        print_r($data[0]);
	        if($returnCookie){
	            list($header, $body) = explode("\r\n\r\n", $data[0], 2);
	            if (preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches)) {
	            	$info['cookie']  = substr($matches[1][0], 1);
	            	$info['content'] = $body;
	            	// print_r($header);
	            	return $info;
	            } else {
	            	return null;
	            }
	            
	        }else{
	            return $data;
	        }
		}
		public function getView()
		{
		     $url = 'http://wlkt.nuist.edu.cn/Default.aspx';
		     $result = $this->curl_request($url);
		     $pattern = '/<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="(.*?)" \/>/is';
		     preg_match_all($pattern, $result[0], $matches);
		     $res[0] = $matches[1][0];
		     $res[1] = $result[1];
		   	 $codes = explode('/', $result[1]);
		   	 $url = $codes[0].'//'.$codes[2].'/'.$codes[3].'/yzm.aspx';
			 $code = $this->curl_request($url,'','',1);
			 $res[2] = $code['cookie'];
		     return $res;
		}
	}
	$timetable = new timetable;
	$result = $timetable->getView();
	$__VIEWSTATE = $result[0];
	$site = $result[1];
	$site_determin = explode('/', $site);
	$url = $site_determin[0].'//'.$site_determin[2].'/'.$site_determin[3].'/default.aspx';
	$code = explode('=', $result[2])[1];
    $post_data = [
    	'__VIEWSTATE' => $__VIEWSTATE,
    	'TextBox1' => '20141346063',
    	'TextBox2' => '19960820',
    	'TxtYZM' => $code,
    	'js' => 'RadioButton3',
    	'Button1' => '登陆'
    ];
    $result = $timetable->curl_request($url,$post_data,$result[2],1);
     print_r($result);
<?php
	/**
	* 
	*/
	class timetable
	{
		function curl_request($url,$post='',$cookie='', $returnCookie=0){
	        $curl = curl_init();
	        curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
	        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
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
	        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);
	        
	        $data[0] = curl_exec($curl);
	        $location = curl_getinfo($curl,CURLINFO_EFFECTIVE_URL);
	        print_r(curl_getinfo($curl));
	        $data[1] = $location;
	        if (curl_errno($curl)) {
	            return curl_error($curl);
	        }
	        curl_close($curl);
	        if($returnCookie){
	            list($header, $body) = explode("\r\n\r\n", $data[0], 2);
	            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
	            $info['cookie']  = substr($matches[1][0], 1);
	            $info['content'] = $body;
	            print_r($header);
	            return $info;
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
	$code = explode('=', $result[2])[1];
    $post_data = [
    	'__VIEWSTATE' => $__VIEWSTATE,
    	'TextBox1' => '20141346063',
    	'TextBox2' => '19960820',
    	'TxtTZM' => $code,
    	'js' => 'RadioButton3',
    	'Button1' => '登陆'
    ];
    $result = $timetable->curl_request($site,$post_data,'checkcode='.$code,1);
    // echo $code;die;
    // print_r($result);
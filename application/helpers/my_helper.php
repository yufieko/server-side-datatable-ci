<?php

function web_title($title)
{
	$ci = get_instance();
	$ci->template->title($title,$ci->config->item('site_title')); // set page title
	return $ci;
}

function web_build($file, $data = NULL)
{
	$ci = get_instance();
	$ci->template->build($file, $data);
	return $ci;
}

function web_breadcrumb($name, $uri = '')
{
	$ci = get_instance();
	$ci->template->set_breadcrumb($name, $uri);
	return $ci;
}

function front_url($file = "")
{
	return empty($file) ? base_url('assets/front/') : base_url('assets/front/'.$file);
}

function back_url($file = "")
{
	return empty($file) ? base_url('assets/back/') : base_url('assets/back/'.$file);
}

function vendor_url($file = "")
{
	return empty($file) ? base_url('assets/vendor/') : base_url('assets/vendor/'.$file);
}

function plugin_url($file = "")
{
	return empty($file) ? base_url('assets/back/plugins/') : base_url('assets/back/plugins/'.$file);
}

function assets_url($file = "")
{
	return empty($file) ? base_url('assets/') : base_url('assets/'.$file);
}

function upload_url($file = "")
{
	return empty($file) ? base_url('uploads/') : base_url('uploads/'.$file);
}

function dashboard_url($uri = "")
{
	return empty($uri) ? site_url('goodadmin') : base_url('goodadmin/'.$uri);
}


function post_info($id,$data,$extra=null)
{
	$CI =& get_instance();
    $CI->load->database();

	if($data == "column_type") {
	    $query = $CI->db->select($extra)->from("post_types")->where("id", $id)->get()->row();

		return $query->$extra;
	} elseif($data == "url") {
		$query = $CI->db->select("p.slug,p.id,pt.slug AS post_type,p.created_original,p.type_id")
    				->from("posts p")
    				->join('post_types pt','pt.id = p.type_id')
    				->where("p.id", $id)
    				->limit(1)
    				->get();

	    if ($query->row()) {
	    	$d = empty($extra) ? 'default' : $extra;
	    	$post = $query->row();
	    	if($post->type_id == 1) {
	    		$year = date('Y', strtotime($post->created_original));
	            $month = date('m', strtotime($post->created_original));
	            $date = date('d', strtotime($post->created_original));

	            return $d == 'default' ? site_url($year.'/'.$month.'/'.$date.'/'.$post->slug) : $year.'/'.$month.'/'.$date.'/'.$post->slug;
	    	}
	        return $d == 'default' ? site_url($post->post_type."/".$post->slug) : $post->post_type."/".$post->slug;
	    } else {
	        return site_url();
	    }
	} elseif($data == "category") {
		$query = $CI->db->select("c.name")
    				->from("posts p")
    				->join('categories c','c.id = p.category_id')
    				->where("p.id", $id)
    				->limit(1)
    				->get();

	    if ($query->row()) {
	    	$post = $query->row();
	        return $post->name;
	    } else {
	        return "Belum Berkategori";
	    }
	} elseif($data == "reading_time") {
		$est = "";
		$query = $CI->db->select('content')->from("posts")->where("id", $id)->get();

		if ($query->row()) {
	    	$post = $query->row();
	        $word = str_word_count(strip_tags($post->content));
	        $m = floor($word / 200);
	        $s = floor($word % 200 / (200 / 60));
	        // $est = $m . ' minute' . ($m == 1 ? '' : 's') . ', ' . $s . ' second' . ($s == 1 ? '' : 's');
	        $est = $m . ' menit baca';
	    } else {
	    	$est = "2 menit baca";
	    }
	    return $est;
	}
}

function channel_info($id,$data,$extra=null)
{
	$CI =& get_instance();
    $CI->load->database();

	if($data == "column") {
	    $query = $CI->db->select($extra)->from("channel")->where("id", $id)->get()->row();

		return $query->$extra;
	} elseif($data == "url") {
		$query = $CI->db->select("id,name,slug,created")
    				->from("channel")
    				->where("id", $id)
    				->get();

	    if ($query->num_rows() > 0) {
	    	$channel = $query->row();
	        return site_url("kanal/".$channel->slug);
	    } else {
	        return site_url();
	    }
	}
}

function category_info($id,$data,$extra=null)
{
	$CI =& get_instance();
    $CI->load->database();

	if($data == "column") {
	    $query = $CI->db->select($extra)->from("category")->where("id", $id)->get()->row();

		return $query->$extra;
	} elseif($data == "url") {
		$query = $CI->db->select("id,name,slug,created")
    				->from("category")
    				->where("id", $id)
    				->get();

	    if ($query->num_rows() > 0) {
	    	$category = $query->row();
	        return site_url("kategori/".$category->slug);
	    } else {
	        return site_url();
	    }
	}
}

function ad_info($position,$data)
{
	$CI =& get_instance();
    $CI->load->database();

    $query = $CI->db->select()
    		->from("ads")
    		->where("position", $position)
    		->where("status", 1)
    		->get();

    if($query) {
    	if($query->num_rows() > 0) {
	    	$d = $query->row();

	    	$now = new DateTime();
	        $start_date = new DateTime($d->start_date);
	        $end_date = new DateTime($d->end_date);

	        // check date
	        if($start_date <= $now && $now <= $end_date){
	        	if($data == 'all') {
		    		return $d;
		    	} else {
		    		return $d->$data;	
		    	}	
	        } else {
	        	return false;
	        }
	    } else {
	    	return false;
	    }
    } else {
    	log_message('error',$CI->db->error());
    	return false;
    }
}

function user_info($user,$data,$extra=null)
{
	$CI =& get_instance();
    $CI->load->database();

	if($data == "today_content") {
		$date_start = date("Y-m-d 00:00:01");
		$date_end = date("Y-m-d 23:59:59");

		$total = $CI->db->where("author", $user)
						->where("status", 1)
						->where("created >=", $date_start)
						->where("created <=", $date_end)
						->count_all_results('posts');

		return $total;
	} elseif($data == "total_contents") {
		$total = $CI->db->where("author", $user)
						->where("status", 1)
						->count_all_results('posts');

		return $total;
	} elseif($data == "total_content_on_category") {
		$total = $CI->db->where("author", $user)
						->where("category", $extra)
						->where("status", 1)
						->count_all_results('posts');

		return $total;
	} elseif($data == "join") {
		$query = $CI->db->select("created_on")->from("users")->where("id", $user)->get()->row();
		$date = strftime("%d %B %Y",$query->created_on);

		return $date;
	} elseif($data == "profile_url") {
		$query = $CI->db->select("username")->from("users")->where("id", $user)->get()->row();

		return site_url('penulis/'.$query->username);
	} elseif($data == "avatar") {
	    $query = $CI->db->select("avatar")->from("users")->where("id", $user)->get()->row();

		return upload_url("avatar/".$query->avatar);
	} elseif($data == "column") {
	    $query = $CI->db->select($extra)->from("users")->where("id", $user)->get()->row();

		return $query->$extra;
	}
}

function youtube_responsive($content) 
{
  	$replacement = '<div class="embed-responsive embed-responsive-16by9">$0</div>';
  	$regex = '/<iframe[^>]*src\s*=\s*"?https?:\/\/[^\s"\/]*youtube.com(?:\/[^\s"]*)?"?[^>]*>.*?<\/iframe>/i';
  	$newContent = preg_replace_callback($regex, function($match) {
    	// replace class attr
    	$classRegex = '/class="(.*?)"/i';
    	$hasClass = preg_match($classRegex, $match[0]);
    	if (false !== $hasClass && $hasClass > 0) {
      		// class attr exists on iframe
      		$newIframe = preg_replace($classRegex, 'class="$1 embed-responsive-item"', $match[0]);
    	} else {
      		// no class attr exists on iframe
      		$replaceRegex = '/^<iframe/i';
      		$newIframe = preg_replace($replaceRegex, '<iframe class="embed-responsive-item"', $match[0]);
    	}
    	return $newIframe;
  	}, $content);

  	$newContent = preg_replace($regex, $replacement, $newContent);
  	return $newContent;
}

function check_facebook_url($url)
{
	$fbUrlCheck = '/^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/';
	$secondCheck = '/home((\/)?\.[a-zA-Z0-9])?/';
	
	if(preg_match($fbUrlCheck, $url) == 1 && preg_match($secondCheck, $url) == 0) {
		return true;
	} else {
		return false;
	}
}

function convert_text_url($string)
{
	$url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$string = preg_replace($url, '<a href="http$2://$4" target="_blank" rel="nofollow" title="$0">$0</a>', $string);
	return $string;
}

/**
* Converts a UTC timestamp to date string of given timezone (considering DST) and given dateformat
*
* DateTime requires PHP >= 5.2
*
* @param $str_server_datetime
*
* Normally is a 14-digit UTC timestamp (YYYYMMDDHHMMSS). It can also be 8-digit (date), 12-digit (datetime without seconds).
* If given dateformat ($str_user_dateformat) is longer than $str_server_datetime,
* the missing digits of input value are filled with zero,
* so (YYYYMMDD is equivalent to YYYYMMDD000000 and YYYYMMDDHHMM is equivalent to YYYYMMDDHHMM00).
*
* It can also be 'now', null or empty string. In this case returns the current time.
*
* Other values (invalid datetime strings) throw an error. Milliseconds are not supported.
*
* @param string $str_user_timezone
* @param $str_user_dateformat
* @return string
*/
function date_decode($str_server_datetime, $str_user_timezone, $str_user_dateformat) {
	// create date object
	try {
	$date = new DateTime($str_server_datetime);
	} catch(Exception $e) {
	trigger_error('date_decode: Invalid datetime: ' . $e->getMessage(), E_USER_ERROR);
	}

	// convert to user timezone
	$userTimeZone = new DateTimeZone($str_user_timezone);
	$date->setTimeZone($userTimeZone);

	// convert to user dateformat
	$str_user_datetime = $date->format($str_user_dateformat);

	return $str_user_datetime;
}

function get_ads($position, $data)
{
	$CI =& get_instance();
    $CI->load->database();

    $query = $CI->db->select()->from("ads")->where("position", $position)->where("status", 1)->get()->row();

    if(!empty($query)) {
    	return $query->$data;	
    } else {
    	return false;
    }
	
}

function getPostReactionPercentage($post,$reaction,$total = null) {
	$CI =& get_instance();
    $CI->load->database();

    $sql = "SELECT COUNT(*) AS total FROM post_reactions WHERE post_id = ? AND reaction = ?";
    $q = $CI->db->query($sql, 
    	array(
    		$post, 
    		$reaction
    	)
    );

    if($q) {
    	$single = $q->row()->total;

    	if(empty($total)) {
	        $total = getPostReactionsTotal($post);
	    }

	    $result = $total == 0 ? 0 : round(($single/$total)*100);
    } else {
    	log_message('error', $CI->db->error());
    	$result = 0;
    }

    return $result;
}

function getPostReactionsTotal($post) {
	$CI =& get_instance();
    $CI->load->database();

    $sql = "SELECT COUNT(*) AS total FROM post_reactions WHERE post_id = ?";
    $q = $CI->db->query($sql, 
    	array(
    		$post
    	)
    );

    if($q) {
    	$result = $q->row()->total;
    } else {
    	log_message('error', $CI->db->error());
    	$result = 0;
    }

    return $result;
}

function word_limit($string,$character = 23)
{
	$limit = $character;
	$count = strlen($string);

	if($count <= $limit) return $string;
	else {
		$exp = explode(" ", $string);
		return $exp[0] . " " . $exp[1] . " " . $exp[2];
	}
}

function name_limit($string,$count = 1)
{
	$exp = explode(" ", $string);
	$new = "";
	for($i=0;$i<count($i);$i++){
		if($i < $count)
		{
			$new .= $exp[$i] . " ";
		}
	}
	return $new;
}

function cover_url($name,$created,$modified)
{
	if(empty($name)) return upload_url('cover/default.jpg');

	if($created != $modified) {
		if(!empty($modified)) {
			return upload_url('cover/watermark_'.$name.'?rev='.strtotime($modified));
		}
	}
	return upload_url('cover/watermark_'.$name);
}

function URL_exists($url)
{
   $headers = get_headers($url);
   return stripos($headers[0],"200 OK") ? true : false;
}


function time_stamp($session_time,$lang = 1)
{
	$time_difference = time() - date(strtotime($session_time),time()) ;
	$seconds = $time_difference ;
	$minutes = round($time_difference / 60 );
	$hours = round($time_difference / 3600 );
	$days = round($time_difference / 86400 );
	$weeks = round($time_difference / 604800 );
	$months = round($time_difference / 2419200 );
	$years = round($time_difference / 29030400 );

	if($seconds <= 60)
	{
	    return $lang === 1 ? "$seconds detik yang lalu" : "$seconds seconds ago";
	}
	else if($minutes <=60)
	{
	    if($minutes==1)
	    {
	        return $lang === 1 ? "satu menit yang lalu" : "one minute ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$minutes menit yang lalu" : "$minutes minutes ago";
	    }
	}
	else if($hours <=24)
	{
	    if($hours==1)
	    {
	        return $lang === 1 ? "satu jam yang lalu" : "one hour ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$hours jam yang lalu" : "$hours hours ago";
	    }
	}
	else if($days <=7)
	{
	    if($days==1)
	    {
	        return $lang === 1 ? "satu hari yang lalu" : "one day ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$days hari yang lalu" : "$days days ago";
	    }
	}
	else if($weeks <=4)
	{
	    if($weeks==1)
	    {
	        return $lang === 1 ? "satu pekan yang lalu" : "one week ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$weeks pekan yang lalu" : "$weeks weeks ago";
	    }
	}
	else if($months <=12)
	{
	    if($months==1)
	    {
	        return $lang === 1 ? "satu bulan yang lalu" : "one month ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$months bulan yang lalu" : "$months months ago";
	    }
	}
	else
	{
	    if($years==1)
	    {
	        return $lang === 1 ? "satu tahun yang lalu" : "one year ago";
	    }
	    else
	    {
	        return $lang === 1 ? "$years tahun yang lalu" : "$years years ago";
	    }
	}
}

function time_stamp_user($session_time,$lang = 2)
{
	$time_difference = time() - $session_time ;
	$seconds = $time_difference ;
	$minutes = round($time_difference / 60 );
	$hours = round($time_difference / 3600 );
	$days = round($time_difference / 86400 );
	$weeks = round($time_difference / 604800 );
	$months = round($time_difference / 2419200 );
	$years = round($time_difference / 29030400 );

	if($hours <=24)
	{
        return $lang === 1 ? "Hari ini" : "Today";
	}
	else if($days <=7)
	{
	    return $lang === 1 ? "Kemarin" : "Yesterday";
	}
	else
	{
		return $lang === 1 ? date("d M") : date("d M");
	}
}

function format_num($num, $precision = 2) 
{
    if ($num >= 1000 && $num < 1000000) {
        $n_format = number_format($num/1000,$precision).'k';
    } else if ($num >= 1000000 && $num < 1000000000) {
        $n_format = number_format($num/1000000,$precision).'m';
    } else if ($num >= 1000000000) {
        $n_format=number_format($num/1000000000,$precision).'b';
    } else {
        $n_format = $num;
    }
    return $n_format;
}

function deleteFiles($path)
{
    $files = glob($path); // get all file names
    foreach($files as $file){ // iterate files
        if(file_exists($file) && !is_dir($file)) {
            return unlink($file) or die('Failed to remove: ' . $path); // delete file
            //echo $file.'file deleted';
        }
    }
}

function status_label($status)
{
	switch($status) {
		case "publish" : 
		case 1 : $status = '<span class="label bg-green">Publish</span>'; break;
		case "review" : 
		case 2 : $status = '<span class="label bg-amber">Review</span>'; break;
		case "draft" : 
		case 3 : $status = '<span class="label bg-brown">Draft</span>'; break;
		case "trash" : 
		case 4 : $status = '<span class="label bg-deep-orange">Trash</span>'; break;
		case "deleted" : 
		case 5 : $status = '<span class="label bg-red">Deleted</span>'; break;
	};

	return $status;
}

function user_status_label($status)
{
	switch($status) {
		case 1 : $status = '<span class="label bg-green">Aktif</span>'; break;
		case 0 : $status = '<span class="label bg-red">Tidak Aktif</span>'; break;
	};

	return $status;
}

function get_setting($name)
{
  	$ci = get_instance();
	return $ci->common_model->getSetting($name);
}

function edit_unique($value, $params)  {
    $CI =& get_instance();
    $CI->load->database();

    $CI->form_validation->set_message('edit_unique', "Maaf, %s itu sudah dipakai/ada.");

    list($table, $field, $current_id) = explode(".", $params);

    $query = $CI->db->select()->from($table)->where($field, $value)->limit(1)->get();

    if ($query->row() && $query->row()->id != $current_id)
    {
        return FALSE;
    } else {
        return TRUE;
    }
}

function random_color()
{
	$colors = array(
		'#f56954','#f39c12','#0073b7','#00c0ef','#00a65a','#3c8dbc'
	);

	return $colors[ mt_rand( 0,count($colors)-1 ) ];
}

function getGroupColumn($id,$column)
{
  	$ci = get_instance();

  	$ci->load->model('common_model');
	return $ci->common_model->getGroupColumn($id,$column);
}

function pagination_nav($uri, $item_per_page, $current_page, $total_records, $total_pages)
{
  	$pagination = '<div class="text-center">';

  	// verify total pages and current page number
  	if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
    	$pagination .= '<ul class="pagination">';

    	$right_links    = $current_page + 3;
    	$previous       = $current_page - 3; // previous link
    	$next           = $current_page + 1; // next link
    	$first_link     = true; // boolean var to decide our first link

    	$pagination .= '<li class="page-item '.($current_page == 1?'disabled':'').'"><a href="'.$uri.'" data-page="1" class="page-link" aria-label="Pertama" title="Pertama"><span aria-hidden="true"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>'; // first link
    	
    	if($current_page > 1) {
      		$previous_link = ($previous<=1) ? 1 : $previous;

      		// $pagination .= '<li><a href="'.$uri.'page/'.$previous_link.'" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; // previous link
          	for($i = ($current_page-2); $i < $current_page; $i++) { // Create left-hand side links
              	if($i > 0){
                  	$pagination .= '<li class="page-item"><a href="'.$uri.'/laman/'.$i.'" class="page-link" data-page="'.$i.'" title="Halaman '.$i.'">'.$i.'</a></li>';
              	}
          	}
      		$first_link = false; // set first link to false
    	}

    	if($first_link) { // if current active page is first link
        	$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	} elseif($current_page == $total_pages) { // if it's the last active link
       		$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	} else { // regular current link
       		$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	}

    	for($i = $current_page+1; $i < $right_links ; $i++) { // create right-hand side links
        	if($i<=$total_pages) {
            	$pagination .= '<li class="page-item"><a href="'.$uri.'/laman/'.$i.'" class="page-link" data-page="'.$i.'" title="Halaman '.$i.'">'.$i.'</a></li>';
        	}
    	}

    	if($current_page < $total_pages){
      		// $next_link = ($i > $total_pages) ? $total_pages : $i;
      		// $pagination .= '<li><a href="'.$uri.'page/'.$next_link.'" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
      		$pagination .= '<li class="page-item"><a href="'.$uri.'/laman/'.$total_pages.'" class="page-link" data-page="'.$total_pages.'" title="Terakhir" aria-label="Terakhir"><span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></a></li>'; // last link
		} else {
      		$pagination .= '<li class="page-item disabled"><a href="#" class="page-link" data-page="'.$total_pages.'" title="Terakhir" aria-label="Terakhir"><span aria-hidden="true"><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></a></li>'; // last link
    	}
    	$pagination .= '</ul>';
  	}
  	$pagination .= '</div>';
  	return $pagination; //return pagination links
}

function pagination_get_nav($uri, $item_per_page, $current_page, $total_records, $total_pages)
{
  	$pagination = '<div class="text-center">';

  	// verify total pages and current page number
  	if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
    	$pagination .= '<ul class="pagination">';

    	$right_links    = $current_page + 3;
    	$previous       = $current_page - 3; // previous link
    	$next           = $current_page + 1; // next link
    	$first_link     = true; // boolean var to decide our first link

    	$pagination .= '<li class="page-item '.($current_page == 1?'disabled':'').'"><a href="'.$uri.'" data-page="1" class="page-link" aria-label="Pertama" title="Pertama"><span><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></a></li>'; // first link
    	if($current_page > 1) {
      		$previous_link = ($previous<=1) ? 1 : $previous;

      		// $pagination .= '<li><a href="'.$uri.'page/'.$previous_link.'" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; // previous link
          	for($i = ($current_page-2); $i < $current_page; $i++) { // Create left-hand side links
              	if($i > 0){
                	$pagination .= '<li class="page-item"><a href="'.$uri.'&p='.$i.'" class="page-link" data-page="'.$i.'" title="Halaman '.$i.'">'.$i.'</a></li>';
              	}
          	}
      		$first_link = false; // set first link to false
   	 	}

    	if($first_link) { // if current active page is first link
        	$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	} elseif($current_page == $total_pages) { // if it's the last active link
       		$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	} else { // regular current link
       		$pagination .= '<li class="page-item active"><a href="#" class="page-link">'.$current_page.'</a></li>';
    	}

    	for($i = $current_page+1; $i < $right_links ; $i++) { // create right-hand side links
        	if($i<=$total_pages) {
            	$pagination .= '<li class="page-item"><a href="'.$uri.'&p='.$i.'" class="page-link" data-page="'.$i.'" title="Halaman '.$i.'">'.$i.'</a></li>';
        	}
    	}
    	if($current_page < $total_pages) {
      		// $next_link = ($i > $total_pages) ? $total_pages : $i;
      		// $pagination .= '<li><a href="'.$uri.'page/'.$next_link.'" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
      		$pagination .= '<li class="page-item"><a href="'.$uri.'&p='.$total_pages.'" class="page-link" data-page="'.$total_pages.'" title="Terakhir" aria-label="Terakhir"><span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></a></li>'; // last link
    	} else {
      		$pagination .= '<li class="page-item disabled"><a href="#" class="page-link" data-page="'.$total_pages.'" title="Terakhir" aria-label="Terakhir"><span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></a></li>'; // last link
    	}

    	$pagination .= '</ul>';
  	}

  	$pagination .= '</div>';
  	return $pagination; //return pagination links
}
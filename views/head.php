<?
// open-records-generator
require_once('open-records-generator/config/config.php');
require_once('open-records-generator/config/url.php');

// site
require_once('static/php/config.php');
require_once('static/php/function.php');

$db = db_connect("guest");
$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();

if($uu->id)
	$item = $oo->get($uu->id);
else
	// $item = $oo->get(0);    
	$item = $oo->get(1);    // _Home id
$name = ltrim(strip_tags($item["name1"]), ".");
$id_arr_raw = $uu->ids;
// var_dump($id_arr_raw);
if(count($id_arr_raw) > 1){
	$id_arr = array_slice($id_arr_raw, 0, 1);
}
else
	$id_arr = $id_arr_raw;
// var_dump($id_arr);
// $nav = $oo->nav($id_arr);
$nav = nav_zenazezza($id_arr, $oo);
// var_dump($nav);
$show_menu = false;
if($uu->id) {
	// $is_leaf = empty($oo->children_ids($uu->id));
	// $internal = (substr($_SERVER['HTTP_REFERER'], 0, strlen($host)) === $host);	
	// if(!$is_leaf && $internal)
	// 	$show_menu = true;

	$show_menu = true;
} else  
    if ($uri[1])  
        $uu->id = -1; 

?><!DOCTYPE html>
<html>
	<head>
		<title><? echo $site; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="/static/fonts/euler/euler.css">
		<link rel="stylesheet" href="/static/fonts/optima/optima.css">
		<link rel="stylesheet" href="/static/fonts/palatino/palatino.css">
		<link rel="stylesheet" href="/static/css/main.css">
		<link rel="apple-touch-icon" href="/media/png/touchicon.png" />
	</head>
	<body><?
	    if(!$uu->id) {
    	    ?><header id="menu" class="homepage"><?
	    } else if($show_menu) {
    	    ?><header id="menu" class="visible"><?
	    } else {
    	    ?><header id="menu" class="hidden"><?
	    }
	    ?><div id = 'site-info'>
	    	<p><a class = 'reverse' href = '/'>Zena Zezza</a></p>
	    	<p>Portland, Oregon</p>
	    	<p>USA</p>
	    	<p>+1 415 321 9304</p>
	    	<p><a href = 'mailto:zena@zenazezza.org'>zena@zenazezza.org</a></p>
	    </div>
	    <br>
	    <ul>
		    <li><?
			    if($uu->id) {
				    ?><a href="<? echo $host; ?>"><?= $head; ?></a><?
			    }
			    else { 
                    echo $head; 
                }
		    ?></li>
		    <ul id = 'level-1' class="nav-level"><?
	    $prevd = $nav[0]['depth'];
	    foreach($nav as $n) {
		    $d = $n['depth'];
		    // var_dump($d);
		   	if($d > $prevd) {
    		    ?><ul class="nav-level" depth="<?= $d; ?>"><?
		    }
		    else {
			    for($i = 0; $i < $prevd - $d; $i++) { 
                    ?></ul><? 
                }
		    }
		    if(substr($n['o']['name1'], 0, 1) != '_' &&
				substr($n['o']['name1'], 0, 1) != '.' ){
		    ?><li class = "<?= $n['o']['id'] == $uu->id ? 'current' : '' ?>"><?
			    if($n['o']['id'] != $uu->id) {
			    	$highlight = false;
			    	if(in_array($n['o']['url'], $uri))
			    		$highlight = true;
    			    ?><a class = 'reverse <?= $highlight ? "highlight" : "" ?>' href="<? echo $host.$n['url']; ?>"><?
				    echo $n['o']['name1'];
                    if ($n['o']['url'] !== "about")
    				    $n['o']['deck'];
	    		    ?></a><?
			    }
			    else {
    			    ?><span class = 'highlight'><?= $n['o']['name1']; ?></span><?
			    }
		    ?></li><?
		    }
		    $prevd = $d;
	    }
	    ?></ul>
	    </ul>
    </header>
    <script>
    	var current_page = document.querySelector('li.current');
    	if(current_page)
    	{
    		var current_parent = current_page.parentNode;
    		var current_page_siblings = current_parent.childNodes;
    		if(current_page_siblings.length > 1 && current_parent.id != 'level-1')
    		{
    			[].forEach.call(current_page_siblings, function(el, i){
    				console.log(el.tagName);
		    		if(el != current_page && el.tagName == 'LI')
		    			el.classList.add('current_sibling');
		    	});
    		}
    	}
    </script>
    <div id = 'badge'>
    	<a href = '/'><img src = '/media/jpg/label.jpg'></a>
    </div>

<?php 
$sidebar_html = get_template_directory_uri() . '/cache/sidebar.txt';
$have_cached = false;
if (file_exists($sidebar_html)){
    $file_time = filemtime($sidebar_html);
    if (($file_time + 18000) > time()){ //缓存5小时
        echo "<!-- cached sidebar -->";
        echo(file_get_contents($sidebar_html));
        echo "<!-- end of cached sidebar -->";
        $have_cached = true;
    }
}
if(!$have_cached){
    ob_start();
?>
<aside class="sidebar">
<?php
if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sitesidebar')) : endif;

if (is_single()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_postsidebar')) : endif;
}
else if (is_page()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_pagesidebar')) : endif;
}
else if (is_home()){
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_sidebar')) : endif;
}
else {
	if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_othersidebar')) : endif;
}
?>
</aside>
<?php
    $sidebar_content = ob_get_contents();
    ob_end_clean();
    $sidebar_fp = fopen($sidebar_html, "w");
 
    if ($sidebar_fp){
         fwrite($sidebar_fp, $sidebar_content);
         fclose($sidebar_fp);
    }
 
    echo $sidebar_content;
}
?>
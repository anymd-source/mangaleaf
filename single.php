<?php 
defined("ABSPATH") || die("!");
get_header();
$readerClass = new GOV_mangastream_reader();
$mode = $readerClass->get_chapter_mode();
if ("minimal" == $mode){
	get_template_part( "template-parts/single/single", "minimal" );
}else{
	ts_load_part( "template-parts/single/single-advanced", ["readerClass" => $readerClass]);
}
get_footer();
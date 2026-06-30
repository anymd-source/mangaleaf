<?php defined("ABSPATH") || die("!"); ?>

<style>
.series-history-pool{
    margin:15px;
}
</style>

<!-- series history-->
<div class="bixbox bxcl" id="series-history" style="display:none;">
    <div class="releases" >
        <h2><?php echo GOV_lang::get('series_history_title'); ?></h2>
    </div>
    <div class="series-history-pool">
        <ul class="clstyle" id="series-history-ul"></ul>
    </div>
</div>
<span id="series-history-tpl" style='display:none'>
    <li data-id="{{id}}" data-num="{{number}}">
		<div class="chbox">
			<div class="eph-num">
				<a onclick="return series_history.redirect({{id}});" href="#/chapter-{{number}}">
					<span class="chapternum"><?php echo GOV_lang::get('widget_chapter_label'); ?> {{number}}</span>
					<span class="chapterdate">{{date}}</span>
				</a>
			</div>
		</div>
	</li>
</span>
<!-- /series history-->
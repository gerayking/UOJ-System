<?php
	if ($is_preview) {
		$readmore_pos = strpos($blog['content'], '<!-- readmore -->');
		if ($readmore_pos !== false) {
			$content = substr($blog['content'], 0, $readmore_pos).'<p><a href="'.HTML::blog_url(UOJContext::userid(), '/post/'.$blog['id']).'">阅读更多……</a></p>';
		} else {
			$content = $blog['content'];
		}
	} else {
		$content = $blog['content'];
	}
	
	$extra_text = $blog['is_hidden'] ? '<span class="text-muted">[已隐藏]</span> ' : '';
	
	$blog_type = $blog['type'] == 'B' ? 'post' : 'slide';
?>
<h2><?= $extra_text ?><a class="header-a" href="<?= HTML::blog_url(UOJContext::userid(), '/post/'.$blog['id']) ?>"><?= $blog['title'] ?></a></h2>
<div><?= $blog['post_time'] ?> <strong>By</strong> <?= getUserLink($blog['poster']) ?></div>
<?php if (!$show_title_only): ?>
<div class="card mb-4">
	<div class="card-body">
		<?php if ($blog_type == 'post'): ?>
		<article><?= $content ?></article>
		<?php elseif ($blog_type == 'slide'): ?>
		<article>
			<div class="embed-responsive embed-responsive-16by9">
				<iframe class="embed-responsive-item" src="<?= HTML::blog_url(UOJContext::userid(), '/slide/'.$blog['id']) ?>"></iframe>
			</div>
			<div class="text-right top-buffer-sm">
				<a class="btn btn-secondary btn-md" href="<?= HTML::blog_url(UOJContext::userid(), '/slide/'.$blog['id']) ?>"><span class="glyphicon glyphicon-fullscreen"></span> 全屏</a>
			</div>
		</article>
		<?php endif ?>
	</div>
	<div class="card-footer text-right">
		<ul class="list-inline bot-buffer-no">
			<li class="list-inline-item">
			<?php foreach (queryBlogTags($blog['id']) as $tag): ?>
				<?php echoBlogTag($tag) ?>
			<?php endforeach ?>
			</li>
			<?php if ($is_preview): ?>
  			<li class="list-inline-item"><a href="<?= HTML::blog_url(UOJContext::userid(), '/post/'.$blog['id']) ?>">阅读全文</a></li>
  			<?php endif ?>
  			<?php if (Auth::check() && (isSuperUser(Auth::user()) || Auth::id() == $blog['poster'])): ?>
			<li class="list-inline-item"><a href="<?=HTML::blog_url(UOJContext::userid(), '/'.$blog_type.'/'.$blog['id'].'/write')?>">修改</a></li>
			<li class="list-inline-item"><a href="<?=HTML::blog_url(UOJContext::userid(), '/post/'.$blog['id'].'/delete')?>">删除</a></li>
			<?php endif ?>
  			<li class="list-inline-item"><?= getClickZanBlock('B', $blog['id'], $blog['zan']) ?></li>
		</ul>
	</div>
	<a class="uoj-username">附件下载</a>
	<?php foreach ($blog["files"] as $file): ?>
		<ul class="list-group" id="file-list-display">
			<li	class="list-group-item"><a href="<?="/post/download?p=".$file["path"]."&name=".$file["filename"]?>"><?=$file["filename"]?></a></li>
		</ul>
	<?php endforeach;?>
</div>
<?php endif ?>

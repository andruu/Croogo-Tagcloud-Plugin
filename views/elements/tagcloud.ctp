<?php
App::import('Helper', 'Tagcloud.Tagcloud');
$tagcloud = new TagcloudHelper;
foreach($tags as $tag) {
	$formatted_tags[$tag['Term']['title']] = $tag['Term']['tag_count'];
}
$tag_info = $tagcloud->formulateTagCloud($formatted_tags);
?>
<h3><?php echo $block['Block']['title']; ?></h3>
<? foreach ($tags as $tag) : ?>
<?=$html->link($tag['Term']['title'], array(
	'controller' => 'nodes',
    'action' => 'term',
    'type' => 'blog',
    'slug' => $tag['Term']['slug'],
), array('style' => 'font-size:' . $tag_info[$tag['Term']['title']]['size'] . '%'))?>&nbsp;&nbsp;
<? endforeach ?>
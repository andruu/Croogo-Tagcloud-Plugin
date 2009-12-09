<div class="tagcloud settings">
    <h2><?php __('Tagcloud Settings'); ?></h2>
    <?php echo $form->create('Tagcloud', array('url' => array('controller' => 'tagcloud', 'action' => 'settings'))); ?>
    <fieldset>
        <?=$form->input('vocabulary_id', array('value' => Configure::read('Tagcloud.term')))?>
    </fieldset>
    <?php echo $form->end('Submit'); ?>
</div>
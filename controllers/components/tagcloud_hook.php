<?php
/**
* Tagcloud Component
*
* Tagcloud Component for Croogo
*
* @category Component
* @package  Croogo
* @version  1.0
* @author   Andrew Weir <andru.weir@gmail.com>
* @license  http://www.opensource.org/licenses/mit-license.php The MIT License
* @link     http://andrw.net
*/
class TagcloudHookComponent extends Object {

    function onActivate(&$controller) {
        
        $controller->Croogo->addAdminMenu('Tagcloud');
        $controller->Setting->write('Tagcloud.term', '2');
        
        $block = ClassRegistry::init('Block')->find('first',
        array('conditions' => array(
            'Block.alias' => 'tagcloud'
        )));
        if (empty($block)) {
            ClassRegistry::init('Block')->create();
            ClassRegistry::init('Block')->save(array('Block' => array(
                'region_id' => 4,
                'title'     => 'Tagcloud',
                'alias'     => 'tagcloud',
                'status'    => 1,
                'element'   => 'Tagcloud.tagcloud'
            )));
        }
    }
    
    function onDeactivate(&$controller) {
        ClassRegistry::init('Block')->deleteAll(array('Block.alias' => 'tagcloud'));
        ClassRegistry::init('Setting')->deleteAll(array('Setting.key' => 'Tagcloud.term'));
        $controller->Croogo->removeAdminMenu('Tagcloud');
    }

    /**
    * Called after the Controller::beforeFilter() and before the controller action
    *
    * @param object $controller Controller with components to startup
    * @return void
    */
    function startup(&$controller) {
        $controller->set('tags', $this->tagcloud(&$controller));
    }

    /**
    * Called after the Controller::beforeRender(), after the view class is loaded, and before the
    * Controller::render()
    *
    * @param object $controller Controller with components to beforeRender
    * @return void
    */
    function beforeRender(&$controller) {
    }

    /**
    * Called after Controller::render() and before the output is printed to the browser.
    *
    * @param object $controller Controller with components to shutdown
    * @return void
    */
    function shutdown(&$controller) {
    }

    /**
    * Return tags from database.
    *
    * @return array
    */
    function tagcloud (&$controller) {
        
        $term_id = Configure::read('Tagcloud.term');
        
        $query = "SELECT count(*) as tag_count, Term.title, Term.id, Term.slug
            FROM nodes_terms as nt
            JOIN terms as Term ON Term.id = nt.term_id
            WHERE Term.vocabulary_id = {$term_id}
            GROUP BY nt.term_id";

        $tags = ClassRegistry::init('Term')->query($query);

        if(Set::check($tags, '0.0')) {
            $fieldName = key($tags[0][0]);
            foreach($tags as $key=>$value) {
                $tags[$key]['Term'][$fieldName] = $value[0][$fieldName];
                unset($tags[$key][0]);
            }
        }
        return $tags;
    }

}
?>
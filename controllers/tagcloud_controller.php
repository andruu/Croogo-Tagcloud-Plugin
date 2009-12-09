<?php
class TagcloudController extends TagcloudAppController {
    
    var $name = 'Tagcloud';
    var $uses = array();
    
    function admin_settings() {
        
        if (!empty($this->data)) {
            $this->Setting->write('Tagcloud.term', $this->data['Tagcloud']['vocabulary_id']);
            $this->Session->setFlash(__('Tagcloud settings updated successfully.', true));
        }
        
        $this->loadModel('Vocabulary');        
        $this->set('vocabularies', $this->Vocabulary->find('list'));
        $this->set('title', 'Tagcloud Settings');
    }
}
?>
<?php

    /**
     * @author quyetnd
     */

    class default_block_utility Extends baseBlock {

        public function init() {
            $rate = new XmlHelper(RATE_URL);                                   
            $this->data['rate_data'] = $rate->getXml();
                 
            $rate = new XmlHelper(GOLD_URL);                                   
            $this->data['gold_data'] = $rate->getXml();            
        }

    }

?>
<?php
class Model extends CActiveRecord
{
    public function delete(){
        $this->setAttribute('deleted', true);
        $this->save();
        return true;
    }

    public function findAll($condition='', $params = array ( )){
        if(!$condition){
            return $this->findAllByAttributes(array('deleted' => 0));
        } else{
            return parent::findAll($condition, $params);
        }
    }
} 
<?php

/**
 * Sharded active record
 */
class CShardedActiveRecord extends CActiveRecord
{
    /**
     * Used in find by PK and
     * @var integer
     */
    private $_pk = null;

    /**
     * Used connection
     * @var CDbConnection
     */
    private $_connection = null;


    /**
     * @see db/ar/CActiveRecord#getDbConnection()
     */
    public function getDbConnection()
    {

        if (!is_null($this->_connection))
            return $this->_connection;
        if (is_null($this->_pk)) {
            $serverName = Yii::app()->params->servers['serverNames'][0];
        } else {
            $serverId = $this->getServerId($this->_pk);
            $serverName =empty(Yii::app()->params->servers['serverNames'][$serverId]) ?
                Yii::app()->params->servers['serverNames'][0]
                : Yii::app()->params->servers['serverNames'][$serverId];
        }
        $this->_connection = Yii::app()->{$serverName};
        return $this->_connection;
    }

    private function removeConnection()
    {
        $this->_connection = null;
    }

    private function getRedisKey($key)
    {
        return $this->tableName() . '_' . $key;
    }

    /**
     * @return server id or false, for null $pk
     */
    private function getServerId($pk)
    {
        if (is_null($pk))
            return false;
        $serverId = Yii::app()->RediskaConnection->getConnection()->get($this->getRedisKey($pk));
        return $serverId;
    }

    public function findByPk($pk, $condition = '', $params = array())
    {
        if (!is_integer($pk))
            throw new Exception ('primary key must be integer');
        $this->_pk = $pk;
        $this->removeConnection();
        return parent::findByPk($pk, $condition, $params);
    }

    /**
     * Set unique id for new record
     * @return boolean
     */
    protected function beforeSave()
    {
        if (!parent::beforeSave())
            return false;
        if ($this->getIsNewRecord()) {
            $key = $this->tableName().'_counter';
            $this->id = $this->_pk = Yii::app()->RediskaConnection->getConnection()->increment($key);
            $serverId = $this->id % Yii::app()->params->servers['serverCount'];
            $result = Yii::app()->RediskaConnection->getConnection()->set($this->getRedisKey($this->id), $serverId);
            $this->removeConnection();
        }
        return true;
    }
}
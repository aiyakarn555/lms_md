<?php 
class VODCActiveRecord extends CActiveRecord {
    
    private static $vod = null;
 
    protected static function getAdvertDbConnection()
    {
        if (self::$vod !== null)
            return self::$vod;
        else
        {
            self::$vod = Yii::app()->dbvod;
            if (self::$vod instanceof CDbConnection)
            {
                self::$vod->setActive(true);
                return self::$vod;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
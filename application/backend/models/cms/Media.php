<?php

namespace backend\models\cms;


class Media extends \common\models\cms\Media
{
    const TEMP_DIR = UPLOADS_DIR.'/.temp';
    const HASH_FILE_METHOD = HASH_FILE_METHOD;
    const MIME_FOLDER = 'directory';


    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasOne(self::className(), ['parent_id' => 'id']);
    }

    public static function getIdByPath($parentId, $name)
    {
        $strSql = " SELECT id FROM tbl_cms_media WHERE parent_id = :parentId AND name = :name; ";
        $cmd = self::getDb()->createCommand($strSql);
        $cmd->bindParam(":parentId", $parentId, \PDO::PARAM_INT);
        $cmd->bindParam(":name", $name, \PDO::PARAM_STR);
        return $cmd->queryScalar();
    }

    public function getPath()
    {
        return self::UPLOADS_DIR.'/'.$this->content_path();
    }

    public function getUrl()
    {
        return self::UPLOADS_URL.'/'.$this->content_path();
    }

    /* public static function createPath(){
        return  '/'.'src/'.date('Y').'/'.date('md').'/'.substr(md5($name), 0, 1);;
    } */
}
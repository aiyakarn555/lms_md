<?php

/**
 * Yush class file.
 *
 * @author Matt Skelton
 * @date 3-Aug-2012
 */

/**
 * Description
 */
class Yush
{
    const FORMAT_PATH = 'path';
    const FORMAT_URL = 'url';

    /**
     * These are common sizes that can be used throughout views and controllers.
     */
    const SIZE_CROPPED = 'cropped';
    const SIZE_THUMB = 'thumb';
    const SIZE_SMALL = 'small';
    const SIZE_LARGE = 'large';
    const SIZE_ORIGINAL = 'original';

    private static $model;

    /**
     * Builds the initial structure specified in the config.
     * This method should always be called before uploading resources.
     * @param CActiveRecord $model the model associated with the resource
     */
    public static function init(CActiveRecord $model)
    {
        self::$model = $model;

        if (!self::buildStructure($model))
        {
            throw new Exception('Error creating directories. Please check permissions and try again.');
        }
    }

    /**
     * Returns the URL for the specified resource.
     * If no format is given and the filename is given, the URL to the original image will be returned.
     * If no filename is given, the URL to parent directory will be returned.
     * @param CActiveRecord $model the model associated with this image
     * @param string $format the size format to be returned
     * @param string $filename the filename of the image
     * @return string the full URL to the specified resource
     */
    public static function getUrl(CActiveRecord $model, $format, $filename)
    {
        return self::buildDestination(self::FORMAT_URL, $model, $format, $filename);
    }

    /**
     * Returns the path for the specified resource.
     * If no format is given and the filename is given, the path to the original image will be returned.
     * If no filename is given, the path to parent directory will be returned.
     * @param CActiveRecord $model the model associated with this image
     * @param string $format the size format to be returned
     * @param string $filename the filename of the image
     * @return string the full path to the specified resource
     */
    public static function getPath(CActiveRecord $model, $format, $filename)
    {
        return self::buildDestination(self::FORMAT_PATH, $model, $format, $filename);
    }

    /**
     * Returns an array of directory paths for a given level.
     * Level 1 returns the baseFolder + the first template
     * Level 2 returns the baseFolder + the first & 2nd template
     * Etc
     * @param CActiveRecord $model
     * @param type $level
     * @return type
     */
    public static function getDirectoriesAtLevel(CActiveRecord $model, $level = 1)
    {
        if (!isset($level) || !is_int($level) || $level < 1)
        {
            throw new Exception('$level should be an integer greater than 0');
        }

        $pathList = array();

        foreach (Yii::app()->yush->getComponents($model) as $key => $templateList)
        {
            $components = array();

            array_push($components, self::basePath());

            foreach ($templateList as $key => $directory)
            {
                array_push($components, $directory);
            }

            if ($level)
            {
                // Count and number of elements the path consists of and
                // substract 1 to exclude the basePath/baseUrl
                $componentCount = abs($level - count($components)) - 1;

                for ($i = 0; $i < $componentCount; $i++)
                {
                    array_pop($components);
                }
            }

            $pathList[] = implode(DIRECTORY_SEPARATOR, $components);
        }

        return array_unique($pathList);
    }

    /**
     * Returns an array of paths for the specified model and filename.
     * @param CActiveRecord $model the model whose paths should be returned
     * @param type $filename the name of the file to be appended
     * @return array the array of paths
     */
    public static function getPaths(CActiveRecord $model, $filename)
    {
        $pathList = array();

        foreach (Yii::app()->yush->getComponents($model) as $key => $templateList)
        {
            $components = array();

            array_push($components, self::basePath());

            foreach ($templateList as $key => $directory)
            {
                array_push($components, $directory);
            }

            array_push($components, $filename);

            $pathList[] = implode(DIRECTORY_SEPARATOR, $components);
        }

        return array_unique($pathList);
    }

    /**
     * Returns the full base URL specified in the config
     * @return string the full URL
     */
    public static function baseUrl()
    {
        return Yii::app()->getRequest()->getHostInfo() . Yii::app()->baseUrl . '/' . Yii::app()->yush->baseDirectory;
    }

    /**
     * Returns the full base path specified in the config
     * @return string the full path
     */
    public static function basePath()
    {
        return Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . Yii::app()->yush->baseDirectory;
    }

    /**
     * Determines if a directory exists
     * @param string $path the full path to the directory
     * @return boolean true if the directory exists
     */
    private static function folderExists($path)
    {
        return (file_exists($path) && is_dir($path));
    }

    /**
     * Builds the structure specified in the config
     * @param CActiveRecord $model the model whose structure should be created
     * @return boolean true if all directories were successfully created or already exist
     */
    private static function buildStructure(CActiveRecord $model)
    {
        $isValid = true;

        if (!self::folderExists(self::basePath()))
        {
            @mkdir(self::basePath(), 0755);
        }

        foreach (Yii::app()->yush->getComponents($model) as $key => $componentList)
        {
            $path = self::basePath() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $componentList);

            if (!self::folderExists($path))
            {
                @mkdir($path, 0755, true);
            }

            if (!self::folderExists($path))
            {
                $isValid = false;
            }
        }

        return $isValid;
    }

    /**
     * Returns the full path or url for the specified resource.
     * @param type $format
     * @param CActiveRecord $model the model associated with the resource
     * @param type $size the desired format to be returned
     * @param string $filename the filename of the resource
     * @return string the full path or url to the specified resource
     */
    private static function buildDestination($format, CActiveRecord $model, $size, $filename)
    {
        $components = array();

        ($format == self::FORMAT_PATH) ? array_push($components, self::basePath()) : array_push($components, self::baseUrl());

        foreach (Yii::app()->yush->getComponent($model, $size) as $key => $directory)
            array_push($components, $directory);

        if ($filename)
            array_push($components, CHtml::encode($filename));

        $seperator = ($format == self::FORMAT_PATH) ? DIRECTORY_SEPARATOR : '/';

        return implode($seperator, $components);
    }
}
?>
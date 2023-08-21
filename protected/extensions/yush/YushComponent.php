<?php

/**
 * YushComponent class file.
 *
 * @author Matt Skelton
 * @date 3-Aug-2012
 */

/**
 * YushComponent is responsible for interpreting the templates and exposes them as
 * an array. You shouldn't call this class directly from view or controllers, instead
 * use the Yush helper file.
 *
 * You can configure this class in the application's main config file.
 */
class YushComponent extends CApplicationComponent
{
    /* Public fields can be set via the application's main config. */
    public $lowercase = true;
    public $baseDirectory = 'uploads';
    public $template = array();

    /* Private fields */
    private $model;
    private $destination = array();
    private $defaultTemplate = array(
        '*' => array(
            'small' => '{model}{modelId}',
            'cropped' => '{model}{modelId}',
            'thumb' => '{model}{modelId}',
            'large' => '{model}{modelId}',
            'original' => '{model}{modelId}',
        )
    );

    public function init()
    {
        if ($this->lowercase)
            $this->baseDirectory = strtolower($this->baseDirectory);

        parent::init();
    }

    /**
     * Returns an array containing all transformed templates for a specific model.
     * @param CActiveRecord $model
     * @return type
     */
    public function getComponents(CActiveRecord $model)
    {
        $this->model = $model;

        $structureList = $this->getTemplate();

        $pathList = array();

        foreach ($structureList as $key => $template)
        {
            $pathList[] = $this->getComponent($model, $key);
        }

        return $pathList;
    }

    /**
     * Transforms the templates and returns and array containing the directory names
     * @param CActiveRecord $model the model whose template should be transformed
     * @param type $key the unique identifier for the desired template
     * @return array the list of directories
     */
    public function getComponent(CActiveRecord $model, $key)
    {
        // Empty the destination for subsequent calls
        $this->destination = array();
        $this->model = $model;
        $structureList = $this->getTemplate();

        preg_replace_callback("/{(\w+)}/", array($this, 'transformTemplate'), $structureList[$key]);

        array_push($this->destination, $key);

        if ($this->lowercase)
            $this->destination = array_map("strtolower", $this->destination);

        return $this->destination;
    }

    /**
     * Returns an array containing template strings for a given model.
     * Example:
     * array(
     *      'small' => '{model}{modelId}',
     *      'original' => '{model}{modelId}'
     *  )
     * @return array the array containing the template strings
     */
    private function getTemplate()
    {
        $modelName = get_class($this->model);

        return (array_key_exists($modelName, $this->template)) ? $this->template[$modelName] : $this->defaultTemplate['*'];
    }

    private function transformTemplate($matches)
    {
        $method = 'transform' . $matches[1];
        if (method_exists($this, $method))
        {
            return $this->$method();
        }
        else
            return $matches[0];
    }

    // Templates
    /**
     * Matches the template {model}
     */
    public function transformModel()
    {
        array_push($this->destination, get_class($this->model));
    }

    /**
     * Matches the template {modelId}
     */
    public function transformModelId()
    {
        array_push($this->destination, $this->model->id);
    }

}
?>

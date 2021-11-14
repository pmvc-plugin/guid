<?php

namespace IdOfThings;

use DomainException;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\guid';

class guid extends \PMVC\PlugIn
{
    private $_models;
    private $_privateModelsPlugin = null;

    /**
     * @parameters string guidEngine Default engine.
     * @parameters string privateMoel Private model getter plugin.
     */
    public function init()
    {
        $guid = new BigIntGuid();
        $this->setDefaultAlias($guid);
        if (!isset($this['privateModels'])) {
            $this['privateModels'] = 'private_models';
        }
    }

    private function _getPrivateModelsPlugin()
    {
        if (is_null($this->_privateModelsPlugin)) {
            if (\PMVC\exists($this['privateModels'], 'plug')) {
                $this->_privateModelsPlugin = \PMVC\plug(
                    $this['privateModels']
                );
            } else {
                $this->_privateModelsPlugin = false;
            }
        }
        return $this->_privateModelsPlugin;
    }

    private function _getModels($key, $engine, $modelsGetter)
    {
        if ($modelsGetter) {
            $model = $modelsGetter->getModel($key, $key, $engine);
            if ($model) {
                $this->_models[$key] = $model;

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function _getPublicModels($key, $engine)
    {
        $class = __NAMESPACE__ . '\\models\\' . $key;
        if (!class_exists($class)) {
            return !trigger_error(
                'Model not found [' . $class . ']',
                E_USER_WARNING
            );
        }
        $this->_models[$key] = new $class($engine);
        return true;
    }

    public function getModel($key, $engine = null)
    {
        if (empty($engine)) {
            $engine = $this->getEngine();
        }
        if (empty($this->_models[$key])) {
            $hasPrivateModel = $this->_getModels(
                $key,
                $engine,
                $this->_getPrivateModelsPlugin()
            );
            if (!$hasPrivateModel) {
                $this->_getPublicModels($key, $engine);
            }
        }
        return $this->_models[$key];
    }

    public function getEngine()
    {
        if (empty($this['guidEngine'])) {
            $this['guidEngine'] = \PMVC\plug('get')->get('guidEngine');
            if (empty($this['guidEngine'])) {
                throw new DomainException(
                    'Default db plugin not setted. "guidEngine"'
                );
            }
        }
        $engine = \PMVC\plug($this['guidEngine']);
        if (empty($engine)) {
            return !trigger_error('[GUID] Get engine failed.', E_USER_WARNING);
        }
        return $engine;
    }
}

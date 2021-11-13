<?php

namespace IdOfThings;

use DomainException;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__ . '\guid';

class guid extends \PMVC\PlugIn
{
    private $_models;
    private $_privateModelPlugin = null;

    /**
     * @parameters string guidEngine Default engine.
     * @parameters string privateMoel Private model getter plugin.
     */
    public function init()
    {
        $guid = new BigIntGuid();
        $this->setDefaultAlias($guid);
        if (!isset($this['privateModel'])) {
            $this['privateModel'] = 'private_model';
        }
    }

    private function _getPrivateModelPlugin()
    {
        if (is_null($this->_privateModelPlugin)) {
            if (\PMVC\exists($this['privateModel'], 'plug')) {
                $this->_privateModelPlugin = \PMVC\plug($this['privateModel']);
            } else {
                $this->_privateModelPlugin = false;
            }
        }
        return $this->_privateModelPlugin;
    }

    private function _getPrivateModel($key, $engine)
    {
        $private = $this->_getPrivateModelPlugin();
        if ($private) {
            $model = $private->getModel($key, $key, $engine);
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

    private function _getPublicModel($key, $engine)
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
            if (!$this->_getPrivateModel($key, $engine)) {
                $this->_getPublicModel($key, $engine);
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

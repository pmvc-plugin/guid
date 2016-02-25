<?php
namespace IdOfThings;

trait GetDb
{
    protected $dbs;
    /**
     * @param int    $id  group guid
     * @param string $key group key
     */
    public function getDb($id,$key=null)
    {
        if(empty($this->dbs[$id])){
            $path = $this->getDir().'/src/dbs/'.$key.'.php';
            if (\PMVC\realpath($path)) {
                \PMVC\l($path);
                $class = __NAMESPACE__.'\\'.$key;
                if(class_exists($class)){
                    $this->dbs[$id] = new $class(
                        $this['this'],
                        $id 
                    );
                } else {
                    trigger_error($class .' not exists.');
                    return false;
                }
            } else {
                $this->dbs[$id] = new $this['baseDb'](
                    $this['this'],
                    $id
                );
            }
        }
        return $this->dbs[$id];
    }
}

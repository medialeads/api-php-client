<?php
namespace EuropeanSourcing\Api;

class ModelBuilder
{
    public function build(array $array, $modelName)
    {
        $model = new $modelName();
        $namespace = (new \ReflectionObject($model))->getNamespaceName();

        foreach ($array as $key => $value) {
            $compiledValue = null;

            if (is_array($value)) {
                // search the model name based on the key
                $className = $this->findModel($namespace, $key);

                if ( ($key === 'children') || ($key === 'parent') ) {
                    $className = $modelName;
                }

                if (null !== $className) {
                    // c'est un objet
                    if ($this->isAssociative($value)) {
                        $compiledValue = $this->build($value, $className);

                    // si c'est une clé numérique, c'est un tableau d'object
                    } else {
                        $compiledValue = [];

                        foreach ($value as $row) {
                            $compiledValue[] = $this->build($row, $className);
                        }
                    }
                }
            } else {
                $compiledValue = $value;
            }

            $propertyName = $this->denormalize($key);

            if (method_exists($model, 'set'.ucfirst($propertyName))) {
                $model->{'set'.ucfirst($propertyName)}($compiledValue);
            }
        }

        if (method_exists($model, 'postLoad')) {
            $model->postLoad($array);
        }

        return $model;
    }

    private function isAssociative(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function findModel($namespace, $keyName)
    {
        $subModelName = $namespace.'\\'.ucwords($keyName);

        if (class_exists($subModelName)) {
            return $subModelName;
        }

        // without 's'
        $subModelName = substr($subModelName, 0, (strlen($subModelName)-1));

        if (class_exists($subModelName)) {
            return $subModelName;
        }

        if (preg_match('/ie$/', $subModelName)) {
            $subModelName = preg_replace('/ie$/', 'y', $subModelName);
        }
        if (preg_match('/ies$/', $subModelName)) {
            $subModelName = preg_replace('/ies$/', 'y', $subModelName);
        }

        if (class_exists($subModelName)) {
            return $subModelName;
        }

        return null;
    }

    /**
     * Denormalize CamelCaseName
     *
     * @param unknown $propertyName
     * @return unknown
     */
    private function denormalize($propertyName)
    {
        $camelCasedName = preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
            return ('.' === $match[1] ? '_' : '').strtoupper($match[2]);
        }, $propertyName);

        return lcfirst($camelCasedName);
    }
}

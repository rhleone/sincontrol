<?php
namespace Oness\Sincontrol;

abstract class FacturaWrapper{

    protected $collection;
    protected $entityClass;
    public $entity;

    public function __construct($collection)
    {
        $this->collection = $collection;
        $this->entity = $this->build();
    }

    protected function build()
    {
        $tempFactura = new $this->entityClass;

        $Facturas = collect([]);

        foreach ($this->collection as $model) {
            $Facturas->push($this->makeEntity($tempFactura, $model));
        }

        return $Facturas;
    }

    abstract protected function makeEntity($entity, $model);

}
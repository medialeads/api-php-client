<?php
namespace EuropeanSourcing\Api\Model\Attribute;

interface AttributeInterface
{
    public function getId();

    public function getName();

    public function getFullName();

    public function getCount();

    public function getGroup();
}
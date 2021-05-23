<?php


require_once 'interface/GeoObjectInterface.php';
class GeoObject implements GeoObjectInterface
{
    private $ordinat;
    private $absciss;

    function __construct($coordsString)
    {
        $coords = explode(',', $coordsString);
        $this->absciss = $coords[0];
        $this->ordinat = $coords[1];
    }

    public function x()
    {
        return $this->absciss;
    }

    public function y()
    {
        return $this->ordinat;
    }

}
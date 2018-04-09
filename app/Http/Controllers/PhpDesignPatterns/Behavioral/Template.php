<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午5:22
 */
abstract class SaleItemTemplate
{
    public $price = 0;

    public final function setPriceAdjustments()
    {
        $this->price += $this->oversizedAddition();
        $this->price += $this->taxAddition();
    }

    protected function oversizedAddition()
    {
        return 0;
    }

    abstract protected function taxAddition();
}

class CD extends SaleItemTemplate
{
    public $band;
    public $title;
    public function __construct($band, $title, $price)
    {
        $this->band = $band;
        $this->title = $title;
        $this->price = $price;
    }

    protected function taxAddition()
    {
        // TODO: Implement taxAddition() method.
        return round($this->price * 0.05,2);
    }
}

class BandEndorsedCaseOfCereal extends SaleItemTemplate
{
    public $band;
    public function __construct($band, $price)
    {
        $this->band = $band;
        $this->price = $price;
    }

    protected function taxAddition()
    {
        // TODO: Implement taxAddition() method.
        return 0;
    }

    protected function oversizedAddition()
    {
        return round($this->price * 0.02,2);
    }
}
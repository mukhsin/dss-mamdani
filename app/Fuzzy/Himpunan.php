<?php

namespace App\Fuzzy;

class Himpunan
{
    public string $nama;
    public int $p1;
    public int $p2;
    public int $p3;
    public int $p4;
    public final const INVALID_INDEX = -1;

    /**
     * @param string $nama
     * @param int $p1
     * @param int $p2
     * @param int $p3
     * @param int $p4
     */
    public function __construct(string $nama, int $p1, int $p2, int $p3, int $p4)
    {
        $this->nama = $nama;
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->p3 = $p3;
        $this->p4 = $p4;
    }

    /**
     * @return Bentuk
     */
    public function getBentuk(): Bentuk
    {
        if ($this->p1 < 0 || $this->p2 < 0 || $this->p3 < 0 || $this->p4 < 0) {
            return Bentuk::INVALID;
        }
        if ($this->p1 == $this->p2) {
            return Bentuk::TURUN;
        }
        if ($this->p2 == $this->p3) {
            return Bentuk::GUNUNG_LANCIP;
        }
        if ($this->p3 == $this->p4) {
            return Bentuk::NAIK;
        }
        if (
            $this->p2 > $this->p1 &&
            $this->p3 > $this->p2 &&
            $this->p4 > $this->p3
        ) {
            return Bentuk::GUNUNG_DATAR;
        }
        return Bentuk::INVALID;
    }

    /**
     * @param $x
     * @return float|int
     */
    public function getY($x): float|int
    {
        if ($this->getBentuk() == Bentuk::TURUN) {
            return $this->calculateYTurun($x);
        }
        if ($this->getBentuk() == Bentuk::NAIK) {
            return $this->calculateYNaik($x);
        }
        if ($this->getBentuk() == Bentuk::GUNUNG_LANCIP) {
            return $this->calculateYGunung($x);
        }
        if ($this->getBentuk() == Bentuk::GUNUNG_DATAR) {
            return $this->calculateYGunung($x);
        }
        return self::INVALID_INDEX;
    }

    /**
     * menghitung index dari grafik turun
     * ___
     *    \
     *
     * @param $x
     * @return float|int
     */
    private function calculateYTurun($x): float|int
    {
        if ($x <= $this->p3) {
            return 1;
        }
        if ($x >= $this->p4) {
            return 0;
        }
        return $this->yTurun($x);
    }

    /**
     * menghitung index dari grafik naik
     *  ___
     * /
     *
     * @param $x
     * @return float|int
     */
    private function calculateYNaik($x): float|int
    {
        if ($x <= $this->p1) {
            return 0;
        }
        if ($x >= $this->p3) {
            return 1;
        }
        return $this->yNaik($x);
    }

    /**
     * menghitung index dari grafik gunung
     *  .
     * / \
     *
     * @param $x
     * @return float|int
     */
    private function calculateYGunung($x): float|int
    {
        if ($x <= $this->p1 || $x >= $this->p4) {
            return 0;
        }
        if ($x >= $this->p2 && $x <= $this->p3) {
            return 1;
        }
        if ($x < $this->p2) {
            return $this->yNaik($x);
        }
        if ($x > $this->p3) {
            return $this->yTurun($x);
        }
        return 0;
    }

    private function yTurun($x): float|int
    {
        return ($this->p4 - $x) / ($this->p4 - $this->p3);
    }

    private function yNaik($x): float|int
    {
        return ($x - $this->p1) / ($this->p2 - $this->p1);
    }

    /**
     * @param $y
     * @return float|int
     */
    public function getX($y): float|int
    {
        if ($this->getBentuk() == Bentuk::TURUN) {
            return $this->xTurun($y);
        }
        if ($this->getBentuk() == Bentuk::NAIK) {
            return $this->xNaik($y);
        }
        // if ($this->getBentuk() == Bentuk::GUNUNG_LANCIP) {
        //     return $this->calculateYGunung($y);
        // }
        // if ($this->getBentuk() == Bentuk::GUNUNG_DATAR) {
        //     return $this->calculateYGunung($y);
        // }
        return self::INVALID_INDEX;
    }

    private function xTurun($y): float|int
    {
        /*
         * y = (p4 - x) / (p4 - p3)
         * y * (p4 - p3) = (p4 - x)
         * x = p4 - y * (p4 - p3)
        */
        return $this->p4 - ($y * ($this->p4 - $this->p3));
    }

    private function xNaik($y): float|int
    {
        /*
         * y = (x - p1) / (p2 - p1)
         * y * (p2 - p1) = (x - p1)
         * x = p1 + y * (p2 - p1)
        */
        return $this->p1 + ($y * ($this->p2 - $this->p1));
    }

    public function getPoints(): array
    {
        if ($this->getBentuk() == Bentuk::TURUN) {
            return [1, 1, 0, null];
        }
        if ($this->getBentuk() == Bentuk::NAIK) {
            return [null, 0, 1, 1];
        }
        // if ($this->getBentuk() == Bentuk::GUNUNG_LANCIP) {
        //     return [0, 0, 1, 0];
        // }
        // if ($this->getBentuk() == Bentuk::GUNUNG_DATAR) {
        //     return [0, 0, 1, 1, 0];
        // }
        return [null, null, null, null];
    }

}

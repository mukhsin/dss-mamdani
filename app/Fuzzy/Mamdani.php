<?php

namespace App\Fuzzy;

use JetBrains\PhpStorm\NoReturn;

class Mamdani
{
    private int $k = 1000;
    private int $m = 1000 * 1000;
    private int $var1; //harga_modal
    private int $var2; //harga_jual
    private Variabel $modal;
    private Variabel $untung;
    private Variabel $diskon;
    private Himpunan $aggregate;
    private array $rules;
    private array $predicates;
    private array $aggregates;
    private array $a;

    /**
     * @param int $var1
     * @param int $var2
     */
    public function __construct(int $var1, int $var2)
    {
        $this->var1 = $var1;
        $this->var2 = $var2;
    }

    public function getResult(): float|int
    {
        $this->prepareRules();
        $this->preparePredicates();
        $this->prepareAggregates();
        $this->prepareA();
        $moment = $this->calculateMoment();
        $area = $this->calculateArea();

        // dd([
        //     'rules' => $this->rules,
        //     'predicates' => $this->predicates,
        //     'aggregates' => $this->aggregates,
        //     'aggregate' => $this->aggregate,
        //     'a' => $this->a,
        //     'moment' => $moment,
        //     'area' => $area,
        // ]);

        return $moment / $area;
    }

    public function prepareParameters($parameters): void
    {
        $this->modal = $parameters['modal'];
        $this->untung = $parameters['untung'];
        $this->diskon = $parameters['diskon'];
        // $this->modal = new Variabel('modal', [
        //     new Himpunan('kecil', $this->k(0), $this->k(0), $this->k(30), $this->k(60)),
        //     new Himpunan('besar', $this->k(30), $this->k(60), $this->k(100), $this->k(100)),
        // ]);
        // $this->untung = new Variabel('untung', [
        //     new Himpunan('kecil', $this->m(0), $this->m(0), $this->m(15), $this->m(30)),
        //     new Himpunan('besar', $this->m(15), $this->m(30), $this->m(100), $this->m(100)),
        // ]);
        // $this->diskon = new Variabel('diskon', [
        //     new Himpunan('kecil', $this->p(0), $this->p(0), $this->p(10), $this->p(20)),
        //     new Himpunan('besar', $this->p(10), $this->p(20), $this->p(100), $this->p(100)),
        // ]);
    }

    private function prepareRules(): void
    {
        $this->rules = [
            [
                'modal' => $this->modal->is('kecil'),
                'untung' => $this->untung->is('kecil'),
                'diskon' => $this->diskon->is('kecil'),
            ],
            [
                'modal' => $this->modal->is('kecil'),
                'untung' => $this->untung->is('besar'),
                'diskon' => $this->diskon->is('besar'),
            ],
            [
                'modal' => $this->modal->is('besar'),
                'untung' => $this->untung->is('kecil'),
                'diskon' => $this->diskon->is('kecil'),
            ],
            [
                'modal' => $this->modal->is('besar'),
                'untung' => $this->untung->is('besar'),
                'diskon' => $this->diskon->is('besar'),
            ],
        ];
    }

    private function preparePredicates(): void  //proses fuzzyfikasi dan inferensi (MIN)
    {
        foreach ($this->rules as $key => $rule) {
            /** @var Himpunan $modal */
            $modal = $rule['modal'];
            $indexModal = $modal->getY($this->var1); //harga_modal

            /** @var Himpunan $untung */
            $untung = $rule['untung'];
            $indexUntung = $untung->getY($this->var2);

            /** @var Himpunan $diskon */
            $diskon = $rule['diskon'];
            $predicate = min($indexModal, $indexUntung);
            $this->predicates[$key] = [
                'diskon' => $diskon->nama,
                'value' => $predicate,
            ];
        }
    }

    private function prepareAggregates(): void
    {
        $aggregates = [];
        foreach ($this->predicates as $key => $predicate) {
            $diskon = $predicate['diskon'];
            $value = $predicate['value'];

            if (!array_key_exists($diskon, $aggregates) && $value > 0) {
                $aggregates[$diskon] = $value;
            }
            if (array_key_exists($diskon, $aggregates) && $value > $aggregates[$diskon]) {
                $aggregates[$diskon] = $value;
            }
        }

        $max = 0;
        foreach ($aggregates as $key => $aggregate) {
            if ($aggregate > $max) {
                $max = $aggregate;
                $this->aggregate = $this->diskon->is($key);
            }
        }

        $this->aggregates = $aggregates;
    }

    private function prepareA(): void
    {
        $this->a = [];
        foreach ($this->rules as $rule) {
            /** @var Himpunan $diskon */
            $diskon = $rule['diskon'];
            if ($diskon->nama == $this->aggregate->nama) {
                foreach ($this->aggregates as $y) {
                    $this->a[] = $diskon->getX($y);
                }
                break;
            }
        }
    }

    private function calculateMoment(): int|float
    {
        if (count($this->a) == 1) {
            $a = $this->aggregate->nama == 'kecil' ? 0 : $this->aggregate->p2;
            $b = $this->a[0];
            $t = 1;
            foreach ($this->aggregates as $y) {
                $t = $y;
                break;
            }

            $m1 = $this->calculateIntegralRectangle($a, $b, $t);

            $a = $this->aggregate->nama == 'kecil' ? $this->aggregate->p3 : $this->aggregate->p1;
            $b = $this->aggregate->nama == 'kecil' ? $this->aggregate->p4 : $this->aggregate->p2;
            $t = $this->a[0];
            $s = $this->aggregate->nama == 'kecil' ? 1 : 2;
            $m2 = $this->calculateIntegralTriangle($a, $b, $t, $s);

            return $m1 + $m2;
        }

        return 123123;
    }

    private function calculateIntegralRectangle($a, $b, $t): int|float
    {
        $x = $this->fnIntegralRectangle($t, $a);
        $y = $this->fnIntegralRectangle($t, $b);
        return abs($x - $y);
    }

    private function calculateIntegralTriangle($a, $b, $t, $s): int|float
    {
        $c = abs($a - $b);
        $x = 0;
        $y = 0;
        if ($s == 1) {
            $x = $this->fnIntegralTriangle1($b, $c, $t);
            $y = $this->fnIntegralTriangle1($b, $c, $b);
        }
        if ($s == 2) {
            $x = $this->fnIntegralTriangle2($a, $c, $a);
            $y = $this->fnIntegralTriangle2($a, $c, $t);
        }
        return abs($x - $y);
    }

    /**
     * menghitung integral untuk persegi panjang
     * ___
     * | |
     * ___
     * @param $t
     * @param $z
     * @return int|float
     */
    private function fnIntegralRectangle($t, $z): int|float
    {
        return $t / 2 * $z * $z;
    }

    /**
     * menghitung integral untuk segitiga turun
     * .
     * | \
     * ___
     * @param $b
     * @param $c
     * @param $z
     * @return int|float
     */
    private function fnIntegralTriangle1($b, $c, $z): int|float
    {
        return ($b * $z * $z / (2 * $c)) - ($z * $z * $z / (3 * $c));
    }

    /**
     * menghitung integral untuk segitiga naik
     *    .
     *  / |
     * ___
     * @param $a
     * @param $c
     * @param $z
     * @return int|float
     */
    private function fnIntegralTriangle2($a, $c, $z): int|float
    {
        return ($z - (2 * $a)) * $z / (2 * $c);
    }

    private function calculateArea(): int|float
    {
        if (count($this->a) == 1) {
            $a = $this->aggregate->p4 - ($this->aggregate->nama == 'kecil' ? 0 : $this->aggregate->p3);
            $b = $this->a[0];
            $t = 1;
            foreach ($this->aggregates as $y) {
                $t = $y;
                break;
            }
            return ($a + $b) / 2 * $t;
        }

        return 123123;
    }

    private function k($num): int|float
    {
        return $num * $this->k;
    }

    private function m($num): int|float
    {
        return $num * $this->m;
    }

    private function p($num): int|float
    {
        return $num;
    }

}

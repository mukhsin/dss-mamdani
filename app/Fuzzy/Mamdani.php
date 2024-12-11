<?php

namespace App\Fuzzy;

use JetBrains\PhpStorm\NoReturn;

class Mamdani
{
    private int $k = 1000;
    private int $m = 1000 * 1000;
    private int $var1; // harga_modal
    private int $var2; // harga_jual
    private Variabel $modal;
    private Variabel $untung;
    private Variabel $diskon;
    private Himpunan $aggregate;
    private array $rules;
    private array $predicates;
    private array $aggregates;
    private array $t;
    private array $list_step;

    /**
     * @param int $var1
     * @param int $var2
     */
    public function __construct(int $var1, int $var2, array $parameters)
    {
        $this->var1 = $var1;
        $this->var2 = $var2;

        $this->list_step['input'] = [
            'harga_modal' => $var1,
            'harga_jual' => $var2,
        ];

        $this->prepareParameters($parameters);
    }

    public function getListStep(): array
    {
        return $this->list_step;
    }

    public function getResult(): float|int
    {
        $this->prepareRules();
        $this->preparePredicates();
        $this->prepareAggregates();
        $this->prepareT();
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

    private function prepareParameters($parameters): void
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

        $params = [];
        foreach ($parameters as $key => /** @var Variabel $variabel */ $variabel) {
            $myu = [];
            foreach ($variabel->list_himpunan as /** @var Himpunan $himpunan */ $himpunan) {
                $var = 0;
                if ($key == 'modal') {
                    $var = $this->var1;
                }
                if ($key == 'untung') {
                    $var = $this->var2;
                }
                if ($key == 'diskon') {
                    continue;
                }
                $myu[] = [
                    'nama' => 'μ ' . $variabel->nama . ' ' . $himpunan->nama,
                    'param' => $var,
                    'index' => $himpunan->getY($var),
                ];
            }

            $params[$key] = [
                'data' => [
                    'nama' => strtoupper($key),
                    'myu' => $myu,
                ],
                'chart' => [
                    'type' => 'line',
                    'data' => [
                        'labels' => $variabel->getPoints(),
                        'datasets' => $variabel->getDatasets(),
                    ],
                ],
            ];
        }
        $this->list_step['parameters'] = $params;
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

        $rules = [];
        foreach ($this->rules as $rule) {
            $rules[] = 'Jika modal ' . $rule['modal']->nama
                . ' dan untung ' . $rule['untung']->nama
                . ', maka diskon ' . $rule['diskon']->nama;
        }
        $this->list_step['rules'] = $rules;
    }

    private function preparePredicates(): void // proses fuzzyfikasi dan inferensi (MIN)
    {
        $predicates = [];
        foreach ($this->rules as $key => $rule) {
            /** @var Himpunan $modal */
            $modal = $rule['modal'];
            $indexModal = $modal->getY($this->var1); // harga_modal

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

            $index1 = number_format($indexModal, 2, ',', '.');
            $index2 = number_format($indexUntung, 2, ',', '.');
            $index3 = number_format($predicate, 2, ',', '.');
            $predicates[] = 'α-predikat' . ($key + 1)
                . ' = ' . 'min(' . $index1 . '; ' . $index2 . ')'
                . ' = ' . $index3;
        }

        $this->list_step['predicates'] = $predicates;
    }

    private function prepareAggregates(): void
    {
        $aggregates = [];
        foreach ($this->predicates as $predicate) {
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

        $predicates = [];
        foreach ($this->predicates as $predicate) {
            $predicates[] = number_format($predicate['value'], 2, ',', '.');
        }
        $this->list_step['aggregates'] = [
            'μ ' . $this->diskon->nama . ' ' . $this->diskon->list_himpunan[0]->nama
            . ' = ' . 'max(α1;α3)'
            . ' = ' . 'max(' . $predicates[0] . '; ' . $predicates[2] . ')'
            . ' = ' . max($predicates[0], $predicates[2]),
            'μ ' . $this->diskon->nama . ' ' . $this->diskon->list_himpunan[1]->nama
            . ' = ' . 'max(α2;α4)'
            . ' = ' . 'max(' . $predicates[1] . '; ' . $predicates[3] . ')'
            . ' = ' . max($predicates[1], $predicates[3]),
        ];
    }

    private function prepareT(): void
    {
        $this->t = [];
        foreach ($this->rules as $rule) {
            /** @var Himpunan $diskon */
            $diskon = $rule['diskon'];
            if ($diskon->nama == $this->aggregate->nama) {
                foreach ($this->aggregates as $y) {
                    $this->t[] = $diskon->getX($y);
                }
                break;
            }
        }

        $labels = [];
        $datasets = [];
        /** @var Himpunan $diskon_kecil */
        $diskon_kecil = $this->diskon->list_himpunan[0];
        /** @var Himpunan $diskon_besar */
        $diskon_besar = $this->diskon->list_himpunan[1];
        if ($this->aggregate->nama == $diskon_kecil->nama) {
            $labels[] = $diskon_kecil->p1;
            $datasets[] = $this->aggregates['kecil'];
            foreach ($this->t as $key => $t) {
                $labels[] = $t;
                if ($key == 0) {
                    $datasets[] = $this->aggregates['kecil'];
                } else {
                    $datasets[] = $this->aggregates['besar'];
                }
            }
            $labels[] = count($this->t) > 1 ? $diskon_besar->p4 : $diskon_kecil->p4;
            $datasets[] = count($this->t) > 1 ? $this->aggregates['besar'] : 0;
        }
        if ($this->aggregate->nama == $diskon_besar->nama) {
            $labels[] = count($this->t) > 1 ? $diskon_kecil->p1 : null;
            $datasets[] = count($this->t) > 1 ? $this->aggregates['kecil'] : 0;
            foreach ($this->t as $key => $t) {
                $labels[] = $t;
                if ($key == 0) {
                    $datasets[] = count($this->t) > 1 ? $this->aggregates['kecil'] : $this->aggregates['besar'];
                } else {
                    $datasets[] = $this->aggregates['besar'];
                }
            }
            $labels[] = $diskon_besar->p4;
            $datasets[] = $this->aggregates['besar'];
        }

        $t = $this->t;
        if (count($t) == 1) {
            if ($this->aggregate->nama == $diskon_kecil->nama) {
                $t[] = 0;
            }
            if ($this->aggregate->nama == $diskon_besar->nama) {
                $t1 = $t[0];
                $t = [0, $t1];
            }
        }
        $this->list_step['aggregate'] = [
            't' => $t,
            'chart' => [
                'type' => 'line',
                'data' => [
                    'labels' => array_map(function ($y) {
                        return number_format($y, 2, ',', '.');
                    }, $labels),
                    'datasets' => [
                        [
                            'fill' => true,
                            'label' => $this->diskon->nama . ' ' . $this->aggregate->nama,
                            'data' => array_map(function ($y) {
                                return (float) number_format($y, 2, '.', ',');
                            }, $datasets),
                        ],
                    ],
                ],
                'options' => [
                    'scales' => [
                        'y' => [
                            'min' => 0,
                            'max' => 1,
                        ]
                    ]
                ]
            ],
        ];

        // if ($this->var1 == 35000 && $this->var2 == 1650000) {
        //     dd(array_map(function ($y) {
        //         return number_format($y, 2, ',', '.');
        //     }, $datasets));
        // }
    }

    private function calculateMoment(): int|float
    {
        if (count($this->t) == 1) {
            $a = $this->aggregate->nama == 'kecil' ? 0 : $this->aggregate->p2;
            $b = $this->t[0];
            $t = 1;
            foreach ($this->aggregates as $y) {
                $t = $y;
                break;
            }

            $m1 = $this->calculateIntegralRectangle($a, $b, $t);

            $a = $this->aggregate->nama == 'kecil' ? $this->aggregate->p3 : $this->aggregate->p1;
            $b = $this->aggregate->nama == 'kecil' ? $this->aggregate->p4 : $this->aggregate->p2;
            $t = $this->t[0];
            $s = $this->aggregate->nama == 'kecil' ? 1 : 2;
            $m2 = $this->calculateIntegralTriangle($a, $b, $t, $s);

            $this->list_step['moments'] = [
                $m1,
                $m2,
            ];
            $this->list_step['total_moments'] = $m1 + $m2;

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
        if (count($this->t) == 1) {
            // $a = $this->aggregate->p4 - ($this->aggregate->nama == 'kecil' ? 0 : $this->aggregate->p3);
            $a = $this->aggregate->nama == 'kecil'
                ? $this->aggregate->p4 - $this->t[0]
                : $this->t[0] - $this->aggregate->p1;
            $b = $this->aggregate->nama == 'kecil'
                ? $this->t[0]
                : $this->aggregate->p4 - $this->t[0];
            $t = 1;
            foreach ($this->aggregates as $y) {
                $t = $y;
                break;
            }

            $a1 = $b * $t;
            $a2 = $a * $t / 2;

            $this->list_step['areas'] = [
                $a1,
                $a2,
            ];
            $this->list_step['total_areas'] = $a1 + $a2;

            return $a1 + $a2;
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

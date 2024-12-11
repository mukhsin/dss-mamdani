<?php

namespace App\Fuzzy;

class Variabel
{
    public string $nama;
    public array $list_himpunan;

    /**
     * @param string $nama
     * @param array $arr_himpunan
     */
    public function __construct(string $nama, array $arr_himpunan)
    {
        $this->nama = $nama;
        $this->list_himpunan = $arr_himpunan;
    }

    public function is($nama): Himpunan
    {
        foreach ($this->list_himpunan as $value) {
            /** @var Himpunan $himpunan */
            $himpunan = $value;
            if ($himpunan->nama == $nama) {
                return $himpunan;
            }
        }
        return new Himpunan('', -1, -1, -1, -1);
    }

    public function getPoints(): array
    {
        $points = [];
        foreach ($this->list_himpunan as $value) {
            /** @var Himpunan $himpunan */
            $himpunan = $value;
            if (!in_array($himpunan->p1, $points)) {
                $points[] = $himpunan->p1;
            }
            if (!in_array($himpunan->p2, $points)) {
                $points[] = $himpunan->p2;
            }
            if (!in_array($himpunan->p3, $points)) {
                $points[] = $himpunan->p3;
            }
            if (!in_array($himpunan->p4, $points)) {
                $points[] = $himpunan->p4;
            }
        }

        sort($points);
        return $points;
    }

    public function getDatasets(): array
    {
        $datasets = [];
        foreach ($this->list_himpunan as $value) {
            /** @var Himpunan $himpunan */
            $himpunan = $value;
            $datasets[] = [
                'label' => strtoupper($himpunan->nama),
                'data' => $himpunan->getPoints(),
            ];
        }

        return $datasets;
    }

}

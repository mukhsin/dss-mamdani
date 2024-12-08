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
        foreach ($this->list_himpunan as $key => $value) {
            /** @var Himpunan $himpunan */
            $himpunan = $value;
            if ($himpunan->nama == $nama) {
                return $himpunan;
            }
        }
        return new Himpunan('', -1, -1, -1, -1);
    }

}

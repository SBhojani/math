<?php
/*
 * Copyright (c) 2014 Michel Petit <petit.michel@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Malenki\Math\Stats\NonParametricTest;
use \Malenki\Math\Stats\Stats;

class WilcoxonMannWhitney implements \Countable
{
    protected $arr_samples = array();
    protected $arr_ranks = array();
    protected $u1 = null;
    protected $u2 = null;
    protected $u = null;
    protected $sigma = null;
    protected $mean = null;


    public function __get($name)
    {
        if(in_array($name, array('u1','u2','u', 'sigma', 'mean'))){
            return $this->$name();
        }

        if($name == 'mu'){
            return $this->mean();
        }

        if(in_array($name, array('std', 'stdev', 'stddev'))){
            return $this->sigma();
        }
    }


    public function add($s)
    {
        if(count($this->arr_samples) == 2){
            throw new \RuntimeException(
                'Wilcoxon-Mann-Whitney Test does not use more than two samples!'
            );
        }

        if(is_array($s)){
            $s = new Stats($s);
        } elseif(!($s instanceof Stats))
        {
            throw new \InvalidArgumentException(
                'Added sample to Wilcoxon-Mann-Whitney test must be array or Stats instance'
            );
        }

        $this->arr_samples[] = $s;
        $this->clear();

        return $this;
    }

    public function set($sampleOne, $sampleTwo)
    {
        $this->add($sampleOne);
        $this->add($sampleTwo);

        return $this;
    }

    public function clear()
    {
        //TODO
    }

    public function count()
    {
        return 0;
    }

    protected function compute()
    {
        if(is_null($this->u1) || is_null($this->u2)){
            $n1 = count($this->arr_samples[0]);
            $n2 = count($this->arr_samples[1]);
            $this->computeRanks();
            $r1 = $this->arr_samples[0]->sum; //FIXME Not that!
            $r2 = $this->arr_samples[1]->sum; //FIXME Not that!
            $this->u1 =  $n1 * $n2 + ( 0.5 * $n1 * ($n1 + 1)) - $r1;
            $this->u2 =  $n1 * $n2 + ( 0.5 * $n2 * ($n2 + 1)) - $r2;
            $this->u = min($this->u1(), $this->u2());
            $this->mean = 0.5 * $n1 * $n2;
            $this->sigma = sqrt($n1 * $n2 * ($n1 + $n2 + 1) / 12);
        }
    }

    /**
     * @todo
     */
    protected function computeRanks()
    {
        $int_size = max(
            count($this->arr_samples[0]),
            count($this->arr_samples[1])
        );

        $prev = null;
        $stats = null;

        for($i = 0; $i < $int_max; $i++){
/*
            $x1 = $this->arr_samples[0]->get($i);
            $x2 = $this->arr_samples[1]->get($i);

            if($x1 == $prev){

                if(is_null($stats)){
                    $stats = new \Malenki\Math\Stats\Stats();
                    $stats->add($i - 1);
                }
             
                $stats->add($i);
                
            } else {
                if(!is_null($stats)){
                    foreach($this->arr_ranks as $ri => $rv){
                        if(in_array($rv, $stats->array)){
                            $this->arr_ranks[$ri] = $stats->mean;
                            $this->arr_signed_ranks[$ri] = $stats->mean * $this->arr_signs[$ri];
                        }
                    }
                    $stats = null;
                }
            }

            $this->arr_ranks[$k] = $i;
            $this->arr_signed_ranks[$k] = $i * $this->arr_signs[$k];

            $prev = $c;
            $i++;
 */
        }


        /*
        if(!is_null($stats)){
            foreach($this->arr_ranks as $ri => $rv){
                if(in_array($rv, $stats->array)){
                    $this->arr_ranks[$ri] = $stats->mean;
                    $this->arr_signed_ranks[$ri] = $stats->mean * $this->arr_signs[$ri];
                }
            }
        }

        $this->arr_ranks = array_filter($this->arr_ranks);
         */
    }

    public function u1()
    {
        $this->compute();

        return $this->u1;
    }

    public function u2()
    {
        $this->compute();

        return $this->u2;
    }

    public function u()
    {
        $this->compute();
        return $this->u;
    }

    public function sigma()
    {
        $this->compute();

        return $this->sigma;
    }

    public function mean()
    {
        $this->compute();

        return $this->mean;
    }
}

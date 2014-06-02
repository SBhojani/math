<?php
/*
Copyright (c) 2014 Michel Petit <petit.michel@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

use Malenki\Math\Stats\NonParametricTest\KruskalWallis;
use Malenki\Math\Stats\Stats;

class KruskalWallisTest extends PHPUnit_Framework_TestCase
{
    public function testInstanciateKWTShouldSuccess()
    {
        $k = new KruskalWallis();
        $this->assertInstanceOf(
            '\Malenki\Math\Stats\NonParametricTest\KruskalWallis',
            $k
        );
    }
    
    public function testAddingSamplesShouldSuccess()
    {
        $k = new KruskalWallis();
        $k->add(new Stats(array(1, 2, 3)));
        $this->assertInstanceOf(
            '\Malenki\Math\Stats\NonParametricTest\KruskalWallis',
            $k->add(new Stats(array(6, 3, 4)))
        );
        
        $k = new KruskalWallis();
        $this->assertInstanceOf(
            '\Malenki\Math\Stats\NonParametricTest\KruskalWallis',
            $k->add(array(6, 3, 4))->add(array(7, 5, 9))->add(array(7,3,1,5))
        );
        
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddingWrongTypeSamplesShouldFail()
    {
        $k = new KruskalWallis();
        $k->add(3);
    }

    public function testGettingTotalAmountShouldSuccess()
    {
        $k = new KruskalWallis();
        $k->add(array(6, 3, 4))->add(array(7, 5, 9))->add(array(7,3,1,5));
        $this->assertCount(10, $k);
    }


    public function testGettingRankSumsShouldSuccess()
    {
        // taken from http://www.brightstat.com/index.php?option=com_content&task=view&id=41&Itemid=1&limit=1&limitstart=2
        $k = new KruskalWallis();
        $k->add(array(68, 93, 123, 83, 108, 122));
        $k->add(array(119, 116, 101, 103, 113, 84));
        $k->add(array(70, 68, 54, 73, 81, 68));
        $k->add(array(61, 54, 59, 67, 59, 70));

        //$k->rankSum(0);
        //var_dump($k);
        $this->markTestIncomplete();
        $this->assignEquals(104, $k->rankSum(1));
        $this->assignEquals(113, $k->rankSum(2));
        $this->assignEquals(53, $k->rankSum(3));
        $this->assignEquals(30, $k->rankSum(4));
    }

    public function testGettingRankMeansShouldSuccess()
    {
        // taken from http://www.brightstat.com/index.php?option=com_content&task=view&id=41&Itemid=1&limit=1&limitstart=2
        $k = new KruskalWallis();
        $k->add(array(68, 93, 123, 83, 108, 122));
        $k->add(array(119, 116, 101, 103, 113, 84));
        $k->add(array(70, 68, 54, 73, 81, 68));
        $k->add(array(61, 54, 59, 67, 59, 70));

        $this->markTestIncomplete();
        $this->assignEquals(17.33, $k->rankMean(1));
        $this->assignEquals(18.83, $k->rankMean(2));
        $this->assignEquals(8.83, $k->rankMean(3));
        $this->assignEquals(5, $k->rankMean(4));
    }
}

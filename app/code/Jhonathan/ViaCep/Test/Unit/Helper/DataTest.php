<?php
/**
 * @author Jhonathan da silva
 * @link https://github.com/jhonathan93
 * @link https://www.linkedin.com/in/jhonathan-silva-367541171/
 * @package Jhonathan_ViaCep
 */

namespace Jhonathan\ViaCep\Test\Unit\Helper;

use PHPUnit_Framework_MockObject_MockObject;
use Jhonathan\ViaCep\Helper\Data;
use PHPUnit\Framework\TestCase;

use Exception;

/**
 * Class DataTest
 * @package Jhonathan\ViaCep\Test\Unit\Helper
 */
class DataTest extends TestCase {

    /**
     * @var Data|PHPUnit_Framework_MockObject_MockObject
     */
    private $data;

    /**
     * @return void
     */
    public function setUp(): void {
        $this->data = $this->getMockBuilder(Data::class)
        ->disableOriginalConstructor()
        ->getMock();
    }

    /**
     * @return void
     */
    public function testRequest(): void {
        try {
            $this->assertEquals('teste', $this->data->request('86037752'));
        } catch (Exception $e) {

        }
    }
}

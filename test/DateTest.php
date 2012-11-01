<?php
require '../Shamsi/Date.php';

date_default_timezone_set('Asia/Tehran'); 
class DateTest extends PHPUnit_Framework_TestCase
{
    public function testDateFunc()
    {
        //$this->markTestSkipped();
        $result = \Shamsi\date('l S F Y H:i:s a T', 1324146714);
        $this->assertEquals('شنبه بیست و ششم آذر ۱۳۹۰ ۲۲:۰۱:۵۴ ب.ظ IRST', $result);
    }

    public function testMktime()
    {
        $result = \Shamsi\mktime(1383, 10, 12);
        $this->assertEquals(1104525000, $result);
    }

    public function testStrtotime()
    {
        $timestamp = \strtotime('+1 week');
        $result = \Shamsi\date('l S F Y H:i:s', $timestamp); 
    }
}

<?php
require_once('PHPUnit/Autoload.php');
require_once('PHPUnit/Util/Log/JUnit.php');

function bfglob($path, $pattern = '*', $flags = 0, $depth = 0) {
  $matches = array();
  $folders = array(rtrim($path, DIRECTORY_SEPARATOR));

  while($folder = array_shift($folders)) {
    $matches = array_merge($matches, glob($folder.DIRECTORY_SEPARATOR.$pattern, $flags));
    if($depth != 0) {
      $moreFolders = glob($folder.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
      $depth   = ($depth < -1) ? -1: $depth + count($moreFolders) - 2;
      $folders = array_merge($folders, $moreFolders);
    }
  }
  return $matches;
}

class SPTestRunner{
  public static function run(){
    // Create the test suite instance
    $suite = new PHPUnit_Framework_TestSuite();
    $suite->setName('SPTestRunner');

    $filenames = bfglob(__DIR__,"*Test.php",0,-1);
    // Add files to the TestSuite
    $suite->addTestFiles($filenames);

    // Create a xml listener object
    $listener = new PHPUnit_Util_Log_JUnit;

    // Create TestResult object and pass the xml listener to it
    $testResult = new PHPUnit_Framework_TestResult();
    $testResult->addListener($listener);

    // Run the TestSuite
    $result = $suite->run($testResult);

    // Get the results from the listener
    $xml_result = $listener->getXML();
    return $xml_result;
  }
}

$test_xml = SPTestRunner::run();
$simple = new SimpleXMLElement($test_xml);

$test_results = array();
$assertions = 0;
$time = 0.0;
$tests = 0;
foreach($simple->{'testsuite'}->testsuite as $testsuite){
  foreach($testsuite->testcase as $testcase){
    $result = array();
    $tests += 1;
    // Don't froget to cast SimpleXMLElement to string!
    $result['name'] = (string)$testcase['name'];
    $result['suite'] = (string)$testcase['class'];
    $assertions += $result['assertions'] = (string)$testcase['assertions'];
    $time += $result['time'] = (string)$testcase['time'];
    if(isset($testcase->{'failure'})){
      $result['result'] = 'Fail';
      $result['message'] = (string)$testcase->{'failure'};
    }else{
      $result['result'] = 'Pass';
      $result['message'] = '';
    }
    $test_results[] = $result;
  }
}
?>
<style type="text/css">
body{
  background:#333;
  font-family:Helvetica;
  font-size:11px;
}
table{
  width:90%;
  margin:0px auto;
  font-size:12px;
}

table th{
  text-align:left;
  background:#aaa;
  padding:4px;
}

table td{
  background:#fff;
  padding:4px;
  border-bottom:1px solid #999;
}

table td.test_pass{
  color:#3a3;
  text-transform:uppercase;
  font-weight:bold;
}

table td.test_fail{
  color:#a33;
  text-transform:uppercase;
  font-weight:bold;
}

tr.totals td{
  font-weight:bold;
  font-size:14px;
}

pre{
  background:#eee;
}
</style>
<table class="test_results" cellspacing="0">
<thead>
<tr>
<th>Suite</th>
<th>Test Name</th>
<th>Result</th>
<th>Message</th>
<th>Assertions</th>
<th>Time</th>
</tr>
</thead>
<tbody>
  <?php foreach($test_results as $test_result): ?>
<tr>
<td><?php echo $test_result['suite'] ?></td>
<td><?php echo $test_result['name'] ?></td>

      <?php if($test_result['result'] == 'Fail') : ?>
<td class="test_fail">Fail</td>

      <?php else: ?> 
<td class="test_pass">Pass</td>

      <?php endif; ?>
<td><?php echo $test_result['message'] ?></td>
<td><?php echo $test_result['assertions'] ?></td>
<td><?php echo $test_result['time'] ?></td>
</tr>

  <?php endforeach; ?>
<tr class="totals">
<td colspan="3"></td>
<td><?php echo $tests ?> TESTS</td>
<td><?php echo $assertions ?> ASSERTIONS</td>
<td><?php echo $time ?> SEC</td>
</tr>
</tbody>
</table>

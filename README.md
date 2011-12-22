##Description
This package provides an exact scientific approach to create Jalali(Shamsi) calendar with an interface similar to php [date()](http://www.php.net/manual/en/function.date.php)

###How to instantiate the class
The main class can be instantiated in three ways:

Without any parameters: 
    $date = new \Shamsi\Date();
With a timestamp:
    $date = new \Shamsi\Date(1324499150);
With year, month, day, hour, minute and second, the same format used by php [mktime()](http://www.php.net/manual/en/function.mktime.php):
    $date = new \Shamsi\Date(1383, 12, 30, 13, 45, 25);

###Public methods
    
    string format(string format[, int timestamp [, boolean decorate]])  //set decorate to true in order to use Persian numbers/strings
    int mktime(int year, int month, int day[, int hour[, int minute[, int second]]])
    int getTimestamp()

###Functions
    \Shamsi\date(string format[, int timestamp [, boolean decorate]]) 
    \Shamsi\mktime(int year, int month, int day[, int hour[, int minute[, int second]]])

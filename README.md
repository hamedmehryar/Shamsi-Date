##Description
This package provides an exact scientific approach to create Jalali(Shamsi) calendar with an interface similar to php [date()](http://www.php.net/manual/en/function.date.php)

###How to instantiate the class
The main class can be instantiated in three ways:

    $date = new \Shamsi\Date();
    $date = new \Shamsi\Date(1324499150);   //with timestamp
    $date = new \Shamsi\Date(1383, 12, 30, 13, 45, 25); //with year, month, day, hour, minute and second parameters

###Public methods
    
    string format(string format[, int timestamp [, boolean decorate]])  //use decorate to use Persian numbers/strings
    int mktime(int year, int month, int day[, int hour[, int minute[, int second]]])
    int getTimestamp()

###Functions
    \Shamsi\date(string format[, int timestamp [, boolean decorate]]) 
    \Shamsi\mktime(int year, int month, int day[, int hour[, int minute[, int second]]])

# tech-test
PHP Tech Test

## How to run
Run `composer install`  
Run tests with `./vendor/bin/phpunit tests`  
Run command with `php src/main.php --filename='../../Downloads/example-input' --day=17/03/20 --time=06:51 --location=NW43QB --covers=20`

## Assumptions
I assumed that the Postcode location is first 2 chars, I guess it could mean only first char if the postcode was N,E,W or S. In that case, I would use a regex to test rather than sub_str  
I assumed that all the data was valid. Given more time, I would introduce data validation and error handling.  
I assumed that vendor/item info was not duplicated.  
I assumed the process was short lived, therefore creating a constant $now variable was safe to do.  
I assumed availability is always in hours and that the date passed in is never over a month in the future. I would use Carbon or Chronos to handle dates if I was allowed.  
I assumed the dataset was small enough to handle in memory and there was no need to persist or stream it.

## What else I could do
There are many more tests that could be written. Some unit, some integration. I think what is here is mainly sufficient.  
There are some micro optimizations that could be made, but it would probably impact code readability.  
Given more time the app could probably be structured even better to allow export to `echo`, CSV, text file etc....

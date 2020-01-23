# General
Sample simplistic calculator app.

# Install

Clone the repo:
```
$ cd /where/needed/www/apps
$ git clone git@github.com:mlinuxgada/sample-calculator.git
```

Copy the sample config, and add needed adjustments if needed:
```
$ cd /to/cloned/repo
$ cp config/config.php.example config/config.php
```

# Routes

Open/Render calc input page: http://whatever.app.address/calculator

# Unit Tests

Test coverage on the Calculator Service. Run as usual:
```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/CalculatorTest.php
```

Enjoy ;-)

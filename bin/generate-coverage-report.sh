#!/usr/bin/env bash

vendor/bin/tester -j 1 -c tests/php-coverage.ini --coverage docs/coverage.html --coverage-src src/ tests/

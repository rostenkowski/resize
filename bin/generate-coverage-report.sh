#!/usr/bin/env bash

vendor/bin/tester -j 1 -c tests/php.ini --coverage docs/code-coverage.html --coverage-src src/ tests/

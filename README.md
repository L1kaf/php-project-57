### Hexlet tests and linter status:
[![Actions Status](https://github.com/L1kaf/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/L1kaf/php-project-57/actions)
[![Tests and Linter](https://github.com/L1kaf/php-project-57/actions/workflows/main.yml/badge.svg)](https://github.com/L1kaf/php-project-57/actions/workflows/main.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/7b914568e34396e05f3a/maintainability)](https://codeclimate.com/github/L1kaf/php-project-57/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/7b914568e34396e05f3a/test_coverage)](https://codeclimate.com/github/L1kaf/php-project-57/test_coverage)

### Description:
---
This repository contains the implementation of the fourth project of the Hexlet learning portal: Task Manager!

Task Manager is a task management system similar to http://www.redmine.org/. It allows you to set tasks, assign executors and change their statuses. Registration and authentication are required to work with the system. Only authenticated users are authorized to create and edit tasks. Once a task is established and appears in the overall list, it can be edited and its status updated by all users, but only the original creator has the ability to delete it.

Stack used: PHP/Laravel/Blade/Eloquent. Registration and authentication is done using Breeze (when resetting user password email is not sent to real address, instead mailtrap.io service is used). Styling - Tailwind CSS.

Demo: https://php-project-57-pizh.onrender.com/

### System Requirements:
---
* PHP version 8+
* Composer

### Usage:
---
```bash
make setup
make start
```
Open in browser: http://0.0.0.0:8000


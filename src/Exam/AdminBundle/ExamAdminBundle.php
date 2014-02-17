<?php

namespace Exam\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExamAdminBundle extends Bundle {
    public function __construct() {
        if(!defined('BUNDLE_SEPARATOR')) define('BUNDLE_SEPARATOR', ':');
    }
}
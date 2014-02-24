<?php

namespace Exam\AopBundle\ValidateExamPackage;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Exam\WebBundle\Service\EnrollmentService;
use Exam\AopBundle\Transactional;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Inject;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class ValidateExamPackageInterceptor
 * @package Exam\AopBundle
 * @Service("validate_interceptor")
 */
class ValidateExamPackageInterceptor implements MethodInterceptorInterface {
    private $enrollService, $container;
    /**
     * @InjectParams({
     *      "enrollService" = @Inject("enrollmentService")
     * })
     */
    public function __construct(EnrollmentService $enrollService) {
        $this->enrollService = $enrollService;
    }

    /**
     * Called when intercepting a method call.
     *
     * @param MethodInvocation $invocation
     * @return mixed the return value for the method invocation
     * @throws \Exception may throw any exception
     */
    function intercept(MethodInvocation $invocation)
    {
        $this->enrollService->validateEnrollmentTime();

        $result = $invocation->proceed();

        return $result;
    }
}
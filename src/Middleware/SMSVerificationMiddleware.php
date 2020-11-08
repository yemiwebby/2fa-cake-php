<?php
declare(strict_types=1);

namespace App\Middleware;

use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SMSVerificationMiddleware implements MiddlewareInterface
{
    private array $permittedRoutes = [
        '/verification',
        '/users/login',
        '/'
    ];

    /**
     * Process method.
     *
     * @param ServerRequestInterface $request The request.
     * @param RequestHandlerInterface $handler The request handler.
     * @return ResponseInterface A response.
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $cookieParams = $request->getCookieParams();
        if ($this->shouldRedirectToVerificationController($path, $cookieParams)) {
            return new RedirectResponse('/verification');
        }
        return $handler->handle($request);
    }

    private function shouldRedirectToVerificationController(
        string $path,
        array $cookieParams
    ): bool
    {
        $hasValidVerificationCookie = isset($cookieParams['2-fa-passed']) ?
            $cookieParams['2-fa-passed'] === '1' : false;
        $isAllowedRoute = in_array($path, $this->permittedRoutes);
        return !($isAllowedRoute || $hasValidVerificationCookie);
    }
}

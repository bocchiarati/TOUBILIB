<?php

namespace toubilib\api\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use toubilib\api\dtos\InputAuthnDTO;
use function DI\string;

class AuthnSigninValidationMiddleware {
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface {
        $data = $request->getQueryParams();
        $data["email"] = isset($data["email"]) ? strval($data["email"]) : "";
        $data["password"] = isset($data["password"]) ? strval($data["password"]) : "";

        try {
            v::key('email', v::stringType()->notEmpty())
                ->key('password', v::stringType()->notEmpty())
            ->assert($data);

        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($request, "Invalid data: " . $e->getFullMessage(), $e);
        }

        $authnDTO = new InputAuthnDTO($data);
        $request = $request->withAttribute('auth_dto', $authnDTO);

        return $next->handle($request);
    }
}
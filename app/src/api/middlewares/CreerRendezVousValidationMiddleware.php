<?php

namespace toubilib\api\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use toubilib\api\dtos\InputRendezVousDTO;

class CreerRendezVousValidationMiddleware {
    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next) : ResponseInterface {
        $data = RouteContext::fromRequest($request)
            ->getRoute()
            ->getArguments() ?? null;

        $data["duree"] = intval($data["duree"]);
        try {
            v::key('duree', v::intType())
                ->key('motif', v::stringType()->notEmpty())
                ->key('date_heure_debut', v::stringType()->notEmpty())
                ->key('date_heure_fin', v::stringType()->notEmpty())
                ->key('id_pat', v::stringType()->notEmpty())
                ->key('id_prat', v::stringType()->notEmpty())
            ->assert($data);
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($request, "Invalid data: " . $e->getFullMessage(), $e);
        }

        $rdvDTO = new InputRendezVousDTO($data);
        $request = $request->withAttribute('rdv_dto', $rdvDTO);

        return $next->handle($request);
    }
}
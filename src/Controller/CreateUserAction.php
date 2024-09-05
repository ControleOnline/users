<?php

namespace ControleOnline\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ControleOnline\Service\HydratorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ControleOnline\Entity\UserService;

class CreateUserAction
{

  public function __construct(
    private EntityManagerInterface $manager,
    private UserService $service,
    private HydratorService $hydratorService

  ) {}

  public function __invoke(Request $request)
  {

    try {
      $payload   = json_decode($request->getContent());
      return new JsonResponse($this->hydratorService->result(
        $this->service->createUser(
          $payload->people,
          $payload->username,
          $payload->password
        )
      ));
    } catch (\Exception $e) {

      return new JsonResponse([
        'response' => [
          'data'    => [],
          'count'   => 0,
          'error'   => $e->getMessage(),
          'success' => false,
        ],
      ], 500);
    }
  }
}

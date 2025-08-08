<?php

namespace App\Controller\CustomerOrder;

use App\Controller\BaseApiController;
use App\Dto\CustomerOrder\CreateCustomerOrderDto;
use App\Exception\ValidationException;
use App\Message\NotifyContractorsMessage;
use App\Service\CustomerOrder\CreateCustomerOrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api/order', name: 'createCustomerOrder', methods: ['POST'])]
class CreateCustomerOrderController extends BaseApiController
{
    public function __invoke(Request $request, CreateCustomerOrderService $customerOrderService, MessageBusInterface $bus): JsonResponse
    {
        try {

            $createCustomerOrderDto = $this->serializer->deserialize($request->getContent(), CreateCustomerOrderDto::class, 'json');

            $customerOrderId = $customerOrderService->createCustomerOrder($createCustomerOrderDto);

            $bus->dispatch(new NotifyContractorsMessage($customerOrderId));

            $serializedCustomerOrder = $this->serializer->serialize($createCustomerOrderDto, 'json');

        } catch (ExceptionInterface $e) {
            $this->logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (ValidationException|NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["errors" => json_decode($e->getMessage() , true)], 422);
        }

        return new JsonResponse($serializedCustomerOrder, 201, [], true);
    }
}

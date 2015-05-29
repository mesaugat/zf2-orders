<?php

namespace Order\Api\V1\Controller;

use Foundation\AbstractRestController;
use Foundation\Exception\BadRequestException;
use Foundation\Exception\ValidationException;
use Foundation\Misc\JsonResponse;
use Order\Service\ItemService;

class ItemController extends AbstractRestController
{
    const BASE_URI = '/api/v1/items';

    public function __construct(ItemService $service)
    {
        $this->service = $service;
    }

    public function getList()
    {
        $request = $this->getRequest();
        $result = $this->service->fetchList($request->getQuery(), [
            'baseUri' => self::BASE_URI
        ]);

        return [
            'data' => $this->service->extractList($result['items']),
            'total' => $result['total'],
            'results_per_page' => $result['max'],
            'no_of_pages' => $result['noOfPages'],
            'current_page' => $result['page'],
            'links' => $result['links']
        ];
    }

    public function get($id)
    {
        return $this->service->fetch($id);
    }

    public function create($data)
    {
        $data['id'] = 0;
        try {
            $entity = $this->service->save($data);

            // created successfully
            return new JsonResponse([
                'id' => $entity->getId(),
                'link' => $this->getRequest()->getUri()->getPath() . '/' . $entity->getId()
            ], 201);
        } catch (ValidationException $e) {
            $messages = $e->getValidationMessages();
            $firstField = key($messages);
            $firstMessage = array_shift($messages[$firstField]);

            $firstMessage = sprintf("'%s' %s", $firstField, strtolower($firstMessage));
            throw new BadRequestException($firstMessage);
        }
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        try {
            $this->service->save($data);

            // Updated successfully
            return new JsonResponse(null, 204);
        } catch (ValidationException $e) {
            $messages = $e->getValidationMessages();
            $firstField = key($messages);
            $firstMessage = array_shift($messages[$firstField]);

            $firstMessage = sprintf("'%s' %s", $firstField, strtolower($firstMessage));
            throw new BadRequestException($firstMessage);
        }
    }

    public function delete($id)
    {
        $this->service->remove($id);

        // Deleted successfully
        return new JsonResponse(null, 204);
    }

}

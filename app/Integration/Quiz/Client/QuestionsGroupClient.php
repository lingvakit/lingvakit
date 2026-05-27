<?php
declare(strict_types=1);

namespace App\Integration\Quiz\Client;

use App\Application\Quiz\Dto\QuestionsGroup\Request\QuestionsGroupCreateDto;
use App\Integration\Quiz\Dto\Response\QuestionsGroupDto;
use App\Integration\Quiz\Mapper\QuestionsGroupMapper;

class QuestionsGroupClient extends BaseClient implements QuestionsGroupServiceInterface
{
    public function __construct(
        private readonly QuestionsGroupMapper $mapper
    ) {
    }

    public function create(
        QuestionsGroupCreateDto $requestDto
    ): QuestionsGroupDto {
        $response = $this->http()->post(
            url: "{$this->getMsUrl()}/api/v1/questionGroups",
            data: $requestDto->convertToArray()
        );

        return $this->handleResponse(
            $response,
            fn(array $responseData) => $this->mapper->fromResponseDataToDto($responseData)
        );
    }
}

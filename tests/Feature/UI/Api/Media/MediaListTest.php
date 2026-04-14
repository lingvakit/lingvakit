<?php
declare(strict_types=1);

namespace Feature\UI\Api\Media;

use App\Models\User;
use Tests\TestCase;

class MediaListTest extends TestCase
{
    private const string MEDIA_LIST_ENDPOINT = '/react/api/media';

    public function testGuestCannotGetMediaList(): void
    {
        $response = $this->getJson(self::MEDIA_LIST_ENDPOINT);

        $response->assertUnauthorized();
    }

    public function testAuthenticatedUserCanGetMediaList(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(self::MEDIA_LIST_ENDPOINT);

        $response->assertOk();
    }
}

<?php

namespace App\Utils\Enums;

enum PostTypeEnum: string
{
    case POST_TILE_TYPE = 'POST_TILE_TYPE';
    case POST_FEED_TYPE = 'POST_FEED_TYPE';
    case POST_STORY_TYPE = 'POST_STORY_TYPE';
    case POST_WELL_TYPE = 'POST_WELL_TYPE';
}

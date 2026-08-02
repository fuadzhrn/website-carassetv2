<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Content Workflow (Draft / Preview / Publish / Revisions)
|--------------------------------------------------------------------------
|
| Technical limits for the Draft/Preview/Publish/Revision system —
| tunable without touching controllers/services.
|
*/

return [
    'preview_expiration_minutes' => 30,
    'revision_pagination' => 20,
];

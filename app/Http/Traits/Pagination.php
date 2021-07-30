<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait Pagination
{
    public function paginate(Request $request): array
    {
        $limit = 0;
        $offset = 0;

        if ($request->has('limit')) {
            $limit = $request->query('limit');
        }

        if ($request->has('offset')) {
            $offset = $request->query('offset');
        }

        return ["limit" => $limit, "offset" => $offset];
    }
}

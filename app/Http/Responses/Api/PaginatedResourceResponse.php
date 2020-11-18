<?php

namespace App\Http\Responses\Api;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as BasePaginatedResourceResponse;

class PaginatedResourceResponse extends BasePaginatedResourceResponse
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function getPagination($request)
    {
        return $this->paginationInformation($request);
    }


}

<?php


namespace App\Http\Responses\Api;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class Response implements Responsable
{

    /**
     * @var int
     */
    protected $status;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var int
     */
    protected $options;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var mixed
     */
    protected $pagination;

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var mixed
     */
    protected $validation;

    /**
     * @var mixed
     */
    protected $backtrace;

    /**
     * @var mixed
     */
    protected $eventId;

    /**
     * JsonResponse constructor.
     *
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     */
    public function __construct($data = null, $status = 200, array $headers = [], $options = 0)
    {
        $this->status  = $status;
        $this->headers = $headers;
        $this->options = $options;
        $this->data    = $data;
    }

    /**
     * @param null  $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return Response
     */
    public static function make($data = null, $status = 200, array $headers = [], $options = 0): Response
    {
        return new static($data, $status, $headers, $options);
    }



    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $additional = [];
        if ($this->data instanceof ResourceCollection) {
            if ($this->data->resource instanceof AbstractPaginator) {
                $this->pagination = (new PaginatedResourceResponse($this->data))->getPagination($request);
            }
        }


        if ($this->data instanceof JsonResource) {
            $this->data = array_replace(
                $this->data->resolve($request),
                $this->data->with($request),
                $this->data->additional
            );
        }

        $data = [];

        if ($this->status === 200) {
            if (!empty($this->pagination)) {
                $data['data']     = $this->data;
                $data['pagination'] = $this->pagination;
            } else {
                $data['data'] = $this->data;
            }
        }

        if (!empty($this->messages)) {
            $data['messages'] = $this->messages;
        }

        if (!empty($this->validation)) {
            $data['validation'] = $this->validation;
        }

        if (!empty($this->backtrace)) {
            $data['backtrace'] = $this->backtrace;
        }

        if (!empty($this->backtrace)) {
            $data['eventId'] = $this->eventId;
        }

        $data = array_merge($data, $additional);

        $response = new JsonResponse($data, $this->status, $this->headers, $this->options);

        return $response;
    }
}

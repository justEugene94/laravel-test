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
     * @param string $text
     * @param mixed  $code
     *
     * @return \App\Http\Responses\Api\Response
     */
    public function addErrorMessage(string $text, $code = 0): Response
    {
        return $this->addMessage('error', $text, $code);
    }

    /**
     * @param string $severity
     * @param string $text
     * @param mixed  $code
     * @return \App\Http\Responses\Api\Response
     */
    public function addMessage(string $severity, string $text, $code = 0): Response
    {
        $message = [
            'severity' => $severity,
            'text'     => $text,
            'code'     => $code,
        ];

        $this->messages[] = $message;

        return $this;
    }

    /**
     * @param string $text
     * @param mixed  $code
     *
     * @return \App\Http\Responses\Api\Response
     */
    public function addSuccessMessage(string $text, $code = 0): Response
    {
        return $this->addMessage('success', $text, $code);
    }

    /**
     * @param null $messages
     *
     * @return $this
     */
    public function addValidationErrors($messages = null): Response
    {
        $this->validation[] = $messages;

        return $this;
    }

    /**
     * @param int $status
     * @return \App\Http\Responses\Api\Response
     */
    public function setStatusCode(int $status): Response
    {
        $this->status = $status;

        return $this;
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

        $data = array_merge($data, $additional);

        $response = new JsonResponse($data, $this->status, $this->headers, $this->options);

        return $response;
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class PohException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Model|null $for
     * @param \Throwable|null $previous
     * @noinspection PhpMissingParamTypeInspection
     */
    public function __construct(
        protected             $message,
        protected ?Model      $for = null,
        protected             $code = Response::HTTP_BAD_REQUEST,
        protected ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}

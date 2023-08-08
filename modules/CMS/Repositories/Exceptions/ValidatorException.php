<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Repositories\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\MessageBag;

class ValidatorException extends \Exception implements Jsonable, Arrayable
{
    /**
     * @var MessageBag
     */
    protected MessageBag $messageBag;

    /**
     * @param  MessageBag  $messageBag
     */
    public function __construct(MessageBag $messageBag)
    {
        $this->messageBag = $messageBag;
    }

    /**
     * @return MessageBag
     */
    public function getMessageBag()
    {
        return $this->messageBag;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'error' => 'validation_exception',
            'error_description' => $this->getMessageBag()
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}

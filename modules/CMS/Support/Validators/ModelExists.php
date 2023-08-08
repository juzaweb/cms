<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Validators;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class ModelExists implements Rule
{
    /**
     * @var string
     */
    private $modelClass;

    /**
     * @var string
     */
    private $modelAttribute;

    /**
     * @var callable
     */
    private $closure;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(string $modelClass, string $modelAttribute = 'id', callable $closure = null)
    {
        $this->modelClass = $modelClass;
        $this->modelAttribute = $modelAttribute;
        $this->closure = $closure ?? function () {
        };
    }

    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;

        return $this->modelClass::query()
            ->when(
                is_array($value),
                function (Builder $query) {
                    $query->whereIn($this->modelAttribute, $this->value);
                },
                function (Builder $query) {
                    $query->where($this->modelAttribute, $this->value);
                }
            )
            ->tap($this->closure)
            ->exists();
    }

    public function message(): string
    {
        return trans(
            'validation.model_exists',
            [
                'attribute' => $this->attribute,
                'value' => $this->value,
                'model' => class_basename($this->modelClass),
                'model_attribute' => $this->modelAttribute,
            ]
        );
    }
}

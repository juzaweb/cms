<?php
// @phpcs:disabled

namespace Illuminate\Database\Eloquent {

    /**
     * @method $this cacheFor($time)
     * @method $this joinRelationship($relationName, $callback = null, $joinType = 'join', $useAlias = false, bool $disableExtraConditions = false)
     * @method $this joinRelationshipUsingAlias($relationName, $callback = null, bool $disableExtraConditions = false)
     * @method void ddRawSql()
     * @method void toRawSql()
     */
    class Builder
    {

    }
}

namespace Illuminate\Database\Query {
    /**
     * @method $this joinRelationship($relationName, $callback = null, $joinType = 'join', $useAlias = false, bool $disableExtraConditions = false)
     * @method $this joinRelationshipUsingAlias($relationName, $callback = null, bool $disableExtraConditions = false)
     * @method void ddRawSql()
     * @method void toRawSql()
     */
    class Builder
    {
    }
}

namespace TwigBridge\Facade {

    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;

    /**
     * @method static Factory|View|string display(string $view, array $params = [])
     */
    class Twig {}
}



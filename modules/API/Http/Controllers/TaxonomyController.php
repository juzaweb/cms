<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\CMS\Http\Controllers\ApiController;

class TaxonomyController extends ApiController
{
    public function __construct(protected TaxonomyRepository $taxonomyRepository)
    {
    }
    
    public function index(Request $request)
    {
        //
    }
    
    public function show()
    {
        //
    }
}

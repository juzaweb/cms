<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/19/2021
 * Time: 10:34 PM
 */

namespace Mymo\Tests\Feature\Backend;

use Illuminate\Support\Facades\Auth;
use Mymo\Core\Facades\HookAction;
use Mymo\Core\Models\User;
use Mymo\PostType\PostType;
use Tests\TestCase;

class PostTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::find(1);
        Auth::loginUsingId($this->user->id);
    }

    public function testIndex()
    {
        $response = $this->get('/admin-cp/posts');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get('/admin-cp/posts/create');

        $response->assertStatus(200);
    }


}
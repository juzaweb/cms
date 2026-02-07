<?php

namespace Juzaweb\Themes\Itech\Tests\Unit;

use Juzaweb\Themes\Itech\Tests\TestCase;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class CommentSecurityTest extends TestCase
{
    public function test_comment_list_escapes_html_and_preserves_newlines()
    {
        $maliciousContent = "<script>alert('xss')</script>\nLine 2";

        // Mock a comment object
        $comment = new \stdClass();
        $comment->name = 'Hacker';
        $comment->created_at = Carbon::now();
        $comment->content = $maliciousContent;
        $comment->children = [];

        $comments = collect([$comment]);

        $rendered = View::make('itech::blog.components.comment-list', ['comments' => $comments])->render();

        // Check for double escaping or lack of escaping.
        // Expectation (after fix):
        // - Escaped HTML: "&lt;script&gt;"
        // - Line breaks: <br />

        $this->assertStringContainsString('&lt;script&gt;', $rendered, 'HTML tags should be escaped');
        $this->assertStringNotContainsString('<script>', $rendered, 'Raw HTML tags should NOT be present');

        // This assertion confirms we want newlines converted
        $this->assertStringContainsString('<br', $rendered, 'Newlines SHOULD be converted to <br>');
    }
}

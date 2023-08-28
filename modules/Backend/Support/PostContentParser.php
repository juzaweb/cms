<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Support;

use Juzaweb\Backend\Models\Post;

class PostContentParser
{
    protected array $noneReplaces = [];

    public static function make(Post $post): static
    {
        return new self($post);
    }

    public function __construct(protected Post $post)
    {
    }

    public function parse(): string
    {
        $content = $this->post->content ?? '';
        $domp = str_get_html($content);
        if ($domp) {
            foreach ($domp->find('img') as $e) {
                $content = str_replace(
                    $e->outertext(),
                    '<img src="'.upload_url($e->src).'" alt="'. addslashes($this->post->title) .'"
                    class="lazyload"
                    loading="lazy">',
                    $content
                );
            }

            $id = 1;
            foreach ($domp->find('a') as $e) {
                $this->noneReplaces[] = $e->outertext();
                $content = str_replace(
                    $e->outertext(),
                    "[none-{$id}][/none-{$id}]",
                    $content
                );

                $id ++;
            }
        }

        // Auto add tag link
        // $tags = $this->post->taxonomies->where('taxonomy', 'tags')->mapWithKeys(
        //     fn ($item) => [$item->getLink() => $item->name]
        // );
        //
        // foreach ($tags as $link => $tag) {
        /*    $pattern = "/<.*?>(*SKIP)(*FAIL)|". preg_quote(" {$tag} ") ."/ui";*/
        //     $content = preg_replace_callback(
        //         $pattern,
        //         function ($matches) use ($link) {
        //             return' <a href="'. $link .'">'. trim($matches[0]) .'</a> ';
        //         },
        //         $content
        //     );
        // }

        $id = 1;
        foreach ($this->noneReplaces as $replace) {
            $content = str_replace(
                "[none-{$id}][/none-{$id}]",
                $replace,
                $content
            );

            $id ++;
        }

        return $content;
    }
}
